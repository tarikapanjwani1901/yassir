<!doctype html>
<html class="no-js" lang="">
    <head>
	<script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/jquery-1.12.4.min.js') }}"></script>
<!--stylesheet-->
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/css/style.css') }}">
		<!--favicon-->
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
<!--fonts-->
<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">

    </head>

    <body class="login-reg-page">
	<div class="container padd50">
		 <h1> Sign In</h1>
	   <form>
	    <div class="row tablebox">
		    <div class="col-sm-6  tablecell loginlogo">
			  <img src="{{ asset('public/images/logo-white.png') }}" alt="Yassir your corporate motto">
			</div>
			 <div class="col-sm-6 tablecell">
		
			
			      <div class="formheader">
				     <div class="formgroup">
					    <label>UserName</label>
						 <div class="icons">
						 <i class="fa fa-user"></i>
						<input type="text">
						</div>
						
					 </div>
					 <div class="formgroup">
					    <label>Password</label>
							 <div class="icons"> <i class="fa fa-lock"></i>
						<input type="password"></div>
					 </div>
				 <div class="formgroup">
				    <div class="row">
		   <div class="col-sm-6">
		      <div class="keepsigned">
			     <input type="checkbox">
				 <label>Keep me signed in</label>
			  </div>
		   </div>
		    <div class="col-sm-6 text-right"><a href="#">Forget Password?</a></div>
		  </div>
		  </div>
		    </div>
			<div class="formfooter">
			  <input type="submit" value="Sign In">
			</div>
			  
			</div>
		</div>
		
		 </form>
	</div>
	</body>
	</html>