@include('header')
<!--main content-->
<body class="firstBlur">
<style>
.error { color:red;}
.searchbox.s-box{font-family: 'Oswald', sans-serif !important;}
.s-box input::placeholde{font-family: 'Oswald', sans-serif !important;}
.s-box input[type="text"]{    padding: 10px 10px 10px 30px;
    background: #fff;
    display: inline-block;
    border: 0;
    border-radius: 35px 0 0 35px;
    float: left;
    margin: 5px 0;
    width: 30%;font-family: 'Work Sans', sans-serif !important;font-size: 16px;color:#000;}
    .servicespage-detail .searchbox select{font-family: 'Work Sans', sans-serif !important;font-size: 15px;font-weight: bold;color:#000;}
    .s-box form input.s_key,.s-box form input,.s-box form input[type="text"],.s-box form input::placeholder{font-family: 'Work Sans', sans-serif !important;}
    #myOTR{}
    #myOTR .modal-content{}
    #myOTR .form-group{padding: 0px 18px;margin-top:10px;margin-bottom:10px;}
    #myOTR .modal-content .otp_information p{margin: 0;text-align: center;padding: 10px 0px;background: #8c1730;color: #fff;font-size: 18px;font-weight: bold;border-radius: 5px;}
    #myOTR .modal-content .otp_information label{margin: 0;}
    #myOTR .modal-content .otp_information input{}
    #myOTR .modal-footer{text-align: center;border: 0;padding: 0px 0px 15px;}
    #myOTR .modal-footer.otp_num_submit button{padding: 8px 50px;background: #8c1730;font-size: 18px;font-weight: bold;border: 0;}
    button.close.otr-11{position: absolute;top: -14px;background: #0000;opacity: 1;color: #d2cece;text-shadow: none;right: -4px;font-size: 26px;}
    #myOTR .modal-body{padding-top: 26px;}
span.select2.select2-container.select2-container--default{left:0px;}
/*--thank you pop starts here--*/
.thank-you-pop{
  width:100%;
  padding:20px;
  text-align:center;
}
.thank-you-pop img{
  width:76px;
  height:auto;
  margin:0 auto;
  display:block;
  margin-bottom:25px;
}

.thank-you-pop h1{
  font-size: 42px;
    margin-bottom: 25px;
  color:#5C5C5C;
}
.thank-you-pop p{
  font-size: 20px;
    margin-bottom: 27px;
  color:#5C5C5C;
}
.thank-you-pop h3.cupon-pop{
  font-size: 25px;
    margin-bottom: 40px;
  color:#222;
  display:inline-block;
  text-align:center;
  padding:10px 20px;
  border:2px dashed #222;
  clear:both;
  font-weight:normal;
}
.thank-you-pop h3.cupon-pop span{
  color:#03A9F4;
}
.thank-you-pop a{
  display: inline-block;
    margin: 0 auto;
    padding: 9px 20px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    background-color: #8BC34A;
    border-radius: 17px;
}
.thank-you-pop a i{
  margin-right:5px;
  color:#fff;
}
#ignismyModal .modal-header{
    border:0px;
}
.modal { background:rgba(0, 0, 0, 0.7803921568627451);}
/*--thank you pop ends here--*/
.servicespage-detail {
    position: relative;
    width: 100%;
    float: left;
    right: -15px;
}
.bbg{padding: 3px 4px;background: #8c1730;border-radius: 3px;color: #fff;text-align: center;margin-bottom:3px; display: inline-block;}
</style>
<div class="modal fade1" id="myOTR" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <form method="post" id="super_submit">
              {{csrf_field()}}
              <div class="modal-body otp_information">
              <button type="button" class="close otr-11" data-dismiss="modal" id="close_modal">×</button>
                <p>ONE TIME REGISTRATION</p>
                <span id="ltName" style="display: none;"></span>
                  <div class="row">
              <div class="form-group">
                    <span style="color:red;"></span><label for="">Name</label><input type="text" class="form-control txtname" name="txtname"  id="txtname" placeholder="Enter your name">
                  </div>
                  <div class="form-group">
                    <span style="color:red;"></span><label for="">Number</label><input type="text" class="form-control number user" name="txtnumber"  id="txtnumber" maxlength="13" minlength="10"  placeholder="Enter your number">
                    <div id="error_user" class="text-danger"></div>
                  </div>
                  <div class="form-group">
                    <span style="color:red;"></span><label for="">City</label><input type="text" class="form-control txtcity"  name="txtcity" id="txtcity" placeholder="Enter your city">
                  </div>
                  <div class="form-group">
                    <span style="color:red;"></span><label for="">Looking for</label>
                    <select class="form-control" name="cat" id="cat">
                    <option value="">Select category</option>
                    <option value="Property">Property</option>
                    <option value="Consultancy">Consultancy</option>
                    <option value="Contractor">Contractor</option>
                    <option value="Material">Material</option>
                    <option value="Skill Labour">Skill Labour</option>
                  </select>
                  </div>
              </div>
              </div>
              <div class="modal-footer otp_num_submit">
                  <button type="submit" class="btn btn-primary" id="submits">Submit</button> 
              </div>
              </form>
          </div>
      </div>
    </div>
<div id="main" class="inner-content  product-listing">
    <div class="container-fluid">
       <div class="row">
           <div class="col-sm-8 product-listing-left">
             <!-- search form-->
             <div class="col-sm-12 servicespage-detail">
             <div class="searchbox  s-box"  data-spy="affix" >
                    <form>
                        <input type="text" name="s_key" id="s_key" class="s_key" value="{{ $s_key }}" onkeyup="getPredefineSelection()" placeholder="Requirement">                
                  <select name="s_city" id="s_city"  class="select2">
                        <option value="">Select city</option>
                        @if (!empty($city_info))
                          @foreach($city_info as $d)                         
                         @if (isset($s_city) && $d->City_Name == $s_city)
                            <option value="{{$d->City_Name}}" selected="selected">{{$d->City_Name}}</option>
                             @else
                             <option value="{{ $d->City_Name }}">{{ $d->City_Name }}</option>
                             @endif                          
                          @endforeach
                        @endif
                    </select>  
                    <select name="area" id="state" class="select2">
                        <option value="">Select Area</option>
                    </select> 
            <select id="l_category" name="s_category" required class="select2 l_category">
              <option value="" disabled="">Category</option>
              <option value="1" <?php if($_GET['s_category'] == '1'): ?> selected="selected"<?php endif; ?>>Properties </option>
              <option value="2" <?php if($_GET['s_category'] == '2'): ?> selected="selected"<?php endif; ?>>Consultancy </option>
              <option value="3" <?php if($_GET['s_category'] == '3'): ?> selected="selected"<?php endif; ?>>Contractor</option>
              <option value="4" <?php if($_GET['s_category'] == '4'): ?> selected="selected"<?php endif; ?>> Material</option>
              <option value="5" <?php if($_GET['s_category'] == '5'): ?> selected="selected"<?php endif; ?>> Skill labour</option>
            </select>
            <select id="s_type" name="s_type" class="select2">
              <option value="">Sub Category</option>
                <?php foreach ($type as $key => $value) {
                    if ($type_id != '' && $type_id == $value->id) { ?>
                      <option value="<?php echo $value->id; ?>" selected><?php echo $value->name; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            
           
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                </div>
             <!-- serach form close-->
             <!-- search form -->
             <!-- search form close-->
           <!--Popular  listing-->
            <?php
                if (!$result) {
                    $array = array();
                    foreach ($result as $key => $value) {
                        $address = $value->l_location;
                        $ex = explode(',',$address);
                        $a = array();
                        foreach ($ex as $key => $value) {
                            $a[] = trim($value);
                        }
                        $im = implode(',<br>',$a);
                        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=true&key=AIzaSyBIU0AkBLdVGjo4oTQm3R5kyYC6uhNdMLs');
                        $geoReponse = json_decode($geo, true);
                        $url = urlencode($address);
                        if (isset($geoReponse['status']) && $geoReponse['status'] == 'OK') {
                            $latitude = $geoReponse['results'][0]['geometry']['location']['lat'];
                            $longitude = $geoReponse['results'][0]['geometry']['location']['lng'];
                            $array[] = array('lat'=> $latitude ,'log'=> $longitude,'address'=>$im,'url' => 'https://www.google.com/maps/place/'.$url);
                        }
                        ?>
                   <?php  }
                }
            ?>
            <div class="row">
                <div class="listingview service-list col-sm-12">
                    <div class="col-sm-12 listing-all nd-padding">
                        <?php
                            if (!$result->isEmpty()) {
                                 $kk = 1;
                                $w = 1;
                                foreach ($result as $key => $value) {
                                  $masterArray = array();
                                  $priceArray = array();
                                  $price = $value->price;              
                                  $carpet_area = json_decode($value->carpet_area,true);
                                  $super_area = json_decode($value->super_area,true);
                                  $type = json_decode($value->type,true);
                                  $floor = $value->floor;
                                  $status = $value->status;
                                 if($super_area != "")
                                 {
                                  foreach ($super_area['type'] as $key2 => $value2) {
                                    foreach ($super_area[$value2] as $k2 => $v2) {
                                      
                                      $masterArray[$value2][$v2]['carpet_area'][] = $carpet_area[$value2][$k2];
                                      $masterArray[$value2][$v2]['super_area'][] = $super_area[$value2][$k2];
                                      $masterArray[$value2][$v2]['transaction_type'][] = $type[$value2][$k2];
                                    }
                                  }
                                 }
                                 ?>
                                    @if($kk % 2 == 0 && $value->l_category == '4' && $value->l_status == '1')
                                    @elseif($kk % 2 != 0 && $value->l_category == '4' && $value->l_status == '1')
                                        <div class="col-sm-12">
                                    @endif
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

                                    @if($value->l_category == '1' && $value->l_status == '1')
                                    <div class="h-listing-box">
                                        <figure>      
                                            <?php
                                                $directory = "public/images/".$value->vl_id."/featured_image/";
                                                $directory1 = "public/images/".$value->vl_id."/pics/";

                                                if(is_dir($directory)){
                                        if(is_dir($directory) && count(glob("$directory/*")) !== 0){
                                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                          $img = '';
                                        foreach ($files as $key => $values) { ?>
                                                   <?php if($value->l_prime == 1){ ?>

                                                    <div class="listing-img-pro">
                                                      <div class="featured-cvr">
                                                        <h6>Premium</h6>
                                                       </div>
                                                      <img src="{{ $directory}}/{{ $values }}" alt="Popular Listing">
                                                    </div>
                                            <?php } else { ?>
                                                  <div class="listing-img-pro">
                                                     
                                                      <img src="{{ $directory}}/{{ $values }}" alt="Popular Listing">
                                                    </div>


                                           <?php  } ?> 
                                              <?php } } }else{
                                                    $files = array_values(array_diff(scandir($directory1), array('..', '.')));
                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                } 
                                            ?>    
                                            <div class="listing-img-pro">
                                              <img src="{{ $directory1.$img }}" alt="Popular Listing">
                                            </div>
                                            <?php
                                        } ?>
                                            <div class="like" onclick="saveListing('listing_{{$value->vl_id}}')">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                            <div class="price" style="display: none;">
                                                <?php
                                                // $abc = "<i class='fa fa-inr'></i>";
                                                //     foreach ($result as $v) {
                                                        
                                                //           if($v->price != 0)
                                                //           {
                                                //             $priceArray[] = $v->price;
                                                //           }
                                                //     }
                                                //     if (!empty($priceArray) && count($priceArray) > 1) {
                                                //       $min = min($priceArray);
                                                //       $max = max($priceArray);
                                                //       echo $abc.' '.$min.' - '.$max;
                                                //     } else if (!empty($priceArray) && count($priceArray) == 1) {
                                                //       echo $abc.' '.$priceArray[0];
                                                //     }
                                                $abc = "<i class='fa fa-inr'></i>";
                                                echo $abc.' '.$value->price;
                                                ?>
                                            </div>
                                            <div class="price">
                                                <?php
                                                // $abc = "<i class='fa fa-inr'></i>";
                                                //     foreach ($masterArray as $k => $v) {
                                                //       foreach ($v as $kv => $vv) {
                                                //         foreach ($vv['price'] as $details) {
                                                //           if($details != 0)
                                                //           {
                                                //             $priceArray[] = $details;
                                                //           }
                                                //         }
                                                //       }
                                                //     }
                                                //     if (!empty($priceArray) && count($priceArray) > 1) {
                                                //       $min = min($priceArray);
                                                //       $max = max($priceArray);
                                                //       echo $abc.' '.$min.' - '.$max.' lacs';
                                                //     } else if (!empty($priceArray) && count($priceArray) == 1) {
                                                //       echo $abc.' '.$priceArray[0].' lacs';
                                                //     }
                                                $abc = "<i class='fa fa-inr'></i>";
                                                echo $abc.' '.$value->price;
                                                ?>
                                            </div>
                                        </figure>
                                        <div class="content">
                                            <div class="detailtab mainhead">
                                                      @if(isset($value->Vl_id) && $value->url_name != "")
                                                      <?php
                                                          if ($check == '1') { ?>
                                                              <a href="detail/{{ $value->url_name }}" class="onclick">{{$value->l_title}}</a>
                                                          <?php } else { ?>
                                                              <a href="#" data-id="detail/{{ $value->url_name }}" class="onclick" data-toggle="modal" data-target="#myOTP">{{ $value->l_title }}</a>
                                                          <?php }
                                                      ?>
                                                      @else
                                                      <?php
                                                          if ($check == '1') { ?>
                                                              <a href="detail/{{ $value->url_name }}" class="onclick">{{ucfirst($value->l_title)}}</a>
                                                          <?php } else { ?>
                                                              <a href="#" data-id="detail/{{ $value->url_name }}" class="onclick" data-toggle="modal" data-target="#myOTP">{{ ucfirst($value->l_title) }}</a>
                                                          <?php }
                                                      ?>
                                                      @endif
                                                      <ul class="nav-tabs tab">
                                                          <?php
                                                            if(($value->l_category) == 1){
                                                              if (($value->l_sub_category) == 1) { ?>
                                                               <li><button>Offices & shop</button></li> <?php

                                                                    if($value->shop_car_parking == 1)
                                                                    {
                                                                    $value->shop_car_parking = "yes"; 
                                                                    }else
                                                                    {
                                                                    $value->shop_car_parking = "no";
                                                                    }

                                                                    if($value->shop_price){ ?>
                                                                    <li><button class="shop" id="{{$value->vl_id}}" data-id="{{$value->vl_id}}" data-shop_price="{{$value->shop_price}}" data-shop_area="{{$value->shop_area}}" data-shop_washroom="{{$value->shop_washroom}}" data-shop_floor="{{$value->shop_floor}}" data-shop_car_parking="{{$value->shop_car_parking}}">Shop</button></li>
                                                                    <?php } 

                                                              }else
                                                              {
                                                                 $x = 1;
                                                              foreach ($masterArray as $mk => $mv) {
                                                                echo '<li><button class="bhk_class" id="bhk_'.$w.'_'.$mk.'">'.$mk.'</button></li>';
                                                                $x++;
                                                                     }
                                                                      if($value->shop_price){ ?>
                                                                    <li><button class="shop" id="{{$value->vl_id}}" data-id="{{$value->vl_id}}" data-shop_price="{{$value->shop_price}}" data-shop_area="{{$value->shop_area}}" data-shop_washroom="{{$value->shop_washroom}}" data-shop_floor="{{$value->shop_floor}}" data-shop_car_parking="{{$value->shop_car_parking}}">Shop</button></li>
                                                                    <?php } 

                                                              }
                                                            }
                                                             
                                                            ?>
                                                            <?php
                                                              if($value->shop_car_parking == 1)
                                                              {
                                                              $value->shop_car_parking = "yes"; 
                                                              }else
                                                              {
                                                              $value->shop_car_parking = "no";
                                                              }
                                                          ?>
                                                      </ul>
                                                      <div class="detiltab-txt">
                                                        <div class="sqrft">
                                                          <ul class="detailtab2 detailtab2_<?php echo $w ?>">
                                                            <?php
                                                              $y = 1;
                                                              foreach ($masterArray as $km => $vm) {
                                                                foreach ($vm as $vk => $vv) {
                                                                  $ans = str_replace('.', '&#8228;', $vk);
                                                                  if($value->l_sub_category == 1) {
                                                                  if ($y == 1) {
                                                                    echo '<li class="bhk_'.$w.'_'.$km.'"><button class="sqft_click 2bhk" id="sqft_'.$w.'_'.$km.'_'.$ans.'">'.$ans.' Sqft</button></li>';
                                                                  } else {
                                                                    echo '<li class="bhk_'.$w.'_'.$km.'" style="display:none;"><button class="sqft_click 3bhk" id="sqft_'.$w.'_'.$km.'_'.$ans.'">'.$ans.' Sqft</button></li>';
                                                                  } 
                                                                  }else {
                                                                    if ($y == 1) {
                                                                    echo '<li class="bhk_'.$w.'_'.$km.'"><button class="sqft_click 2bhk" id="sqft_'.$w.'_'.$km.'_'.$ans.'">'.$ans.' Sqyrd</button></li>';
                                                                  } else {
                                                                    echo '<li class="bhk_'.$w.'_'.$km.'" style="display:none;"><button class="sqft_click 3bhk" id="sqft_'.$w.'_'.$km.'_'.$ans.'">'.$ans.' Sqyrd</button></li>';
                                                                  }
                                                                  }
                                                                }
                                                                $y++;
                                                              }
                                                            ?>
                                                            <li class="shop_sqyrd" style="display: none;"><button>{{$value->shop_area}} Sqyrd</button></li>
                                                          </ul>
                                                        </div>
                                                        <div class="detail detail2_<?php echo $w ?>">
                                                          <?php $z = 1; ?>
                                                          @foreach($masterArray as $k => $v)

                                                            @foreach ($v as $kv => $vv)
                                                            <?php
                                                            $ans1 = str_replace('.', '&#8228;', $kv);
                                                            ?>
                                                            <?php if ($z == 1) { ?>
                                                            <div class="property_detail" id="property_detail_<?php echo $w?>_<?php echo $k?>_<?php echo $ans1?>">
                                                              <?php } else { ?>
                                                                <div class="property_detail" id="property_detail_<?php echo $w?>_<?php echo $k?>_<?php echo $ans1?>" style="display: none;">
                                                                  <?php } ?>
                                                                  <a href="detail/{{ $value->url_name }}">
                                                                    <div class="www">
                                                            @if($value->l_sub_category == 1)
                                                            <span> 
                                                              @foreach($vv['super_area'] as $details)
                                                                <small>Built Up area</small>{{$details}} sqft
                                                              @endforeach
                                                            </span>
                                                            @else
                                                            <span> 
                                                              @foreach($vv['super_area'] as $details)
                                                                <small>Built Up area</small>{{$details}} sqyrd
                                                              @endforeach
                                                            </span>
                                                            @endif
                                                            
                                                            <span>
                                                             
                                                              <small>Status</small>{{$value->status}}
                                                              
                                                            </span>
                                                            <span>
                                                              
                                                              <small>Floor</small>{{$value->floor}}
                                                              
                                                            </span>
                                                            <span>
                                                             @foreach($vv['transaction_type'] as $details)
                                                              <small>Transaction</small>
                                                              {{$details}}
                                                              @endforeach
                                                              
                                                            </span>
                                                                   </div>
                                                                 </a>
                                                                </div>
                                                                <?php $z ++;?>
                                                                 @endforeach
                                                                @endforeach
                                                      
                                                                @if($value->shop_price && $value->vl_id)

                                                              <div class="detail shop_info" id="{{$value->vl_id}}">
                                                                   <input type="hidden" class="hdnvalue" value="{{$value->vl_id}}" >
                                                                    <span>
                                                                    <small>Built Up area</small>
                                                                    <div Class="shop_area"></div>
                                                                    </span>

                                                                    <span>

                                                                    <small>Price</small>
                                                                    <div class="shop_price"></div>
                                                                    </span>

                                                                    <span>
                                                                    <small>Floor</small>
                                                                    <div Class="shop_floor"></div> 
                                                                    </span>
                                                                    <span>
                                                                    <small>Car Parking</small>
                                                                    <div Class="shop_car"></div> 
                                                                    </span> 
                                                              </div>
                                                              @endif
                                                            </div>
                                                        </div>
                                                       </div>
                                            </div>
                                             
                                            <a href="detail/{{ $value->url_name }}"><p style="color:black;">
                                              {{ App\Http\Controllers\ListingController::getExcerpt($value->l_description) }}</p></a>
                                            <div class="reranum">Rera No: 
                                              <a href="https://gujrera.gujarat.gov.in/" target="_blank" style="color:green"class="rera_text" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Property Details">
                                              {{ $value->rera_number }}
                                              </a>
                                            </div>
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
                                  
                              @elseif($value->l_category == '5')
                              <div class="col-sm-6">
                              <div class="h-listing-box skills">
                              <div class="content "> 
                              <h4>Name :{{ $value->first_name .' '.$value->last_name }}</h4> 
                              <div class="row">
                              <div class="col-sm-6"><p>Skill :{{ $value->name }}</p></div>
                              <div class="col-sm-6"><p>Contact :{{ $value->Phone }}</p></div>
                              <div class="col-sm-6"><p>Age : {{ $value->age_details }}</p></div>
                              <div class="col-sm-6"><p>Experiance : {{ $value->experience_details }}<p></div>
                              <div class="col-sm-6"><p>Adhar : {{ $value->adharnumber_details }}</p></div>
                              </div>
                              </div>
                              </div>
                              </div>
                                    @elseif($value->l_category == '4' && $value->l_status == '1') 
                                    <div class="col-sm-12">
                                    <div class="h-listing-box">
                                    
                                        <figure>   
                                          <?php 
                                      $directory = "public/images/".$value->vl_id."/featured_image/";
                                      
                                      if(is_dir($directory) && count(glob("$directory/*")) !== 0){
                                            $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                            $img = '';
                                            foreach ($files as $key => $value_image) { ?>  

                                        <?php if($value->l_prime== 1){ ?>
                                                    <div class="listing-img-pro">
                                                      <div class="featured-cvr">
                                                        <h6>Premium</h6>
                                                       </div>
                                                      <img  src="{{url('/')}}/public/images/{{$value->vl_id}}/featured_image/featured_image.jpg" alt="featured_image">
                                                    </div> 
                                              <?php } else {  ?>

                                                 <div class="listing-img-pro">
                                                     
                                                       <img  src="{{url('/')}}/public/images/{{$value->vl_id}}/featured_image/featured_image.jpg" alt="featured_image">
                                                    </div>
                                                        
                                                  <?php } ?>

                                          
                                          <?php } } else { ?>
                                          <img src="{{url('/')}}/public/images/noimage.png"  class="prodctimg">
                                          <?php } ?>
                                            <div class="like" onclick="">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </figure>   
                                            
                                        <div class="content">
                                             <a href="detail/{{$value->url_name}}">
                                            @if($value->l_title == "")

                                             <h4>{{ucfirst($value->url_name)}}</h4>
                                             @else
                                             <h4>{{ucfirst($value->l_title)}}</h4>

                                             @endif
                                           </a>
                                        </div>
                                         <?php if($_GET['s_category'] == '4'){ ?> 
                                         @if($value->l_category==4)
                                        @foreach(explode(',', $value->l_sub_category) as $info)                                           
                                            <span class="bbg">
                                            {{ ucfirst($typeProcess[$info]) }}
                
                                            </span>
                                        @endforeach
                                       @endif
                                     <?php } ?>


                                
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
                                        <a href="detail/{{$value->url_name}}">
                                          <i class="fa fa-map-marker"></i> {{ $value->l_nearby }}
                                        </a>
                                      </div>
                                    </div>
                                </div>
                                    @if($kk % 2 == 0 && $value->l_category == '4' && $value->l_status == '1')
                                        </div>
                                    @elseif($value->l_category == '4' && $value->l_status == '1')
                                    @endif
                                    @else
                                    @if($value->l_category == '1' && $value->l_status == '1')
                                    <div class="h-listing-box">
                                      <a href="detail/{{ $value->url_name}}" class="onclick">
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
                                            <div class="like" onclick="saveListing('listing_{{$value->vl_id}}')">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </figure>
                                      </a>
                                        <div class="content">
                                            @if(isset($value->url_name) && $value->url_name != "")
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->url_name }}" class="onclick"><h4>{{$value->l_title}}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->url_name }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @else
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->vl_id }}" class="onclick"><h4>{{$value->l_title}}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->vl_id }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @endif
                                            <a href="detail/{{ $value->url_name}}" class="onclick"><p>{{ App\Http\Controllers\ListingController::getExcerpt(ucfirst($value->l_description)) }}</p></a>
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
                                                <i class="fa fa-map-marker"></i> {{ $value->l_nearby }}
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($value->l_category == '2' && $value->l_status == '1')
                                     <div class="h-listing-box">
                                      
                                        <figure>
                                            <?php
                                                $directory = "public/images/".$value->vl_id."/featured_image/";
                                                $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                }
                                            ?>
                                            <?php if($value->l_prime== 1){ ?>
                                                  <div class="listing-img-pro">
                                                      <div class="featured-cvr">
                                                        <h6>Premium</h6>
                                                       </div>
                                                      <img src="{{ $directory.$img }}" alt="Popular Listing">
                                                  </div>
                                                <?php } else { ?>
                                                  <div class="listing-img-pro">
                                                      <img src="{{ $directory.$img }}" alt="Popular Listing">
                                                  </div>

                                                  <?php } ?>
                                            <div class="like" onclick="saveListing('listing_{{$value->vl_id}}')">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </figure>
                                     
                                        <div class="content">
                                            @if(isset($value->url_name) && $value->url_name != "")
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->url_name }}" class="onclick"><h4>{{$value->l_title}}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->url_name }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @else
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->vl_id }}" class="onclick"><h4>{{ucfirst($value->l_title)}}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->vl_id }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @endif
                                            <a href="detail/{{ $value->url_name}}" class="onclick">
                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt(ucfirst($value->l_description)) }}</p>
                                          </a>
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $value->l_view)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="fa fa-star-o"></i>
                                                    @endif
                                                @endfor
                                                <span>( {{ $value->l_view }} Count )</span>
                                            </div>
                                            <div class="address">
                                                <i class="fa fa-map-marker"></i> {{ ucfirst($value->l_nearby) }}
                                            </div>
                                        </div>
                                    </div>
                                     @elseif($value->l_category == '3' && $value->l_status == '1')
                                     <div class="h-listing-box">
                                        <figure>
                                            <?php
                                                $directory = "public/images/".$value->vl_id."/featured_image/";
                                                $directory_no_image = "public/images/noimage.png"; 
                                                $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                }
                                            ?>
                                            <?php if($directory){ ?>
                                            <?php if($value->l_prime== 1){ ?>

                                                    <div class="listing-img-pro">
                                                      <div class="featured-cvr">
                                                        <h6>Premium</h6>
                                                       </div>
                                                      <img src="{{ $directory.$img }}" alt="Popular Listing">
                                                    </div>
                                            <?php } else { ?>
                                            <img src="{{ $directory.$img }}" alt="Popular Listing">
                                          <?php } ?>
                                          <?php } else { ?>
                                            <img src="{{ $directory_no_image }}" alt="Popular Listing">
                                            <?php } ?>
                                            <div class="like" onclick="saveListing('listing_{{$value->vl_id}}')">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </figure>
                                        <div class="content">
                                            @if(isset($value->url_name) && $value->url_name != "")
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->url_name }}" class="onclick"><h4>{{$value->l_title}}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->url_name }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @else
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->vl_id }}" class="onclick"><h4>{{$value->l_title}}</h4></a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->vl_id }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @endif
                                            <a href="detail/{{ $value->url_name}}" class="onclick"><p>{{ App\Http\Controllers\ListingController::getExcerpt(ucfirst($value->l_description)) }}</p>
                                            </a>
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $value->l_view)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="fa fa-star-o"></i>
                                                    @endif
                                                @endfor
                                                <span>( {{ $value->l_view }} Count )</span>
                                            </div>
                                            <div class="address">
                                                <i class="fa fa-map-marker"></i> {{ ucfirst($value->l_nearby) }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                               <?php $kk++; $w++;} ?>
                                 <div class="col-sm-12">
                               
                              </div>
                            <?php } else { ?>
                            <div class="content">
                        <div class="text-center" style=" margin-top: 80px;"><img src="{{url('/')}}/public/images/no-result-found.jpg" alt="noimage"></div>
                        <h2 style="text-align:center; margin-top: 30px;"> That's a miss
                        </h2> 
                        <p class="text-center">Sorry,that filter combination has no results.<br>Please try different criteria. 
                        </div>
                            <?php } ?>
                    </div>
               </div>
           </div>
