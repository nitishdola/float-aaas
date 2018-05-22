<?php

namespace App\Http\Controllers\Claims;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB, Validator, Redirect, Auth, Crypt, Input, Excel;

use App\Models\Admin\ClaimFloat;
use App\Models\District;

use App\Claim;

class HomeController extends Controller
{
    public function index() {
    	$results = ClaimFloat::where('assigned_to', Auth::user()->id)->orderBy('approval_date', 'DESC')->get();

    	return view('claim.home', compact('results'));
    }
}
