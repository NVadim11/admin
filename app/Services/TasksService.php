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
            $existing_daily_quests = $account->daily_quests->pluck('daily_quest_id')->toArray();
            $new_daily_quests = array_diff($daily_quests, $existing_daily_quests);

            foreach ($new_daily_quests as $new_daily_quest_id) {
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
            $existing_partners_quests = $account->partners_quests->pluck('partners_quest_id')->toArray();
            $new_partners_quests = array_diff($partners_quests, $existing_partners_quests);

            foreach ($new_partners_quests as $new_partners_quest_id) {
                $partners_quest = PartnersQuest::find($new_partners_quest_id);
                $account_partners_quest = new AccountPartnersQuest();
                $account_partners_quest->account_id = $account->id;
                $account_partners_quest->partners_quest_id = $partners_quest->id;
                $account_partners_quest->reward = $partners_quest->reward;
                $account_partners_quest->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }

        return true;
    }
}
