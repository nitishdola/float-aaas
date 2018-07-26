<?php

Route::get('/home', ['as' => 'home', 'middleware' => ['claim'], 'uses' => 'Claims\HomeController@index']);


Route::group(['prefix' => 'claims'],function (){
	 Route::get('/view-info/{float_id}', ['as' => 'floats.view_info', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@viewInfo']);

	 Route::post('/process-float/{float_id}', ['as' => 'floats.process', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@processFloat']);

	Route::get('/view-fresh-floats', ['as' => 'floats.view_fresh_floats', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@viewFreshFloats']);
	 
});


Route::group(['prefix' => 'float-data'],function (){

	Route::get('/view-info/{float_id}', ['as' => 'float_data.info', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@viewDetailedInfo']);

	Route::get('/{float_id}/edit', ['as' => 'float_data.edit', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@edit']);

	Route::post('/{float_id}/view-info', ['as' => 'float_data.update', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@update']);

	 Route::get('/view', ['as' => 'float_data.view', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@viewAll']);

	 Route::get('/download-excel', ['as' => 'float_data.excel_download', 'middleware' => ['claim'], 'uses' => 'Claims\FloatController@excelExport']);
});