<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;

class UpdateBalanceApiController extends Controller
{
    public function index(Request $request)
    {
        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'min:10|max:100',
            'id_telegram' => 'min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'score' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $score = $request->post('score');
        $wallet_address = $request->post('wallet_address');
        $id_telegram = $request->post('id_telegram');
        $account = [];

        if ($wallet_address || $id_telegram) {
            $redis = new RedisService();
            if($id_telegram) {
                $account = $redis->getData($id_telegram);
            }

            $max_coins = app('settings')->get('update_balance_max_coins');

            if ($account) {
                // get from Redis
                //log
                $startTime = microtime(true);

                $account = json_decode($account);

                $endTime = microtime(true);
                $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                Log::channel('update_balance_log')->debug("BOT — GET user from Redis exec time: {$executionTime} ms");
                //log
            } else {
                // get from DB
                //log
                $startTime = microtime(true);

                if ($wallet_address) {
                    $account = Account::where('wallet_address', $wallet_address)
                        ->with(['daily_quests', 'partners_quests'])
                        ->first();
                } elseif($id_telegram) {
                    $account = Account::where('id_telegram', $id_telegram)
                        ->with(['daily_quests', 'partners_quests'])
                        ->first();
                }

                $endTime = microtime(true);
                $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                Log::channel('update_balance_log')->debug("BOT — GET user from DB exec time: {$executionTime} ms");
                //log

                if ($account->id_telegram) {
                    $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
                }
            }

            if ($score > 0 && $score < $max_coins) {
                if ($account) {
                    if (is_null($account->active_at) || time() > $account->active_at) {
                        if (is_null($account->update_balance_at) || time() > $account->update_balance_at) {
                            DB::transaction(function () use ($request, $account, $score, $redis) {
                                $account->update_balance_at = strtotime('+' . app('settings')->get('update_balance_time') . ' second');
                                $account->notify_play = 0;
                                $balance = $account->wallet_balance + $score;
                                $energy = $account->energy;
                                $energy_scored = $account->energy + $score;

                                // go ot call down
                                if (($energy_scored) >= 1000) {
                                    $addHour = new \DateTime();
                                    $addHour->add(new \DateInterval('PT1H'));
                                    $balance = $account->wallet_balance + (1000 - $account->energy);
                                    $account->energy = 0;
                                    $account->active_at = $addHour->getTimestamp();
                                    $account->sessions = $account->sessions + 1;
                                } else {
                                    $account->energy += $score;
                                }

                                // daily quests
                                if(!is_null($account->wallet_address) && $account->daily_quests) {
                                    foreach ($account->daily_quests as $daily_quest) {
                                        if ($daily_quest->required_amount && !$daily_quest->status) {
                                            if ($energy_scored >= 1000) {
                                                $daily_quest->amount = $daily_quest->amount + (1000 - $energy);
                                            } else {
                                                $daily_quest->amount += $score;
                                            }

                                            if ($daily_quest->amount >= $daily_quest->required_amount && ($daily_quest->referrals >= $daily_quest->required_referrals || $daily_quest->required_referrals == 0)) {
                                                $daily_quest->amount = $daily_quest->required_amount;
                                                $daily_quest->status = 1;
                                                $daily_quest->wallet_balance_before = $balance;
                                                $daily_quest->wallet_balance_after = $balance + $daily_quest->reward;
                                                $balance += $daily_quest->reward;
                                            }

                                            if ($account instanceof Account) {
                                                // if account from DB
                                                //log
                                                $startTime = microtime(true);

                                                $daily_quest->save();

                                                $endTime = microtime(true);
                                                $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                                Log::channel('update_balance_log')->debug("BOT — Save daily to DB instance of Account exec time: {$executionTime} ms");
                                                //log
                                            } else {
                                                //log
                                                $startTime = microtime(true);

                                                // if account from Redis
                                                DB::table('accounts_daily_quests')
                                                    ->where('id', $daily_quest->id)
                                                    ->update([
                                                        'amount' => $daily_quest->amount,
                                                        'status' => $daily_quest->status,
                                                        'wallet_balance_before' => $daily_quest->wallet_balance_before,
                                                        'wallet_balance_after' => $daily_quest->wallet_balance_after,
                                                        'updated_at' => Carbon::now()
                                                    ]);

                                                $endTime = microtime(true);
                                                $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                                Log::channel('update_balance_log')->debug("BOT — Save daily to DB instance of Redis exec time: {$executionTime} ms");
                                                //log
                                            }
                                        }
                                    }
                                }

                                $account->wallet_balance = $balance;
                                $account->updated_at = Carbon::now();
                                
                                if ($account instanceof Account) {
                                    // if account from DB
                                    //log
                                    $startTime = microtime(true);

                                    $account->save();
                                    $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);

                                    $endTime = microtime(true);
                                    $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                    Log::channel('update_balance_log')->debug("BOT — Save account to DB/Redis instance of DB exec time: {$executionTime} ms");
                                    //log
                                } else {
                                    // if account from Redis
                                    //log
                                    $startTime = microtime(true);

                                    DB::table('accounts')
                                        ->where('id_telegram', $account->id_telegram)
                                        ->update([
                                            'wallet_balance' => $account->wallet_balance,
                                            'energy' => $account->energy,
                                            'sessions' => $account->sessions,
                                            'update_balance_at' => $account->update_balance_at,
                                            'notify_play' => $account->notify_play,
                                            'active_at' => $account->active_at,
                                            'updated_at' => $account->updated_at
                                        ]);

                                    $redis->updateIfNotSet($account->id_telegram, json_encode($account), $account->timezone);

                                    $endTime = microtime(true);
                                    $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                    Log::channel('update_balance_log')->debug("BOT — Save account to DB/Redis instance of Redis exec time: {$executionTime} ms");
                                    //log
                                }

                                if ($account->parent_id) {
                                    //log
                                    $startTime = microtime(true);

                                    $referral = Account::with(['daily_quests', 'partners_quests'])
                                        ->find($account->parent_id);

                                    $endTime = microtime(true);
                                    $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                    Log::channel('update_balance_log')->debug("BOT — Find account referral from DB exec time: {$executionTime} ms");
                                    //log

                                    if ($referral && $score > 0) {
                                        $referral_amount = round($score / ((int)app('settings')->get('referral_percent') ?? 1));
                                        $referral->wallet_balance += $referral_amount;
                                        $referral->referral_balance += $referral_amount;

                                        //log
                                        $startTime = microtime(true);

                                        $referral->save();

                                        $endTime = microtime(true);
                                        $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                        Log::channel('update_balance_log')->debug("BOT — Save account referral to DB exec time: {$executionTime} ms");
                                        //log

                                        if ($referral->id_telegram) {
                                            //log
                                            $startTime = microtime(true);
                                            $redis = new RedisService();
                                            $data = $redis->getData($referral->id_telegram);

                                            $endTime = microtime(true);
                                            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                            Log::channel('update_balance_log')->debug("BOT — Get account referral from Redis exec time: {$executionTime} ms");
                                            //log
                                            if ($data) {
                                                //log
                                                $startTime = microtime(true);

                                                $redis->updateIfNotSet($referral->id_telegram, $referral->toJson(), $referral->timezone);

                                                $endTime = microtime(true);
                                                $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                                                Log::channel('update_balance_log')->debug("BOT — Save account referral updates in Redis exec time: {$executionTime} ms");
                                                //log
                                            }
                                        }
                                    }
                                }
                            });

                            return response()->json([
                                $wallet_address ? 'wallet_address' : 'id_telegram' => $wallet_address ?? $id_telegram,
                                'wallet_balance' => $account->wallet_balance
                            ], 201);

                        } else {
                            Log::channel('update_balance_log')->debug("update balance time limit error");
                            return response()->json(['message' => 'update balance time limit'], 404);
                        }
                    } else {
                        return response()->json(['message' => 'Cat rest until: ' . date("d.m.Y H:i:s", $account->active_at)], 404);
                    }
                } else {
                    Log::channel('update_balance_log')->debug("account not found");
                    return response()->json(['message' => 'account not found'], 404);
                }
            } else {
                Log::channel('update_balance_log')->debug("score must be greater than 0");
                return response()->json(['message' => 'score must be greater than 0'], 404);
            }
        }
        Log::channel('update_balance_log')->debug("Invalid request");
        return response()->json(['message' => 'Invalid request'], 404);
    }

    public function test(Request $request)
    {
        echo 'test';
    }
}
