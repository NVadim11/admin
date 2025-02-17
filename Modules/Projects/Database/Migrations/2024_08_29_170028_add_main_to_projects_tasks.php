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
        Schema::table('projects_tasks', function (Blueprint $table) {
            $table->tinyInteger('main')->default(0)->after('reward');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects_tasks', function (Blueprint $table) {
            $table->dropColumn('main');
        });
    }
};
