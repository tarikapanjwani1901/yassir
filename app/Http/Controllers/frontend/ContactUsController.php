<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

Class ContactUsController extends Controller
{
    public function view() {
    	return view('frontend/contactus');
    }
}
