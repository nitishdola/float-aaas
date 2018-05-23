<?php

use Illuminate\Database\Seeder;

class RequirementSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('float_requirements')->insert(array(
	      array('name'=>'Preauth Slip',  'order' => '1'),
	      array('name'=>'Satisfaction/Feedback',  'order' => '2'),
	      array('name'=>'Photo',  'order' => '3'),
	      array('name'=>'TA bill slip',  'order' => '4'),
	      array('name'=>'TA bill slip',  'order' => '5'),
	      array('name'=>'Discharge Summary/Discharge Letter',  'order' => '6'),
	    )); 
    }
}
