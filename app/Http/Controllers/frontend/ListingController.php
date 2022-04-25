<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

Class ListingController extends Controller
{
    public function listing() {
    	return view('frontend/listing');
    }

    public function detaillisting() {
    	return view('frontend/detaillisting');
    }
}
