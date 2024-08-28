<?php

namespace Modules\Projects\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;

class AccountProjectGaming extends Model
{
    use HasFactory;

	protected $table = "accounts_projects_gaming";
	protected $fillable = [
        'account_id',
        'projects_task_id',
        'taps',
        'votes',
        'energy',
        'sessions',
        'notify_play',
        'update_balance_at',
        'can_play_at'
    ];
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