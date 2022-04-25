<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

Class DashBoardController extends Controller
{
    public function view() {
    	return view('backend/dashboard');
    }
}
