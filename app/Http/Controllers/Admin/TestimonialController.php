<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\Testimonials;

class TestimonialController extends JoshController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all the testimonials
        $testimonials = DB::table('site_testimonials')
            ->leftJoin('users', 'site_testimonials.created_by', '=', 'users.id')
            ->orderBy('site_testimonials.t_id', 'DESC')
            ->paginate(5);

        return view('admin.testimonial')->with('testimonials', $testimonials);
    }

    public function add() {
         return view('admin.testimonialadd');
    }

    public function delete($id) {
        DB::table('site_testimonials')->where('t_id', '=', $id)->delete();
        return 'success';
    }

    public function editTestimonail($id) {


     

       $data =  Testimonials::where('t_id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }               
      
      $testimonial = DB::table('site_testimonials')
                    ->where('t_id','=',$id)
                    ->get()
                    ->toArray();

  
        return view('admin.testimonialedit')->with('testimonials', 'testimonials')->with('testimonials', $testimonial);
    }

     public function manage_testimonial(Request $request)
    {

      // echo "hii"; exit;
       $search = $request->get('testimonial_search');
       $testimonials = DB::table('site_testimonials')
       ->where('t_quote','like','%'.$search.'%')
       ->orwhere('t_name','like','%'.$search.'%')
       ->orwhere('t_company','like','%'.$search.'%')
       ->orwhere('t_image','like','%'.$search.'%')
       ->paginate(10);   
      // echo "<pre>"; print_r($testimonials); exit; 

       return view('admin.testimonial')->with('testimonials', $testimonials);
       // return view('admin/testimonial',compact('testimonials',$testimonials));
    }

    public function editPostTestimonail(Request $request,$id) {
        
        $image = request()->file('inputFile');
        if($image) {

        $target_dir = "public/images/testimonial/".$id;

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName();  
            $destinationPath = public_path().'/images/testimonial/'.$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

           $testimonial = DB::table('site_testimonials')
            ->where('t_id', $id)
            ->update(['t_rating' => $_POST['rating'], 't_quote' => $_POST['message'], 't_name' => $_POST['name'], 't_company' => $_POST['company'],'t_image' => $imagename , 'created_by' => '1','updated_at' => date('Y-m-d h:i:s')]);
                
        }else{

            $testimonial = DB::table('site_testimonials')
            ->where('t_id', $id)
            ->update(['t_rating' => $_POST['rating'], 't_quote' => $_POST['message'], 't_name' => $_POST['name'], 't_company' => $_POST['company'],'created_by' => '1','updated_at' => date('Y-m-d h:i:s')]);
        }
           
        return redirect('admin/testimonials');

    }

    public function addTestimonail(Request $request,$id="") {

        //Insert in to the database
        if($request->hasFile('inputFile')) { 

            $photo = $request->file('inputFile');
            $imagename = $photo->getClientOriginalName();  
        
            $ids = DB::table('site_testimonials')->insertGetId(
            ['t_rating' => $_POST['rating'], 't_quote' => $_POST['message'], 't_image' => $imagename, 't_name' => $_POST['name'], 't_company' => $_POST['company'], 'created_at' => date('Y-m-d h:i:s'), 'created_by' => '1']
            );

            $target_dir = "public/images/testimonial/".$ids."/".$id;    

            if (!file_exists($target_dir))
            {
                mkdir($target_dir, 0777, true);
            }

            $destinationPath = public_path().'/images/testimonial/'. $ids."/".$id;
            $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
            $thumb_img->save($destinationPath.'/'.$imagename,80);

        }

        return redirect('admin/testimonials');
    }
}


