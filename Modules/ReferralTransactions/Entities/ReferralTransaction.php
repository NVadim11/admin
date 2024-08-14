<?php

namespace Modules\ReferralTransactions\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralTransaction extends Model
{
    use HasFactory;

	protected $table = "referral_transactions";
	protected $fillable = ['name', 'name_ru', 'reward', 'required_referrals', 'vis'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){
            AccountReferralTransaction::where('referral_transaction_id', $model->id)
                ->update([
                    'reward' => $model->reward,
                    'required_referrals' => $model->required_referrals,
                    'vis' => $model->vis
                ]);
        });
        self::deleted(function($model){});
    }
}

