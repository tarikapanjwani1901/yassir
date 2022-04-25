<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

Class HomePageController extends Controller
{
    public function view() {
    	return view('frontend/home');
    }
}
