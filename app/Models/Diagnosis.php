<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = array(
    	'tpa_name', 'enr_urn', 'beneficiary_district_id',
    	'tpa_claim_reference_number', 'hof_name', 'patient_name',
    	'patient_age', 'patient_gender', 'hospital_id',
    	'hospital_type', 'date_of_admission', 'date_of_discharge',
    	'package_code', 'package_name', 'diagnosis_id',
    	'claim_amount_base', 'approved_amount_base', 'approval_date',
    	'deduction_amount_base', 'deduction_remarks', 'tds_amount',
    	'p_intimation_date', 'claim_upload_date', 'hospital_pan_number',
    	'hospital_email_id', 'hospital_mobile_number', 'hospital_payee_name',
    	'payee_bank_name', 'payee_branch_address', 'payee_account_type',
    	'payee_bank_account_number', 'payee_bank_ifsc_code','utr_date',
    	'claim_id', 'float_id', 'net_payable',
    	'float_generated_date', 'float_generated_by', 'utr_number',

    );
	protected $table    = 'floats';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'tpa_name' => 'required',
		'enr_urn' => 'required' ,
	];
}
