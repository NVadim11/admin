<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('liders', [\App\Api\LiderboardApiController::class, 'liders']);
Route::get('liderbord/{user}', [\App\Api\LiderboardApiController::class, 'index']);
Route::get('topvoters/{user}', [\App\Api\LiderboardApiController::class, 'topvoters']);
Route::get('topreferrals/{user}', [\App\Api\LiderboardApiController::class, 'topreferrals']);

Route::get('referrals/{user}', [\App\Api\ReferralApiController::class, 'index']);

Route::post('users', [\App\Api\RegisterApiController::class, 'index']);
Route::post('pass-task', [\App\Api\ApiController::class, 'pass_task']);
Route::post('update-balance', [\App\Api\UpdateBalanceApiController::class, 'index']);
Route::post('set-activity', [\App\Api\ApiController::class, 'set_activity_time']);
Route::post('update-wallet-address', [\App\Api\ApiController::class, 'update_wallet_address']);
Route::post('clear-wallet-address', [\App\Api\ApiController::class, 'clear_wallet_address']);
Route::post('set-wallet-address', [\App\Api\ApiController::class, 'set_wallet_address']);
Route::get('users/{user}', [\App\Api\ApiController::class, 'show']);
Route::get('telegram-id/{id}', [\App\Api\ApiController::class, 'show_by_telegram_id']);
Route::get('make-tasks/{id}', [\App\Api\ApiController::class, 'make_tasks']);
Route::get('generate-referral-code/{user}', [\App\Api\ApiController::class, 'generate_referral_code']);
Route::get('check-referral-code/{code}', [\App\Api\ApiController::class, 'check_referral_code']);

Route::get('bot-data', [\App\Api\DataApiController::class, 'bot_data']);
Route::get('redis-info', [\App\Api\DataApiController::class, 'redis_info']);
Route::get('game-daily-statistic', [\App\Api\DataApiController::class, 'game_daily_statistic']);

Route::get('notify-play', [\App\Api\NotifyApiController::class, 'bot_notify_play']);

Route::get('daily-quests', [\App\Api\DailyQuestsApiController::class, 'daily_quests']);
Route::post('pass-daily-quest', [\App\Api\DailyQuestsApiController::class, 'pass_daily_quest']);

Route::post('pass-partners-quest', [\App\Api\PartnersQuestsApiController::class, 'pass_partners_quest']);
Route::post('claimer', [\App\Api\ClaimerApiController::class, 'index']);
Route::post('check-task', [\App\Api\ClaimerApiController::class, 'check_task']);
Route::get('test', [\App\Api\ClaimerApiController::class, 'test']);

Route::get('projects', [\App\Api\ProjectsApiController::class, 'index']);
Route::get('top-projects', [\App\Api\ProjectsApiController::class, 'top_projects']);
Route::get('top-daily-projects', [\App\Api\ProjectsApiController::class, 'top_daily_projects']);
Route::get('top-new-projects', [\App\Api\ProjectsApiController::class, 'top_new_projects']);
Route::post('pass-project-task', [\App\Api\ProjectsApiController::class, 'pass_project_task']);

Route::post('votes', [\App\Api\VotesApiController::class, 'index']);