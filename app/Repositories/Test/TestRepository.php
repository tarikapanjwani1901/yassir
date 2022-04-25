<?php

namespace App\Repositories\Test;

use App\Models\Test\Test;
use InfyOm\Generator\Common\BaseRepository;

class TestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Test::class;
    }
}
