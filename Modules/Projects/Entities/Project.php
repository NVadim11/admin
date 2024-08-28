<?php

namespace Modules\Projects\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "projects";

    protected $fillable = [
        'name',
        'image',
        'vote_total',
        'vote_24',
        'tokenName',
        'contract',
        'projectLink',
        'taskLink',
        'has_game',
        'tap_total',
        'sessions_total',
        'vis'
    ];

    protected $guarded = ['id'];

    public $timestamps = true;

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class)->orderBy('pos', 'ASC');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeTasks()
    {
        return $this->hasMany(ProjectTask::class)->where('vis', 1)->orderBy('pos', 'ASC');
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            if ($model->isDirty()) {
                $redis = new RedisService();
                $redis->deleteIfExists('projects_list');
            }
        });

        self::updating(function($model){
            if ($model->isDirty()) {
                $redis = new RedisService();
                $redis->deleteIfExists('projects_list');
            }
        });

        self::deleted(function($model){
            $model->tasks()->delete();
            $redis = new RedisService();
            $redis->deleteIfExists('projects_list');
        });
    }
}