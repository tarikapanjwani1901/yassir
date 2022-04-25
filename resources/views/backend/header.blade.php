<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>YasSir| Your Corporate Motto</title>
        <meta name="description" content="Your Corporate Motto">
        <meta name="viewport" content="width=device-width, initial-scale=1">

	    <!--stylesheet-->
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/font-awesome.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/bootstrap.min.css') }}">
	    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend/css/style.css') }}">


	   	<!-- scripts -->
	    <script src="{{ asset('public/frontend/js/jquery-1.12.4.min.js') }}"></script>
	    <script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
	    <script src="{{ asset('public/backend/js/general.js') }}"></script>

	    <!--fonts-->
	    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

    </head>

	<body>
	    <!-- header-->
	    <header>
	        <div class="container-fluid">
	            <div class="row">
	                <div class="col-sm-3 col-md-4">
	                	<div class="logo">
		                	<a href="{{ url ('/') }}">
		                        <img src="{{ asset('public/frontend/images/logo.png') }}" alt="Yassir your corporate motto">
		                    </a>
	                    </div>
	                </div>
	                <div class="col-sm-9 col-md-8 text-right loginsection">
	                    <div class="loginbox">
	                        <ul>
							 <li><a href="#"><i class="fa fa-envelope"></i><span>5</span></a></li>
	                            <li><a href="#"><i class="fa fa-bell"></i><span>15</span></a></li>
	                            <li><a href="#">
									<figure><img src="{{ asset('public/backend/images/user.png') }}"></figure>User name</a>
								   	<ul class="submenu">
								    	<li><a href="#"> <i class="fa fa-user"></i> My Account</a></li>
										<li><a href="#"> <i class="fa fa-lock	"></i> Log Out</a></li>
								   </ul>
								 </li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </header>
	<!-- header end-->
	    <div class="dashboard-row">
			<div class="left-side">
				<div class="sidebar">
				   <ul id="menu" class="page-sidebar-menu">
				      <li><a href="#">Users</a></li>
				      <li><a href="/users">Users List</a></li>
				      <li><a href="/add_user">Add New User</a></li>
				      <li><a href="/bio/1">User Profile</a></li>
				      <li><a href="/deleted">Deleted users</a></li>
				      <li><a href="#">Testimonials</a></li>
				   </ul>
				</div>
			</div>

			<div class="right-side">
				<div class="contentsection">