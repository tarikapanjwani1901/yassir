<?php

namespace App\Http\Controllers\Admin;

use App\Inquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use DB;
use App\Exports\InquiryExpoet;
use App\Models\PropertyBookVisit;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class InquiryController extends Controller
{
   
    public function index(Request $request)
    {
        // Search Values
        $vendors = $request->get('vendors');
        $inquiry_name = $request->get('inquiry_name');

        $start_date = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
        $end_date = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');

        if($start_date && $end_date){
            $start_date = date('Y-m-d 00:00:00', strtotime($start_date));
            $end_date = date('Y-m-d 23:59:59', strtotime($end_date));
        }

        if(Sentinel::inRole('vendor')){    
            $id = Sentinel::getUser()->id; 

            $inquires = PropertyBookVisit::getAllVendorInquiries($id,$inquiry_name,$start_date,$end_date);
            $inquiresCount = PropertyBookVisit::getAllVendorInquiriesCount($id);

        }
        else{
            $inquires = PropertyBookVisit::getAllInquiries($inquiry_name,$vendors,$start_date,$end_date);
            $inquiresCount = PropertyBookVisit::getAllInquiriesCount('');
        }
        
        $vendors_info = DB::table('vendor_listing')->select('vl_id','l_title')->whereNotNull('l_title')->orderBy('l_title','asc')->get();      

        return view('admin.inquiry.index')->with('inquires',$inquires)->with("vendors_info",$vendors_info)->with('vendors',$vendors)->with('inquiry_name',$inquiry_name)->with('total_inquity',$inquiresCount);
        
        
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

   
    public function export(Request $r)
    {
       return Excel::download(new InquiryExpoet, 'Inquiry.xlsx');
    }
}
