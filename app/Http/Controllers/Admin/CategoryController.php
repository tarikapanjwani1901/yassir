<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Image;
use Auth;
use DB;

class CategoryController extends JoshController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get all the category
        $category = DB::table('category')->get();

        $id = ($request->query('cate')) ? $request->query('cate') : '5';
        $db = $this->getCategoryValue($id);

        //Get first category list
        $category_list = DB::table($db)->orderBy('id','DESC')->paginate(15);

        return view('admin.category')->with('category', $category)->with('category_list', $category_list)->with('cat_id',$id);
    }

    public function add(Request $request) {
        if ($_POST) {

            $db = $this->getCategoryValue($request->input('category'));

            //Insert new record in category list
            $id = DB::table($db)->insertGetId(
                ['name' => $request->input('name'), 'slug' => strtolower($request->input('slug')), 'image' =>  trim(str_replace(" ","_", $_FILES['inputFile']['name']))]
            );

            $target_dir = "public/images/category/".$request->input('category');

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName(); 
            $destinationPath = public_path('/images/category/'.$request->input('category'));
            $thumb_img = Image::make($photo->getRealPath())->resize(325,150);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

            $destinationPath = public_path('/normal_images');
            $photo->move($destinationPath, $imagename);

            return redirect('admin/categories');

        } else {
            return view('admin.categoryadd');
        }
    }

    public function edit($id,$lid) {


        $db = $this->getCategoryValue($id);

        $categoryResult = DB::table($db)
            ->where('id','=',$lid)
            ->get()
            ->toArray();

        return view('admin.categoryedit')->with('categoryResult',$categoryResult)->with('id',$id);
    }

    public function editPost(Request $request,$id) {


        $db = $this->getCategoryValue($request->input('id'));

        DB::table($db)
            ->where('id', $request->input('lid'))
            ->update(['name' => $request->input('name'), 'slug' => strtolower($request->input('slug'))]);

        if ($_FILES['inputFile']["name"]) {
            DB::table($db)
            ->where('id', $request->input('lid'))
            ->update(['image' => trim(str_replace(" ","_", $_FILES['inputFile']['name']))]);
        }

        $target_dir = "public/images/category/".$request->input('id');

        $photo = $request->file('inputFile');
        if($photo != ""){
        $imagename = $photo->getClientOriginalName();
        $destinationPath = public_path('/images/category/'.$request->input('id'));
        $thumb_img = Image::make($photo->getRealPath())->resize(325,150);
        $thumb_img->save($destinationPath.'/'.$imagename,80);

        $destinationPath = public_path('/normal_images');
        $photo->move($destinationPath, $imagename);
        }

        // Check if file already exists

        return redirect('admin/categories?cate='.$request->input('id'));

    }

    public function delete($id,$lid) {
        $db = $this->getCategoryValue($id);

        DB::table($db)->where('id', '=', $lid)->delete();
        return 'success';
    }

    public function getCategoryValue($id) {
        $array = array(
            '1' => 'category_type_properties',
            '2' => 'category_type_consultancy',
            '3' => 'category_type_contractor',
            '4' => 'category_type_material',
            '5' => 'category_type_skill_labour',
        );
        return $array[$id];
    }

    public function categories_delimage(Request $request)
    { 

        $file = $request->input('file');
        $id = $request->input('id');

          DB::table('category_type_material')
            ->where('id', $id)
            ->update(['image' => NULL ]);
            
         unlink(public_path().'/images/category/4/'.$file); 

        return response()->JSON($file);
    }
}


