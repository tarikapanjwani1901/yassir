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
Route::post('/Registration', 'API\ApiAuthController@Registration'); 
Route::post('/RegistrationVerification', 'API\ApiAuthController@RegistrationVerification'); 
Route::post('/userRegistration', 'API\ApiAuthController@userRegistration'); 
Route::post('/userRegistrationVerification', 'API\ApiAuthController@userRegistrationVerification'); 
Route::post('/ResendOtp', 'API\ApiAuthController@ResendOtp'); 

Route::get('/getCountries', 'API\CommonController@getCountries'); 
Route::get('/getStates', 'API\CommonController@getStates'); 
Route::get('/getCities', 'API\CommonController@getCities'); 
Route::get('/getSubCities', 'API\CommonController@getSubCities'); 
Route::get('/getAreas', 'API\CommonController@getAreas'); 

Route::get('/getUserProfile', 'API\UserController@getUserProfile'); 
Route::post('/updateUserProfile', 'API\UserController@updateUserProfile'); 

Route::post('/property/addfavourite', 'API\PropertyController@addFavourite');
Route::post('/property/unfavourite', 'API\PropertyController@unFavourite');
Route::get('/property/getfavourite', 'API\PropertyController@getFavourite');

Route::get('/dashboard/getVendorProperty', 'API\PropertyController@getVendorProperty'); 
Route::get('/getPropertyDetails', 'API\PropertyController@getPropertyDetails');
Route::post('/property/bookvisit', 'API\PropertyController@bookVisit');
Route::get('/user/getUserProperty', 'API\PropertyController@getUserProperty'); 
/*
Route::get("vendor",'AppBaseController@get_vender');
Route::get("user",'AppBaseController@get_user');
Route::get("user/{id}",'AppBaseController@get_user_by_id');
*/



