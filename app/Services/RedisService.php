<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisService
{
    private function isRedisConnected()
    {
        try {
            Redis::ping();
            return true;
        } catch (\Exception $e) {
            Log::channel('redis_log')->error('Redis connection failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getData($id)
    {
        if (!$this->isRedisConnected()) {
            return [];
        }

        $data = Redis::get($id);
        return $data !== null ? $data : [];
    }

    public function updateIfNotSetHourly($key, $value)
    {
        if (!$this->isRedisConnected()) {
            return;
        }

        $currentDateTime = Carbon::now();
        $nextHour = $currentDateTime->copy()->addHour();
        $diffTime = $currentDateTime->diffInSeconds($nextHour);

        // Проверяем, что время до следующего часа положительное
        if ($diffTime > 0) {
            Redis::transaction(function ($transaction) use ($key, $value, $diffTime) {
                $transaction->set($key, $value);
                // Устанавливаем время жизни ключа
                $transaction->expire($key, $diffTime);
            });
        } else {
            Log::channel('redis_log')->debug("Время вычислено неверно.");
            throw new \Exception('Время вычислено неверно.');
        }
    }

public function updateIfNotSet($key, $value, $timezone  = 'UTC')
{
    if (!$this->isRedisConnected()) {
        return;
    }

    // Установка временной зоны для Carbon
    Carbon::setLocale('en');
    $currentDateTime = Carbon::now($timezone);

    // Получаем конец текущего дня в указанном часовом поясе
    $endOfDay = $currentDateTime->copy()->endOfDay();

    // Переводим время до конца дня в секунды
    $timeUntilEndOfDay = $currentDateTime->diffInSeconds($endOfDay, false);

    // Проверяем, что время до конца дня положительное
    if ($timeUntilEndOfDay > 0) {
        Redis::transaction(function ($transaction) use ($key, $value, $timeUntilEndOfDay) {
            $transaction->set($key, $value);
            // Устанавливаем время жизни ключа
            $transaction->expire($key, $timeUntilEndOfDay);
        });
    } else {
        // Обработка ошибки: время жизни не может быть отрицательным или нулевым
        Log::channel('redis_log')->debug("Время до конца дня вычислено неверно для часового пояса $timezone.");
        throw new \Exception('Время до конца дня вычислено неверно для часового пояса ' . $timezone);
    }
}



    public function deleteIfExists($key)
    {
        if (!$this->isRedisConnected()) {
            return;
        }

        Redis::transaction(function ($transaction) use ($key) {
            if ($transaction->exists($key)) {
                $transaction->del($key);
            }
        });
    }

    public function logRedisMemoryUsage()
    {
        if (!$this->isRedisConnected()) {
            return;
        }

        $memoryInfo = Redis::info('memory');

        // Проверяем и извлекаем используемую память и максимальную память
        $usedMemory = isset($memoryInfo['used_memory']) ? $memoryInfo['used_memory'] : 'N/A'; // В байтах
        $maxMemory = isset($memoryInfo['maxmemory']) ? $memoryInfo['maxmemory'] : 'No limit set'; // В байтах

        // Если maxmemory не установлено, используем допустимое значение (например, без ограничений)
        if ($maxMemory === 'No limit set') {
            $remainingMemory = 'Memory limit not set';
        } elseif ($maxMemory === 'N/A') {
            $remainingMemory = 'Used memory not available';
        } else {
            $remainingMemory = $maxMemory - $usedMemory; // Рассчитываем оставшуюся память
        }

        Log::channel('redis_log')->debug("Used memory: {$usedMemory} bytes");
        Log::channel('redis_log')->debug("Max memory: {$maxMemory}");
        Log::channel('redis_log')->debug("Remaining memory: {$remainingMemory} bytes");

        return [
            'used_memory' => $usedMemory,
            'max_memory' => $maxMemory,
            'remaining_memory' => $remainingMemory
        ];
    }
}