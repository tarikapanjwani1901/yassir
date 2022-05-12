<?php

namespace App\Http\Controllers\Admin;

use App\VendorListing;
use App\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Product;
use DB;
use Sentinel;
use Image;
use File;
use App\Skill_labor;

ini_set("memory_limit","10240M");

class VendorListingController extends Controller
{
    public function index(Request $request)
    {

        //Set the default variable
        $cate = '';
        $subCate = '';
        $vendor = '';
        $listing = '';
        $type = '';
        $ven = '';
        $venListing = '';
        $vendorList = '';
        $city = '';
        $area = '';
        $viewFile = 'admin.vendorlisting';
        $typeProcess = array();

        if ($request->query('category')) {

            $cate = $request->input('category');
            $subCate = $request->input('sub_cat');
            $vendor = $request->input('vendor');
            $listing = $request->input('listing');
            $city = $request->input('city');
            $area = $request->input('area');

            //Get the vendors based on the filters
            $ven = Inquiry::getVendorInquires($cate,$subCate,$vendor,$listing,$city,$area);

            //Get the vendor listing based on the filters
            $venListing = Inquiry::getVendorListing($cate,$subCate,$vendor,$city,$area);

            //Grab all the inquires
            $vendorList = VendorListing::getAllListing($cate,$subCate,$vendor,$listing,$city,$area);

        }

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        //Grab system category
        $category = Inquiry::getCategorys();

        //Get the Type if category is set
        if ($cate != '') {
            $type = Inquiry::getType($cate);

            //Decide the view file name
            $viewFile = VendorListing::viewFile($cate);

            //Process the type
            foreach ($type as $key => $value) {
                $typeProcess[$value->id] = $value->name;
            }
        }

        if (Sentinel::inRole('vendor')) {
            $vendorList = VendorListing::getAllListing($cate,$subCate,Sentinel::getUser()->id,$listing);
            $type = Inquiry::getType(Sentinel::getUser()->user_category);

            foreach ($type as $key => $value) {
                $typeProcess[$value->id] = $value->name;
            }
        }

        // $city_info = DB::table('pincode')->get()->toArray();
         $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
          $area_info = DB::table('pincode')->groupby('City_Id')->distinct()->get();  

        $total_properties  = DB::table('vendor_listing')->where('l_category',1)->where('l_sub_category',2)->get()->count(); 

        $total_consultancy  = DB::table('vendor_listing')->where('l_category',2)->get()->count(); 

        $total_contractor  = DB::table('vendor_listing')->where('l_category',3)->get()->count();
        $total_material  = DB::table('vendor_listing')->where('l_category',4)->get()->count(); 
       
        
         return view('admin.vendorlisting')->with('area_info',$area_info)->with('city_info',$city_info)->with('vendors',$vendors)->with('category',$category)->with('vendorList',$vendorList)->with('cate',$cate)->with('subCate',$subCate)->with('vendor',$vendor)->with('listing',$listing)->with('type',$type)->with('ven',$ven)->with('venListing',$venListing)->with('typeProcess',$typeProcess)->with('city',$city)->with('total_properties',$total_properties)->with('total_consultancy',$total_consultancy)->with('total_contractor',$total_contractor)->with('total_material',$total_material);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_backup(Request $request)
    {
        //Store new listing
        VendorListing::storeListing();

        return redirect('admin/vendorlisting');
    }

    public function create(Request $request,$vl_id="")
    {
        //Store new listing
        //VendorListing::storeListing();

      $type1 = $_POST['super_area']['type'][0];
        if(isset($_POST['sub']))
        {
            $ans= implode(',',$_POST['sub']);
        }
        else if(isset($_POST['sub_cat']))
        {
            $ans=$_POST['sub_cat'];
        }

        $path = public_path().'/images/logo/' . $vl_id;

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

        $image = request()->file('logo');

            if ($image) {   
                    $photos = $request->file('logo');    
                    $imagename = $photos->getClientOriginalName();  
                    $destinationPath = public_path().'/images/logo/'. $vl_id;
                    $thumb_img = Image::make($photos->getRealPath())->resize(100, 100);
                    $thumb_img->save($destinationPath.'/'.$imagename,80);    
            
          

        $file=trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['video']['name']))));
        //Store the entire
        $bd = (isset($_POST['bedroom'][$type1][0]) && ($_POST['bedroom'][$type1][0] != "")) ? json_encode($_POST['bedroom']) : '';
        $val = str_replace("\\", "",$bd);
        $vl_id = DB::table('vendor_listing')->insertGetId(
                    [
                        'u_id' => $_POST['vendor'],
                        'p_id' => '4',
                        'l_title' => $_POST['project_name'],
                        'url_name'=>$_POST['url_name'],
                        'l_location' => $_POST['address'],
                        'l_nearby' => $_POST['near_by'],
                        'l_description' => $_POST['about_project'],
                        'rera_number' => $_POST['rera_number'],
                        'rera_link' => $_POST['rera_link'],
                        'price' => $_POST['price'],
                        'price_perft' => $_POST['price_perft'],
                        'short_title' => $_POST['p_short'],
                        'bedroom' => (isset($_POST['bedroom'][$type1][0]) && ($_POST['bedroom'][$type1][0] != "")) ? json_encode($_POST['bedroom']) : '',
                        //'bedroom' => str_replace('""', '"',$val),
                        'bathroom' => (isset($_POST['bathrooms'][$type1][0]) && ($_POST['bathrooms'][$type1][0] != "")) ? json_encode($_POST['bathrooms']) : '',
                        'super_area' => (isset($_POST['super_area'][$type1][0]) && ($_POST['super_area'][$type1][0] != "")) ? json_encode($_POST['super_area']) : '',
                        'carpet_area' => (isset($_POST['carpet_area'][$type1][0]) && ($_POST['carpet_area'][$type1][0] != "")) ? json_encode($_POST['carpet_area']) : '',
                        'status' => $_POST['p_status'],
                        'floor' => $_POST['floor'],
                        'type' => (isset($_POST['transaction_type'][$type1][0]) && ($_POST['transaction_type'][$type1][0] != "")) ? json_encode($_POST['transaction_type']) : '',
                        'car_parking'=> $_POST['car_parking'],
                        'furnishing' => $_POST['furnishing'],
                        'possession_date' => $_POST['possession_date'],
                        'tower' => $_POST['tower'],
                        'listed_by' => 'Admin',
                        'l_category' => $_POST['category'],
                        'product_category' => (isset($_POST['product_category'])) ? implode(',',$_POST['product_category']) : '',
                        'l_sub_category' => $ans,
                        'l_status' => '1',
                        'city' => $_POST['city'],
                        'area' => $_POST['area'],
                        'experience_details' => $_POST['experience_details'],
                        'age_details' => $_POST['age_details'],
                        'adharnumber_details' => $_POST['adharnumber_details'],
                        'Zip_Code' => $_POST['Zip_Code'],
                        'l_key_area' => $_POST['pro_tags'],
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'first_name' => $_POST['first_Name'],
                        'last_name' => $_POST['last_Name'],
                        'email' => $_POST['email'],
                        'Phone' => $_POST['phone_Number'],
                        'website' => $_POST['website'],
                        'facebook' => $_POST['face_book'],
                        'youtube' => $_POST['you_tube'],
                        'l_video_link' => $_POST['l_video_link'],
                        'achievements' => $_POST['achievements'],
                        'past_projects' => $_POST['past_project'],
                        'current_project' => $_POST['current_project'],
                        'amenities' => $_POST['pro_amenities'],
                        'working_hr' => isset($_POST['workinghrs']) ? implode(',',$_POST['workinghrs']) :  '',
                        'working_time' => $_POST['working_time'],
                        'l_featured' => (isset($_POST['l_feature']) && $_POST['l_feature'] == 'on') ? '1' : '0',
                        'shop_price' => $_POST['shop_price'],
                        'shop_area' => $_POST['shop_area'],
                        'shop_washroom' => $_POST['shop_washroom'],
                        'shop_floor' => $_POST['shop_floor'],
                        'shop_car_parking' => $_POST['shop_car_parking'],
                        'logo' => $imagename
                    ]);
            }else{
                $bd = (isset($_POST['bedroom'][$type1][0]) && ($_POST['bedroom'][$type1][0] != "")) ? json_encode($_POST['bedroom']) : '';
                $val = str_replace("\\", "",$bd);
                 $vl_id = DB::table('vendor_listing')->insertGetId(
                    [
                        'u_id' => $_POST['vendor'],
                        'p_id' => '4',
                        'l_title' => $_POST['project_name'],
                        'url_name'=>$_POST['url_name'],
                        'l_location' => $_POST['address'],
                        'l_nearby' => $_POST['near_by'],
                        'l_description' => $_POST['about_project'],
                        'rera_number' => $_POST['rera_number'],
                        'rera_link' => $_POST['rera_link'],
                        'price' => $_POST['price'],
                        'price_perft' => $_POST['price_perft'],
                        'short_title' => $_POST['p_short'],
                        //'bedroom' => str_replace('""', '"',$val),
                        'bedroom' => (isset($_POST['bedroom'][$type1][0]) && ($_POST['bedroom'][$type1][0] != "")) ? json_encode($_POST['bedroom']) : '',
                        'bathroom' => (isset($_POST['bathrooms'][$type1][0]) && ($_POST['bathrooms'][$type1][0] != "")) ? json_encode($_POST['bathrooms']) : '',
                        'super_area' => (isset($_POST['super_area'][$type1][0]) && ($_POST['super_area'][$type1][0] != "")) ? json_encode($_POST['super_area']) : '',
                        'carpet_area' => (isset($_POST['carpet_area'][$type1][0]) && ($_POST['carpet_area'][$type1][0] != "")) ? json_encode($_POST['carpet_area']) : '',
                        'status' => $_POST['p_status'],
                        'floor' => $_POST['floor'],
                        'type' => (isset($_POST['transaction_type'][$type1][0]) && ($_POST['transaction_type'][$type1][0] != "")) ? json_encode($_POST['transaction_type']) : '',
                        'car_parking'=> $_POST['car_parking'],
                        'furnishing' => $_POST['furnishing'],
                        'possession_date' => $_POST['possession_date'],
                        'tower' => $_POST['tower'],
                        'listed_by' => 'Admin',
                        'l_category' => $_POST['category'],
                        'product_category' => (isset($_POST['product_category'])) ? implode(',',$_POST['product_category']) : '',
                        'l_sub_category' => $ans,
                        'l_status' => '1',
                        'city' => $_POST['city'],
                        'area' => $_POST['area'],
                        'experience_details' => $_POST['experience_details'],
                        'age_details' => $_POST['age_details'],
                        'adharnumber_details' => $_POST['adharnumber_details'],
                        'Zip_Code' => $_POST['Zip_Code'],
                        'l_key_area' => $_POST['pro_tags'],
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'first_name' => $_POST['first_Name'],
                        'last_name' => $_POST['last_Name'],
                        'email' => $_POST['email'],
                        'Phone' => $_POST['phone_Number'],
                        'website' => $_POST['website'],
                        'facebook' => $_POST['face_book'],
                        'youtube' => $_POST['you_tube'],
                        'l_video_link' => $_POST['l_video_link'],
                        'achievements' => $_POST['achievements'],
                        'past_projects' => $_POST['past_project'],
                        'current_project' => $_POST['current_project'],
                        'amenities' => $_POST['pro_amenities'],
                        'working_hr' => isset($_POST['workinghrs']) ? implode(',',$_POST['workinghrs']) :  '',
                        'working_time' => $_POST['working_time'],
                       
                        'l_featured' => (isset($_POST['l_feature']) && $_POST['l_feature'] == 'on') ? '1' : '0',
                        'shop_price' => $_POST['shop_price'],
                        'shop_area' => $_POST['shop_area'],
                        'shop_washroom' => $_POST['shop_washroom'],
                        'shop_floor' => $_POST['shop_floor'],
                        'shop_car_parking' => $_POST['shop_car_parking']
                   ]);    
            }

            
            //gallery image
            $path1 = public_path().'/images/' . $vl_id.'/pics';

            if (!file_exists($path1))
            {
                mkdir($path1, 0777, true);
            }

           // $target_path = $path.'/' . "gallery_image.jpg";

            if($_POST['category'] == 1 || $_POST['category'] == 2 || $_POST['category'] == 3){
            if ($photo = $request->file('inputFile')) {

            foreach ($photo as  $photos1) {

                $imagename = $photos1->getClientOriginalName();  
                $destinationPath = public_path().'/images/'. $vl_id.'/pics';
                $thumb_img = Image::make($photos1->getRealPath())->resize(500, 500);
                $thumb_img->save($destinationPath.'/'.$imagename,80);
            }
           }
        }

            //feature image
        
            $path = public_path().'/images/' . $vl_id.'/featured_image';

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            $target_path = $path.'/' . "featured_image.jpg";

            $photo = $request->file('featured_image');
            $imagename = $photo->getClientOriginalName();  
            $destinationPath = public_path().'/images/'. $vl_id.'/featured_image';
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 300);
            //$thumb_img->save($target_path);
             $thumb_img->save($target_path);

            //banner image
            $path = public_path().'/images/' . $vl_id.'/banner';

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            //$target_path = $path.'/' . "banner_image.jpg";

            $photos = $request->file('banner');

            foreach ($photos as  $photoss) {

                $imagename = $photoss->getClientOriginalName();  
                $destinationPath = public_path().'/images/'. $vl_id.'/banner';
                $thumb_img = Image::make($photoss->getRealPath())->resize(1140, 350);
                $thumb_img->save($destinationPath.'/'.$imagename,80);
            }

            //Update brochure name in database
            DB::table('vendor_listing')
                ->where('vl_id', $vl_id)
                ->update(['l_brochure' => trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['brochure']['name']))))]);
        

        return redirect('admin/vendorlisting');
    }

   
    public function store(Request $request)
    {
        //Filter post method call index function
        return $this->index($request);
    }

   
    public function show(VendorListing $vendorListing)
    {
        //Grab system category
        $category = Inquiry::getCategorys();

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        //city
        //$city_info = DB::table('pincode')->groupby('City_Id')->distinct()->get();
        $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();

        
        if (Sentinel::inRole('vendor')) {
            $type = Inquiry::getType(Sentinel::getUser()->user_category);
        }
        

        return view('admin.vendorlisting_add',compact('category','vendors','city_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function edit($id,VendorListing $vendorListing)
    {

       
        $data =  Skill_labor::where('vl_id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }  

        //Grab the all the information from the table
         $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
         //echo "<pre>"; print_r($city_info); exit;
         
        $lisitngs = VendorListing::getVendorListing($id);
        //print_r($lisitngs);exit;
        if (!empty($lisitngs) && $lisitngs->l_category == 1 ) {


            //Process the listing
            $lisitng = array();
            $fieldArray = array('super_area','carpet_area','type','bedroom','bathroom');

            foreach ($lisitngs as $key => $value) {
                if(in_array($key, $fieldArray)) {
                    //Decode json
                    $val = json_decode($value,true);
                    //print_r($value);
                    foreach ($val['type'] as $k => $v) {

                        foreach ($val[$v] as $kv => $vv) {
                            $lisitng['prop'][$key][$v][] = $vv;
                        }

                    }

                } else {
                    $lisitng[$key] = $value;
                }
            }

            $lisitng = (object)$lisitng;
        }else{
             $lisitng = $lisitngs;
        }

        //print_r($lisitng);exit;
        $detail = DB::table('vendor_listing')
                        ->where('vl_id','=',$id)
                        ->get();

        //Grab system category
        $category = Inquiry::getCategorys();

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        //Get the Type if category is set
        $type = Inquiry::getType($lisitng->l_category);

        //Get the product category
        $proCate =  VendorListing::getVendorProductCategory($lisitng->l_category,$lisitng->u_id);

        return view('admin.vendorlisting_edit')->with('city_info',$city_info)->with('category',$category)->with('lisitng',$lisitng)->with('vendors',$vendors)->with('type',$type)->with('proCate',$proCate)->with('detail',$detail);


        //return view('admin.vendorlisting_edit',compact('category','lisitng','vendors','type','proCate'))->with('city_info',$city_info);
    }

    public function update_backup(Request $request, VendorListing $vendorListing)
    {
        $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();
        $vendorListing->updateListing();

        return redirect('admin/vendorlisting')->with('city_info',$city_info)->with('message', 'Success: Product was successfully updated.');
    }


    public function update(Request $request,$vl_id)
    {
        if(isset($_POST['sub']) && $_POST['sub'] != "")
            {
                $ans= implode(',',$_POST['sub']);
            }
           else if(isset($_POST['sub_cat']) && $_POST['sub_cat'] != "")
            {
                $ans = $_POST['sub_cat'];
            }

        $path = public_path().'/images/logo/' . $vl_id;

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            $image = request()->file('logo');

            if ($image) {   
                    $photos = $request->file('logo');    
                    $imagename = $photos->getClientOriginalName();  
                    $destinationPath = public_path().'/images/logo/'. $vl_id;
                    $thumb_img = Image::make($photos->getRealPath())->resize(100, 100);
                    $thumb_img->save($destinationPath.'/'.$imagename,80);


        $bed = (isset($_POST['bedroom'])) ? json_encode($_POST['bedroom']) : '';
        $vals = str_replace("\\", "",$bed);            
           
        DB::table('vendor_listing')
            ->where('vl_id', $_POST['vl_id'])
            ->update(            [
                'u_id' => $_POST['vendor'],
                'p_id' => '4',
                'l_title' => $_POST['project_name'],
                'url_name'=>$_POST['url_name'],
                'l_location' => $_POST['address'],
                'l_nearby' => $_POST['near_by'],
                'l_description' => $_POST['about_project'],
                'rera_number' => $_POST['rera_number'],
                 'rera_link' => $_POST['rera_link'],
                'price' => $_POST['price'],
                'price_perft' =>  $_POST['price_perft'],
                'short_title' => $_POST['p_short'],
                 //'bedroom' => $vals,
                'bedroom' => (isset($_POST['bedroom'])) ? json_encode($_POST['bedroom']) : '',
                'bathroom' => (isset($_POST['bathrooms'])) ? json_encode($_POST['bathrooms']) : '',
                'super_area' => (isset($_POST['super_area'])) ? json_encode($_POST['super_area']) : '',
                'carpet_area' => (isset($_POST['carpet_area'])) ? json_encode($_POST['carpet_area']) : '',
                'status' => $_POST['p_status'],
                'floor' => $_POST['floor'],
                'type' => (isset($_POST['transaction_type'])) ? json_encode($_POST['transaction_type']) : '',
                'car_parking'=> $_POST['car_parking'],
                'furnishing' => $_POST['furnishing'],
                'possession_date' => $_POST['possession_date'],
                'tower' => $_POST['tower'],
                'listed_by' => 'Admin',
                'l_category' => $_POST['category'],
                'product_category' => (isset($_POST['product_category'])) ? implode(',',$_POST['product_category']) : '',
                'l_sub_category' => $ans,
                'city' => $_POST['city'],
                 'area' => $_POST['area'],
                 'experience_details' => $_POST['experience_details'],
                'age_details' => $_POST['age_details'],
                'adharnumber_details' => $_POST['adharnumber_details'],
                'Zip_Code' => $_POST['Zip_Code'],
                'l_key_area' => $_POST['pro_tags'],
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'first_name' => $_POST['first_Name'],
                'last_name' => $_POST['last_Name'],
                'email' => $_POST['email'],
                'Phone' => $_POST['phone_Number'],
                'website' => $_POST['website'],
                'facebook' => $_POST['face_book'],
                'youtube' => $_POST['you_tube'],
                'l_video_link' => $_POST['l_video_link'],
                'achievements' => $_POST['achievements'],
                'past_projects' => $_POST['past_project'],
                'current_project' => $_POST['current_project'],
                'amenities' => $_POST['pro_amenities'],
                'working_hr' => implode(',',$_POST['workinghrs']),
                'working_time' => $_POST['working_time'],
                'l_featured' => (isset($_POST['l_feature']) && $_POST['l_feature'] == 'on') ? '1' : '0',
                'l_prime' => (isset($_POST['l_prime']) && $_POST['l_prime'] == 'on') ? '1' : '0',
                'shop_price' => $_POST['shop_price'],
                'shop_area' => $_POST['shop_area'],
                'shop_washroom' => $_POST['shop_washroom'],
                'shop_floor' => $_POST['shop_floor'],
                'shop_car_parking' => $_POST['shop_car_parking'],
                'logo' => $imagename ]);
             // return redirect('admin/vendorlisting');
        }
        else{
               if(isset($_POST['sub'])){
                     $subs = is_array($_POST['sub']) ? implode(",",$_POST['sub']) : null;
                    }
                    else
                    {
                        $subs=$_POST['sub_cat'];
                    }

            $bed = (isset($_POST['bedroom'])) ? json_encode($_POST['bedroom']) : '';
            $vals = str_replace("\\", "",$bed);
            
            DB::table('vendor_listing')
            ->where('vl_id', $_POST['vl_id'])
            ->update(            [
                'u_id' => $_POST['vendor'],
                'p_id' => '4',
                'l_title' => $_POST['project_name'],
                'url_name'=>$_POST['url_name'],
                'l_location' => $_POST['address'],
                'l_nearby' => $_POST['near_by'],
                'l_description' => $_POST['about_project'],
                'rera_number' => $_POST['rera_number'],
                 'rera_link' => $_POST['rera_link'],
                'price' => $_POST['price'],
                'price_perft' =>  $_POST['price_perft'],
                'short_title' => $_POST['p_short'],
                'bedroom' => (isset($_POST['bedroom'])) ? json_encode($_POST['bedroom']) : '',
                //'bedroom' => $vals,   
                'bathroom' => (isset($_POST['bathrooms'])) ? json_encode($_POST['bathrooms']) : '',
                'super_area' => (isset($_POST['super_area'])) ? json_encode($_POST['super_area']) : '',
                'carpet_area' => (isset($_POST['carpet_area'])) ? json_encode($_POST['carpet_area']) : '',
                'status' => $_POST['p_status'],
                'floor' => $_POST['floor'],
                'type' => (isset($_POST['transaction_type'])) ? json_encode($_POST['transaction_type']) : '',
                'car_parking'=> $_POST['car_parking'],
                'furnishing' => $_POST['furnishing'],
                'possession_date' => $_POST['possession_date'],
                'tower' => $_POST['tower'],
                'listed_by' => 'Admin',
                'l_category' => $_POST['category'],
                'product_category' => (isset($_POST['product_category'])) ? implode(',',$_POST['product_category']) : '',
                'l_sub_category' => $subs,
                'city' => $_POST['city'],
                 'area' => $_POST['area'],
                 'experience_details' => $_POST['experience_details'],
                'age_details' => $_POST['age_details'],
                'adharnumber_details' => $_POST['adharnumber_details'],
                'Zip_Code' => $_POST['Zip_Code'],
                'l_key_area' => $_POST['pro_tags'],
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
                'first_name' => $_POST['first_Name'],
                'last_name' => $_POST['last_Name'],
                'email' => $_POST['email'],
                'Phone' => $_POST['phone_Number'],
                'website' => $_POST['website'],
                'facebook' => $_POST['face_book'],
                'youtube' => $_POST['you_tube'],
                'l_video_link' => $_POST['l_video_link'],
                'achievements' => $_POST['achievements'],
                'past_projects' => $_POST['past_project'],
                'current_project' => $_POST['current_project'],
                'amenities' => $_POST['pro_amenities'],
                'working_hr' => implode(',',$_POST['workinghrs']),
                'working_time' => $_POST['working_time'],
                'l_featured' => (isset($_POST['l_feature']) && $_POST['l_feature'] == 'on') ? '1' : '0',
                'l_prime' => (isset($_POST['l_prime']) && $_POST['l_prime'] == 'on') ? '1' : '0',
                'shop_price' => $_POST['shop_price'],
                'shop_area' => $_POST['shop_area'],
                'shop_washroom' => $_POST['shop_washroom'],
                'shop_floor' => $_POST['shop_floor'],
                'shop_car_parking' => $_POST['shop_car_parking'],
                //'logo' => $imagename 
            ]);
        }
        

            //gallery image
            $path = public_path().'/images/' . $vl_id.'/pics';

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            if ($photo = $request->file('inputFile')) {        
                    $photo = $request->file('inputFile');
                    foreach ($photo as  $photos) {
                        $imagename = $photos->getClientOriginalName();  
                        $destinationPath = public_path().'/images/'. $vl_id.'/pics';
                        $thumb_img = Image::make($photos->getRealPath())->resize(500, 500);
                        $thumb_img->save($destinationPath.'/'.$imagename,80);
                    }
            }

            //feature image
            if ($photo = $request->file('featured_image')) {        

            $path = public_path().'/images/' . $vl_id.'/featured_image';

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }
                $target_path = $path.'/' . "featured_image.jpg";
                $photo = $request->file('featured_image');
                $imagename = $photo->getClientOriginalName();  
                $destinationPath = public_path().'/images/'. $vl_id.'/featured_image';
                $thumb_img = Image::make($photo->getRealPath())->resize(200, 300);
                $thumb_img->save($target_path);
            }
            
            //banner image
            $path = public_path().'/images/' . $vl_id.'/banner';
            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            if ($photos = $request->file('banner')) {   
                $photos = $request->file('banner');
                foreach ($photos as  $photoss) {
                    $imagename = $photoss->getClientOriginalName();  
                    $destinationPath = public_path().'/images/'. $vl_id.'/banner';
                    $thumb_img = Image::make($photoss->getRealPath())->resize(1140, 350);
                    $thumb_img->save($destinationPath.'/'.$imagename,80);
                }
            }

        if ($request->hasFile('brochure')) {
                $music_file = $request->file('brochure');
                $filename = $music_file->getClientOriginalName();
                $location = public_path('/images/brochure/'.$vl_id );
                $music_file->move($location,$filename);

            DB::table('vendor_listing')
                ->where('vl_id', $vl_id)
                ->update(['l_brochure' =>$_FILES['brochure']['name']]);    
        }

        if ($photos = $request->file('l_extravideo_file')){   
                $user = new VendorListing();    
                 //$imagenamefff = time() .'-'.$photos->getClientOriginalName();
                $imagename = $photos->getClientOriginalName();
                $destinationPath = public_path().'/images/extravideo/'.$vl_id;
                $photos->move($destinationPath,$imagename); 

                if (File::exists(public_path() . $destinationPath . $user->l_extravideo)) {
                File::delete(public_path() . $destinationPath . $user->l_extravideo);
            }

        VendorListing::where('vl_id', $vl_id)->update(array(
            'l_extravideo'  => $imagename
        ));
    }

    if ($photos = $request->file('manual_invoice')){   
                
                $user = new VendorListing();    
                 //$imagenamefff = time() .'-'.$photos->getClientOriginalName();
                $manualinvoice = $photos->getClientOriginalName();
                $destinationPath = public_path().'/uploads/manual_invoice/'.$vl_id;
                $photos->move($destinationPath,$manualinvoice); 

                if (File::exists(public_path() . $destinationPath . $user->manual_invoice)) {
                File::delete(public_path() . $destinationPath . $user->manual_invoice);
            }

        VendorListing::where('vl_id', $vl_id)->update(array(
            'manual_invoice'  => $manualinvoice
        ));
    }


         return redirect('admin/vendorlisting');
    }


   
    public function destroy($id,VendorListing $vendorListing)
    {
        DB::table('vendor_listing')->where('vl_id', '=', $id)->delete();
        
        $path = "public/images/" . $id . "/";
        if (\File::exists($path)){
            \File::deleteDirectory($path);
        }

        return 'success';
    }

    /**
     * Get the product category based on the values.
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function getProductCategory(Request $request,VendorListing $vendorListing)
    {
        $vendor = $request->input('vendor');
        $category = $request->input('category');
        $sub_category = $request->input('sub_category');

        return $vendorListing->getProductCategory($vendor,$category,$sub_category);
    }

    /**
     * Delete image
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function del_image(Request $r)
    {
        $img =$r->file;
        $name = str_replace('/public','',$img);

        unlink(public_path().'/'.$name);
        return response()->JSON($img);
    }

    /**
     * Check URL tag is exist or not
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */

    public function del_video(Request $r)
    {
        $img =$r->file;
        $name = str_replace('/public','',$img);
        unlink(public_path().'/'.$name);
        return response()->JSON($img);
    }

    public function del_extravideo(Request $r)
    {
        $img =$r->file;
        $name = str_replace('/public','',$img);
        unlink(public_path().'/'.$name);
        return response()->JSON($img);
    }
    
    public function check_url(Request $r)
    {
        $url=DB::table('vendor_listing')->select('url_name','vl_id')->get()->toArray();
        $post_url=$_POST['url_name'];

        if(isset($_POST['vl_id'])){
            $vl_id=$_POST['vl_id'];
        }

        $msg = "";
        foreach ($url as $key => $value) {

            if(isset($_POST['vl_id']) && $value->url_name == $post_url && $value->vl_id != $vl_id && $post_url != "") {
                $msg = "URL Is Already Exists";
                break;

            } elseif(!isset($_POST['vl_id']) && $value->url_name == $post_url && $post_url != "") {
                $msg = "URL Is Already Exists";
                break;
            }
        }

        return $msg;
    }

     public function active_property($id)
    {
    //echo $id; exit;
        DB::table('vendor_listing')->where('vl_id',$id)->update(['l_status' => '1']);
        return redirect()->back()->with('status', 'Successfully status updated'); 
    }

    public function inactive_property(Request $request,$id)
    {   
        DB::table('vendor_listing')->where('vl_id', $id)->update(['l_status' => '0']);
        return redirect()->back()->with('status', 'Successfully status updated');
    }
}
