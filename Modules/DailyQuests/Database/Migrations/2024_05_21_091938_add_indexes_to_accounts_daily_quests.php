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
            // Adding individual indexes
            $table->index('account_id');
            $table->index('daily_quest_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('updated_at');

            // Adding composite indexes
            $table->index(['account_id', 'daily_quest_id']);
            $table->index(['account_id', 'status']);
            $table->index(['daily_quest_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts_daily_quests', function (Blueprint $table) {
            // Dropping individual indexes
            $table->dropIndex(['account_id']);
            $table->dropIndex(['daily_quest_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);

            // Dropping composite indexes
            $table->dropIndex(['account_id', 'daily_quest_id']);
            $table->dropIndex(['account_id', 'status']);
            $table->dropIndex(['daily_quest_id', 'status']);
        });
    }
};
