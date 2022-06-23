<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
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
    return $request->user();
});

Route::post('/login', 'API\ApiAuthController@login'); 
Route::post('/loginVerification', 'API\ApiAuthController@loginVerification'); 
Route::post('/userRegistration', 'API\ApiAuthController@userRegistration'); 
Route::post('/userRegistrationVerification', 'API\ApiAuthController@userRegistrationVerification'); 
Route::post('/ResendOtp', 'API\ApiAuthController@ResendOtp'); 

Route::get('/getUserProfile', 'API\UserController@getUserProfile'); 
Route::post('/updateUserProfile', 'API\UserController@updateUserProfile'); 

Route::get('/dashboard/getVendorProperty', 'API\PropertyController@getVendorProperty'); 

Route::post('/getPropertyDetails', 'API\PropertyController@getPropertyDetails'); 

/*
Route::get("vendor",'AppBaseController@get_vender');
Route::get("user",'AppBaseController@get_user');
Route::get("user/{id}",'AppBaseController@get_user_by_id');
*/



