@include('header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YasSir | Your Corporate Motto</title>
    <link rel="stylesheet"  href="{{ asset('public/assets/css/material-design.css') }}">
<style>.loginBg{background:url(../images/login/bg.jpg) no-repeat center fixed;background-size:cover}
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
@media screen and (max-width:1366px) {
.loginPage .container{padding:45px 0 30px}
.loginPage .container::before{width:67%}
.loginPage .loginBox{margin:30px auto;max-width:360px}
.loginPage .loginBox figure{height:85px;width:85px}
.loginPage .loginBox p{padding:0}
}
@media screen and (max-width:768px) {
.loginPage .container::before{display:none}
.loginPage .container{padding:15px}
.loginPage .loginBox{margin-bottom:20px}
.whyJoinUs{padding-top:20px;background-color:rgba(255,255,255,.85)}
.loginPage .mdl-textfield{float:left;width:48%}
.loginPage .mdl-textfield:nth-child(even){margin-left:4%}
}
@media screen and (max-width:480px) {
.loginPage .loginBox{padding:40px 20px}
.whyJoinUs p{padding:0 15px}
.whyJoinUs .iconListing{padding:15px}
.whyJoinUs .iconListing ul li{padding:0;text-align:center}
.whyJoinUs .iconListing ul li figure{position:inherit;top:inherit;left:inherit;display:inline-block}
.whyJoinUs .iconListing ul li h3{margin-top:0}
.whyJoinUs .iconListing ul li p{margin-bottom:20px;text-align:center}
}
@media screen and (max-width:360px) {
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
    background-image: url("{{ asset('public/images/login-bg.jpg')}}");
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    height: 100vh;
}
label.error {display: block;text-align: left;padding-top: 5px;}
.signuptxt {margin: 20px  0 0 0; }
</style>
</head>
<body  class="home">
<div class="container">
    <div class="row">
        <div class="loginPage">
            <div class="loginBox">
                <figure class="img-circle">
                   <img src="{{ asset('public/assets/images/logo-black.svg') }}" alt="Yassir your corporate motto">
                </figure>
                <h3>Reset your Password</h3>
            <div id="notific">
            @include('notifications')
            </div>
            <div class="loginForm">
            <form action="{{ route('forgot-password-confirm',compact(['userId','passwordResetCode'])) }}"  autocomplete="off" method="POST" id="login_form">
                {!! Form::token() !!}
                
                <div class="form-group">
                    <input type="password" class="mdl-textfield__input" id="password" name="password" placeholder="New Password">
                </div>
                
                <div class="form-group">
                    <input type="password" class="mdl-textfield__input" id="password_confirm" name="password_confirm" placeholder="Confirm New Password">
                </div>
                
                <div class="clearfix">    
                 <input type="submit" class="btn btn-danger" name="submit" value="Reset Password" style="padding: 10px 94px;">
                </div> 
            </form>
            </div>
        </div>
        </div>
    </div>
</div>
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/js/jquery.validate.min.js') }}"></script>
</body>
</html>
<script>
$(document).ready(function () {
    $('#login_form').validate({
        rules: {
            password: {
                required: true
            },
            password_confirm: {
                required: true,
                equalTo:"#password",
            },
        },
        messages:{
            password:{
                required:"Enter your new password",
            },

            password_confirm:{
                required:"Enter your confirm password",
                equalTo:"Password Is Not Match",
            },        
        },
    });
});
</script>
@include('footer')