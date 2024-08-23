<?php

namespace Modules\Accounts\Entities;

use App\Entities\NotificationStatuses;
use App\Services\RedisService;
use App\Services\ReferralsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\DailyQuests\Entities\AccountDailyQuest;
use Modules\PartnersQuests\Entities\AccountPartnersQuest;
use Modules\Projects\Entities\AccountProjectTask;
use Modules\ReferralTransactions\Entities\AccountReferralTransaction;

class Account extends Model
{
    use HasFactory;

	protected $table = "accounts";
	protected $fillable = [
                            'parent_id',
                            'id_telegram',
                            'username',
                            'first_name',
                            'last_name',
                            'language_code',
                            'query_id',
                            'is_bot',
                            'is_premium',
                            'auth_date',
                            'hash',
                            'wallet_address',
                            'wallet_balance',
                            'referral_balance',
                            'referral_code',
                            'energy',
                            'twitter',
                            'tg_chat',
                            'tg_channel',
                            'website',
                            'notify_play',
                            'update_balance_at',
                            'active_at',
                            'update_wallet_at',
                            'referrals_count',
                            'active_referrals_count',
                            'active_referral',
                            'sessions',
                            'timezone',
                            'claimer_timer',
                            'claimer_value'
                        ];

    protected $appends = ['tap_value', 'tap_boost_value', 'max_energy', 'call_down_minutes'];
	protected $guarded = ['id'];
	public $timestamps = true;
    protected $tap_value = 1;
    protected $tap_boost_value = 4;
    protected $max_energy = 1000;
    protected $call_down_minutes = 60;

    public function setTapValueAttribute($value)
    {
        $this->attributes['tap_value'] = $value;
    }

    public function getTapValueAttribute()
    {
        return $this->attributes['tap_value'] ?? $this->tap_value;
    }

    public function setTapBoostValueAttribute($value)
    {
        $this->attributes['tap_boost_value'] = $value;
    }

    public function getTapBoostValueAttribute()
    {
        return $this->attributes['tap_boost_value'] ?? $this->tap_boost_value;
    }

    public function setMaxEnergyAttribute($value)
    {
        $this->attributes['max_energy'] = $value;
    }

    public function getMaxEnergyAttribute()
    {
        return $this->attributes['max_energy'] ?? $this->max_energy;
    }

    public function setCallDownMinutesAttribute($value)
    {
        $this->attributes['call_down_minutes'] = $value;
    }

    public function getCallDownMinutesAttribute()
    {
        return $this->attributes['call_down_minutes'] ?? $this->call_down_minutes;
    }

    public function referrals()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function daily_quests()
    {
        return $this->hasMany(AccountDailyQuest::class)
            ->join('accounts', 'accounts.id', '=', 'accounts_daily_quests.account_id')
            ->select('accounts_daily_quests.*', 'accounts.timezone')
            ->whereRaw("accounts_daily_quests.created_at > CONVERT_TZ(CONCAT(DATE(CONVERT_TZ(NOW(), @@session.time_zone, accounts.timezone)), ' 00:00:00'), accounts.timezone, 'UTC')")
            ->whereRaw("accounts_daily_quests.created_at < CONVERT_TZ(CONCAT(DATE(CONVERT_TZ(NOW(), @@session.time_zone, accounts.timezone)), ' 23:59:59'), accounts.timezone, 'UTC')")
            ->with('daily_quest');
    }

    public function partners_quests()
    {
        return $this->hasMany(AccountPartnersQuest::class)->with('partners_quest');
    }

    public function projects_tasks()
    {
        return $this->hasMany(AccountProjectTask::class);
    }

    public function referral_template()
    {
        return $this->hasOne(AccountReferralTransaction::class);
    }

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            if($model->parent_id) {
                $redis = new RedisService();
                $account = Account::find($model->parent_id);
                if ($account) {
                    $account->referrals_count = $account->referrals_count + 1;
                    $account->save();

                    $redis->deleteIfExists($account->id);
                    $redis->updateIfNotSet($account, $account->timezone);
                }
            }
        });

        self::updated(function($model){
            if(!$model->active_referral &&
                $model->parent_id &&
                $model->sessions == 4) {

                    $model->active_referral = 1;
                    $model->save();

                    $redis = new RedisService();
                    $account = Account::find($model->parent_id);
                    if ($account) {
                        $account->active_referrals_count = $account->active_referrals_count + 1;
                        $account->save();

                        $redis->deleteIfExists($account->id);
                        $redis->updateIfNotSet($account, $account->timezone);
                    }

                    $service = new ReferralsService();
                    $service->makeReferralLevel($model);

                    $redis->updateIfNotSet($model, $model->timezone);
            }
        });

        self::deleted(function($model){
            $model->projects_tasks()->delete();
            $model->partners_quests()->delete();
            $model->daily_quests()->delete();

            $redis = new RedisService();
            $redis->deleteIfExists($model->id_telegram);
        });
        self::updating(function($model){
            if ($model->isDirty('username')) {
                NotificationStatuses::where('notification_type', 2)
                    ->where('id_telegram', $model->id_telegram)
                    ->delete();
            }

            $redis = new RedisService();
            $redis->deleteIfExists($model->id_telegram);
        });
        self::deleting(function($model){
            $redis = new RedisService();
            $redis->deleteIfExists($model->id_telegram);
        });
    }

    public static function randomString($length = 5) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
