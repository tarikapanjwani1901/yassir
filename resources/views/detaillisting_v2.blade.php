@include('header')
<?php
	$path = public_path().'/images/'.$result[0]->vl_id.'/pics/';
	$dh  = opendir($path);
	$ignoreArry = array('.','..','...','....');
	while (false !== ($filename = readdir($dh))) {
		if (!in_array($filename, $ignoreArry)) {
			$files[] = $filename;
		}
	}

	$bpath = public_path().'/images/'.$result[0]->vl_id.'/banner/';
	if (is_dir($bpath)) {
		$bdh  = opendir($bpath);
		$bignoreArry = array('.','..','...','....');
		while (false !== ($filename = readdir($bdh))) {
			if (!in_array($filename, $bignoreArry)) {
				$bfiles[] = $filename;
			}
		}
	}

?>
<style>


* {
  box-sizing: border-box;
}

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
<div id="main" class="inner-content  product-detail">
	   <!-- banner section-->
    <div class="banner-row">
     <div class="flexslider">
            <ul class="slides">
                <?php
                	if (!empty($bfiles)) {
                		foreach ($bfiles as $key => $value) { ?>
            			<li class="flex-active-slide" style="">
            			<img src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/banner/{{ $value }}" alt="banner">
            			</li>
            			<?php }
                	} else {
                		foreach ($files as $key => $value) { ?>
            			<li class="flex-active-slide" style="">
            			<img src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/pics/{{ $value }}" alt="pics">
            			</li>
            			<?php }
                	}
            	?>
            </ul>
        </div>
  <div class="bannertxt">

     <h1>{{ $result[0]->l_title }} </h1>
	 <div class="adrrs"> {{ $result[0]->l_nearby }}
	 </div>
	 	<div class="rating">
	  	@for ($i = 1; $i <= 5; $i++)
	  		@if ($i <= $avgRating)
	  			<i class="fa fa-star"></i>
	  		@else
				<i class="fa fa-star-o"></i>
			@endif
		@endfor
		<?php echo $reviewResult->total() ?> Reviews
		</div>
	<div class="bannerrightbtn">
		<div class="review rightbtn">
		<img src="../public/assets/images/eye-icon.png" alt="eye-icon">  Viewed - <span id="viewed_list">{{ $result[0]->l_view }}</span>
		</div>
		<a class="review rightbtn" id="add_review">
			<img src="../public/assets/images/review-icon.png" alt="review">  Add Review
		</a>
		
        <div class="rightbtn"><i class="fa fa-heart-o"></i></div>
        <a href="javascript:void(0)" class="share rightbtn">
		 Share : </a>
        <div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="display: inline-block;line-height: 32px;position: relative;top: 12px;">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_whatsapp"></a>
