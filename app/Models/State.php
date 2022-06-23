<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable;

    //use SoftDeletes;

    protected $table = "states";

    public static function getStatesByCountryId($country_id){

        $query = State::query();
        $query = $query->select('*');
        $query = $query->where('status','=','active');
        $query = $query->where('country_id','=',$country_id);
        $response = $query->get();

        return $response;
    }   

}