<!--Popular  listing end-->
           </div>
           <div class="col-sm-4  product-listing-right">
            <div id="map"></div>
           </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ignismyModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close c_this" data-dismiss="modal" aria-label=""><span>×</span></button>
             </div>
            <div class="modal-body">     
    <div class="thank-you-pop">
      <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="Green-Round-Tick">
      <h1>Thank You!</h1>
      <p>Your submission is received and we will contact you soon</p>
    </div>       
          </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
<script src="{{ asset('public/js/select2.full.min.js') }}"></script>
<!-- main content end-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>
  
  
$(document).ready(function(){
 $('.user').blur(function(){
  var error_email = '';
  var email = $('.user').val();
  var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"{{url('/')}}/check_phone",
    method:"POST",
    data:{phone:email, _token:_token},
    success:function(result)
    {
     if(result == 'not_unique')
     {
      $('#error_user').html('<label class="text-danger">This Mobile number is alredy registered</label>');
      $('.user').removeClass('has-error');
      $('#submits').attr('disabled', 'disabled');
     }
     else
     {
      $('#error_user').html('');
       $('#submits').attr('disabled', false);
     }
    }
   })
 });
});












    $(".shop").on('click', function() {
    
      var id = $(this).attr("id");
      $(this).parent().parent().parent().find('.shop_sqyrd').css('display','block');
      $(this).parent().parent().parent().find('.3bhk').css('display','none');
      $(this).parent().parent().parent().find('.2bhk').css('display','none');
      var a = $(this).parent().parent().parent().find(".hdnvalue").val();

      $(this).parent().parent().parent().find('.shop_info').css('display','block');
      $(this).parent().parent().parent().find('.www').css('display','none');

      var price = $(this).data("shop_price");
      var area = $(this).data("shop_area");
      var washroom = $(this).data("shop_washroom");
      var car = $(this).data("shop_car_parking");
      var floor = $(this).data("shop_floor");

      if(id == a){
      $(this).parent().parent().parent().find('.shop_area').text(area);
      $(this).parent().parent().parent().find('.shop_price').text(price);
      $(this).parent().parent().parent().find('.shop_floor').text(floor);
      $(this).parent().parent().parent().find('.shop_car').text(car);
      }
      });

    jQuery(document).ready(function(){

      $('.shop_info').css('display','none');
         //BHK Click
      $(".bhk_class").on('click', function() {

        $(this).parent().parent().parent().find('.3bhk').css('display','block');
        $(this).parent().parent().parent().find('.2bhk').css('display','block');
        $(this).parent().parent().parent().find('.shop_info').css('display','none');
        $(this).parent().parent().parent().find('.www').css('display','block');

        //Get current id
        var bhkid = $(this).attr('id');
        //Split the id
        var splitid = bhkid.split('_');
        //Hide all the li
        $(".detailtab2_"+splitid[1]+" li").hide();
        //Show all the clicked li
        $(".detailtab2_"+splitid[1]+" ."+bhkid).show();
        //Show first record
        $( ".detailtab2_"+splitid[1]+" .bhk_"+splitid[1]+"_"+splitid[2]+" .sqft_click").first().trigger('click');
      });
      $(".sqft_click").on('click', function() {
        //Get Current ID
        var sqftid = $(this).attr('id');
        //Split the id
        var sqftsplitid = sqftid.split('_');

        $('.shop_info').css('display','none');
        $('.www').css('display','block');
        //Hide all the li
        $(".detail2_"+sqftsplitid[1]+" .property_detail").hide();
        //Show all the clicked li
        $(".detail2_"+sqftsplitid[1]+" #property_detail_"+sqftsplitid[1]+"_"+sqftsplitid[2]+"_"+sqftsplitid[3]).show();
      });
      $('.product-listing-right').css('height', $('.service-list').height() + 200);
      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    });
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
    jQuery(".listingbtn").on('click',function() {
        jQuery(".gridview").hide();
        jQuery(".listingview").show();
        jQuery(".gridbtn").removeClass('active');
        jQuery(".listingbtn").addClass('active');
    });
    jQuery(".gridbtn").on('click',function() {
        jQuery(".listingview").hide();
        jQuery(".gridview").show();
        jQuery(".listingbtn").removeClass('active');
        jQuery(".gridbtn").addClass('active');
    });
    jQuery("#l_category").on('change',function(){
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
</script>
<script>
      function getPredefineSelection() {
        var keyword = jQuery("#s_key").val();
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getSelectionInfo')}}?keyword="+keyword,
            success:function(data){
                if (data === false || data === 'no_action') {
                    $("#l_category").val('').change();
                    $("#s_type").val('').change();
                } else {
                    //Grab the category value
                    var cate = $("l_category").val();
                    var s_type = $("s_type").val();
                    if (cate !== data.category_id) {
                        $("#l_category").val(data.category_id).change();
                    }
                    if (s_type !== data.sub_cate_id) {
                        setTimeout(function(){ $("#s_type").val(data.sub_cate_id).change(); }, 2000);
                    }
                }
            }
        })
    }
    function initMap() {
      var locations = [
          <?php if(isset($array)) { foreach($array as $key) {
            if($key['lat'] != '') { ?>
              {
                lat: <?php echo $key['lat'] ?>,
                log: <?php echo $key['log'] ?>,
                type: 'info',
                address: '<?php echo $key['address']; ?>',
                url : '<?php echo $key['url'] ?>'
              },
          <?php }
        } }?>
      ];
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(23.0225, 72.5714),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f5f5"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#bdbdbd"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "poi.business",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#757575"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dadada"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#616161"
      }
    ]
  },
  {
    "featureType": "road.local",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  },
  {
    "featureType": "transit",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e5e5e5"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#eeeeee"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#c9c9c9"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9e9e9e"
      }
    ]
  }
]
    });
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i].lat, locations[i].log),
        map: map
      });
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i].address);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
    }
  </script>
  <script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIU0AkBLdVGjo4oTQm3R5kyYC6uhNdMLs&libraries=places&callback=initMap">
