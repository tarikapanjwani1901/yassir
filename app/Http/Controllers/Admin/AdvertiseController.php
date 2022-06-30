<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\Models\Advertise;
use App\Inquiry;
use Sentinel;

class AdvertiseController extends JoshController
{

    public function index(Request $request)
    {
     
        if(Sentinel::inRole('admin')){
            $advertise_response = Advertise::getAllAdvertise();
        }
        else{
            $user_id = Sentinel::getUser()->id;
            $advertise_response = Advertise::getAllAdvertiseByUserId($user_id);
        }
        
        return view('admin.advertise.index')->with('advertise',$advertise_response);
    }

    public function create()
    {
        
        //Grab all vendors
        $vendors = Inquiry::getVendor();

    	return view('admin/advertise/create',compact('vendors'));
    }

    public function edit(Advertise $adt,$adID)
    {

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        // get advertise
        $advertise = Advertise::getAdvertiseById($adID);

        return view('admin.advertise.edit')->with('vendors',$vendors)->with('advertise',$advertise);

    }

    public function addAdvertise(Request $request)
    { 

        if($request->hasFile('image')) { 

            $photo = $request->file('image');
            $imagename = $photo->getClientOriginalName(); 

            $filename = $_FILES['image']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            $file_type = 'video';
            if($ext=='jpg' || $ext=='JPG' || $ext=='PNG' || $ext=='png' || $ext=='jpeg' || $ext=='JPEG' || $ext=='gif' || $ext=='GIF'){
                $file_type = 'image';
            }

            $advt_id = DB::table('advertise')->insertGetId([
                'vendor_id' => $_POST['vendor_id'], 
                'title' => $_POST['title'], 
                'file_name' => $imagename, 
                'file_path' => "", 
                'file_type' => $file_type, 
                'created_at' => date('Y-m-d h:i:s'), 
                'updated_at' => date('Y-m-d h:i:s') ]
            );

            $target_dir = "public/images/advertise/".$advt_id; 

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $destinationPath = public_path().'/images/advertise/'. $advt_id;
            if($file_type=='video'){
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$imagename);
            }
            else{
                $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
                $thumb_img->save($destinationPath.'/'.$imagename,80);
            }
            

            DB::table('advertise')
            ->where('id', $advt_id)
            ->update(['file_path' => $target_dir."/".$imagename]);

            return redirect('admin/advertise')->with('message', 'Success: Advertise was successfully added.');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertise $adt,$adID)
    {
        //Destroy product
        Advertise::destroyRecord($adID);

        return 'success';
    }

    public function advertise_delimage(Request $request)
    {
        $file = $request->input('file');
        $id = $request->input('id');

        DB::table('advertise')->where('id', $id)->update(['file_name' => NULL ]);

        return response()->JSON($file);

    }

    public function update(Request $request, Advertise $advertise,$id)
    {
        //Update product information
        //$product->updateProduct();

        $image = request()->file('image');
        if($image) {

            $target_dir = "public/images/advertise/".$id;

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $photo = $request->file('image');
            $imagename = $photo->getClientOriginalName();  
            $destinationPath = public_path().'/images/advertise/'.$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

            $filename = $_FILES['image']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            $file_type = 'video';
            if($ext=='jpg' || $ext=='JPG' || $ext=='PNG' || $ext=='png' || $ext=='jpeg' || $ext=='JPEG' || $ext=='gif' || $ext=='GIF'){
                $file_type = 'image';
            }

            $target_dir = "public/images/advertise/".$id; 

            $advt_id = DB::table('advertise')->where('id', $id)->update([
                'vendor_id' => $_POST['vendor_id'], 
                'title' => $_POST['title'], 
                'file_name' => $imagename, 
                'file_path' => $target_dir."/".$imagename, 
                'file_type' => $file_type, 
                'updated_at' => date('Y-m-d h:i:s') ]
            );  
        }else{

           $advt_id = DB::table('advertise')->where('id', $id)->update([
                'vendor_id' => $_POST['vendor_id'], 
                'title' => $_POST['title'], 
                'updated_at' => date('Y-m-d h:i:s') ]
            );
        }
        return redirect('admin/advertise')->with('message', 'Success: Advertisement was successfully updated.');
    }

}