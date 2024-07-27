<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Accounts\Entities\Account;
use Modules\ReferralTransactions\Entities\AccountReferralTransaction;
use Modules\ReferralTransactions\Entities\ReferralTransaction;

class ReferralsService
{
    public function makeReferralLevel($referral)
    {
        $account = Account::find($referral->parent_id);
        if (!$account) {
            return response()->json(['message' => 'user not found'], 404);
        }

        if($account->referrals_count) {
            $level = ReferralTransaction::where('required_referrals', '<=', $account->referrals_count)
                ->where('vis', 1)
                ->orderBy('required_referrals', 'DESC')
                ->first();

            if ($level) {
                DB::transaction(function () use ($account, $level) {
                    $existingTemplate = $account->referral_template;
                    if ($existingTemplate) {
                        if ($existingTemplate->referral_transaction_id != $level->id) {
                            $existingTemplate->delete();
                        } else {
                            return;
                        }
                    }

                    // Создаем объект Carbon для текущего времени в временной зоне аккаунта
                    $timezone = $account->timezone ?: 'UTC';
                    $chargeAt = Carbon::now($timezone)->addHours(24);

                    $account_transaction = new AccountReferralTransaction();
                    $account_transaction->account_id = $account->id;
                    $account_transaction->referral_transaction_id = $level->id;
                    $account_transaction->referrals = $account->referrals_count;
                    $account_transaction->required_referrals = $level->required_referrals;
                    $account_transaction->reward = $level->reward;
                    $account_transaction->charge_at = $chargeAt->setTimezone('Europe/Kiev');
                    $account_transaction->save();
                });
            }
        }

        return true;
    }
}