<a class="a2a_button_skype"></a>
<a class="a2a_button_google_gmail"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
      </div>


  </div>
    </div>
    <!--banner section end-->

	<!--tab menu-->
	  <div class="tab-menu">
	    <div class="container">
	    	<div class="row">
	    		<span style="color:#8c1730;font-size: 30px;padding: 13px">{{ $result[0]->l_title }}</span> &nbsp; &nbsp;
	    	</div>
			<ul>
			<li><a href="#project">About</a></li>
			  <li><a href="#gallery">Gallery</a></li>
			  <li><a href="#owner">Owner Profile</a></li>
			  <li><a href="#reviews">Reviews</a></li>
			</ul>
		</div>
	  </div>
	<!-- tab menu-->
	<div class="container">
	<div class="row">
	   <div class="col-sm-7 col-md-8">
	      	<!-- breadcumb-->
			<div class="breadcumb">
				<ul>
					<li><a href="/">Home</a></li>
					<li><a href="{{ url('/') }}/listing?s_category={{ $result[0]->l_category }}">Listing</a></li>
					<li>Listing Detail</li>
				</ul>
			</div>
			<!-- end-->

			<div class="sidebox mainhead" id="project">
			    <h3>About</h3>
			    <p><?php echo nl2br($result[0]->l_description);?></p>

			@if ($result[0]->web_site)
				<div class="btn1 col-sm-3">
					@if(strpos($result[0]->web_site, "http://"))
                        <a href="{{ $result[0]->web_site }}" target="_blank">visit website</a>
                    @else
                    	<a href="http://{{ $result[0]->web_site }}" target="_blank">visit website</a>
                    @endif
				</div>
			@endif
			

			

				    
                       
                 


			</div>


			<div class="sidebox">

			<div class="amenitiesbox-tag">
			   <h4>Tags</h4>
			   <div class="row">
			   	<?php if ($result) {
			   		$area = explode(',', $result[0]->l_key_area);
			   		foreach ($area as $key => $value) {
			   			echo '<div class="col-sm-4"><i class="fa fa-tag"></i> '.$value.'</div>';
			   		}
			   	} ?>
			   </div>

			</div>
			</div>
			<div class="sidebox" id="gallery">
			    <h3>Gallery</h3>

				<div class="flexslider2 carousel gallery-flex">
			            <ul class="slides">
			            	<?php
			            		foreach ($files as $key => $value) { ?>

									<li>

								    <img src="../../public/images/{{ $result[0]->vl_id }}/pics/{{ $value }}" style="width:100%" onclick="openModal();currentSlide('{{$key+1}}')" class="hover-shadow cursor" alt="pics">

								</li>
								<?php }
			            	?>
			            	</ul>

								<div id="myModal" class="modal">
								  <span class="close cursor" onclick="closeModal()">&times;</span>
								  <div class="modal-content">
								  	@foreach($files as $k => $v)
								    <div class="mySlides">
								      <img src="../../public/images/{{ $result[0]->vl_id }}/pics/{{ $v }}" alt="pics" style="width:100%">
								    </div>
								    @endforeach
								    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
								    <a class="next" onclick="plusSlides(1)">&#10095;</a>

								    <div class="caption-container">
								      <p id="caption"></p>
								    </div>
								  </div>
								</div>


						<!--<a class="commonbtn" href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
			  </div>
			</div>
			@if($result[0]->l_extravideo)
			<div class="sidebox" id="gallery">
			    <h3>Video</h3>
				<div class="flexslider2 carousel gallery-flex">
					<div>
						
					  @php
                    $directory = "public/images/extravideo";
                    $files = array_values(array_diff(scandir($directory), array('..', '.')));
                	@endphp

                		 @foreach ($files as $key => $value)
	                    <video controls muted loop style=" width: 100%; height: 300px; background-color: black;"  autoplay>
	                        <source src="{{url('/')}}/public/images/extravideo/{{$value}}/{{$result[0]->l_extravideo}}" type="video/mp4" /> 
	                    </video>


	                @endforeach
	                
					</div>
			  </div>
			</div>
			@endif
			<div class="sidebox" >
			<h3>Location</h3>
			<!-- <iframe width="100%" height="380" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=<?php  //echo $result[0]->l_location; ?>&amp;key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY"></iframe> -->

			<iframe width="100%" height="380" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q={{ $result[0]->l_location }}&amp;key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY"></iframe>
			</div>
				@if ( $result[0]->l_video_link != '' || $result[0]->l_video != '')
				<div class="sidebox">
				<h4>Promo video</h4>
				<div class="videobox">		
				<?php
					if (isset($result[0]->l_video_link) && $result[0]->l_video_link != '' && strpos($result[0]->l_video_link, '.com') !== false) { ?>	  <input type="hidden" id="txtUrl" name="" value="{{ $result[0]->l_video_link }}">
							<embed id="video" src="" wmode="transparent" type="application/x-shockwave-flash" width="700" height="315" a></embed>
				<?php } else if (isset($result[0]->l_video) && $result[0]->l_video != '') {?>
							<video controls="controls" class="video-stream" src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/video/{{ $result[0]->l_video }}"></video>
				<?php } ?>
				</div>
				</div>
			@endif
			<div class="sidebox review-box" id="addreview" style="display: none;">
				<h4>Add review</h4>
				<div class="center hideform">
			    <button id="close" style="float: right;">X</button>
			    <form method="post" id="review_popup" class="formdesign1">
                   <div class="formheader">
			        <div class="fromgroup">
                        <i class="fa fa-user"></i>
			        <input type="text" name="rname" value="" id="rname" placeholder="Name" required>
                       </div>
                       <div class="fromgroup">
                             <i class="fa fa-star"></i>
			        <select name="rrating" id="rrating" required>
                        <option value="Rating" selected disabled>Rating</option>
			        	<option value="5">5</option>
			        	<option value="4">4</option>
			        	<option value="3">3</option>
			        	<option value="2">2</option>
			        	<option value="1">1</option>
			        </select>
                       </div>
                       <div class="fromgroup">

			        <textarea placeholder="Comment" name="rcomment" id="rcomment" required></textarea>
                       </div>
                    </div>
                    <div class="formfooter">
			        <input type="hidden" name="_token" value="{{ csrf_token() }}">
			        <input type="hidden" name="hvl_id" id="hvl_id" value="{{ $result[0]->vl_id }}">
			        <input type="submit" value="Submit" name="submit">
                    </div>
			    </form>
				</div>
			</div>
			<div class="sidebox review-box" id="reviews">
			  <h4>Reviews</h4>
			  <?php if ($reviewResult) {
			  	foreach ($reviewResult as $k => $v) { ?>
			  <div class="reviews-row">
			    <figure>
				   <img src="../public/assets/images/user2.png" alt="user2">
			    </figure>
					<h4>{{ $v->reviewer_name }}</h4>
					@if ($v->l_review)
					  <div class="rating text-right">
					  	@for ($i = 1; $i <= 5; $i++)
					  		@if ($i <= $v->l_review)
					  			<i class="fa fa-star"></i>
					  		@else
								<i class="fa fa-star-o"></i>
							@endif
						@endfor
					</div>
					@endif
				<p>{{ $v->l_comment }}</p>
			    <div class="date">

				  <i class="fa fa-calendar-o"></i> <?php echo date('Y-m-d',strtotime($v->rcreated_at)); ?>

				</div>
			  </div>
			<?php } ?>
				{{ $reviewResult->links() }}
			<?php } else { ?>
				<h2> No Reviews Yet! </h2>
			<?php } ?>
			</div>
        </div>

        <!-- Dynamic Side Bar -->
        @include('detaillisting_side')

		</div>
	</div>

	</div>
	<script>
    var url = $("#txtUrl").val();
    url = url.split('v=')[1];
    $("#video")[0].src = "https://www.youtube.com/v/" + url;
