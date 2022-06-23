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

        
        $user = DB::table('users')->select('*')->where('id', $request->user_id)->first();

        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "User not found",
                'data'    => array()
            ));
        
        }else{
            $user_data = array();
            $user_data['id'] = $user->id;
            $user_data['first_name'] = $user->first_name;
            $user_data['last_name'] = $user->last_name;
            $user_data['user_name'] = $user->user_name;
            $user_data['pic'] = $user->pic;
            $user_data['mobile_number'] = $user->mobile;
            $user_data['state_id'] = $user->user_state;
            $user_data['city_id'] = $user->city;
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
        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
           // 'state_id' => 'required',
            //'city_id' => 'required',
            'dob'=>'required',
            'gender'=>'required',
            //'mobile_number' => 'required',
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

        if(isset($request->state_id) && $request->state_id!='')
            $user->user_state = $request->state_id;
        if(isset($request->city_id) && $request->city_id!='')
            $user->city = $request->city_id;

        $user->gender = $request->gender;
        $user->dob = $request->dob  ;
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
