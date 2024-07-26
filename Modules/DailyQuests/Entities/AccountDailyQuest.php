<?php

namespace Modules\DailyQuests\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;

class AccountDailyQuest extends Model
{
    use HasFactory;

	protected $table = "accounts_daily_quests";
	protected $fillable = ['account_id', 'daily_quest_id', 'amount', 'referrals', 'required_amount', 'required_referrals', 'wallet_balance_before', 'wallet_balance_after', 'reward', 'status', 'vis'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function daily_quest()
    {
        return $this->belongsTo(DailyQuest::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){});
        self::deleted(function($model){});
    }
}