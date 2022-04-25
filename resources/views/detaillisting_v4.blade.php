@include('header')
<?php
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
	.mat-sec-cvr{}
</style>
<style>
	.mat-sec-cvr{padding: 0px 10px;font-size: 11px;margin-bottom: 5px;}
	.gallery1 ul.slides li{padding-bottom: 5px;}
	.gallery1 ul.slides li{min-height: 388px;}
	.gallery1 ul.slides li h2{line-height: 23px;}
	/*.gallery1 ul.slides li:last-child{border:0px;}*/
	/*.gallery1 ul.slides li:last-child a{color:#fff;} */
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
		<img src="../public/assets/images/eye-icon.png" alt="eye">  Viewed - <span id="viewed_list">{{ $result[0]->l_view }}</span>
		</div>
		<a class="review rightbtn" id="add_review">
			<img src="../public/assets/images/review-icon.png" alt="eye">  Add Review
		</a>
        <div class="rightbtn"><i class="fa fa-heart-o"></i></div>
        <a href="javascript:void(0);" class="share rightbtn">
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
			<div class="sidebox gallery1" id="gallery">
			    <h3>Products</h3>

				<div class="flexslider2 carousel gallery-flex">
			            <ul class="slides">



			            	@php $count = 0; @endphp
			            	
							@foreach(array_slice($product_info,0, 6) as  $key => $product_infos)
							
							@if($product_infos->product_name)
								<li>
								@if($product_infos->product_img)		
									<figure>
										<img src="{{url('/')}}/public/images/product/{{$product_infos->id}}/{{$product_infos->product_img}}">
									</figure>
								@else	
									<figure>
									 <img src="{{url('/')}}/public/images/noimage1.png"  class="prodctimg">
									</figure>
								@endif

									<h2>
										<a href="{{url('/')}}/product_detail/{{$product_infos->url_name}}/{{$product_infos->product_name}}">{{ucfirst($product_infos->product_name)}}
										</a>
									</h2>
									<div class="mat-sec-cvr">
										 @if($product_infos->product_price)
							                Approx Price: <p>{{$product_infos->product_price}} /Piece</p>
							            @else
							                Approx Price:  N/A 
							            @endif
									</div>
									<div class="mat-sec-cvr">
										@if($product_infos->product_qty)
									       	Minimum Order Quantity: <p style="display:inline-block;">{{$product_infos->product_qty}}</p> 
							            @else
							            	<P>Minimum Order Quantity: N/A </P>
							            @endif
								    </div>
								</li>
							@else
								No Product Found
							@endif
							@endforeach

							
						
			            	
							<?php 
							/*@foreach($arr as $k => $v)
								<li>
									<figure>
										<a href="">
											<?php
												$cfiles = array();
												$cpath = public_path().'/images/product_category/'.$k;
												if (is_dir($cpath)) {
													$cdh  = opendir($cpath);
													$cignoreArry = array('.','..','...','....');
													while (false !== ($filename = readdir($cdh))) {
														if (!in_array($filename, $cignoreArry)) { ?>
															<img src="../../public/images/product_category/{{ $k }}/{{ $filename }}" alt="product_category">
														<?php }
													}
												}
											?>

										</a>
									</figure>

									<h2>
										<a href="/category_products/{{ $result[0]->url_name }}/{{ $categoryname[$k] }}">{{ $categoryname[$k] }}</a>
									</h2>
									<div class="mat-sec-cvr">
									@foreach($v as $p => $pv)
									   
										<span><a href="{{url('product_detail/'.$result[0]->url_name.'/'.$pv)}}" >{{$pv}}</a></span>
									@endforeach
									</div>
 
									<div class="text-center">
										<a href="/category_products/{{ $result[0]->url_name }}/{{ $categoryname[$k] }}" class="viewmorebtn">View more</a>
									</div>

								</li>
							@endforeach
							*/	
							?>
						</ul>
						<!--<a class="commonbtn" href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
			    </div>
			    	
					<div class="text-right">
					    <span class="PUDfGe z1asCe lYxQe">
					    	<div class="list_biz" style="margin-top:20px;margin-bottom:20px;">              		
						       <a href="{{url('/')}}/allproducts/{{$product_info[0]->url_name}}" class="commonbtn">
						       More Products</i></a>
						       </div>
		                </span>
		            </div>
			</div>
			
			<div class="sidebox mainhead" id="project">
			    <h3>About</h3>
			    <p><?php echo nl2br($result[0]->l_description);?></p>

			@if ($result[0]->web_site)
				<div class="btn1 col-sm-4">
					@if(strpos($result[0]->web_site, "http://"))
                        <a href="{{ $result[0]->web_site }}" target="_blank">visit website</a>
                    @else
                    	<a href="http://{{ $result[0]->web_site }}" target="_blank">visit website</a>
                    @endif
				</div>
			@endif
			@if ($result[0]->l_brochure)
				<div class="btn1 col-sm-3">
				   <a href="{{url('/')}}/public/images/brochure/{{ $result[0]->vl_id }}/{{ $result[0]->l_brochure }}" target="_blank">Brochure</a>
				</div> 
			@endif

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

			<div class="sidebox">

			<div class="amenitiesbox-tag">
			   <h3>Tags</h3>
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
			<div class="sidebox">
				
			<h3>Location</h3>
			<iframe width="100%" height="380" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=<?php echo $result[0]->l_location; ?>&amp;key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY"></iframe>
			</div>
			<div class="sidebox review-box" id="reviews">
			  <h4>Reviews</h4>
			  <?php if ($result) {
			  	foreach ($result as $k => $v) { ?>
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


<script src="{{url('/')}}/public/assets/js/jquery.flexslider.js"></script>
	<!-- main content end-->
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
   </script>
   <script>
    var url = $("#txtUrl").val();
    url = url.split('v=')[1];
    $("#video")[0].src = "https://www.youtube.com/v/" + url;
</script>
@include('footer')