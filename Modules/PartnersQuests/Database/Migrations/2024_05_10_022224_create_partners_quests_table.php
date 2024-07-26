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
        Schema::create('partners_quests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->integer('reward')->default(0);
            $table->tinyInteger('vis')->default(1);
            $table->tinyInteger('pos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners_quests');
    }
};
