<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('section');
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->tinyInteger('hidden')->default(0)->nullable();
            $table->smallInteger('pos')->default(0);
            $table->timestamps();
        });

        DB::table('modules')->insert( [
            'name' => 'users',
            'section' => 'tools',
            'title' => 'Users',
        ]);

        DB::table('modules')->insert( [
            'name' => 'accounts',
            'section' => 'accesses',
            'title' => 'Accounts',
        ]);

//        DB::table('modules')->insert( [
//            'name' => 'menu_items',
//            'section' => 'site',
//            'title' => 'Menu',
//        ]);
//
//        DB::table('modules')->insert( [
//            'name' => 'socials',
//            'section' => 'site',
//            'title' => 'Socials',
//        ]);
//
//        DB::table('modules')->insert( [
//            'name' => 'features',
//            'section' => 'site',
//            'title' => 'Features',
//        ]);
//
//        DB::table('modules')->insert( [
//            'name' => 'utils',
//            'section' => 'site',
//            'title' => 'Utility',
//        ]);

//        DB::table('modules')->insert( [
//            'name' => 'phases',
//            'section' => 'site',
//            'title' => 'Phases',
//        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
