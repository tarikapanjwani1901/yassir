<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB ;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Redirect;
use Reminder;
use Sentinel;

Class WishListController extends Controller
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
    public function index(Request $request) {

    	//Purify the value
    	$product = array();
    	$listing = array();

    	if (isset($_COOKIE['listing_value']) && !empty($_COOKIE['listing_value'])) {
    		$list = explode(',', $_COOKIE['listing_value']);

    		foreach ($list as $key => $value) {

                if ($value != ''){
    	    		//Justify
    	    		$result = explode('_', $value);

    	    		if ($result[0] == 'listing') {
    	    			$listing[] = $result[1];
    	    		} else {
    	    			$product[] = $result[1];
    	    		}
                }
	    	}
    	}

    	//Get Product listing results
    	$productRes = array();
    	$listingRes = array();

    	if (!empty($product)) {
            $productRes = DB::table('vendor_listing')
                ->join('product', 'product.v_id', '=', 'vendor_listing.u_id')
                ->whereIn('product.id', $product)
                ->get()->toArray();
    	}

    	//Get Listing results
    	if (!empty($listing)) {
    		$listingRes = DB::table('vendor_listing')
                ->whereIn('vl_id', $listing)
                ->get()->toArray();
    	}

    	$result = array_merge($productRes,$listingRes);

        return view('wishlist')->with('result',$result);
    }
}
