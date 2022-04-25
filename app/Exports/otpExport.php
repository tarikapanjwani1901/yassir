<?php

namespace App\Exports;

use App\User;
use App\vendor_listing;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class otpExport implements FromCollection
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
    	if(isset($_POST['otpstatus'])){
    		$otpstatus=$_POST['otpstatus'];
    	}
    	if(isset($_POST['listing'])){
    		$listing=$_POST['listing'];
    	}

        $otp = DB::table('front_view_listing')
            ->select(DB::raw('front_view_listing.created_at as otp_date,vendor_listing.l_title,users.company_name,front_view_listing.u_name,front_view_listing.u_phone,front_view_listing.admin_status'))
            ->leftjoin('vendor_listing','front_view_listing.l_id', '=', 'vendor_listing.vl_id')
            ->leftjoin('users','vendor_listing.u_id', '=', 'users.id');


        if ($category != '' && $category != 'null') {
            $otp->where("vendor_listing.l_category",$category);
        }

        if ($sub_cat != 'null' && $sub_cat != '') {
            $otp->where("vendor_listing.l_sub_category",$sub_cat);
        }

        if ($vendor != 'null' && $vendor != '') {
            $otp->where("vendor_listing.u_id",$vendor);
        }

        if ($listing != 'null' && $listing != '') {
            $otp->where("front_view_listing.l_id",$listing);
        }

        if (!isset($_POST['is_admin']) && isset($_POST['user_id']) != '') {
            $otp->where("vendor_listing.u_id",$_POST['user_id']);
        }

        if ($otpstatus != 'null' && $otpstatus != '') {
            $ot = ($otpstatus == '3') ? '0' : $otpstatus;
            $otp->where("front_view_listing.admin_status",$ot);
        }

        if ($daterange != 'null' && $daterange != '') {
            $dates = explode('-', $daterange);
            $otp->whereBetween('front_view_listing.created_at', [date('Y-m-d', strtotime($dates[0])), date('Y-m-d', strtotime($dates[1]))]);
        }
        $result[0] =  array('date' => 'Date','listing_name' => 'Listing Name','vendor' => 'Vendor','user' => 'User','user_phone' => 'User Phone','status' => 'Status');
        $result1 = $otp->orderBy('front_view_listing.id','DESC')->get()->toArray();

        foreach ($result1 as $key => $value) {
        	if($value->admin_status == 0 && $value->admin_status != "")
        	{
        		$r="Inactive";
        		$value->admin_status = $r;
        	}
        	elseif($value->admin_status == 1 && $value->admin_status != "")
        	{
        		$r="Active";
        		$value->admin_status = $r;
        	}
        	elseif($value->admin_status == 2 || $value->admin_status == "")
        	{
        		$r="Pending";
        		$value->admin_status = $r;
        	}
        }
        $res = array_merge($result, $result1);
        return collect($res);
    }
}
