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
        Schema::create('accounts_projects_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('projects_task_id')->unsigned()->nullable();
            $table->foreign('projects_task_id')->references('id')->on('projects_tasks')->onDelete('cascade');
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
