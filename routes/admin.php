<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    return view('admin.home');
})->name('home');

Route::group(['prefix' => 'users'],function (){
	 Route::get('/view-all', ['as' => 'user.view_all', 'middleware' => ['admin'], 'uses' => 'Admin\Users\UsersController@index']);

    Route::get('/create', ['as' => 'user.create', 'middleware' => ['admin'], 'uses' => 'Admin\Users\UsersController@addUser']);
    Route::post('/save', ['as' => 'user.save', 'middleware' => ['admin'], 'uses' => 'Admin\Users\UsersController@saveUser']);
});

Route::group(['prefix' => 'floats'],function (){
	 Route::get('/view-all', ['as' => 'floats.view_all', 'middleware' => ['admin'], 'uses' => 'Admin\Floats\FloatsController@index']);

    Route::get('/create', ['as' => 'floats.create', 'middleware' => ['admin'], 'uses' => 'Admin\Floats\FloatsController@uploadFloatsExcel']);
    Route::post('/save', ['as' => 'floats.save', 'middleware' => ['admin'], 'uses' => 'Admin\Floats\FloatsController@saveFloatsExcel']);

    Route::post('/assign', ['as' => 'assign_float', 'middleware' => ['admin'], 'uses' => 'Admin\Floats\FloatsController@assignMassFloat']);
});

