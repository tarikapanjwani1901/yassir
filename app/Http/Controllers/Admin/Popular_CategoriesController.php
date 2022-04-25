<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class Popular_CategoriesController extends Controller
{
   public function index() {
			
		$popular_list = DB::table('popular_categories')->get();

		return view('admin/manage_popular_categories',compact('popular_list',$popular_list));
			 
	}

	public function create_popular() {

		return view('admin/add_popular_list');

	}

	public function add_popular(Request $request) {
		//echo "hiii"; exit;
		$this->validate($request,[
			'title'=>'required',
			'link'=>'required',
		]);

        $data = [
            'title' => $request->title,
            'link' => $request->link,
        ];

        DB::table('popular_categories')->insert($data);

        return redirect('admin/manage_popular_categories');
	}

	public function delete($id) {
    
        DB::table('popular_categories')->where('id',$id)->delete();
        
        return 'success';
    }

    public function edit_popular($id)
    {

        $edit_data = DB::table('popular_categories')
        ->where('id','=',$id)
        ->get();

        return view('admin/edit_popular_cate')->with('edit_data',$edit_data)->with('id',$id);
    }

    public function update_popular(Request $request, $id)
    {
        $update_data = [

            'title' => $request->title,
            'link' => $request->link,
        ];

        DB::table('popular_categories')
           ->where('id',$id)->update($update_data);
       

        return redirect('admin/manage_popular_categories')->with('success','Successfully product information updated');
    }   

}
