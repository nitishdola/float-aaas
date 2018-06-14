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
    	$data['processed_by'] 	= Auth::user()->id;
    	$data['float_id'] 		= $float_id;
    	$data['current_status'] = 'float_processed_by_claims_coordinator';

      	$validator = Validator::make($data, FloatProcess::$rules);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();

        if($float_process = FloatProcess::create($data)) {


        	$float = ClaimFloat::find($float_id);
        	if($request->can_be_processed == 'Yes') {
        		$float->current_status = 'float_processed_by_claims_coordinator';
        	}else{
        		$float->current_status = 'float_halt_by_claims_coordinator';
        	}
        	$float->processed = 1;
        	$float->save();

        	foreach(Helper::claimRequirements() as $k => $v) {
	    		$doc_var = '';
	    		$doc_var = 'documents_'.$v->id;

	    		if(isset($request->$doc_var)) {
	    			if($request->$doc_var != '') {
	    				$float_process_document = [];

	    				$float_process_document['float_process_id'] 		= $float_process->id;
	    				$float_process_document['float_requirement_id'] 	= $v->id;
	    				$float_process_document['float_requirement_value'] 	= $request->$doc_var;

	    				$validator_doc = Validator::make($float_process_document, FloatProcessDocument::$rules);
        				if ($validator_doc->fails()) return Redirect::back()->withErrors($validator_doc)->withInput();

	    				FloatProcessDocument::create($float_process_document);
	    			}
	    		}
	    	}
        }

    	

    	dd($request->all());
    }

    public function viewDetails($float_process_id = null) {
    	$float_process_id 	= Crypt::decrypt($float_process_id);

    	$float_process 		= FloatProcess::whereId($float_process_id)->with('float')->first();

    	$float_process_documents = FloatProcessDocument::where('float_process_id', $float_process_id)->with('float_requirement')->get();

    	return view('claim.floats.view_details', compact('float_process', 'float_process_documents'));
    }

    public function viewAll(Request $request) {
        $where = [];
        /*$where['processed']     = 1;
        $where['assigned_to']   = Auth::user()->id;*/

        if($request->tpa_claim_reference_number) {
            $where['tpa_claim_reference_number'] = strtoupper($request->tpa_claim_reference_number);
        }

        if($request->patient_gender) {
            $where['patient_gender'] = strtoupper($request->patient_gender);
        }

        $result_data = ClaimFloat::where($where)->whereStatus(1)->orderBy('patient_name')->with(['claims_coordinator', 'beneficiary_district']);

        if($request->patient_name) {
            $result_data = $result_data->where('patient_name', 'like', '%' . $request->patient_name . '%');
        } 

        if($request->hospital_name) {
            $result_data = $result_data->where('hospital_name', 'like', '%' . $request->hospital_name . '%');
        }

        if($request->date_of_discharge_from) {
            $result_data = $result_data->where('date_of_discharge', '>=', date('Y-m-d', strtotime( $request->date_of_discharge_from ) ));
        }

        if($request->date_of_discharge_to) {
            $result_data = $result_data->where('date_of_discharge', '<=', date('Y-m-d', strtotime( $request->date_of_discharge_to ) ));
        }
 
        $results = $result_data->paginate(600);
        return view('claim.floats.view_all', compact('results', 'request'));
    }
}
