<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;
use Modules\ProjectVote\Models\ProjectVote;

class LiderboardApiController extends Controller
{
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
                $position = DB::select("SELECT id, id_telegram, username, wallet_balance, ( SELECT COUNT(*) + 1 FROM accounts AS a2 WHERE a2.wallet_balance > a1.wallet_balance and a2.vis = 1 ) AS 'rank' FROM accounts AS a1 WHERE id = " . $current->id);
                $accounts = Account::select('id', 'username', 'wallet_address', 'id_telegram', 'wallet_balance')
                    ->where('wallet_balance', '>', 0)
                    ->where('vis', 1)
                    ->orderByRaw("wallet_balance DESC")
                    ->limit(100)
                    ->get();

                if ($accounts) {
                    foreach ($accounts as $pos => $account) {
                        $cur_pos = $pos + 1;
                        if ($position && $cur_pos == $position[0]->rank && $position[0]->rank <= 100) {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => true,
                                'id_telegram' => $account->id_telegram,
                                'wallet_balance' => $account->wallet_balance,
                            );
                        } else {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => false,
                                'id_telegram' => $account->id_telegram,
                                'wallet_balance' => $account->wallet_balance,
                            );
                        }
                    }

                    if ($position && $position[0]->rank > 100) {
                        $res[] = array(
                            'id' => $current->id,
                            'username' => $current->username,
                            'position' => $position[0]->rank,
                            'current' => true,
                            'id_telegram' => $current->id_telegram,
                            'wallet_balance' => $current->wallet_balance,
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

    public function liders()
    {
        $accounts = Account::select('wallet_address', 'wallet_balance')
            ->orderByDesc('wallet_balance')
            ->where('wallet_balance', '>', 0)
            ->where('vis', 1)
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

    public function topvoters($userId)
    {
        $validator = Validator::make(['id' => $userId], [
            'id' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $redis = new RedisService();
        $res = $redis->getData('topvoters_by_user_' . $userId);

        if(!$res) {
            $res = [];
            $current = Account::where('id', $userId)->first();
            if(!$current) {
                $current = Account::where('id_telegram', $userId)->first();
            }

            if ($current) {
                $position = DB::select("SELECT client_id, 
	                (SELECT username FROM accounts WHERE id_telegram = VotesSummary.client_id) AS username, total_votes,
	                    (SELECT COUNT(*) + 1
	                        FROM (SELECT COUNT(id) AS total_votes FROM project_votes GROUP BY client_id) AS subquery
	                        WHERE subquery.total_votes > VotesSummary.total_votes) AS `rank`
                            FROM (SELECT client_id, COUNT(id) AS total_votes FROM project_votes GROUP BY client_id) AS VotesSummary
                        WHERE 
                            client_id = " .$userId . "
                        ORDER BY `rank` ASC LIMIT 1");


                $accounts = ProjectVote::select('project_votes.client_id')
                    ->selectRaw('accounts.username')
                    ->selectRaw('COUNT(project_votes.id) AS total_votes')
                    ->join('accounts', 'accounts.id_telegram', '=', 'project_votes.client_id')
                    ->where('accounts.vis', 1)
                    ->groupBy('project_votes.client_id', 'accounts.username')
                    ->orderBy('total_votes', 'desc')
                    ->limit(100)
                    ->get();


                if ($accounts) {
                    foreach ($accounts as $pos => $account) {
                        $cur_pos = $pos + 1;
                        if ($position && $cur_pos == $position[0]->rank && $position[0]->rank <= 100) {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => true,
                                'id_telegram' => $account->client_id,
                                'total_votes' => $account->total_votes,
                            );
                        } else {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => false,
                                'id_telegram' => $account->client_id,
                                'total_votes' => $account->total_votes,
                            );
                        }
                    }

                    if ($position && $position[0]->rank > 100) {
                        $res[] = array(
                            'id' => $current->id,
                            'username' => $current->username,
                            'position' => $position->rank,
                            'current' => true,
                            'id_telegram' => $current->client_id,
                            'total_votes' => $current->total_votes,
                        );
                    }
                }

                $redis->updateIfNotSetHourly('topvoters_by_user_' . $current->id, json_encode($res));

                return response()->json($res, 201);
            }
        } else {

            return response()->json(json_decode($res, true), 201);
        }

        return response()->json(404);
    }

    public function topreferrals($userId)
    {
        $validator = Validator::make(['id' => $userId], [
            'id' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $redis = new RedisService();
        $res = $redis->getData('topreferrals_by_user_' . $userId);

        if(!$res) {
            $res = [];
            $current = Account::where('id', $userId)->first();
            if(!$current) {
                $current = Account::where('id_telegram', $userId)->first();
            }

            if ($current) {
                $position = DB::select("SELECT id, username, referrals_count, ( SELECT COUNT(*) + 1 FROM accounts AS a2 WHERE a2.referrals_count > a1.referrals_count) AS 'rank' FROM accounts AS a1 WHERE id = " . $current->id);
                $accounts = Account::select('id', 'username', 'wallet_address', 'id_telegram', 'referrals_count')
                    ->orderByRaw("referrals_count DESC")
                    ->whereRaw('referrals_count > 0 and vis = 1')
                    ->limit(100)
                    ->get();

                if ($accounts) {
                    foreach ($accounts as $pos => $account) {
                        $cur_pos = $pos + 1;
                        if ($cur_pos == $position[0]->rank && $position[0]->rank <= 100) {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => true,
                                'id_telegram' => $account->id_telegram,
                                'referrals_count' => $account->referrals_count,
                            );
                        } else {
                            $res[] = array(
                                'id' => $account->id,
                                'username' => $account->username,
                                'position' => $cur_pos,
                                'current' => false,
                                'id_telegram' => $account->id_telegram,
                                'referrals_count' => $account->referrals_count,
                            );
                        }
                    }

                    if ($position && $position[0]->rank > 100) {
                        $res[] = array(
                            'id' => $current->id,
                            'username' => $current->username,
                            'position' => $position->rank,
                            'current' => true,
                            'id_telegram' => $current->id_telegram,
                            'referrals_count' => $current->referrals_count,
                        );
                    }
                }

                $redis->updateIfNotSetHourly('topreferrals_by_user_' . $current->id, json_encode($res));

                return response()->json($res, 201);
            }
        } else {

            return response()->json(json_decode($res, true), 201);
        }

        return response()->json(404);
    }
}