<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

Class AboutController extends Controller
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

    	$cms_info = DB::table('cms')->where('id',1)->get();
    	return view('about',compact('cms_info',$cms_info));
    }

     public function view1() {

    	$cms_infop = DB::table('cms')->where('id',2)->get();
    	return view('Privacy_Policy',compact('cms_infop',$cms_infop));
    }

    public function view2() {

    	$cms_infot = DB::table('cms')->where('id',3)->get();
    	return view('Terms_of_use',compact('cms_infot',$cms_infot));
    }

    public function view3() {
        $cms_infos = DB::table('cms')->where('id',4)->get();
        return view('Services',compact('cms_infos',$cms_infos));
    }
}

