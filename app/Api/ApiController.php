<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use App\Services\TasksService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Accounts\Entities\Account;
use Modules\DailyQuests\Entities\DailyQuest;
use Modules\PartnersQuests\Entities\PartnersQuest;

class ApiController extends Controller
{
    /*
         GET /api/users/{wallet_address}
    */

    public function show($wallet_address)
    {
        $validator = Validator::make(['wallet_address' => $wallet_address], [
            'wallet_address' => 'required|min:10|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        try {
            DB::beginTransaction();

            //log
            $startTime = microtime(true);

            $account =  Account::where('wallet_address', $wallet_address)->lockForUpdate()->first();

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
            Log::channel('enter_game_log')->debug("WEB — Get user before play from DB exec time: {$executionTime} ms");
            //log

            if(!$account) {
                return response()->json(['message' => 'wallet address not found'],404);
            }

            // Retrieve IDs of existing daily quests and partner quests for this account
            $existingDailyQuestIds = $account->daily_quests()->pluck('daily_quest_id')->toArray();
            $existingPartnerQuestIds = $account->partners_quests()->pluck('partners_quest_id')->toArray();

            // Fetch all visible daily quests and partner quests
            $daily_quests = DailyQuest::where('vis', 1)->get();
            $partners_quests = PartnersQuest::where('vis', 1)->get();

            // Create account daily quests for new daily quests
            foreach ($daily_quests as $daily_quest) {
                if (!in_array($daily_quest->id, $existingDailyQuestIds)) {
                    $account->daily_quests()->create([
                        'daily_quest_id' => $daily_quest->id,
                        'required_amount' => $daily_quest->required_amount,
                        'required_referrals' => $daily_quest->required_referrals,
                        'reward' => $daily_quest->reward,
                    ]);
                }
            }

            // Create account partner quests for new partner quests
            foreach ($partners_quests as $partners_quest) {
                if (!in_array($partners_quest->id, $existingPartnerQuestIds)) {
                    $account->partners_quests()->create([
                        'partners_quest_id' => $partners_quest->id,
                        'reward' => $partners_quest->reward,
                    ]);
                }
            }

            //log
            $startTime = microtime(true);

            // Refresh account with updated relations
            $account =  Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])->where('wallet_address', $wallet_address)->first();

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
            Log::channel('enter_game_log')->debug("WEB — User updated with tasks before play from DB exec time: {$executionTime} ms");
            //log

            if($account->id_telegram) {
                $redis = new RedisService();
                $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
                Log::channel('enter_game_log')->debug("WEB — Save User to Redis");
            }

            DB::commit();
            return response()->json($account, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /*
      GET /api/telegram-id/{id}
    */

    public function show_by_telegram_id($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!$id) {
            return response()->json(404);
        }

        //log
        $startTime = microtime(true);

        $redis = new RedisService();
        $account = $redis->getData($id);

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
        Log::channel('enter_game_log')->debug("BOT — GET user from Redis exec time: {$executionTime} ms");
        //log

        if (!$account) {
            //log
            $startTime = microtime(true);

            $account = Account::where('id_telegram', $id)->first();

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
            Log::channel('enter_game_log')->debug("BOT — GET user from DB if not in Redis exec time: {$executionTime} ms");
            //log


            if (!$account) {
                return response()->json(['message' => 'telegram ID not found'], 404);
            }

            if ($account->wallet_address) {
                $tasks = new TasksService();
                $tasks->makeTasks($account);

                //log
                $startTime = microtime(true);

                $account = Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])
                    ->where('id_telegram', $id)->first();

                $endTime = microtime(true);
                $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
                Log::channel('enter_game_log')->debug("BOT — User updated with tasks from DB exec time: {$executionTime} ms");
                //log
            }

            $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
            Log::channel('enter_game_log')->debug("BOT — Save User to Redis");

        } else {
            $account = json_decode($account, true);
        }

