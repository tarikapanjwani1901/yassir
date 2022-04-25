<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Redirect;
use Reminder;
use Sentinel;
use DB;
Class LoginController extends Controller
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
    public function view() {

    	if (Sentinel::check()) {
            return Redirect('my-account');
        }
        else
        {
    	return view('login');
    	}
    }
}
