<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProductListingController extends Controller
{
   public function index() {
		$property_list = DB::table('product_listing')->get();
		return view('admin/manage_product_list',compact('property_list',$property_list));
	}

	public function create_property() {
		return view('admin/add_product_list');
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

        DB::table('product_listing')->insert($data);

        return redirect('admin/manage_product_list');
	}

	 public function delete($id) {
	 	
        DB::table('product_listing')->where('id',$id)->delete();
        
        return 'success';
    }

    public function edit_property($id)
    {

        $edit_data = DB::table('product_listing')
        ->where('id','=',$id)
        ->get();

        return view('admin/edit_product_list')->with('edit_data',$edit_data)->with('id',$id);
    }

    public function update_property(Request $request, $id)
    {
        

        $update_data = [

            'title' => $request->title,
            'link' => $request->link,
        ];

        DB::table('product_listing')
           ->where('id',$id)->update($update_data);
       

        return redirect('admin/manage_product_list')->with('success','Successfully product information updated');
    }   

}
