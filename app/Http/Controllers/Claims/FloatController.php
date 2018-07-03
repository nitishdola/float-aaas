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

    	return view('claim.floats.view', compact('float'));
    } 

    public function processFloat(Request $request, $float_id = null) {

        DB::beginTransaction();

    	$data = $request->all();
    	$data['processed_by'] 	= Auth::user()->id;
    	$data['float_id'] 		= $float_id;
    	$data['current_status'] = 'float_processed_by_claims_coordinator';

      	$validator = Validator::make($data, FloatProcess::$rules);

        if ($validator->fails())
                        {
                            dd($validator); //This Is works
                        }
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

        DB::commit();


        //proceed to next float
    }

    public function viewDetailedInfo($float_id = null) {
    	

        $float_id = Crypt::decrypt($float_id);

        $float = ClaimFloat::whereId($float_id)->with('beneficiary_district')->first();

        $float_process      = FloatProcess::where('float_id', $float_id)->with('float')->first();

    	$float_process_documents = FloatProcessDocument::where('float_process_id', $float_process->id)->with('float_requirement')->get();

    	return view('claim.floats.info', compact('float', 'float_process', 'float_process_documents'));
    }

    public function viewAll(Request $request) {
        $result_data = $this->getSearchResult($request);
        $results = $result_data->paginate(600);
        return view('claim.floats.view_all', compact('results', 'request'));
    }

    public function excelExport(Request $request) {
        $result_data = $this->getSearchResult($request);
        $results = $result_data->get();



        $arr = [];
        foreach($results as $k => $v) {
            $arr[$k]['Sl No']                   = $k+1;
            $arr[$k]['Date of Admission']       = $v->date_of_admission;
            $arr[$k]['Date of Discharge']       = $v->date_of_discharge;
            $arr[$k]['Package Name']            = $v->package_name;

            $float_process = FloatProcess::where('float_id', $v->id)->where('status',1)->first();
       
            $arr[$k]['Invoice/ Bills from Hopsital (Rs)']      = $float_process->invoice_from_hospital;

            $arr[$k]['Amount as per Package rate (Rs)']         = $float_process->amount_as_per_package;

            $arr[$k]['Implants/Stents (Rs)']                    = $float_process->implants;

            $arr[$k]['Traveling Allowance (Rs)']                = $float_process->travelling_allowance;
            $arr[$k]['Total Amount=(Package rate +Implants/stents + TA) (Rs)']                = $float_process->total_amount;
            $arr[$k]['Deduction (Rs)']                = $float_process->deduction;
            $arr[$k]['TDS Amount 10% (Rs)']           = $float_process->tds_amount;
            $arr[$k]['Amount on Billing (Rs) =Total Amount - (Deduction +TDS)']           = $float_process->amount_on_billing;
            $arr[$k]['Status']           = html_entity_decode($float_process->remarks);
            
            
        }
        Excel::create('Float-Processed', function( $excel) use($arr){
            $excel->sheet('Float-Processed', function($sheet) use($arr){
              $sheet->setTitle('Float-Processed');

              $sheet->cells('A1:M1', function($cells) {
                $cells->setFontWeight('bold');
              });
              
              
              $sheet->fromArray($arr, null, 'A1', false, true);
            });
        })->download('xlsx');
    }

    public function getSearchResult($request) {
        $where = [];
        $where['processed']     = 1;
        $where['assigned_to']   = Auth::user()->id;

        if($request->tpa_claim_reference_number) {
            $where['tpa_claim_reference_number'] = strtoupper($request->tpa_claim_reference_number);
        }

        if($request->patient_gender) {
            $where['patient_gender']    = strtoupper($request->patient_gender);
        }

        if($request->float_number) {
            $where['float_number']      = $request->float_number;
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
 
        return $result_data;
    }

    public function edit($float_id) {
        $float_id   = Crypt::decrypt($float_id);

        $float      = ClaimFloat::find($float_id);


        $float_process      = FloatProcess::where('float_id', $float_id)->first();

        $float_documents    = FloatProcessDocument::where('float_process_id', $float_process->id)->with('float_requirement')->get();

        return view('claim.floats.edit', compact('float', 'float_process', 'float_documents'));  
    }

    public function update(Request $request, $float_id) {
        dd($request);
    }
}
