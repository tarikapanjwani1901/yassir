<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PropertyBookVisit extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes;

    protected $table = "property_book_visit";
      
    public static function getPropertyBooking(){

        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.*','vendor_listing.l_title');
        $query = $query->where('property_book_visit.type','like','bookvisit');
        $response = $query->paginate(20);

        return $response;
    }
    
    public static function getPropertyBookingByUserId($user_id){

        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.*','vendor_listing.l_title');

        $query = $query->where('vendor_listing.u_id',$user_id);
        $query = $query->where('property_book_visit.type','like','bookvisit');

        $response = $query->paginate(20);

        return $response;
    }

    //Destroy record
    public static function destroyRecord($id)
    {
        DB::table('property_book_visit')->where('id', '=', $id)->delete();
        return true;
    }

    public static function getAllInquiriesCount()
    {
        $query = PropertyBookVisit::query();
        $query = $query->select('property_book_visit.*');
        $query = $query->where('property_book_visit.type','like','inquiry');

        $response = $query->count();

        return $response;
    }

    public static function getAllInquiries($search,$vendor_id,$start_date,$end_date)
    {
        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.*','vendor_listing.l_title');
        $query = $query->where('property_book_visit.type','like','inquiry');

        if(isset($search) && $search!=''){
            $query = $query->where(function($query) use ($search) {
                $query = $query->where('property_book_visit.name','like','%'.$search.'%');
                $query = $query->orWhere('property_book_visit.email','like','%'.$search.'%');
                $query = $query->orWhere('property_book_visit.contact','like','%'.$search.'%');
                $query = $query->orWhere('property_book_visit.message','like','%'.$search.'%');
            });
        }

        if(isset($vendor_id) && $vendor_id!=''){
            $query = $query->where('property_book_visit.listing_id','=',$vendor_id);
        }

        if ($start_date != 'null' && $start_date != '' && $end_date != 'null' && $end_date != '') {
            $query->where("property_book_visit.created_at",'>=',$start_date);
            $query->where("property_book_visit.created_at",'<=',$end_date);
        }

        $response = $query->paginate(20);
       
        return $response;
    }

    public static function getAllVendorInquiriesCount($user_id)
    {
        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.*');
        $query = $query->where('property_book_visit.type','like','inquiry');
        $query = $query->where('vendor_listing.u_id','=',$user_id);

        $response = $query->count();

        return $response;
    }

    public static function getAllVendorInquiries($user_id,$search,$start_date,$end_date){


        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.*','vendor_listing.l_title');
        $query = $query->where('property_book_visit.type','like','inquiry');
        $query = $query->where('vendor_listing.u_id','=',$user_id);

        if(isset($search) && $search!=''){
            $query = $query->where(function($query) use ($search) {
                $query = $query->where('property_book_visit.name','like','%'.$search.'%');
                $query = $query->orWhere('property_book_visit.email','like','%'.$search.'%');
                $query = $query->orWhere('property_book_visit.contact','like','%'.$search.'%');
                $query = $query->orWhere('property_book_visit.message','like','%'.$search.'%');
            });
        }

        if ($start_date != 'null' && $start_date != '' && $end_date != 'null' && $end_date != '') {
            $query->where("property_book_visit.created_at",'>=',$start_date);
            $query->where("property_book_visit.created_at",'<=',$end_date);
        }
        
        $response = $query->paginate(20);
        
        return $response;

    }

    public static function getAllUserInquiries($user_id)
    {
        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.created_at','vendor_listing.l_title','vendor_listing.vl_id','vendor_listing.l_location',
        'vendor_listing.status','vendor_listing.vl_id');
        $query = $query->where('property_book_visit.type','like','inquiry');
        $query = $query->where('property_book_visit.user_id','=',$user_id);
        
        $response = $query->get();
        
        return $response;

    }

    public static function getAllVendorInquiriesList($vendor_id)
    {
        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.created_at','vendor_listing.l_title','vendor_listing.vl_id','vendor_listing.l_location',
        'vendor_listing.status','vendor_listing.vl_id');
        $query = $query->where('property_book_visit.type','like','inquiry');
        $query = $query->where('vendor_listing.u_id','=',$vendor_id);
        
        $response = $query->get();
        
        return $response;

    }

}