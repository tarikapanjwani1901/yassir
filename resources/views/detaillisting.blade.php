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
  background-color:rgba(0, 0, 0, 0.2);
}
.aminities-cover{width:100%;float:left;padding: 10px 0px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
.aminities-cover img{margin-right:2px;}
.aminities-cover span{}

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
.formdesign1 .fromgroup .fa.fa-smile-o{top: 7px;right: 10px;left: auto;}
</style>
<?php
		

		$price = $result[0]->price;
		$short_title = $result[0]->short_title;
		$carpet_area = json_decode($result[0]->carpet_area,true);
		$price_perft = $result[0]->price_perft;
		$furnishing = $result[0]->furnishing;
        $car_parking = $result[0]->car_parking;
        $type = json_decode($result[0]->type,true);
        $floor = $result[0]->floor;
        $status = $result[0]->status;
        $super_area = json_decode($result[0]->super_area,true);
        $bathroom = json_decode($result[0]->bathroom,true);
        $bedroom = json_decode($result[0]->bedroom,true);
        $masterArray = array();
        
							foreach ($super_area['type'] as $key => $value) {
								foreach ($super_area[$value] as $k1 => $v1) {
									
									$masterArray[$value][$v1]['carpet_area'][] = $carpet_area[$value][$k1];
									$masterArray[$value][$v1]['super_area'][] = $super_area[$value][$k1];
									$masterArray[$value][$v1]['type'][] = $type[$value][$k1];
									$masterArray[$value][$v1]['bathroom'][] = $bathroom[$value][$k1];
									$masterArray[$value][$v1]['bedroom'][] = $bedroom[$value][$k1];
								}
							}
?>
<div id="main" class="inner-content  product-detail">
	   <!-- banner section-->
    <div class="banner-row">
     <div class="flexslider">
     	<div class="flex-viewport">
            <ul class="slides">
                <?php
                	if (!empty($bfiles)) {
                		foreach ($bfiles as $key => $value) { ?>
            			<li class="flex-active-slide" style="">   
            			<img src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/banner/{{ $value }}">
            			 </li>
            			<?php }
                	} else {
                		foreach ($files as $key => $value) { ?>
            			<li  class="flex-active-slide" style="">
            			<img src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/pics/{{ $value }}">
            			</li>
            			<?php }
                	}
            	?>
            </ul>
        </div>
     </div>
    <div class="bannertxt">
     <h1>{{ $result[0]->l_title }} </h1><br>
	 <div class="adrrs"> {{ $result[0]->l_nearby }}
	 </div><br>
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
		<img src="../public/assets/images/eye-icon.png">  Viewed - <span id="viewed_list">{{ $result[0]->l_view }}</span>
		</div>
		<a class="review rightbtn" id="add_review">
			<img src="../public/assets/images/review-icon.png">  Add Review
		</a>
		<div class="like rightbtn" onclick="saveListing('listing_{{$result[0]->vl_id}}')">
            <i class="fa fa-heart"></i>
        </div>
		<a href="javascript:void(0);" class="share rightbtn">
		 Share : </a>
		
        <!-- AddToAny BEGIN -->
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="display: inline-block;line-height: 32px;position: relative;top: 12px;">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_whatsapp"></a>
<a class="a2a_button_skype"></a>
<a class="a2a_button_google_gmail"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
<!-- AddToAny END -->

      </div>
  </div>
    </div>
    <!--banner section end-->
	<!--tab menu-->
	  <div class="tab-menu">
	    <div class="container">
			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
				<div class="row">
					<span style="color:#8c1730;font-size: 30px">{{ $result[0]->l_title }}</span> &nbsp; &nbsp;
          		
					<span>{{ $result[0]->short_title }}</span>
							
				</div>
				<div class="row detail-tab">
					<ul>
					<li><a href="#project">Project Detail</a></li>
					<li><a href="#rera">Rera Number</a></li>
					  <li><a href="#gallery">Gallery</a></li>
					  <li><a href="#owner">Owner Profile</a></li>
					  <li><a href="#reviews">Reviews</a></li>
					</ul>
				</div>
			</div>
			<div class=" col-xs-12 col-sm-2 col-md-2 col-lg-2 text-right">
				<span class="rera-logo">
					<img src="../public/assets/images/rera-approved.png">
				</span>
			</div>

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
			@foreach($shop_condition as $shop)
			@if($shop->l_sub_category==2)
			<div class="sidebox mainhead" id="project">
			    <h3>Project Detail</h3>
			    <!-- ********************** -->
						<div class="detailtab mainhead">
							<ul class="nav-tabs tab">
								@foreach($masterArray as $key => $bhk)
      								<li><button id="bhk_{{$key}}" class="{{$key}}">{{$key}}</button></li>
      							@endforeach
   							</ul>
	   					<div class="detiltab-txt">
	   							<div class="sqrft">
	   								@foreach($masterArray as $k => $v)
	   									<div id="{{$k}}" style="display: none;">
	   										<ul class="detailtab2">
				      							<?php
				      							foreach($shop_condition as $shop){
				      							if($shop->l_sub_category=='1'){
				                               		foreach ($v as $kv => $vv) {
				                               			$ans = str_replace('.', '&#8228;', $kv);
			                               				echo '<li><button id="sqft_'.$k.$ans.'" class="detail_'.$k.$ans.'">'.$ans. ' Sq.Ft</button></li>';
			                               			}
			                               		  }else{
			                               		  	foreach ($v as $kv => $vv) {
				                               			$ans = str_replace('.', '&#8228;', $kv);
			                               				echo '<li><button id="sqft_'.$k.$ans.'" class="detail_'.$k.$ans.'">'.$ans. ' Sq.Yard</button></li>';
			                               			}
			                               		  }
				      							}
				                        		?>
				      						</ul>
	   									</div>
	   								@endforeach
	   							</div>
	   							<div class="detail">
									@foreach($masterArray as $k => $v)
									<?php
									$count = 1;
									?>
	   									@foreach ($v as $kv => $vv)
	   									<?php
	   									$ans1 = str_replace('.', '&#8228;', $kv);
	   									?>
	   									@if($count == 1)
	   										<div id ="detail_{{$k.$ans1}}" class="detail_{{$k}}" style="display: none;">
	   											<?php $count = 0 ?>
	   									@else
	   										<div id ="detail_{{$k.$ans1}}" style="display: none;">
	   									@endif
	   											<div class="row">
	   												<div class="col-sm-12">
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   															<div class="ttl">Build Up Area</div>{{$vv['super_area'][0]}} Sq.Ft
	   															@else
	   															<div class="ttl">Build Up Area</div>{{$vv['super_area'][0]}} Sq.Yard
	   														@endif
	   														@endforeach

	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   															<div class="ttl">Carpet Area</div>{{$vv['carpet_area'][0]}} Sq.Ft
	   															@else
	   															<div class="ttl">Carpet Area</div>{{$vv['carpet_area'][0]}} Sq.Yard
	   														@endif
	   														@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Price per sq. Yard</div>
	   															@foreach($view as $info)
	   															{{$info->price_perft}}
	   															@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Price</div>
	   															@foreach($view as $infos)
	   															{{$infos->price}}
	   															@endforeach
	   														</div>
	   													</div>
	   												</div>
	   											</div>
	   											<hr>
	   											<div class="row">
	   												<div class="col-sm-12">
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Bathrooms</div>
	   															{{$vv['bathroom'][0]}}
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Bedroom</div>
	   															{{$vv['bedroom'][0]}}
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   													<div class="val">
	   															<div class="ttl">Floor</div>
	   															@foreach($view as $info4)
	   															{{$info4->floor}}
	   															@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl"> Status</div>
	   															@foreach($view as $info3)
	   															{{$info3->status}}
	   															@endforeach
	   														</div>
	   													</div>
	   												</div>
	   											</div>
	   											<hr>
	   											<div class="row">
	   												<div class="col-sm-12">
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Transaction type</div>
	   															{{$vv['type'][0]}}
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
																<div class="ttl">Car parking</div>
																@foreach($view as $info6)
																@if($info6->car_parking == 1)
                        											Yes
                        										@else
                        											No
                        										@endif
                        										@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Furnishing</div>
	   															@foreach($view as $info7)
	   															{{$info7->furnishing}}
	   															@endforeach
	   														</div>
	   													</div>
	   													
	   													<div class="col-sm-12 col-md-3">
	   														<div class="ttl">Listed By</div>
					 										<div class="val">Owner</div>
	   													</div>
	   												</div>
	   											</div>
	   										</div>
	   									@endforeach
	   								@endforeach
	   							</div>
							</div>
						</div>
					</div>

			<!-- For Commercial Only  -->
			@else($shop->l_sub_category==1)
			<div class="sidebox mainhead" id="project">
			    <h3>Project Detail</h3>
			    <!-- ********************** -->
						<div class="detailtab mainhead">
							<ul class="nav-tabs tab">
								@foreach($masterArray as $key => $bhk)
      								<li><button id="bhk_{{$key}}" class="{{$key}}">Offices & Shop</button></li>
      							@endforeach
   							</ul>
	   					<div class="detiltab-txt">
	   							<div class="sqrft">
	   								@foreach($masterArray as $k => $v)
	   									<div id="{{$k}}" style="display: none;">
	   										<ul class="detailtab2">
				      							<?php
				      							foreach($shop_condition as $shop){
				      							if($shop->l_sub_category=='1'){
				                               		foreach ($v as $kv => $vv) {
				                               			$ans = str_replace('.', '&#8228;', $kv);
			                               				echo '<li><button id="sqft_'.$k.$ans.'" class="detail_'.$k.$ans.'">'.$ans. ' Sq.Ft</button></li>';
			                               			}
			                               		  }else{
			                               		  	foreach ($v as $kv => $vv) {
				                               			$ans = str_replace('.', '&#8228;', $kv);
			                               				echo '<li><button id="sqft_'.$k.$ans.'" class="detail_'.$k.$ans.'">'.$ans. ' Sq.Yard</button></li>';
			                               			}
			                               		  }
				      							}
				                        		?>
				      						</ul>
	   									</div>
	   								@endforeach
	   							</div>
	   							<div class="detail">
									@foreach($masterArray as $k => $v)
									<?php
									$count = 1;
									?>
	   									@foreach ($v as $kv => $vv)
	   									<?php
	   									$ans1 = str_replace('.', '&#8228;', $kv);
	   									?>
	   									@if($count == 1)
	   										<div id ="detail_{{$k.$ans1}}" class="detail_{{$k}}" style="display: none;">
	   											<?php $count = 0 ?>
	   									@else
	   										<div id ="detail_{{$k.$ans1}}" style="display: none;">
	   									@endif
	   											<div class="row">
	   												<div class="col-sm-12">
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   															<div class="ttl">Build Up Area</div>{{$vv['super_area'][0]}} Sq.Ft
	   															@else
	   															<div class="ttl">Build Up Area</div>{{$vv['super_area'][0]}} Sq.Yard
	   														@endif
	   														@endforeach

	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   															<div class="ttl">Carpet Area</div>{{$vv['carpet_area'][0]}} Sq.Ft
	   															@else
	   															<div class="ttl">Carpet Area</div>{{$vv['carpet_area'][0]}} Sq.Yard
	   														@endif
	   														@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   															<div class="ttl">Price per sq.Ft</div>
	   															@foreach($view as $info)
	   															{{$info->price_perft}}
	   															@endforeach
	   														</div>
	   														@else
	   														<div class="val">
	   															<div class="ttl">Price per sq. Yard</div>
	   															@foreach($view as $info)
	   															{{$info->price_perft}}
	   															@endforeach
	   														</div>
	   														@endif
	   														@endforeach
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Price</div>
	   															@foreach($view as $infos)
	   															{{$infos->price}}
	   															@endforeach
	   														</div>
	   													</div>
	   												</div>
	   											</div>
	   											<hr>
	   											<div class="row">
	   												<div class="col-sm-12">
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Bathrooms</div>
	   															{{$vv['bathroom'][0]}}
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   													<div class="val">
	   															<div class="ttl">Floor</div>
	   															@foreach($view as $info4)
	   															{{$info4->floor}}
	   															@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl"> Status</div>
	   															@foreach($view as $info3)
	   															{{$info3->status}}
	   															@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
	   															<div class="ttl">Transaction type</div>
	   															{{$vv['type'][0]}}
	   														</div>
	   													</div>
	   												</div>
	   											</div>
	   											<hr>
	   											<div class="row">
	   												<div class="col-sm-12">
	   													<div class="col-sm-12 col-md-3">
	   														<div class="val">
																<div class="ttl">Car parking</div>
																@foreach($view as $info6)
																@if($info6->car_parking == 1)
                        											Yes
                        										@else
                        											No
                        										@endif
                        										@endforeach
	   														</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="ttl">Listed By</div>
					 										<div class="val">Owner</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="ttl">Possession date</div>
					 										<div class="val">
					 											@foreach($view as $view_pdate)
					 											@if($view_pdate->possession_date == "NULL")
					 											N/A
					 											@else
	   															{{$view_pdate->possession_date}}
	   															@endif
	   															@endforeach</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														<div class="ttl">Tower</div>
					 										<div class="val">
					 											@foreach($view as $view_tower)
	   															@if($view_tower->tower == "NULL")
	   														    N/A		
	   															
	   															@else
	   															{{$view_tower->tower}}
	   															@endif	
	   															@endforeach</div>
	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   														<div class="val bed_hide">
	   															<div class="ttl">Bedroom</div>
	   															@foreach($view as $info1)
	   															{{$info1->bedroom}}
	   															@endforeach
	   														</div>
	   														@else
	   														<div class="val">
	   															<div class="ttl">Bedroom</div>
	   															@foreach($view as $info1)
	   															{{$info1->bedroom}}
	   															@endforeach
	   														</div>
	   														@endif
	   														@endforeach

	   													</div>
	   													<div class="col-sm-12 col-md-3">
	   														@foreach($shop_condition as $shop)
	   														@if($shop->l_sub_category==1)
	   														<div class="val fur_hide">
	   															<div class="ttl">Furnishing</div>
	   															@foreach($view as $info7)
	   															{{$info7->furnishing}}
	   															@endforeach
	   														</div>
	   														@else
	   														<div class="val">
	   															<div class="ttl">Furnishing</div>
	   															@foreach($view as $info7)
	   															{{$info7->furnishing}}
	   															@endforeach
	   														</div>
	   														@endif
	   														@endforeach
	   													</div>
	   													
	   												</div>
	   											</div>
	   										</div>
	   									@endforeach
	   								@endforeach
	   							</div>
							</div>
						</div>
					</div>
					@endif
					@endforeach
					<!-- ********************** -->
			<div class="sidebox mainhead" id="rera">
			    <h3>Rera Number</h3><div class="reranum">
			    	<a href="https://gujrera.gujarat.gov.in/" target="_blank"  class="rera_text"  data-toggle="tooltip" data-placement="top" title="View Property Details">{{ $result[0]->rera_number }}</a>
			    </div>
			</div>
			<div class="sidebox">
			<div class="aboutbox">
			   	<h3>About</h3>
			   	<p><?php echo nl2br($result[0]->l_description);?></p>
			<div class="row">
			@if ($result[0]->web_site)
				<div class="btn1 col-sm-3">
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
			</div>
			<div class="amenitiesbox-tag">
			   <h3>Amenities</h3>
			   <div class="row">
	   			<div class="col-md-12 col-sm-12 col-xs-12">
	   			<div class="aminities-cover" id="get_amenities">
	   				<?php $amenities = explode(',', $result[0]->amenities);
			   		foreach ($amenities as $key => $value) {
			   			echo '<div class="col-sm-4"> <img class="icon-img" src=" '.$value.'" width="25px" ><span class="icon-name">'.$value.'</span></div>';
			   		} ?>
	   			 </div>
	   			</div>
			   </div>
			</div>
			<div class="amenitiesbox-tag">
			   <h3>Tags</h3>
			   <div class="row">
			   	<?php if ($result) {
			   		$area = explode(',', $result[0]->l_key_area);
			   		foreach ($area as $key => $value) { ?>
			   		<div class="col-sm-4">
			   			<img src="{{url('/')}}/public/images/flat/home.svg" width="25px">&nbsp;<?php echo $value; ?></div>
			   		<?php } } ?>
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
								    <img src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/pics/{{ $value }}" style="width:100%" onclick="openModal();currentSlide('{{$key+1}}')" class="hover-shadow cursor">
								</li>
								<?php }
			            	?>
			            	</ul>
			            	
								<div id="myModal" class="modal">
								  <span class="close cursor" onclick="closeModal()">&times;</span>
								  <div class="modal-content">
								  	@foreach($files as $k => $v)
								    <div class="mySlides">
								      <img src="{{url('/')}}/public/images/{{ $result[0]->vl_id }}/pics/{{ $v }}" style="width:100%">
								    </div>
								    @endforeach
								    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
								    <a class="next" onclick="plusSlides(1)">&#10095;</a>

								    <div class="caption-container">
								      <p id="caption"></p>
								    </div>
								  </div>
								</div>
					
			  </div>
			</div>

			@if($result[0]->l_extravideo)
				@if(isset($directory))
			<div class="sidebox" id="gallery">
			    <h3>Video</h3>
				<div class="flexslider2 carousel gallery-flex">
					<div>
					<?php 
					
                    $directory = "public/images/extravideo/".$result[0]->vl_id."";
                    $files = array_values(array_diff(scandir($directory), array('..', '.')));
               
                	foreach ($files as $key => $value){ ?>
	                    <video controls muted loop style=" width: 100%; height: 300px; background-color: black;"  autoplay>
	                        <source src="{{url('/')}}/public/images/extravideo/{{$result[0]->vl_id}}/{{$value}}" type="video/mp4" /> 
	                    </video>
	              <?php   } ?>
					</div>
			  </div>
			</div>
			@endif
			@endif
			<div class="sidebox" >
				
			<h3>Location</h3>
			<iframe width="100%" height="380" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=<?php echo $result[0]->l_location; ?>&amp;key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY"></iframe>
			</div>
				@if ( $result[0]->l_video_link != '' || $result[0]->l_video != '')
				<div class="sidebox">
				<h3>Promo video</h3>
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
			        <!-- <textarea placeholder="Comment" name="rcomment" id="rcomment" required></textarea> -->
			        <input type="text"  class="form-control textarea-control imo"  data-emojiable="true" name="rcomment" id="rcomment" required>
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
			  <h3>Reviews</h3>
			  <?php if ($reviewResult) {
			  	foreach ($reviewResult as $k => $v) { ?>
			  <div class="reviews-row">
			  	<figure>
				   <img src="../public/assets/images/user2.png">
			    </figure>
					<h4>{{ $v->reviewer_name }}</h4>
					  <div class="rating text-right">
					  	@for ($i = 1; $i <= 5; $i++)
					  		@if ($i <= $v->l_review)
					  			<i class="fa fa-star"></i>
					  		@else
								<i class="fa fa-star-o"></i>
							@endif
						@endfor
					</div>
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
	</div>
	</div>
	<span id="s" hidden></span>
	<span id="detail" hidden></span>
<!-- main content end-->
<script src="{{url('/')}}/public/assets/js/jquery.flexslider.js"></script>
<script type="text/javascript">
	//Update view count
	$( document ).ready(function() {

		$('.bed_hide').hide();
		$('.fur_hide').hide();

		//validate review
		$('#review_popup').validate({
            rules: {
            },
            success: function (element) {
                element.text('OK!').addClass('valid');
            }
        });
		//details show hide
        $("#detail").html($('button[id^="sqft_"]').attr('class'));
		$("#s").html($('button[id^="bhk_"]').attr('class'));
		var s = $("#s").html();
		var d = $("#detail").html();
		$("#"+s).css('display','block');
		$("#"+d).css("display","block");
		$('button[id^="bhk_"]').on('click', function() {
    		var id = $(this).attr('class');
    		var hidden = $("#s").html();
    		var detail = $("#detail").html();
    		$("#"+hidden).css('display','none');
    		$('#'+detail).css('display','none');
    		$('.detail_'+hidden).css('display','none');
			$("#"+id).css('display','block');
			$('.detail_'+id).css('display','block');
			$("#s").html(id);
		});
		$('button[id^="sqft_"]').on('click',function(){
			var det = $("#s").html();
			$('.detail_'+det).css('display','none');
			var id = $(this).attr('class');
			var detail = $("#detail").html();
			$('#'+detail).css('display','none');
			$('#'+id).css('display','block');
			$("#detail").html(id);
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

    $(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
    //Function to save listing in saved list
    function saveListing(listing_id) {
        var expDate = new Date();
        expDate.setTime(expDate.getTime() + (15 * 60 * 1000)); // add 15 minutes
        //Get the current count
        if (typeof $.cookie("total_count") !== 'undefined') {
            var updated = Number($.cookie("total_count")) + 1;     // Number()
        } else {
            var updated = '1';
        }
        if (typeof $.cookie("listing_value") !== 'undefined') {
            var listing_ids = $.cookie("listing_value")+','+listing_id;
        } else {
            var listing_ids = listing_id;
        }
        //Erase value
        $.removeCookie("total_count", { path: '/' });
        $.removeCookie("listing_value", { path: '/' });
        //Set new value
        $.cookie('total_count', updated, { path: '/', expires: expDate });
        $.cookie("listing_value",listing_ids, { path: '/', expires: expDate });
        //Update the header count value
        $(".header-like .count").html('');
        $(".header-like .count").html(updated);
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
<script>
    var url = $("#txtUrl").val();
    url = url.split('v=')[1];
    $("#video")[0].src = "https://www.youtube.com/v/" + url;
</script>
<script src="{{url('/')}}/public/js/jquery.copy-to-clipboard.js"></script>
<script>
 $('.rera_text').click(function(){
        $(this).CopyToClipboard();
    });
</script>
<script>
	$(".icon-img").each(function( index ) {
 	if ( this.src.split('~')[1] != undefined) {
		this.src ="{{url('/')}}/public/images/amenities/"+ this.src.split('~')[1] +".png";
 	}
});

 $(".icon-name").each(function( index ) {
 		
 	this.innerText=this.innerText.split("~")[0];
 
});
</script>
<script>
      $(function() {
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '../lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
      });
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-49610253-3', 'auto');
      ga('send', 'pageview');
</script>
@include('footer')