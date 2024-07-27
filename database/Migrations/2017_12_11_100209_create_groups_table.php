<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('text')->nullable();
        });

        Schema::create('group_module', function (Blueprint $table) {
            $table->integer('module_id')->unsigned()->nullable();
            $table->foreign('module_id')->references('id')
                  ->on('modules')->onDelete('cascade');

            $table->integer('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')
                  ->on('groups')->onDelete('cascade');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->integer('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')
                  ->on('groups')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                  ->on('users')->onDelete('cascade');
        });

        $item = DB::table('modules')->where('name', 'groups')->first();

        if(!$item){
            DB::table('modules')->insert( [
                'name' => 'groups',
                'section' => 'tools',
                'title' => 'Groups',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('group_module');
        Schema::dropIfExists('groups');
    }
}
