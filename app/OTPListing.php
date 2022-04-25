<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OTPListing extends Model
{
    //Get all the OTP result
    public static function getOTPListing($cate='',$subCate='',$vendor='',$listing='',$daterange='',$otpstatus='')
    {
        $otp = DB::table('front_view_listing')
            ->select(DB::raw('front_view_listing.created_at as otp_date,audio_files.audio_id,vendor_listing.*,users.*,front_view_listing.*'))
            ->leftjoin('vendor_listing','front_view_listing.l_id', '=', 'vendor_listing.vl_id')
            ->leftjoin('audio_files','audio_files.audio_id','front_view_listing.id')
            ->leftjoin('users','vendor_listing.u_id', '=', 'users.id')->distinct();


        if ($cate != '' && $cate != 'null') {
            $otp->where("vendor_listing.l_category",$cate);
        }

        if ($subCate != 'null' && $subCate != '') {
            $otp->where("vendor_listing.l_sub_category",$subCate);
        }

        if ($vendor != 'null' && $vendor != '') {
            $otp->where("vendor_listing.u_id",$vendor);
        }

        if ($listing != 'null' && $listing != '') {
            $otp->where("front_view_listing.l_id",$listing);
        }

        if ($otpstatus != 'null' && $otpstatus != '') {
            $ot = ($otpstatus == '3') ? '0' : $otpstatus;
            $otp->where("front_view_listing.admin_status",$ot);
        }

        if ($daterange != 'null' && $daterange != '') {
            $dates = explode('-', $daterange);
            $start = date('Y-m-d', strtotime($dates[0]));
            $end = date('Y-m-d', strtotime($dates[1]));
            $otp->whereBetween('front_view_listing.created_at', [$start.' 00:00:00', $end.' 23:59:59']);
        }

        $result = $otp->orderBy('front_view_listing.id','DESC')->paginate(10);

        return $result;
    }

    //Update the flag
    public static function updateFlag($status='')
    {
        //Explode the value
        $status = explode('_', $status);

        $state = '';

        if ($status[0] == 'valid') {
            $state = '1';
        } else if ($status[0] == 'reset') {
            $state = '2';
        } else {
            $state = '0';
        }

        DB::table('front_view_listing')
            ->where('id', $status['1'])
            ->update(['admin_status' => $state]);

        return $state ;
    }

    //Get all the info
    public static function getInfo($status='')
    {
        $status = explode('_', $status);

        $otp = DB::table('front_view_listing')
            ->leftjoin('vendor_listing','front_view_listing.l_id', '=', 'vendor_listing.vl_id')
            ->where('front_view_listing.id', $status['1'])
            ->get()
            ->toArray();

        return $otp;
    }
}
