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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->longText('message')->nullable();
            $table->string('image', 255)->nullable();
            $table->tinyInteger('type')->default(0);
            $table->string('link', 255)->nullable();
            $table->tinyInteger('vis')->default(1);
            $table->tinyInteger('pos')->default(0);
            $table->timestamps();
        });

        DB::table('modules')->insert( [
            'name' => 'notifications',
            'section' => 'notifications',
            'title' => 'Notifications',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
