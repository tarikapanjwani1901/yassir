<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Review;
use App\Visitors_search;
use App\vendor_listing;
use App\vendor_listing_review;
use DB;
use App\Inquiry;
use App\Skill_labor;
use App\skill_memeber;

class ReviewController extends Controller
{
    public function get(Request $request)
    {
        $type = '';

        //Check the category
        $cat = $request->input('s_category');
        //Get the category listing
        $category = DB::table('category')->get()->toArray();
        
        //Check the sub category
        $sub = $request->input('sub_category');
       
        $search = $request->get('search');

        if ($cat != '') {

            switch ($cat) {
                case '1':
                    $type = DB::table('category_type_properties')->get()->toArray();
                    break;
                case '2':
                    $type = DB::table('category_type_consultancy')->get()->toArray();
                    break;
                case '3':
                    $type = DB::table('category_type_contractor')->get()->toArray();
                    break;
                case '4':
                    $type = DB::table('category_type_material')->get()->toArray();
                    break;
                case '5':
                    $type = DB::table('category_type_skill_labour')->get()->toArray();
                    break;    
            }
        }

        //Check the vendor
        $vendor = $request->input('review');

        $result = Inquiry::getVendorInquires($cat,$sub,$vendor,$search,'');



        //Query to get the listing based on the filter
        $showreview = DB::table('vendor_listing')
            ->join('vendor_listing_review', 'vendor_listing.vl_id', '=','vendor_listing_review.l_id' );

        if ($cat != '' && $cat != 'null') {
            $showreview->where("vendor_listing.l_category",$cat);
        }

        if ($sub != 'null' && $sub != '') {
            $showreview->where("vendor_listing.l_sub_category",$sub);
        }

        if ($vendor != 'null' && $vendor != '') {
            $showreview->where("vendor_listing.u_id",$vendor);
        }

         if ($search != 'null' && $search != '') {
            $showreview->where("vendor_listing_review.l_comment",$search);
            $showreview->orWhere("vendor_listing_review.reviewer_name",$search);        }

      
        $showreviewResult = $showreview->orderby('vendor_listing_review.id','DESC')->paginate(10);
        

        return view('admin.reviews',['showreview'=>$showreviewResult,'data'=>$result,'rid'=>$vendor,'category'=>$category,'type' => $type,'sub' => $sub,'cat' => $cat]);
    }

    public function delete_review($id)
    {
        $obj = vendor_listing_review::find($id);
        $obj->delete();
        return 'success';
    }

     public function deleted_skilllabor()
    {   

        $deleted_skilllabor = skill_memeber::onlyTrashed()->join('category_type_skill_labour','category_type_skill_labour.id','=','vendor_listing.l_sub_category')
        ->orderby('Vl_id','DESC')
        ->paginate(10);
          //echo "<pre>"; print_r($deleted_skilllabor); exit;

        return view('admin/deleted_skilllabor',compact('deleted_skilllabor',$deleted_skilllabor));
    }
    

    public function index(Request $request)
    {
       
        $skill_details = DB::table('vendor_listing')->where('l_category','5')
        ->join('category_type_skill_labour','category_type_skill_labour.id','=','vendor_listing.l_sub_category')
        ->orderby('Vl_id','DESC')
        ->where('vendor_listing.deleted_at',null)
        ->paginate(20);

        $area = $request->input('area');
        $city_name = $request->input('city_name');
        $skill_name = $request->input('skill_name');
        $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
        $skill_info = DB::table('category_type_skill_labour')->select('id','name')->orderBy('name')->get();


      return view('admin/manage_skilllabor')
      ->with('skill_details',$skill_details)
      ->with('city_name',$city_name)
      ->with('city_info',$city_info)
      ->with('skill_name',$skill_name)
      ->with('area',$area)
      ->with('skill_info',$skill_info);

    }

