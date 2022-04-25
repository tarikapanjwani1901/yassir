<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

Class HomePageController extends Controller
{
    public function view() {
    	return view('welcome');
    }
}
