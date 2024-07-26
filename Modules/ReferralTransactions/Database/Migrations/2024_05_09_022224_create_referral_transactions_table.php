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
        Schema::create('referral_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->integer('reward')->default(0);
            $table->integer('required_referrals')->default(0);
            $table->tinyInteger('vis')->default(1);
            $table->tinyInteger('pos')->default(0);
            $table->timestamps();
        });

        Schema::table('referral_transactions', function (Blueprint $table) {
            // Adding individual indexes
            $table->index('vis');
            $table->index('pos');
            $table->index('created_at');
            $table->index('updated_at');

            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 1 / 1%',
                'reward' => 1,
                'required_referrals' => 2,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 2 / 2%',
                'reward' => 2,
                'required_referrals' => 4,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 3 / 3%',
                'reward' => 3,
                'required_referrals' => 10,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 4 / 4%',
                'reward' => 4,
                'required_referrals' => 26,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 5 / 5%',
                'reward' => 5,
                'required_referrals' => 64,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 6 / 10%',
                'reward' => 10,
                'required_referrals' => 160,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 7 / 15%',
                'reward' => 15,
                'required_referrals' => 400,
                'vis' => 1
            ]);
            DB::table('referral_transactions')->insert( [
                'name' => 'Referral level 8 / 20%',
                'reward' => 20,
                'required_referrals' => 1000,
                'vis' => 1
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_transactions');
    }
};
