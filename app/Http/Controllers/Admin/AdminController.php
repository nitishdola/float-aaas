<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel;

use App\Models\Admin\ClaimFloat;
use App\Models\District;
use App\Models\FloatProcess;

use App\Claim;

class AdminController extends Controller
{
    public function home() {
    	$unique_floats = DB::table('floats')
            ->distinct()
            ->where('status',1)
            ->count('float_number');


    	$total_claims = ClaimFloat::where('status',1)->count();

    	$float_processed = FloatProcess::count();

    	return view('admin.home', compact('unique_floats', 'total_claims', 'float_processed'));
    }
}
