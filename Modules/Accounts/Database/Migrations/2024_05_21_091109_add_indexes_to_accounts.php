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
        Schema::table('accounts', function (Blueprint $table) {
            // Adding individual indexes
            $table->index('active_at');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('id_telegram');
            $table->index('wallet_address');

            // Adding combined indexes
            $table->index(['energy', 'updated_at']);
            $table->index(['active_at', 'energy']);
            $table->index(['created_at', 'updated_at']);
            $table->index(['id_telegram', 'created_at', 'updated_at']);
            $table->index(['id_telegram', 'energy', 'active_at', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            // Dropping individual indexes
            $table->dropIndex(['active_at']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['id_telegram']);
            $table->dropIndex(['wallet_address']);

            // Dropping combined indexes
            $table->dropIndex(['energy', 'updated_at']);
            $table->dropIndex(['active_at', 'energy']);
            $table->dropIndex(['created_at', 'updated_at']);
            $table->dropIndex(['id_telegram', 'created_at', 'updated_at']);
            $table->dropIndex(['id_telegram', 'energy', 'active_at', 'updated_at']);
        });
    }
};
