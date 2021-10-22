<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/',function ()
    {
        return view('home');
    });
});

Route::resource('diseases', DiseaseController::class);
Route::resource('roles', RoleController::class);
Route::resource('predictions', PredictionController::class);
