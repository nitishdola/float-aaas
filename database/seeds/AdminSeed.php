<?php

use Illuminate\Database\Seeder;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert(array(
	      array('name'=>'Nitish Dolakasharia',  'username' => 'nitish', 'password' => bcrypt('password1'))
	    )); 
    }
}
