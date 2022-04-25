<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    //Grab all the product category
    public static function getProductCategory($vendor='')
    {
        $cate = DB::table('product_category')->orderBy('cate_id','desc');

        if ($vendor != '' && $vendor != 'null') {
            $cate->where('vendor_id',$vendor);
        }

        $category = $cate->orderBy('cate_name','DESC')
                ->paginate(10);

        return $category;
    }

    //Store new category value
    public static function storeNewCategory()
    {
        //Store new category
        if(isset($_FILES['inputFile']['name']) && $_FILES['inputFile']["name"] != '')
        {
            $file=trim(str_replace(" ","_", $_FILES['inputFile']['name']));
        }
        else
        {
            $file="";
        }
        $categoryid = DB::table('product_category')->insertGetId(
            ['cate_name' => $_POST['name'], 'vendor_id' => $_POST['vendor'], 'cate_slug' => (str_replace(' ', '_', strtolower($_POST['name']))), 'cate_desc' => $_POST['message'], 'cate_image' => $file, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s') ]
        );

        Product::uploadImages($_FILES,'product_category',$categoryid);

        return true;
    }

    //Get the category information
    public static function getCategoryInfo($categoryID)
    {
        $category = DB::table('product_category')
            ->where('cate_id',$categoryID)
            ->get()
            ->toArray();

        return $category[0];
    }

    //Update the record
    public static function updateRecord()
    {
        DB::table('product_category')
            ->where('cate_id', $_POST['cate_id'])
            ->update(['cate_name' => $_POST['name'],'vendor_id' => $_POST['vendor'], 'cate_slug' => (str_replace(' ', '_', strtolower($_POST['name']))), 'cate_desc' => $_POST['message'],  'updated_at' => date('Y-m-d h:i:s')]);

        //Check user has updated new image
        if (isset($_FILES['inputFile']["name"]) && $_FILES['inputFile']["name"] != '') {
            DB::table('product_category')
            ->where('cate_id', $_POST['cate_id'])
            ->update(['cate_image' => trim(str_replace(" ","_", $_FILES['inputFile']['name']))]);

            //Upload image to folder
            Product::uploadImages($_FILES,'product_category',$_POST['cate_id']);
        }

        return true;
    }

    //Destroy record
    public static function destroyRecord($categoryID)
    {
        DB::table('product_category')->where('cate_id', '=', $categoryID)->delete();

        return true;
    }
}