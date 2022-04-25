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
		 <h1>Reset Password</h1>
	   <form>
	    <div class="row tablebox">
		    <div class="col-sm-6  tablecell loginlogo">
			  <img src="{{ asset('public/images/logo-white.png') }}" alt="Yassir your corporate motto">
			</div>
			 <div class="col-sm-6 tablecell">
		
			
			      <div class="formheader">
				     <div class="formgroup">
					    <label>New Password</label> <div class="icons">
						<i class="fa fa-lock"></i><input type="text"></div>
					 </div>
					 <div class="formgroup">
					    <label>Confirm Password</label> <div class="icons">
						<i class="fa fa-lock"></i><input type="password"></div>
					 </div>

		    </div>
			<div class="formfooter">
			  <input type="submit" value="reset password">
			</div>
			  
			</div>
		</div>
		
		 </form>
	</div>
	</body>
	</html>