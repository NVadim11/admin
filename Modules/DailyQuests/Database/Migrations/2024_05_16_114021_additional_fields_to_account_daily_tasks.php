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
        Schema::table('accounts_daily_quests', function (Blueprint $table) {
            $table->bigInteger('wallet_balance_before')->unsigned()->default(0)->after('required_amount');
            $table->bigInteger('wallet_balance_after')->unsigned()->default(0)->after('wallet_balance_before');
            $table->integer('reward')->default(0)->after('wallet_balance_after');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts_daily_quests', function (Blueprint $table) {
            $table->dropColumn('wallet_balance_before');
            $table->dropColumn('wallet_balance_after');
            $table->dropColumn('reward');
        });
    }
};
