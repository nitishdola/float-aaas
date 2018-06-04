<?php

Route::get('/home', ['as' => 'home', 'middleware' => ['claim'], 'uses' => 'Claims\HomeController@index']);


Route::group(['prefix' => 'claims'],function (){
	 Route::get('/view-info/{float_id}', ['as' => 'floats.view_info', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@viewInfo']);

	 Route::post('/process-float/{float_id}', ['as' => 'floats.process', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@processFloat']);
});
