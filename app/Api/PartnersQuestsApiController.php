<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;
use Modules\PartnersQuests\Entities\AccountPartnersQuest;
use Modules\PartnersQuests\Entities\PartnersQuest;

class PartnersQuestsApiController extends Controller
{

    public function index()
    {
        $redis = new RedisService();
//        $res = $redis->getData('partners_quests');
        if(!$res) {
            $res = PartnersQuest::where('vis', 1)->orderBy('pos', 'ASC')->get();
            if ($res) {
//                $redis->updateIfNotSet('partners_quests', json_encode($res));
                return response()->json($res, 201);
            }
        } else {
            return response()->json(json_decode($res, true), 201);
        }

        return response()->json(404);
    }

    public function pass_partners_quest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'user_id' => 'required|regex:/^[0-9]+$/u',
            'partners_quest_id' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!$this->isTokenValid($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $partnersQuest = AccountPartnersQuest::find($request->post('partners_quest_id'));
        if (!$partnersQuest || !$partnersQuest->partners_quest || $partnersQuest->status) {
            return response()->json(['message' => 'partners quest not found'], 404);
        }

        $account = Account::find($request->post('user_id'), ['id', 'wallet_balance']);
        if (!$account) {
            return response()->json(['message' => 'user not found'], 404);
        }

        DB::transaction(function () use ($partnersQuest, $account) {
            $partnersQuest->wallet_balance_before = $account->wallet_balance;
            $partnersQuest->wallet_balance_after = $account->wallet_balance + $partnersQuest->reward;
            $partnersQuest->status = 1;

            $partnersQuest->save();

            $account->wallet_balance += $partnersQuest->reward;
            $account->save();
        });

        $updatedAccount = Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])->find($request->post('user_id'));

        if($updatedAccount->id_telegram) {
            $redis = new RedisService();
            $redis->updateIfNotSet($updatedAccount->id_telegram, $updatedAccount->toJson(), $updatedAccount->timezone);
        }

        return response()->json($updatedAccount, 201);
    }

    private function isTokenValid($token)
    {
        return checkToken($token);
    }
}