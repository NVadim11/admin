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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('tokenName', 255)->nullable()->after('vote_24');
            $table->string('contract', 255)->nullable()->after('tokenName');
            $table->string('projectLink', 255)->nullable()->after('contract');
            $table->string('taskLink', 255)->nullable()->after('projectLink');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['tokenName', 'contract', 'projectLink', 'taskLink']);
        });
    }
};
