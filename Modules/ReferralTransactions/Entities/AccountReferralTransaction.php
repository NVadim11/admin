<?php

namespace Modules\ReferralTransactions\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\Account;
use Modules\PartnersQuests\Entities\AccountPartnersQuest;

class AccountReferralTransaction extends Model
{
    use HasFactory;

	protected $table = "accounts_referral_transactions";
	protected $fillable = ['account_id', 'referral_transaction_id', 'referrals', 'required_sessions', 'required_referrals', 'wallet_balance_before', 'wallet_balance_after', 'charge_at', 'reward', 'status', 'vis'];
	protected $guarded = ['id'];
	public $timestamps = true;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function referral_transaction()
    {
        return $this->belongsTo(ReferralTransaction::class);
    }

    public function accounts_referral_transactions_item()
    {
        return $this->hasMany(AccountReferralTransactionsItem::class)->with('accounts_referral_transactions_items');
    }

    public static function boot()
    {
        parent::boot();

        self::created(function($model){});
        self::updated(function($model){});
        self::deleted(function($model){});
    }
}