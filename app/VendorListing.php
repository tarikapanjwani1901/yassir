<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;
use Storage;
class VendorListing extends Model
{

    Protected  $table = "vendor_listing";
    //Get all the listing based on the filers
    public static function getAllListing($cate='',$subCate='',$vendor='',$listing='',$city='',$area='')
    {
    	$allListing = DB::table('vendor_listing')
    		->select(DB::raw('ROUND(SUM(vendor_listing_review.l_review) / COUNT(vendor_listing_review.l_id)) as result,vendor_listing.*,users.id,user_details.user_id','vendor_listing.updated_at as vl_updated_at'))
    		->leftjoin('vendor_listing_review','vendor_listing.vl_id', '=', 'vendor_listing_review.l_id')
    		->leftjoin('users','users.id', '=', 'vendor_listing.u_id')
    		->leftjoin('user_details','user_details.user_id', '=', 'users.id')->orderBy('vendor_listing.vl_id','desc');
            
    	if ($cate != '' && $cate != 'null') {
            $allListing->where("vendor_listing.l_category",$cate);
        }

        if ($city != '' && $city != 'null') {
            $allListing->where("vendor_listing.city",$city);
        }

        if ($area != '' && $area != 'null') {
            $allListing->where("vendor_listing.area",$area);
        }

        if ($subCate != 'null' && $subCate != '') {
            //$allListing->where("vendor_listing.l_sub_category",$subCate);
            $allListing->whereRaw("find_in_set(?,vendor_listing.l_sub_category)",[$subCate]);
        }

        if ($vendor != 'null' && $vendor != '') {
            $allListing->where("vendor_listing.u_id",$vendor);
        }

        if ($listing != 'null' && $listing != '') {
            $allListing->where("vendor_listing.vl_id",$listing);
        }

    	$result = $allListing->groupBy('vendor_listing.vl_id')->orderBy('result','DESC')->paginate(10);

    	return $result;
    }

    //Get File Name
    public static function viewFile($cate)
    {
    	switch ($cate) {
            case '1':
                $type = 'admin.vendorlisting_property';
                break;
            case '2':
                $type = 'admin.vendorlisting';
                break;
            case '3':
                $type = 'admin.vendorlisting';
                break;
            case '4':
                $type = 'admin.vendorlisting_material';
                break;
            case '5':
                $type = 'admin.vendorlisting';
                break;    
                
        }

        return $type;
    }

    //Get the product category
    public static function getProductCategory($vendor='',$category='',$subCate='')
    {
        $productCate = DB::table('product_category')
            ->leftjoin('product','product_category.cate_id', '=', 'product.product_category');

        if ($category != '' && $category != 'null') {
            $productCate->where("product.cat_id",$category);
        }

        if ($vendor != 'null' && $vendor != '') {
            $productCate->where("product.v_id",$vendor);
        }

        if ($subCate != 'null' && $subCate != '') {
            $productCate->where("product.sub_cat_id",$subCate);
        }

        $result = $productCate->groupBy('product_category.cate_id')->orderBy('product_category.cate_name','DESC')->get()->toArray();

        return json_encode($result);
    }


