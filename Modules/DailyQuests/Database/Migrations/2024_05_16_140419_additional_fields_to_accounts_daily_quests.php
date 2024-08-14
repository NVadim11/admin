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
            $table->integer('required_referrals')->default(0)->after('required_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts_daily_quests', function (Blueprint $table) {
            $table->dropColumn('required_referrals');
        });
    }
};
