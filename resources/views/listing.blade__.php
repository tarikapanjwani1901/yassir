@include('header')

<!--main content-->
<div id="main" class="inner-content  product-listing">
    <div class="container-fluid">
       <div class="row">

           <div class="col-sm-8 product-listing-left">
             <!-- search form-->
             <div class="col-sm-12 servicespage-detail">
             <div class="searchbox">
                    <form>
                        <input type="text" name="s_key" id="s_key" class="s_key" value="{{ $s_key }}" onkeyup="getPredefineSelection()" placeholder="Requirement">
            <select id="l_city" name="s_city">
                <option value="">City</option>
                    @foreach($city as $ck => $cv)
                        @if($cv != '')
                            @if( $ck == $_GET['s_city'])
                                <option value="{{ $ck }}" selected>{{ $cv }}</option>
                            @else
                                <option value="{{ $ck }}">{{ $cv }}</option>
                            @endif
                        @endif
                    @endforeach
            </select>
            <select id="l_category" name="s_category" required>
              <option value="">Category</option>
              <option value="1" <?php if($_GET['s_category'] == '1'): ?> selected="selected"<?php endif; ?>>Properties </option>
              <option value="2" <?php if($_GET['s_category'] == '2'): ?> selected="selected"<?php endif; ?>>Consultancy </option>
              <option value="3" <?php if($_GET['s_category'] == '3'): ?> selected="selected"<?php endif; ?>>Contractor</option>
              <option value="4" <?php if($_GET['s_category'] == '4'): ?> selected="selected"<?php endif; ?>> Material</option>
              <option value="5" <?php if($_GET['s_category'] == '5'): ?> selected="selected"<?php endif; ?>> Skill labour</option>
            </select>
            <select id="s_type" name="s_type" required>
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
                if (!$result->isEmpty()) {

                    $array = array();
                    foreach ($result as $key => $value) {

                        $address = $value->l_location;
                        $ex = explode(',',$address);

                        $a = array();
                        foreach ($ex as $key => $value) {
                            $a[] = trim($value);
                        }

                        $im = implode(',<br>',$a);

                        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=true&key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY');
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
                    <div class="col-sm-12">
                        <?php
                            if (!$result->isEmpty()) {
                                 $k = 1;
                                foreach ($result as $key => $value) { ?>
                                    @if($k % 2 == 0 && $value->l_category == '4')
                                    @elseif($k % 2 != 0 && $value->l_category == '4')
                                        <div class="col-sm-12">
                                    @endif
                                    <?php

                                    $check = '';
                                    if (Sentinel::check() && (Sentinel::inRole('admin') || Sentinel::inRole('sales-team'))) {
                                        $check = '1';
                                    } else {
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
                                    <div class="h-listing-box">
                                        <figure>
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
                                                @if($value->price != '0')
                                             &#8377; {{ $value->price }} lacs
                                                @endif
                                            </div>
                                        </figure>
                                        <div class="content">

                                            @if(isset($value->url_name) && $value->url_name != "")
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->url_name }}" class="onclick">{{$value->l_title}}</a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->url_name }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @else
                                            <?php
                                                if ($check == '1') { ?>
                                                    <a href="detail/{{ $value->vl_id }}" class="onclick">{{$value->l_title}}</a>
                                                <?php } else { ?>
                                                    <a href="#" data-id="detail/{{ $value->vl_id }}" class="onclick" data-toggle="modal" data-target="#myOTP"><h4>{{ $value->l_title }}</h4></a>
                                                <?php }
                                            ?>
                                            @endif

                                            <div class="detail">
                                              <span>
                                                <small>Built Up area</small>
                                                  {{ $value->super_area }} Sqyrd
                                              </span>
                                                <span>
                                                <small>Status</small>
                                                  {{ $value->status }}
                                              </span>
                                                <span>
                                                <small>Floor</small>
                                                  {{ $value->floor }}
                                              </span>
                                                 <span>
                                                <small>Transaction</small>
                                                  {{ $value->type }}
                                              </span>
                                            </div>
                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($value->l_description) }}</p>

                                            <div class="reranum">Rera No: {{ $value->rera_number }}</div>

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
                                    @elseif($value->l_category == '4')
                                    <div class="col-sm-6">
                                    <div class="h-listing-box">
                                        <figure>
                                            <?php
                                                $pid = (isset($value->pid)) ? $value->pid : $value->id;

                                                $directory = "public/images/product/".$pid;
                                                $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                                $img = '';
                                                foreach ($files as $key => $val) {
                                                    $img = $val;
                                                }
                                            ?>
                                            <img src="{{ $directory}}/{{$img }}" alt="Popular Listing">

                                            <div class="like" onclick="saveListing('product_{{$pid}}')">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </figure>
                                        <div class="content">
                                           @if(isset($value->url_name) && $value->url_name != "")
                                            <a href="product_detail/{{$value->url_name}}/{{ $pid }}"><h4>{{ $value->product_name }}</h4></a>
                                            @else
                                            <a href="product_detail/{{$value->vl_id}}/{{ $pid }}"><h4>{{ $value->product_name }}</h4></a>
                                             @endif
                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($value->product_detail) }}</p>

                                            <div class="price">
                                                @if($value->product_price != '0')
                                                 &#8377; {{ $value->product_price }}
                                                @endif
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
                                                <i class="fa fa-map-marker"></i> {{ $value->l_nearby }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @if($k % 2 == 0 && $value->l_category == '4')
                                        </div>
                                    @elseif($value->l_category == '4')
                                    @endif
                                    @else
                                    <div class="h-listing-box">
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
                                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($value->l_description) }}</p>
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
                                    @endif

                                <?php $k++; } ?>
                                {{ $result->appends($_GET)->links() }}
                            <?php } else { ?>
                            <div class="content">
                                    <?php echo 'No result found.'; ?>
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
<!-- main content end-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<script type="text/javascript">

    jQuery(document).ready(function(){
        $('.product-listing-right').css('height', $('.service-list').height() + 200);
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
<script type="text/javascript">

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
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY&libraries=places&callback=initMap">
</script>

@include('footer')