<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YasSir | Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/css/material-design.css')); ?>">
<style type="text/css">.loginBg{background:url(../images/login/bg.jpg) no-repeat center fixed;background-size:cover}
.loginPage {padding:150px 0px 51px 0px;display:block}
.loginPage .container{padding:60px 0;display:block;position:relative}
.loginPage .container::before{content:'';position:absolute;top:0;right:0;width:68%;height:100%;background:#fff;display:block;-webkit-box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10);box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10)}
.loginPage .loginBox{padding:30px;display:block;text-align:center;background:#8c1730;-webkit-box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10);box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10);color:#fff;margin:50px auto;max-width:400px}
.loginPage .loginBox figure{ padding:15px;display: inline-flex; width:125px;height:125px;background:#fff;border-radius:50%; }
.loginPage .loginBox h1{font-size:40px}
.loginPage .loginBox P{padding-top:15px;font-size:16px;color:#fff}
.loginPage .loginBox a{color:#fff}
.loginPage .loginBox a.forgotPassword{margin:10px 20px;float:left}
.loginPage .loginForm{display:block}
.loginPage .loginForm .btn{padding:10px 40px;float:left}
.loginPage .loginForm .btn.submitButton{margin-top:20px}
.loginPage .loginForm p{display:block;text-align:left}
.loginPage .mdl-textfield__label{padding:10px 0;color:#fff}
.loginPage .mdl-textfield{border:none;color:#fff}
.loginPage .mdl-textfield__input{padding:10px 0;border-bottom:#fff solid 1px}
.whyJoinUs{display:block;margin-top:50px}
.whyJoinUs h2{margin-top:0;text-align:center;color:#29333d;font-size:41px;line-height:41px;font-family:proxima_nova_rgregular}
.whyJoinUs p{padding:15px 128px;font-size:16px;color:#29333d;text-align:center}
.whyJoinUs .iconListing{padding:30px;width:100%}
.whyJoinUs .iconListing ul{display:block}
.whyJoinUs .iconListing ul li{padding:0 0 10px 80px;display:block;position:relative}
.whyJoinUs .iconListing ul li figure{width:65px;height:65px;position:absolute;top:0;left:0}
.whyJoinUs .iconListing ul li h3{padding:0;color:#49515a;font-size:18px;font-family:proxima_nova_ltsemibold!important}
.whyJoinUs .iconListing ul li p{padding:0;font-size:16px;color:#49515a;font-family:proxima_nova_rgregular;text-align:left}
@media  screen and (max-width:1366px) {
.loginPage .container{padding:45px 0 30px}
.loginPage .container::before{width:67%}
.loginPage .loginBox{margin:30px auto;max-width:360px}
.loginPage .loginBox figure{height:85px;width:85px}
.loginPage .loginBox p{padding:0}
}
@media  screen and (max-width:768px) {
.loginPage .container::before{display:none}
.loginPage .container{padding:15px}
.loginPage .loginBox{margin-bottom:20px}
.whyJoinUs{padding-top:20px;background-color:rgba(255,255,255,.85)}
.loginPage .mdl-textfield{float:left;width:48%}
.loginPage .mdl-textfield:nth-child(even){margin-left:4%}
}
@media  screen and (max-width:480px) {
.loginPage .loginBox{padding:40px 20px}
.whyJoinUs p{padding:0 15px}
.whyJoinUs .iconListing{padding:15px}
.whyJoinUs .iconListing ul li{padding:0;text-align:center}
.whyJoinUs .iconListing ul li figure{position:inherit;top:inherit;left:inherit;display:inline-block}
.whyJoinUs .iconListing ul li h3{margin-top:0}
.whyJoinUs .iconListing ul li p{margin-bottom:20px;text-align:center}
}
@media  screen and (max-width:360px) {
.loginPage .mdl-textfield{float:none;width:100%}
.loginPage .mdl-textfield:nth-child(even){margin-left:inherit}
}
.btn-danger{background-color: #fff;color:#8c1730;border-color: #fff;}
.btn-danger:hover {background-color: #ccc; border-color: #ccc;color:#000;}
::-webkit-input-placeholder { /* Chrome/Opera/Safari */color: #fff;}
::-moz-placeholder { /* Firefox 19+ */color: #fff;}
:-ms-input-placeholder { /* IE 10+ */color: #fff;}
:-moz-placeholder { /* Firefox 18- */color: #fff;}
body {
    position: relative;
    background-image: url(public/images/login-bg.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    height: 100vh;
}
label.error {display: block;text-align: left;padding-top: 5px;}
.signuptxt {margin: 20px  0 0 0; }
</style>
</head>
<body class="home">
<div class="container">
    <div class="row">
        <div class="loginPage">
            <div class="loginBox">
                <figure class="img-circle">
                   <img src="<?php echo e(asset('public/assets/images/logo-black.svg')); ?>" alt="Yassir your corporate motto">
                </figure>
                <?php if(Session::get('login_mobile')): ?>
                <h2>OTP Verification</h2>
                <?php else: ?>
                <h2>Log In</h2>
                 <?php endif; ?>
                 <div id="notific" class="hide_msg">
                <?php echo $__env->make('notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <?php if(Session::get('login_mobile')): ?>
                <div class="loginForm">
                	 <form method="post" id="login_form" action="<?php echo e(route('otpSubmit')); ?>" autocomplete="off">
                     <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                     <input type="hidden" name="mobile_number" value="<?php echo e(Session::get('login_mobile')); ?>">
                     
                      <div class="form-group <?php echo e($errors->first('otp', 'has-error')); ?>">
                        <input type="text" class="mdl-textfield__input" placeholder="Please enter otp" id="otp" name="otp">
                      </div>
                      <span class="help-block"><?php echo e($errors->first('otp', ':message')); ?></span>
                      <div class="clearfix">
                        <input type="submit" class="btn btn-danger submitBtn" name="submit" value="SUBMIT">     <a href="javascript:void(0)" class="forgotPassword back_to_login"><strong> Back to login</strong></a>
                     </div>
                        <div class="text-center signuptxt">
                    <a href="javascript:void(0)" class="resend_otp"><strong> Resend OTP</strong></a>                
                    </div>
                    </form>
                </div>
                <?php else: ?>
                <div class="loginForm">
                    <form method="post" id="login_form" action="<?php echo e(route('login')); ?>" autocomplete="off">
                     <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                      <div class="form-group <?php echo e($errors->first('mobile_number', 'has-error')); ?>">
                        <input type="text" class="mdl-textfield__input" placeholder="Mobile No" id="mobile_number" name="mobile_number">
                      </div>
                      <span class="help-block"><?php echo e($errors->first('mobile_number', ':message')); ?></span>
                      <div class="clearfix">
                        <input type="submit" class="btn btn-danger submitBtn" name="submit" value="Log In">
                     </div>
                        <div class="text-center signuptxt">
                    Don't have an account? <a href="<?php echo e(url('/')); ?>/becomevendor"><strong> Sign Up</strong></a>
                    </div>
                    </form>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo e(asset('public/assets/js/frontend/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('public/assets/js/frontend/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo e(asset('public/assets/vendors/iCheck/js/icheck.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('public/assets/js/frontend/login_custom.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/jquery.validate.min.js')); ?>"></script>

<script>
$(document).ready(function () {
    $('#login_form').validate({
        rules: {
            mobile_number: {
                required: true,
				number:true
            },
			otp: {
                required: true,
				number:true
            },
			
            
        },
        messages:{
            moble_number:{
                required:"Please enter your mobile number.",
            },

        },
    });

});
$(".hide_msg").fadeTo(2000, 500).slideUp(500, function(){
    $(".hide_msg").slideUp(500);
});

jQuery(document).on("click",".resend_otp",function(){
 $.ajax({
            type: "GET",
            url: "<?php echo e(route('resendOTP')); ?>",
            dataType: "json",
            success: function (data) {
				if(data.success){
					alert("OTP has been successfully send.");	
				}else{
					alert("Sorry invalid request. please try again.");		
				}
            },
            error: function () {
				
					alert("Sorry invalid request. please try again.");	
			},
        });
});

jQuery(document).on("click",".back_to_login",function(){
 
 $.ajax({
            type: "GET",
            url: "<?php echo e(route('backtologin')); ?>",
            dataType: "json",
            success: function (data) {
				window.location.reload();
				
            },
            error: function () {
		//		
			//		alert("Sorry invalid request. please try again.");	
			},
        });
});


</script>
</body>
</html>
<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>