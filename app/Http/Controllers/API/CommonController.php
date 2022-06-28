<?php

namespace App\Http\Controllers\API;

use App\Models\Country;
use App\Models\Areas;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
use App\Models\SubCity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;

class CommonController extends Controller
{

    /* Create a new AuthController instance.
    *
    * @return void
    */

    public function __construct() {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function getCountries()
    {
        $country_response = Country::getAllCountries();

        $list = array();
        $i=0;
        if(isset($country_response) && sizeof($country_response)>0){
            foreach($country_response as $k=>$v){
                $list[$i]['id'] = $v->id;
                $list[$i]['name'] = $v->name;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list)
        );
    }

    public function getStates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
        ]);
		  
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $country_id = $request->country_id;

        $state_response = State::getStatesByCountryId($country_id);

        $list = array();
        $i=0;
        if(isset($state_response) && sizeof($state_response)>0){
            foreach($state_response as $k=>$v){
                $list[$i]['id'] = $v->id;
                $list[$i]['name'] = $v->name;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list));
    }

    public function getCities(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->all(), [
            'state_id' => 'required',
        ]);
		  
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $state_id = $request->state_id;

        $city_response = City::getCitiesByStateId($state_id);

        $list = array();
        $i=0;
        if(isset($city_response) && sizeof($city_response)>0){
            foreach($city_response as $k=>$v){
                $list[$i]['id'] = $v->id;
                $list[$i]['name'] = $v->name;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list));
    }

    public function getSubCities(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
        ]);
		  
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $city_id = $request->city_id;

        $sub_city_response = SubCity::getSubCitiesByCityId($city_id);

        $list = array();
        $i=0;
        if(isset($sub_city_response) && sizeof($sub_city_response)>0){
            foreach($sub_city_response as $k=>$v){
                $list[$i]['id'] = $v->id;
                $list[$i]['name'] = $v->name;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list)
        );
    }

    public function getAreas(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->all(), [
            'subcity_id' => 'required',
        ]);
		  
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $subcity_id = $request->subcity_id;

        $area_response = Areas::getAreasBySubCityId($subcity_id);

        $list = array();
        $i=0;
        if(isset($area_response) && sizeof($area_response)>0){
            foreach($area_response as $k=>$v){
                $list[$i]['area_id'] = $v->id;
                $list[$i]['area_name'] = $v->name;
                $list[$i]['area_pincode'] = $v->pincode;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list)
        );
    }

    public static function randomStringGenrator($length = 20)
    {
        $string = '';
        $characters = "123456789ABCDEFHJKLMNPRTVWXYZ";

        for ($p = 0;$p < $length;$p++)
        {
            $string .= $characters[mt_rand(0, strlen($characters) - 1) ];
        }
        return $string;
    }

    public static function generateToken($token_id = 0)
    {
        for($i=1;$i<=100;$i++){
            $token = CommonController::randomStringGenrator(300);
            return $token;
        }
            
        return '';
    }
    
    public static function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization']))
        {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION']))
        { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        }
        elseif (function_exists('apache_request_headers'))
        {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)) , array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization']))
            {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header
     *
     */
    public static function getBearerToken()
    {
        $headers = CommonController::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers))
        {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches))
            {
                return $matches[1];
            }
        }
        return null;
    }
    public static function checkAccessToken(){
        
		$accessToken = CommonController::getBearerToken();
        $checkUser = User::where('access_token',$accessToken)->first();
        if(!empty($checkUser) && $accessToken!=""){
            return CommonController::customAPIResponse(true, 200, 'Token Valid!', ['token' => $accessToken]);
        }else{
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }
    }

    public static function customAPIResponse($status, $code, $message, $data)
    {
        if(!empty($data))
            return \Illuminate\Support\Facades\Response::json(['success' => $status, 'code' => $code, 'message' => $message, 'data' => (object)$data]);
        else
            return \Illuminate\Support\Facades\Response::json(['success' => $status, 'code' => $code, 'message' => $message, 'data' => [] ]);
    }

}