<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\JoshController;
use App\Blog;
use App\BlogCategory;
use App\BlogComment;
use App\Http\Requests;
use App\Http\Requests\BlogCommentRequest;
use App\Http\Requests\BlogRequest;
use Response;
use Sentinel;
use Intervention\Image\Facades\Image;
use DOMDocument;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1); 
error_reporting(E_ALL);

class BlogController extends JoshController
{


    private $tags;

    public function __construct()
    {
        parent::__construct();
        $this->tags = Blog::allTags();
         $this->middleware('admin'); 
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the blogs
        $blogs = Blog::all();
        // Show the page
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $blogcategory = BlogCategory::pluck('title', 'id');
        return view('admin.blog.create', compact('blogcategory'));
    }

  
    public function store_backup(BlogRequest $request)
    {

        $blog = new Blog($request->except('files','image','tags'));
        $message=$request->get('content');
        $dom = new DomDocument();
        $dom->loadHtml($message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        // foreach <img> in the submited message
        foreach($images as $img){

            $src = $img->getAttribute('src');
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                // Generating a random filename
                $filename = uniqid();
                $filepath = "uploads/blog/$filename.$mimetype";
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    // resize if required
                    /* ->resize(300, 200) */
                    ->encode($mimetype, 100)  // encode file to the specified mimetype
                    ->save(public_path($filepath));
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-
        $blog->content = $dom->saveHTML();

        $picture = "";

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension()?: 'png';
            $picture = str_random(10) . '.' . $extension;
            $destinationPath = public_path() . '/uploads/blog/';
            $file->move($destinationPath, $picture);
            $blog->image = $picture;

        }
        $blog->user_id = Sentinel::getUser()->id;
        $blog->save();

        $blog->tag($request->tags?$request->tags:'');

        if ($blog->id) {
            return redirect('admin/blog')->with('success', trans('blog/message.success.create'));
        } else {
            return Redirect::route('admin/blog')->withInput()->with('error', trans('blog/message.error.create'));
        }

    }
    public function store(BlogRequest $request)
    {

        $blog = new Blog();

        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        //$blog->blog_category = $request->input('blog_category');
        /*
        $photo = $request->file('image');
        if(isset($photo)){
            $imagename = time().'.'.$photo->getClientOriginalName(); 
            $destinationPath = public_path('/uploads/blog');
            $thumb_img = Image::make($photo->getRealPath())->resize(300, 300);
            $thumb_img->save($destinationPath.'/'.$imagename,80);
            $destinationPath = public_path('/normal_images');
            $photo->move($destinationPath, $imagename);
            $blog->image = $imagename;
        }
        */

        $photo = $request->file('image');
        if(isset($photo)){
            $imagename = time().'.'.$photo->getClientOriginalName(); 
            $destinationPath = public_path('/uploads/blog');
            //$thumb_img = Image::make($photo->getRealPath())->resize(300, 300);
            
            //$destinationPath = public_path('/normal_images');
            $photo->move($destinationPath, $imagename);
            $blog->image = $imagename;
        }


        $blog->user_id = Sentinel::getUser()->id;
        $blog->save();
        $blog->tag($request->tags?$request->tags:'');

        if ($blog->id) {
            return redirect('admin/blog')->with('success', trans('blog/message.success.create'));
        } else {
            return Redirect::route('admin/blog')->withInput()->with('error', trans('blog/message.error.create'));
        }

    }


    public function show(Blog $blog)
    {
        $comments = Blog::find($blog->id)->comments;

        return view('admin.blog.show', compact('blog', 'comments', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Blog $blog
     * @return view
     */
    public function edit(Blog $blog)
    {
        $blogcategory = BlogCategory::pluck('title', 'id');
        return view('admin.blog.edit', compact('blog', 'blogcategory'));
    }

    public function update_backup(BlogRequest $request, Blog $blog)
    {
        $message=$request->get('content');
        libxml_use_internal_errors(true);
        $dom = new DomDocument();
        $dom->loadHtml($message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        // foreach <img> in the submited message
        foreach($images as $img){
            $src = $img->getAttribute('src');
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                // Generating a random filename
                $filename = uniqid();
                info($filename);
                $filepath = "uploads/blog/$filename.$mimetype";
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    ->encode($mimetype, 100)  // encode file to the specified mimetype
                    ->save(public_path($filepath));
                $new_src = asset($filepath);
            } // <!--endif
            else{
                $new_src=$src;
            }
            $img->removeAttribute('src');
            $img->setAttribute('src', $new_src);
        } // <!-
        $blog->content = $dom->saveHTML();
        
        $photo = $request->file('image');
        if(isset($photo)){
            $imagename = time().'.'.$photo->getClientOriginalName(); 
            $destinationPath = public_path('/uploads/blog');
            $thumb_img = Image::make($photo->getRealPath())->resize(300, 300);
            $thumb_img->save($destinationPath.'/'.$imagename,80);
            $destinationPath = public_path('/normal_images');
            $photo->move($destinationPath, $imagename);
            $blog->image = $imagename;
        }


        $blog->retag($request->tags?$request->tags:'');

        if ($blog->update($request->except('content','image','files','_method', 'tags'))) {
            return redirect('admin/blog')->with('success', trans('blog/message.success.update'));
        } else {
            return Redirect::route('admin/blog')->withInput()->with('error', trans('blog/message.error.update'));
        }
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $message=$request->get('content');
        libxml_use_internal_errors(true);
        $dom = new DomDocument();
        $dom->loadHtml($message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        // foreach <img> in the submited message
        /*
        foreach($images as $img){
            $src = $img->getAttribute('src');
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                // Generating a random filename
                $filename = uniqid();
                info($filename);
                $filepath = "uploads/blog/$filename.$mimetype";
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                    ->encode($mimetype, 100)  // encode file to the specified mimetype
                    ->save(public_path($filepath));
                $new_src = asset($filepath);
            } // <!--endif
            else{
                $new_src=$src;
            }
            $img->removeAttribute('src');
            $img->setAttribute('src', $new_src);
        } // <!-
        $blog->content = $dom->saveHTML();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension()?: 'png';
            $picture = str_random(10) . '.' . $extension;
            $destinationPath = public_path() . '/uploads/blog';
            $file->move($destinationPath, $picture);
            $blog->image = $picture;
        }*/

        $photo = $request->file('image');
        if(isset($photo)){
            $imagename = time().'.'.$photo->getClientOriginalName(); 
            $destinationPath = public_path('/uploads/blog');
            $thumb_img = Image::make($photo->getRealPath())->resize(300, 300);
            $thumb_img->save($destinationPath.'/'.$imagename,80);
            
           // $destinationPath = public_path('/normal_images');
            //$photo->move($destinationPath, $imagename);
            $blog->image = $imagename;
        }

         // $photo = $request->file('inputFile');
         //    $imagename = $photo->getClientOriginalName();  
         //    $destinationPath = public_path().'/images/product/'.$id;
         //    $thumb_img = Image::make($photo->getRealPath())->resize(200, 200);
         //    $thumb_img->save($destinationPath.'/'.$imagename,80);



        $blog->retag($request->tags?$request->tags:'');

        if ($blog->update($request->except('content','image','files','_method', 'tags'))) {
            return redirect('admin/blog')->with('success', trans('blog/message.success.update'));
        } else {
            return Redirect::route('admin/blog')->withInput()->with('error', trans('blog/message.error.update'));
        }
    }

    /**
     * Remove blog.
     *
     * @param Blog $blog
     * @return Response
     */
    public function getModalDelete(Blog $blog)
    {
        $model = 'blog';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.blog.delete', ['id' => $blog->id]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = trans('blog/message.error.destroy', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Blog $blog
     * @return Response
     */
    public function destroy(Blog $blog)
    {
        if ($blog->delete()) {
            return redirect('admin/blog')->with('success', trans('blog/message.success.delete'));
        } else {
            return Redirect::route('admin/blog')->withInput()->with('error', trans('blog/message.error.delete'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCommentRequest $request
     * @param Blog $blog
     *
     * @return Response
     */
    public function storeComment(BlogCommentRequest $request, Blog $blog)
    {
        $blogcooment = new BlogComment($request->all());
        $blogcooment->blog_id = $blog->id;
        $blogcooment->save();
        return redirect('admin/blog/' . $blog->id );
    }
}
