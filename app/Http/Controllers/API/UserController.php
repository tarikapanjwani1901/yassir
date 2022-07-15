<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Support\Arr;
use Sentinel;
use Image;

class UserController extends Controller
{
    public function __construct() {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get User Profile API
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function getUserProfile(Request $request)
    {
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }
        
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

        
        $user = DB::table('users')->select('users.*','areas.pincode')
            ->leftJoin('areas','areas.id','=','users.area_id')
            ->where('users.id', $request->user_id)->first();

        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "User not found",
                'data'    => array()
            ));
        
        }else{
            $user_data = array();
            $user_data['user_id'] = $user->id;
            $user_data['first_name'] = $user->first_name;
            $user_data['last_name'] = $user->last_name;
            $user_data['user_name'] = $user->user_name;
            $user_data['profile_pic'] = "public/uploads/users/".$user->pic;
            $user_data['mobile_number'] = $user->mobile;
            $user_data['country_id'] = (int)$user->country;
            $user_data['state_id'] = (int)$user->user_state;
            $user_data['city_id'] = (int)$user->city;
            $user_data['sub_city_id'] = $user->sub_city_id;
            $user_data['area_id'] = $user->area_id;
            $user_data['gender'] = $user->gender;
            $user_data['dob'] = $user->dob;

            return \Illuminate\Support\Facades\Response::json(array(
                'success' => true,
                'code'    => 200,
                'message' => "Login successful.",
                'data'    => $user_data
            ));
        }
    }


    /**
     * Get User Profile API
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function updateUserProfile(Request $request)
    {
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }
        
        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'dob'=>'required',
            'gender'=>'required',
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

        $user = User::find($request->user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->gender = $request->gender;
        $user->dob = $request->dob;

        if(isset($request->country_id) && $request->country_id!='')
            $user->country = $request->country_id;
        if(isset($request->state_id) && $request->state_id!='')
            $user->user_state = $request->state_id;
        if(isset($request->city_id) && $request->city_id!='')
            $user->city = $request->city_id;
        if(isset($request->sub_city_id) && $request->sub_city_id!='')
            $user->sub_city_id = $request->city_id;
        if(isset($request->area_id) && $request->area_id!='')
            $user->area_id = $request->area_id;
        
        //$user->mobile  = $user->mobile_number;
        
        if($request->hasFile('profile_pic')) {
            if($request->file('profile_pic')!=''){
                $photo = $request->file('profile_pic');
                $imagename = time().'.'.$photo->getClientOriginalExtension(); 
                $destinationPath = public_path('/uploads/users');
                $thumb_img = Image::make($photo->getRealPath())->resize(100, 100);
                $thumb_img->save($destinationPath.'/'.$imagename,80);
                //delete old pic if exists
                $destinationPath = public_path('/normal_images');
                $photo->move($destinationPath, $imagename);
                //save image
                $user->pic = $imagename;
            }
        }
        $user->save();

        return \Illuminate\Support\Facades\Response::json(
            array('success' => true,
            'code'    => 200,
            'message' => "Profile updated successfully",
			'data'    => array())
        );
    }
}
