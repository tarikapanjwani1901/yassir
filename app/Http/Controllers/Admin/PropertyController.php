<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PropertyList;
use DB;

class PropertyController extends Controller
{
    
	public function index() {
		
		$property_list = DB::table('property_listing')->get();
		return view('admin/manage_property_list',compact('property_list',$property_list));
			 
	}

	public function create_property() {

		return view('admin/add_property_list');
	}

	public function add_property(Request $request) {

		$this->validate($request,[
			'title'=>'required',
			'link'=>'required',
		]);

        $data = [
            'title' => $request->title,
            'link' => $request->link,
        ];

        DB::table('property_listing')->insert($data);

        return redirect('admin/manage_property_list');
	}

	public function delete_property($id) {
    
        DB::table('property_listing')->where('id',$id)->delete();
        
        return 'success';
    }

    public function edit_property($id)
    {

        $edit_data = DB::table('property_listing')
        ->where('id','=',$id)
        ->get();

        return view('admin/edit_property_list')->with('edit_data',$edit_data)->with('id',$id);
    }

    public function update_property(Request $request, $id)
    {
        

        $update_data = [

            'title' => $request->title,
            'link' => $request->link,
        ];

        DB::table('property_listing')
           ->where('id',$id)->update($update_data);
       

        return redirect('admin/manage_property_list')->with('success','Successfully property information updated');
    }   
}
