<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogComment;
use App\Http\Requests\BlogCommentRequest;
use Response;
use Sentinel;
use DB;


class BlogController extends JoshController
{


    private $tags;

     public function __construct()
    {
        parent::__construct();
        $this->tags = Blog::allTags();

        $property_list = DB::table('property_listing')->get();
        $product_list = DB::table('product_listing')->get(); 
        $popular_list = DB::table('popular_categories')->get();
        $setting = DB::table('general_setting')->get();

        \View::share('property_list',$property_list);
        \View::share('product_list',$product_list);
        \View::share('popular_list',$popular_list);
        \View::share('setting',$setting);
    }


    public function index()
    {
        // Grab all the blogs
        $blogs = Blog::latest()->paginate(5);

        $tags = $this->tags;
        // Show the page

        return view('blog', compact('blogs', 'tags'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function getBlog($slug = '')
    {

        $blog = Blog::where('slug', $slug)->first();
        if ($blog) {
            $blog->increment('views');
        } else {
            abort('404');
        }
        // Show the page
        return view('blogitem', compact('blog'));
    }

    /**
     * @param $tag
     * @return \Illuminate\View\View
     */
    public function getBlogTag($tag)
    {
        $blogs = Blog::withAnyTags($tag)->paginate(5);
        $tags = $this->tags;
        return view('blog', compact('blogs', 'tags'));
    }

    /**
     * @param BlogCommentRequest $request
     * @param Blog $blog
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeComment(BlogCommentRequest $request, Blog $blog)
    {
        $blogcooment = new BlogComment($request->all());
        $blogcooment->blog_id = $blog->id;
        $blogcooment->save();
        return redirect('blogitem/' . $blog->slug);
    }

}
