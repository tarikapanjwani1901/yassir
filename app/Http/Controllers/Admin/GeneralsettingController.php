<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class GeneralsettingController extends Controller
{
    public function index()
    {  
    	$setting = DB::table('general_setting')->get();
    
    	return view('admin.general_setting')->with('setting',$setting);
    }

    public function edit_setting($id)
    {
    	 $edit = DB::table('general_setting')->where('id',$id)->get();

    	 return view('admin.edit_general_setting')->with('edit',$edit)->with('id',$id);
    }

    public function update_setting(Request $request,$id)
    {
        
    	$update = [
    		'contact_no' => $request->contact_no,
    		'facebook_link' => $request->facebook_link,
    		'twitter_link' => $request->twitter_link,
    		'instagram_link' => $request->instagram_link,
    		'youtube_link' => $request->youtube_link
    	]; 

		DB::table('general_setting')->where('id',$id)->update($update);

		return redirect('admin/general_setting')->with('success','Successfully Data Updated');
    }
}
