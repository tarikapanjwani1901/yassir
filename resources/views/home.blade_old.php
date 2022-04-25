@include('header')
<!-- <link href="https://fonts.googleapis.com/css?family=Work+Sans:700" rel="stylesheet"> -->
      <link rel="stylesheet" href="{{ asset('public/css/home_blade.css') }}">
<!-- banner section-->
    <div class="banner-row">
        <div class="flexslider">
            <ul class="slides">
                 <?php
                    $directory = "public/images/home_galery";
                    if (is_dir($directory)) {
						$files = array_values(array_diff(scandir($directory), array('..', '.')));
						$img = '';
						foreach ($files as $key => $value) { ?>
						    <li style="background-image:url(public/images/home_galery/{{ $value }})"></li>
						  <?php }
					}
                ?>
            </ul>
        </div>
        <div class="bannertext">
            <h1>We will help you to find all</h1>
            <span class="hd1">Want to buy or refurbish your own property? Or looking for potential buyers for your house or office? Your search ends here<br></span>
            <div class="searchbox  s-box">


                <form action="listing" method="get" id="home_search" autocomplete="off">
                    
                    <input type="text" name="s_key" id="s_key" class="gcse-search" onkeyup="getPredefineSelection()" placeholder="Requirement">
                    <select name="s_city" id="s_city"  class="select2">
                        <option value="">Select city</option>
                        @if (!empty($city_info))
                          @foreach($city_info as $d)
                            <option value="{{$d->City_Name}}">{{$d->City_Name}}</option>
                          @endforeach
                        @endif
                    </select>  
                    <select name="area" id="state" class="select2">
                        <option value="">Select Area</option>
                    </select>    
                    <select id="s_category" name="s_category"  class="select2" required="required">
                        <option value="">Category</option>
                        <?php foreach ($category as $key => $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                    <select id="s_type" name="s_type" class="select2">
                        <option value="">Sub Category</option>
                        <?php foreach ($type as $key => $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div id="countryList">
    </div>
        </div>
    </div>
    <!--banner section end-->
    <!-- category row-->
    <div class="category-row mg1">
        <div class="container">
            <a class="category-box" href="listing?s_key=&s_city=&s_category=1&s_type=">
            <!-- <a class="category-box" href="detail/4"> -->
                <img src="public/images/homepage_icon_img/property.png" alt="Properties">
                <span>Properties</span>
            </a>
            <a class="category-box" href="listing?s_key=&s_city=&s_category=2&s_type=">
            <!-- <a class="category-box" href="detail/5"> -->
                <img src="public/images/homepage_icon_img/consultancy.png" alt="Consultancy">
                <span>Consultancy</span>
            </a>
            <a class="category-box" href="listing?s_key=&s_city=&s_category=3&s_type=">
            <!-- <a class="category-box" href="detail/7"> -->
                <img src="public/images/homepage_icon_img/contractors.png" alt="Contractor">
                <span>Contractor</span>
            </a>
            <a class="category-box" href="listing?s_key=&s_city=&s_category=4&s_type=">
            <!-- <a class="category-box" href="detail/9"> -->
                <img src="public/images/homepage_icon_img/material.png" alt="Material">
                <span>Material</span>
            </a>

            <a class="category-box" href="listing?s_key=&s_city=&s_category=5&s_type=">
            <!-- <a class="category-box" href="detail/9"> -->
                <img src="public/images/homepage_icon_img/labor.png" alt="Material">
                <span>Skill labour</span>
            </a>
        </div>
    </div>

    
    <!-- category row end-->
    <!-- feature row -->
    <!-- category row end-->
    <!-- feature row -->
    <div class="feature-row">
        <div class="commonttl-subttl">
                <h2>Popular Listings</h2>
            </div>
   <div class="row">
   <div class="col-sm-12">
       <div class="flexslider2 flex_consultancy carousel">
            <ul class="slides">
                <?php foreach ($listing as $listings) { ?>
                    <li>
                    <div class="h-listing-box">
                       
                        <figure>
                            <?php
                                $directory = "public/images/".$listings->vl_id."/featured_image/";
                                $directory1 = "public/images/".$listings->vl_id."/pics/";


                                $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                $img = '';
                                foreach ($files as $key => $value) {
                                    $img = $value;
                                }
                            $check = '';
                                    if (empty(Sentinel::check())) {
                                        $check = '1';
                                    }else if(Sentinel::check())
                                    {
                                       $check = '1';
                                    }   else {
                                            if (isset($_COOKIE['otp_lists'])) {
                                                $explode = explode(',', $_COOKIE['otp_lists']);
                                                if (!in_array($value->vl_id, $explode)) {
                                                    $check = '0';
                                                } else {
                                                    $check = '1';
                                                }
                                            } else if (Sentinel::check() && Sentinel::inRole('vendor') && Sentinel::getUser()->id == $value->u_id ) {
                                                $check = '1';
                                            } else {
                                                $check = '0';
                                            }
                                    }
                                   
                           if(is_dir($directory) && count(glob("$directory/*")) !== 0){ ?>
                                    <div class="property-bg">
                                        <img class="popular_image" src="{{url('/')}}/public/images/{{$listings->vl_id}}/featured_image/{{$value}}" alt="featured_image">
                                    </div>
                            <?php  } else { ?>
                                    <div class="property-bg"    >
                                        <img class="popular_image" src="{{url('/')}}/public/images/{{$listings->vl_id}}/featured_image/{{$value}}" alt="featured_image">
                                    </div>
                            <?php  }  ?>
                               @if(isset($listings->url_name) && $listings->url_name != "")
                                <?php
                                    if ($check == '1') { ?>
                                        <div class="btn"><a href="detail/{{ $listings->url_name }}" class="onclick" >{{$listings->l_title}}</a></div>
                                    <?php } else { ?>
                                            <div class="btn"><a href="#" class="onclick" data-id="detail/{{ $listings->url_name }}" data-toggle="modal" data-target="#myOTP">{{$listings->l_title}}</a></div>
                                    <?php }
                                ?>
                                @else
                                <?php
                                    if ($check == '1') { ?>
                                        <div class="btn"><a href="detail/{{ $listings->vl_id }}" class="onclick" >{{$listings->l_title}}</a></div>
                                    <?php } else { ?>
                                            <div class="btn"><a href="#" class="onclick" data-id="detail/{{ $listings->vl_id }}" data-toggle="modal" data-target="#myOTP">{{$listings->l_title}}</a></div>
                                    <?php }
                                ?>
                                @endif

                            <div class="like" onclick="saveListing('listing_{{$listings->vl_id}}')">
                                <i class="fa fa-heart"></i>
                            </div>
                        </figure>
                        <div class="content">
                            
                            <p>{!! \Illuminate\Support\Str::words($listings->l_description, 10,'....')  !!}</p>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $listings->l_review)
                                        <i class="fa fa-star"></i>
                                    @else
                                        <i class="fa fa-star-o"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="address">
                                <i class="fa fa-map-marker"></i> {{$listings->l_nearby}}
                            </div>
                        </div>
                    </div>
                </li>
                <?php } ?>
            </ul>
  </div>
  </div>
  </div>

        <div class="container-fluid">
            <div class="commonttl-subttl">
                <h2>Properties</h2>
            </div>
   <div class="row">
     <div class="col-sm-9">
             <div class="proprities-list">
            <ul class="slides">
                <?php foreach ($category_properties as $key => $value) { ?>
                    <li>
                        <div class="">
                            <a class="feture-box" href="listing?s_key=&s_city=&s_category=1&s_type=<?php echo $value->id?>">
                                <?php if(isset($value->image)) { ?>
                                <div class="featureimg" style="background-image:url(public/images/category/1/{{$value->image}});"></div>
                                <?php } else {?>
                                <div class="featureimg" style="background-image:url(public/images/noimage.png);" width="100%"></div>
                                <?php } ?>
                                <div class="content">
                                    <h3><?php echo $value->name;?></h3>
                                    <div class="btnbox">view more</div>
                                </div>
                            </a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <!--<a class="commonbtn" href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
  </div></div>
  <div class="col-sm-3">
    <div class="property-adv feture-box">
                    <?php
                    $directory = "public/images/home_add";
                    $files = array_values(array_diff(scandir($directory), array('..', '.')));
                    foreach ($files as $key => $value) { ?>
                    <video poster="public/images/video_logo.jpg" controls muted loop style=" width: 100%; height: 142px; background-color: black;">
                        <source src="{{url('/')}}/public/images/home_add/{{$value}}" type="video/mp4" /> 
                    </video>
                    <?php } ?>   
        <div class="content">
            <h3>&nbsp;</h3>
        <div class="btnbox"><a href="https://www.youtube.com/channel/UCrvfZV9TZbck5YCpH7uorMQ" target="_blank" style="color:#fff">view more</a></div>
        </div>
  </div>
  </div>
   </div>
   <!-- -->
    <div class="commonttl-subttl">
                <h2>Consultancy</h2>
            </div>
   <div class="row">
   <div class="col-sm-12">
       <div class="flexslider2 flex_consultancy carousel">
            <ul class="slides">
                <?php foreach ($category_consultancy as $key => $value) { ?>
                    <li>
                        <div class="">
                            <a class="feture-box" href="listing?s_key=&s_city=&s_category=2&s_type=<?php echo $value->id?>" >
                            <?php if(isset($value->image)) { ?>
                                <div class="featureimg" style="background-image:url(public/images/category/2/{{$value->image}});"></div>
                                <?php } else {?>
                                <div class="featureimg" style="background-image:url(public/images/noimage.png);" width="100%"></div>
                                <?php } ?>
                                <div class="content">
                                    <h3><?php echo $value->name;?></h3>
                                    <div class="btnbox">view more</div>
                                </div>
                            </a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
  </div>
  </div>
  </div>
           <div class="commonttl-subttl">
                <h2>Contractor</h2>
            </div>
   <div class="row">
   <div class="col-sm-12">
       <div class="flexslider2 flex_contractor carousel">
            <ul class="slides">
                <?php foreach ($category_contractor as $key => $value) { ?>
                    <li>
                        <div class="">
                            <a class="feture-box" href="listing?s_key=&s_city=&s_category=3&s_type=<?php echo $value->id?>">
                            <?php if(isset($value->image)) { ?>
                                <div class="featureimg" style="background-image:url(public/images/category/3/{{$value->image}});"></div>
                                <?php } else {?>
                                <div class="featureimg" style="background-image:url(public/images/noimage.png);" width="100%"></div>
                                <?php } ?>
                                <div class="content">
                                    <h3><?php echo $value->name;?></h3>
                                    <!-- <p>16384 verified rentals</p> -->
                                    <div class="btnbox">view more</div>
                                </div>
                            </a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
  </div>
  </div>
  </div>
            <div class="commonttl-subttl">
                <h2>Material</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="flexslider2 flex_material carousel">
                        <ul class="slides">
                            <?php foreach ($category_material as $key => $value) { ?>
                                <li>
                                    <div class="">
                                        <a class="feture-box" href="listing?s_key=&s_city=&s_category=4&s_type=<?php echo $value->id?>" >
                                        <?php if(isset($value->image)) { ?>
                                            <div class="featureimg" style="background-image:url(public/images/category/4/{{$value->image}});"></div>
                                            <?php } else {?>
                                            <div class="featureimg" style="background-image:url(public/images/noimage.png);" width="100%"></div>
                                            <?php } ?>
                                            <div class="content">
                                                <h3><?php echo $value->name;?></h3>
                                                <!-- <p>16384 verified rentals</p> -->
                                                <div class="btnbox">view more</div>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="commonttl-subttl">
                <h2>Skill labour</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                   <div class="flexslider2 flex_contractor carousel">
                        <ul class="slides">
                            <?php //echo "<pre>"; print_r($category_skill_labour); exit; ?>
                            <?php foreach ($category_skill_labour as $key => $value) { ?>
                                <li>
                                    <div class="">
                                        <a class="feture-box" href="listing?s_key=&s_city=&s_category=5&s_type=<?php echo $value->id?>">
                                        <?php if(isset($value->image)) { ?>
                                            <div class="featureimg" style="background-image:url(public/images/category/5/{{$value->image}});"></div>
                                            <?php } else {?>
                                            <div class="featureimg" style="background-image:url(public/images/noimage.png);" width="100%"></div>
                                            <?php } ?>
                                            <div class="content">
                                                <h3><?php echo $value->name;?></h3>
                                                <!-- <p>16384 verified rentals</p> -->
                                                <div class="btnbox">view more</div>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature row end -->
    <!--Popular  listing-->
    
  </div>
        </div>
    </div>
    <!--Popular  listing end-->
    <!--signup row-->
    <div class="signup-row">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="vendorbox">
                        <div class="vendor1 vendor"><img src="public/assets/images/user1.png" alt="User"></div>
                        <div class="vendor2 vendor"><img src="public/assets/images/user2.png" alt="User"></div>
                        <div class="vendor3 vendor"><img src="public/assets/images/user3.png" alt="User"></div>
                        <div class="vendor4 vendor"><img src="public/assets/images/user4.png" alt="User"></div>
                        <div class="vendor5 vendor"><img src="public/assets/images/user5.png" alt="User"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="rightside">
                        <h3>List your business</h3>
                        <p>Associate with us and deal on our e-commerce marketplace.</p>
                        <a class="commonbtn" href="/becomevendor">SignUp Now <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--signup row end-->
    <!-- find-vendor-->
    <div class="find-vendor">
        <div class="container">
            <h3>Find the best deal for you</h3>
            <p>Get connected with skilled contractors, traders and New Property sellers</p>
            <a class="commonbtn" href="javascript:void(0)">Find Vendor <i class="fa fa-angle-right" aria-hidden="true"></i></a>
        </div>
    </div>
    <!-- find-vendor-end-->
    <!-- hpw it work-->
    <div class="how-it-work-row padd100">
        <div class="commonttl-subttl">
            <h2>How it Works</h2>
            <span>Associate with us with these three simple steps</span>
        </div>
        <div class="container">
            <div class="row">
                <div class="worksboxes">
                    <div class="col-sm-4">
                        <div class="works-box">
                            <figure>
                                <img src="public/assets/images/map.png" alt="how it Works">
                            </figure>
                            <h5>Navigate</h5>
                            <p>Find what you are looking for</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="works-box">
                            <figure>
                                <img src="public/assets/images/mail.png" alt="how it Works">
                            </figure>
                            <h5>Connect</h5>
                            <p>Discover the deals for you</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="works-box">
                            <figure>
                                <img src="public/assets/images/trust.png" alt="how it Works">
                            </figure>
                            <h5>Congratulations!</h5>
                            <p>Welcome aboard to Yas Sir. We will always have many great deals to offer you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-row">
        <div class="container-fluid">

    <div class="commonttl-subttl">
        <h2>Associated with us</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
           <div class="flexslider2 flex_contractor carousel">
                <ul class="slides">
                    <?php
                    $directory = "public/images/brand";
                    $files = array_values(array_diff(scandir($directory), array('..', '.')));
                    foreach ($files as $key => $value) { ?>
                        <li>
                            <div class="">
                                
                             
                                <img src="{{url('/')}}/public/images/brand/{{$value}}" alt="brand">    
                                    
                               
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
    <!-- how it work end-->
    <!-- counts row-->
    <div class="count-row padd100">
        <div class="container">   
            <div class="row">
                <div class="col-sm-4 text-center">
                    <h3>{{ $visitor_count }}</h3>
                    <span>new visitor</span>
                </div>
                <div class="col-sm-4 text-center">
                    <h3>{{ $happy_cust }}</h3>
                    <span>Happy customers</span>
                </div>            
                <div class="col-sm-4 text-center">
                    <h3>{{ $vendor_count }}</h3>
                    <span>New Vendors</span>
                </div>
            </div>
        </div>
    </div>
    <!-- counts row end-->
    <!-- testimonial row-->
    <div class="testimonial-row padd100">
        <div class="container">
            <div class="commonttl-subttl">
                <h2>Testimonials</h2>
                <span>Know Yourself Your Inner Power</span>
            </div>
        </div>
        <div class="flexslider1 carousel">
            <ul class="slides">
                 @foreach($testimonials as $t)
                <li class="text-center">
                        <div class="testicontent">
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $t->t_rating)
                                        <i class="fa fa-star"></i>
                                    @else
                                        <i class="fa fa-star-o"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="quotebox"></div>
                            <p>{{$t->t_quote}}</p>
                        </div>
                    <div class="reviewer">
                        <img src="public/assets/images/testimonial-down-arrow.png" class="arrow" alt="Review">
                        <figure class="testimonial-figure">
                            <img src="public/images/testimonial/{{$t->t_id}}/{{$t->t_image}}" alt="Review">
                        </figure>
                        <h5>{{$t->t_name}}</h5>
                        <span>{{$t->t_company}}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- testimonial r ow end-->
    <!-- testimonial r ow end-->
    <div id="tst">
   </div>
<link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
<!-- <script src="{{ asset('public/js/select2.full.min.js') }}"></script> -->


<script async src="https://cse.google.com/cse.js?cx=018325874689819820679:jkadin80v5t"></script>


<script src="{{ asset('public/assets/js/select2_b86534ec160eaa35eabe3003543e50eb.js') }}" defer></script>
<script>
    function msg() {
        var x = document.getElementById("snackbar");
        x.className = "show";
    }
     $(function () {
        $('.select2').select2()
    });
    $('#close').click(function(){
        //alert('fg');
        $('#tst').css('display','none');
    });
    jQuery("#s_category").on('change',function(){
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getType')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#s_type").empty();

                    $("#s_type").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#s_type").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })
    });
    jQuery(window).on( 'scroll', function(){
        
        if (jQuery(window).scrollTop() >= 350) {
            jQuery('.bannertext ').addClass('sticky-tab');
        } else {
            jQuery('.bannertext ').removeClass('sticky-tab');
        }
    });
    function getPredefineSelection() {
        var keyword = jQuery("#s_key").val();
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getSelectionInfo')}}?keyword="+keyword,
            success:function(data){
                if (data === false || data === 'no_action') {
                    $("#s_category").val('').change();
                    $("#s_type").val('').change();
                } else {
                    //Grab the category value
                    var cate = $("s_category").val();
                    var s_type = $("s_type").val();
                    if (cate !== data.category_id) {
                        $("#s_category").val(data.category_id).change();
                    }
                    if (s_type !== data.sub_cate_id) {
                        setTimeout(function(){ $("#s_type").val(data.sub_cate_id).change(); }, 2000);
                    }
                }
            }
        })
    }
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
</script>
<script>
    $("#s_city").on('change',function(){
        var City_Id = $(this).val(); 
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#state").empty();
                    $("#state").append('<option value="">Select Area</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
    });
 $('#s_key').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch') }}",
          method:"GET",
          data:{query:query, _token:_token},
          success:function(data){
           $('#countryList').fadeIn();  
            $('').css("background-color", "yellow");
                    $('#countryList').html(data);
          }
         });
        }
    });
$(document).on('click', 'li.main_search', function(){ 

        $('#s_key').val($(this).text());  
        $('#countryList').fadeOut();  

        var keyword = jQuery("#s_key").val();
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getSelectionInfo')}}?keyword="+keyword,
            success:function(data){
                if (data === false || data === 'no_action') {
                    $("#s_category").val('').change();
                    $("#s_type").val('').change();
                } else {
                    //Grab the category value
                    var cate = $("s_category").val();
                    var s_type = $("s_type").val();
                    if (cate !== data.category_id) {
                        $("#s_category").val(data.category_id).change();
                    }
                    if (s_type !== data.sub_cate_id) {
                        setTimeout(function(){ $("#s_type").val(data.sub_cate_id).change(); }, 2000);
                    }
                }
            }
        })


    }); 

</script>
@include('footer')
