<?php

namespace App\Http\Controllers\Claims;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB, Validator, Redirect, Auth, Crypt, Input, Excel;

use App\Models\Admin\ClaimFloat;
use App\Models\District;

use App\Claim;

class FloatController extends Controller
{
    public function viewInfo($float_id = null) {
    	$float_id = Crypt::decrypt($float_id);

    	$float = ClaimFloat::whereId($float_id)->with('beneficiary_district')->first();

    	return view('claim.floats.info', compact('float'));
    } 
}
