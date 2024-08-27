<?php

namespace Modules\PartnersQuests\Entities;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;

class AccountPartnersQuest extends Model
{
    use HasFactory;

	protected $table = "accounts_partners_quests";
    protected $fillable = [
        'id_telegram',
        'partners_quest_id',
        'wallet_balance_before',
        'wallet_balance_after',
        'reward',
        'status',
        'vis'
    ];

    protected $guarded = ['id']; // id можно оставить в guarded, чтобы защитить его от массового заполнения

    public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(Account::class, 'id_telegram', 'id_telegram');
    }

    public function partners_quest()
    {
        return $this->belongsTo(PartnersQuest::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists($model->id_telegram);
        });
        self::deleted(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists($model->id_telegram);
        });
    }
}