    //Store new listing entry
    public static function storeListing($request='')
    {
         $type1 = $_POST['price']['type'][0];
        if(isset($_POST['sub']))
        {
            $ans= implode(',',$_POST['sub']);
        }
        else if(isset($_POST['sub_cat']))
        {
            $ans=$_POST['sub_cat'];
        }
        $file=trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['video']['name']))));
        //Store the entire
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
                       'price' => (isset($_POST['price'][$type1][0]) && ($_POST['price'][$type1][0] != "")) ? json_encode($_POST['price']) : '',
                        'price_perft' => (isset($_POST['price_perft'][$type1][0]) && ($_POST['price_perft'][$type1][0] != "")) ? json_encode($_POST['price_perft']) : '',
                        'short_title' => (isset($_POST['p_short'][$type1][0]) && ($_POST['p_short'][$type1][0] != "")) ? json_encode($_POST['p_short']) : '',
                        'bedroom' => (isset($_POST['bedroom'][$type1][0]) && ($_POST['bedroom'][$type1][0] != "")) ? json_encode($_POST['bedroom']) : '',
                        'bathroom' => (isset($_POST['bathrooms'][$type1][0]) && ($_POST['bathrooms'][$type1][0] != "")) ?  json_encode($_POST['bathrooms']) : '',
                        'super_area' => (isset($_POST['super_area'][$type1][0]) && ($_POST['super_area'][$type1][0] != "")) ? json_encode($_POST['super_area']) : '',
                        'carpet_area' => (isset($_POST['carpet_area'][$type1][0]) && ($_POST['carpet_area'][$type1][0] != "")) ? json_encode($_POST['carpet_area']) : '',
                        'status' => (isset($_POST['p_status'][$type1][0]) && ($_POST['p_status'][$type1][0] != "")) ? json_encode($_POST['p_status']) : '',
                        'floor' => (isset($_POST['floor'][$type1][0]) && ($_POST['floor'][$type1][0] != "")) ? json_encode($_POST['floor']) : '',
                        'type' => (isset($_POST['transaction_type'][$type1][0]) && ($_POST['transaction_type'][$type1][0] != "")) ? json_encode($_POST['transaction_type']) : '',
                        'car_parking'=> (isset($_POST['car_parking'][$type1][0]) && ($_POST['car_parking'][$type1][0] != "")) ?  json_encode($_POST['car_parking']) : '',
                        'furnishing' => (isset($_POST['furnishing'][$type1][0]) && ($_POST['price'][$type1][0] != "")) ?   json_encode($_POST['furnishing']) : '',
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
                    ]
        );

        if (isset($_FILES['video']['tmp_name']) && $_FILES['video']['tmp_name'] != '') {
            $uploadDirectory = public_path().'/images/' .$vl_id.'/video/';

            if (!file_exists($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
            }

            $target_file = $uploadDirectory.'/' . $file;

            if(move_uploaded_file($_FILES['video']['tmp_name'], $target_file)) {
                echo "The file ". basename( $_FILES['video']['name']). " has been uploaded";
            } else {
                echo "Sorry, there was a problem uploading your file.";
            }
        }

        if (isset($_FILES['featured_image']['tmp_name']) && $_FILES['featured_image']['tmp_name'] != '') {
            $path = public_path().'/images/' .$vl_id.'/featured_image/';

            if (!file_exists($path)) {
                    mkdir($path, 0777, true);
            }

            $target_path = $path.'/' . "featured_image.jpg";

            if(move_uploaded_file($_FILES['featured_image']['tmp_name'], $target_path)) {
                echo "The file ". basename( $_FILES['featured_image']['name']). " has been uploaded";
            } else {
                echo "Sorry, there was a problem uploading your file.";
            }
        }

        //Check gallery is set
        if (isset($_FILES["inputFile"]["tmp_name"][0]) && $_FILES["inputFile"]["tmp_name"][0] != '') {
            VendorListing::MultipleImageUpload($_FILES,'vendor_listing',$vl_id);
        }

        //Check banner is set
        if (isset($_FILES["banner"]["tmp_name"][0]) && $_FILES["banner"]["tmp_name"][0] != '') {
            VendorListing::MultipleImageUploader($_FILES,'banner',$vl_id);
        }

        if (isset($_FILES["brochure"]["tmp_name"]) && $_FILES["brochure"]["tmp_name"] != '') {
            VendorListing::uploadFiles($_FILES,'brochure',$vl_id);

            //Update brochure name in database
            DB::table('vendor_listing')
                ->where('vl_id', $vl_id)
                ->update(['l_brochure' => trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['brochure']['name']))))]);
        }

        return 'true';
    }

    //Multiple image upload
    public static function MultipleImageUpload($files='',$targetdir='',$id='')
    {
        foreach($_FILES['inputFile']["tmp_name"] as $key => $tmp_name) {;

            $target_dir = "public/images/".$id."/pics";

            //Create folder
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir.'/' . trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['inputFile']['name'][$key]))));
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['inputFile']["tmp_name"][$key]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES['inputFile']["tmp_name"][$key], $target_file)) {
                    echo "The file ". basename( trim(str_replace(" ","_", $_FILES['inputFile']['name'][$key]))). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        return 'true';
    }

    //Multiple image uploader
    public static function MultipleImageUploader($files='',$targetdir='',$id='')
    {
        foreach($_FILES['banner']["tmp_name"] as $key => $tmp_name) {;

            $target_dir = "public/images/".$id."/banner";

            //Create folder
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir.'/' . trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['banner']['name'][$key]))));
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['banner']["tmp_name"][$key]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES['banner']["tmp_name"][$key], $target_file)) {
                    echo "The file ". basename( trim(str_replace(" ","_", $_FILES['banner']['name'][$key]))). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        return 'true';
    }

    //File unloader
    public static function uploadFiles($files='',$targetdir='',$id='')
    {
        $target_dir = "public/images/".$targetdir."/".$id;

        //Create folder
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir.'/' . trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['brochure']['name']))));
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["brochure"]["tmp_name"], $target_file)) {
                echo "The file ". basename( trim(str_replace(" ","_", $_FILES['brochure']['name']))). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        return 'success';
    }

    //Get the vendor listing
    public static function getVendorListing($id='')
    {
        $allListing = DB::table('vendor_listing')->select('vendor_listing.*')
                        ->where('vl_id','=',$id)
                        ->get()
                        ->toArray();

        return $allListing[0];
    }

    //Get the category list
    public static function getVendorProductCategory($category,$vendor)
    {
        $result = DB::select('SELECT
                              *
                            FROM
                              `product_category`
                              LEFT JOIN `product`
                                ON FIND_IN_SET(
                                  `product_category`.`cate_id`,
                                  `product`.`product_category`
                                )
                            WHERE product.`v_id` = '.$vendor.'
                            GROUP BY product_category.`cate_id`');

        return $result;
    }

    //Update the listing
    public static function updateListing()
    {
        if(isset($_POST['sub']) && $_POST['sub'] != "")
        {
            $ans= implode(',',$_POST['sub']);
        }
       else if(isset($_POST['sub_cat']) && $_POST['sub_cat'] != "")
        {
            $ans=$_POST['sub_cat'];
        }

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
                'price' => (isset($_POST['price'])) ? json_encode($_POST['price']) : '',
                'price_perft' => (isset($_POST['price_perft'])) ? json_encode($_POST['price_perft']) : '',
                'short_title' => (isset($_POST['p_short'])) ? json_encode($_POST['p_short']) : '',
                'bedroom' => (isset($_POST['bedroom'])) ? json_encode($_POST['bedroom']) : '',
                'bathroom' => (isset($_POST['bathrooms'])) ?  json_encode($_POST['bathrooms']) : '',
                'super_area' => (isset($_POST['super_area'])) ? json_encode($_POST['super_area']) : '',
                'carpet_area' => (isset($_POST['carpet_area'])) ? json_encode($_POST['carpet_area']) : '',
                'status' => (isset($_POST['p_status'])) ? json_encode($_POST['p_status']) : '',
                'floor' => (isset($_POST['floor'])) ? json_encode($_POST['floor']) : '',
                'type' => (isset($_POST['transaction_type'])) ? json_encode($_POST['transaction_type']) : '',
                'car_parking'=> (isset($_POST['car_parking'])) ?  json_encode($_POST['car_parking']) : '',
                'furnishing' => (isset($_POST['furnishing'])) ?   json_encode($_POST['furnishing']) : '',
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
                'working_hr' => implode(',',$_POST['workinghrs']),
                'working_time' => $_POST['working_time'],
                'l_featured' => (isset($_POST['l_feature']) && $_POST['l_feature'] == 'on') ? '1' : '0',

            ]);

        if (isset($_FILES['featured_image']['tmp_name']) && $_FILES['featured_image']['tmp_name'] != '') {
            $path = public_path().'/images/' . $_POST['vl_id'].'/featured_image';

            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            $target_path = $path.'/' . "featured_image.jpg";

            if(move_uploaded_file($_FILES['featured_image']['tmp_name'], $target_path))
            {
                echo "The file ". basename( $_FILES['featured_image']['name']). " has been uploaded";
            }
            else
            {
                echo "Sorry, there was a problem uploading your file.";
            }
        }

        //Check gallery is set
        if (isset($_FILES["inputFile"]["tmp_name"][0]) && $_FILES["inputFile"]["tmp_name"][0] != '') {
            VendorListing::MultipleImageUpload($_FILES,'vendor_listing',$_POST['vl_id']);
        }

        //Check banner is set
        if (isset($_FILES["banner"]["tmp_name"][0]) && $_FILES["banner"]["tmp_name"][0] != '') {
            VendorListing::MultipleImageUploader($_FILES,'banner',$_POST['vl_id']);
        }

        if (isset($_FILES["brochure"]["tmp_name"]) && $_FILES["brochure"]["tmp_name"] != '') {
            VendorListing::uploadFiles($_FILES,'brochure',$_POST['vl_id']);

            //Update brochure name in database
            DB::table('vendor_listing')
                ->where('vl_id', $_POST['vl_id'])
                ->update(['l_brochure' => trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['brochure']['name']))))]);
        }

        
    }
}