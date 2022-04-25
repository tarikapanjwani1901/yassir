@include('header')
<div id="main" class="inner-content  product-detail1">
      <div class="commonttl-subttl paddtop">
         <!--   <div class="lightttl">Catalog of Categories</div>-->
            <h2>Labor Details</h2>


        </div>
<div class="container-fluid">

 

 
    <!--repet this in loop-->
    @foreach($skill as $d)
    <div class="col-sm-12">
    <div class="detailbox">
      <div class="like-product" onclick="saveListing('listing_{{$d->vl_id}}')">
      <span> <i class="fa fa-heart"></i> </span>
    </div>
      <div class="row">
         <div class="col-sm-5 text-center">
          <figure>
          
              
                <img src="{{url('/')}}/public/images/noimage.png">
            
             </figure>
          </div>
          <div class="content">
            <h3>Name: {{$skill[0]->first_name.' '.$skill[0]->last_name}}</h3>
              

              <div class="price">
                Email Details : <a href="mailto:{{$d->email}}">{{ $d->email }}</a>
              </div>
              <div class="price">
                Contact Details : <a href="tel:{{$d->Phone}}">{{ $d->Phone }}</a>
              </div>
              <div class="price">
                Skill Details : {{ $d->name }}</a>
              </div>
              <div class="price">
                Experiance Details : {{ $d->experience_details }}</a>
              </div>
               <div class="price">
                Age Details : {{ $d->age_details }}</a>
              </div>
               <div class="price">
                Adhar Details : {{ $d->adharnumber_details }}</a>
              </div>
              <?php if(!empty($d->city)){ ?>
              <div class="address">
                  <i class="fa fa-map-marker"></i> {{ ucfirst($d->city) }}
             </div>
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
      </div>
    </div>
    @endforeach
    <!-- till here-->
       <!--repet this in loop-->
    <!-- till here-->
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