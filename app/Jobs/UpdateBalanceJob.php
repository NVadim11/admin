<?php

namespace App\Jobs;

use Modules\Accounts\Entities\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class UpdateBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $request = $this->requestData;
            $score = $request['score'];
            $wallet_address = $request['wallet_address'] ?? '';
            $id_telegram = $request['id_telegram'] ?? '';

            if ($wallet_address || $id_telegram) {
                $max_coins = app('settings')->get('update_balance_max_coins');
                if ($score > 0 && $score < $max_coins) {
                    $account = Account::where($wallet_address ? 'wallet_address' : 'id_telegram', $wallet_address ?? $id_telegram)->first();

                    if ($account) {
                        if (time() > $account->active_at) {
                            if (time() > $account->update_balance_at) {
                                $account->update_balance_at = strtotime('+' . app('settings')->get('update_balance_time') . ' second');
                                $account->notify_play = 0;
                                $balance = $account->wallet_balance + $score;

                                if (($account->energy + $score) >= 1000) {
                                    $addHour = new \DateTime();
                                    $addHour->add(new \DateInterval('PT1H'));
                                    $balance = $account->wallet_balance + (1000 - $account->energy);
                                    $account->energy = 0;
                                    $account->active_at = $addHour->getTimestamp();
                                } else {
                                    $account->energy += $score;
                                }

                                foreach ($account->daily_quests as $daily_quest) {
                                    if ($daily_quest->required_amount && !$daily_quest->status) {
                                        $daily_quest->amount += $score;
                                        if ($daily_quest->amount >= $daily_quest->required_amount && ($daily_quest->referrals >= $daily_quest->required_referrals || $daily_quest->required_referrals == 0)) {
                                            $daily_quest->amount = $daily_quest->required_amount;
                                            $daily_quest->status = 1;
                                            $daily_quest->wallet_balance_before = $balance;
                                            $daily_quest->wallet_balance_after = $balance + $daily_quest->reward;
                                            $balance += $daily_quest->reward;
                                        }
                                        $daily_quest->save();
                                    }
                                }

                                $account->wallet_balance = $balance;
                                $account->save();

                                if ($account->parent_id) {
                                    $referral = Account::find($account->parent_id);
                                    if ($referral && $score > 0) {
                                        $referral_amount = round($score / ((int)app('settings')->get('referral_percent') ?? 1));
                                        $referral->wallet_balance += $referral_amount;
                                        $referral->referral_balance += $referral_amount;
                                        $referral->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        });
    }
}