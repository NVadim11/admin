<?php

use Illuminate\Database\Migrations\Migration;

class AddDataToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('modules')->insert( [
            'name' => 'referral_transactions',
            'section' => 'referrals',
            'title' => 'Referral Conditions',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
