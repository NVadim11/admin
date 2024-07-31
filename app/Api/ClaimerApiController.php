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

class ClaimerApiController extends Controller
{
    public $verification_bot_token = '7426539518:AAE_mYyuaqQ2euVHk7eAWohVqrhKwLyPJ4I';
    public $tg_channel_id = -1002230268780;
    public $tg_chat_id = -1002216416628;

    public $claimer_bonus = 1;
    public $claimer_period = 10;

    public function index(Request $request)
    {
        $claimer_bonus = $this->claimer_bonus;
        $claimer_period = $this->claimer_period;

        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        /*
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'min:10|max:100',
            'id_telegram' => 'min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }
            */

        $wallet_address = $request->post('wallet_address');
        $id_telegram = $request->post('id_telegram');
        $account = [];

        if ($wallet_address || $id_telegram) {
            $redis = new RedisService();

            $max_coins = app('settings')->get('update_balance_max_coins');

            // Getting account from Redis
            if ($id_telegram && $account = $redis->getData($id_telegram)) {

                $account = json_decode($account);

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

            if ($account) {
                $currentTime = time();
                $claimerTime = (isset($account->claimer_timer)) ? $account->claimer_timer : 0;
                $claimer_bonus = ($claimerTime == 0) ? 3 : $claimer_bonus;

                if ($currentTime > $claimerTime) {
                    
                    $account->wallet_balance = $account->wallet_balance + $claimer_bonus;
                    $account->updated_at = Carbon::now();
                    $account->claimer_timer = $currentTime + $claimer_period;

                    // Savig account 
                    // -- if account from DB
                    if ($account instanceof Account) {
                        
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
                                'update_balance_at' => $account->update_balance_at,
                                'updated_at' => $account->updated_at,
                                'claimer_timer' => $account->claimer_timer
                            ]);

                        $redis->updateIfNotSet($account->id_telegram, json_encode($account), $account->timezone);

                        $endTime = microtime(true);
                        $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                        Log::channel('update_balance_log')->debug("BOT — Save account to DB/Redis instance of Redis exec time: {$executionTime} ms");
                        //log
                    }

                    return response()->json([
                        'message' => 'Claimed! New balacne: '.$account->wallet_balance, 
                        'success' => true,
                        'wallet_balance'=> $account->wallet_balance,
                        'claimer_bonus' => $this->claimer_bonus,
                        'claimer_timer'=>$account->claimer_timer], 200);

                } Log::channel('update_balance_log')->debug("Claimer timer for user in not ready");
                return response()->json(['message' => 'claimer not ready'], 404);
            }
            else {
                Log::channel('update_balance_log')->debug("account not found");
                return response()->json(['message' => 'account not found'], 404);
            }

        }
        Log::channel('update_balance_log')->debug("Invalid request");
        return response()->json(['message' => 'Invalid request'], 404);
    }

    private function check_tg_subscriber( $user_id, $channel_id )
    {
        //$user_id = "7172543732";
        //$channel_id = "-1002225952190"; 
        //$bot_token =  "7246664265:AAEKzuZz4nAkJDT5E2us3tMWoeRqS52EB_I";
        $bot_token = $this->verification_bot_token;
        $user_id = intval($user_id);
        $api_url = "https://api.telegram.org/bot$bot_token/getChatMember?chat_id=$channel_id&user_id=$user_id";
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $chat_member = curl_exec($ch);

        if (curl_errno($ch)) {
            echo("cURL error: " . curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        if ($chat_member === FALSE) {
            //echo("Failed to get chat member info from API: $api_url");
           return false;
        }

        //echo("Chat member API response: ");
        
        //var_dump($chat_member);
        $chat_member_data = json_decode($chat_member, true);

        if (isset($chat_member_data['result']['status']) 
        
            /*
            &&
            ($chat_member_data['result']['status'] == 'member' ||
                $chat_member_data['result']['status'] == 'administrator' ||
                $chat_member_data['result']['status'] == 'creator' ||
                $chat_member_data['result']['status'] == 'restricted'
                )
                */
                
                ) {
            return true;
            
        } else {
           // echo 'status unavaliable';
        }
        return false;
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

    public function check_task(Request $request)
    {
        if (!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 401);
        }

        /*
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'min:10|max:100',
            'id_telegram' => 'min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
            */
        $redis = new RedisService();
        $wallet_address = $request->post('wallet_address');
        $id_telegram = $request->post('id_telegram');
        $task_code = $request->post('code');
        $account = $this->getAccount($id_telegram, $wallet_address);

        if ($account && ($task_code == 'tg_channel' || $task_code == 'tg_chat' || $task_code == 'twitter'))
        {

            if ($task_code == 'tg_channel')
            {
                $check = $this->check_tg_subscriber($account->id_telegram, $this->tg_channel_id);
            } else if ($task_code == 'tg_chat')
            {
                $check = $this->check_tg_subscriber($account->id_telegram, $this->tg_chat_id);
            }
            else 
                $check = true;

            if ($check)
            {
                $account->$task_code = 1;
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
                            $task_code  => 1,
                        ]);
                    $redis->updateIfNotSet($account->id_telegram, json_encode($account), $account->timezone);
                }

                return response()->json(['message' => 'Task completed!', 'success'=>true], 200);
            }
            else return response()->json(['message' => 'Task was not completed'], 400);

        } else return response()->json(['message' => 'Invalid request'], 404);
    }


    public function test()
    {
        //$account = $this->getAccount('64288442', '61ebb74112ea5cd963800f90dd7f119b5aaa7e6681de59b091707f5a44b5170e');
        //var_dump($account);
        exit();
    }
}
