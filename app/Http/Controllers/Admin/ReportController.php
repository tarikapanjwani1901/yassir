<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Review;
use App\vendor_listing;
use App\vendor_listing_review;
use DB;
use Illuminate\Support\Str;
use App\product;
use File;
class ReportController extends Controller
{
    public function get(Request $r)
    {
    	$showData = DB::table('user_details')
        ->join('users', 'user_details.user_id', '=', 'users.id')
        ->where("user_details.user_role","3")->orderBy('first_name', 'asc')
        ->get()
        ->toArray();

        $category = DB::table('category')->get()->toArray();
    	$rid = $r->input('review');

		return view('admin.report_list',['data'=>$showData,'rid'=>$rid,'category'=>$category]);
    }

    public function getdata(Request $r)
    {
        $sub="";
        $data=$r->input('v');
        $rev=$r->input('r');
        $cat=$r->input('c');
        $sub_cat=$r->input('sc');
        $type="";
        $html='';
        $record='';
        if($data)
        {
                    $c = DB::table('product')
                    ->where('sub_cat_id','=',$sub_cat)->where('v_id','=',$data)
                    ->get()
                    ->toArray();
                    if(isset($cat) && isset($sub_cat))
                    {
                    $l=vendor_listing::where('u_id',$data)->where('l_category',$cat)->where('l_sub_category',$sub_cat)->get();
                    }
                    else
                    {
                        $l=vendor_listing::where('u_id',$data)->get();
                    }
        }
        else
        {
            $c = DB::table('product')
                    ->where('sub_cat_id','=',$sub_cat)
                    ->get()
                    ->toArray();
            $l=vendor_listing::where('l_category',$cat)->where('l_sub_category',$sub_cat)->get();

        }
        if($cat==4)
        {
            $record = '';
                    foreach($c as $row)
                    {
                        $record .='<tr><td>'.$row->product_name.'</td>
                         <td>'.$row->product_category.'</td>
                         <td>'.$row->product_price.'</td>
                         <td>'.$row->product_qty.'</td>
                         <td>'.$row->product_detail.'</td>
                         <td><img src="../../images/product/'.$row->product_img.'" height="50px" width="50px"></td>
                         <td><a href="edit_report/'.$row->id.'"class="btn btn-success">Edit</a></td>
                         <td><a href="delete_report/'.$row->id.'?cat='.$row->cat_id.'" class="btn btn-danger">Delete</a></td>
                          </tr>';
                    }
        }
       else if($cat==2 || $cat==3)
        {
        $record = '';
        foreach($l as $row)
            {
                $total=vendor_listing_review::where('l_id',$row->vl_id)->sum('l_review');
                $review=vendor_listing_review::where('l_id',$row->vl_id)->count();

                if($review==0)
            {
                $review=1;
            }
                $avg=$total/$review;
                $record .='<tr><td>'.$row->l_title.'</td>
                        <td>'.$row->l_location.'</td>
                            <td>'.$row->l_nearby.'</td>
                            <td>'.$row->type.'</td>
                         <td>'.$row->price.'</td>
                         <td>'.$row->listed_by.'</td>
                         <td>'.$avg.'</td>
                          <td><a href="edit_report/'.$row->vl_id.'"class="btn btn-success">Edit</a></td>
                         <td><a href="delete_report/'.$row->vl_id.'" class="btn btn-danger">Delete</a></td></tr>';
            }
        }
        else
        {
            $record = '';
        foreach($l as $row)
            {
                $total=vendor_listing_review::where('l_id',$row->vl_id)->sum('l_review');
                $review=vendor_listing_review::where('l_id',$row->vl_id)->count();
                $rev_count=vendor_listing_review::where('l_id',$row->vl_id)->where('l_review',$rev)->count();
                if($review==0)
            {
                $review=1;
            }
                $avg=$total/$review;
                $html='<option value="'.$row->vl_id.'">' . $row->l_title . '</option>';
                $record .='<tr><td>'.$row->l_location.'</td>
                         <td>'.Str::words($row->l_description, 10).'</td>
                         <td>'.$row->price.'</td>
                         <td>'.$row->bedroom.'</td>
                         <td>'.$row->bathroom.'</td>
                         <td>'.$row->super_area.'</td>
                         <td>'.$row->carpet_area.'</td>
                         <td>'.$row->floor.'</td>
                         <td>'.$avg.'</td>
                         <td>'.$rev_count.'</td>
                          <td><a href="edit_report/'.$row->vl_id.'"class="btn btn-success">Edit</a></td>
                         <td><a href="delete_report/'.$row->vl_id.'" class="btn btn-danger">Delete</a></td></tr>';
            }
        }
            $arr['select']=$html;
            $arr['rec']=$record;
            return json_encode($arr);
    }
    public function edit($id)
    {
        $report = DB::table('vendor_listing')
                    ->where('vl_id','=',$id)
                    ->get()
                    ->toArray();
        $product = DB::table('product')
                    ->where('id','=',$id)
                    ->get()
                    ->toArray();
                    if($product)
                		return view('admin.reportedit')->with('product', $product);
                   	else if($report)
        				return view('admin.reportedit')->with('report', $report);

    }
    public function update(Request $r)
    {
         $id = $_POST['id'];
         $category=$_POST['cat_id'];
         if($category==4)
         {
         	DB::table('product')
            ->where('id', $id)
            ->update(['product_name' => $_POST['product_name'], 'product_category' => $_POST['product_category'], 'product_price' => $_POST['product_price'], 'product_qty' => $_POST['product_qty'],'product_detail' => $_POST['product_detail'],'product_img' => $_FILES['product_img']["name"],'updated_at' => date('Y-m-d h:i:s')]);
            $target_dir = "public/images/product/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir.'/' . trim(str_replace(" ","_", $_FILES['product_img']['name']));
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["product_img"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["product_img"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
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
                if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["product_img"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
         }
         else
         {
         	DB::table('vendor_listing')
            ->where('vl_id', $id)
            ->update(['l_title' => $_POST['l_title'], 'l_location' => $_POST['l_location'], 'l_nearby' => $_POST['l_nearby'], 'l_description' => $_POST['l_description'],'price' => $_POST['price'],'bedroom' => $_POST['bedroom'],'bathroom' => $_POST['bathroom'], 'super_area' => $_POST['super_area'],'carpet_area' => $_POST['carpet_area'],'status' => $_POST['status'],'floor' => $_POST['floor'],'type' => $_POST['type'],'car_parking' => $_POST['car_parking'],'furnishing' => $_POST['furnishing'],'listed_by' => $_POST['listed_by'],'updated_at' => date('Y-m-d h:i:s')]);
         }
        return redirect('admin/report');

    }
    public function delete($id ,Request $r)
    {
    	if(isset($_GET['cat']))
    	{
    		$cat_id= $_GET['cat'];
    		if($cat_id==4)
    		{
        		DB::table('product')->where('id', '=', $id)->delete();
    		}
    	}
    	else
    	{
        	DB::table('vendor_listing')->where('vl_id', '=', $id)->delete();
    	}
        return redirect('admin/report');
    }
    public function showvendor(Request $r)
    {
        $showData = DB::table('user_details')
        ->join('users', 'user_details.user_id', '=', 'users.id')
        ->where("user_details.user_role","3")->orderBy('first_name', 'asc')
        ->get()
        ->toArray();
        $category=DB::table('category')->get()->toArray();
        $rid=$r->input('review');
        return view('admin.reportadd',['data'=>$showData,'rid'=>$rid,'category'=>$category]);
    }


    public function add(Request $r)
    {
        if($_POST['category']==4)
        {
            DB::table('product')
            ->insertGetId(['v_id' => $_POST['vendor'],'product_name' => $_POST['product_name'], 'product_category' => $_POST['product_category'], 'product_price' => $_POST['product_price'], 'product_qty' => $_POST['product_qty'],'product_detail' => $_POST['product_detail'],'product_img' => $_FILES['product_img']["name"],'cat_id' => $_POST['category'],'sub_cat_id' => $_POST['sub_category'],'created_at' => date('Y-m-d h:i:s')]);

            $target_dir = "public/images/product/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir.'/' . trim(str_replace(" ","_", $_FILES['product_img']['name']));
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["product_img"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["product_img"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
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
                if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["product_img"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        else
        {
            DB::table('vendor_listing')
            ->insertGetId(['u_id' => $_POST['vendor'],'l_title' => $_POST['l_title'], 'l_location' => $_POST['l_location'], 'l_nearby' => $_POST['l_nearby'], 'l_description' => $_POST['l_description'],'price' => $_POST['price'],'bedroom' => $_POST['bedroom'],'bathroom' => $_POST['bathroom'], 'super_area' => $_POST['super_area'],'carpet_area' => $_POST['carpet_area'],'status' => $_POST['status'],'floor' => $_POST['floor'],'type' => $_POST['type'],'car_parking' => $_POST['car_parking'],'furnishing' => $_POST['furnishing'],'listed_by' => $_POST['listed_by'],'l_category' => $_POST['category'],'l_sub_category' => $_POST['sub_category'],'created_at' => date('Y-m-d h:i:s')]);
            $id = DB::table('vendor_listing')->select('vl_id')->where('created_at',date('Y-m-d h:i:s'))->get();
                $path = public_path().'/images/'.$id[0]->vl_id;
                File::makeDirectory($path);
                $pics=$path.'/pics';
                File::makeDirectory($pics);


        }
        return redirect('admin/report');
    }

    public function sub_cat_Ajax(Request $r) {
        $cat = $r->input('category');

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

        return $type;
    }
    
public function vendor_ajax(Request $request) {
        $cat = $request->input('category');
        $sub = $request->input('sub_cat');

              $showData = DB::table('users')
            ->select('users.id as user_id', 'users.company_name')
            ->whereNull('users.deleted_at');

        if ($cat != '' && $cat != 'null') {
            $showData->where("users.user_category",$cat);
        }

/*        if ($sub != 'null' && $sub != '') {
            $showData->where("vendor_listing.l_sub_category",$sub);
        }*/

       // $result = $showData->groupBy('vendor_listing.u_id')->get()->toArray();
         $result = $showData->groupBy('users.id')->get()->toArray();
        return $result;
    }

    public function otplisting_ajax(Request $request) {
        $cat = $request->input('category');
        $sub = $request->input('sub_cat');

            $showData = DB::table('users')
            ->select('users.id as user_id', 'users.company_name')
            ->whereNull('users.deleted_at');

        if ($cat != '' && $cat != 'null') {
            $showData->where("users.user_category",$cat);
        }

/*        if ($sub != 'null' && $sub != '') {
            $showData->where("vendor_listing.l_sub_category",$sub);
        }*/

       // $result = $showData->groupBy('vendor_listing.u_id')->get()->toArray();
         $result = $showData->groupBy('users.id')->get()->toArray();
        return $result;
    }

    public function vendorlisting_data(Request $request) {
        $cat = $request->input('category');
        $sub = $request->input('sub_cat');

        $showData = DB::table('users')
            ->select('users.id as user_id', 'users.company_name')
            ->whereNull('users.deleted_at')->orderBy('company_name','asc');

        if ($cat != '' && $cat != 'null') {
            $showData->where("users.user_category",$cat);
        }

/*        if ($sub != 'null' && $sub != '') {
            $showData->where("vendor_listing.l_sub_category",$sub);
        }*/

        $result = $showData->groupBy('users.id')->get()->toArray();

        return $result;
    }

}