<?php

namespace App\Http\Controllers\Claims;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Helper;

use App\Models\Admin\ClaimFloat;
use App\Models\District;

use App\Models\FloatProcess, App\Models\FloatProcessDocument;
use App\Models\FloatNumber;
use App\Claim;

class FloatController extends Controller
{

    public function viewFreshFloats() {
        $results = ClaimFloat::where('assigned_to', Auth::user()->id)->where('current_status', 'float_uploaded')->with('float', 'hospital')->orderBy('approval_date', 'DESC')->get();

        return view('claim.home', compact('results'));
    }

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

        return Redirect::route('claim.float_data.view')->with(['message' => 'Processed succeesfully !', 'alert_class' => 'alert-success']);

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
        $all_floats = FloatNumber::orderBy('name','asc')->where('status',1)->pluck('name','id');
        $result_data = $this->getSearchResult($request);
        $results = $result_data->paginate(600);
        return view('claim.floats.view_all', compact('results', 'request', 'all_floats'));
    }

    public function excelExport(Request $request) {
        $result_data = $this->getSearchResult($request);
        $results = $result_data->get();

        dd($results);

        $arr = [];
        foreach($results as $k => $v) {
            $arr[$k]['Sl No']                   = $k+1;
            $arr[$k]['Hospital']                = $v->hospital->name;
            $arr[$k]['Date of Admission']       = date('d-m-Y', strtotime($v->date_of_admission));
            $arr[$k]['Date of Discharge']       = date('d-m-Y', strtotime($v->date_of_discharge));
            $arr[$k]['Package Name']            = $v->package_name;

            $float_process = FloatProcess::where('float_id', $v->id)->where('status',1)->first();
       
            $arr[$k]['Invoice/ Bills from Hopsital (Rs)']       = $float_process->invoice_from_hospital;

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
            $excel->sheet('All', function($sheet) use($arr){
              $sheet->setTitle('All');

              $sheet->cells('A1:N1', function($cells) {
                $cells->setFontWeight('bold');
              });
              
              
              $sheet->fromArray($arr, null, 'A1', false, true);
            });

            $excel->sheet('Hayat', function($sheet) use($arr){
              $sheet->setTitle('Hayat');

              $sheet->cells('A1:N1', function($cells) {
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

        if($request->float_id) {
            $where['float_id']      = $request->float_id;
        }

        $result_data = ClaimFloat::where($where)->whereStatus(1)->orderBy('patient_name')->with(['claims_coordinator', 'beneficiary_district', 'hospital', 'float']);

        if($request->patient_name) {
            $result_data = $result_data->where('patient_name', 'like', '%' . $request->patient_name . '%');
        } 

        if($request->hospital_id) {
            $where['hospital_id']      = $request->hospital_id;
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

    public function update(Request $request, $float_process_id) {
        $data = $request->all();


        $float_process_id = Crypt::decrypt($float_process_id);

        $float_process    = FloatProcess::findOrfail($float_process_id);

        $data['processed_by']   = Auth::user()->id;
        $data['float_id']       = $float_process->float_id;
        $data['current_status'] = 'float_processed_by_claims_coordinator';
        /*dump($request->all());
        dd($data);*/
        $validator = Validator::make($data, FloatProcess::$rules);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        
        

        $float_process->fill($data);

        DB::beginTransaction();
        if($float_process->save()) {

            $float = ClaimFloat::find($float_process->float_id);
            if($request->can_be_processed == 'Yes') {
                $float->current_status = 'float_processed_by_claims_coordinator';
            }else{
                $float->current_status = 'float_halt_by_claims_coordinator';
            }
            $float->processed = 1;
            $float->save();


            //remove all float process document files
            DB::table('float_process_documents')->where('float_process_id', $float_process->id)->delete(); 

            foreach(Helper::claimRequirements() as $k => $v) {
                $doc_var = '';
                $doc_var = 'documents_'.$v->id;

                if(isset($request->$doc_var)) {
                    if($request->$doc_var != '') {
                        $float_process_document = [];

                        $float_process_document['float_process_id']         = $float_process->id;
                        $float_process_document['float_requirement_id']     = $v->id;
                        $float_process_document['float_requirement_value']  = $request->$doc_var;

                        $validator_doc = Validator::make($float_process_document, FloatProcessDocument::$rules);
                        if ($validator_doc->fails()) return Redirect::back()->withErrors($validator_doc)->withInput();

                        FloatProcessDocument::create($float_process_document);
                    }
                }
            }
        }

        DB::commit();

        return Redirect::route('claim.float_data.view')->with(['message' => 'Updated succeesfully !', 'alert_class' => 'alert-success']);
    }
}
