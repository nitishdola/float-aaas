<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = array(
    	'name',

    );
	protected $table    = 'diagnoses';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'name' => 'required',
	];
}