    public function manage_skill(Request $request)
    {

       $search = $request->get('skill_search');


        $search_info = DB::table('vendor_listing')->where('l_category','5')
        ->join('category_type_skill_labour','category_type_skill_labour.id','=','vendor_listing.l_sub_category')->where('vendor_listing.deleted_at',null);

        $area = $request->input('area');
        $city_name = $request->input('city_name');
        $skill_name = $request->input('skill_name');
        $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
        $skill_info = DB::table('category_type_skill_labour')->select('id','name')->orderBy('name')->get();

        if ($area != 'null' && $area != '') {
            $search_info->where("vendor_listing.area",$area);
        }
        if ($city_name != 'null' && $city_name != '') {
            $search_info->where("vendor_listing.city",$city_name);
        }

        if ($skill_name != 'null' && $skill_name != '') {
            $search_info->where("vendor_listing.l_sub_category",$skill_name);
        }

        if ($search != '' && $search != 'null') {
            $search_info->where("vendor_listing.first_name",$search);
            $search_info->orwhere("vendor_listing.Phone",$search);
        }


      $skill_details = $search_info->paginate(100);
      return view('admin/manage_skilllabor')
      ->with('skill_details',$skill_details)
      ->with('city_name',$city_name)
      ->with('city_info',$city_info)
      ->with('skill_name',$skill_name)
      ->with('area',$area)
      ->with('skill_info',$skill_info);
    }

    public function delete_skill($id)
    {
        skill_memeber::where('vl_id',$id)->delete();

        return 'success';
    }

    public function restore_skill($id)
    {
        skill_memeber::where('vl_id',$id)->restore();

        return 'success';
    }

    public function create_skill()
    {
        $skill_category = DB::table('category_type_skill_labour')->get();

            
        $skill_city = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();


        return view('admin/add_skill_labor',compact('skill_category',$skill_category,'skill_city',$skill_city));
    }
    public function add_skill(Request $request)
    {
        $add = new Skill_labor();
        $add->l_category = $request->input('l_category');
        $add->l_sub_category = $request->input('l_sub_category');
        $add->first_name = $request->input('first_name');
        $add->last_name = $request->input('last_name');
        $add->u_id = 141;
        $add->other_skill = implode("  , " , $request->input('other_skill'));
        $add->Phone = $request->input('Phone');
        $add->city = $request->input('s_city');
        $add->area = $request->input('area');
        $add->experience_details = $request->input('experience_details');
        $add->age_details = $request->input('age_details');
        $add->adharnumber_details = $request->input('adharnumber_details');
        $add->save();

        return redirect('admin/skill_labors')->with('success','Successfully skill labor information added');
    }

    public function edit_skill($id)
    {

        $data =  Skill_labor::where('vl_id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }    

        $skill_category = DB::table('category_type_skill_labour')->get();
        
        $skill_city = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
        

        $edit_data = DB::table('vendor_listing')
        ->where('vl_id','=',$id)
        ->get();

        return view('admin/edit_skill_labor')->with('edit_data',$edit_data)->with('skill_category',$skill_category)->with('id',$id)->with('skill_city',$skill_city);
    }

    public function update_skill(Request $request, $id)
    {
        

        $update_data = [

            'l_category' => $request->l_category,
            'l_sub_category' => $request->l_sub_category,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'other_skill' => implode(',', $request->other_skill),
            'Phone' => $request->Phone,
            'city' => $request->s_city,
            'area' => $request->area,
            'experience_details' => $request->experience_details,
            'age_details' => $request->age_details,
            'adharnumber_details' => $request->adharnumber_details
        ];

        Skill_labor::where('Vl_id',$id)->update($update_data);
       

        return redirect('admin/skill_labors')->with('success','Successfully skill labor information updated');
    }

    public function visitor_records(Request $request)
    {
        $visitor_records = Visitors_search::latest()->paginate();
        return view('admin.visitor_records')->with('visitor_records',$visitor_records);
    }    
}
