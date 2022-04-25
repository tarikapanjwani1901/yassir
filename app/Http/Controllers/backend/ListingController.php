<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

Class ListingController extends Controller
{
    public function alllist() {
    	return view('backend/alllisting');
    }

    public function add() {
    	return view('backend/addeditlist');
    }

    public function edit() {
    	return view('backend/addeditlist');
    }

    public function delete() {
    	return view('backend/alllisting');
    }
}
