<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Image;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [];
    protected $guarded = ['id'];

    //Get all product list
    public static function getAllProducts($vendor='')
    {
        
        $pro = DB::table('product')
                ->select('product.*','vendor_listing.url_name','vendor_listing.first_name','vendor_listing.last_name','vendor_listing.vl_id','vendor_listing.l_title','category_type_material.id as mid','category_type_material.name','product_category.vendor_id','product_category.cate_name')

            ->leftjoin('vendor_listing','vendor_listing.u_id','product.v_id','users.id')
             ->join('users','users.id','product.v_id')
            ->join('category_type_material','category_type_material.id','=','product.sub_cat_id')
            ->leftjoin('product_category','product_category.cate_id','product.product_category')
            ->orderBy('product.id','DESC');
          
        if ($vendor != '' && $vendor != 'null') {
            $pro->where('v_id',$vendor);
        }

        $product = $pro->paginate(20);
    
        return $product;

    }

    //Grab all the product category
    public static function getProductCategory($vendor='')
    {
        $cat = array();

        $cate = DB::table('product_category');

        if ($vendor != '' && $vendor != 'null') {
            $cate->where('vendor_id',$vendor);
        }

        $category = $cate->orderBy('created_at','DESC')
                    ->get()
                    ->toArray();

        if (!empty($category)) {
            foreach ($category as $key => $value) {
                $cat[$value->cate_id] = $value->cate_name;
            }
        }

        return $cat;
    }

    //Get type list
    public static function getType()
    {
        $type = DB::table('category_type_material')->get()->toArray();

        return $type;
    }

    //Store new product 
    public static function storeNewProduct()
    {
        //Store new category
        $product_id = DB::table('product')->insertGetId(
            ['v_id' => $_POST['vendor'], 'cat_id' => '4', 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'], 'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'product_img' => trim(str_replace(" ","_", $_FILES['inputFile']['name'])), 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s') ]
        );

        Product::uploadImages($_FILES,'product',$product_id);

        return 'true';
    }

    //Get product information
    public static function getProductInfo($productID)
    {
        $product = DB::table('product')
            ->where('id',$productID)
            ->get()
            ->toArray();

        return $product[0];
       

    }

    //Update product
    public static function updateProduct()
    {
        DB::table('product')
            ->where('id', $_POST['pro_id'])
            ->update(['v_id' => $_POST['vendor'], 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'], 'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'updated_at' => date('Y-m-d h:i:s') ]);

        //Check user has updated new image
        if (isset($_FILES['inputFile']["name"]) && $_FILES['inputFile']["name"] != '') {
            DB::table('product')
            ->where('id', $_POST['pro_id'])
            ->update(['product_img' => trim(str_replace(" ","_", $_FILES['inputFile']['name']))]);

            //Upload image to folder
            Product::uploadImages($_FILES,'product',$_POST['pro_id']);
        }

        return true;
    }

    //Destroy record
    public static function destroyRecord($productID)
    {
        DB::table('product')->where('id', '=', $productID)->delete();

        return true;
    }

    //Upload Images
    public static function uploadImages($files='',$targetdir='',$id='')
    {
        if(isset($_FILES["inputFile"]["name"]) && $_FILES["inputFile"]["name"] != '')
        {
        $target_dir = "public/images/".$targetdir."/".$id;

        //Create folder
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir.'/' . trim(str_replace(" ","_", trim(str_replace(" ","_", $_FILES['inputFile']['name']))));
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["inputFile"]["tmp_name"]);
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
            if (move_uploaded_file($_FILES["inputFile"]["tmp_name"], $target_file)) {
                echo "The file ". basename( trim(str_replace(" ","_", $_FILES['inputFile']['name']))). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

        return 'true';

    }
}