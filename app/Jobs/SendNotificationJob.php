<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Modules\Accounts\Entities\Account;

class SendNotificationJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function handle()
    {
        $message = app('settings')->get('notify_message');
        $photo = app('settings')->get('notify_image');
        $token = '6396746497:AAEPBTUxHgKLSQ6ZPp34CLw1gT9X0jy9Q5o';
        $chatId = $this->account->id_telegram;

        if ($chatId) {
            $client = new Client();
            try {
                $response = null;
                if ($photo) {
                    $response = $client->post("https://api.telegram.org/bot{$token}/sendPhoto", [
                        'json' => [
                            'chat_id' => $chatId,
                            'caption' => $message,
                            'photo' => 'https://aws.tomocat.com/uploads/' . $photo,
                            'reply_markup' => json_encode([
                                'inline_keyboard' => [
                                    [
                                        [
                                            'text' => 'Play now',
                                            'web_app' => [
                                                'url' => 'https://bot.play.tomocat.com/'
                                            ]
                                        ]
                                    ]
                                ]
                            ])
                        ]
                    ]);
                } else {
                    $response = $client->post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'json' => [
                            'chat_id' => $chatId,
                            'text' => $message,
                            'reply_markup' => json_encode([
                                'inline_keyboard' => [
                                    [
                                        [
                                            'text' => 'Play now',
                                            'web_app' => [
                                                'url' => 'https://bot.play.tomocat.com/'
                                            ]
                                        ]
                                    ]
                                ]
                            ])
                        ]
                    ]);
                }

                // Проверка успешного ответа
                if ($response && $response->getStatusCode() == 200) {
                    $body = json_decode($response->getBody(), true);
                    if (!$body['ok']) {
                        Log::error("Failed to send notification to {$chatId}: " . $body['description']);
                    }
                } else {
                    Log::error("Failed to send notification to {$chatId}: HTTP status " . ($response ? $response->getStatusCode() : 'No response'));
                }
            } catch (\Exception $e) {
                $response = $e->getResponse();
                if ($response) {
                    $statusCode = $response->getStatusCode();
                    $body = json_decode($response->getBody(), true);
                    if ($statusCode == 403 && isset($body['description']) && $body['description'] == 'Forbidden: bot was blocked by the user') {
                        Log::warning("Notification not sent to {$chatId}: Bot was blocked by the user");
                    } else {
                        Log::error("Failed to send notification to {$chatId}: " . $e->getMessage());
                    }
                } else {
                    Log::error("Failed to send notification to {$chatId}: " . $e->getMessage());
                }
            }
        }
    }
}
