@include('header')
<div id="main" class="inner-content  product-detail1">
      



    <div class="popular-listing-row padd100 related-products">
          <div class="container-fluid">
        <div class="commonttl-subttl">


            <h2>All Products of {{$product_info[0]->l_title}}</h2>
        </div>

            <div class="row">
              @foreach($product_info as $product_infos)
                <div class="col-sm-3">
                    <div class="h-listing-box">
                       <figure>

                             @if($product_infos->product_img) 
                                <img src="{{url('/')}}/public/images/product/{{$product_infos->id}}/{{$product_infos->product_img}}" alt="Popular Listing" class="productimg">
                              @else
                                <img src="{{url('/')}}/public/images/noimage.png" alt="Popular Listing" class="productimg">
                              @endif
                                <div class="btn">
                                  <a href="{{url('/')}}/product_detail/{{$product_infos->url_name}}/{{$product_infos->product_name}}">{{$product_infos->product_name}}
                                 </a>
                                </div>
                                  <div class="like" onclick="saveListing('product_{{$product_infos->id}}')">
                                      <i class="fa fa-heart"></i>
                                  </div>
                            </figure>
                       <div class="content">
                                <a class="h-listing-box" href="{{url('/')}}/product_detail/{{$product_infos->url_name}}/{{$product_infos->product_name}}"><h4>{{$product_infos->product_name}}</h4></a>
                                @if($product_infos->product_price != '0')
                                  <h5>Price: &#8377;{{$product_infos->product_price}}</h5>
                                @else
                                  <h5>For Price Contact Vendor</h5>
                                @endif
                                <p>{{ App\Http\Controllers\ListingController::getExcerpt($product_infos->product_detail) }}</p>
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
  <!-- main content end-->

@include('footer')