@include('header')

<!--main content-->
<div id="main" class="inner-content  product-listing whishlist">

    <div class="commonttl-subttl paddtop">
     <!--   <div class="lightttl">Catalog of Categories</div>-->
        <h2>Compare Wishlist</h2>
    </div>

    <div class="container-fluid">
       <div class="row">
           <div class="col-sm-12 product-listing-left">
            <div class="row">
                <div class="listingview service-list col-sm-12">
                    <div class="col-sm-12">
                       
                        <?php
                            if ($result) {
                                $kk = 1;
                                $w = 1;           
                                foreach ($result as $key => $value) { 

                                  $masterArray = array();
                                  $priceArray = array();
                                  $price = json_decode($value->price,true);
                                  $carpet_area = json_decode($value->carpet_area,true);
                                  $super_area = json_decode($value->super_area,true);
                                  $type = json_decode($value->type,true);
                                  $floor = $value->floor;
                                  $status = $value->status;
                                   
                                  if($super_area != "")
                                 {
                                  foreach ($super_area['type'] as $key2 => $value2) {
                                    foreach ($super_area[$value2] as $k2 => $v2) {

                                      $masterArray[$value2][$v2]['price'][] = $price[$value2][$k2];
                                      $masterArray[$value2][$v2]['carpet_area'][] = $carpet_area[$value2][$k2];
                                      $masterArray[$value2][$v2]['super_area'][] = $super_area[$value2][$k2];
                                      $masterArray[$value2][$v2]['type'][] = $type[$value2][$k2];
                                    }
                                  }
                                 }  

                                    ?>
                                    
                                    <?php

                                    $check = '';
                                    if (empty(Sentinel::check())) {
                                        $check = '1';
                                    } 
                                    else if(Sentinel::check())
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
                                    } ?>

                                    @if ($value->l_category == '1')
                                    <div class="h-listing-box" id="rm_{{ $value->vl_id }}">
                                       <div class="close" onclick="remove('{{ $value->vl_id }}')"> <i class="fa fa-times"></i></div>
                                        <figure class="wis">
                                            <?php
                                                $directory = "public/images/".$value->vl_id."/featured_image/";
                                                $directory1 = "public/images/".$value->vl_id."/pics/";
                                                if(is_dir($directory) && count(glob("$directory/*")) !== 0){ ?>
                                                    <img src="{{ $directory}}/featured_image.jpg" alt="Popular Listing">

                                              <?php  }else{
                                                    $files = array_values(array_diff(scandir($directory1), array('..', '.')));


                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                }
                                            ?>
                                            <img src="{{ $directory1.$img }}" alt="Popular Listing">
                                            <?php
                                        } ?>
                                            <div class="like" onclick="saveListing('listing_{{$value->vl_id}}')">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                            <div class="price">
                                                <?php
                                                    foreach ($masterArray as $k => $v) {
                                                      foreach ($v as $kv => $vv) {
                                                        foreach ($vv['price'] as $details) {

                                                          if($details != 0)
                                                          {
                                                            $priceArray[] = $details;
                                                          }
                                                        }
                                                      }
                                                    }
                                                    if (!empty($priceArray) && count($priceArray) > 1) {
                                                      $min = min($priceArray);
                                                      $max = max($priceArray);
                                                      echo $min.' - '.$max.' lacs';
                                                    } else if (!empty($priceArray) && count($priceArray) == 1) {
                                                      echo $priceArray[0].' lacs';
                                                    }
                                                ?>
                                            </div>
                                        </figure>
                                        <div class="content">
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->url_name }}"><h4>{{ $value->l_title }}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" class="onclick" data-id="/detail/{{$value->url_name}}" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            <div class="detail">
                                                <span>
                                                  @if($value->l_sub_category==1)
                                                  @foreach($vv['super_area'] as $details)
                                                  <small>Built Up area</small>{{$details}} sqft
                                                  @endforeach
                                                  @else
                                                   @foreach($vv['super_area'] as $details)
                                                  <small>Built Up area</small>{{$details}} sqyard
                                                  @endforeach
                                                  @endif
                                                </span>
                                                <span>
                                                  
                                                  <small>Status</small>{{$value->status}}
                                                 
                                                </span>
                                                 <span>
                                                 
                                                  <small>Floor</small>{{$value->floor}}
                                                 
                                                </span>
                                                <span>
                                                  @foreach($vv['type'] as $details)
                                                  <small>Transaction</small>{{$details}}
                                                  @endforeach
                                                </span>
                                            </div>
                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($value->l_description) }}</p>
                                            <div class="reranum">Rera number:<a href="https://gujrera.gujarat.gov.in/" target="_blank" style="color:green"class="rera_text" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Property Details"> {{ $value->rera_number }}</a></div>
                                                <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $value->l_view)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="fa fa-star-o"></i>
                                                    @endif
                                                @endfor
                                                <span>( {{ $value->l_view }} count )</span>
                                            </div>

                                            <div class="address">
                                                <i class="fa fa-map-marker"></i> {{ $value->l_title }} , {{ $value->l_nearby }}
                                            </div>
                                        </div>
                                    </div>
                                      @elseif($value->l_category == '5')
                                        
                                    <div class="h-listing-box" id="rm_{{ $value->vl_id }}">
                                        <div class="close" onclick="remove('{{$value->vl_id}}')">  <i class="fa fa-times"></i>
                                        </div>
                                        <figure>
                                       
                                       <img src="{{url('/')}}/public/images/no-image.png">     
                                           
                                        </figure>
                                        <div class="content">
                                             <a href="skill_labour_detail/{{ $value->vl_id }}/{{ $value->u_id }}">
                                            <h4>Name : {{ $value->first_name.' '.$value->last_name }} </h4></a>
                                            <p>Email Details : {{ $value->email }} </p>
                                            <p>Phone : {{ $value->Phone }} </p>
                                            <p>Experiance : {{ $value->experience_details }} </p>
                                            <p>Age : {{ $value->age_details }} </p>
                                            <p>Adhar Details : {{ $value->adharnumber_details }} </p>
                                            <?php if(!empty($value->city)){ ?>
                                            <p class="address"><i class="fa fa-map-marker"></i> {{ $value->city }} </p>
                                            <?php } ?>    
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            <span>( 24 count )</span>
                                            </div>
                
                                        </div>  
                                    </div>    


                                        

                                    @elseif($value->l_category == '4')


                                    <div class="h-listing-box" id="rm_{{ $value->id }}">
                                        <div class="close" onclick="remove('{{$value->id}}')"> <i class="fa fa-times"></i></div>
                                        <figure>
                                            <?php
                                                $directory = "public/images/product/".$value->id;
                                                $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                }
                                            ?>
                                            <img src="{{ $directory}}/{{$img }}" alt="Popular Listing">

                                        </figure>
                                        <div class="content">
                                             <a href="product_detail/{{ $value->vl_id }}/{{ $value->id }}"><h4>{{ $value->product_name }}</h4></a>

                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($value->product_detail) }}</p>
                                            @if($value->product_price != '0')
                                                <div class="price">
                                                    &#8377; {{ $value->product_price }}
                                                </div>
                                            @endif
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <span>( {{ $value->l_view }} count )</span>
                                            </div>
                                            <div class="address">
                                                <i class="fa fa-map-marker"></i> {{ $value->l_nearby }}
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="h-listing-box" id="rm_{{ $value->vl_id }}">
                                        <div class="close" onclick="remove('{{$value->vl_id}}')"> <i class="fa fa-times"></i></div>
                                        <figure>
                                            <?php
                                                $directory = "public/images/".$value->vl_id."/pics/";
                                                $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                }
                                            ?>
                                            <img src="{{ $directory.$img }}" alt="Popular Listing">
                                        </figure>
                                        <div class="content">
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->vl_id }}"><h4>{{ $value->l_title }}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" class="onclick" data-id="/detail/{{$value->vl_id}}" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($value->l_description) }}</p>

                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <span>( {{ $value->l_view }} count )</span>
                                            </div>
                                            <div class="address">
                                                <i class="fa fa-map-marker"></i> {{ $value->l_nearby }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                <?php  } ?>

                            <?php } else { ?>
                <div class="">
                  <div class="content text-center">
                    <h4> No Content Available</h4>
                  </div>
                </div>
                <?php } ?>
                    </div>
               </div>
            </div>
