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
        Schema::create('accounts_projects_gaming', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('project_id')->unsigned()->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->bigInteger('taps')->unsigned()->default(0);
            $table->bigInteger('votes')->unsigned()->default(0);
            $table->integer('energy')->unsigned()->default(0);
            $table->bigInteger('sessions')->unsigned()->default(0);
            $table->tinyInteger('notify_play')->default(0);
            $table->string('update_balance_at', 30)->nullable();
            $table->string('can_play_at', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_projects_tasks');
    }
};
