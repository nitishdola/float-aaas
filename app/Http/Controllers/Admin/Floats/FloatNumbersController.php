<?php

namespace App\Http\Controllers\Admin\Floats;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FloatNumber;

class FloatNumbersController extends Controller
{
    public function index(Request $request) {
    	$all_float_numbers = FloatNumber::orderBy('name', 'ASC')->with('floats')->get();
 
    	return view('admin.floats.float_numbers.index', compact('all_float_numbers'));
    }
}
