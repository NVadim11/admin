<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Modules\DailyQuests\Entities\AccountDailyQuest;
use Modules\DailyQuests\Entities\DailyQuest;
use Modules\PartnersQuests\Entities\AccountPartnersQuest;
use Modules\PartnersQuests\Entities\PartnersQuest;

class TasksService
{
    public function makeTasks($account)
    {
        try {
            DB::beginTransaction();

            $daily_quests = DailyQuest::where('vis', 1)->pluck('id')->toArray();
            $partners_quests = PartnersQuest::where('vis', 1)->pluck('id')->toArray();

            // Daily quests
            if(!empty($account->daily_quests)) {
                if (is_array($account->daily_quests)) {
                    $existing_daily_quests = array_map(function($quest) {
                        return $quest->daily_quest_id;
                    }, $account->daily_quests);
                } else {
                    $existing_daily_quests = $account->daily_quests->pluck('daily_quest_id')->toArray();
                }

                $new_daily_quests = array_diff($daily_quests, $existing_daily_quests);
            } else {
                $new_daily_quests = $daily_quests;
            }

            foreach ($new_daily_quests as $new_daily_quest_id) {
                #todo check exists
                $daily_quest = DailyQuest::find($new_daily_quest_id);
                $account_daily_quest = new AccountDailyQuest();
                $account_daily_quest->account_id = $account->id;
                $account_daily_quest->daily_quest_id = $daily_quest->id;
                $account_daily_quest->required_amount = $daily_quest->required_amount;
                $account_daily_quest->required_referrals = $daily_quest->required_referrals;
                $account_daily_quest->reward = $daily_quest->reward;
                $account_daily_quest->save();
            }

            // Partners quests
            if(!empty($account->partners_quests)) {
                if (is_array($account->partners_quests)) {
                    $existing_partners_quests = array_map(function($quest) {
                        return $quest->partners_quest_id;
                    }, $account->partners_quests);
                } else {
                    $existing_partners_quests = $account->partners_quests->pluck('partners_quest_id')->toArray();
                }

                $new_partners_quests = array_diff($partners_quests, $existing_partners_quests);
            } else {
                $new_partners_quests = $partners_quests;
            }

            foreach ($new_partners_quests as $new_partners_quest_id) {
                $exists = AccountPartnersQuest::where('id_telegram', $account->id_telegram)
                    ->where('partners_quest_id', $new_partners_quest_id)
                    ->exists();

                if (!$exists) {
                    $partners_quest = PartnersQuest::find($new_partners_quest_id);
                    $account_partners_quest = new AccountPartnersQuest();
                    $account_partners_quest->id_telegram = $account->id_telegram;
                    $account_partners_quest->partners_quest_id = $partners_quest->id;
                    $account_partners_quest->reward = $partners_quest->reward;
                    $account_partners_quest->save();
                }
            }


            if ($account->partners_quests) {
                $quests = [
                    'tg_channel' => 1,
                    'tg_chat' => 2,
                    'twitter' => 3,
                    'is_wallet_connected' => 4,
                    'referrals_count' => 5
                ];

                foreach ($quests as $field => $quest_id) {
                    if ($account->$field) {
                        DB::table('accounts_partners_quests')
                            ->where('partners_quest_id', $quest_id)
                            ->update(['status' => 1]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }

        return true;
    }
}
