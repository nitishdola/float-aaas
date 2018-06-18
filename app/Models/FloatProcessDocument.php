<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FloatProcessDocument extends Model
{
    protected $fillable = array(
    	'float_process_id','float_requirement_id', 'float_requirement_value',

    );
	   protected $table    	= 'float_process_documents';
    protected $guarded   	= ['_token'];
    public static $rules 	= [
    	'float_process_id' 		     => 'required|exists:float_processes,id',
    	'float_requirement_id' 	   => 'required|exists:float_requirements,id',
    	'float_requirement_value'  => 'required',
	];

	public function float_process()
  	{
      return $this->belongsTo('App\Models\FloatProcess', 'float_process_id');
  	}

  	public function float_requirement()
  	{
      return $this->belongsTo('App\Models\FloatRequirement', 'float_requirement_id');
  	}
}
