<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Testimonials;
use App\vendor_listing_review;
use App\vendor_listing;
use DB;
use App\Visitors_search;
use Illuminate\Support\Str;
use File;
use Illuminate\Http\Request;

Class HomePageController extends Controller
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

     public function fetch(Request $request)
    {
      
     if($request->get('query'))
     {
      $query = $request->get('query');

         $vendor = DB::table('vendor_listing')->select('l_title')
        ->where('vendor_listing.l_title', 'LIKE', "%{$query}%");

        $vendor1 = DB::table('vendor_listing')->select('short_title')
        ->where('vendor_listing.short_title', 'LIKE', "%{$query}%");

         $vendor3 = DB::table('vendor_listing')->select('l_key_area')
        ->where('vendor_listing.l_key_area', 'LIKE', "%{$query}%");

        $price = DB::table('vendor_listing')->select('price')
        ->where('vendor_listing.price', 'LIKE', "%{$query}%");

         $skill = DB::table('category_type_skill_labour')->select('name')
        ->where('category_type_skill_labour.name', 'LIKE', "%{$query}%");

         $category_type_material = DB::table('category_type_material')->select('name')
        ->where('category_type_material.name', 'LIKE', "%{$query}%");

         $category_type_consultancy = DB::table('category_type_consultancy')->select('name')
        ->where('category_type_consultancy.name', 'LIKE', "%{$query}%");

          $flats = DB::table('flats')->select('name')
        ->where('flats.name', 'like', '%'.$query.'%');

        $category_type_contractor =  DB::table('category_type_contractor')->select('name')
        ->where('category_type_contractor.name', 'like', '%'.$query.'%');

          $products =  DB::table('product')->select('product_name')
        ->where('product.product_name', 'like', '%'.$query.'%');


        // 'like', '%'.$s_key.'%');

      $data = DB::table('flats')->select('name')
        ->where('flats.name', 'like', '%'.$query.'%')
        //->union($vendor)
       // ->union($skill)
        //->union($vendor1)
        //->union($vendor3)
        //->union($price)
        //->union($flats)
        ->union($category_type_material)
        ->union($category_type_consultancy)
        ->union($category_type_contractor)
        ->union($products)
       
        ->get();

        $test = json_decode($data,true);

    $total_row = $data->count();  
    if($total_row > 0){
      $output = '<ul class="dropdown-menu" style="display:block; width:67%; position:relative;">';

    


      foreach($test as $row)
      {
       $output .= '
       <li class="main_search"><a href="javascript:void(0);">'.implode(' ',$row).'</a></li>
       ';
      }
    }
    else{
        $output = '
        <ul class="dropdown-menu" style="display:block; width:67%; position:relative;">
       <li>
         <?php '.implode(' ',$row).' ?>
       </li>
       </ul>
       ';
    }
    

      $output .= '</ul>';
      echo $output;
     }
    
    }


    public function fetch_old(Request $request)
    {
      
     if($request->get('query'))
     {
      $query = $request->get('query');

         $vendor = DB::table('vendor_listing')->select('l_title')
        ->where('vendor_listing.l_title', 'LIKE', "%{$query}%");

        $vendor1 = DB::table('vendor_listing')->select('short_title')
        ->where('vendor_listing.short_title', 'LIKE', "%{$query}%");

         $vendor3 = DB::table('vendor_listing')->select('l_key_area')
        ->where('vendor_listing.l_key_area', 'LIKE', "%{$query}%");

        $price = DB::table('vendor_listing')->select('price')
        ->where('vendor_listing.price', 'LIKE', "%{$query}%");

         $skill = DB::table('category_type_skill_labour')->select('name')
        ->where('category_type_skill_labour.name', 'LIKE', "%{$query}%");

         $category_type_material = DB::table('category_type_material')->select('name')
        ->where('category_type_material.name', 'LIKE', "%{$query}%");

          $flats = DB::table('flats')->select('name')
        ->where('flats.name', 'like', '%'.$query.'%');

        $category_type_consultancy =  DB::table('category_type_consultancy')->select('name')
        ->where('flats.name', 'like', '%'.$query.'%');

        // 'like', '%'.$s_key.'%');

      $data = DB::table('product')->select('product_name')
        ->where('product.product_name', 'LIKE', "%{$query}%")
        //->union($vendor)
        ->union($skill)
        ->union($vendor1)
        ->union($vendor3)
        ->union($price)
        ->union($flats)
        //->union($category_type_material)
       
        ->get();

        $test = json_decode($data,true);

    $total_row = $data->count();  
    if($total_row > 0){
      $output = '<ul class="dropdown-menu" style="display:block; width:100%; position:relative;">';

    


      foreach($test as $row)
      {
       $output .= '
       <li class="main_search"><a href="javascript:void(0);">'.implode(' ',$row).'</a></li>
       ';
      }
    }
    else{
        $output = '
        <ul class="dropdown-menu" style="display:block; width:100%; position:relative;">
       <li>
        Sorry, No matching results found
       </li>
       </ul>
       ';
    }
    

      $output .= '</ul>';
      echo $output;
     }
    
    }
    
    public function view() {

        //Get the category listing
        $category = DB::table('category')->get()->toArray();

        $visitor_count = DB::table('vendor_inquiry')->get()->count();
       

        //vendor count
        $vendor_count = DB::table('vendor_listing')->get()->count();

        //happy cust
        $happy_cust  = DB::table('vendor_listing_review')
        ->where('l_review','>=',4)->get()->count();
    

        //get city
         $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();

        //Get category_type_properties
        $category_properties = DB::table('category_type_properties')->get()->toArray();

        //Get category_type_material
        $category_material = DB::table('category_type_material')->get()->toArray();

        //Get category_type_contractor
        $category_contractor = DB::table('category_type_contractor')->get()->toArray();

        //Get category_type_consultancy
        $category_consultancy = DB::table('category_type_consultancy')->get()->toArray();
        
        //category_type_skill_labour
        $category_skill_labour = DB::table('category_type_skill_labour')->get()->toArray(); 

        $testimonials=Testimonials::all();

        // $listing = vendor_listing::select('vendor_listing.*','vendor_listing_review.*', DB::raw('sum(vendor_listing_review.l_review) / COUNT(vendor_listing_review.l_id) AS result'))
        //  ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
        //  ->join('activations', 'vendor_listing.u_id', '=', 'activations.user_id')
        //  ->where('activations.completed_at','!=', null)
        //  ->where('vendor_listing.l_featured','=', '1')
        //  ->groupBy('vendor_listing.vl_id')->orderBy('result', 'desc')->limit(4)
        //  ->get();

         //  $listing = vendor_listing::
         //  where('vendor_listing.l_featured','1')
         // ->orderBy('vendor_listing.l_featured','desc')
         // ->get();

         $listing = vendor_listing::select('vendor_listing.*','vendor_listing_review.*',
          DB::raw('sum(vendor_listing_review.l_review) / COUNT(vendor_listing_review.l_id) AS result'))
          ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
         ->where('vendor_listing.l_featured','1')
         ->groupBy('vendor_listing.vl_id')->orderBy('vendor_listing.l_featured', 'DESC')
         ->get();


        //Get the city
        $cityResult = vendor_listing::select('city')->groupBy('city')->orderBy('city', 'ASC')->get();

        $city = array();
        foreach ($cityResult as $key => $value) {
            if (!in_array(ucfirst($value->city), $city)) {
                $city[strtolower($value->city)] = ucfirst($value->city);
            }
        }

        //Get Type values
        $type = $this->getTypeList('1');

        return view('home')->with('vendor_count',$vendor_count)->with('happy_cust',$happy_cust)->with('visitor_count',$visitor_count)->with('city_info',$city_info)->with('category',$category)->with('category_properties',$category_properties)->with('category_material',$category_material)->with('category_contractor',$category_contractor)->with('category_consultancy',$category_consultancy)->with('testimonials',$testimonials)->with('type',$type)->with('listing',$listing)->with('city',$city)->with('category_skill_labour',$category_skill_labour);
    }

    public function getTypeListAjax(Request $request) {
        return $this->getTypeList($request->category);
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

    public function check_phone(Request $request)
    {
     if($request->get('phone'))
     {
      $email = $request->get('phone');
      $data = DB::table("otr_listing")
       ->where('phone', $email)
       ->count();
      if($data > 0)
      {
       echo 'not_unique';
      }
      else
      {
       echo 'unique';
      }
     }
    }

    public function getSelectionInfoAjax(Request $request)
    {
        //Word Count
        if (strlen(trim($request->keyword)) > 2) {
            //Check the key word is belong to material category
            $result = DB::table('system_keywords')
                    ->where('keyword', 'like', '%' . strtolower($request->keyword) . '%')
                    ->groupBy('sub_cate_id')
                    ->orderBy('category_id','desc')
                    ->get()
                    ->toArray();

            if (!empty($result)) {
                return json_encode($result[0]);
            } else {
                return 'false';
            }
        } else {
            return 'no_action';
        }
    }

    public function updateUserOTPInfoAjax($user,$phone,$l_id,Request $request)
    {
        //Generate OTP
        $digits = 4;
        $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);




        //Make the API call and get the OTP and response and update in database
        $otpResponse = $this->sendOTP($otp,$phone,'sendotp');

              $tbl_info = DB::table('front_view_listing')    
                    ->latest()
                    ->get();


     

        DB::table('front_view_listing')->insert(
            ['u_name' => $user,'user_view_status' => NULL,'u_phone' => $phone,'u_OTP' => $otp, 'l_id' => $l_id, 'ip_address' => $request->ip(), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'otp_api_response' => $otpResponse ]
            );


        $reponse = json_decode($otpResponse);
        return ($reponse->responseCode == '3001') ? 'success' : 'error';
    }
    
    public function sendOTP($otp='',$phone='',$flag='')
    {

        if ($flag == 'sendotp') {
            $otpmessage = urlencode("Please use this OTP: ".$otp);
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

    public function updateUserOTPVerifyAjax($otp,$phone,$l_id,Request $request)
    {
        $Check = DB::table('front_view_listing')
                    ->where('u_phone', '=', $phone)
                    ->where('l_id', '=', $l_id)
                    ->where('u_OTP', '=', $otp)
                    ->where('ip_address', '=', $request->ip())
                    ->get()
                    ->toArray();

                    //echo "<pre>"; print_r($Check); exit;

        if (empty($Check)) {
            return 'Invalid OTP! Please try again';
        }
        else if($Check[0]->u_OTP != $otp)
        {
             return 'Invalid OTP! Please try again';
          
        } else {
           
            DB::table('front_view_listing')
            ->where('u_phone', $phone)
            ->update(['user_view_status' => '1']);

            return 'success';
        }

    }


    public function updateViewedCountAjax(Request $request)
    {

        //Get the count
        $l_view = DB::table('vendor_listing')->where('vl_id', $request->input('listing_id'))->pluck('l_view');

        DB::table('vendor_listing')
            ->where('vl_id', $request->input('listing_id'))
            ->update(['l_view' => $l_view[0] + 1]);

        return $l_view[0] + 1;
    }

     public function updateUserOTRInfo(Request $request)
    {

         $update_data = [
          'name' => $request->txtname,
          'phone' => $request->txtnumber,
          'city' =>  $request->txtcity,
          'intrested' => $request->cat,
          'created_at' => date('Y-m-d H:i:s')
        ]; 

     DB::table('otr_listing')->insert($update_data);
     return 'success';
      
    }

    public function visitors_search_data(Request $request){

      $data = new Visitors_search;
        $data->search_keyword = $request->input('search_keyword');
        $data->device = $request->input('device');
        $data->ios = $request->input('ios');
        $data->ip = $request->input('ip');
        $data->save();
      }
}
