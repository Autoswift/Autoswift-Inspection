<?php

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
 Route::get('fcmnotification', 'API\ApiController@fcmnotification');
Route::post('login', 'API\RegisterController@login');
Route::middleware('auth:api')->group( function () {
    Route::get('get_report', 'API\ApiController@get_report');
    Route::get('accounstatus', 'API\ApiController@accounstatus');
    Route::get('get_notification', 'API\ApiController@get_notification');
    Route::post('send_notification','API\ApiController@send_notification');
    Route::post('add_user','API\ApiController@add_user');
    Route::get('get_valuations','API\ApiController@get_valuations');
    Route::get('get_state','API\ApiController@get_state');
    Route::get('get_area','API\ApiController@get_area');
    Route::get('getcompany_area','API\ApiController@getcompany_area');
    Route::post('submit_report','API\ApiController@submit_report');
    Route::post('addfiles_report','API\ApiController@addfiles_report');
    Route::match(['get','post'],'profile','API\ApiController@profile');
   
});
 Route::get('report_status','API\ApiController@report_status');