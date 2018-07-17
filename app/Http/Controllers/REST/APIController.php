<?php

namespace App\Http\Controllers\REST;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    public function getData(Request $request) {
    	$ccn = $request->ccn;

    	$url = "http://mdiaaasnc.mdindia.com:8088/api/aaasnc/GetCCNData?&ccn=".$ccn;
    	$result = file_get_contents($url);
		$arr = json_decode($result);

		$arr = json_decode($arr);
	
		$data = [];
		foreach ($arr as $k => $v) { 
		  $data['urn'] = $v->urn;
		  $data['ccn'] = $v->CCN;
		  $data['patient_name'] 	= $v->patient_name;
		  $data['patient_gender'] 	= $v->patient_gender;
		  $data['category'] 		= $v->CategoryName;
		  $data['sum_assured'] 		= $v->sum_assured;
		}
		return json_encode($data);
    }
}
