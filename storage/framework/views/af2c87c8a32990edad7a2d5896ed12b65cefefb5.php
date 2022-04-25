
<?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body class="stickynav home">
	<style>
		.socialicon.ct .fb i{    background: #39579a;
    color: #FFF;
    border: 1px solid #39579a;
    height: 40PX;
    width: 40PX;
    text-align: center;
    line-height: 40PX;
    border-radius: 33PX;}
		.socialicon.ct .tw i{    background: #059ff5;
    color: #FFF;
    border: 1px solid #059ff5;
    height: 40PX;
    width: 40PX;
    text-align: center;
    line-height: 40PX;
    border-radius: 33PX;}
		.socialicon.ct .insta i{    background: #e4405f;
    color: #FFF;
    border: 1px solid #e4405f;
    height: 40PX;
    width: 40PX;
    text-align: center;
    line-height: 40PX;
    border-radius: 33PX;} 
    .socialicon.ct .you i{    background: #cd201f;
    color: #FFF;
    border: 1px solid #cd201f;
    height: 40PX;
    width: 40PX;
    text-align: center;
    line-height: 40PX;
    border-radius: 33PX;}
	</style>
<div id="main" class="inner-content  contact-page">
   <div class="inner-banner-row" style="background-image:url(public/assets/images/inner-banner1.png);">
      <div class="bannertext">
         <h1>Contact Us</h1>
         <span>Get a prompt, pocket-friendly and apt quotation specifically for you.</span>
      </div>
   </div>
   <div class="container padd100">
      <div class="row">
         <div class="col-sm-6">
            <div class="contact-left">
               <img src="public/assets/images/contactpic.png">
               <p><?php echo e($contact[0]->description); ?></p>
               <table>
                  <tbody>
                     <tr>
                        <td><i class="fa fa-map-marker"></i> Address</td>
                        <td><?php echo e($contact[0]->address); ?></td>
                     </tr>
                     <tr>
                        <td><i class="fa fa-phone"></i> Phone</td>
                        <!--<td><a href="tel:7575081000"><?php echo e($contact[0]->phone_no); ?></a></td>-->
                        <td>
                           <a href="tel:7575081000">7575081000</a>,
                           <a href="tel:7575020262">7575020262</a>
                        </td>
                     </tr>
                     <tr>
                        <td><i class="fa fa-envelope"></i> Email</td>
                        <td><a href="mailto:<?php echo e($contact[0]->email_id); ?>"><?php echo e($contact[0]->email_id); ?></a></td>
                     </tr>
                  </tbody>
               </table>
               <tr>
                  <div class="socialicon ct">
                    <h6>Follow Us on</h6>
                   
			 		<a class="fb" href="<?php echo e($setting[0]->facebook_link); ?>" target="_blank"><i class="fa fa-facebook"></i> </a>
	   				<a class="tw" href="<?php echo e($setting[0]->twitter_link); ?>" target="_blank"><i class="fa fa-twitter"></i> </a>
			        <a class="insta" href="<?php echo e($setting[0]->instagram_link); ?>" target="_blank"><i class="fa fa-instagram"></i> </a>
			        <a class="you" href="<?php echo e($setting[0]->youtube_link); ?>" target="_blank"><i class="fa fa-youtube"></i> </a>
                  </div>
            </div>
         </div>
        <div class="col-sm-6 contact-right">
	        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3665.806245178714!2d72.63909!3d23.2501367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c2bce3721c5f5%3A0xb653ff4a371f70d8!2sYas+Sir!5e0!3m2!1sen!2sin!4v1542172512161" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			<div class="book-form sidebox">
       <?php if(session('contact_msgs')): ?>
                        <div class="alert alert-success" id="success-alert">
                            <?php echo e(session('contact_msgs')); ?>

                        </div>
                    <?php endif; ?>
			 <h6>Get In Touch</h6>
			 <form class="formdesign1" id="cform" method="post" autocomplete="off">
			     <div class="formheader">
			         <div class="fromgroup">
			         	<input placeholder="Name" type="text" name="fname" id="fname" value="">
			         </div>
			         <div class="fromgroup">
			         	<input placeholder="Phone" type="text" class="number" id="phone" name="phone" value="">
			         </div>
			         <div class="fromgroup">
			         	<input placeholder="Email" type="email" id="email" name="email" value="">
			         </div>
			         <div class="fromgroup">
			         	<textarea placeholder="Comment" name="comment"></textarea>
			         </div>
			     </div>
			     <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			     <div class="formfooter">
			     <input type="submit" value="Send Us" id="test">
			     </div>
			 </form>
			</div>
        </div>
      </div>
   </div>
</div>
<script>
$(document).ready(function () {
	$('#cform').validate({
	    rules: {
	        fname: {
	            required: true
	        },
	        email: {
	            required: true,
	            email: true
	        },
    			phone: {
    				required: true
                }
	    },
      messages:{
        fname:{
          required:"Name is required",
        },
        email:{
          required:"Email address is required",
          email:"Email address is not valid",
        },
        phone:
        {
          required:"Phone number is required"
        },
      }
	});
});

$("#success-alert").fadeTo(2000, 2000).slideUp(2000, function(){
    $("#success-alert").slideUp(2000);
});

</script>

<script>
	
	$(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });

</script>
<?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>