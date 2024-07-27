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
        Schema::table('accounts_partners_quests', function (Blueprint $table) {
            // Adding individual indexes
            $table->index('status');
            $table->index('created_at');
            $table->index('updated_at');

            // Adding composite indexes
            $table->index(['account_id', 'partners_quest_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts_partners_quests', function (Blueprint $table) {
            // Dropping individual indexes
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);

            // Dropping composite indexes
            $table->dropIndex(['account_id', 'partners_quest_id']);
        });
    }
};
