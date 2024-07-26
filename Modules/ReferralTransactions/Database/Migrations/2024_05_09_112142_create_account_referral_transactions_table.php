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
        Schema::create('accounts_referral_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->unsigned()->nullable();
            $table->index(['account_id', 'referral_transaction_id'], 'acc_ref_trx_acc_id_ref_trx_id_idx');
            $table->unsignedBigInteger('referral_transaction_id')->unsigned()->nullable();
            $table->integer('referrals')->default(0);
            $table->integer('required_referrals')->default(0);
            $table->integer('reward')->default(0);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('vis')->default(1);
            $table->timestamps();

            $table->foreign('account_id', 'acc_ref_trx_acc_id_fk')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            // Добавляем внешний ключ для referral_transaction_id
            $table->foreign('referral_transaction_id', 'acc_ref_trx_ref_trx_id_fk')
                ->references('id')
                ->on('referral_transactions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_referral_transactions');
    }
};
