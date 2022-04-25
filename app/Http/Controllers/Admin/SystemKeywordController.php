<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SystemKeywordController extends Controller
{
	public function report()
	{
		$cat = DB::table('category')->get()->toArray();

		return view('admin.systemkeyword_add')->with('category',$cat);
	}
	public function add_report(Request $r)
	{
		if (isset($_POST['Keyword']) && !empty($_POST['Keyword'])) {
			foreach(explode(',', $_POST['Keyword']) as $value){

				if (trim($value) != ''){
					DB::table('system_keywords')->insert(
		                [
		                 	'category_id' => $_POST['category'],
		                    'sub_cate_id' => $_POST['sub_cat'],
		                    'Keyword' => trim(strtolower($value)),
		                    'created_at'=>date('Y-m-d h:i:s'),
		                    'updated_at'=>date('Y-m-d h:i:s')
		                ]);
				}
			}
		}

		return redirect('admin/system_keyword');
	}

	public function manage_numbers()
	{
		
		$visitor_count = DB::table('number')->get()->toArray();
		return view('admin.number')->with('visitor_count',$visitor_count);
	}

	public function add_numbers(Request $request)
	{
		$id = 1;
			$data = [
				'visitor' => $request->visitor,
				'happy_cust' => $request->happy_cust,
				'vendor' => $request->vendor
			];
			

    DB::table('number')->where('id',1)->update($data);
    return redirect('admin/numbers')->with('success','Successfully records updated');	
		
	}
}
