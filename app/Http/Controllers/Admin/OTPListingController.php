<?php

namespace App\Http\Controllers\Admin;

use App\OTPListing;
use App\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Textlocal;
use Sentinel;
use DB;
use App\Exports\otpExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Audio_files;
use Illuminate\Support\Facades\Redirect;

class OTPListingController extends Controller
{
    public function index(Request $request)
    {   

        $cate = ($request->query('category')) ? $request->query('category') : '';
        $subCate = ($request->query('sub_cat')) ? $request->query('sub_cat') : '';
        $vendor = ($request->query('vendor')) ? $request->query('vendor') : '';
        $listing = ($request->query('listing')) ? $request->query('listing') : '';
        $daterange = ($request->query('from')) ? $request->query('from') : date('m/d/Y').'-'.date('m/d/Y');
        $otpstatus = ($request->query('otpstatus')) ? $request->query('otpstatus') : '';


        if (Sentinel::inRole('vendor')) {
            $vendor = Sentinel::getUser()->id;
        }

        $start_date = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
        $end_date = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');

        if($start_date && $end_date){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
        } 


        // $otp_info = DB::table('front_view_listing')
        //     ->select(DB::raw('front_view_listing.created_at as otp_date,audio_files.audio_id,audio_files.audio_description ,vendor_listing.*,front_view_listing.*'))
        //     ->join('vendor_listing','front_view_listing.l_id', '=', 'vendor_listing.vl_id')
        //     ->leftjoin('audio_files','audio_files.audio_id','front_view_listing.id')
        //      ->distinct();

        $otp_info = DB::table('front_view_listing')
        ->select(DB::raw('front_view_listing.created_at as otp_date,audio_files.audio_id,audio_files.audio_description ,vendor_listing.*,users.*,front_view_listing.*'))
        ->leftjoin('vendor_listing','front_view_listing.l_id', '=', 'vendor_listing.vl_id')
        ->leftjoin('audio_files','audio_files.audio_id','front_view_listing.id')
        ->leftjoin('users','vendor_listing.u_id', '=', 'users.id')->distinct();


        if ($cate != '' && $cate != 'null') {
            $otp_info->where("vendor_listing.l_category",$cate);
        }
        if ($subCate != 'null' && $subCate != '') {
            $otp_info->where("vendor_listing.l_sub_category",$subCate);
        }    
        if ($vendor != 'null' && $vendor != '') {
            $otp_info->where("vendor_listing.u_id",$vendor);
        }
        if ($listing != 'null' && $listing != '') {
            $otp_info->where("front_view_listing.l_id",$listing);
        }
        if ($start_date != 'null' && $start_date != '') {
            $otp_info->whereBetween("front_view_listing.created_at",[$start_date, $end_date]);
        }
        if ($otpstatus != 'null' && $otpstatus != '') {
            $ot = ($otpstatus == '3') ? '0' : $otpstatus;
            $otp_info->where("front_view_listing.admin_status",$ot);
        } 
        $type = '';
        if ($cate != '') {
            $type = Inquiry::getType($cate);
        }      
        $category = Inquiry::getCategorys();
        $otpListing = $otp_info->orderBy('front_view_listing.id','DESC')->paginate(10);
        $ven = Inquiry::getVendorInquires($cate,$subCate,$vendor,$listing);
        $venListing = Inquiry::getVendorListing($cate,$subCate,$vendor);
        $total_otp_listing = DB::table('front_view_listing')->get()->count();

        return view('admin.otplisting')->with('otpListing',$otpListing)->with('category',$category)->with('type',$type)->with('otpstatus',$otpstatus)->with('subCate',$subCate)->with('listing',$listing)->with('cate',$cate)->with('ven',$ven)->with('vendor',$vendor)->with('venListing',$venListing)->with('total_otp_listing',$total_otp_listing);
    }

    

    public function upload_audio()
    {   
        return view('admin.otplisting_audio');

    }
    public function add_audio(Request $request,$id)
    {

        if($photos = $request->file('audio')) {   
                
            $imagename = time() .'-'.$photos->getClientOriginalName();
            $destinationPath = public_path().'/uploads/audio/'.$id;
            $photos->move($destinationPath,$imagename); 
         
            $data = new Audio_files;
            $data->audio_id = $id;
            $data->audio_name = $imagename;
            $data->audio_description = $request->input('description');
            $data->save();
        }
        else
        {
            $data = new Audio_files;
            $data->audio_id = $id;
            $data->audio_description = $request->input('description');
            $data->save();

        }
        return redirect('admin/otplisting');
    }    



    public function edit_audio(Request $request,$id,$ids){
       
        $audio_info =   DB::table('audio_files')
                ->where('audio_name',$ids)->get();

            return view('admin.edit_audio_file')->with('audio_info',$audio_info);
    }


    public function edit_audios(Request $request,$id){
       
        $audio_info =   DB::table('audio_files')
                ->where('audio_id',$id)->get();

            return view('admin.edit_audio_file')->with('audio_info',$audio_info);
    }


    public function update_audio(Request $request,$id,$ids){

    $image_file = request()->file('audio_name'); 
    if($image_file){

        $photos = $request->file('audio_name');
        $imagename = time() .'-'.$photos->getClientOriginalName();
        $destinationPath = public_path().'/uploads/audio/'.$id;
        $photos->move($destinationPath,$imagename); 


        $update_data = [

            'audio_description' => $request->audio_description,
            'audio_name' => $imagename
        ];
    }
    else{


        $update_data = [

            'audio_description' => $request->audio_description
        ];

    }    
       

        DB::table('audio_files')->where('audio_name',$ids)->update($update_data);

       
     

              return redirect('admin/otplisting');
    }

