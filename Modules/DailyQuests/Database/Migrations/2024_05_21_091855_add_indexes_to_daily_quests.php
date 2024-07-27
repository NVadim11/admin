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
            Schema::table('daily_quests', function (Blueprint $table) {
                // Adding individual indexes
                $table->index('vis');
                $table->index('pos');
                $table->index('created_at');
                $table->index('updated_at');

                // Adding composite indexes
                $table->index(['vis', 'pos']);
                $table->index(['reward', 'required_amount', 'required_referrals']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_quests', function (Blueprint $table) {
            Schema::table('daily_quests', function (Blueprint $table) {
                // Dropping individual indexes
                $table->dropIndex(['vis']);
                $table->dropIndex(['pos']);
                $table->dropIndex(['created_at']);
                $table->dropIndex(['updated_at']);

                // Dropping composite indexes
                $table->dropIndex(['vis', 'pos']);
                $table->dropIndex(['reward', 'required_amount', 'required_referrals']);
            });
        });
    }
};
