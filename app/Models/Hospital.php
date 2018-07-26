<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = array(
    	'name','hospital_type'

    );

    protected $table    = 'hospitals';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'name' => 'required',
    	'hospital_type' => 'required'
	];
}