</script>
	<script src="{{url('/')}}/public/assets/js/jquery.flexslider.js"></script>
	<script>


	//Update view count
	$( document ).ready(function() {
		//validate review

		$('#review_popup').validate({
            rules: {
            },
            success: function (element) {
                element.text('OK!').addClass('valid');
            }
        });
		var expDate = new Date();
   		expDate.setTime(expDate.getTime() + (15 * 60 * 1000)); // add 15 minutes

   		var vl_id = $("#hvl_id").val();

   		//Get the current listing ids
   		if (typeof $.cookie("viewed_listing") !== 'undefined') {
   			var exp = $.cookie("viewed_listing").split(',');
   			var check = '0';

   			$.each( exp, function( key, value ) {
			  if(vl_id == value){
			  	check = '1';
			  }
			});

   			if (check !== '1') {
   				var updated = $.cookie("viewed_listing")+','+vl_id;     // Number()

   				//Update the count
   				visiting_count(vl_id);

   			} else {
   				var updated = $.cookie("viewed_listing");
   			}

        } else {
            var updated = vl_id;
            //Update the count

            visiting_count(vl_id);
        }

        //Erase value
        $.removeCookie("viewed_listing", { path: '/' });

        //Set new value
        $.cookie("viewed_listing",updated, { path: '/', expires: expDate });

    });


    //Ajax to update the count
    function visiting_count(listing_id='') {

    	$.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/updateCount')}}?listing_id="+listing_id,
            success:function(data){
            	$("#viewed_list").html('');
            	$("#viewed_list").html(data);
            }
        });
    }


function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
	$("body").removeClass( "modal-open" );
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
	$("body").addClass( "modal-open" );
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
}
</script>
	<!-- main content end-->

@include('footer')