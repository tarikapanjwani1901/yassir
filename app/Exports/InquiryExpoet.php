<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class InquiryExpoet implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$category = "";
    	$sub_cat = "";
    	$vendor = "";
    	$daterange = "";
    	$otpstatus = "";
    	$listing = "";
    	if(isset($_POST['category'])){
    		$category=$_POST['category'];
    	}
    	if(isset($_POST['sub_cat'])){
    		$sub_cat=$_POST['sub_cat'];
    	}
    	if(isset($_POST['vendor'])){
    		$vendor=$_POST['vendor'];
    	}
    	if(isset($_POST['daterange'])){
    		$daterange=$_POST['daterange'];
    	}
    	if(isset($_POST['listing'])){
    		$listing=$_POST['listing'];
    	}
    	$inquires = DB::table('vendor_inquiry')
            ->select('vendor_inquiry.created_at as datetime','vendor_inquiry.iname','vendor_inquiry.iemail','vendor_inquiry.iphone','users.company_name','vendor_listing.l_title','vendor_inquiry.imessage','vendor_inquiry.idate','vendor_inquiry.itime')
            ->join('users','vendor_inquiry.u_id', '=', 'users.id')
            ->join('vendor_listing','vendor_listing.u_id', '=', 'users.id');

        if ($category != '' && $category != 'null') {
            $inquires->where("vendor_listing.l_category",$category);
        }

        if ($sub_cat != 'null' && $sub_cat != '') {
            $inquires->where("vendor_listing.l_sub_category",$sub_cat);
        }

        if ($vendor != 'null' && $vendor != '') {
            $inquires->where("vendor_inquiry.u_id",$vendor);
        }

        if ($listing != 'null' && $listing != '') {
            $inquires->where("vendor_inquiry.l_id",$listing);
        }

        if (!isset($_POST['is_admin']) && isset($_POST['user_id']) != '') {
            $inquires->where("vendor_inquiry.u_id",$_POST['user_id']);
        }

        if ($daterange != 'null' && $daterange != '') {
            $dates = explode('-', $daterange);
            $inquires->whereBetween('vendor_inquiry.created_at', [date('Y-m-d 00:00:00', strtotime($dates[0])), date('Y-m-d 23:59:59', strtotime($dates[1]))]);
        }
       /* else{
            $inquires->whereBetween('vendor_inquiry.created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')]);
        }*/
        $result[0] =  array('date&time' => 'Date & Time','name'=>'Name','email'=>'Email','phone' => 'Phone','vendor' => 'Vendor','listing_name' => 'Listing Name','message' => 'Message');
        $result1 = $inquires->orderBy('vendor_inquiry.created_at','DESC')->get()->toArray();

        $res = array_merge($result, $result1);
        return collect($res);
    }

}
