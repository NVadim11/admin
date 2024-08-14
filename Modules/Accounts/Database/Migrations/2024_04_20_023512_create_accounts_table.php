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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('id_telegram', 16)->unique()->nullable();
            $table->string('wallet_address', 100)->unique()->nullable();
            $table->bigInteger('wallet_balance')->unsigned()->default(0);
            $table->bigInteger('referral_balance')->unsigned()->default(0);
            $table->string('referral_code', 5)->nullable();
            $table->integer('energy')->unsigned()->default(0);
            $table->tinyInteger('notify_play')->default(0);
            $table->tinyInteger('twitter')->default(0);
            $table->tinyInteger('tg_chat')->default(0);
            $table->tinyInteger('tg_channel')->default(0);
            $table->tinyInteger('website')->default(0);
            $table->string('update_balance_at', 30)->nullable();
            $table->string('active_at', 30)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
