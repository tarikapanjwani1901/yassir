<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

use DB;
use paginate;

use Illuminate\Http\Request;

Class UserController extends Controller
{
    public function view() {

        //Get Campaign Type
        $users = DB::table('users')->where('u_delete', '!=', 1)->paginate(2);

    	return view('backend/allusers')->with('allUsers',$users);
    }

    public function add() {
    	return view('backend/adduser');
    }

    public function bio($userid='') {
    	return view('backend/userbio');
    }

    public function delete($userid) {
        DB::table('users')
            ->where('id', $userid)
            ->update(['u_delete' => 1]);

        return redirect()->route('users');
    }

    public function deleted() {
    	return view('backend/alldeleted');
    }
}
