@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{$blog->title}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/frontend/blog.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="blg-cover">
    <div class="container blog-detail p-t-150 aboutpage">
        <h2 class="primary marl12">{{$blog->title}}</h2>
        <div class="row content">
            <!-- Business Deal Section Start -->

                <div class="featured-post-wide img">
                     <div class="col-sm-12 col-md-5">
                    @if($blog->image)
                        <img src="{{ URL::to('public/uploads/blog/'.$blog->image)  }}" class="img-responsive" alt="Image">
                    @endif
                    </div>
                     <div class="col-sm-12 col-md-7">
                    <!-- /.blog-detail-image -->
                    <div class="the-box no-border blog-detail-content">
                        <p class="additional-post-wrap">
                            <span class="additional-post">
                                    <i class="livicon" data-name="user" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i> by&nbsp;<a href="#">{{$blog->author->first_name . ' ' . $blog->author->last_name}}</a>
                                </span>
                            <span class="additional-post">
                                    <i class="livicon" data-name="clock" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> {{$blog->created_at->diffForHumans()}} </a>
                                </span>
                            <span class="additional-post">
                                    <i class="livicon" data-name="comment" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> {{$blog->comments->count()}} comments</a>
                                </span>
                        </p>
                        <p class="text-justify">
                            {!! $blog->content !!}
                        </p>
                        <div class="blog-detail-image">
                            @if(!empty($blog->summernote_image))
                                <img src="{{URL::to('uploads/blog/'.$blog->summernote_image)}}" class="img-responsive summernote_image" alt="Image">
                            @endif
                        </div>
                        <div class="tags">
                            <strong>Tags: </strong>
                            @forelse($blog->tags as $tag)
                                <a href="{{ URL::to('blog/'.mb_strtolower($tag).'/tag') }}">{{ $tag }}</a>,
                            @empty
                                No Tags
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- /the.box .no-border -->
                <!-- Media left section start -->
                    <div class="col-sm-12 commentbox">

                <ul class="media-list">
                    @foreach($blog->comments as $comment)
                    <li class="media">
                        <div class="media-body">
                            <h4 class="media-heading"><i>{{$comment->name}}</i></h4>
                            <p>{{$comment->comment}}</p>
                            <p class="text-danger">
                                <small> {!! $comment->created_at!!}</small>
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <!-- //Media left section End -->
                <!-- Comment Section Start -->
                <h3>Leave a Comment <span class="commntcount">{{$blog->comments->count()}} Comments</span></h3>
                {!! Form::open(array('url' => URL::to('blogitem/'.$blog->id.'/comment'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::text('name', null, array('class' => 'form-control input-lg','required' => 'required', 'placeholder'=>'Your name')) !!}
                    <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::text('email', null, array('class' => 'form-control input-lg','required' => 'required', 'placeholder'=>'Your email')) !!}
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                </div>
                <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
                    {!! Form::text('website', null, array('class' => 'form-control input-lg', 'placeholder'=>'Your website')) !!}
                    <span class="help-block">{{ $errors->first('website', ':message') }}</span>
                </div>
                <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                    {!! Form::textarea('comment', null, array('class' => 'form-control input-lg no-resize','required' => 'required', 'style'=>'height: 200px', 'placeholder'=>'Your comment')) !!}
                    <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn commonbtn">
                        <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                        Submit
                    </button>
                </div>
                {!! Form::close() !!}
                <!-- //Comment Section End -->
            </div>
                    </div>
            <!-- //Business Deal Section End -->
            <!-- /.col-sm-9 -->
            <!-- Recent Posts Section Start -->
            <!-- //Recent Posts Section End -->
            <!-- /.col-sm-3 -->
        </div>
    </div>
</div>
    <!-- //Conatainer Section End -->
@stop
