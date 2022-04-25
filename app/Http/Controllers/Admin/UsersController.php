<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\Mail\Register;
use App\Mail\Restore;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Sentinel;
use URL;
use Validator;
use View;
use DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Image;
use App\Inquiry;
use App\Invoice;

class UsersController extends JoshController
{

    public function index_backup()
    {
       $user = Sentinel::findUserById(2);
//        $activation = Activation::completed($user);
//        return dd($activation);
        // Show the page
        return view('admin.users.index', compact('user'));
    }

    public function index(Request $request)
    {   
        $search = $request->get('users_search');
        $main_category = $request->input('s_category');
        $sub_category = $request->input('sub_category'); 
        $city_name = $request->input('s_city');
        $role_name = $request->input('roles'); 
        $typeProcess = array();
        

        $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
        $role_info = DB::table('roles')->whereNotIn('id',[1])->get();
        $total_users_info = DB::table('users')->get()->count();
         $active_users_info = DB::table('users')->whereNotNull('package_duration')->count();
        $deactive_users_info = DB::table('users')->whereNull('package_duration')->count();
        
        $type = '';
        if ($main_category != '') {
            switch ($main_category) {
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
        }


        if ($main_category != '') {
            $type = Inquiry::getType($main_category);

            foreach ($type as $key => $value) {
                $typeProcess[$value->id] = $value->name;
            }
        }  
             
             
 $users_info = DB::table('users')
->select('users.*','activations.completed','activations.user_id',(DB::raw('CASE WHEN `user_category` = 1 THEN (SELECT name from category_type_properties where `users`.`user_sub_cate` = `category_type_properties`.`id`) WHEN `user_category` = 2 THEN (SELECT name from category_type_consultancy where `users`.`user_sub_cate` = `category_type_consultancy`.`id`) WHEN `user_category` = 3 THEN (SELECT name from category_type_contractor where `users`.`user_sub_cate` = `category_type_contractor`.`id`) WHEN`user_category` = 4 THEN (SELECT name from category_type_material where `users`.`user_sub_cate` = `category_type_material`.`id`) WHEN`user_category` = 5 THEN (SELECT name from category_type_skill_labour where `users`.`user_sub_cate` = `category_type_skill_labour`.`id`) END AS name' )))
->leftjoin('activations','activations.user_id','users.id')
->groupby('activations.user_id')->distinct()
->where('users.deleted_at','=',NULL)
->orderBy('users.id','DESC');




/*
 $users=DB::table('users')->select('users.*','invoice.u_id','invoice.id as invoiceid','invoice.created_at','invoice.expiry_date')
        ->leftjoin('invoice','invoice.u_id','users.id')
        ->orderBy('users.id', 'DESC')->paginate(10);
        return view('admin.invoice.index')->with('users', $users);

        */

 $users_info_backup = DB::table('users')
->select('users.*','activations.completed','activations.user_id',(DB::raw('CASE WHEN `user_category` = 1 THEN (SELECT GROUP_CONCAT(name) from category_type_properties where `users`.`user_sub_cate` = `category_type_properties`.`id`) WHEN `user_category` = 2 THEN (SELECT GROUP_CONCAT(name) from category_type_consultancy where `users`.`user_sub_cate` = `category_type_consultancy`.`id`) WHEN `user_category` = 3 THEN (SELECT GROUP_CONCAT(name) from category_type_contractor where `users`.`user_sub_cate` = `category_type_contractor`.`id`) WHEN`user_category` = 4 THEN (SELECT GROUP_CONCAT(name) from category_type_material where `users`.`user_sub_cate` = `category_type_material`.`id`) WHEN`user_category` = 5 THEN (SELECT GROUP_CONCAT(name) from category_type_skill_labour where `users`.`user_sub_cate` = `category_type_skill_labour`.`id`) END AS name' )))
->join('category','category.id','users.user_category')
->join('activations','activations.user_id','users.id')
->where('users.deleted_at','=',NULL)
->orderBy('users.id','desc');





$users_info1 = DB::table('users')
->select('users.*','activations.completed','activations.user_id',(DB::raw('CASE WHEN `user_category` = 1 THEN (SELECT name from category_type_properties where `users`.`user_sub_cate` = `category_type_properties`.`id`) WHEN `user_category` = 2 THEN (SELECT name from category_type_consultancy where `users`.`user_sub_cate` = `category_type_consultancy`.`id`) WHEN `user_category` = 3 THEN (SELECT name from category_type_contractor where `users`.`user_sub_cate` = `category_type_contractor`.`id`) WHEN`user_category` = 4 THEN (SELECT name from category_type_material where `users`.`user_sub_cate` = `category_type_material`.`id`) WHEN`user_category` = 5 THEN (SELECT name from category_type_skill_labour where `users`.`user_sub_cate` = `category_type_skill_labour`.`id`) END AS name' )))
->join('activations','activations.user_id','users.id')
->groupby('activations.user_id')->distinct()
->where('users.deleted_at','=',NULL)
->orderBy('users.id','desc')->get();




        if ($search != '' && $search != 'null') {
            $users_info->where("users.first_name",$search);
            $users_info->orwhere("users.last_name",$search);
            $users_info->orWhere("users.email",$search);
        }

        if ($main_category != 'null' && $main_category != '') {
            $users_info->where("users.user_category",$main_category);
        }

        if ($sub_category != 'null' && $sub_category != '') {
          
            $users_info->whereRaw("find_in_set(?,users.user_sub_cate)",[$sub_category]);
        }
        if ($city_name != 'null' && $city_name != '') {
            $users_info->where("users.city",$city_name);
        }
        if ($role_name != 'null' && $role_name != '') {
            $users_info->where("users.user_role",$role_name);
        }
         


        $users = $users_info->groupBy('users.id')->paginate(10);
      
       
       
      
        $category =  DB::table('category')->get();
    
         return view('admin.users.index')->with('users',$users)->with('category',$category)->with('type',$type)->with('sub_category',$sub_category)->with('city_info',$city_info)->with('main_category',$main_category)->with('city_name',$city_name)->with('role_info',$role_info)->with('role_name',$role_name)->with('users_info1',$users_info1)->with('typeProcess',$typeProcess)->with('total_users_info',$total_users_info)->with('active_users_info',$active_users_info)->with('deactive_users_info',$deactive_users_info);
    }


   
   public function invoice_detail()
    {               
        $id = Sentinel::getUser()->id;
         $users=DB::table('users')->select('users.*','vendor_listing.u_id','vendor_listing.vl_id','vendor_listing.manual_invoice','invoice.u_id','invoice.created_at','invoice.expiry_date')
        ->leftjoin('invoice','invoice.u_id','users.id')
        ->leftjoin('vendor_listing','vendor_listing.u_id','users.id')
        ->where('users.id',$id)
        ->orderBy('users.id', 'DESC')->distinct('vendor_listing.u_id')->paginate(10);
        return view('admin.invoice.vendor_index')->with('users', $users);
    }



    public function all_vendor()
    {
        $users=DB::table('users')->orderBy('id', 'DESC')->where('user_role','=',3)->get();
        //echo "<pre>"; print_r($users); exit;
        return view('admin.vendor.index')->with('users', $users);
    }

    public function manage_invoice()
    {   
       $users=User::select('users.*','invoice.u_id','invoice.id as invoiceid','invoice.created_at','invoice.expiry_date')
        ->leftjoin('invoice','invoice.u_id','users.id')
        ->orderBy('users.id', 'DESC')->paginate(10);
        return view('admin.invoice.index')->with('users', $users);
    }

    public function get_invoice($id)
    {


        $edit_data = DB::table('users')
        ->select('users.id','users.first_name','users.last_name','invoice.*')
        ->leftjoin('invoice','invoice.u_id','users.id')
        ->where('users.id','=',$id)
        ->get();
     
        return view('admin/invoice/get_invoice')->with('edit_data',$edit_data)->with('id',$id);
    }

   
 public function invoice($id)
    {   


        $edit_data = DB::table('users')
        ->select('users.id','users.first_name','users.last_name','users.company_name','users.address','users.mobile','users.created_at','users.gst_number','invoice.*')
        ->leftjoin('invoice','invoice.u_id','users.id')
        ->where('users.id','=',$id)
        ->get();



        if(empty($edit_data[0]))
        {
          return abort(404);
        }

        $sum_invoice = DB::table('invoice')->where('u_id',$id)->sum('total_price');
        $cgst_total = DB::table('invoice')->where('u_id',$id)->sum('cgst');
        $sgst_total = DB::table('invoice')->where('u_id',$id)->sum('sgst');
        $price_total = DB::table('invoice')->where('u_id',$id)->sum('price');

        //echo "<pre>"; print_r($edit_data); exit;

        return view('admin/invoice')->with('edit_data',$edit_data)->with('id',$id)->with('sum_invoice',$sum_invoice)->with('cgst_total',$cgst_total)->with('sgst_total',$sgst_total)->with('price_total',$price_total);
    }


    public function add_invoice(Request $request, $id)
    {

      $current = Carbon::now();

       $package_duration = $request->input('package_duration');
                 


      $price = $request->price;
      $hsn = $request->hsn;
      $package = $request->input('package');
      $qnty = $request->qnty;
      $cgst =  $request->cgst;
      $sgst = $request->sgst;
      $u_id =  $id;
      $created_at = date('Y-m-d h:i:s');
      $invoice_number = $request->invoice_number;
      $total_price = $request->total;

      if($package_duration == '3 Months'){
            $expiry_date = $current->addDays(91);
      }elseif($package_duration == '6 Months'){
                $expiry_date = $current->addDays(182);
             }
        elseif($package_duration == '12 Months'){
                $expiry_date = $current->addDays(365);
             }

      for($count = 0; $count < count($price); $count++)
      {
       $data = array(
        'price' => $price[$count],
        'invoice_number' => $invoice_number,
          'hsn' => $hsn[$count],
           'package' => $package[$count],
            'qnty' => $qnty[$count],
            'u_id' => $u_id,
            'created_at' => $created_at,
            'total_price' => $total_price[$count],
             'cgst'  => $cgst[$count],
             'sgst' => $sgst[$count],
             'expiry_date' => $expiry_date,
             'package_duration' => $package_duration[$count]
       );
       $insert_data[] = $data; 
      }

    Invoice::insert($insert_data);

        
        $edit_data = DB::table('invoice')
        ->where('id','=',$id)
        ->get();  

        return redirect('admin/manage_invoice')->with('edit_data',$edit_data)->with('id',$id);
    }


    public function all_sales()
    {
        //echo "hii";exit;
        $sales=DB::table('users')->orderBy('id', 'DESC')->where('user_role','=',4)->get();
        //echo "<pre>"; print_r($sales); exit;
        return view('admin.sales.index')->with('sales', $sales);
        //echo "<pre>"; print_r($sales); exit;
    }
      public function all_customer()
    {
        //echo "hii";exit;
        $cust=DB::table('users')->orderBy('id', 'DESC')->where('user_role','=',5)->get();
        //echo "<pre>"; print_r($sales); exit;
        return view('admin.customer.index')->with('cust', $cust);
        //echo "<pre>"; print_r($sales); exit;
    }

      public function delete_invoice($id)
    {
         Invoice::where('id',explode(",",$id))->delete();

         return 'success';
    }

    public function data()
    {
        $users= User::get(['id', 'first_name', 'last_name', 'email','created_at','company_name','user_role']);

        return DataTables::of($users)
            ->editColumn('created_at',function(User $user) {
                return $user->created_at->diffForHumans();
            })
            ->addColumn('status',function($user){
                if($activation = Activation::completed($user)){

                    return 'Activated';} else
                    return 'Pending';

            })
            ->addColumn('user_role',function($user){
                if ($user->user_role == '3') {
                    return 'Vendor';
                } else if ($user->user_role == '4') {
                    return 'Sales Team';
                } else if ($user->user_role == '5'){
                    return 'Customer';
                } else {
                    return 'Admin';
                }
            })
            ->addColumn('actions',function($user) {
                $actions = '<a href='. route('admin.users.show', $user->id) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view user"></i></a>
                            <a href='. route('admin.users.edit', $user->id) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update user"></i></a>';
                if ((Sentinel::getUser()->id != $user->id) && ($user->id != 1)) {
                    $actions .= '<a href='. route('admin.users.confirm-delete', $user->id) .' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create(Request $request)
    {
        // Get all the available groups
        $groups = Sentinel::getRoleRepository()->all();

        $countries = $this->countries;
        
        // Show the page
        return view('admin.users.create', compact('groups', 'countries'));
    }

    /**
     * User create form processing.
     *
     * @return Redirect
     */
    public function store(User $user,Request $request)
    {
        //upload image
        if ($file = $request->file('pic_file')) {
            $extension = $file->extension()?: 'png';
            $destinationPath = public_path() . '/uploads/users/';
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $request['pic'] = $safeName;
        }
        //check whether use should be activated by default or not
        $activate = $request->get('activate') ? true : false;

        try {
            // Register the user
            $user = Sentinel::register($request->except('_token', 'password_confirm', 'group', 'activate', 'pic_file'), $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleById($request->get('group'));
            if ($role) {
                $role->users()->attach($user);
            }
            //check for activation and send activation mail if not activated by default
            if (!$request->get('activate')) {
                // Data to be used on the email view
                $data =[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code])
                ];
                // Send the activation code through email
/*                Mail::to($user->email)
                    ->send(new Register($data));*/
            }

            //Update user role
            User::where('id', $user->id)->update(['user_role' => $request->get('group')]);

            // Activity log for New user create
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('New User Created by '.Sentinel::getUser()->full_name);
            // Redirect to the home page with success menu
            return Redirect::route('admin.users.index')->with('success', trans('users/message.success.create'));

        } catch (LoginRequiredException $e) {
            $error = trans('admin/users/message.user_login_required');
        } catch (PasswordRequiredException $e) {
            $error = trans('admin/users/message.user_password_required');
        } catch (UserExistsException $e) {
            $error = trans('admin/users/message.user_exists');
        }

        // Redirect to the user creation page
        return Redirect::back()->withInput()->with('error', $error);
    }

    /**
     * User update.
     *
     * @param  int $id
     * @return View
     */

    public function edit_vender($id){


 // Get this user groups
        $vendor_edit = DB::table('users')
        ->join('activations','activations.user_id','=','users.id')
        ->where('users.id','=',$id)
        ->get();
     
        // Get a list of all the available groups
        $roles = DB::table('roles')
                    ->get();
        //echo "<pre>"; print_r($roles); exit;

        //$status = Activation::completed($user_info);
        $status = DB::table('activations')->Where('id',$id)->orWhere('completed',0)->get();
        // echo "<pre>"; print_r($vendor_edit); exit;
        $countries = $this->countries;

         //echo "<pre>"; print_r($countries); exit;

        // Show the page
        return view('admin.vendor.edit')->with('vendor_edit',$vendor_edit)->with('status',$status)->with('roles',$roles)->with('countries',$countries)->with('id',$id);
          
    }
    public function edit(Request $request, User $user)
    {

//echo "<pre>"; print_r($user); exit;
        // Get this user groups
        $userRoles = $user->getRoles()->pluck('name', 'id')->all();
        // Get a list of all the available groups
        $roles = Sentinel::getRoleRepository()->all();

        $status = Activation::completed($user);
        //echo "<pre>"; print_r($status); exit;

        $countries = $this->countries;


        $sub_category = $request->input('sub_category');
          $main_category = $request->input('user_category');

        $type = '';
        if ($main_category != '') {

            switch ($main_category) {
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
        }     

        // Show the page
        return view('admin.users.edit', compact('user', 'roles', 'userRoles', 'countries', 'status','main_category','type','sub_category'));
    }

    

    public function update_vendor(Request $request, $id)
    {
        echo $id; exit;
    }
    public function update(User $user, UserRequest $request)
    {   
        try {
             $user->update($request->except('pic_file','password','password_confirm','groups','activate','user_sub_cate'));

            if ( !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            // is new image uploaded?
            if ($photo = $request->file('pic_file')) {
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

            if ($mobile = $request->input('mobile')) {
                 $user->mobile = $mobile;
            }

            if ($package_duration = $request->input('package_duration')) {
                 $user->package_duration = $package_duration;
            }

             $current = Carbon::now();

             if($package_duration == '3 Months'){
                $user->end_date = $current->addDays(91);
             }

             if($package_duration == '6 Months'){
                $user->end_date = $current->addDays(182);
             }

             if($package_duration == '12 Months'){
                $user->end_date = $current->addDays(365);
             }

            if ($gstn = $request->input('gstn')) {
                    $user->gstn = $gstn;
            }  
            //update users set updated_at = '2019-07-10 12:53:21', user_sub_cate = '2,1' where id = 174

            $user_sub_cate = implode(",",$request->input('user_sub_cate'));
            
            $user->user_sub_cate = $user_sub_cate;

            //save record
            $user->save();

            //Update the user role
            DB::table('users')
                ->where('id', $user->id)
                ->update(['user_role' => $request->get('groups')[0]]);

            // Get the current user groups
            $userRoles = $user->roles()->pluck('id')->all();

            // Get the selected groups

            $selectedRoles = $request->get('groups');

            // Groups comparison between the groups the user currently
            // have and the groups the user wish to have.
            $rolesToAdd = array_diff($selectedRoles, $userRoles);
            $rolesToRemove = array_diff($userRoles, $selectedRoles);

            // Assign the user to groups

            foreach ($rolesToAdd as $roleId) {
                $role = Sentinel::findRoleById($roleId);
                $role->users()->attach($user);
            }

            // Remove the user from groups
            foreach ($rolesToRemove as $roleId) {
                $role = Sentinel::findRoleById($roleId);
                $role->users()->detach($user);
            }

            // Activate / De-activate user

            $status = $activation = Activation::completed($user);

            if ($request->get('activate') != $status) {
                if ($request->get('activate')) {
                    $activation = Activation::exists($user);
                    if ($activation) {
                        Activation::complete($user, $activation->code);
                    }else {
                        Activation::create($user);
                        $activation = Activation::exists($user);
                        if ($activation) {
                            Activation::complete($user, $activation->code);
                        }
                    }
                } else {
                    //remove existing activation record
                    Activation::remove($user);
                    //add new record
                    Activation::create($user);
                    //send activation mail
                    $data=[
                        'user_name' =>$user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::exists($user)->code])
                    ];
                    // Send the activation code through email
/*                    Mail::to($user->email)
                        ->send(new Restore($data));*/

                }
            }

            // Was the user updated?
            if ($user->save()) {
                // Prepare the success message
                $success = trans('users/message.success.update');
               //Activity log for user update
                activity($user->full_name)
                    ->performedOn($user)
                    ->causedBy($user)
                    ->log('User Updated by '.Sentinel::getUser()->full_name);
                // Redirect to the user page
                return Redirect::route('admin.users.index', $user)->with('success', $success);
            }

            // Prepare the error message
            $error = trans('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }

        // Redirect to the user page

       return Redirect::route('admin.users.edit', $user);
    }
    public function getDeletedUsers()
    {
        // Grab deleted users
        $users = User::onlyTrashed()->orderby('id','desc')->paginate('10');

        // Show the page
        return view('admin.deleted_users', compact('users'));
    }
    public function getModalDelete($id)
    {
        $model = 'users';
        $confirm_route = $error = null;
        try {
            // Get user information
            $user = Sentinel::findById($id);

            // Check if we are not trying to delete ourselves
            if ($user->id === Sentinel::getUser()->id) {
                // Prepare the error message
                $error = trans('users/message.error.delete');

                return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('admin.users.delete', ['id' => $user->id]);
        return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
    }
    public function destroy($id)
    {
        try {
            // Get user information
            $user = Sentinel::findById($id);
            // Check if we are not trying to delete ourselves
            if ($user->id === Sentinel::getUser()->id) {
                // Prepare the error message
                $error = trans('admin/users/message.error.delete');
                // Redirect to the user management page
                return Redirect::route('admin.users.index')->with('error', $error);
            }
            // Delete the user
            //to allow soft deleted, we are performing query on users model instead of Sentinel model
            User::destroy($id);
            Activation::where('user_id',$user->id)->delete();
            // Prepare the success message
            $success = trans('users/message.success.delete');
            //Activity log for user delete
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User deleted by '.Sentinel::getUser()->full_name);
            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }
    }

    public function getRestore($id)
    {
        try {
            // Get user information
            $user = User::withTrashed()->find($id);
            // Restore the user
            $user->restore();
            // create activation record for user and send mail with activation link
//            $data->user_name = $user->first_name .' '. $user->last_name;
//            $data->activationUrl = URL::route('activate', [$user->id, Activation::create($user)->code]);
            // Send the activation code through email

            $activation = Activation::create($user);

            if ($activation) {
                Activation::complete($user, $activation->code);
            }

//           $data=[
//               'user_name' => $user->first_name .' '. $user->last_name,
//            'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code])
//           ];
//            Mail::to($user->email)
//                ->send(new Restore($data));
//            // Prepare the success message
            $success = trans('users/message.success.restored');
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User restored by '.Sentinel::getUser()->full_name);
            // Redirect to the user management page
            return Redirect::route('admin.deleted_users')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.deleted_users')->with('error', $error);
        }
    }
    public function show($id)
    {
        try {
            // Get the user information
            $user = Sentinel::findUserById($id);
            //get country name
            if ($user->country) {
                $user->country = $this->countries[$user->country];
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }
        // Show the page
        return view('admin.users.show', compact('user'));

    }

    public function passwordreset( Request $request)
    {
        $id = $request->id;
        $user = Sentinel::findUserById($id);
        $password = $request->get('password');
        $user->password = Hash::make($password);
        $user->save();
    }

    public function lockscreen($id){

        if (Sentinel::check()) {
            $user = Sentinel::findUserById($id);
            return view('admin.lockscreen',compact('user'));
        }
        return view('admin.login');
    }

    public function postLockscreen(Request $request){
        $password = Sentinel::getUser()->password;
        if(Hash::check($request->password,$password)){
            return 'success';
        } else{
            return 'error';
        }
    }
}
?>
