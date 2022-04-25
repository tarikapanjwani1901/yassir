<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


Class ServicesDetailController extends Controller
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
    public function view(Request $request) {

    	//Get the category listing
    	$category = DB::table('category')->get()->toArray();

    	//Get Type values
        if ($request->s_cate != '') {
            $type = $this->getTypeList($request->s_cate);
        }

	    //Get search result based on the criteria
	    $result = DB::table('vendor_listing')
            ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->where('vendor_listing.l_category', '=', $request->s_cate)
            ->groupBy('vendor_listing.vl_id')
            ->orderBy('vendor_listing_review.l_review', 'desc');

	        if ($request->s_sub_cate != '') {
	        	$result->where('vendor_listing.l_sub_category', '=', $request->s_sub_cate);
	        }

            if ($request->s_key != '') {
                $result->where('vendor_listing.l_title', 'like', '%'.$request->s_key.'%');
            }

	        if ($request->s_city != '') {
	        	$result->where('users.city', '=', strtolower($request->s_city));
	        } else {
	        	$result->where('users.city', '=', 'ahmedabad');
	        }

            $results = $result->get()->toArray();

    	return view('services_detail')->with('service',$this->services($request->s_cate))->with('service_id',$request->s_cate)->with('category',$category)->with('type',$type)->with('type_id',$request->s_sub_cate)->with('result',$results)->with('city',strtolower($request->s_city));
    }

    public function services($key){
    	$array = array(
    		'1' => 'Properties',
    		'2' => 'Consultancy',
    		'3' => 'Contractor',
    		'4' => 'Material',
            '5' => 'Skill labour'
    	);

    	return $array[$key];
    }

    public function getTypeListAjax(Request $request) {
    	return $this->getTypeList($request->category);
    }

    public function getTypeList($type_id) {

        switch ($type_id) {
            case '1':
                $type = DB::table('category_type_properties')->orderBy('name')->get()->toArray();
                break;
            case '2':
                $type = DB::table('category_type_consultancy')->orderBy('name')->get()->toArray();
                break;
            case '3':
                $type = DB::table('category_type_contractor')->orderBy('name')->get()->toArray();
                break;
            case '4':
                $type = DB::table('category_type_material')->orderBy('name')->get()->toArray();
                break;
            case '5':
                $type = DB::table('category_type_skill_labour')->orderBy('name')->get()->toArray();
                break;    
        }

        return $type;
    }

    public function getCityList(Request $request)
    {
        $cities = DB::table("pincode")
        ->where("City_Name",$request->City_Id)
        ->orderBy('Area')
        ->pluck("Area","Area");
        return response()->json($cities);
    }

}
