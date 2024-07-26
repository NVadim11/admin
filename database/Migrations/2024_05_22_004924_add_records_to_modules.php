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
        Schema::table('modules', function (Blueprint $table) {
            DB::table('modules')->insert( [
                'name' => 'daily_quests',
                'section' => 'game',
                'title' => 'Daily Quests',
            ]);
            DB::table('modules')->insert( [
                'name' => 'partners_quests',
                'section' => 'game',
                'title' => 'Partners Quests',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            //
        });
    }
};
