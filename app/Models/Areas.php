<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $table = 'areas';

    public static function getAreasBySubCityId($subcity_id){

        $query = Areas::query();
        $query = $query->select('*');
        $query = $query->where('status','=','active');
        $query = $query->where('sub_city_id','=',$subcity_id);
        $response = $query->get();

        return $response;
    } 
}
