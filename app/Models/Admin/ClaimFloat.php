<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ClaimFloat extends Model
{
    protected $fillable = array(
    	'tpa_name', 'enr_urn', 'beneficiary_district_id',
    	'tpa_claim_reference_number', 'hof_name', 'patient_name',
    	'patient_age', 'patient_gender', 'hospital_name',
    	'hospital_type', 'date_of_admission', 'date_of_discharge',
    	'package_code', 'package_name', 'diagnosis',
    	'claim_amount_base', 'approved_amount_base', 'approval_date',
    	'deduction_amount_base', 'deduction_remarks', 'tds_amount',
    	'p_intimation_date', 'claim_upload_date', 'hospital_pan_number',
    	'hospital_email_id', 'hospital_mobile_number', 'hospital_payee_name',
    	'payee_bank_name', 'payee_branch_address', 'payee_account_type',
    	'payee_bank_account_number', 'payee_bank_ifsc_code','utr_date',
    	'claim_id', 'float_number', 'net_payable',
    	'float_generated_date', 'float_generated_by', 'utr_number',

    );
	protected $table    = 'floats';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'tpa_name' => 'required',
		'enr_urn' => 'required' ,
		'beneficiary_district_id' => 'required',
		'tpa_claim_reference_number' => 'required|unique:floats,tpa_claim_reference_number', 
		'hof_name' => 'required',
		'patient_name' => 'required',
		'patient_age' => 'required',
		'patient_gender' => 'required', 
		'hospital_name' => 'required',
		'hospital_type' => 'required' ,
		'date_of_admission' => 'required', 
		'date_of_discharge' => 'required',
		'package_code' => 'required',
		'package_name' => 'required',
		'diagnosis' => 'required',
		'claim_amount_base' => 'required' ,
		'approved_amount_base' => 'required', 
		'approval_date' => 'required|date|date_format:Y-m-d',
		'deduction_amount_base' => 'required' ,
		'tds_amount' => 'required',
		'p_intimation_date' => 'required|date|date_format:Y-m-d' ,
		'claim_upload_date' => 'required|date|date_format:Y-m-d' ,
		'hospital_pan_number' => 'required',
		'hospital_email_id' => 'required|email' ,
		'hospital_mobile_number' => 'required' ,
		'hospital_payee_name' => 'required',
		'payee_bank_name' => 'required' ,
		'payee_branch_address' => 'required' ,
		'payee_account_type' => 'required',
		'payee_bank_account_number' => 'required' ,
		'payee_bank_ifsc_code' => 'required',
		'utr_date' => 'date|date_format:Y-m-d',
		'claim_id' => 'required', 
		'float_number' => 'required', 
		'net_payable' => 'required',
		'float_generated_date' => 'required', 
		'float_generated_by' => 'required', 
		'utr_number' => 'required',
    ];


    public function claims_coordinator() {
    	return $this->belongsTo('App\Claim', 'assigned_to');
    }


    public function beneficiary_district() {
    	return $this->belongsTo('App\Models\District', 'beneficiary_district_id');
    }
}
