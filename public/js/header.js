$( document ).ready(function() {
	  	$(".loader").fadeOut("slow");
});		    
		    $(".onclick").click(function(){
		      var myBookId = $(this).data('id');
		      $(".modal-dialog #bookId").val( myBookId );
		    });
		    jQuery("#property_ok_1").on('click',function(){
		        var listingPath = jQuery("#bookId").val();
		         var dd = $('#otp_verifys').val();
		        var split = listingPath.split('/');
		     	var phoneNumber = jQuery(".otp_num1").val();
		    	var user_name = jQuery(".otpuser").val();
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
		        var letters = /^[a-zA-Z_ ]*$/;
				if(user_name.match(letters))
				{
				} else {
					$(".error_msg").html('');
	              	$(".error_msg").html('Please enter correct name.');
	              	var validate = false;
				}		        
	        	if (validate) {
			        $.ajax({
			           type:'get',
			           url:'{{url('/')}}/otpAdd/add/'+user_name+'/'+phoneNumber+'/'+dd,
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
		    jQuery("#property_ok_2").on('click',function(){	

		    	$('html, body').animate({
								        scrollTop: $(".map_location").offset().top
								    }, 2000);
		    	 var dd = $('#otp_verifys').val();
		    	var listingPath = jQuery("#bookId").val();
		        var split = listingPath.split('/');
		        if (typeof (split[2]) != "undefined" && split[2] !== null ) {
		        	var sval = split[2];
		        } else {
		        	var sval = split[1];
		        }
		    	var otp_verify = jQuery(".verify").val();
		    	var phoneNumber = jQuery(".otp_num1").val();
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
			           url:'{{url('/')}}/otpVerify/'+otp_verify+'/'+phoneNumber+'/'+dd,
			           success:function(data){
			                if (data == 'success') {
			                	
			                	$('#location_view').css('display','');		
			                	$('#demo_view').css('display','none');   
			                	$('#iam_interest').hide();
			                	$('.modal-backdrop').css("display", "none");
			                	$('#properties_otp').modal('hide');
			                	$('.firstBlur').removeClass('modalBlur');
			                	
			                	var expDate = new Date();
						        expDate.setTime(expDate.getTime() + (15 * 60 * 1000));
						        if (typeof $.cookie("otp_lists") !== 'undefined') {
						            var otp_lists = $.cookie("otp_lists")+','+sval;
						        } else {
						            var otp_lists = sval;
						        }						        
						        $.removeCookie("otp_lists", { path: '/' });
						        $.cookie("otp_lists",otp_lists, { path: '/', expires: expDate });  
			                } else {
			                	$(".error_msg").html('');
	              				$(".error_msg").html(data);
			                }
			           }
			        });
		    	}
		    });
		    	
	// window.oncontextmenu = function () {
 //        return false;
 //      }
 //      $(document).keydown(function (event) {
 //        if (event.keyCode == 123) {
 //          return false;
 //        }
 //        else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) {
 //          return false;
 //        }
 //      });	