<?php

namespace App\Http\Controllers\Admin\Floats;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB, Validator, Redirect, Auth, Crypt, Input, Excel;

use App\Models\Admin\ClaimFloat;
use App\Models\District;

use App\Claim;


class FloatsController extends Controller
{
    public function uploadFloatsExcel() {
    	return view('admin.floats.upload_excel');
    }

    public function saveFloatsExcel(Request $request) {
    	$path = $request->file('float_file')->getRealPath();
    	$data = Excel::load($path, function($reader) {})->get();

    	DB::beginTransaction();
    	foreach($data as $k => $v) {
            if($v->tpa_name != '') {
        		$arr = [];
        		//check if district exists
        		$district_name = trim($v->beneficiary_district);
        		$chk = District::where('name', $district_name)->count();
        		if($chk) {
        			$district = District::where('name', $district_name)->first();
        		}else{
        			$dist_arr = [];
        			$dist_arr['name'] = $district_name;

        			$district = District::create($dist_arr);
        		}

        		$arr['tpa_name'] = $v->tpa_name;
        		$arr['enr_urn'] = $v->enr_urn;
        		$arr['beneficiary_district_id'] = $district->id;

        		$arr['tpa_claim_reference_number'] = $v->tpa_claim_reference_no;
        
        		$arr['hof_name'] 	= $v->hof_name;
        		$arr['patient_name'] = $v->patient_name;

        		$arr['patient_age'] 	= $v->patient_age;
        		$arr['patient_gender'] 	= $v->patient_gender;
        		$arr['hospital_name'] 	= $v->hospital_name;

        		$arr['hospital_type'] 	= $v->hospital_type;
        		$arr['date_of_admission'] = date('Y-m-d', strtotime( str_replace('/', '-', $v->date_of_admission)));
        		$arr['date_of_discharge'] = date('Y-m-d', strtotime( str_replace('/', '-', $v->date_of_discharge)));

        		$arr['package_code'] 	= $v->package_code;
        		$arr['package_name'] 	= $v->package_name;
        		$arr['diagnosis'] 		= $v->diagnosis;

        		$arr['claim_amount_base'] 		= $v->claimed_amount_base;
        		$arr['approved_amount_base'] 	= $v->approved_amount_base;
        		$arr['approval_date'] 			= date('Y-m-d', strtotime( str_replace('/', '-', $v->approval_date)));

        		$arr['deduction_amount_base'] 	= $v->deduction_amount_base;
        		$arr['deduction_remarks'] 		= $v->deduction_remarks;
        		$arr['tds_amount'] 				= $v->tds_amount;

        		$arr['p_intimation_date'] 		= date('Y-m-d', strtotime( str_replace('/', '-', $v->p_intimation_date)));
        		$arr['claim_upload_date'] 		= date('Y-m-d', strtotime( str_replace('/', '-', $v->claim_upload_date)));
        		$arr['hospital_pan_number'] 	= $v->hospital_pan_number;


        		$arr['hospital_email_id'] 		= $v->hospital_email_id;
        		$arr['hospital_mobile_number'] 	= $v->hospital_mobile_number;
        		$arr['hospital_payee_name'] 	= $v->hospital_payee_name;


        		$arr['payee_bank_name'] 		= $v->payee_bank_name;
        		$arr['payee_branch_address'] 	= $v->payee_branch_address;
        		$arr['payee_account_type'] 		= $v->payee_account_type;

        		$arr['payee_bank_account_number'] 	= $v->payee_bank_account_number;
        		$arr['payee_bank_ifsc_code'] 		= $v->payee_bank_ifsc_code;
        		$arr['utr_date'] = date('Y-m-d', strtotime( str_replace('/', '-', $v->utr_date)));

        		$arr['claim_id'] 		= $v->claim_id;;
        		$arr['float_number'] 	= $v->float_no;
        		$arr['net_payable'] 	= $v->net_payable;

        		$arr['float_generated_date'] 	= date('Y-m-d', strtotime( str_replace('/', '-', $v->float_generated_date)));
        		$arr['float_generated_by'] 		= $v->float_generated_by;
        		$arr['utr_number'] 				= $v->utr_no;

        		ClaimFloat::create($arr);
            }
    	}

    	DB::commit();

    	return Redirect::route('admin.floats.view_all')->with(['message' => 'Floats loaded successfully !', 'alert-class' => 'alert-success']);
    }

    public function index(Request $request) {
    	$results = ClaimFloat::orderBy('created_at', 'DESC')->with('claims_coordinator')->get();
        $claim_coordinators = Claim::where('status', 1)->orderBy('name')->pluck('name', 'id');
    	return view('admin.floats.view_all', compact('results', 'claim_coordinators'));
    }

    public function assignMassFloat(Request $request) {

        if(count($request->assign_float_ids)) {
            $float_ids = $request->assign_float_ids;

            foreach($float_ids as $v) {
                $float = ClaimFloat::find($v);

                $float->assigned_to = $request->claim_id;

                $float->save();
            }
        }

        return Redirect::route('admin.floats.view_all')->with(['message' => 'Floats assigned successfully !', 'alert-class' => 'alert-success']);
    }
}
