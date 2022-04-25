<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Sentinel;
use App\Inquiry;
use DB;
use Image;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $vendor = '';
        if (Sentinel::inRole('vendor')) {
            $vendor = Sentinel::getUser()->id;
        }

        //Get all the product categories
        $category = Category::getProductCategory($vendor);

        return view('admin.product_category')->with('category',$category);
    }

    public function product_del_image(Request $r)
    { 
        $img =$r->file;
        $name = str_replace('/public','',$img);

        unlink(public_path().'/'.$name);
        return response()->JSON($img);
    }

    public function manage_product_cat(Request $request)
    {

       $search = $request->get('product_searchh');
       $category = DB::table('product_category')
       ->where('cate_name','like','%'.$search.'%')
       ->paginate(10);   
      // echo "<pre>"; print_r($testimonials); exit; 

       return view('admin/product_category')->with('category', $category);
       // return view('admin/testimonial',compact('testimonials',$testimonials));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.product_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id="")
    {
        //Create new category
        //$newCategory = Category::storeNewCategory();

        if($request->hasFile('inputFile')) { 

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName();  
        
            $categoryid = DB::table('product_category')->insertGetId(
            ['cate_name' => str_replace("/"," ",$_POST['name']), 'vendor_id' => $_POST['vendor'], 'cate_slug' => (str_replace(' ', '_', strtolower($_POST['name']))), 'cate_desc' => $_POST['message'], 'cate_image' => $imagename, 'updated_at' => date('Y-m-d h:i:s') ]
            );

            $target_dir = "public/images/product_category/".$categoryid."/".$id;    

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $destinationPath = public_path().'/images/product_category/'. $categoryid."/".$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

        }

        return redirect('admin/product/category')->with('message', 'Success: Category was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //Grab all vendors
       $vendors = Inquiry::getVendorMaterial();

        //$vendors = DB::table('vendor_listing')->join('users','users.id','vendor_listing.u_id')->where('l_category',4)->orderby('users.company_name','asc')->get();

        return view('admin.product_category_add')->with('vendors',$vendors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category,$categoryId)
    {
        //Grab all vendors
        $vendors = Inquiry::getVendorMaterial();
        //$vendors = DB::table('vendor_listing')->join('users','users.id','vendor_listing.u_id')->where('l_category',4)->orderby('users.company_name','asc')->get();

        //Grab the category information
        $cateInfo = $category->getCategoryInfo($categoryId);

         $cateInfos = $category->getCategoryInfo($categoryId);



        return view('admin.product_category_edit')->with('cateInfo',$cateInfo)->with('vendors',$vendors)->with('cateInfos',$cateInfos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category,$id)
    {
        //Update the record
        //$category->updateRecord();

        $image = request()->file('inputFile');
        if($image) {

        $target_dir = "public/images/product_category/".$id;

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName();  
            $destinationPath = public_path().'/images/product_category/'.$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);
            
           DB::table('product_category')
            ->where('cate_id', $_POST['cate_id'])
            ->update(['cate_name' => str_replace("/"," ",$_POST['name']),'vendor_id' => $_POST['vendor'],'cate_image'=>$imagename, 'cate_slug' => (str_replace(' ', '_', strtolower($_POST['name']))), 'cate_desc' => $_POST['message'],  'updated_at' => date('Y-m-d h:i:s')]);
                
        }else{

            DB::table('product_category')
            ->where('cate_id', $_POST['cate_id'])
            ->update(['cate_name' => str_replace("/"," ",$_POST['name']),'vendor_id' => $_POST['vendor'],'cate_slug' => (str_replace(' ', '_', strtolower($_POST['name']))), 'cate_desc' => $_POST['message'],  'updated_at' => date('Y-m-d h:i:s')]);
        }
        return redirect('admin/product/category')->with('message', 'Success: Category was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category,$categoryId)
    {
        //Delete the record
        $category->destroyRecord($categoryId);

        return 'success';
    }
}