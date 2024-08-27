<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts_partners_quests', function (Blueprint $table) {
            $table->dropColumn('account_id');
            $table->string('id_telegram')->index()->after('id');
//            $table->foreign('id_telegram')->references('id_telegram')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts_partners_quests', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->index();
            $table->dropColumn('id_telegram');
//            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }
};