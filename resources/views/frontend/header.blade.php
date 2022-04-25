<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>YasSir Your Corporate Motto</title>
        <meta name="description" content="Your Corporate Motto">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script data-ad-client="ca-pub-2472976030239875" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	    <!-- scripts -->
	    <script src="{{ asset('public/frontend/js/jquery-1.12.4.min.js') }}"></script>
	    <script src="{{ asset('public/frontend/js/jquery.flexslider.js') }}"></script>
	    <script src="{{ asset('public/frontend/js/modernizr.js') }}"></script>
	    <script src="{{ asset('public/frontend/js/general.js') }}"></script>
	    <script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>

	    <!--stylesheet-->
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/font-awesome.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/bootstrap.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/flexslider.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/style.css') }}">

	    <!--fonts-->
	    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">
		<!--favicon-->
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
		
		
     <script data-ad-client="ca-pub-2472976030239875" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
    </head>

    <body>
    	<!-- header-->
	    <header>
	        <div class="container">
	            <div class="row">
	                <div class="col-sm-3">
	                    <div class="logo">
	                    	<a href="{{ url ('/') }}">
	                        	<img src="{{ asset('public/images/logo-black.png') }}" alt="Yassir your corporate motto">
	                    	</a>
	                    </div>
	                </div>
	                <div class="col-sm-9 text-right navigation">
	                    <nav>
	                        <ul>
	                            <li><a href="{{ url ('/') }}">Home</a></li>
	                            <li><a href="{{ url ('services') }}">Services</a> <span></span>
	                                <ul>
	                                    <li><a href="{{ url ('services/properties') }}">Properties</a></li>
	                                    <li><a href="{{ url ('services/consultancy') }}">Consultancy</a></li>
	                                    <li><a href="{{ url ('services/contractor') }}">Contractor</a></li>
	                                    <li><a href="{{ url ('services/material') }}">Material</a></li>
	                                    <li><a href="{{ url ('services/labour') }}">Labour</a></li>
	                                </ul>
	                            </li>
	                            <li><a href="{{ url ('quick_quote') }}">Quick Quote</a></li>
	                            <li><a href="{{ url ('about_us') }}">About Us</a></li>
	                            <li><a href="{{ url ('contact_us') }}">Contact Us</a></li>
	                        </ul>
	                    </nav>
	                    <div class="loginbox">
	                        <ul>
	                            <li><a href="{{ url ('login') }}">Login</a></li> /
	                            <li><a href="{{ url ('signup') }}">Signup</a></li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </header>
	    <!-- header end-->