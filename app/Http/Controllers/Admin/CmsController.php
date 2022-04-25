<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Cms;
use DB;


class CmsController extends Controller
{
    public function index()
    {
    	$cms_info = DB::table('cms')->get();
    	return view('admin/cms/manage_cms',compact('cms_info',$cms_info));
    }
    public function create_cms()
    {
    	return view('admin/cms/create_cms');
    }

    public function add_cms(Request $request)
    { 
    
        $addddd = [

            'title' => $request->title,
            'description' => $request->description
        ];

        DB::table('cms')->insert($addddd);
       
        return redirect('admin/manage_cms');
    }

    public function active_cms($id)
    {
        DB::table('cms')->where('id', $id)->update(['status' => 'active']);
        return redirect()->back()->with('status', 'Successfully status updated'); 
    }

    public function inactive_cms(Request $request,$id)
    {
       DB::table('cms')->where('id', $id)->update(['status' => 'in-active']);
       return redirect()->back()->with('status', 'Successfully status updated');
    }


     public function edit_cms($id)
    {

      
        $edit_data = DB::table('cms')
        ->where('id','=',$id)
        ->get();

        return view('admin/cms/edit_cms')->with('edit_data',$edit_data)->with('id',$id);
    }

    public function update_cms(Request $request, $id)
    {
        

        $update_data = [

            'title' => $request->title,
            'description' => $request->description
            
        ];

        DB::table('cms')->where('id',$id)->update($update_data);
       

        return redirect('admin/manage_cms');
    } 
}
