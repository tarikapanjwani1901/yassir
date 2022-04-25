@include('header')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Yassir Your Corporate Motto</title>
    <link rel="stylesheet" href="{{ asset('public/assets/css/material-design.css') }}">
<style>
.loginBg{background:url(../images/login/bg.jpg) no-repeat center fixed;background-size:cover}
.loginPage{padding:150px 0px 51px 0px;display:block}
.loginPage .container{padding:60px 0;display:block;position:relative}
.loginPage .container::before{content:'';position:absolute;top:0;right:0;width:68%;height:100%;background:#fff;display:block;-webkit-box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10);box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10)}
.loginPage .loginBox{padding:30px;display:block;text-align:center;background:#8c1730;-webkit-box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10);box-shadow:1px 1px 36px 0 rgba(0,0,0,0.10);color:#fff;margin:50px auto;max-width:400px}
.loginPage .loginBox figure{ padding:15px;display: inline-flex; width:125px;height:125px;background:#fff;border-radius:50%;}
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
    background-image: url(public/images/login-bg.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    height: 100vh;
}
.vender-sign .loginPage .loginBox {margin: 30px auto; max-width: 600px;}
.vender-sign .loginPage{text-align: center;}
.vender-sign .loginBox{display: inline-block;margin: 0 auto;}

.icheckbox_minimal-blue.checked,
.iradio_minimal-blue.checked{background-color:#fff;}
.iradio_minimal-blue.checked{border-radius:100%;}
.icheckbox_minimal-blue, .iradio_minimal-blue {  background-image: url(public/assets/images/black-white.png);}
.icheckbox_minimal-blue, .iradio_minimal-blue {
    display: inline-block;
    vertical-align: middle;
    margin: 0;
    padding: 0;
    width: 18px;
    height: 18px;
    background: url(public/assets/images/blue.png) no-repeat;
    border: none;
    cursor: pointer;
}
.icheckbox_minimal-blue.checked {
    background-position: -40px 0;
}
.mdl-textfield .form-control {background-color: #8c1730;border: none;border-bottom:1px solid #fff;color: #fff;box-shadow:none;border-radius:0;padding-left:0;}
.mdl-textfield .form-control option {background: #fff;color: #000;}
.mdl-textfield {padding:5px 0 5px 0;}
label.error {display: block;text-align: left;padding-top: 5px;}
</style>
</head>
<div class="container">
    <!--Content Section Start -->
    <div class="row vender-sign">
        <div class="loginPage">
            <div class="loginBox">
                <figure class="img-circle">
                   <img src="{{ asset('public/assets/images/logo-black.svg') }}" alt="Yassir your corporate motto">
                </figure>
                <h2>Vendor Registration</h2>
                 <div id="notific">
                @include('notifications')
                </div>
                <div class="loginForm">
                    <form  id="register_form" method="post" autocomplete="off">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-sm-6">
                           <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">
                                <input id="first_name"  placeholder="First Name" type="text" class="mdl-textfield__input" name="first_name" value="" autofocus>
                                <div class="text-danger">{{$errors->first('first_name')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input id="company_name"placeholder="Company Name"  type="text" class="mdl-textfield__input" name="company_name" value="" autofocus>
                                <div class="text-danger">{{$errors->first('company_name')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="password" class="mdl-textfield__input" placeholder="Password" id="password" name="password">
                                 <div class="text-danger">{{$errors->first('password')}}</div>
                            </div>
                           
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="text" class="mdl-textfield__input" placeholder="Address" id="address" name="address">
                                 <div class="text-danger">{{$errors->first('address')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="text" class="mdl-textfield__input number" placeholder="Zipcode" id="zipcode" name="zipcode">
                                 <div class="text-danger">{{$errors->first('zipcode')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="text" class="mdl-textfield__input only" placeholder="Gstn" id="gstn" name="gst_number">
                                 <div class="text-danger">{{$errors->first('gst_number')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <select class="form-control" name="user_category" id="category">
                                   <option value="">Select Category</option>
                                    <option value="1">Properties </option>
                                    <option value="2">Consultancy </option>
                                    <option value="3">Contractor</option>
                                    <option value="4">Material</option>
                                </select>
                                 <div class="text-danger">{{$errors->first('user_category')}}</div>
                            </div>
                        </div>  
                        <div class="col-sm-6">
                           <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">
                                 <input id="last_name"  placeholder="Last Name" type="text" class="mdl-textfield__input" name="last_name" value="" autofocus>
                                  <div class="text-danger">{{$errors->first('last_name')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                    <input type="text" class="mdl-textfield__input" placeholder="E-Mail Address" id="email" name="email">
                                     <div class="text-danger">{{$errors->first('email')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="password" class="mdl-textfield__input" placeholder="Confirm Password" id="conform_password" name="conform_password">
                                 <div class="text-danger">{{$errors->first('conform_password')}}</div>
                            </div> 
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="text" class="mdl-textfield__input number" placeholder="Mobile" id="mobile" name="mobile">
                                 <div class="text-danger">{{$errors->first('mobile')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="text" class="mdl-textfield__input" placeholder="City" id="city" name="city">
                                 <div class="text-danger">{{$errors->first('city')}}</div>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <input type="text" class="mdl-textfield__input" placeholder="State" id="state" name="user_state">
                                 <div class="text-danger">{{$errors->first('user_state')}}</div>
                            </div>

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield" style="display: none;">                
                                <input type="text" class="mdl-textfield__input" placeholder="State" name="user_role" value="5">

                            </div>
                           
                             <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-upgraded" data-upgraded=",MaterialTextfield">                
                                <select class="form-control" name="user_sub_cate" id="types">
                                        <option value="">Sub Category</option>
                                        <?php foreach ($type as $key => $value) {?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                     <div class="text-danger">{{$errors->first('user_sub_cate')}}</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label class="">
                                    <input type="checkbox" name="subscribed" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                      I accept <a href="https://www.yassir.in/terms_of_use" target="_blank"> Terms and Conditions</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">  
                            <div class="pull-right">
                                <button id="btnlogin" class="btn btn-danger submitBtn" type="Submit">Register</button>
                            </div>
                        </div>                      
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
<script src="{{ asset('public/assets/js/frontend/register_custom.js') }}"></script>
<script>
    jQuery("#category").on('change',function(){
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getType')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#types").empty();

                    $("#types").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#types").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })
    });
</script>
<script src="{{ asset('public/assets/js/jquery.validate.min.js') }}"></script>
<script>
$(document).ready(function () {

    $.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a valid mobile number');
    $('#register_form').validate({
        rules: {
            first_name: {
                required:true,
            },
            last_name: {
                required:true,
            },
            company_name: {
                required:true,
            },
            email: {
                required: true,
                email:true,
            },
            password: {
                required: true,
                minlength: 6
            },
            conform_password: {
                required:true,
                equalTo:'#password'
            },
            mobile: {
                required:true,
                regex: '^([+][9][1]|[9][1]|[0]){0,1}([6-9]{1})([0-9]{9})$'
            },
            address: {
                required:true,
            },
            city: {
                required:true,
            },
            zipcode: {
                required:true,
            },
            user_state: {
                required:true,
            },
            gst_number: {
                required:true,
            },
            user_category: {
                required:true,
            },
            user_sub_cate: {
                required:true,
            },
        },
        messages:{
            first_name:{
                required:"Enter first name",
            },
            last_name:{
                required:"Enter last name",
            },
            company_name:{
                required:"Enter company name",
            },
            email:{
                required:"Enter email address",
                email:"Email is not valid",
            },
            password:{
                required:"Enter password",
                minlength:"Password must contain at least six characters"
            },
            conform_password:{
                required:"Enter confirm password",
                equalTo:"Password and confirm password do not match",
            },     
            mobile:{
                required:"Enter mobile number",
            },
            address:{
                required:"Enter address",
            },
            city:{
                required:"Enter city name",
            },
            zipcode:{
                required:"Enter zipcode",
            },
            user_state:{
                required:"Enter state name",
            },
            gst_number:{
                required:"Enter gstn number",
            },
            user_category:{
                required:"Select category",
            },
            user_sub_cate:{
                required:"Select sub category",
            },
        },
    });
});
$(".hide_msg").fadeTo(2000, 500).slideUp(500, function(){
    $(".hide_msg").slideUp(500);
});
$(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });
</script>

<script>
$(function () {
$('.only').keydown(function (e) {
if (e.shiftKey || e.ctrlKey || e.altKey) {
e.preventDefault();
} else {
var key = e.keyCode;
if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
e.preventDefault();
}
}
});
});
</script>

<!--global js end-->
</html>
@include('footer')