</script>
<script src="public/js/jquery.copy-to-clipboard.js"></script>
<script>
 $('.rera_text').click(function(){
        $(this).CopyToClipboard();
    });
</script>
<script>
     $("#s_city").on('change',function(){
        var City_Id = $(this).val(); 
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if (data) {
                    $("#state").empty();

                    $("#state").append('<option value="">Select Area</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                        
                    });
                }
            }
        })
    });
    jQuery("#l_category").on('change',function(){
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


    var ltName = getCookie('Info');
    if (ltName == '') {

$(window).on('load',function(){
        $('#myOTR').modal('show');
         $('.firstBlur').addClass('modalBlur');
    });


        $(".modal fade").css("display", "block");
        $(".modal fade").css("opacity", "10");
        $(".modal fade").css("pointer-events", "auto");

    }
    else {
        $("#myOTR").modal('hide');
        $(".modal fade").css("opacity", "0");
        $(".modal fade").css("pointer-events", "none");
    }


    $.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a valid mobile number');


  $("#super_submit").validate({
    rules: {
      txtname:{
       required: true,
      },
      txtnumber: {
        required: true,
        regex: '^([+][9][1]|[9][1]|[0]){0,1}([6-9]{1})([0-9]{9})$'
      },
      txtcity: {
        required: true,
      },
      cat:{
        required: true,
      },
    },
    messages: {
      txtname: {
        required: "Name is required",
      },
      txtnumber: {
        required: "Mobile number is required",
      },
       txtcity: {
        required: "City name is required",
      },
      cat: {
        required: "Category is Required",
      },
    },
    errorElement : 'div',
      errorLabelContainer: '.error',
      submitHandler: function() {
        $.ajax({
          url:"{{url('/')}}/otradd_form",
          type: 'post',
          data: $('#super_submit').serialize(),
          success: function(result){
             if(result == 'success')
              {
              setCookie('Info', result, 365);
              $("#myOTR").modal('hide');
              $('#ignismyModal').modal('show');
            }
          },error: function(err){

          }
        });  
      }    
    });
$("#close_modal").click(function(){
   $('#myOTR').modal('toggle');
    $('.firstBlur').removeClass('modalBlur');
});    
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
    $(function () {
        $('.select2').select2()
    });
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
    $( document ).ready(function() {
      var city= $( "#s_city option:selected" ).text().trim();
       $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+city,
            success:function(data){
                if (data) {
                    $("#state").empty();
                    $("#state").append('<option value="">Select Area</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                    var area ="";
                    area =$.urlParam('area').replace(/\+/g,' ');
                    if(area != ""){
                        $("#state").val(area);
                        } 
                        else{
                          $ ("#state").val($("#target option:first").val());
                        }
                }
            }
        })
        
   $.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
    }
});

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};


</script>
<script>
  $(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });
 $('.c_this').on('click',function() {
    
 $('.firstBlur').removeClass('modalBlur');
});
</script>
@include('footer')