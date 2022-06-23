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
use Sentinel;

class ApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Login of api user
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
	 public function sendOTP($otp='',$phone='',$flag='')
    {

        if ($flag == 'sendotp') {
            $otpmessage = urlencode("Dear User, ".$otp." is your YasSir Verification code.");
        } else {
            $otpmessage = urlencode($otp);
        }
        
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,'http://sms.incisivewebsolution.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=667810964beb48fcf4f157b070dd89fa&message='.$otpmessage.'&senderId=YASSIR&routeId=1&mobileNos='.$phone.'&smsContentType=english');
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $query;

    }
	
		public function convert_time_by_seconds($interval) {
			if($interval < 0) {
				return false;
			}
			$seconds_n_miliseconds = explode('.', $interval);
			$interval = $seconds_n_miliseconds[0];
		
			$hours = floor($interval / (60*60));
			$minutes = floor(($interval - ($hours*60*60)) / 60);
			$seconds = floor(($interval - ($hours*60*60)) - ($minutes*60));
			$ms = empty($seconds_n_miliseconds[1]) ? 0 : $seconds_n_miliseconds[1];
			return array('h' => $hours, 'm' => $minutes, 's' => $seconds, 'ms' => $ms);
		}

 
    public function ResendOtp(Request $request)
    {

        //valid credential
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        //Send failed response if request is not valid
         if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
        	 return \Illuminate\Support\Facades\Response::json(array('success' => false,'code'    => 442,'message' => $error[0],'data'    => (object) $errors));
		}

       		 $digits = 4;
        	$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
			
			$otpResponse = $this->sendOTP($otp,$request->mobile,'sendotp');
			//$otpResponse ="aaa";
			DB::table('user_otp')->where('mobile', $request->mobile)->delete();
            DB::table('user_otp')->insert(
            ['mobile' => $request->mobile,'otp' => $otp, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'otp_api_response' => $otpResponse ]
            );

			return \Illuminate\Support\Facades\Response::json(array('success' => true,'code'    => 200,'message' => "Otp send successfully.",
			 'data'    => array('otp'=>$otp,'mobile'=>$request->mobile)));
				
		
      }
	  
    public function login(Request $request)
    {

        //valid credential
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        //Send failed response if request is not valid
         if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
        	 return \Illuminate\Support\Facades\Response::json(array('success' => false,'code'    => 442,'message' => $error[0],'data'    => (object) $errors));
		}

        $checkUser = DB::table('users')->select('id')->where('mobile', $request->mobile)->first();

		if(empty($checkUser)){
				return \Illuminate\Support\Facades\Response::json(array(
					'success' => false,
					'code'    => 442,
					'message' => "Sorry invalid mobile number.",
			 		'data'    => array())
				);
		}else{
			$digits = 4;
        	$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
			
			//$otpResponse = $this->sendOTP($otp,$request->mobile,'sendotp');
			$otpResponse ="aaa";
			DB::table('user_otp')->where('mobile', $request->mobile)->delete();
            DB::table('user_otp')->insert(
            ['mobile' => $request->mobile,'otp' => $otp, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'otp_api_response' => $otpResponse ]
            );

			return \Illuminate\Support\Facades\Response::json(array(
				'success' => true,
				'code'    => 200,
				'message' => "Otp send successfully.",
			 	'data'    => array('otp'=>$otp,'mobile'=>$request->mobile)));
				
		}
      }
	  
    public function loginVerification(Request $request)
    {

        //valid credential
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
			'otp'=>'required'
        ]);

        //Send failed response if request is not valid
         if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
        	 return \Illuminate\Support\Facades\Response::json(array('success' => false,'code'    => 442,'message' => $error[0],'data'    => (object) $errors));
		}

        $checkUser = DB::table('users')->select('id','first_name','last_name','user_role')->where('mobile', $request->mobile)->first();
		
		if(empty($checkUser)){
			return \Illuminate\Support\Facades\Response::json(array(
				'success' => false,
				'code'    => 442,
				'message' => "Sorry invalid mobile number.",
			 	'data'    => array()));
			
		}else{	
		
			$getOtp = DB::table('user_otp')->select('otp','created_at')->where('otp', $request->otp)->where('mobile', $request->mobile)->get()->toArray();
			
			if(empty($getOtp)){
					return \Illuminate\Support\Facades\Response::json(
						array(
						'success' => false,
						'code'    => 442,
						'message' => "Sorry invalid otp.",
						'data'    => array()));
			}
			if(!empty($getOtp)){
					$currentDate = date("Y-m-d H:i:s"); 
					$time_diff = strtotime($currentDate) - strtotime($getOtp[0]->created_at);
					$convert_time_by_seconds = $this->convert_time_by_seconds($time_diff);
					
				
					$totalSecond = (($convert_time_by_seconds['h']*60) + $convert_time_by_seconds['m']).".".$convert_time_by_seconds['s'];
						
				if((float)$totalSecond>=5){
					return \Illuminate\Support\Facades\Response::json(array(
						'success' => false,
						'code'    => 442,
						'message' => "Sorry invalid otp.",
						'data'    => array()));
				}else{
					$token = CommonController::generateToken(0);

					$user = User::find($checkUser->id);
					$user->access_token = $token;
					$user->save();

					DB::table('user_otp')->where('mobile', $request->mobile)->delete();
			
					return \Illuminate\Support\Facades\Response::json(array(
						'success' => true,
						'code'    => 200,
						'message' => "Login successful.",
						'data'    => array(
									'user_id' => $checkUser->id,
									'user_type'=>$checkUser->user_role,
									'first_name'=>$checkUser->first_name,
									'last_name'=>$checkUser->last_name,
									'mobile'=>$request->mobile,
									'access_token'=>$token)
								));
				}
			}	
		}
	}

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
	 
    public function vendorRegistration(Request $request) {
        //validate data
        $validator = Validator::make($request->all(), [
            'user_type'     => 'required|string',
            'first_name'     => 'required',
			'last_name'     => 'required',
			'mobile'    => 'required|unique:users,mobile',
			'user_name' => 'required'
        ]);

        //if validation error then return the errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
        	 return \Illuminate\Support\Facades\Response::json(array('success' => false,'code'    => 442,'message' => $error[0],'data'    => (object) $errors));
		}
		
		if($request->user_type!="User" && $request->user_type!="Vendor" && $request->user_type!="Sales"){
			 return \Illuminate\Support\Facades\Response::json(array('success' => false,'code'    => 442,'message' => "Please enter valid user type.",
			 'data'    => array()));
				
		}else{
			
			 $digits = 4;
        	$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
			
			$otpResponse = $this->sendOTP($otp,$request->mobile,'sendotp');
			//$otpResponse ="aaa";
			DB::table('user_otp')->where('mobile', $request->mobile)->delete();
            DB::table('user_otp')->insert(
            ['mobile' => $request->mobile,'otp' => $otp, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'otp_api_response' => $otpResponse ]
            );

			return \Illuminate\Support\Facades\Response::json(array('success' => true,'code'    => 200,'message' => "Otp send successfully.",
			 'data'    => array('otp'=>$otp,'user_type'=>$request->user_type,'first_name'=>$request->first_name,'last_name'=>$request->last_name,'mobile'=>$request->mobile)));
			 
	
		}
        
    }
    
	public function vendorRegistrationVerification(Request $request) {
        //validate data
        $validator = Validator::make($request->all(), [
            'user_type'     => 'required|string',
            'first_name'     => 'required',
			'last_name'     => 'required',
			'otp'     => 'required',
			'mobile'    => 'required|unique:users,mobile',
			'user_name' => 'required'
           // 'image' => 'required',
            
        ]);

        //if validation error then return the errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
        	 return \Illuminate\Support\Facades\Response::json(array('success' => false,'code'    => 442,'message' => $error[0],'data'    => (object) $errors));
		}
		if($request->user_type!="User" && $request->user_type!="Vendor" && $request->user_type!="Sales"){
			return \Illuminate\Support\Facades\Response::json(array(
				'success' => false,
				'code'    => 442,
				'message' => "Please enter valid user type.",
			 	'data'    => array()));
		}else{
		
			$getOtp = DB::table('user_otp')->select('otp','created_at')->where('otp', $request->otp)->where('mobile', $request->mobile)->get()->toArray();
			if(empty($getOtp)){
				return \Illuminate\Support\Facades\Response::json(array(
					'success' => false,
					'code'    => 442,
					'message' => "Sorry invalid otp.",
					'data'    => array()));
			}

			if(!empty($getOtp)){
				$currentDate = date("Y-m-d H:i:s"); 
				$time_diff = strtotime($currentDate) - strtotime($getOtp[0]->created_at);
				$convert_time_by_seconds = $this->convert_time_by_seconds($time_diff);
				
			
				$totalSecond = (($convert_time_by_seconds['h']*60) + $convert_time_by_seconds['m']).".".$convert_time_by_seconds['s'];
						
				if((float)$totalSecond>=5){
					return \Illuminate\Support\Facades\Response::json(array(
						'success' => false,
						'code'    => 442,
						'message' => "Sorry invalid otp.",
						'data'    => array()));
				}else{
			
					if($request->user_type=="Vendor"){
						$user_role = 3;
					}	
						
					if($request->user_type=="Sales"){
						$user_role = 4;
					}
					
					if($request->user_type=="User"){
						$user_role = 5;
					}
			
					DB::table('users')->insert([
						'mobile' => $request->mobile,
						'user_role'=>$user_role,
						'first_name' =>$request->first_name,
						'last_name' =>$request->last_name,
						'user_name' => $request->user_name,
						'created_at' => date('Y-m-d H:i:s'), 
						'updated_at' => date('Y-m-d H:i:s')
						]);

					$id = DB::getPdo()->lastInsertId();;

					if($id>0){
						DB::table('role_users')->insert([
							'user_id' => $id,
							'role_id'=>$user_role, 
							'created_at' => date('Y-m-d H:i:s'), 
							'updated_at' => date('Y-m-d H:i:s')
						]);
					}
		
					return \Illuminate\Support\Facades\Response::json(array(
						'success' => true,
						'code'    => 200,
						'message' => "Your registration has been successful.",
						'data'    => array(
							'user_id'=>$id,
							'otp'=>$request->otp,
							'user_type'=>$request->user_type,
							'first_name'=>$request->first_name,
							'last_name'=>$request->last_name,
							'mobile'=>$request->mobile)));
				}
			}
		}
        
    }

	public function userRegistration(Request $request) {
        //validate data
        $validator = Validator::make($request->all(), [
            'first_name'     => 'required',
			'last_name'     => 'required',
			'mobile'    => 'required|unique:users,mobile'
        ]);

        //if validation error then return the errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
        	return \Illuminate\Support\Facades\Response::json(
				array(
					'success' => false,
					'code'    => 442,
					'message' => $error[0],
					'data'    => (object) $errors
				));
		}
		
		$digits = 4;
		$otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
		
		$otpResponse = $this->sendOTP($otp,$request->mobile,'sendotp');
		//$otpResponse ="aaa";
		DB::table('user_otp')->where('mobile', $request->mobile)->delete();
		DB::table('user_otp')->insert([
			'mobile' => $request->mobile,
			'otp' => $otp, 
			'created_at' => date('Y-m-d H:i:s'), 
			'updated_at' => date('Y-m-d H:i:s'), 
			'otp_api_response' => $otpResponse 
		]);

		return \Illuminate\Support\Facades\Response::json(array(
			'success' => true,
			'code' => 200,
			'message' => "Otp send successfully.",
			'data'    => array(
				'otp'=>$otp,
				'first_name'=>$request->first_name,
				'last_name'=>$request->last_name,
				'mobile'=>$request->mobile
			)));
        
    }

	public function userRegistrationVerification(Request $request) {
        //validate data
        $validator = Validator::make($request->all(), [
            //'user_type'     => 'required|string',
            'first_name'     => 'required',
			'last_name'     => 'required',
			'otp'     => 'required',
			'mobile'    => 'required|unique:users,mobile',
			//'user_name' => 'required'
           // 'image' => 'required',
            
        ]);

        //if validation error then return the errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
			return \Illuminate\Support\Facades\Response::json(array(
				'success' => false,
				'code'    => 442,
				'message' => $error[0],
				'data'    => (object) $errors));
		}
		
		$getOtp = DB::table('user_otp')->select('otp','created_at')->where('otp', $request->otp)->where('mobile', $request->mobile)->get()->toArray();
		
		if(empty($getOtp)){
			return \Illuminate\Support\Facades\Response::json(array(
				'success' => false,
				'code'    => 442,
				'message' => "Sorry invalid otp.",
				'data'    => array()));
		}

		if(!empty($getOtp)){
			$currentDate = date("Y-m-d H:i:s"); 
			$time_diff = strtotime($currentDate) - strtotime($getOtp[0]->created_at);
			$convert_time_by_seconds = $this->convert_time_by_seconds($time_diff);
			
			$totalSecond = (($convert_time_by_seconds['h']*60) + $convert_time_by_seconds['m']).".".$convert_time_by_seconds['s'];
					
			if((float)$totalSecond>=5){
				return \Illuminate\Support\Facades\Response::json(array(
					'success' => false,
					'code'    => 442,
					'message' => "Sorry invalid otp.",
					'data'    => array()));
			}else{
			
				$user_role = 5;
			
				DB::table('users')->insert([
					'mobile' => $request->mobile,
					'user_role'=>$user_role,
					'first_name' =>$request->first_name,
					'last_name' =>$request->last_name,
					'created_at' => date('Y-m-d H:i:s'), 
					'updated_at' => date('Y-m-d H:i:s')
					]);

				$id = DB::getPdo()->lastInsertId();;

				if($id>0){
					DB::table('role_users')->insert([
						'user_id' => $id,
						'role_id'=>$user_role, 
						'created_at' => date('Y-m-d H:i:s'), 
						'updated_at' => date('Y-m-d H:i:s')
					]);
				}
		
				return \Illuminate\Support\Facades\Response::json(array(
					'success' => true,
					'code'    => 200,
					'message' => "Your registration has been successful.",
					'data'    => array(
						'user_id'=>$id,
						'otp'=>$request->otp,
						'user_type'=>$request->user_type,
						'first_name'=>$request->first_name,
						'last_name'=>$request->last_name,
						'mobile'=>$request->mobile
					)));
			}
		}
        
    }
    
}


