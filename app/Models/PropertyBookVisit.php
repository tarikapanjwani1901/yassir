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

        $response = $query->paginate(20);

        return $response;
    }
    
    public static function getPropertyBookingByUserId($user_id){

        $query = PropertyBookVisit::query();
        $query = $query->join('vendor_listing','vendor_listing.vl_id','=','property_book_visit.listing_id');
        $query = $query->select('property_book_visit.*','vendor_listing.l_title');

        $query = $query->where('vendor_listing.u_id',$user_id);

        $response = $query->paginate(20);

        return $response;
    }

    //Destroy record
    public static function destroyRecord($id)
    {
        DB::table('property_book_visit')->where('id', '=', $id)->delete();

        return true;
    }
}