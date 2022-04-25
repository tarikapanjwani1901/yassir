@include('header')

<div id="main" class="inner-content  product-detail1">
      <div class="commonttl-subttl paddtop">
         <!--   <div class="lightttl">Catalog of Categories</div>-->
            <h2>{{ $category[0]->cate_name}}</h2>
            <span>{{ $category[0]->cate_desc}}</span>
        </div>
<div class="container-fluid">
    <!--repet this in loop-->
     @foreach($category as $k => $d)
    <div class="col-sm-12">
    <div class="detailbox">
    <div class="like-product">
      <span> <i class="fa fa-heart"></i> </span>
    </div>
      <div class="row">
         <div class="col-sm-5 text-center">
             <figure>
              @if ($d->product_img != '')
                <img src="/public/images/product/{{$d->id }}/{{$d->product_img}}" alt="product">
              @else
                <img src="/public/images/noimage.png" alt="noimage">
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
              <div class="minumorder">Minimum Order Quantity: <strong>{{$d->product_qty}}</strong> </div><br>
              @endif


              <p>{{$d->product_detail}}</p>

              <div class="text-centr">
              <a class="commonbtn" href="/detail/{{$vl_id}}">I am interested <i class="fa fa-angle-right" aria-hidden="true"></i></a>

              </div>
          </div>

      </div>
      </div>
    </div>
    @endforeach
 </div>

</div>

  <!-- main content end-->

@include('footer')