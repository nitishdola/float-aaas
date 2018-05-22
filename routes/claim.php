<?php

Route::get('/home', ['as' => 'home', 'middleware' => ['claim'], 'uses' => 'Claims\HomeController@index']);


Route::group(['prefix' => 'claims'],function (){
	 Route::get('/view-info/{claim_id}', ['as' => 'floats.view_info', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@viewInfo']);
});
