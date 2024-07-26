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
        Schema::table('daily_quests', function (Blueprint $table) {
            DB::table('daily_quests')->insert( [
                'name' => 'Enter the Game',
                'link' => null,
                'reward' => 500,
                'required_amount' => 0,
                'required_referrals' => 0,
                'vis' => 1
            ]);
            DB::table('daily_quests')->insert( [
                'name' => 'Tap 1000 coins',
                'link' => null,
                'reward' => 250,
                'required_amount' => 1000,
                'required_referrals' => 0,
                'vis' => 1
            ]);
            DB::table('daily_quests')->insert( [
                'name' => 'Tap 2000 coins',
                'link' => null,
                'reward' => 500,
                'required_amount' => 2000,
                'required_referrals' => 0,
                'vis' => 1
            ]);
            DB::table('daily_quests')->insert( [
                'name' => '+1 Referral',
                'link' => null,
                'reward' => 2000,
                'required_amount' => 0,
                'required_referrals' => 1,
                'vis' => 1
            ]);
            DB::table('daily_quests')->insert( [
                'name' => '+3 Referrals',
                'link' => null,
                'reward' => 7000,
                'required_amount' => 0,
                'required_referrals' => 3,
                'vis' => 1
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_quests', function (Blueprint $table) {
            //
        });
    }
};
