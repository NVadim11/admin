<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;
use Modules\ReferralTransactions\Entities\ReferralTransaction;

class ReferralApiController extends Controller
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
        $res = $redis->getData('referrals_by_user_' . $userId);

        if(!$res) {
            $res = [];
            $current = Account::where('id', $userId)->first();
            if(!$current) {
                $current = Account::where('id_telegram', $userId)->first();
            }

            if ($current) {
                $levels = ReferralTransaction::where('vis', 1)->get();
                foreach($levels as $level) {
                    $res[] = array(
                        'id' => $level->id,
                        'name' => $level->name,
                        'name_ru' => $level->name_ru,
                        'required_referrals' => $level->required_referrals,
                        'reward' => $level->reward,
                        'current' => (!empty($current->referral_template) && $current->referral_template->referral_transaction_id == $level->id) ? true : false
                    );
                }

                $redis->updateIfNotSetHourly('referrals_by_user_' . $current->id, json_encode($res));

                return response()->json($res, 201);
            }
        } else {

            return response()->json(json_decode($res, true), 201);
        }

        return response()->json(404);
    }
}