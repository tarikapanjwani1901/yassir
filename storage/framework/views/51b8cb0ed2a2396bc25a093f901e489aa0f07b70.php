<!-- footer-->
<link rel="stylesheet" href="<?php echo e(asset('public/css/footer.css')); ?>">
 <footer>

	  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	  <script>
		    //OTP logic
		    $(".onclick").click(function(){
		      var myBookId = $(this).data('id');
		      $(".modal-dialog #bookId").val( myBookId );
		    });
		    jQuery("#btn_ok_1").on('click',function(){
		        var listingPath = jQuery("#bookId").val();
		        var split = listingPath.split('/');
		     	var phoneNumber = jQuery(".otp_number").val();
		    	var user_name = jQuery(".otpuser_name").val();
		        if (user_name == '' && phoneNumber == '') {
		        	$(".error_msg").html('');
	              	$(".error_msg").html('Please enter field values.');
	              	var validate = false;
		        } else  if (user_name == null && phoneNumber !== undefined) {
		        	$(".error_msg").html('');
	              	$(".error_msg").html('Please enter your name.');
	              	var validate = false;
		        } else  if (user_name !== undefined && phoneNumber == null) {
		        	$(".error_msg").html('');
	              	$(".error_msg").html('Please put 10 digit mobile number');
	              	var validate = false;
		        } else {
		        	var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
		            if (filter.test(phoneNumber)) {
		              if(phoneNumber.length==10){
		              	$(".error_msg").html('');
		                var validate = true;
		              } else {
		              	$(".error_msg").html('');
		              	$(".error_msg").html('Please put 10 digit mobile number');
		                  var validate = false;
		              }
		            }
		            else {
		            	$(".error_msg").html('');
		              	$(".error_msg").html('Not a valid number');
		              	var validate = false;
		            }
		        }
		        if (typeof (split[2]) != "undefined" && split[2] !== null ) {
		        	var sval = split[2];
		        } else {
		        	var sval = split[1];
		        }
		        var letters = /^[A-Za-z]+$/;
				if(user_name.match(letters))
				{
				} else {
					$(".error_msg").html('');
	              	$(".error_msg").html('Please enter correct name.');
	              	var validate = false;
				}
		        //Update record in the system
	        	if (validate) {
			        $.ajax({
			           type:'get',
			           url:'/otpAdd/add/'+user_name+'/'+phoneNumber+'/'+sval,
			           success:function(data){
			                if (data == 'success') {
					            $(".otp_information").hide();
				        		$(".otp_information_submit").hide();
				        		$(".otp_num").show();
				        		$(".otp_num_submit").show();
			                } else {
			                	$(".error_msg").html('Something went wrong! Please try again.');
			                }
			           }
			        });
		        }
		    });
		    jQuery("#btn_ok_2").on('click',function(){
		    	var listingPath = jQuery("#bookId").val();
		        var split = listingPath.split('/');
		        if (typeof (split[2]) != "undefined" && split[2] !== null ) {
		        	var sval = split[2];
		        } else {
		        	var sval = split[1];
		        }
		    	var otp_verify = jQuery(".otp_verify").val();
		    	var phoneNumber = jQuery(".otp_number").val();
		    	var validate = true;
		    	if (otp_verify == '') {
		    		$(".error_msg").html('');
	              	$(".error_msg").html('Please enter OTP');
	              	var validate = false;
		    	}
		    	var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
	            if (filter.test(otp_verify)) {
	              if(phoneNumber.length==4){
	              	$(".error_msg").html('');
	                var validate = true;
	              } else {
	              	$(".error_msg").html('');
	              	$(".error_msg").html('Please put 4 digit');
	                  var validate = false;
	              }
	            }
	            //Verify OTP
		    	if (validate) {	
		    		$.ajax({
			           type:'get',
			           url:'/otpVerify/'+otp_verify+'/'+phoneNumber+'/'+sval,
			           success:function(data){
			                if (data == 'success') {
			                	var expDate = new Date();
						        expDate.setTime(expDate.getTime() + (15 * 60 * 1000)); // add 15 minutes
						        if (typeof $.cookie("otp_lists") !== 'undefined') {
						            var otp_lists = $.cookie("otp_lists")+','+sval;
						        } else {
						            var otp_lists = sval;
						        }
						        //Erase value
						        $.removeCookie("otp_lists", { path: '/' });
						        //Set new value
						        $.cookie("otp_lists",otp_lists, { path: '/', expires: expDate });
					            window.location.href = jQuery("#bookId").val();
			                } else {
			                	$(".error_msg").html('');
	              				$(".error_msg").html(data);
			                }
			           }
			        });
		    	}
		    });
	  </script>
  	<?php if (substr(strrchr(url()->current(),"/"),1) != 'contact_us') { ?>
    <div class="getointouch padd100">
		    <div class="container">
		     <div class="row">
			    <div class="col-sm-7 col-md-8">
				   <h5>Do you have a Question?</h5>
				    <p>Feel free to reach out us. Our dedicated team will help you out with all the queries.</p>
				</div>
				<div class="col-sm-5 col-md-4 text-right">
				    <a href="<?php echo e(url('/')); ?>/contact-us" class="commonbtn">Get in Touch <i class="fa fa-envelope"></i></a>
				</div>
			 </div>
		</div>
	</div>
	<?php } ?>
	<div class="main-footer">
	  <div class="container">
	    <div class="row">
			<div class="col-sm-12 col-md-12">
			   <div class="row footerlinks">
			       <div class="col-sm-3 popular-search-footer">
				     <h6>Popular Searches</h6>
				     <?php $__currentLoopData = $property_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 <ul>
					    <li><a href="/<?php echo e($property_lists->link); ?>" rel="noreferrer noopener" target="_blank" ><?php echo e($property_lists->title); ?></a></li>
					 </ul>
					 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  </div>
				  <div class="col-sm-3"><h6>Popular Searches</h6>
				  	<ul>
						<li><a href="listing?s_key=3+Bhk&s_city=Gandhinagar&area=Sargasan&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >3 BHK in Sargasan</a></li>
						<li><a href="listing?s_key=3+Bhk&s_city=Gandhinagar&area=Kudasan&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >3 BHK in Kudasan</a></li>
						<li><a href="listing?s_key=3+Bhk&s_city=Gandhinagar&area=Randesan&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >3 BHK in Randesan</a></li>
						<li><a href="listing?s_key=3+Bhk&s_city=Gandhinagar&area=Vavol&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >3 BHK in Vavol</a></li>
						<li><a href="listing?s_key=3+Bhk&s_city=Gandhinagar&area=Randheja&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >3 BHK in Randheja</a></li>
					</ul>

				  	<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 <!-- <ul>
					     <li><a href="/<?php echo e($product_lists->link); ?>" rel="noreferrer noopener" target="_blank" ><?php echo e($product_lists->title); ?></a></li>
					 </ul>-->
					 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  </div>
				  <div class="col-sm-3"><h6>Popular Searches</h6>
				  	<ul>
						<li><a href="listing?s_key=2+Bhk&s_city=Gandhinagar&area=Sargasan&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >2 BHK in Sargasan</a></li>
						<li><a href="listing?s_key=2+Bhk&s_city=Gandhinagar&area=Randesan&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >2 BHK in Randesan</a></li>
						<li><a href="listing?s_key=2+Bhk&s_city=Gandhinagar&area=Vavol&s_category=1&s_type=" rel="noreferrer noopener" target="_blank" >2 BHK in Vavol</a></li>
						<li><a href="listing?s_key=2+Bhk&s_city=Gandhinagar&area=Randheja&s_category=1&s_type=" rel="noreferrer noopener" target="_blank">2 BHK in Randheja</a></li>
					</ul>

				  	<?php $__currentLoopData = $popular_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popular_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					 <!-- <ul>
					    <li><a href="/<?php echo e($popular_lists->link); ?>" rel="noreferrer noopener" target="_blank" ><?php echo e($popular_lists->title); ?></a></li>
					 </ul>-->
					 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  </div>
				  <div class="col-sm-3"><h6>About</h6>
					 <ul>
						<li><a href="<?php echo e(url('/services')); ?>" target="_blank">Services</a></li>
						<!-- <li><a href="<?php echo e(url('/blog')); ?>" target="_blank">Blogs</a></li> -->
						<li><a href="<?php echo e(url('/privacy-policy')); ?>" target="_blank">Privacy Policy</a></li>
					 </ul></div>
			   </div>
			</div>
	  </div>
	  <div class="row copyright">
	  <div class="col-sm-6">
	  	&copy; <?php echo date('Y')?> Copyright yassir.in. All Rights Reserved
	 </div>
	  <div class="scicon text-right">
          	<a class="fb" href="<?php echo e($setting[0]->facebook_link); ?>" target="_blank"><i class="fa fa-facebook"></i> </a>
		   <a class="tw" href="<?php echo e($setting[0]->twitter_link); ?>" target="_blank"><i class="fa fa-twitter"></i> </a>
			 <a class="insta" href="<?php echo e($setting[0]->instagram_link); ?>" target="_blank"><i class="fa fa-instagram"></i> </a>
			 <a class="you" href="<?php echo e($setting[0]->youtube_link); ?>" target="_blank"><i class="fa fa-youtube"></i> </a>
	 </div>
	</div>
	</div>
      </div>
  </footer>
   <div id="stop" class="scrollTop">
    <span><a href="#"><i class="fa fa-angle-up"></i></a></span>
  </div>
<!-- footer end-->
</div>
  <script>
  	// BY KAREN GRIGORYAN
$(document).ready(function() {
  var scrollTop = $(".scrollTop");
  $(window).scroll(function() {
    var topPos = $(this).scrollTop();
    // if user scrolls down - show scroll to top button
    if (topPos > 100) {
      $(scrollTop).css("opacity", "1");
    } else {
      $(scrollTop).css("opacity", "0");
    }
  }); // scroll END
  $(scrollTop).click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;
  }); // click() scroll top EMD
});
  </script>
    </body>
</html>