<title>Quick Quote</title>
@include('header')
<body class="stickynav">
<div id="main" class="inner-content  contact-page">
<div class="inner-banner-row" style="background-image:url(public/assets/images/inner-banner1.png);">
	<div class="bannertext">
	  <h1>Quick Quote</h1>
	  <span>Get a prompt, pocket-friendly and apt quotation specifically for you.</span>
	</div>
</div>
<div class="quick-quote-page">
	<div class="container padd100">
	  	<div class="formttl text-center">
	     <table>
	        <tr>
	           <td class="text-right">
	              <img src="public/assets/images/quote-icon.png">
	           </td>
	           <td class="text-left">
	              <h2>Request for Quotation</h2>
	              <p>Get a prompt, pocket-friendly and apt quotation specifically for you.</p>
	           </td>
	        </tr>
	     </table>
	      @if (session('contact_msg'))
                        <div class="alert alert-success">
                            {{ session('contact_msg') }}
                        </div>
                    @endif
	  	</div>
	  	<form id="quick_quote" method="post" autocomplete="off">
	     	<div class="formheader">

	        <div class="fromgroup">
	           <input type="text" placeholder="Enter the name" name="fullname" id="fullname" value="">
	        </div>
	       	<div class="fromgroup">
	           <div class="row">
	              <div class="col-sm-6">
	              	<input type="text" placeholder="Enter the email" name="email" value="" id="email" class="email">
	              </div>
	              <div class="col-sm-6">
	              	<input type="text" placeholder="Enter the phone" name="phone" value="" id="phone" class="phone number">
	              </div>
	           </div>
	        </div>
	        <div class="fromgroup">
	           <div class="row">
	              <div class="col-sm-6">
	                 <select id="cate" name="cate">
	                    <option value="">Please select a Category</option>
	                    <?php foreach ($category as $key => $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
	                 </select>
	              </div>
	              <div class="col-sm-6 selectrow">
	                 <select id="sub_cate" name="sub_cate">
	                    <option value="">Please select a Sub-category</option>
	                    <?php foreach ($category_properties as $key => $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
	                 </select>
	              </div>
	           </div>
	        </div>
	        <p>Please let Us know your detailed requirements.</p>
	        <div class="fromgroup" >
	           <textarea rows="5" name="comment"></textarea>
	        </div>
	     </div>
	     <div class="formfooter">
	        <input type="submit" value="Submit your request">
	     </div>
	     <input type="hidden" name="_token" value="{{ csrf_token() }}">
	  </form>
	</div>
</div>
<script>
$(document).ready(function () {
	$('#quick_quote').validate({
	    rules: {
	        fullname: {
	            required: true
	        },
	        email: {
	            required: true,
	            email: true
	        },
	       	cate: {
	            required: true
	        },
	       	sub_cate: {
	            required: true
	        },
			phone: {
				required: true
            }
	    },
	    messages:{
	    	fullname:{
	    		required:"Name is required",
	    	},
	    	email:{
	    		required:"Email address is required",
	    		email:"Email addrees not valid",
	    	},
	    	cate:{
	    		required:"Category is required",
	    	},
	    	sub_cate:{
	    		required:"Sub category is required",
	    	},
	    	phone:{
	    		required:"Phone number is required"
	    	},
	    }
	});
});
$("#cate").on('change',function(){
    $.ajax({
        type:"GET",
        dataType: "json",
        url:"{{url('/getType')}}?category="+this.value,
        success:function(data){
            if (data) {
                $("#sub_cate").empty();
                $("#sub_cate").append('<option value="">Please select a Sub-category</option>');
                $.each( data, function( key, value ) {
                    $("#sub_cate").append('<option value="'+value.id+'">'+value.name+'</option>');
                });
            }
        }
    })
});
$(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });
</script>
@include('footer')