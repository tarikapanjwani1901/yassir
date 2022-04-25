<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use App\Inquiry;
use DB;
use Image;

class ProductController extends Controller
{
   
    public function index(Request $request)
    {
        
        //Check user role
        $vendor = '';
        if (Sentinel::inRole('vendor')) {
            $vendor = Sentinel::getUser()->id;
        }
        $vendor_name = $request->get('vendor_name');
        $category_name = $request->get('category_name');
        $vendor_list = DB::table('users')->select('id','company_name')->where('user_category',4)->orderBy('company_name')->get();
        $category_list = DB::table('product_category')->select('cate_id','cate_name')->orderBy('cate_name')->get();

        //Get all the data from Product
        $product = Product::getAllProducts($vendor);

       
        //Get all the category list
        $category = Product::getProductCategory($vendor);
        return view('admin.product')->with('product',$product)->with('category',$category)
        ->with('vendor_list',$vendor_list)->with('vendor_name',$vendor_name)->with('category_list',$category_list)->with('category_name',$category_name);
    }



     public function manage_product(Request $request)
    {
        $vendor = '';
        if (Sentinel::inRole('vendor')) {
            $vendor = Sentinel::getUser()->id;
        }
        
        //$vendor_list = DB::table('users')->select('id','company_name')->whereNotNull('company_name')->get();
        $vendor_list = DB::table('users')->select('id','company_name')->where('user_category',4)->orderBy('company_name')->get();
        $category_list = DB::table('product_category')->select('cate_id','cate_name')->orderBy('cate_name')->get();
        $category = Product::getProductCategory($vendor);

       $search = $request->get('product_search');
       $vendor_name = $request->get('vendor_name');
       $category_name = $request->get('category_name');

        $users_info = DB::table('product')
            ->select('product.*','vendor_listing.url_name','vendor_listing.l_title','vendor_listing.vl_id','category_type_material.id as mid','category_type_material.name','product_category.vendor_id','product_category.cate_name')
            ->join('vendor_listing','vendor_listing.u_id','=','product.v_id')
              ->leftjoin('product_category','product_category.cate_id','product.product_category')   
            ->join('category_type_material','category_type_material.id','=','product.sub_cat_id')->orderBy('product.created_at','DESC');

        if ($search != 'null' && $search != '') {
            $users_info->where("product.product_name", 'like', '%'.$search.'%');
        }

        if ($vendor_name != 'null' && $vendor_name != '') {
            $users_info->where("product.v_id",'=',$vendor_name);
            
        }

        if ($category_name != 'null' && $category_name != '') {
            $users_info->where("product.product_category",'=',$category_name);
        }

        $product = $users_info->paginate(100);

         return view('admin/product')->with('product',$product)->with('category',$category)->with('vendor_list',$vendor_list)->with('vendor_name',$vendor_name)->with('category_list',$category_list)->with('category_name',$category_name);
    }
    

    public function store(Request $request,$id="")
    {

        if($request->hasFile('inputFile')) { 

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName();  
            
            // $product_id = DB::table('product')->insertGetId(
            //     ['v_id' => $_POST['vendor'], 'cat_id' => '4', 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'], 'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'product_img' => $imagename, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s') ]
            // );
            
            $product_id = DB::table('product')->insertGetId(
                ['v_id' => $_POST['vendor'], 'cat_id' => '4', 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'], 'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'product_img' => $imagename, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s') ]
            );

            $target_dir = "public/images/product/".$product_id."/".$id;    

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $destinationPath = public_path().'/images/product/'. $product_id."/".$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

        }


        return redirect('admin/product')->with('message', 'Success: Product was successfully created.');
    }

    
    public function show(Product $product)
    {
        //Check user role
        $vendor = '';
        if (Sentinel::inRole('vendor')) {
            $vendor = Sentinel::getUser()->id;
        }

        //Grab all vendors
        $vendors = Inquiry::getVendorMaterial();

        //Get all the sub category
        $type = Product::getType();

        //Get all the category list
        $category = Product::getProductCategory($vendor);

        return view('admin.product_add')->with('type',$type)->with('category',$category)->with('vendors',$vendors);
    }

   
    public function edit(Product $product,$productID)
    {


        //Check user role
        $vendor = '';
        if (Sentinel::inRole('vendor')) {
            $vendor = Sentinel::getUser()->id;
        }

        //Get all the sub category
        $type = Product::getType();

        //Grab all vendors
        $vendors = Inquiry::getVendorMaterial();

        //Get the product information
        $productInfo = Product::getProductInfo($productID);

        //Get all the category list
        $category = Product::getProductCategory($vendor);

        return view('admin.product_edit')->with('type',$type)->with('productInfo',$productInfo)->with('category',$category)->with('vendors',$vendors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,$id)
    {
        //Update product information
        //$product->updateProduct();

        $image = request()->file('inputFile');
        if($image) {

        $target_dir = "public/images/product/".$id;

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName();  
            $destinationPath = public_path().'/images/product/'.$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

            //  DB::table('product')
            // ->where('id', $id)
            // ->update(['v_id' => $_POST['vendor'], 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'],'product_img'=> $imagename,'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'updated_at' => date('Y-m-d h:i:s') ]);
            
           DB::table('product')
            ->where('id', $id)
            ->update(['v_id' => $_POST['vendor'], 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'],'product_img'=> $imagename,'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'updated_at' => date('Y-m-d h:i:s') ]);
                
        }else{

            DB::table('product')
            ->where('id', $id)
            ->update(['v_id' => $_POST['vendor'], 'sub_cat_id' => $_POST['s_category'], 'product_name' => $_POST['name'],'product_category' => implode(',', $_POST['product_category']), 'product_price' => $_POST['price'], 'product_qty' => $_POST['qty'], 'product_detail' => $_POST['message'], 'updated_at' => date('Y-m-d h:i:s') ]);
        }
        return redirect('admin/product')->with('message', 'Success: Product was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$productID)
    {
        //Destroy product
        Product::destroyRecord($productID);

        return 'success';
    }

    public function product_delimage(Request $request)
    {
        $file = $request->input('file');
        $id = $request->input('id');

          DB::table('product')
            ->where('id', $id)
            ->update(['product_img' => NULL ]);

           

            return response()->JSON($file);

    }
}
