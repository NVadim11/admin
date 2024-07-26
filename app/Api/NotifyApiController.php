<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Modules\Accounts\Entities\Account;

class NotifyApiController extends Controller
{
    public function bot_notify_play()
    {
        if (app('settings')->get('notify_to_play') &&
            app('settings')->get('notify_message') &&
            app('settings')->get('notify_qty')) {

            $decHour = Carbon::now()->timestamp;
            $accounts = Account::whereNotNull('active_at')
                ->whereNotNull('id_telegram')
                ->where('active_at', '<', $decHour)
                ->where('energy', 0)
                ->where('notify_play', 0)
                ->orderBy('active_at', 'asc')
                ->limit(app('settings')->get('notify_qty'))
                ->get();

            Account::whereIn('id', $accounts->pluck('id')->toArray())->update(['notify_play' => 1]);

            $delay = 0;
            foreach ($accounts as $account) {
                Queue::later(now()->addSeconds($delay), (new SendNotificationJob($account))->onQueue('notify'));
//                $delay += 2;
            }
        }
    }
}
