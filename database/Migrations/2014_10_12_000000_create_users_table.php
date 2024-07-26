<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('login');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('full_access')->default(0);
            $table->string('password');
            $table->string('locale')->nullable();
            $table->string('auth_verify_secret')->nullable();
            $table->string('auth_verify')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert( [
            'name' => 'Administrator',
            'login' => 'root',
            'email' => 'root@root.ru',
            'password' => $password = bcrypt('C3e5T7v9'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
