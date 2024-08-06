<?php

namespace Modules\Projects\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;

class AccountProjectTask extends Model
{
    use HasFactory;

	protected $table = "accounts_projects_tasks";
	protected $fillable = ['account_id', 'projects_task_id'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(Account::class);
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
        self::deleted(function($model){});
    }
}