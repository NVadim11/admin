<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts_referral_transactions_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_referral_transaction_id')->unsigned()->nullable();
            $table->index('account_referral_transaction_id', 'acc_ref_trx_acc_id_ref_trx_id_idx1');
            $table->bigInteger('wallet_balance_before')->unsigned()->default(0);
            $table->bigInteger('wallet_balance_after')->unsigned()->default(0);
            $table->integer('reward')->default(0);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('account_referral_transaction_id', 'acc_ref_trx_ref_trx_id_fk1')
                ->references('id')
                ->on('accounts_referral_transactions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_referral_transactions_items');
    }
};
