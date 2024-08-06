<?php

namespace App\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Modules\Projects\Entities\Project;

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
                        'link' => $task->link,
                        'reward' => $task->reward
                    ];
                })
            ];
        });

        return response()->json($data, 201);
    }
}