<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorListingFavourite extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes;

    protected $table = "vendor_listing_favourite";

    public static function getFavouritePropertyCountById($user_id,$property_id){

        $query = VendorListingFavourite::query();
        $query = $query->where('u_id','=',$user_id);
        $query = $query->where('vl_id','=',$property_id);
        $count = $query->count();

        return $count;
    }

    public static function getFavouritePropertyById($user_id,$property_id){

        $query = VendorListingFavourite::query();
        $query = $query->where('u_id','=',$user_id);
        $query = $query->where('vl_id','=',$property_id);
        $query = $query->select('vendor_listing_favourite.id');
        $count = $query->first();

        return $count;
    }

}