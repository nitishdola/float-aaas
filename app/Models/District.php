<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = array(
    	'name',

    );
	protected $table    	= 'districts';
    protected $guarded   	= ['_token'];
    public static $rules 	= [
    	'name' => 'required',
	];

}
