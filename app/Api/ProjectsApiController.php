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
}