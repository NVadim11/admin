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
            $table->string('username', 255)->nullable()->after('id_telegram');
            $table->string('first_name', 255)->nullable()->after('username');
            $table->string('last_name', 255)->nullable()->after('first_name');
            $table->string('language_code', 5)->nullable()->after('last_name');
            $table->string('query_id', 100)->nullable()->after('language_code');
            $table->boolean('is_bot')->after('query_id');
            $table->string('auth_date', 30)->nullable()->after('is_bot');
            $table->string('hash', 100)->nullable()->after('auth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('language_code');
            $table->dropColumn('query_id');
            $table->dropColumn('is_bot');
            $table->dropColumn('auth_date');
            $table->dropColumn('hash');
        });
    }
};
