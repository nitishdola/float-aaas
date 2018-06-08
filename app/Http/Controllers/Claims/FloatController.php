<?php

namespace App\Http\Controllers\Claims;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Helper;

use App\Models\Admin\ClaimFloat;
use App\Models\District;

use App\Models\FloatProcess, App\Models\FloatProcessDocument;

use App\Claim;

class FloatController extends Controller
{
    public function viewInfo($float_id = null) {
    	$float_id = Crypt::decrypt($float_id);

    	$float = ClaimFloat::whereId($float_id)->with('beneficiary_district')->first();

    	return view('claim.floats.info', compact('float'));
    } 

    public function processFloat(Request $request, $float_id = null) {

    	$data = $request->all();
    	$data['processed_by'] = Auth::user()->id;

      	$validator = Validator::make($data, FloatProcess::$rules);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();

        if($float_process = FloatProcess::create($data)) {
        	foreach(Helper::claimRequirements() as $k => $v) {
	    		$doc_var = '';
	    		$doc_var = 'documents_'.$v->id;

	    		if(isset($request->$doc_var)) {
	    			if($request->$doc_var != '') {
	    				$float_process_document = [];

	    				$float_process_document['float_process_id'] 		= $float_process->id;
	    				$float_process_document['float_requirement_id'] 	= $v->id;
	    				$float_process_document['float_requirement_value'] 	= $request->$doc_var;

	    				$validator_doc = Validator::make($FloatProcessDocument, FloatProcessDocument::$rules);
        				if ($validator_doc->fails()) return Redirect::back()->withErrors($validator_doc)->withInput();

	    				FloatProcessDocument::create($float_process_document);
	    			}
	    		}
	    	}
        }

    	

    	dd($request->all());
    }
}
