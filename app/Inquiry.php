<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Inquiry extends Model
{
    //Get all vendors
    public static function getVendor()
    {
        $allvendors = DB::table('users')
            ->where("user_role","3")
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        return $allvendors;
    }

    //Get all vendors material
    public static function getVendorMaterial()

    
    {
        $allvendors = DB::table('users')
            ->where("user_role","3")
            ->where("user_category","4")
            ->whereNull('deleted_at')
            ->orderBy('users.company_name','asc')
            ->get()
            ->toArray();

        return $allvendors;
    }


    //Get system default category
    public static function getCategorys()
    {
        $cate = DB::table('category')->select('*')->where('id', '!=', [5])->get();

        return $cate;
    }

    //Get last 10 inquires
    public static function getInquires($cate='',$subCate='',$vendor='',$listing='',$daterange='')
    {
        $inquires = DB::table('vendor_inquiry')
            ->select('vendor_inquiry.created_at as datetime','vendor_inquiry.iname','vendor_inquiry.iemail','vendor_inquiry.iphone','users.company_name','vendor_listing.l_title','vendor_inquiry.id','vendor_inquiry.imessage','vendor_inquiry.idate','vendor_inquiry.itime')
            ->join('users','vendor_inquiry.u_id', '=', 'users.id')
            ->join('vendor_listing','vendor_listing.u_id', '=', 'users.id');

        if ($cate != '' && $cate != 'null') {
            $inquires->where("vendor_listing.l_category",$cate);
        }

        if ($subCate != 'null' && $subCate != '') {
            $inquires->where("vendor_listing.l_sub_category",$subCate);
        }

        if ($vendor != 'null' && $vendor != '') {
            $inquires->where("vendor_inquiry.u_id",$vendor);
        }

        if ($listing != 'null' && $listing != '') {
            $inquires->where("vendor_inquiry.l_id",$listing);
        }

        if ($daterange != 'null' && $daterange != '') {
            $dates = explode('-', $daterange);
            $inquires->whereBetween('vendor_inquiry.created_at', [date('Y-m-d 00:00:00', strtotime($dates[0])), date('Y-m-d 23:59:59', strtotime($dates[1]))]);
        }

        $result = $inquires->orderBy('vendor_inquiry.created_at','DESC')->paginate(10);

        return $result;
    }

    //Get Type
    public static function getType($cate)
    {
        $type = '';

        switch ($cate) {
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

    //Get last vendors based on the filter
    public static function getVendorInquires($cate='',$subCate='',$vendor='',$listing='')
    {

        $inquires = DB::table('vendor_listing')
            ->join('users', 'users.id', '=', 'vendor_listing.u_id')
            ->whereNull('vendor_listing.deleted_at');

        if ($cate != '' && $cate != 'null') {
            $inquires->where("vendor_listing.l_category",$cate);
        }

        if ($subCate != 'null' && $subCate != '') {
            $inquires->where("vendor_listing.l_sub_category",$subCate);
        }

        $result = $inquires->groupBy('vendor_listing.u_id')->get()->toArray();
/*
        $inquires = DB::table('vendor_inquiry')
            ->join('users', 'users.id', '=', 'vendor_inquiry.u_id')
            ->join('vendor_listing','vendor_listing.u_id', '=', 'users.id')
            ->whereNull('deleted_at');

        if ($cate != '' && $cate != 'null') {
            $inquires->where("vendor_listing.l_category",$cate);
        }

        if ($subCate != 'null' && $subCate != '') {
            $inquires->where("vendor_listing.l_sub_category",$subCate);
        }

        if ($vendor != 'null' && $vendor != '') {
            $inquires->where("vendor_listing.u_id",$vendor);
        }

        if ($listing != 'null' && $listing != '') {
            $inquires->where("vendor_listing.vl_id",$listing);
        }

        $result = $inquires->groupBy('users.company_name')->get()->toArray();*/

        return $result;
    }

    //Get the vendor listing based on the filters
    public static function getVendorListing($cate='',$subCate='',$vendor='')
    {
        $listing = DB::table('vendor_listing');

        if ($cate != '' && $cate != 'null') {
            $listing->where("vendor_listing.l_category",$cate);
        }

        if ($subCate != 'null' && $subCate != '') {
            $listing->where("vendor_listing.l_sub_category",$subCate);
        }

        if ($vendor != 'null' && $vendor != '') {
            $listing->where("vendor_listing.u_id",$vendor);
        }

        $result = $listing->get()->toArray();

        return $result;
    }


}
