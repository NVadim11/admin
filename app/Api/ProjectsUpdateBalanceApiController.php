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
use Modules\Projects\Entities\AccountProjectGaming;
use Modules\Projects\Entities\Project;
use Modules\ProjectVote\Models\ProjectVote;

class ProjectsUpdateBalanceApiController extends Controller
{
    public function index(Request $request)
    {
        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'id_telegram' => 'required|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'id_project' => 'required|regex:/^[0-9]+$/u',
            'score' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $score = $request->post('score');
        $id_telegram = $request->post('id_telegram');
        $id_project = $request->post('id_project');
        $client_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $client_ip = $this->getClientIpInfo();

        if ($id_telegram) {
            $redis = new RedisService();
            $account = $redis->getData($id_telegram);

            $max_coins = app('settings')->get('update_balance_max_coins');

            if ($account) {
                $redis->deleteIfExists($id_telegram);
            }

            $account = Account::where('id_telegram', $id_telegram)
                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id', 'projects_gaming'])
                ->first();

            if (!$account) {
                Log::channel('update_balance_log')->debug("account not found");
                return response()->json(['message' => 'account not found'], 404);
            }

            if (!isset($account->projects_gaming) || $account->projects_gaming->isEmpty()) {

                $gaming = new AccountProjectGaming();
                $gaming->account_id = $account->id;
                $gaming->project_id = $id_project;
                $gaming->votes = Project::accountVotes($id_telegram, $id_project);
                $gaming->save();

            } else {
                $gaming = AccountProjectGaming::where(['account_id' => $account->id, 'project_id' => $id_project])->first();

                if(!$gaming) {
                    $gaming = new AccountProjectGaming();
                    $gaming->account_id = $account->id;
                    $gaming->project_id = $id_project;
                    $gaming->votes = Project::accountVotes($id_telegram, $id_project);
                    $gaming->save();
                }
            }

            $account = Account::where('id_telegram', $id_telegram)
                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id', 'projects_gaming'])
                ->first();

            $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);

            if ($score > 0 && $score < $max_coins) {
                if (is_null($gaming->can_play_at) || time() > $gaming->can_play_at) {
                    if (is_null($gaming->update_balance_at) || time() > $gaming->update_balance_at) {
                        DB::transaction(function () use ($request, $account, $gaming, $score, $redis, $client_agent, $client_ip) {
                            $project = $gaming->project;
                            $gaming->update_balance_at = strtotime('+' . app('settings')->get('update_balance_time') . ' second');
                            $gaming->notify_play = 0;
                            $balance = $gaming->taps + $score;
                            $project_balance = $project->tap_total + $score;
                            $energy = $gaming->energy;
                            $energy_scored = $gaming->energy + $score;

                            // go ot call down
                            if (($energy_scored) >= 1000) {
                                $addHour = new \DateTime();
                                $addHour->add(new \DateInterval('PT1H'));
                                $balance = $gaming->taps + (1000 - $gaming->energy);
                                $project_balance = $project->tap_total + (1000 - $gaming->energy);
                                $gaming->energy = 0;
                                $gaming->can_play_at = $addHour->getTimestamp();
                                $gaming->sessions = $gaming->sessions + 1;
                                $gaming->votes = $gaming->votes + 1;

                                $project_vote = ProjectVote::create([
                                    'project_id' => $gaming->project_id,
                                    'client_id' => $account->id_telegram,
                                    'client_ip' => $client_ip,
                                    'client_agent' => $client_agent
                                ]);

                                if ($project_vote) {

                                    if ($project) {
                                        $project->vote_24 = ProjectVote::where('project_id', $gaming->project_id)
                                            ->where('created_at', '>=', Carbon::now()->subHours(24))
                                            ->count();

                                        $project->vote_total += 1;
                                        $project->sessions_total += 1;
                                    }
                                }

                            } else {
                                $gaming->energy += $score;
                            }

                            $gaming->taps = $balance;
                            $gaming->updated_at = Carbon::now();
                            $gaming->save();

                            $project->tap_total = $project_balance;
                            $project->save();

                            $account = Account::where('id_telegram', $account->id_telegram)
                                ->with(['daily_quests', 'partners_quests', 'projects_tasks:account_id,projects_task_id', 'projects_gaming'])
                                ->first();

                            $redis->updateIfNotSet($account->id_telegram, $account->toJson(), $account->timezone);
                        });

                        return response()->json($gaming, 201);

                    } else {
                        Log::channel('update_balance_log')->debug("update balance time limit error");
                        return response()->json(['message' => 'update balance time limit'], 404);
                    }
                } else {
                    return response()->json(['message' => 'Call down until: ' . date("d.m.Y H:i:s", $gaming->can_play_at)], 404);
                }
            } else {
                Log::channel('update_balance_log')->debug("score must be greater than 0");
                return response()->json(['message' => 'score must be greater than 0'], 404);
            }
        }
        Log::channel('update_balance_log')->debug("Invalid request");
        return response()->json(['message' => 'Invalid request'], 404);
    }

    private function getClientIpInfo()
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }

        return $ip_address;
    }
}
