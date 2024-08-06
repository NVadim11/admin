<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;
use Modules\DailyQuests\Entities\AccountDailyQuest;

class DailyQuestsApiController extends Controller
{
    /*
        POST /api/pass-daily-quest
    */

    public function pass_daily_quest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'user_id' => 'required|regex:/^[0-9]+$/u',
            'daily_quest_id' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!$this->isValidToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $dailyQuestId = $request->post('daily_quest_id');
        $userId = $request->post('user_id');

        $dailyQuest = AccountDailyQuest::with('account')
            ->where('id', $dailyQuestId)
            ->first();

        if (!$dailyQuest || $dailyQuest->status || $dailyQuest->required_amount || $dailyQuest->required_referrals) {
            return response()->json(['message' => 'daily quest not found'], 404);
        }

        $account = $dailyQuest->account;
        if (!$account || $account->id != $userId) {
            return response()->json(['message' => 'user not found'], 404);
        }

        DB::transaction(function () use ($dailyQuest, $account) {
            $dailyQuest->wallet_balance_before = $account->wallet_balance;
            $dailyQuest->wallet_balance_after = $account->wallet_balance + $dailyQuest->reward;
            $dailyQuest->status = 1;

            $dailyQuest->save();

            $account->wallet_balance += $dailyQuest->reward;
            $account->save();
        });

        $account = Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])->find($userId);

        if($account->id_telegram) {
            $redis = new RedisService();
            $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
        }

        return response()->json($account, 201);
    }

    private function isValidToken($token)
    {
        return checkToken($token);
    }

    public static function passReferralTask($referral)
    {
        $balance = $referral->wallet_balance;

        if ($referral->daily_quests->isEmpty()) {
            return true;
        }

        DB::transaction(function () use ($referral, &$balance) {
            foreach ($referral->daily_quests as $daily_quest) {
                if ($daily_quest->required_referrals && !$daily_quest->status) {
                    $daily_quest->referrals += 1;

                    if ($daily_quest->referrals >= $daily_quest->required_referrals &&
                        ($daily_quest->amount >= $daily_quest->required_amount || $daily_quest->required_amount == 0)
                    ) {
                        $daily_quest->referrals = $daily_quest->required_referrals;
                        $daily_quest->status = 1;
                        $daily_quest->wallet_balance_before = $balance;
                        $daily_quest->wallet_balance_after = $balance + $daily_quest->reward;
                        $balance += $daily_quest->reward;
                    }

                    $daily_quest->save();
                }
            }

            $referral->wallet_balance = $balance;
            $referral->save();

            if($referral->id_telegram) {
                $redis = new RedisService();
                $redis->updateIfNotSet($referral->id_telegram, $referral->toJson(), $referral->timezone);
            }
        });

        return true;
    }
}