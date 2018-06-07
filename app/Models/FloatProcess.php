<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FloatProcess extends Model
{
    protected $fillable = array(
    	'float_id','invoice_from_hospital', 'amount_as_per_package', 'implants', 'travelling_allowance','total_amount', 'deduction','tds_amount','amount_on_billing','processed_by','remarks','can_be_processed'

    );
	protected $table    	= 'float_processes';
    protected $guarded   	= ['_token'];
    public static $rules 	= [
    	'float_id' 				=> 'required|exists:floats,id',
    	'invoice_from_hospital' => 'required',
    	'amount_as_per_package' => 'required',
    	'implants' 				=> 'required',
    	'travelling_allowance' 	=> 'required',
    	'total_amount' 			=> 'required',
    	'deduction' 			=> 'required',
    	'tds_amount' 			=> 'required',
    	'amount_on_billing' 	=> 'required',
    	'processed_by' 			=> 'required',
    	'remarks' 				=> 'required',
    	'can_be_processed' 		=> 'required',
	];

	public function float()
  	{
      return $this->belongsTo('App\Models\Admin\ClaimFloat', 'float_id');
  	}
}
