<title>About Us</title>
@include('header')
<body class="stickynav home">
<div id="main" class="inner-content aboutpage">
  	   <div class="inner-banner-row" style="background-image:url(public/assets/images/inner-banner1.png);">
	@foreach($cms_info as $cms)
	<div class="bannertext">
               <h1>{{ $cms->title }}</h1>
    </div>
	</div>
	<div class="container padd100">		
		{!! $cms->description !!}		
	</div>
	@endforeach
</div>
@include('footer')