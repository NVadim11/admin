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
use Modules\ProjectVote\Models\ProjectVote;
use Modules\Projects\Entities\Project;

class VotesApiController extends Controller
{
    public function index(Request $request)
    {
        /*
        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }
        */

        $validator = Validator::make($request->all(), [
            //'token' => 'required',
            'wallet_address' => 'min:10|max:100',
            'id_telegram' => 'min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'project_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $wallet_address = $request->post('wallet_address');
        $id_telegram = $request->post('id_telegram');
        $projectId = $request->post('project_id');
        $account = $this->getAccount($id_telegram, $wallet_address);
        $client_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $client_ip = $this->getClientIpInfo();
        $redis = new RedisService();

        if ($account)
        {
            $project = Project::find($projectId);
            if ($project) { 
                if ($account->wallet_balance > 0)
                {
                    
                    $project_vote = ProjectVote::create([
                        'project_id' => $project->id,
                        'client_id' => $account->id_telegram,
                        'client_ip' => $client_ip,
                        'client_agent' => $client_agent
                        //'user_id' => $account->id_telegram
                        ]);
                    
                    if ($project_vote) {
                        
                        $project->vote_24 = ProjectVote::where([
                            'project_id' => $project->id,
                        ])->where('created_at', '>=', Carbon::now()->subHours(24))->count();
                        $project->vote_total = $project->vote_total + 1;
                        $project->save();

                        $account->wallet_balance -= 1;
                        $account->update_balance_at = Carbon::now();

                        // Savig account 
                        // -- if account from DB
                        if ($account instanceof Account) {
                            $account->save();
                            $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
                        }
                        // if account from Redis 
                        else {
                            DB::table('accounts')
                                ->where('id_telegram', $account->id_telegram)
                                ->update([
                                    "wallet_balance"  => $account->wallet_balance,
                                    'update_balance_at' => $account->update_balance_at,
                                ]);
                            $redis->updateIfNotSet($account->id_telegram, json_encode($account), $account->timezone);
                        }

                        return response()->json(['message' => 'ok', 'success' => true, 'votes_total'=>$project->vote_total], 200);

                    } else return response()->json(['message' => 'Your vote was not counted. Please try again.'], 400);
                }
                else return response()->json(['message' => 'Not enough $hit points in the account'], 404);

            } else return response()->json(['message' => 'Not found'], 404);
        }
        else return response()->json(['message' => 'Not found'], 404);

    }

    private function getAccount($id_telegram, $wallet_address)
    {
        $account = [];
        $redis = new RedisService();
        // Getting account from Redis
        if ($id_telegram && $account = $redis->getData($id_telegram)) {

            $account = json_decode($account);

        } 
        // Getting from DB
        else {
            if ($wallet_address) {
                $account = Account::where('wallet_address', $wallet_address)
                    ->with(['daily_quests', 'partners_quests'])
                    ->first();
            } elseif ($id_telegram) {
                $account = Account::where('id_telegram', $id_telegram)
                    ->with(['daily_quests', 'partners_quests'])
                    ->first();
            }
        }

        return $account;
    }

    private function getClientIpInfo()
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Перевірка, чи використовує клієнт прокси-сервер
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }

        return $ip_address;
    }
}