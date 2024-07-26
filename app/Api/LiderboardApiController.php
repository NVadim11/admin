<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;

class LiderboardApiController extends Controller
{
    /*
        GET /api/liderbord/{iserId}
    */

    public function index($userId)
    {
        $validator = Validator::make(['id' => $userId], [
            'id' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $redis = new RedisService();
        $res = $redis->getData('liderboard_by_user_' . $userId);

        if(!$res) {
            $res = [];
            $current = Account::where('id', $userId)->first();
            if(!$current) {
                $current = Account::where('id_telegram', $userId)->first();
            }

            if ($current) {
                $position = DB::select("SELECT id, username, wallet_balance, ( SELECT COUNT(*) + 1 FROM accounts AS a2 WHERE a2.wallet_balance > a1.wallet_balance ) AS 'rank' FROM accounts AS a1 WHERE id = " . $current->id);
                $accounts = Account::select('id', 'username', 'wallet_address', 'id_telegram', 'wallet_balance')
                    ->orderByRaw("wallet_balance DESC")
                    ->whereRaw('wallet_balance > 0')
                    ->limit(10)
                    ->get();

                if ($accounts) {
                    foreach ($accounts as $pos => $account) {
                        $cur_pos = $pos + 1;
                        if ($cur_pos == $position[0]->rank && $position[0]->rank <= 10) {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => true,
                                'id_telegram' => $account->id_telegram,
                                'wallet_address' => $account->wallet_address,
                                'wallet_balance' => $account->wallet_balance,
                                'referral_balance' => $account->referral_balance
                            );
                        } else {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => false,
                                'id_telegram' => $account->id_telegram,
                                'wallet_address' => $account->wallet_address,
                                'wallet_balance' => $account->wallet_balance,
                                'referral_balance' => $account->referral_balance
                            );
                        }
                    }

                    if ($position && $position[0]->rank > 10) {
                        $res[] = array(
                            'id' => $current->id,
                            'username' => $current->username,
                            'position' => $position[0]->rank,
                            'current' => true,
                            'id_telegram' => $current->id_telegram,
                            'wallet_address' => $current->wallet_address,
                            'wallet_balance' => $current->wallet_balance,
                            'referral_balance' => $current->referral_balance
                        );
                    }
                }

                $redis->updateIfNotSetHourly('liderboard_by_user_' . $current->id, json_encode($res));

                return response()->json($res, 201);
            }
        } else {

            return response()->json(json_decode($res, true), 201);
        }

        return response()->json(404);
    }

    /*
         GET /api/liders
    */

    public function liders()
    {
        $accounts = Account::select('wallet_address', 'wallet_balance')
            ->orderByDesc('wallet_balance')
            ->where('wallet_balance', '>', 0)
            ->limit(5)
            ->get();

        if($accounts->isEmpty()) {
            return response()->json(['message' => 'No accounts found'], 404);
        }

        $res = $accounts->map(function ($account, $index) {
            return [
                'position' => $index + 1,
                'current' => false,
                'wallet_address' => $account->wallet_address,
                'wallet_balance' => $account->wallet_balance,
                'referral_balance' => $account->referral_balance
            ];
        });

        return response()->json($res, 201);
    }
}