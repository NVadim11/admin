<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Entities\Account;
use Modules\Projects\Entities\AccountProjectGaming;
use Modules\Projects\Entities\AccountProjectTask;
use Modules\Projects\Entities\Project;
use Modules\Projects\Entities\ProjectTask;

class ProjectsApiController extends Controller
{
    public function index()
    {
        $redis = new RedisService();
        $res = $redis->getData('projects_list');
        if(!$res) {
            $res = Project::with(['activeTasks'])->where('vis', 1)->get();
            if ($res) {
                $redis->updateIfNotSet('projects_list', json_encode($res));
                return response()->json($res, 201);
            }
        } else {
            return response()->json(json_decode($res, true), 201);
        }

        return response()->json(404);
    }

    public function top_projects()
    {
        $projects = Project::with(['activeTasks:id,project_id,name,link,reward'])
            ->where('vis', 1)
            ->where('vote_total', '>', 0)
            ->orderByDesc('vote_total')
            ->limit(100)
            ->get();

        if($projects->isEmpty()) {
            return response()->json(['message' => 'No projects found'], 404);
        }

        $data = $projects->map(function($project, $index) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'image' => $project->image,
                'position' => $index + 1,
                'vote_total' => $project->vote_total,
                'tokenName' => $project->tokenName,
                'contract' => $project->contract,
                'projectLink' => $project->projectLink,
                'active_tasks' => $project->activeTasks->map(function($task) {
                    return [
                        'id' => $task->id,
                        'project_id' => $task->project_id,
                        'name' => $task->name,
                        'task_descr' => $task->task_descr,
                        'link' => $task->link,
                        'reward' => $task->reward
                    ];
                })
            ];
        });

        return response()->json($data, 201);
    }

    public function top_daily_projects()
    {
        $projects = Project::with(['activeTasks:id,project_id,name,link,reward'])
            ->where('vis', 1)
            ->where('vote_24', '>', 0)
            ->orderByDesc('vote_24')
            ->limit(100)
            ->get();

        if($projects->isEmpty()) {
            return response()->json(['message' => 'No projects found'], 404);
        }

        $data = $projects->map(function($project, $index) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'image' => $project->image,
                'position' => $index + 1,
                'vote_24' => $project->vote_24,
                'tokenName' => $project->tokenName,
                'contract' => $project->contract,
                'projectLink' => $project->projectLink,
                'active_tasks' => $project->activeTasks->map(function($task) {
                    return [
                        'id' => $task->id,
                        'project_id' => $task->project_id,
                        'name' => $task->name,
                        'task_descr' => $task->task_descr,
                        'link' => $task->link,
                        'reward' => $task->reward
                    ];
                })
            ];
        });

        return response()->json($data, 201);
    }

    public function top_new_projects()
    {
        $projects = Project::with(['activeTasks:id,project_id,name,link,reward'])
            ->where('vis', 1)
            ->where('vote_total', '>', 0)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        if($projects->isEmpty()) {
            return response()->json(['message' => 'No projects found'], 404);
        }

        $data = $projects->map(function($project, $index) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'image' => $project->image,
                'position' => $index + 1,
                'vote_total' => $project->vote_total,
                'tokenName' => $project->tokenName,
                'contract' => $project->contract,
                'projectLink' => $project->projectLink,
                'active_tasks' => $project->activeTasks->map(function($task) {
                    return [
                        'id' => $task->id,
                        'project_id' => $task->project_id,
                        'name' => $task->name,
                        'task_descr' => $task->task_descr,
                        'link' => $task->link,
                        'reward' => $task->reward
                    ];
                })
            ];
        });

        return response()->json($data, 201);
    }

    public function pass_project_task(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'id_telegram' => 'required|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'projects_task_id' => 'required|regex:/^[0-9]+$/u'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if (!$this->isTokenValid($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $projectsTaskId = $request->post('projects_task_id');
        $id_telegram = $request->post('id_telegram');
        $projectTask = ProjectTask::where('id', $projectsTaskId)->first();

        if (!$projectTask) {
            return response()->json(['message' => 'Project task not found'], 404);
        }

        $account = Account::where('id_telegram', $id_telegram)
            ->select('id', 'id_telegram', 'wallet_balance')
            ->first();

        if ($account === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (AccountProjectTask::where('projects_task_id', $projectsTaskId)
            ->where('account_id', $account->id)
            ->exists()) {
            return response()->json(['message' => 'Project task already passed'], 404);
        }

        DB::transaction(function () use ($projectTask, $account) {
            $accountProjectTask = new AccountProjectTask();
            $accountProjectTask->account_id = $account->id;
            $accountProjectTask->projects_task_id = $projectTask->id;
            $accountProjectTask->save();

            $account->wallet_balance += $projectTask->reward;
            $account->save();
        });

        $updatedAccount = Account::with([
            'daily_quests',
            'partners_quests',
            'projects_tasks:account_id,projects_task_id'
        ])->where('id_telegram', $id_telegram)->first();

        if ($updatedAccount->id_telegram) {
            $redis = new RedisService();
            $redis->updateIfNotSet($updatedAccount->id_telegram, $updatedAccount->toJson(), $updatedAccount->timezone);
        }

        return response()->json($updatedAccount, 201);
    }

    private function isTokenValid($token)
    {
        return checkToken($token);
    }

    public function set_project_activity_time(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'id_telegram' => 'required|min:5|max:16|regex:/^[a-zA-Z0-9]+$/u',
            'id_project' => 'required|regex:/^[0-9]+$/u',
            'timestamp' => 'required|date_format:U|after:' . Carbon::now()->format('U')
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        if(!checkToken($request->post('token'))) {
            return response()->json(['message' => 'token invalid'], 404);
        }

        $account = Account::where('id_telegram', $request->post('id_telegram'))->first();
        if(!$account) {
            return response()->json(['message' => 'account not found'], 404);
        }

        $gaming = AccountProjectGaming::where(['account_id' => $account->id, 'project_id' => $request->post('id_project')])->first();

        if(!$gaming) {
            return response()->json(['message' => 'gaming progress not found'], 404);
        }

        $gaming->can_play_at = $request->post('timestamp');
        $gaming->energy = 0;
        $gaming->save();

        $res = array(
            'id_telegram' => $account->id_telegram,
            'id_project' => $gaming->project_id,
            'id_game_progress' => $gaming->id,
            'active_at' => $gaming->can_play_at,
        );

        return response()->json($res, 201);
    }
}