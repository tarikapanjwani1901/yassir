<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class skill_memeber extends Model
{
     use SoftDeletes;

     protected $dates = ['deleted_at'];

     protected $table = 'vendor_listing';
}
