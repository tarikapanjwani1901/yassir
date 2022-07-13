<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Inquiry;
use App\Models\PropertyBookVisit;
use App\Models\User;
use App\Models\VendorListing;
use App\Models\VendorListingFavourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Google\Service\CloudRun\Probe;
use Illuminate\Support\Arr;
use Sentinel;
use Image;

class PropertyController extends Controller
{
    public function __construct() {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function getVendorProperty(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        // check role of user id is vendor
        $user = DB::table('role_users')->select('role_id')->where('user_id', $request->user_id)->where('role_id',3)->first();
        
        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "Vendor not found",
                'data'    => array()
            ));
        
        }else{
           
            // get property of vendor
            $property = VendorListing::getPropertyByVendor($request->user_id);

            $list = array();
            $i=0;
            if(isset($property) && sizeof($property)>0){
                foreach($property as $k=>$v){
                    $list[$i]['id'] = $v->vl_id;
                    $list[$i]['title'] = $v->l_title;
                    $list[$i]['possession_date'] = $v->possession_date;
                    $list[$i]['address'] = $v->l_location;
                    $list[$i]['price'] = $v->price;
                    $list[$i]['image'] = "public/images/".$v->vl_id."/featured_image/featured_image.jpg";
                    $i++;
                }
            }

            return \Illuminate\Support\Facades\Response::json(array(
                'success' => true,
                'code'    => 200,
                'message' => "Success",
			    'data'    => $list));

        }
        
    }

    public function getPropertyDetails(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'property_id' => 'required',
            'user_id' => 'required',
        ]);
		  
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }
		$listingid = $request->property_id;	

		
        $result = DB::table('vendor_listing')
            ->select(DB::raw('vendor_listing.*, vendor_listing_review.*,vendor_listing.first_name as vfname,vendor_listing.last_name as vlname, users.*,users.email as u_email,users.company_name as c_name,vendor_listing.website as web_site,vendor_listing.price'))
            ->leftJoin('vendor_listing_review', 'vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
            ->join('users', 'vendor_listing.u_id', '=', 'users.id')
            ->where('vendor_listing.vl_id', '=', $listingid)
            ->orderBy('vendor_listing_review.l_review', 'desc')
            ->orderBy('vendor_listing_review.rcreated_at', 'desc')
            ->get()->toArray();
			
           $avgRating = 0;
       $shop_condition = DB::table('vendor_listing')->select('l_sub_category')->where('vendor_listing.url_name', '=', $result[0]->url_name)->get();
	
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
    	
		
		$path = public_path().'/images/'.$result[0]->vl_id.'/pics/';
        $dh  = opendir($path);
        $ignoreArry = array('.','..','...','....');
        while (false !== ($filename = readdir($dh))) {
            if (!in_array($filename, $ignoreArry)) {
                $files[] = $filename;
            }
        }
        $bpath = public_path().'/images/'.$result[0]->vl_id.'/banner/';
        if (is_dir($bpath)) {
            $bdh  = opendir($bpath);
            $bignoreArry = array('.','..','...','....');
            while (false !== ($filename = readdir($bdh))) {
                if (!in_array($filename, $bignoreArry)) {
                    $bfiles[] = $filename;
                }
            }
        }
	
		$price = $result[0]->price;
		$short_title = $result[0]->short_title;
		$carpet_area = json_decode($result[0]->carpet_area,true);
		$price_perft = $result[0]->price_perft;
		$furnishing = $result[0]->furnishing;
        $car_parking = $result[0]->car_parking;
        $type = json_decode($result[0]->type,true);
        $floor = $result[0]->floor;
        $status = $result[0]->status;
        $super_area = json_decode($result[0]->super_area,true);
        $bathroom = json_decode($result[0]->bathroom,true);
        $bedroom = json_decode($result[0]->bedroom,true);
        $masterArray = array();
        
        foreach ($super_area['type'] as $key => $value) {
            foreach ($super_area[$value] as $k1 => $v1) {
                
                $masterArray[$value][$v1]['carpet_area'][] = $carpet_area[$value][$k1];
                $masterArray[$value][$v1]['super_area'][] = $super_area[$value][$k1];
                $masterArray[$value][$v1]['type'][] = $type[$value][$k1];
                $masterArray[$value][$v1]['bathroom'][] = $bathroom[$value][$k1];
                $masterArray[$value][$v1]['bedroom'][] = $bedroom[$value][$k1];
            }
        }   

		$returnData = array();
		$returnData['title'] =$result[0]->l_title ;
		$returnData['short_title'] =$result[0]->short_title;
		$returnData['address'] = $result[0]->l_nearby;
		$returnData['avg_rating'] = $avgRating;
		$returnData['reviews'] = $reviewResult->total() ;
		$returnData['viewed'] = $result[0]->l_view ;  
		$returnData['description'] = nl2br($result[0]->l_description); 
		$returnData['website'] = ""; 
		if ($result[0]->web_site){
		if(strpos($result[0]->web_site, "http://")){
            $returnData['website'] = $result[0]->web_site;
		}else{
			$returnData['website'] = "http://".$result[0]->web_site;
		}
	}
 
		$returnData['slider'] = array();
		if (!empty($bfiles)) {
			foreach ($bfiles as $key => $value) {
				$returnData['slider'][] ="public/images/".$result[0]->vl_id."/banner/".$value;
			}
		}else{
			
			foreach ($files as $key => $value) {
				$returnData['slider'][] ="public/images/".$result[0]->vl_id."/pics/".$value;
			}
		}
		$returnData['gallery'] = array();
		foreach ($files as $key => $value) {
				$returnData['gallery'][] ="public/images/".$result[0]->vl_id."/pics/".$value;
			}
		
		$amenities = explode(',', $result[0]->amenities);
		$returnData['amenities']= array();
		foreach ($amenities as $key => $value) {
			if(!empty($value)){
				$returnData['amenities'][] =$value;
			}
		}
		$returnData['tags'] =array();
		$tags = explode(',', $result[0]->l_key_area);
		foreach ($tags as $key => $value) {
			if(!empty($value)){
				$returnData['tags'][] =$value;
			}
		}
		$returnData['reviews_list'] = array();
		foreach ($reviewResult as $k => $v) { 
				$returnData['reviews_list'][] =array('reviewer_name'=>$v->reviewer_name,'review'=>$v->l_review,'comment'=>$v->l_comment,'date'=>$v->rcreated_at);
			
		}
		$returnData['location'] = $result[0]->l_location;
		$returnData['vendor_logo'] = 'public/images/logo/'.$result[0]->vl_id.'/'.$result[0]->logo;
		$returnData['vendor_first_name'] = $result[0]->vfname;
		$returnData['vendor_last_name'] = $result[0]->vlname ;
		$returnData['vendor_company_name'] = $result[0]->c_name ;
		
		$returnData['phone'] = $result[0]->Phone ;
		$returnData['email'] = $result[0]->email ;
		$returnData['facebook'] = $result[0]->facebook;
		$returnData['youtube'] = $result[0]->youtube ;
		
		$returnData['achievements'] = array();
		if($result[0]->achievements){
			$explode = explode('<br />', nl2br($result[0]->achievements));
			foreach ($explode as $key => $value) {
				if (trim($value) != ''){
					$returnData['achievements'][] =  trim($value);
				}
			}
			
			}
		$returnData['past_projects'] = array();
		if($result[0]->past_projects != ''){
			$explode = explode('<br />', nl2br($result[0]->past_projects)); 
			foreach ($explode as $key => $value) {
				if (trim($value) != ''){
					$returnData['past_projects'][] =  trim($value);
				}
			}
		}
		
		
		$returnData['current_project'] = array();
		if($result[0]->current_project != ''){
			$explode = explode('<br />', nl2br($result[0]->current_project)); 
			foreach ($explode as $key => $value) {
				if (trim($value) != ''){
					$returnData['current_project'][] =  trim($value);
				}
			}
		}
		
		$week = array(
                '1' => 'Monday',
                '2' => 'Tuesday',
                '3' => 'Wednesday',
                '4' => 'Thursday',
                '5' => 'Friday',
                '6' => 'Saturday',
                '7' => 'Sunday');

        $hrs = explode(',',$result[0]->working_hr);
		$returnData['working_hours']= array(); 
		for ($i=1; $i < 8; $i++) { 
			$time = 'Close';
			if (in_array($i, $hrs)) {
				$time = $result[0]->working_time;
			}
			$returnData['working_hours'][] = array('day'=>$week[$i],'time'=>$time);
		}
		
		
		
		foreach($shop_condition as $shop){
			if($shop->l_sub_category==2){
				$counter=0;
				foreach($masterArray as $key => $v){
					
					foreach($shop_condition as $shop){
						if($shop->l_sub_category=='1'){
							foreach ($v as $kv => $vv) {
								$ans = str_replace('.', '&#8228;', $kv);
								$returnData['project_details'][$key]['square'][] = $ans. ' Sq.Ft';
								
							}
						  }else{
							foreach ($v as $kv => $vv) {
								$ans = str_replace('.', '&#8228;', $kv);
								$returnData['project_details'][$key]['square'][] = $ans. ' Sq.Yard';
								
							}
						  }
						}
						
				foreach ($v as $kv => $vv){
					$ans = str_replace('.', '&#8228;', $kv);
					foreach($shop_condition as $shop){
						if($shop->l_sub_category==1){
							$returnData['project_details'][$key][$vv['super_area'][0].' Sq.Ft']['super_area']=$vv['super_area'][0].' Sq.Ft';
							$returnData['project_details'][$key][$vv['super_area'][0].' Sq.Ft']['carpet_area']=$vv['carpet_area'][0].' Sq.Ft'; 
						}else{
							$returnData['project_details'][$key][$vv['super_area'][0].' Sq.Yard']['super_area']=$vv['super_area'][0].' Sq.Yard';
							$returnData['project_details'][$key][$vv['super_area'][0].' Sq.Yard']['carpet_area']=$vv['carpet_area'][0].' Sq.Yard';
						
						}	
					}	
						$returnData['project_details'][$key]['bathrooms']=$vv['bathroom'][0];
						$returnData['project_details'][$key]['bedroom']=$vv['bedroom'][0];
						$returnData['project_details'][$key]['transaction_type']=$vv['type'][0];
						foreach($view as $info6){
							if($info6->car_parking == 1){
									$returnData['project_details'][$key]['car_parking']="Yes";
							}else{
									
									$returnData['project_details'][$key]['car_parking']="No";
							}
							$returnData['project_details'][$key]['furnishing']=$info6->furnishing;
						}
					$returnData['project_details'][$key]['listed_by']='Owner';	
				}
							
				$counter++;
				}
			}
		}
		$returnData['rera_number']=$result[0]->rera_number;
		$returnData['brochure']="";
		if($result[0]->l_brochure){
			$returnData['brochure']='public/images/brochure/'.$result[0]->vl_id.'/'.$result[0]->l_brochure;
		}
		$returnData['video']="";
		if($result[0]->l_extravideo){
			$directory = "public/images/extravideo/".$result[0]->vl_id."";
                   $files = array_values(array_diff(scandir($directory), array('..', '.')));
			if(isset($directory)){
				$returnData['video']='public/images/extravideo/'.$result[0]->vl_id.'/'.$value;		
			}	
		}
		$returnData['promo_video']="";
		if ( $result[0]->l_video_link != '' || $result[0]->l_video != ''){
				$returnData['promo_video']='public/images/'.$result[0]->vl_id.'/video/'.$result[0]->l_video;
		}
		 return \Illuminate\Support\Facades\Response::json(array(
                'success' => true,
                'code'    => 200,
                'message' => "Success",
			    'data'    => $returnData));
	
		
	}

    public function addFavourite(Request $request) {
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'property_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $user = DB::table('users')->select('*')->where('id', $request->user_id)->first();
        
        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "User not found",
                'data'    => array()
            ));
        
        }else{

            // check if already added as favourite then no change
            $favourite_count = VendorListingFavourite::getFavouritePropertyCountById($request->user_id,$request->property_id);
            if($favourite_count==0){
                $vendor_list_favourite = new VendorListingFavourite();
                $vendor_list_favourite->vl_id = $request->property_id;
                $vendor_list_favourite->u_id = $request->user_id;
                $vendor_list_favourite->save();

                return \Illuminate\Support\Facades\Response::json(array(
                    'success' => true,
                    'code'    => 200,
                    'message' => "Property added as favourite",
                    'data'    => array()
                ));
            }
            else{
                return \Illuminate\Support\Facades\Response::json(array(
                    'success' => true,
                    'code'    => 200,
                    'message' => "Property already added as favourite",
                    'data'    => array()
                ));
            }
        }
    }

    public function unFavourite(Request $request) {
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'property_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $user = DB::table('users')->select('*')->where('id', $request->user_id)->first();
        
        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "User not found",
                'data'    => array()
            ));
        
        }else{

            // check if added as favourite then no unfavourite
            $favourite_property = VendorListingFavourite::getFavouritePropertyById($request->user_id,$request->property_id);
            if(isset($favourite_property->id) && $favourite_property->id>0){
                $vendor_list_favourite = VendorListingFavourite::find($favourite_property->id);
                $vendor_list_favourite->delete();

                return \Illuminate\Support\Facades\Response::json(array(
                    'success' => true,
                    'code'    => 200,
                    'message' => "Property removed as favourite",
                    'data'    => array()
                ));
            }
            else{
                return \Illuminate\Support\Facades\Response::json(array(
                    'success' => true,
                    'code'    => 200,
                    'message' => "Property was not added as favourite",
                    'data'    => array()
                ));
            }
        }
    }

    public function getfavourite(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $user = DB::table('users')->select('*')->where('id', $request->user_id)->first();

        if(empty($user)){
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => "User not found",
                'data'    => array()
            ));
        
        }else{
           
            // get property of vendor
            $property = VendorListing::getFavouritePropertyListById($request->user_id);

            $list = array();
            $i=0;
            if(isset($property) && sizeof($property)>0){
                foreach($property as $k=>$v){
                    $list[$i]['id'] = $v->vl_id;
                    $list[$i]['title'] = $v->l_title;
                    $list[$i]['possession_date'] = $v->possession_date;
                    $list[$i]['address'] = $v->l_location;
                    $list[$i]['price'] = $v->price;
                    $list[$i]['image'] = "public/images/".$v->vl_id."/featured_image/featured_image.jpg";
                    $i++;
                }
            }

            return \Illuminate\Support\Facades\Response::json(array(
                'success' => true,
                'code'    => 200,
                'message' => "Success",
			    'data'    => $list));

        }
        
    }

    public function bookVisit(Request $request)
    {
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id'=> 'required',
            'property_id'=> 'required',
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'date' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }
        
        $property = new PropertyBookVisit();
        $property->user_id = $request->user_id;
        $property->listing_id = $request->property_id;
        $property->name = $request->name;
        $property->email = $request->email;
        $property->contact = $request->contact;
        $property->book_date = $request->date;
        $property->book_from_time = $request->from_time;
        $property->book_to_time = $request->to_time;
        $property->type = "bookvisit";
        $property->save();

        return \Illuminate\Support\Facades\Response::json(
            array('success' => true,
            'code'    => 200,
            'message' => "Book Visit has been done successfully",
			'data'    => array())
        );

    }

    public function getUserProperty(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }
           
        // get property of vendor
        $property = VendorListing::getPropertyBySearch();

        $list = array();
        $i=0;
        if(isset($property) && sizeof($property)>0){
            foreach($property as $k=>$v){
                $list[$i]['id'] = $v->vl_id;
                $list[$i]['title'] = $v->l_title;
                $list[$i]['possession_date'] = $v->possession_date;
                $list[$i]['address'] = $v->l_location;
                $list[$i]['price'] = $v->price;
                $list[$i]['image'] = "public/images/".$v->vl_id."/featured_image/featured_image.jpg";
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list)
        );
        
    }

    public function bookInquiry(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'property_id'=> 'required',
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'message' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }

        $property_book_visit = new PropertyBookVisit();
        $property_book_visit->user_id = $request->user_id;
        $property_book_visit->listing_id = $request->property_id;
        $property_book_visit->name = $request->name;
        $property_book_visit->email = $request->email;
        $property_book_visit->contact = $request->contact;
        $property_book_visit->message = $request->message;
        $property_book_visit->type = "inquiry";
        $property_book_visit->save();

        $book_visit_id = $property_book_visit->id;

        /*if($book_visit_id>0){
            // send message to who raise inquiry
            $otpmessage = urlencode("Thank you for contacting us.");
            $phone = '9712618161'; //$request->contact;

            $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,'http://sms.incisivewebsolution.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=667810964beb48fcf4f157b070dd89fa&message='.$otpmessage.'&senderId=YASSIR&routeId=1&mobileNos='.$phone.'&smsContentType=english');
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
            $query = curl_exec($curl_handle);
            curl_close($curl_handle);

            // send message to owner of property

            $owner_mobile = '9712618161'; 
            $otpownermessage = urlencode("Tarika has requested for inquiry. Please find contact info as below.");
            $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,'http://sms.incisivewebsolution.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=667810964beb48fcf4f157b070dd89fa&message='.$otpownermessage.'&senderId=YASSIR&routeId=1&mobileNos='.$owner_mobile.'&smsContentType=english');
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
            $query = curl_exec($curl_handle);
            curl_close($curl_handle);

        }*/

        return \Illuminate\Support\Facades\Response::json(
            array('success' => true,
            'code'    => 200,
            'message' => "Inquiry has been submitted successfully",
			'data'    => array())
        );

    }
    
    public function getUserInquiries(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }


        $property_inquiries = PropertyBookVisit::getAllUserInquiries($request->user_id);

        return $property_inquiries;

        $list = array();
        $i=0;
        if(isset($property_inquiries) && sizeof($property_inquiries)>0){
            foreach($property_inquiries as $k=>$v){
                $list[$i]['id'] = $v->vl_id;
                $list[$i]['image'] = "public/images/".$v->vl_id."/featured_image/featured_image.jpg";
                $list[$i]['title'] = $v->l_title;
                $list[$i]['inquiry_date'] = date("d-M-Y",strtotime($v->created_at));
                $list[$i]['address'] = $v->l_location;
                $list[$i]['status'] = $v->status;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list)
        );

    }

    public function getVendorInquiries(Request $request) {
        
        $token = CommonController::checkAccessToken();
        if ($token->getData()->success != 1) {
            return CommonController::customAPIResponse(false, 401, 'Invalid token.', []);
        }

        //valid credential
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $validator->errors()->all(':message');
            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'code'    => 442,
                'message' => $error[0],
                'data'    => (object) $errors
            ));
        }


        $property_inquiries = PropertyBookVisit::getAllVendorInquiriesList($request->user_id);

        return $property_inquiries;

        $list = array();
        $i=0;
        if(isset($property_inquiries) && sizeof($property_inquiries)>0){
            foreach($property_inquiries as $k=>$v){
                $list[$i]['id'] = $v->vl_id;
                $list[$i]['image'] = "public/images/".$v->vl_id."/featured_image/featured_image.jpg";
                $list[$i]['title'] = $v->l_title;
                $list[$i]['inquiry_date'] = date("d-M-Y",strtotime($v->created_at));
                $list[$i]['address'] = $v->l_location;
                $list[$i]['status'] = $v->status;
                $i++;
            }
        }

        return \Illuminate\Support\Facades\Response::json(array(
            'success' => true,
            'code'    => 200,
            'message' => "Success",
            'data'    => $list)
        );

    }
}