<?php

namespace Modules\ReferralTransactions\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;

class AccountReferralTransactionsItem extends Model
{
    use HasFactory;

	protected $table = "accounts_referral_transactions_item";
	protected $fillable = ['account_referral_transaction_id', 'wallet_balance_before', 'wallet_balance_after', 'reward', 'status', 'vis'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public function account_referral_transaction()
    {
        return $this->belongsTo(AccountReferralTransaction::class);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){});
        self::deleted(function($model){});
    }
}