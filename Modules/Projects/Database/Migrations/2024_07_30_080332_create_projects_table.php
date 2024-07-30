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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->string('slug',250)->nullable();
            $table->string('image',250)->nullable();
            $table->string('contract_address',250)->nullable();
            $table->date('ido_date')->nullable();
            $table->date('presale_start')->nullable();
            $table->date('presale_end')->nullable();
            $table->string('telegram',250)->nullable();
            $table->string('email',250)->nullable();
            $table->string('ton_name',250)->nullable();
            $table->string('ton_abbr',250)->nullable();
            $table->integer('ton_max_supply')->nullable();
            $table->tinyInteger('ton_revoke')->nullable();
            $table->integer('vote_total')->nullable();
            $table->integer('vote_24')->nullable();
            $table->tinyInteger('is_advertised')->nullable();
            $table->tinyInteger('is_verified')->nullable();
            $table->integer('place_order')->nullable();
            $table->integer('mark_id')->nullable();
            $table->string('lucky_drop',250)->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->text('ton_description')->nullable();
            $table->string('ton_image')->nullable();
            $table->string('ton_verification')->nullable();
            $table->integer('ton_decimals')->unsigned()->nullable();
            $table->integer('ton_holders_count')->unsigned()->nullable();
            $table->boolean('ton_mintable')->unsigned()->default(0);
            $table->float('price_usd')->unsigned()->nullable();
            $table->string('site_link')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
