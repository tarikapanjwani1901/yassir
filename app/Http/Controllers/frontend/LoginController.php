<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

Class LoginController extends Controller
{
    public function view() {
    	return view('frontend/login');
    }
}
