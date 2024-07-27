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
        Schema::create('game_daily_statistic', function (Blueprint $table) {
            $table->id();
            $table->integer('new_players_bot')->default(0);
            $table->integer('new_players_web')->default(0);
            $table->integer('new_referrals')->default(0);
            $table->integer('playing_from_bot')->default(0);
            $table->integer('playing_from_web')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_daily_statistic');
    }
};
