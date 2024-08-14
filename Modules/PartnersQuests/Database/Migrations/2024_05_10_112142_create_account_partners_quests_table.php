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
        Schema::create('accounts_partners_quests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('partners_quest_id')->unsigned()->nullable();
            $table->foreign('partners_quest_id')->references('id')->on('partners_quests')->onDelete('cascade');
            $table->tinyInteger('status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_partners_quests');
    }
};
