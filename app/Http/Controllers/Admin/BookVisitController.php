<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\Models\Advertise;
use App\Inquiry;
use App\Models\PropertyBookVisit;
use Sentinel;

class BookVisitController extends JoshController
{

    public function index(Request $request)
    {
        
        if(Sentinel::inRole('admin')){
            $bookvisit_response = PropertyBookVisit::getPropertyBooking();
        }
        else{
            $user_id = Sentinel::getUser()->id;
            $bookvisit_response = PropertyBookVisit::getPropertyBookingByUserId($user_id);
        }

        return view('admin.bookvisit.index')->with('bookvisit',$bookvisit_response);
    }

    public function destroy(PropertyBookVisit $bv,$bvID)
    {
        //Destroy product
        PropertyBookVisit::destroyRecord($bvID);

        return 'success';
    }
}