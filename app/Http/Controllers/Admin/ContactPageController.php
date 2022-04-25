<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\ContactPages;

class ContactPageController extends Controller
{
    public function index()
    {
    	$contact = DB::table('contact_detail')->get();
        
    	return view('admin.contact_detail')->with('contact',$contact);

    }
	public function create()
	{

		return view('admin.add_contact_detail');
	}

	public function add_contact(Request $request)
    {

    	DB::table('contact_detail')->insert(
            [
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'phone_no' => $request->input('phone_no'),
            'email_id' => $request->input('email_id')
            ]);

    	return redirect('admin/contact_detail');
    }

    public function update_contact(Request $request,$id)
    {

         $update_contact = [
            'description' => $request->description,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
            'email_id' => $request->email_id
        ];

        DB::table('contact_detail')->where('id',$id)->update($update_contact);
    
        return redirect('admin/contact_detail')->with('success','Successfully Contact information updated');
    }

    public function edit_contact($id)
    {
        $edit_data = DB::table('contact_detail')
        ->where('id','=',$id)
        ->get();

        return view('admin.edit_contact_detail')->with('edit_data',$edit_data)->with('id',$id);
    }
}
