<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use DateTime;


class OTRListingController extends Controller
{
    public function index(Request $request)
		{


      $users_info = DB::table('otr_listing')->orderBy('id','DESC');



    $city_name = $request->input('city_name');  
    $date = $request->input('date');  
    $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();

    $main_category = $request->input('main_category');
    
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

      if ($main_category != 'null' && $main_category != '') {
            $users_info->where("otr_listing.intrested",$main_category);
      }

      if ($city_name != 'null' && $city_name != '') {
            $users_info->where("otr_listing.city",$city_name);

      }


      if ($date != 'null' && $date != '') {
        
           $date_format = new DateTime($date);

          $users_info->whereDate("otr_listing.created_at",$date_format->format('Y-m-d'));

      }

      $category =  DB::table('category')->get();


    $otrListing = $users_info->orderBy('id','DESC')->paginate(10);


		return view('admin.otrlisting')->with('otrListing',$otrListing)->with('category',$category)->with('main_category',$main_category)->with('type',$type)->with('city_name',$city_name);
		}

	public function excel()
    {
  
     $otrListing = DB::table('otr_listing')->get()->toArray();
     $customer_array[] = array('name', 'phone', 'city', 'intrested');
     foreach($otrListing as $customer)
     {
      $customer_array[] = array(
       'name'  => $customer->name,
       'phone'   => $customer->phone,
       'city'    => $customer->city,
       'intrested'  => $customer->intrested
      );
     }
    

      return Excel::download($customer_array, 'users.xlsx');

     

    }
}
