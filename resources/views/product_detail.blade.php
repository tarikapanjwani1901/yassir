@include('header')
<div id="main" class="inner-content  product-detail1">
      <div class="commonttl-subttl paddtop">
         <!--   <div class="lightttl">Catalog of Categories</div>-->
            <h2>{{$detail[0]->product_name}}</h2>
        </div>
<div class="container-fluid">
    <!--repet this in loop-->

    @foreach($detail as $d)
    <div class="col-sm-12">
    <div class="detailbox">
      <div class="like-product" onclick="saveListing('product_{{$d->id}}')">
      <span> <i class="fa fa-heart"></i> </span>
    </div>
      <div class="row">
         <div class="col-sm-5 text-center">
             <figure>
              @if ($d->product_img != '')
                <img src="/public/images/product/{{$d->id }}/{{$d->product_img}}">
              @else
                <img src="/public/images/noimage.png">
              @endif
              <!-- <div class="text-center">

                  <a class="commonbtn" href="#">Get a Best Quote <i class="fa fa-angle-right" aria-hidden="true"></i></a>

              </div> --></figure>
          </div>
          <div class="col-sm-7">
            <h3>{{$d->product_name}}</h3>


              <div class="price">
                @if($d->product_price != '0')
                Approx Price: <strong>{{$d->product_price}} /Piece</strong>
                @else
                For Price Contact Vendor
                @endif
              </div>


               @if($d->product_qty != '0')
              <div class="minumorder">Minimum Order Quantity: <strong>{{$d->product_qty}}</strong> </div> <br>
              @endif
              <p>{{ $d->product_detail }}</p>

              <?php

                $check = '';
                if (Sentinel::check() && (Sentinel::inRole('admin') || Sentinel::inRole('sales-team'))) {
                    $check = '1';
                } else {
                    if (isset($_COOKIE['otp_lists'])) {
                        $explode = explode(',', $_COOKIE['otp_lists']);

                        if (!in_array($d->v_id, $explode)) {
                            $check = '0';
                        } else {
                            $check = '1';
                        }
                    } else if (Sentinel::check() && Sentinel::inRole('vendor') && Sentinel::getUser()->id == $d->v_id ) {
                        $check = '1';
                    } else {
                        $check = '0';
                    }
                }
              ?>

              <div class="text-centr">
                        <a href="/detail/{{$vl_id}}" class="commonbtn onclick">I am interested <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </div>
          </div>

      </div>
      </div>
    </div>
    @endforeach
    <!-- till here-->
       <!--repet this in loop-->
    <!-- till here-->
 </div>
    <div class="popular-listing-row padd100 related-products">
          <div class="container-fluid">
        <div class="commonttl-subttl">

            <h2>Related Products</h2>
        </div>
            <div class="row">
              @foreach($related as $r)
                <div class="col-sm-3">
                    <div class="h-listing-box">
                        <figure>
                          @if (trim($r->product_img) != "")
                            <img src="/public/images/product/{{$r->id }}/{{$r->product_img}}" alt="Popular Listing" class="productimg">
                          @else
                            <img src="/public/images/noimage.png" alt="Popular Listing" class="productimg">
                          @endif
                              <div class="btn">{{$r->product_name}}</div>
                              <div class="like" onclick="saveListing('product_{{$r->id}}')">
                                  <i class="fa fa-heart"></i>
                              </div>
                        </figure>
                        <div class="content">
                            <a class="h-listing-box" href="/product_detail/{{$r->url_name}}/{{$r->product_name }}"><h4>{{$r->product_name}}</h4></a>
                            @if($r->product_price != '0')
                              <h5>Price: &#8377;{{$r->product_price}}</h5>
                            @else
                              <h5>For Price Contact Vendor</h5>
                            @endif
                            <p>{{ App\Http\Controllers\ListingController::getExcerpt($r->product_detail) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    </div>
    </div>
</div>
<script type="text/javascript">
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
</script>
@include('footer')