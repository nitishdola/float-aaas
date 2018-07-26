<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloatNumber extends Model
{
    protected $fillable = array(
    	'name','float_date'

    );

    protected $table    = 'float_numbers';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'name' => 'required',
    	'float_date' => 'required|date_format:Y-m-d'
	];
}
