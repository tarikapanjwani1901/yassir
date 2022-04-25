<?php

namespace App\Http\Controllers\Admin;

use App\Datatable;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Sentinel;

class BrochureController extends Controller
{
    public function index_backup()
    {   

        $usde = DB::table('users')->select("users.id",'vendor_listing.u_id','vendor_listing.l_title','product.product_name','product.product_img')
        ->join('vendor_listing','vendor_listing.u_id','users.id')
        ->join('product','product.v_id','users.id')
        ->where('users.user_category',4)->groupby('vendor_listing.l_title')->distinct()->get();
       //echo "<pre>"; print_r($usde);
       return view('admin.brochure')->with('usde',$usde);
    }

    public function index()
    {   

        if(Sentinel::inRole('vendor')){
        $ids = Sentinel::getUser()->id;
        $usde = DB::table('users')->select("users.id",'vendor_listing.u_id','vendor_listing.l_title','product.product_name','product.product_img')
        ->join('vendor_listing','vendor_listing.u_id','users.id')
        ->join('product','product.v_id','users.id')
        ->where('users.user_category',4)->where('users.id',$ids)->groupby('vendor_listing.l_title')->distinct()->get();
        
        }else{

        $usde = DB::table('users')->select("users.id",'vendor_listing.u_id','vendor_listing.l_title','product.product_name','product.product_img')
        ->join('vendor_listing','vendor_listing.u_id','users.id')
        ->join('product','product.v_id','users.id')
        ->where('users.user_category',4)->groupby('vendor_listing.l_title')->distinct()->get();
        }
       //echo "<pre>"; print_r($usde);
       return view('admin.brochure')->with('usde',$usde);
    }

    public function data()
    {
        $tables = Datatable::select(['id', 'firstname', 'lastname', 'email']);

        return DataTables::of($tables)
            ->make(true);
    }

    public function get_data(Request $request,$id)
    {
        $data = DB::table('product')->select('product.v_id','product.id','product.product_name','product.product_price','product.product_img','vendor_listing.l_title','vendor_listing.u_id','vendor_listing.l_location','vendor_listing.phone','vendor_listing.vl_id')
        ->join('users','users.id','product.v_id')
        ->join('vendor_listing','vendor_listing.u_id','product.v_id')
        ->where('users.id',$id)->get();
       
        $data_info = DB::table('product')->select('product.v_id','product.id','product.product_name','product.product_price','product.product_img','vendor_listing.l_title','vendor_listing.u_id','vendor_listing.l_location','vendor_listing.phone','product_category.cate_name','vendor_listing.vl_id')
        ->join('users','users.id','product.v_id')
        ->join('vendor_listing','vendor_listing.u_id','product.v_id')
        ->join('product_category','product_category.vendor_id','product.v_id')
        ->where('users.id',$id)->groupby('product_category.cate_name')->distinct()->get();
        
        return view('admin.brochure_data')->with('data',$data)->with('data_info',$data_info);
    }
}