<!--Popular  listing end-->
           </div>
        </div>
    </div>
</div>
<!-- main content end-->
<script>

    function remove(id) {

        var expDate = new Date();
        expDate.setTime(expDate.getTime() + (15 * 60 * 1000)); // add 15 minutes

        //Hide the listing
        $("#rm_"+id).hide();

        //Update the cookie value
        if (typeof $.cookie("total_count") !== 'undefined' && $.cookie("total_count") !== '0') {
            var updated = Number($.cookie("total_count")) - 1;     // Number()
        } else {
            var updated = '0';
        }

        var yourArray = [];
        if (typeof $.cookie("listing_value") !== 'undefined') {
            var exp = $.cookie("listing_value").split(',');

            $.each( exp, function( key, value ) {
                var exp_value = value.split('_');
              if(id === exp_value[1]){
              } else {
                yourArray.push(value);
              }
            });

        }
         $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
        //Erase value
        $.removeCookie("total_count", { path: '/' });
        $.removeCookie("listing_value", { path: '/' });

        //Set new value
        $.cookie('total_count', updated, { path: '/', expires: expDate });
        $.cookie("listing_value",yourArray.join(','), { path: '/', expires: expDate });

        //Update the header count value
        $(".header-like .count").html('');
        $(".header-like .count").html(updated);
    }

</script>
@include('footer')