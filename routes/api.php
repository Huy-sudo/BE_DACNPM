<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return [
        'status' => '1',
        'code' => '200',
        'data' =>  $request->user()
    ];
});

Route::group(['middleware' => 'auth:api','prefix'=>'report'], function () {
    Route::get('/medicine','reportController@reportMedicine');
});


Route::group(['middleware' => 'auth:api','prefix'=>'prescription'], function () {
    Route::get('/','prescriptionController@index');
    Route::post('/','prescriptionController@create');
    Route::get('/{id}','prescriptionController@detail');
    Route::put('/{id}','prescriptionController@update');
    Route::delete('/{id}','prescriptionController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'prescription-medicine'], function () {
    Route::get('/','medicinePrescriptionController@index');
    Route::post('/','medicinePrescriptionController@create');
    Route::get('/{id}','medicinePrescriptionController@detail');
    Route::put('/{id}','medicinePrescriptionController@update');
    Route::delete('/{id}','medicinePrescriptionController@delete'); 
});

Route::group(['middleware' => 'auth:api','prefix'=>'prescription-detail'], function () {
    Route::get('/','prescriptionDetailController@index');
    Route::post('/','prescriptionDetailController@create');
    Route::get('/{id}','prescriptionDetailController@detail');
    Route::put('/{id}','prescriptionDetailController@update');
    Route::delete('/{id}','prescriptionDetailController@delete'); 
});


Route::group(['middleware' => 'auth:api','prefix'=>'customer'], function () {
    Route::get('/','customerController@index');
    Route::post('/','customerController@create');
    Route::get('/{id}','customerController@detail');
    Route::put('/{id}','customerController@update');
    Route::delete('/{id}','customerController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'inventory'], function () {
    Route::get('/','medicineInventoryController@index');
    Route::post('/','medicineInventoryController@create');
    Route::get('/{id}','medicineInventoryController@detail');
    Route::put('/{id}','medicineInventoryController@update');
    Route::delete('/{id}','medicineInventoryController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'medicine'], function () {
    Route::get('/','medicineController@index');
    Route::post('/','medicineController@create');
    Route::get('/{id}','medicineController@detail');
    Route::put('/{id}','medicineController@update');
    Route::delete('/{id}','medicineController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'disease'], function () {
    Route::get('/','diseaseController@index');
    Route::post('/','diseaseController@create');
    Route::get('/{id}','diseaseController@detail');
    Route::put('/{id}','diseaseController@update');
    Route::delete('/{id}','diseaseController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'symptom'], function () {
    Route::get('/','symptomController@index');
    Route::post('/','symptomController@create');
    Route::get('/{id}','symptomController@detail');
    Route::put('/{id}','symptomController@update');
    Route::delete('/{id}','symptomController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'diseaseSymptom'], function () {
    Route::get('/','diseaseSymptomController@index');
    Route::post('/','diseaseSymptomController@create');
    Route::get('/{id}','diseaseSymptomController@detail');
    Route::put('/{id}','diseaseSymptomController@update');
    Route::delete('/{id}','diseaseSymptomController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'bill'], function () {
    Route::get('/','billController@index');
    Route::post('/','billController@create');
    Route::get('/{id}','billController@detail');
    Route::put('/{id}','billController@update');
    Route::delete('/{id}','billController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'unit'], function () {
    Route::get('/','unitController@index');
    Route::post('/','unitController@create');
    Route::get('/{id}','unitController@detail');
    Route::put('/{id}','unitController@update');
    Route::delete('/{id}','unitController@delete');
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
