<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;



class Test extends Model
{

    public $table = 'tests';
    


    public $fillable = [
        'undefined',
        'test'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'test' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
