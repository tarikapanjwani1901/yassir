<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
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

    public function getStates()
    {
        $country_id = 101;
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
}