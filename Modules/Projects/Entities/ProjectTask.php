<?php

namespace Modules\Projects\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

	protected $table = "projects_tasks";
    protected $fillable = ['name', 'task_descr', 'link', 'reward', 'main', 'vis'];
	protected $guarded = ['id'];
    public $timestamps = true;

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists('projects_list');
        });
        self::updated(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists('projects_list');
        });
        self::deleted(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists('projects_list');
        });
    }
}
