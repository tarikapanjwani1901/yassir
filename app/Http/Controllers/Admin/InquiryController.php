<?php

namespace App\Http\Controllers\Admin;

use App\Inquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use DB;
use App\Exports\InquiryExpoet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class InquiryController extends Controller
{
   
    public function index(Request $request)
    {

        $vendors = $request->get('vendors');
        $inquiry_name = $request->get('inquiry_name');

        $vendors_info = DB::table('vendor_listing')->select('vl_id','l_title')->whereNotNull('l_title')->orderBy('l_title','asc')->get();
        $total_inquity = DB::table('vendor_inquiry')->get()->count();
        
        $start_date = (!empty($_GET["from"])) ? ($_GET["from"]) : ('');
        $end_date = (!empty($_GET["to"])) ? ($_GET["to"]) : ('');

        if($start_date && $end_date){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
        } 


    if(Sentinel::inRole('vendor')){    
        $id = Sentinel::getUser()->id; 
         
        //Grab all the inquires
        $inquires_info = DB::table('vendor_inquiry')
            ->select('vendor_inquiry.*','vendor_listing.l_title','users.company_name')
            ->join('users','vendor_inquiry.u_id', '=', 'users.id')
            ->join('vendor_listing','vendor_listing.vl_id', '=', 'vendor_inquiry.l_id')->orderBy('vendor_inquiry.created_at','DESC')->where('users.id',$id);
    }else{
        $inquires_info = DB::table('vendor_inquiry')
            ->select('vendor_inquiry.*','vendor_listing.l_title','users.company_name')
            ->join('users','vendor_inquiry.u_id', '=', 'users.id')
            ->join('vendor_listing','vendor_listing.vl_id', '=', 'vendor_inquiry.l_id')->orderBy('vendor_inquiry.created_at','DESC');
    }       


     if ($vendors != 'null' && $vendors != '') {
            $inquires_info->where("vendor_inquiry.l_id",$vendors);
        }

      if ($inquiry_name != 'null' && $inquiry_name != '') {
            $inquires_info->where("vendor_inquiry.iname",$inquiry_name);
            $inquires_info->orwhere("vendor_inquiry.iemail",$inquiry_name);
        }
        if ($start_date != 'null' && $start_date != '') {
            $inquires_info->whereBetween("vendor_inquiry.created_at",[$start_date, $end_date]);
        }   

       $inquires = $inquires_info->paginate('10');   
           
        return view('admin.inquiry')->with('inquires',$inquires)->with("vendors_info",$vendors_info)->with('vendors',$vendors)->with('inquiry_name',$inquiry_name)->with('total_inquity',$total_inquity);
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
