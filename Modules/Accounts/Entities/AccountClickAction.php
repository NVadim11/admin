<?php

namespace Modules\Accounts\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Entities\Project;
use Modules\Projects\Entities\ProjectTask;

class AccountClickAction extends Model
{
    use HasFactory;

	protected $table = "accounts_click_actions";
	protected $fillable = ['account_id', 'project_id', 'projects_task_id', 'action'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function project_task()
    {
        return $this->belongsTo(ProjectTask::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){});
        self::deleted(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists($model->account()->id_telegram);
        });
    }
}