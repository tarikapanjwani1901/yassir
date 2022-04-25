<title>Blog</title>
@extends('layouts/default')

@section('content')
    <!-- Container Section Strat -->
    <div class="blg-cover">
    <div class="container">
        <div class="commonttl-subttl p-t-150">
                <h2>Blog</h2>
            </div>
        <div class="row">
            <div class="content">
                <div class="bloglisting">
                    @forelse ($blogs as $blog)
                    <!-- BEGIN FEATURED POST -->
                    <div class="blog-box thumbnail">
                        @if($blog->image)
                        <figure>
                        <img src="{{ URL::to('public/uploads/blog/'.$blog->image)  }}" class="img-responsive" alt="Image"></figure>
                        @endif
                        <div class="featured-text relative-left">
                            <h3 class="primary"><a href="{{ URL::to('blogitem/'.$blog->slug) }}">{{$blog->title}}</a></h3>
                            <p>
                               {!! App\Http\Controllers\ListingController::getExcerpt($blog->content) !!}
                            </p>
                            <div class="tags">
                                <strong>Tags: </strong>
                                @forelse($blog->tags as $tag)
                                    <a href="{{ URL::to('blog/'.mb_strtolower($tag).'/tag') }}">{{ $tag }}</a>
                                @empty
                                    No Tags
                                @endforelse
                            </div>
                            <p class="additional-post-wrap">
                                <span class="additional-post">
                                    <i class="livicon" data-name="user" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i> by&nbsp;<a href="#">{{$blog->author->first_name . ' ' . $blog->author->last_name}}</a>
                                </span>
                                <span class="additional-post">
                                    <i class="livicon" data-name="clock" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> {{$blog->created_at->diffForHumans()}}</a>
                                </span>
                                <span class="additional-post">
                                    <i class="livicon" data-name="comment" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> {{$blog->comments->count()}} comments</a>
                                </span>
                            </p>

                            <p class="text-right">
                                <a href="{{ URL::to('blogitem/'.$blog->slug) }}" class="btn commonbtn">Read more</a>
                            </p>
                        </div>
                        <!-- /.featured-text -->
                    </div>
                    <!-- /.featured-post-wide -->
                    <!-- END FEATURED POST -->
                    @empty
                        <h3 class="text-center">No Posts Exists!</h3>
                    @endforelse
                    <ul class="pager">
                        {!! $blogs->render() !!}
                    </ul>
                </div>
                <!-- /.col-md-8 -->
                <!-- /.col-md-4 -->
            </div>
        </div>
    </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')

@stop
