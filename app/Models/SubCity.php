<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCity extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes;

    protected $table = "sub_cities";

    public static function getSubCitiesByCityId($city_id){

        $query = SubCity::query();
        $query = $query->select('*');
        $query = $query->where('status','=','active');
        $query = $query->where('city_id','=',$city_id);
        $response = $query->get();

        return $response;
    }   

}