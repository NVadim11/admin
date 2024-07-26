<?php

namespace App\Api;

use App\Entities\GameDailyStatistic;
use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataApiController extends Controller
{
    protected function getSettings(array $keys)
    {
        return collect($keys)->mapWithKeys(function ($key) {
            return [$key => app('settings')->get($key)];
        });
    }

    public function redis_info()
    {
        $redis = new RedisService();
        return $redis->logRedisMemoryUsage();
    }

    public function bot_data()
    {
        //log
        $startTime = microtime(true);

        $redis = new RedisService();
        $data = $redis->getData('bot_data');

        if (!$data) {
            $settings = $this->getSettings([
                'intro',
                'rules',
                'referral',
                'stay_tuned'
            ]);

            $data = [
                'info' => [
                    'intro' => $settings['intro'],
                    'rules' => $settings['rules'],
                    'referral' => $settings['referral'],
                    'stay_tuned' => $settings['stay_tuned'],
                ]
            ];

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
            Log::channel('settings_log')->debug("Bot settings from DB exec time: {$executionTime} ms");
            //log

            $redis->updateIfNotSet('bot_data', json_encode($data));
        } else {
            $data = json_decode($data, true);

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
            Log::channel('settings_log')->debug("Bot settings from Redis exec time: {$executionTime} ms");
            //log
        }

        return response()->json($data, 201);
    }

    public function game_daily_statistic()
    {
        $redis = new RedisService();
        $cacheKey = 'game_daily_statistic';

        $today = Carbon::today();
        $startOfDay = $today->copy()->startOfDay();
        $endOfDay = $today->copy()->endOfDay();
        $startOfDayTime = $startOfDay->timestamp;
        $endOfDayTime = $endOfDay->timestamp;

        $statistics = DB::table('accounts')
            ->selectRaw("
            SUM(CASE WHEN id_telegram IS NOT NULL AND created_at BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?) THEN 1 ELSE 0 END) AS new_players_bot,
            SUM(CASE WHEN id_telegram IS NULL AND created_at BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?) THEN 1 ELSE 0 END) AS new_players_web,
            SUM(CASE WHEN id_telegram IS NOT NULL AND update_balance_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS playing_from_bot,
            SUM(CASE WHEN id_telegram IS NULL AND update_balance_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS playing_from_web,
            SUM(CASE WHEN parent_id > 0 AND created_at BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?) THEN 1 ELSE 0 END) AS new_referrals
        ", [
                $startOfDayTime, $endOfDayTime,
                $startOfDayTime, $endOfDayTime,
                $startOfDayTime, $endOfDayTime,
                $startOfDayTime, $endOfDayTime,
                $startOfDayTime, $endOfDayTime
            ])
            ->first();

        $data = new GameDailyStatistic();
        $data->new_players_bot = $statistics->new_players_bot;
        $data->new_players_web = $statistics->new_players_web;
        $data->playing_from_bot = $statistics->playing_from_bot;
        $data->playing_from_web = $statistics->playing_from_web;
        $data->new_referrals = $statistics->new_referrals;
        $data->save();

        $dataCollection = GameDailyStatistic::orderBy('created_at', 'ASC')->get();
        $redis->updateIfNotSet($cacheKey, $dataCollection->toJson());

        return response()->json($dataCollection, 201);
    }
}