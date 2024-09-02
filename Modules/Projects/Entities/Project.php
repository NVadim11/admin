<?php

namespace Modules\Projects\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Model;
use Modules\ProjectVote\Models\ProjectVote;

class Project extends Model
{
    protected $table = "projects";

    protected $fillable = [
        'name',
        'image',
        'webpImage',
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

    protected $appends = ['webpImage'];

    protected $guarded = ['id'];

    public $timestamps = true;

    public function setWebpImageAttribute($value)
    {
        $this->attributes['webpImage'] = $value;
    }

    public function getWebpImageAttribute()
    {
        if ($this->image && getWebpPath($this->image)) {
            return getWebpPath($this->image);
        } else {
            return null;
        }
    }

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

    public function totalVoters()
    {
        return $this->hasMany(ProjectVote::class, 'project_id')
            ->selectRaw('project_id, COUNT(DISTINCT client_id) as total_voters')
            ->groupBy('project_id');
    }

    public static function accountVotes($id_telegram, $id_project)
    {
        return ProjectVote::where(['client_id' => $id_telegram, 'project_id' => $id_project])->count();
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