        return response()->json($account, 201);
    }

    /*
         GET /api/generate-referral-code/{wallet_address}
    */
    public function generate_referral_code($wallet_address)
    {
        $validator = Validator::make(['wallet_address' => $wallet_address], [
            'wallet_address' => 'required|min:10|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $account = Account::where('wallet_address', $wallet_address)
            ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])
            ->first();

        if (!$account) {
            return response()->json(['message' => 'wallet address not found'], 404);
        }

        DB::beginTransaction();
        try {
            if (!$account->referral_code) {
                $account->referral_code = \Modules\Accounts\Entities\Account::randomString();
                $account->save();

                $redis = new RedisService();
                $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to generate referral code'], 500);
        }

        return response()->json(['code' => $account->referral_code], 201);
    }

     /*
         GET /api/check-referral-code/{code}
     */

    public function check_referral_code($code)
    {
        $validator = Validator::make(['code' => $code], [
            'code' => 'required|min:5|max:16|regex:/^[A-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $account = Account::where('referral_code', $code)->first();

        if ($account) {
            return response()->json($account, 201);
        }

        return response()->json(['message' => 'referral code not found'], 404);
    }

    /*
        POST /api/pass-task
    */

    public function pass_task(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'nullable|min:10|max:100',
            'id_telegram' => 'nullable|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'task' => 'required|regex:/^[a-z\_]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $walletAddress = $request->post('wallet_address');
        $idTelegram = $request->post('id_telegram');

        if (!$walletAddress && !$idTelegram) {
            return response()->json(['message' => 'wallet_address or id_telegram required'], 404);
        }

        $account = null;
        if ($walletAddress) {
            $account = Account::where('wallet_address', $walletAddress)
                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])
                ->first();
        } elseif ($idTelegram) {
            $account = Account::where('id_telegram', $idTelegram)
                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])
                ->first();
        }

        if (!$account) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $redis = new RedisService();
        $redis->deleteIfExists($account->id_telegram);

        $task = $request->post('task');
        $validTasks = [
            'twitter' => 'twitter_connect_price',
            'tg_chat' => 'tg_chat_connect_price',
            'tg_channel' => 'tg_channel_connect_price',
            'website' => 'website_connect_price'
        ];

        if (!array_key_exists($task, $validTasks)) {
            return response()->json(['message' => 'task value incorrect'], 404);
        }

        $taskField = $task;

        if (!$account->$taskField) {
            try {
                DB::beginTransaction();

                $account->$taskField = 1;
                $account->wallet_balance += (int)app('settings')->get($validTasks[$task]);
                $account->save();

                if($account->id_telegram) {
                    $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 404);
            }
        }

        $response = [
            'wallet_address' => $account->wallet_address,
            'id_telegram' => $account->id_telegram,
            'twitter' => $account->twitter,
            'tg_chat' => $account->tg_chat,
            'tg_channel' => $account->tg_channel,
            'website' => $account->website
        ];

        return response()->json($response, 201);
    }

    /*
        POST /api/set-activity
    */

    public function set_activity_time(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'min:10|max:100',
            'id_telegram' => 'min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'timestamp' => 'required|date_format:U|after:' . Carbon::now()->format('U')
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        if(($request->post('wallet_address') || $request->post('id_telegram')) && 
            $request->post('timestamp')) {
            
            if($request->post('wallet_address')) {
                $account = Account::where('wallet_address', $request->post('wallet_address'))->first();
                if(!$account) {
                    return response()->json(['message' => 'user not found'], 404);
                }
            }
            if($request->post('id_telegram')) {
                $account = Account::where('id_telegram', $request->post('id_telegram'))->first();
                if(!$account) {
                    return response()->json(['message' => 'user not found'], 404);
                }
            }
            
            $account->active_at = $request->post('timestamp');
            $account->energy = 0;
            $account->save();

            $res = array(
                'id_telegram' => $account->id_telegram,
                'wallet_address' => $account->wallet_address,
                'active_at' => $account->active_at,
            );

            return response()->json($res, 201);
        }

        return response()->json(404);
    }

    /*
        POST /api/update-wallet-address
    */

    public function update_wallet_address(Request $request)
    {
        $account = Account::where('id_telegram', $request->post('id_telegram'))->first();

        if (!$account) {
            return response()->json(['message' => 'telegram account not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => [
                'required',
                'min:10',
                'max:100',
                Rule::unique('accounts')->ignore($account->id, 'id'),
            ],
            'id_telegram' => 'min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        try {
            DB::beginTransaction();

            $redis = new RedisService();
            $currentDateTime = new \DateTime();
        //    $currentDateTime->add(new \DateInterval('PT72H'));

            $account->update_wallet_at = $currentDateTime->getTimestamp();
            $account->wallet_address = $request->post('wallet_address');

            if ($account->is_wallet_connected == 0) {
                $account->is_wallet_connected = 1;
            }

            $account->save();

            if ($account->id_telegram) {
                $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
            }

            DB::commit();

            return response()->json($account, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /*
        POST /api/set-wallet-address
    */

    public function set_wallet_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'required|min:10|max:100',
            'id_telegram' => 'required|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        if($request->post('wallet_address') && $request->post('id_telegram')) {

            $account = Account::where('id_telegram', $request->post('id_telegram'))
                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])
                ->first();

            $exist = Account::where('wallet_address', $request->post('wallet_address'))
                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])
                ->first();

            if(!$account) {
                return response()->json(['message' => 'telegram ID not found'], 404);
            }

            $tasks = new TasksService();
            $redis = new RedisService();

            if(!$exist) {
                if($account->wallet_address) {
                    return response()->json(['message' => 'account already has a wallet address'], 404);
                }
                $currentDateTime = new \DateTime();
                $currentDateTime->add(new \DateInterval('PT72H'));

                $account->wallet_address = $request->post('wallet_address');
                $account->wallet_balance = $account->wallet_balance;// + (int)app('settings')->get('wallet_connect_price');
                $account->update_wallet_at = $currentDateTime->getTimestamp();
                $account->save();

                $tasks->makeTasks($account);
                $account = Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])->find($account->id);

                $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);

                $res = array(
                    'wallet_address' => $account->wallet_address
                );

                return response()->json($res, 201);
            } else {
                if(!$exist->id_telegram) {

                    $redis->deleteIfExists($account->id_telegram);
                    Account::destroy($account->id);

                    $balance = $account->wallet_balance;

                    if($account->twitter) {
                        if($exist->twitter) {
                            $balance = $balance - (int)app('settings')->get('twitter_connect_price');
                        } else {
                            $exist->twitter = 1;
                        }
                    }
                    if($account->tg_chat) {
                        if($exist->tg_chat) {
                            $balance = $balance - (int)app('settings')->get('tg_chat_connect_price');
                        } else {
                            $exist->tg_chat = 1;
                        }
                    }
                    if($account->tg_channel) {
                        if($exist->tg_channel) {
                            $balance = $balance - (int)app('settings')->get('tg_channel_connect_price');
                        } else {
                            $exist->tg_channel = 1;
                        }
                    }
                    if($account->website) {
                        if($exist->website) {
                            $balance = $balance - (int)app('settings')->get('website_connect_price');
                        } else {
                            $exist->website = 1;
                        }
                    }

                    $balance = $balance < 0 ? 0 : $balance;

                    if($account->parent_id && !$exist->parent_id) {
                        $exist->parent_id = $account->parent_id;
                    }
                    if($account->active_at && !$exist->active_at) {
                        $exist->active_at = $account->active_at;
                    }

                    $ref_users = Account::where('parent_id', $account->id)->count();
                    if($ref_users) {
                        DB::select("update accounts set parent_id = " . $exist->id . " where parent_id = " . $account->id);
                    }

                    $exist->id_telegram = $request->post('id_telegram');
                    $exist->wallet_balance = $exist->wallet_balance + $balance + (int)app('settings')->get('wallet_connect_price');
                    $exist->referral_balance = $exist->referral_balance + $account->referral_balance;
                    $exist->energy = (($exist->energy + $account->energy) > (int)app('settings')->get('maximumEnergy')) ? (int)app('settings')->get('maximumEnergy') : ($exist->energy + $account->energy);
                    $exist->save();

                    $tasks->makeTasks($exist);
                    $exist = Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])->find($exist->id);

                    $redis->updateIfNotSet($exist->id_telegram, $exist->toJson(), $exist->timezone);
                } else {
                    return response()->json(['message' => 'Wallet already registered','error_code'=>'wallet_exist'], 404);
                }
            }
        }

        return response()->json(404);
    }

    public function clear_wallet_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'wallet_address' => 'min:10|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $account = Account::where('wallet_address', $request->post('wallet_address'))->first();

        if (!$account) {
            return response()->json(['message' => 'user not found'], 404);
        }

        try {
            DB::beginTransaction();

            $account->wallet_address = NULL;
            $account->save();

            $account = Account::with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id'])->find($account->id);

            if($account->id_telegram) {
                $redis = new RedisService();
                $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
            }

            DB::commit();

            return response()->json($account, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}