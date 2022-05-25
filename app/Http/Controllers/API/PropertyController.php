<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VendorListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Support\Arr;
use Sentinel;
use Image;

class PropertyController extends Controller
{
    public function __construct() {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function getVendorProperty(Request $request) {
        
        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
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

        // check role of user id is vendor
        $user = DB::table('role_users')->select('role_id')->where('user_id', $request->user_id)->where('role_id',3)->first();
        
        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "Vendor not found",
                'data'    => array()
            ));
        
        }else{
           
            // get property of vendor
            $property = VendorListing::getPropertyByVendor($request->user_id);

            $list = array();
            $i=0;
            if(isset($property) && sizeof($property)>0){
                foreach($property as $k=>$v){
                    $list[$i]['id'] = $v->vl_id;
                    $list[$i]['title'] = $v->l_title;
                    $list[$i]['possession_date'] = $v->possession_date;
                    $list[$i]['address'] = $v->l_location;
                    $list[$i]['price'] = $v->price;
                    $list[$i]['image'] = "public/images/".$v->vl_id."/featured_image/featured_image.jpg";
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
}