<?php

namespace App\Http\Controllers\Admin;

use App\VendorListing;
use App\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Product;
use DB;
use Sentinel;

class VendorListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Set the default variable
        $cate = '';
        $subCate = '';
        $vendor = '';
        $listing = '';
        $type = '';
        $ven = '';
        $venListing = '';
        $vendorList = '';
        $viewFile = 'admin.vendorlisting';
        $typeProcess = array();

        if ($request->query('category')) {

            $cate = $request->input('category');
            $subCate = $request->input('sub_cat');
            $vendor = $request->input('vendor');
            $listing = $request->input('listing');

            //Get the vendors based on the filters
            $ven = Inquiry::getVendorInquires($cate,$subCate,$vendor,$listing);

            //Get the vendor listing based on the filters
            $venListing = Inquiry::getVendorListing($cate,$subCate,$vendor);

            //Grab all the inquires
            $vendorList = VendorListing::getAllListing($cate,$subCate,$vendor,$listing);

        }

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        //Grab system category
        $category = Inquiry::getCategorys();

        //Get the Type if category is set
        if ($cate != '') {
            $type = Inquiry::getType($cate);

            //Decide the view file name
            $viewFile = VendorListing::viewFile($cate);

            //Process the type
            foreach ($type as $key => $value) {
                $typeProcess[$value->id] = $value->name;
            }
        }

        if (Sentinel::inRole('vendor')) {
            $vendorList = VendorListing::getAllListing($cate,$subCate,Sentinel::getUser()->id,$listing);

            $type = Inquiry::getType(Sentinel::getUser()->user_category);

            foreach ($type as $key => $value) {
                $typeProcess[$value->id] = $value->name;
            }
        }

        return view('admin.vendorlisting')->with('vendors',$vendors)->with('category',$category)->with('vendorList',$vendorList)->with('cate',$cate)->with('subCate',$subCate)->with('vendor',$vendor)->with('listing',$listing)->with('type',$type)->with('ven',$ven)->with('venListing',$venListing)->with('typeProcess',$typeProcess);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Store new listing
        VendorListing::storeListing();

        return redirect('admin/vendorlisting');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Filter post method call index function
        return $this->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function show(VendorListing $vendorListing)
    {
        //Grab system category
        $category = Inquiry::getCategorys();

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        if (Sentinel::inRole('vendor')) {
            $type = Inquiry::getType(Sentinel::getUser()->user_category);
        }

        return view('admin.vendorlisting_add',compact('category','vendors','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function edit($id,VendorListing $vendorListing)
    {
        //Grab the all the information from the table
        $lisitng = VendorListing::getVendorListing($id);

        //Grab system category
        $category = Inquiry::getCategorys();

        //Grab all vendors
        $vendors = Inquiry::getVendor();

        //Get the Type if category is set
        $type = Inquiry::getType($lisitng->l_category);

        //Get the product category
        $proCate =  VendorListing::getVendorProductCategory($lisitng->l_category,$lisitng->u_id);

        return view('admin.vendorlisting_edit',compact('category','lisitng','vendors','type','proCate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorListing $vendorListing)
    {
        //
        $vendorListing->updateListing();

        return redirect('admin/vendorlisting')->with('message', 'Success: Product was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,VendorListing $vendorListing)
    {
        DB::table('vendor_listing')->where('vl_id', '=', $id)->delete();
        return 'success';
    }

    /**
     * Get the product category based on the values.
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function getProductCategory(Request $request,VendorListing $vendorListing)
    {
        $vendor = $request->input('vendor');
        $category = $request->input('category');
        $sub_category = $request->input('sub_category');

        return $vendorListing->getProductCategory($vendor,$category,$sub_category);
    }

    /**
     * Delete image
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function del_image(Request $r)
    {
        $img =$r->file;
        $name = str_replace('/public','',$img);

        unlink(public_path().'/'.$name);
        return response()->JSON($img);
    }

    /**
     * Check URL tag is exist or not
     *
     * @param  \App\VendorListing  $vendorListing
     * @return \Illuminate\Http\Response
     */
    public function check_url(Request $r)
    {
        $url=DB::table('vendor_listing')->select('url_name','vl_id')->get()->toArray();
        $post_url=$_POST['url_name'];

        if(isset($_POST['vl_id'])){
            $vl_id=$_POST['vl_id'];
        }

        $msg = "";
        foreach ($url as $key => $value) {

            if(isset($_POST['vl_id']) && $value->url_name == $post_url && $value->vl_id != $vl_id && $post_url != "") {
                $msg = "URL Is Already Exists";
                break;

            } elseif(!isset($_POST['vl_id']) && $value->url_name == $post_url && $post_url != "") {
                $msg = "URL Is Already Exists";
                break;
            }
        }

        return $msg;
    }
}
