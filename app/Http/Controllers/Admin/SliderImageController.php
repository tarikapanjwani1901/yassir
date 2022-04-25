<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class SliderImageController extends Controller
{
    public function slider()
    {
        return view('admin.sliderimage_add');
    }
    public static function MultipleImageUpload($files='',$targetdir='')
    {
        foreach($_FILES['inputFile']["tmp_name"] as $key => $tmp_name) {

            $target_dir = "public/images/home_galery";

            //Create folder
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir.'/' . trim(str_replace(array('(',')'),"", trim(str_replace(" ","_", $_FILES['inputFile']['name'][$key]))));
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
                    echo "The file ". basename( trim(str_replace(array('(',')'),"", trim(str_replace(" ","_", $_FILES['inputFile']['name'][$key]))))). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        return 'true';
    }

    public static function add_slider(Request $request)
    {

       if (isset($_FILES["inputFile"]["tmp_name"]) && $_FILES["inputFile"]["tmp_name"]!= '')
         {
            // SliderImageController::MultipleImageUpload($_FILES,'home_galery');
            $target_dir = "public/images/home_galery";
           

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_dirr = "public/images/home_galery/".$request->file('home_galery');

            $photo = $request->file('inputFile');
             $imagename = $photo->getClientOriginalName();  
            $destinationPath = public_path('/images/home_galery/'.$request->file('home_galery'));
            $thumb_img = Image::make($photo->getRealPath())->resize(1345, 400);
            $thumb_img->save($destinationPath.'/'.$imagename,80);
       
        return redirect('admin/slider_image');
       
        }
    }

    public static function add()
    {
        if (isset($_FILES["inputFile"]["tmp_name"]) && $_FILES["inputFile"]["tmp_name"] != '') {
            $target_dir = "public/images/home_add";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir.'/' . trim(str_replace(array('(',')'),"", trim(str_replace(" ","_", $_FILES['inputFile']['name']))));

            if (move_uploaded_file($_FILES['inputFile']["tmp_name"], $target_file)) {
                    echo "The file ". basename( trim(str_replace(array('(',')'),"", trim(str_replace(" ","_", $_FILES['inputFile']['name']))))). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
        }

        return redirect('admin/slider_image');
    }
}
