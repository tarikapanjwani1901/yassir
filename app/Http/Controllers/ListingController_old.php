<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB ;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Sentinel;
use App\VendorListing;
use App\Inquiry;

Class ListingController extends Controller
{
    public function __construct()
    {
        $property_list = DB::table('property_listing')->get();
        $product_list = DB::table('product_listing')->get(); 
        $popular_list = DB::table('popular_categories')->get(); 
        $setting = DB::table('general_setting')->get();

        \View::share('property_list',$property_list);
        \View::share('product_list',$product_list);
        \View::share('popular_list',$popular_list);
        \View::share('setting',$setting);
    }
    
    public function listing() {

        $s_key = Input::get('s_key');
        $s_city = Input::get('s_city');
        $area = Input::get('area');
        $s_category = Input::get('s_category');
        $s_type = Input::get('s_type');
        $typeProcess = array();

        if ($s_category == '4') {

           
            $result = DB::table('vendor_listing')
                ->select('vendor_listing.*',(DB::raw('CASE WHEN `l_category` = 4 THEN (SELECT name from category_type_material where `vendor_listing`.`l_sub_category` = `category_type_material`.`id`) END AS name' )))->where('l_status',1);
            $type = '';
            if ($s_category != '') {
                switch ($s_category) {
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

            if ($s_category != '') {
                $type = Inquiry::getType($s_category);

                foreach ($type as $key => $value) {
                    $typeProcess[$value->id] = $value->name;
                }
            }  
           
            if ($s_category != '' && $s_category != 'null') {
                $result->where("vendor_listing.l_category",$s_category);
            }

            if ($s_type != '' && $s_type != 'null') {
                //$result->where("vendor_listing.l_sub_category",$s_type);
                $result->whereRaw("find_in_set(?,vendor_listing.l_sub_category)",[$s_type]);
            }

            /*
            if ($s_key != '' && $s_key != 'null') {
                $result->select(DB::raw("product.*,product.id AS pid,product_category.*,(CASE WHEN product.product_name LIKE '%".$s_key."%' THEN 0 ELSE 1 END) AS pname,vendor_listing.*, vendor_listing_review.*, users.*"));
                $result->where('product.product_name','=', $s_key);
                 $result->orwhere('vendor_listing.l_title', '=', $s_key);
            }
            */

            if ($s_key != '' && $s_key != 'null') {

                $result->where("vendor_listing.short_title" ,$s_key);
                $result->orwhereRaw("find_in_set(?,vendor_listing.short_title)",[$s_key]);
            }

            // if ($s_key != '' && $s_key != 'null') {
            //      $result->where('product.product_name', '=', $s_key);
            // }

            if ($s_city != '' && $s_city != 'null') {
                $result->where('vendor_listing.city', '=', $s_city);
            }

             if ($area != '' && $area != 'null') {
                $result->where('vendor_listing.area', '=', $area);
            }

            $result = $result->orderBy('vendor_listing.l_prime','DESC')->get();
        }
        else if($s_category == '3'){

             $result = DB::table('vendor_listing')
                ->select('vendor_listing.*','users.id','category_type_contractor.name')
                ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
                ->join('users', 'vendor_listing.u_id', '=', 'users.id')
                ->join('activations', 'activations.user_id', '=', 'users.id')
                ->join('category_type_contractor','category_type_contractor.id', '=', 'vendor_listing.l_sub_category')
                ->orderBy('l_prime','DESC');
              
                if ($s_category != '' && $s_category != 'null') {
                    $result->where("vendor_listing.l_category",$s_category);
                }
                if ($s_type != '' && $s_type != 'null') {
                    $result->where("vendor_listing.l_sub_category" ,$s_type);
                }
                if ($s_key != '' && $s_key != 'null') {
                    $result->where('vendor_listing.l_title', '=', $s_key);
                    $result->orWhere('vendor_listing.short_title', '=', $s_key);
                }
                if ($s_city != '' && $s_city != 'null') {
                    $result->where('vendor_listing.city', '=', $s_city);
                }

                if ($area != '' && $area != 'null') {
                    $result->where('vendor_listing.area', '=', $area);
                }

                $result = $result->where('activations.completed_at','!=', null)->whereNull('users.deleted_at')->groupBy('vendor_listing.vl_id')
                ->orderBy('vendor_listing_review.l_review', 'desc')
                ->orderBy('vendor_listing_review.rcreated_at', 'desc')
                ->orderBy('l_prime','DESC')->get();

        }
        else if($s_category == '5'){
            $result = DB::table('vendor_listing')
                ->select('vendor_listing.*','users.id','category_type_skill_labour.name')
                ->where('vendor_listing.deleted_at','=',NULL)
                ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
                ->join('users', 'vendor_listing.u_id', '=', 'users.id')
                ->join('activations', 'activations.user_id', '=', 'users.id')
                ->join('category_type_skill_labour','category_type_skill_labour.id', '=', 'vendor_listing.l_sub_category');
                
            
                if ($s_category != '' && $s_category != 'null') {
                    $result->where("vendor_listing.l_category",$s_category);
                }

                if ($s_type != '' && $s_type != 'null') {
                    $result->where("vendor_listing.l_sub_category" ,$s_type);
                     $result->orwhereRaw("find_in_set(?,vendor_listing.other_skill)",[$s_type]);
                }
                if ($s_key != '' && $s_key != 'null') {
                    $result->where('vendor_listing.l_title', 'like', '%'.$s_key.'%');
                    $result->orWhere('vendor_listing.short_title', 'like', '%'.$s_key.'%');
                }

                if ($s_city != '' && $s_city != 'null') {
                    $result->where('vendor_listing.city', '=', $s_city);
                }

                if ($area != '' && $area != 'null') {
                    $result->where('vendor_listing.area', '=', $area);
                }

                $result = $result->where('activations.completed_at','!=', null)->whereNull('users.deleted_at')->groupBy('vendor_listing.vl_id')
                ->orderBy('vendor_listing_review.l_review', 'desc')
                ->orderBy('vendor_listing_review.rcreated_at', 'desc')
                ->orderBy('l_prime','DESC')->get();



        } else if($s_category == '2'){

            // $result = DB::table('vendor_listing')
            //     ->select('vendor_listing.*','users.id')
            //     ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            //     ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            //     ->join('activations', 'activations.user_id', '=', 'users.id');
                         
             $result = DB::table('vendor_listing')
                ->select('vendor_listing.*','users.id','category_type_consultancy.name')
                ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
                ->join('users', 'vendor_listing.u_id', '=', 'users.id')
                ->join('activations', 'activations.user_id', '=', 'users.id')
                ->join('category_type_consultancy','category_type_consultancy.id', '=', 'vendor_listing.l_sub_category')
                ->orderBy('l_prime','DESC');    
                
                if ($s_category != '' && $s_category != 'null') {
                    $result->where("vendor_listing.l_category",$s_category);
                }
                if ($s_type != '' && $s_type != 'null') {
                    $result->where("vendor_listing.l_sub_category" ,$s_type);
                }
                if ($s_key != '' && $s_key != 'null') {
                    // $result->where('vendor_listing.l_title', '=', $s_key);
                    //$result->orWhere('vendor_listing.short_title', 'like', '%'.$s_key.'%');

                    $result->where('vendor_listing.l_title', 'like', '%'.$s_key.'%');
                    $result->orWhere('vendor_listing.status', 'like', '%'.$s_key.'%');
                    $result->orWhere('vendor_listing.l_description', 'like', '%'.$s_key.'%');
                    $result->orWhere('vendor_listing.l_key_area', 'like', '%'.$s_key.'%');
                    $result->orWhere('vendor_listing.price', 'like', '%'.$s_key.'%');
                    $result->orWhere('vendor_listing.short_title', 'like', '%'.$s_key.'%');
                }
                if ($s_city != '' && $s_city != 'null') {
                    $result->where('vendor_listing.city', '=', $s_city);
                }
                if ($area != '' && $area != 'null') {
                    $result->where('vendor_listing.area', '=', $area);
                }
                $result = $result->where('activations.completed_at','!=', null)->whereNull('users.deleted_at')->groupBy('vendor_listing.vl_id')
                 ->orderBy('vendor_listing.l_prime','DESC')->get();             

        } else {

            //s_category = 1 and 2
            // $result = DB::table('vendor_listing')
            //     ->select('vendor_listing.*','users.id')
            //     ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            //     ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            //     ->join('activations', 'activations.user_id', '=', 'users.id');

              $result = DB::table('vendor_listing')
                ->select('vendor_listing.*','users.id','category_type_properties.name')
                ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
                ->join('users', 'vendor_listing.u_id', '=', 'users.id')
                ->join('activations', 'activations.user_id', '=', 'users.id')
                ->join('category_type_properties','category_type_properties.id', '=', 'vendor_listing.l_sub_category')
                ->orderBy('l_prime','DESC');      

                
                
                if ($s_category != '' && $s_category != 'null') {
                    $result->where("vendor_listing.l_category",$s_category);
                }
                if ($s_type != '' && $s_type != 'null') {
                    $result->where("vendor_listing.l_sub_category" ,$s_type);
                }
                if ($s_key != '' && $s_key != 'null') {
                    $result->where('vendor_listing.l_title', '=', $s_key);
                    $result->orWhere('vendor_listing.short_title', 'like', '%'.$s_key.'%');

                    // $result->where('vendor_listing.l_title', 'like', '%'.$s_key.'%');
                    // $result->orWhere('vendor_listing.status', 'like', '%'.$s_key.'%');
                    // $result->orWhere('vendor_listing.l_description', 'like', '%'.$s_key.'%');
                    // $result->orWhere('vendor_listing.l_key_area', 'like', '%'.$s_key.'%');
                    // $result->orWhere('vendor_listing.price', 'like', '%'.$s_key.'%');
                    // $result->orWhere('vendor_listing.short_title', 'like', '%'.$s_key.'%');
                }
                if ($s_city != '' && $s_city != 'null') {
                    $result->where('vendor_listing.city', '=', $s_city);
                }
                if ($area != '' && $area != 'null') {
                    $result->where('vendor_listing.area', '=', $area);
                }
                $result = $result->where('activations.completed_at','!=', null)->whereNull('users.deleted_at')->groupBy('vendor_listing.vl_id')
                 ->orderBy('vendor_listing.l_prime','DESC')->get();
        }
        
        $cityResult = DB::table('vendor_listing')->select('city')->groupBy('city')->orderBy('city', 'ASC')->get();

        $city = array();
        foreach ($cityResult as $key => $value) {
            if (!in_array(ucfirst($value->city), $city)) {
                $city[strtolower($value->city)] = ucfirst($value->city);
            }
        }

        //Get Type values
        $type = $this->getTypeList($s_category);

        $detail = DB::table('product')->select('product.v_id','product.sub_cat_id','category_type_material.name','category_type_material.id')
            ->join('category_type_material','category_type_material.id','=','product.sub_cat_id')
            ->distinct()->get();

          $detailggdgfd = DB::table('vendor_listing')
            ->select('product.v_id','product.sub_cat_id','vendor_listing.l_sub_category','vendor_listing.u_id')->where('vendor_listing.l_category',4)
            ->join('product','product.v_id','=','vendor_listing.u_id')
            ->distinct()->get();    
        //city
         $city_info = DB::table('pincode')->where('status','active')->groupby('City_Id')->distinct()->get();

        return view('listing')->with('city_info',$city_info)->with('s_key',$s_key)->with('result',$result)->with('type',$type)->with('type_id',$s_type)->with('s_city',$s_city)->with('detail',$detail)->with('typeProcess',$typeProcess);
    }

    public function detaillisting($listingid='') {

        $shop_condition = DB::table('vendor_listing')->select('l_sub_category')->where('vendor_listing.url_name', '=', $listingid)->get();

        //Get user based on the listingid
        $user_id = DB::table('vendor_listing')->select('u_id','vl_id')->where('vendor_listing.url_name', '=', $listingid)->get()->toArray();

        if(!isset($user_id[0]->u_id))
        {
            $user_id = DB::table('vendor_listing')->where('vendor_listing.vl_id', '=', $listingid)->pluck('u_id');
        } else {
            $listingid = $user_id[0]->vl_id;
        }

        //Get the cookie value
        if (Sentinel::check() && Sentinel::inRole('admin')) {

        } else {
            if (isset($_COOKIE['otp_lists'])) {
                $explode = explode(',', $_COOKIE['otp_lists']);

                if (!in_array($listingid, $explode)) {
                    return redirect('/');
                }
            } 
                else if (empty(Sentinel::check())) 
                {
                $check = '1';

                // else if (Sentinel::check() && Sentinel::inRole('vendor') && Sentinel::getUser()->id == $user_id[0] ) {
                // $check = '1';

            }
            else if (Sentinel::check())
            {
               $check = '1';
            } 

            else {
                return redirect('/');
            }
        }


         $data =  VendorListing::where('vl_id',$listingid)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       } 

        $result = DB::table('vendor_listing')
            ->select(DB::raw('vendor_listing.*, vendor_listing_review.*,vendor_listing.first_name as vfname,vendor_listing.last_name as vlname, users.*,users.email as u_email,users.company_name as c_name,vendor_listing.website as web_site,vendor_listing.price'))
            ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->where('vendor_listing.vl_id', '=', $listingid)
            ->orderBy('vendor_listing_review.l_review', 'desc')
            ->orderBy('vendor_listing_review.rcreated_at', 'desc')
            ->get()->toArray();

           // echo "<pre>"; print_r($result); exit;

        $avgRating = 0;
        foreach ($result as $key => $value) {
            $avgRating+= $value->l_review;
        }

        if ($avgRating != '0') {
            $avgRating = $avgRating/count($result);
        }

        $reviewResult = DB::table('vendor_listing_review')->where('vendor_listing_review.l_id', '=', $listingid)->orderBy('vendor_listing_review.rcreated_at', 'desc')->paginate(5);

        if ($result[0]->l_category == '4') {
            $arr = array();
            $categoryname = array();

            $category =  DB::select('SELECT
                        *
                        FROM
                        `vendor_listing`
                        LEFT JOIN `vendor_listing_review`
                        ON `vendor_listing`.`vl_id` = `vendor_listing_review`.`l_id`
                        INNER JOIN `users`
                        ON `vendor_listing`.`u_id` = `users`.`id`
                        LEFT JOIN `product`
                        ON `product`.`v_id` = `vendor_listing`.`u_id`
                        LEFT JOIN `product_category`
                        ON FIND_IN_SET(
                        `product_category`.`cate_id`,
                        `product`.`product_category`
                        )
                        WHERE `vendor_listing`.`vl_id` = '.$listingid.'
                        ORDER BY `vendor_listing_review`.`l_review` DESC,
                        `vendor_listing_review`.`rcreated_at` DESC'
                    );

            $listCate = explode(',', $result[0]->product_category);

            foreach($category as $s) {
                if (in_array($s->cate_id, $listCate)) {
                    $arr[$s->cate_id][$s->id] = $s->product_name;
                    $categoryname[$s->cate_id] = $s->cate_name;
                }
            }
        }

        $view = DB::table('vendor_listing')
            ->select(DB::raw('vendor_listing.*, users.*'))
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->where('vendor_listing.vl_id', '=', $listingid)
            ->groupBy('vendor_listing.vl_id')
            ->get();

        //1: Property
        //2 & 3: Consultancy & Contractor
        //4: Material

        $product_info =  DB::select('SELECT
                        *
                        FROM
                        `vendor_listing`
                        LEFT JOIN `vendor_listing_review`
                        ON `vendor_listing`.`vl_id` = `vendor_listing_review`.`l_id`
                        INNER JOIN `users`
                        ON `vendor_listing`.`u_id` = `users`.`id`
                        LEFT JOIN `product`
                        ON `product`.`v_id` = `vendor_listing`.`u_id`
                        LEFT JOIN `product_category`
                        ON FIND_IN_SET(
                        `product_category`.`cate_id`,
                        `product`.`product_category`
                        )
                        WHERE `vendor_listing`.`vl_id` = '.$listingid.'
                        ORDER BY `vendor_listing_review`.`l_review` DESC,
                        `vendor_listing_review`.`rcreated_at` DESC'
                    );        

        if (isset($result[0])) {
            if ($result[0]->l_category == '1') {
                return view('detaillisting')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);

            } else if ($result[0]->l_category == '2') {
                return view('detaillisting_v2')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);


            } else if ($result[0]->l_category == '3') {
                return view('detaillisting_v2')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);


            } else if ($result[0]->l_category == '4') {
                return view('detaillisting_v4')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('arr',$arr)->with('categoryname',$categoryname)->with('view',$view)->with('shop_condition',$shop_condition)->with('product_info',$product_info);

            } else if ($result[0]->l_category == '5') {
                return view('detaillisting_v5')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);
            }


        } else {
            return redirect('/');
        }
    }

    public function all_product_detaillisting($listingid='') {

        $shop_condition = DB::table('vendor_listing')->select('l_sub_category')->where('vendor_listing.url_name', '=', $listingid)->get();

        //Get user based on the listingid
        $user_id = DB::table('vendor_listing')->select('u_id','vl_id')->where('vendor_listing.url_name', '=', $listingid)->get()->toArray();

        if(!isset($user_id[0]->u_id))
        {
            $user_id = DB::table('vendor_listing')->where('vendor_listing.vl_id', '=', $listingid)->pluck('u_id');
        } else {
            $listingid = $user_id[0]->vl_id;
        }

        //Get the cookie value
        if (Sentinel::check() && Sentinel::inRole('admin')) {

        } else {
            if (isset($_COOKIE['otp_lists'])) {
                $explode = explode(',', $_COOKIE['otp_lists']);

                if (!in_array($listingid, $explode)) {
                    return redirect('/');
                }
            } 
                else if (empty(Sentinel::check())) 
                {
                $check = '1';

                // else if (Sentinel::check() && Sentinel::inRole('vendor') && Sentinel::getUser()->id == $user_id[0] ) {
                // $check = '1';

            }
            else if (Sentinel::check())
            {
               $check = '1';
            } 

            else {
                return redirect('/');
            }
        }


         $data =  VendorListing::where('vl_id',$listingid)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       } 

        $result = DB::table('vendor_listing')
            ->select(DB::raw('vendor_listing.*, vendor_listing_review.*,vendor_listing.first_name as vfname,vendor_listing.last_name as vlname, users.*,users.email as u_email,users.company_name as c_name,vendor_listing.website as web_site,vendor_listing.price'))
            ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->where('vendor_listing.vl_id', '=', $listingid)
            ->orderBy('vendor_listing_review.l_review', 'desc')
            ->orderBy('vendor_listing_review.rcreated_at', 'desc')
            ->get()->toArray();

           

        $avgRating = 0;
        foreach ($result as $key => $value) {
            $avgRating+= $value->l_review;
        }

        if ($avgRating != '0') {
            $avgRating = $avgRating/count($result);
        }

        $reviewResult = DB::table('vendor_listing_review')->where('vendor_listing_review.l_id', '=', $listingid)->orderBy('vendor_listing_review.rcreated_at', 'desc')->paginate(5);

        if ($result[0]->l_category == '4') {
            $arr = array();
            $categoryname = array();

            $category =  DB::select('SELECT
                        *
                        FROM
                        `vendor_listing`
                        LEFT JOIN `vendor_listing_review`
                        ON `vendor_listing`.`vl_id` = `vendor_listing_review`.`l_id`
                        INNER JOIN `users`
                        ON `vendor_listing`.`u_id` = `users`.`id`
                        LEFT JOIN `product`
                        ON `product`.`v_id` = `vendor_listing`.`u_id`
                        LEFT JOIN `product_category`
                        ON FIND_IN_SET(
                        `product_category`.`cate_id`,
                        `product`.`product_category`
                        )
                        WHERE `vendor_listing`.`vl_id` = '.$listingid.'
                        ORDER BY `vendor_listing_review`.`l_review` DESC,
                        `vendor_listing_review`.`rcreated_at` DESC'
                    );

                // echo "<pre>"; print_r($category); exit;

            $listCate = explode(',', $result[0]->product_category);

            foreach($category as $s) {
                if (in_array($s->cate_id, $listCate)) {
                    $arr[$s->cate_id][$s->id] = $s->product_name;
                    $categoryname[$s->cate_id] = $s->cate_name;
                }
            }
        }

        $view = DB::table('vendor_listing')
            ->select(DB::raw('vendor_listing.*, users.*'))
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->where('vendor_listing.vl_id', '=', $listingid)
            ->groupBy('vendor_listing.vl_id')
            ->get();

        //1: Property
        //2 & 3: Consultancy & Contractor
        //4: Material


         $product_info =  DB::select('SELECT
                        *
                        FROM
                        `vendor_listing`
                        LEFT JOIN `vendor_listing_review`
                        ON `vendor_listing`.`vl_id` = `vendor_listing_review`.`l_id`
                        INNER JOIN `users`
                        ON `vendor_listing`.`u_id` = `users`.`id`
                        LEFT JOIN `product`
                        ON `product`.`v_id` = `vendor_listing`.`u_id`
                        LEFT JOIN `product_category`
                        ON FIND_IN_SET(
                        `product_category`.`cate_id`,
                        `product`.`product_category`
                        )
                        WHERE `vendor_listing`.`vl_id` = '.$listingid.'
                        ORDER BY `vendor_listing_review`.`l_review` DESC,
                        `vendor_listing_review`.`rcreated_at` DESC'
                    );    
        //echo "<pre>"; print_r($product_info); exit;


        if (isset($result[0])) {
            if ($result[0]->l_category == '1') {
                return view('detaillisting')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);

            } else if ($result[0]->l_category == '2') {
                return view('detaillisting_v2')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);


            } else if ($result[0]->l_category == '3') {
                return view('detaillisting_v2')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);


            } else if ($result[0]->l_category == '4') {
                return view('all_product_detaillisting_v4')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('arr',$arr)->with('categoryname',$categoryname)->with('view',$view)->with('shop_condition',$shop_condition)->with('product_info',$product_info);

            } else if ($result[0]->l_category == '5') {
                return view('detaillisting_v5')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating)->with('view',$view)->with('shop_condition',$shop_condition);
            }


        } else {
            return redirect('/');
        }
    }

    public static function getExcerpt($str, $startPos=0, $maxLength=150) {

        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }

    public function sendMail($listingid='',Request $request) {
            
        $owner_mobile = urlencode($request->input('umobile'));
        $name = urlencode($request->input('f_name'));
        $email = urldecode($request->input('iemail'));
        $phone = urldecode($request->input('inumber'));
        $abc = "".ucfirst($name)." has requested for inquiry. Please find contact info as below.
        Email :".$email." 
        Phone :".$phone." 
        Thanks!";

        $owner_msg = urlencode($abc);
        $request_phone = urlencode($request->input('inumber'));
        $request_msgs = urlencode("Thank you for contacting us.");     
                
            $curl = curl_init();
                curl_setopt_array($curl, array(
                 CURLOPT_URL => "http://sms.incisivewebsolution.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=667810964beb48fcf4f157b070dd89fa&message=".$request_msgs."&senderId=YASSIR&routeId=1&mobileNos=".$request_phone."&smsContentType=english",

                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache"
                  ),
                ));

            $curl1 = curl_init();
                curl_setopt_array($curl1, array(
                  CURLOPT_URL => "http://sms.incisivewebsolution.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=667810964beb48fcf4f157b070dd89fa&message=".$owner_msg."&senderId=YASSIR&routeId=1&mobileNos=".$owner_mobile."&smsContentType=english",
                  
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache"
                  ),
                ));
                $response = curl_exec($curl);
                $response1 = curl_exec($curl1);
                $err = curl_error($curl);
                curl_close($curl);

                if ($request->rname) {

            //Insert into the table
            DB::table('vendor_listing_review')->insert([
                ['l_id' => $request->hvl_id, 'l_comment' => $request->rcomment,'l_review' => $request->rrating,'reviewer_name' => $request->rname,'rcreated_at' => date('Y-m-d h:i:s'),'rupdated_at' => date('Y-m-d h:i:s')]
            ]);

            //Send review mail and insert into the table
            $to = "support@yassir.in";
            $subject = "New Review Submitted - Yassir";
            $txt = "Hi,". "\r\n\r\n";
            $txt .= $request->rname." has provided review to you listing.". "\r\n\r\n";
            $txt .= "Name: ".$request->rname. "\r\n";
            $txt .= "Rating: ".$request->rrating. "\r\n";
            $txt .= "Comment: ".$request->rcomment. "\r\n";
            $txt .= "Thanks!";
            $headers = "From: support@yassir.in" . "\r\n";

        } else {

            //Insert into the table
            DB::table('vendor_inquiry')->insert([
                ['l_id' => $request->hvl_id, 'u_id' => $request->u_id,'iname' => $request->f_name,'iemail' => $request->iemail,'iphone' => $request->inumber,'idate' => $request->idate,'itime' => $request->itime,'imessage' => $request->icomment,'created_at' => date('Y-m-d H:i:s')]
            ]);



            //Send inquiry mail
            $to = $request->uemail;
            $subject = "New Inquiry - Yassir";
            $txt = "Hi,". "\r\n\r\n";
            $txt .= ucfirst($request->f_name)." has requested for inquiry.Please find contact info as below.". "\r\n\r\n";
            $txt .= "Email: ".$request->iemail. "\r\n";
            $txt .= "Phone: ".$request->inumber. "\r\n";

            if ($request->idate) {
                $txt .= "Date: ".$request->idate. "\r\n";
            }

            if ($request->itime) {
                $txt .= "Time: ".$request->itime. "\r\n";
            }

            $txt .= "Comment: ".$request->icomment. "\r\n";
            $txt .= "Thanks!";
            $headers = "From: support@yassir.in" . "\r\n";
        }



        mail($to,$subject,$txt,$headers);
        mail('support@yassir.in',$subject,$txt,$headers);

        return $this->detaillisting($listingid);
    }

    public function sendMail_backup($listingid='',Request $request) {

        if ($request->rname) {

            //Insert into the table
            DB::table('vendor_listing_review')->insert([
                ['l_id' => $request->hvl_id, 'l_comment' => $request->rcomment,'l_review' => $request->rrating,'reviewer_name' => $request->rname,'rcreated_at' => date('Y-m-d h:i:s'),'rupdated_at' => date('Y-m-d h:i:s')]
            ]);

            //Send review mail and insert into the table
            $to = "info@yassir.in";
            $subject = "New Review Submitted - Yassir";
            $txt = "Hi,". "\r\n\r\n";
            $txt .= $request->rname." has provided review to you listing.". "\r\n\r\n";
            $txt .= "Name: ".$request->rname. "\r\n";
            $txt .= "Rating: ".$request->rrating. "\r\n";
            $txt .= "Comment: ".$request->rcomment. "\r\n";
            $txt .= "Thanks!";
            $headers = "From: info@yassir.in" . "\r\n";

        } else {

            //Insert into the table
            DB::table('vendor_inquiry')->insert([
                ['l_id' => $request->hvl_id, 'u_id' => $request->u_id,'iname' => $request->f_name,'iemail' => $request->iemail,'iphone' => $request->inumber,'idate' => $request->idate,'itime' => $request->itime,'imessage' => $request->icomment,'created_at' => date('Y-m-d H:i:s')]
            ]);

            //Send inquiry mail
            $to = $request->uemail;
            //$to = "info@yassir.in";
            $subject = "New Inquiry - Yassir";
            $txt = "Hi,". "\r\n\r\n";
            $txt .= $request->f_name." has requested for inquiry.Please find contact info as below.". "\r\n\r\n";
            $txt .= "Email: ".$request->iemail. "\r\n";
            $txt .= "Phone: ".$request->inumber. "\r\n";

            if ($request->idate) {
                $txt .= "Date: ".$request->idate. "\r\n";
            }

            if ($request->itime) {
                $txt .= "Time: ".$request->itime. "\r\n";
            }

            $txt .= "Comment: ".$request->icomment. "\r\n";
            $txt .= "Thanks!";
            $headers = "From: info@yassir.in" . "\r\n";
        }



        mail($to,$subject,$txt,$headers);
        mail('support@yassir.in',$subject,$txt,$headers);

        return $this->detaillisting($listingid);

/*        $result = DB::table('vendor_listing')
            ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->join('user_details', 'user_details.user_id', '=', 'users.id')
            ->where('vendor_listing.vl_id', '=', $listingid)
            ->orderBy('vendor_listing_review.l_review', 'desc')
            ->orderBy('vendor_listing_review.rcreated_at', 'desc')
            ->get()->toArray();

        $avgRating = 0;
        foreach ($result as $key => $value) {
            $avgRating+= $value->l_review;
        }

        if ($avgRating != '0') {
            $avgRating = $avgRating/count($result);
        }

        //Query for pagination
        $reviewResult = DB::table('vendor_listing_review')->where('vendor_listing_review.l_id', '=', $listingid)->orderBy('vendor_listing_review.rcreated_at', 'desc')->paginate(5);

        if (isset($result[0])) {
            if ($result[0]->l_category == '1') {
                return view('detaillisting')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating);
            } else if ($result[0]->l_category == '2') {
                return view('detaillisting_v2')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating);
            } else if ($result[0]->l_category == '3') {
                return view('detaillisting_v2')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating);
            } else if ($result[0]->l_category == '4') {
                return view('detaillisting_v4')->with('result',$result)->with('reviewResult',$reviewResult)->with('avgRating',$avgRating);
            }
        } else {
            return redirect('/');
        }*/

    }

    public function listingProduct() {
        return view('detaillisting_material');
    }

    public function otpMail(Request $request) {

        //Random number
        $randNo = mt_rand(100000, 999999);
        $ip = $request->ip();

        //Store entry in DB with random number
        DB::table('front_view_listing')->insert(
            ['u_email' => $request->input('lemail'), 'l_id' => $request->input('lid'), 'u_OTP' => $randNo, 'view_status' => '0', 'ip_address' => $ip, 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')]
        );

        //Send review mail and insert into the table
        $to = $request->input('lemail');
        $subject = "OTP - Yassir";
        $txt = "Hi,". "\r\n\r\n";
        $txt .= "Your OTP Code is:".$randNo. "\r\n\r\n";
        $txt .= "Thanks!";
        $headers = "From: support@yassir.in" . "\r\n";

        mail($to,$subject,$txt,$headers);
        echo 'success';
        exit;
    }

    public function otpVerification(Request $request) {
        $ip = $request->ip();

        $viewListing = DB::table('front_view_listing')
                    ->where('u_OTP', '=', $request->input('otpval'))
                    ->where('l_id', '=', $request->input('lid'))
                    ->get()->toArray();

        if ($viewListing) {
            if ($viewListing[0]->view_status == '1') {
                echo 'OPT Expired.';
            } else if ($viewListing[0]->ip_address != $request->ip()) {
                echo 'IP Address is changed.';
            } elseif ( $viewListing[0]->view_status == '0' && $viewListing[0]->ip_address == $request->ip()) {
                DB::table('front_view_listing')
                    ->where('id', $viewListing[0]->id)
                    ->update(['view_status' => 1]);
                echo 'success';
            }
        } else {
            echo 'Invalid OTP';
        }
        exit;
    }

    public function getTypeList($type_id) {

        switch ($type_id) {
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

        if(empty($type))
        {
            return abort('404');
        }
        else
        { 
            return $type;

        }
    }

    //Get the Product details
    public function product_detail($vl_id,$id)
    {

        //Get the product detail
    //$detail = DB::table('product')->where('product_name','=',$id)->get()->toArray();
          // $detail = DB::table('product')->select('vendor_listing.vl_id','product.*')
          //       ->leftjoin('vendor_listing','vendor_listing.vl_id','product.v_id')
          //       ->where('product.product_name',$id)
          //       ->get()->toArray();    

     
                 $detail = DB::table('product')->select('product.*','vendor_listing.u_id')
                ->leftjoin('vendor_listing','vendor_listing.u_id','product.v_id')
                ->where('product.product_name',$id)
                ->where('vendor_listing.url_name',$vl_id)    
                ->get();

                //echo "<pre>"; print_r($detail); exit;
                if($detail[0]->product_category == 0)
                {
                    $dd = NULL;
                }
                else
                {
                    $dd = $detail[0]->product_category;
                }

               //echo $detail[0]->product_category; exit;

                 $product_id = DB::table('product')->where('product_name',$id)->get();
                    //echo $product_id[1]->v_id; exit;
        //Get the related product except the selected one
        $related = DB::table('product')->select('vendor_listing.u_id','vendor_listing.url_name','product.*')
                    ->join('vendor_listing','vendor_listing.u_id','product.v_id')
                    ->where('product.product_category',$dd)
                    // ->where('vendor_listing.url_name',$vl_id)
                    ->where('product_name','!=',$id)
                    ->get()->toArray();

                    //  $related = DB::table('product')->select('product_category')
                    // //->where('product_category',$detail[0]->product_category)
                    // ->where('product_name',$id)
                    // ->get()->toArray();

        return view('product_detail')->with('detail',$detail)->with('related',$related)->with('vl_id',$vl_id);
    }

    public function skill_detail($vl_id,$id)
    {
       
        $skill = DB::TABLE('vendor_listing')
        ->join('category_type_skill_labour','category_type_skill_labour.id','=','vendor_listing.l_sub_category')
         ->where('vl_id','=',$vl_id)
         ->get()
         ->toArray();     
         
        return view('skill_labour_detail')->with('skill',$skill)->with('vl_id',$vl_id);
    }

    //Get all the products
    public function category_products1($vl_id,$cate_id)
    {
        $category =  DB::select('SELECT
            *
            FROM
            `vendor_listing`
            LEFT JOIN `vendor_listing_review`
            ON `vendor_listing`.`vl_id` = `vendor_listing_review`.`l_id`
            INNER JOIN `users`
            ON `vendor_listing`.`u_id` = `users`.`id`
            LEFT JOIN `product`
            ON `product`.`v_id` = `vendor_listing`.`u_id`
            LEFT JOIN `product_category`
            ON FIND_IN_SET(
            `product_category`.`cate_id`,
            `product`.`product_category`
            )
            WHERE `vendor_listing`.`vl_id` = '.$vl_id.'
            ORDER BY `vendor_listing_review`.`l_review` DESC,
            `vendor_listing_review`.`rcreated_at` DESC'
        );

        $arr = array();

        foreach($category as $s) {
            if ($s->cate_id == $cate_id) {
                $arr[] = $s;
            }
        }

        return view('detaillisting_material')->with('arr',$arr)->with('vl_id',$vl_id);
    }
    public function category_products($vl_id,$cate_id)
    {
        //echo $cate_id; exit;
        $category =  DB::select('SELECT
            *
            FROM
            `vendor_listing`
            LEFT JOIN `vendor_listing_review`
            ON `vendor_listing`.`vl_id` = `vendor_listing_review`.`l_id`

            INNER JOIN `users`
            ON `vendor_listing`.`u_id` = `users`.`id`
            
            LEFT JOIN `product`
            ON `product`.`v_id` = `vendor_listing`.`u_id`
            
            LEFT JOIN `product_category`
            ON FIND_IN_SET(
            `product_category`.`cate_id`,

            `product`.`product_category`
            )
            
            WHERE `vendor_listing`.`url_name` = "'.$vl_id.'"
            AND `product_category`.`cate_name`= "'.$cate_id.'"
            ORDER BY `vendor_listing_review`.`l_review` DESC,
            `vendor_listing_review`.`rcreated_at` DESC');


        $arr = array();

        foreach($category as $s) {
            if ($s->cate_id == $cate_id) {
                $arr[] = $s;
            }
        }

        return view('detaillisting_material')->with('arr',$arr)->with('vl_id',$vl_id)->with('category',$category);
    }
}
