<?php

namespace App\Helpers;
use App\Models\FloatRequirement;
use App\Models\Admin\ClaimFloat;
use App\Models\FloatProcess;
class Helper
{
    public static function claimRequirements()
    {
        return FloatRequirement::orderBy('order')->get();
    }

    public static function getAllClaims($hospital_id = null)
    {
        return ClaimFloat::where('hospital_id', $hospital_id)->count();
    }

    public static function getAllPaidClaims($hospital_id = null)
    {
        $all_floats = ClaimFloat::where('hospital_id', $hospital_id)->get();
        $total = 0;
        if(count($all_floats)):
	        foreach($all_floats as $k => $v) {
	        	$float_processes = FloatProcess::where('float_id', $v->id)->where('can_be_processed', 'YES')->first();
	        	if($float_processes) {
	        		$total += $float_processes->amount_on_billing;
	        	}
	        }
	    endif;


        return $total;
    }

    public static function getAllUnpaidClaims($hospital_id = null)
    {
        $all_floats = ClaimFloat::where('hospital_id', $hospital_id)->get();
        $total = 0;
        if(count($all_floats)):
	        foreach($all_floats as $k => $v) {
	        	$float_processes = FloatProcess::where('float_id', $v->id)->where('can_be_processed', 'No')->first();
	        	if($float_processes) {
	        		$total += $float_processes->amount_on_billing;
	        	}
	        }
	    endif;


        return $total;
    }

    public static function twoDecimalPlaces($number) {
    	return number_format((float)$number, 2, '.', '');
    }
}