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
        Schema::table('partners_quests', function (Blueprint $table) {
            $table->string('type', 2)->default(0)->after('reward');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners_quests', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};