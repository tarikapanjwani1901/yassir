<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes;

    protected $table = "cities";

    public static function getCitiesByStateId($state_id){

        $query = City::query();
        $query = $query->select('*');
        $query = $query->where('status','=','active');
        $query = $query->where('state_id','=',$state_id);
        $response = $query->get();

        return $response;
    }   

}