<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use App\Services\TasksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;

class RegisterApiController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_address' => 'nullable|min:10|max:100',
            'id_telegram' => 'nullable|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'parent_id_telegram' => 'nullable|regex:/^[a-zA-Z0-9]+$/u',
            'referral_code' => 'nullable|max:5|regex:/^[A-Z0-9]+$/u',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if ($request->filled('wallet_address') && !$request->filled('id_telegram')) {
            // From web
            return $this->handleWebRegistration($request);
        } elseif ($request->filled('id_telegram') && !$request->filled('wallet_address')) {
            // From bot
            return $this->handleBotRegistration($request);
        } elseif ($request->filled('id_telegram') && $request->filled('wallet_address')) {
            // Link wallet address
            return $this->handleLinkWalletAddress($request);
        }

        return response()->json(['message' => 'Invalid request'], 404);
    }

    protected function handleWebRegistration(Request $request)
    {
        $account = Account::where('wallet_address', $request->input('wallet_address'))->first();
        if ($account) {
            return response()->json(['message' => 'Wallet address already exists'], 404);
        }

        try {
            DB::beginTransaction();

            $account = new Account();
            $account->wallet_address = $request->input('wallet_address');

            $this->handleReferral($request, $account);

            $account->save();
            DB::commit();

            return response()->json($account, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    protected function handleBotRegistration(Request $request)
    {
        // Запомнить текущее время перед выполнением запроса
        $startTime = microtime(true);

        $account = Account::where('id_telegram', $request->input('id_telegram'))->first();
        if ($account) {
            return response()->json(['message' => 'Telegram ID already exists'], 404);
        }

        try {
            DB::beginTransaction();

            $account = new Account();
            $account->id_telegram = $request->input('id_telegram');

            $this->handleReferral($request, $account);

            $account->save();
            DB::commit();

            // Логирование успешного выполнения запроса и времени выполнения
            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Время выполнения в миллисекундах
            Log::channel('sql_bot_register')->debug("SQL exec time: {$executionTime} ms");

            return response()->json($account, 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Логирование ошибки
            Log::channel('sql_bot_register')->error('Error occurred: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    protected function handleLinkWalletAddress(Request $request)
    {
        $account = Account::where('wallet_address', $request->input('wallet_address'))
            ->with(['daily_quests', 'partners_quests'])
            ->first();

        if (!$account) {
            return response()->json(['message' => 'Wallet address not found'], 404);
        }

        if ($account->id_telegram) {
            return response()->json(['message' => 'User already exists'], 404);
        }

        $tasks = new TasksService();
        $redis = new RedisService();

        try {
            DB::beginTransaction();

            if ($existingAccount = Account::where('id_telegram', $request->input('id_telegram'))->whereNull('wallet_address')->first()) {
                $redis->deleteIfExists($existingAccount->id_telegram);
                $existingAccount->delete();
            }

            $account->id_telegram = $request->input('id_telegram');
            $this->handleReferral($request, $account);

            $account->wallet_balance += (int) app('settings')->get('wallet_connect_price');
            $account->save();

            $tasks->makeTasks($account);
            $account = Account::with(['daily_quests', 'partners_quests'])->find($account->id);
            $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);

            DB::commit();

            return response()->json($account, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    protected function handleReferral(Request $request, Account $account)
    {
        $referral = [];
        if ($request->filled('referral_code')) {
            $referral = Account::where('referral_code', $request->input('referral_code'))
                ->with(['daily_quests', 'partners_quests'])
                ->first();

        } elseif ($request->filled('parent_id_telegram')) {
            $referral = Account::where('id_telegram', $request->input('parent_id_telegram'))
                ->with(['daily_quests', 'partners_quests'])
                ->first();
        }

        if ($referral) {
            DailyQuestsApiController::passReferralTask($referral);
            $account->parent_id = $referral->id;
        }
    }
}