    public function update_audios(Request $request,$id){

    $image_file = request()->file('audio_name'); 
    if($image_file){

        $photos = $request->file('audio_name');
        $imagename = time() .'-'.$photos->getClientOriginalName();
        $destinationPath = public_path().'/uploads/audio/'.$id;
        $photos->move($destinationPath,$imagename); 


        $update_data = [

            'audio_description' => $request->audio_description,
            'audio_name' => $imagename
        ];
    }
    else{


        $update_data = [

            'audio_description' => $request->audio_description
        ];

    }    
       

        DB::table('audio_files')->where('audio_id',$id)->update($update_data);

       
     

              return redirect('admin/otplisting');
    }



    
    public function store(Request $request)
    {
        //Filter post method call index function
        return $this->index($request);
    }

    public function show(OTPListing $oTPListing)
    {
        //
    }

    public function edit(OTPListing $oTPListing)
    {
        //
    }

    public function update(Request $request, OTPListing $oTPListing)
    {
        //Update the status
        $status = OTPListing::updateFlag($request->status);

        //Get the vendor information based on the otp id
        $info = OTPListing::getInfo($request->status);

      
            $message = '';
            if ($status == '1') {
                $message = 'We have verified the lead, Name:'.$info[0]->u_name.' & Number:'.$info[0]->u_phone. ' is VALID.';

            $otpmessage = urlencode($message);
            $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,'http://sms.incisivewebsolution.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=667810964beb48fcf4f157b070dd89fa&message='.$otpmessage.'&senderId=YASSIR&routeId=1&mobileNos='.$info[0]->Phone.'&smsContentType=english');
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
            $query = curl_exec($curl_handle);
            curl_close($curl_handle);
            DB::table('front_view_listing')
                ->where('id', $info[0]->id)
                ->update(['vendor_api_response' => $query]);


            } else if ($status == '0') {
                $message = 'We have verified the lead, Name:'.$info[0]->u_name.' & Number:'.$info[0]->u_phone. ' is INVALID.';
            }

            
        

        return $status;
    }

    
    public function destroy(Request $request,$id)
    { 
           
        $directory = "public/uploads/audio/".$id;
       
          if (is_dir($directory)) {
          $files = array_values(array_diff(scandir($directory), array('..', '.')));
          $img = '';

           foreach ($files as $value){
                  
                   unlink(public_path() .  '/public/uploads/audio'.$value );
            }
            
         }  
        return view('admin.otplisting');
    }

    public function audio($id)
    {
        $directory = "public/uploads/audio/".$id;
          $audio_info =   DB::table('audio_files')
                ->where('audio_id',$id)->get();


       
          if (is_dir($directory)) {
          $files = array_values(array_diff(scandir($directory), array('..', '.')));
          $img = '';
            
         }  
        return view('admin.audio')->with('files',$files)->with('id',$id)->with('audio_info',$audio_info);
    }

    public function del_audio(Request $r,$id,$ids)
    {   
        
        $directory = "public/uploads/audio/".$id;

        $files = array_values(array_diff(scandir($directory), array('..', '.')));
       
        $path = "public/uploads/audio/".$id."/".$ids;
        unlink($path);


        DB::table('audio_files')->where('audio_name',$ids)->delete();

        return redirect('admin/otplisting');
    }

    public function del_audios(Request $r,$id)
    {   
        
       


        DB::table('audio_files')->where('audio_id',$id)->delete();

        return redirect('admin/otplisting');
    }

    public function export(Request $r)
    {
       return Excel::download(new otpExport, 'OTPListing.xlsx');
    }


    public function mdelete(Request $request)
    {

        $all_data = $request->input('all_data');
         DB::table('front_view_listing')->whereIn('id',$all_data)->delete();
          $total_otp_listing = DB::table('front_view_listing')->get()->count();
           $listing = ($request->query('listing')) ? $request->query('listing') : '';
           $category = Inquiry::getCategorys();
           $otpstatus = ($request->query('otpstatus')) ? $request->query('otpstatus') : '';
           $cate = ($request->query('category')) ? $request->query('category') : '';
           $type = Inquiry::getType($cate);
           $otp_info = DB::table('front_view_listing')
            ->select(DB::raw('front_view_listing.created_at as otp_date,audio_files.audio_id,vendor_listing.*,users.*,front_view_listing.*'))
            ->leftjoin('vendor_listing','front_view_listing.l_id', '=', 'vendor_listing.vl_id')
            ->leftjoin('audio_files','audio_files.audio_id','front_view_listing.id')
            ->leftjoin('users','vendor_listing.u_id', '=', 'users.id')->distinct();
           $otpListing = $otp_info->orderBy('front_view_listing.id','DESC')->paginate(10);

           $vendor = ($request->query('vendor')) ? $request->query('vendor') : '';
           $subCate = ($request->query('sub_cat')) ? $request->query('sub_cat') : '';
           $ven = Inquiry::getVendorInquires($cate,$subCate,$vendor,$listing);
           $venListing = Inquiry::getVendorListing($cate,$subCate,$vendor);

           return redirect('admin/otplisting')->with('otpListing',$otpListing)->with('category',$category)->with('type',$type)->with('otpstatus',$otpstatus)->with('subCate',$subCate)->with('listing',$listing)->with('cate',$cate)->with('ven',$ven)->with('vendor',$vendor)->with('venListing',$venListing);
       }
}
