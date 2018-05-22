<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Claim;
use DB, Validator, Redirect, Auth, Crypt, Hash;
class UsersController extends Controller
{
    public function addUser() {
    	return view('admin.users.add_user');
    }

    public function saveUser(Request $request) {
    	$validator = Validator::make($data = $request->all(), Claim::$rules);
    	if ($validator->fails()) return  Redirect::back()->withErrors($validator)->withInput();

    	$message = $alert_info = '';

    	$data['password'] = bcrypt($request->password);
    	if(Claim::create($data)) {
	      $message    .= 'User created succssfully !';
	      $alert_info .= 'alert-success';
	    }else{
	      $message    .= 'Something went wrong ! User couldn\'t be created';
	      $alert_info .= 'alert-danger';
	    }

	    return Redirect::route('admin.user.view_all')->with(['message' => $message, 'alert-class' => $alert_info]);
    }

    public function index(Request $request) {
    	$users = Claim::orderBy('name')->get();
    	return view('admin.users.view_all', compact('users'));
    }
}
