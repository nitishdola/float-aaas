<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel;

use App\Models\Admin\ClaimFloat, App\Models\FloatNumber;
use App\Models\District, App\Models\Hospital;
use App\Models\FloatProcess;

use App\Claim;

class AdminController extends Controller
{
    public function home() {
    	$float_number = FloatNumber::count();

    	$medical_colleges 	= Hospital::whereStatus(1)->where('hospital_type', 'Medical College')->get();
    	$private_hospitals 	= Hospital::whereStatus(1)->where('hospital_type', 'Private')->get();
    	$total_claims 	= ClaimFloat::where('status',1)->count();

    	$float_processed = FloatProcess::count();

    	return view('admin.home', compact('float_number', 'total_claims', 'float_processed', 'medical_colleges','private_hospitals'));
    }
}
