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

    public function ratings()
    {
        $projects = Project::where('vis', 1)
            ->orderByDesc('vote_total')
            ->where('vote_total', '>', 0)
            ->limit(100)
            ->get();

        if($projects->isEmpty()) {
            return response()->json(['message' => 'No projects found'], 404);
        }

        $res = $projects->map(function ($project, $index) {
            return [
                'position' => $index + 1,
                'name' => $project->name,
                'image' => $project->image,
                'vote_total' => $project->vote_total,
                'vote_24' => $project->vote_24,
                'tokenName' => $project->tokenName,
                'contract' => $project->contract,
                'projectLink' => $project->projectLink,
                'taskLink' => $project->taskLink,
            ];
        });

        return response()->json($res, 201);
    }
}