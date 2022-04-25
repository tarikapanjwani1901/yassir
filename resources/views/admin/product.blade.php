@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Products
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Products</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Products</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
    <form action="product_search" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        <div class="input-group">
           <input type="search" name="product_search" class="form-control" placeholder="Search">
            <select name="vendor_name" id="vendor_name" class="reviewselect">
                <option value="">Select Vendor</option>
                @foreach($vendor_list as $d)
                  @if ($vendor_name == $d->id)
                <option value="{{$d->id}}" selected>{{$d->company_name}}</option>
                @else
                <option value="{{$d->id}}">{{$d->company_name}}</option>
                @endif
                @endforeach

            </select>

            <select name="category_name" id="category_name" class="reviewselect">
                <option value="">Select Category</option>


                @foreach($category_list as $category_lists)
                  @if ($category_name == $category_lists->cate_id)
                <option value="{{$category_lists->cate_id}}" selected>{{$category_lists->cate_name}}</option>
                @else
                <option value="{{$category_lists->cate_id}}">{{$category_lists->cate_name}}</option>
                @endif
                @endforeach

            </select>

            <span class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Search</button>
               <a href="{{url('/admin/product')}}" data-toggle="tooltip" title="reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            </span>
             <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
        </div>
    </form>
</div>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        Product
                    </h4>
                    <div class="pull-right">
                        <a href="product/add" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>

                    </div>
                </div>

                <br>

                <div class="panel-body">
                 <div class="table-responsive productimges">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                          <tr>
                             <th class="ac w1">Product Image</th>
                             <th class="w2">Vendor Name</th>
                            
                             <th class="w3">Material Sub Category</th>
                              <th class="w3">Product Sub Category </th>
                               <th class="w4">Product Name</th>
                             
                           
                             <th class="w6">Price & QTY</th>
                             <th class="ac w7">Actions</th>
                          </tr>
                       </thead>
                       <tbody>
                        <?php // echo "<pre>"; print_r($product); exit; ?>
                            @if(count($product))
                            @foreach($product as $pro)
                                <tr id="tr_{{$pro->id}}">

                                    @if (isset($pro->product_img) && $pro->product_img != '')

                                        
                                        <td class="ac w1" align="center"><img src="{{ asset('public/images/product') }}/{{$pro->id}}/{{$pro->product_img}}" class="prodctimg"></td>
                                    @else
                                        <td  align="center"><img src="{{ asset('public/images/noimage.png') }}" class="prodctimg"></td>
                                    @endif
                                    
                                    <td class="w2">{{ $pro->l_title }}</td>
                                    
                                    <td class="w3">{{ $pro->name }}</td>
                                   
                                    @if($pro->cate_name == "")
                                    <td> No Category Available </td>
                                    @else
                                    <td> {{ $pro->cate_name }} </td>
                                    @endif
                                     <td class="w4">
                                        {{$pro->product_name}}
                                    </td>
                                    <td class="w6">
                                        Price: {{ $pro->product_price }} <br>
                                        QTY: {{ $pro->product_qty }}
                                    </td>
                                    
                                    <td class="ac w7">
                                        <a href="product/edit/{{$pro->id}}" class="btn btn-success">Edit</a>
                                        <a href="#" class="btn btn-danger btn-info btn-lg onclick" data-id="{{ $pro->id }}" data-toggle="modal" data-target="#myModal">Delete</a>
                                        <?php $ab = Sentinel::getUser()->id; ?>
                                        

                                        <a class="btn default" href="{{ url('/') }}/product_detail/{{$pro->url_name}}/{{$pro->product_name}}" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Product"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                              <td colspan="10">No result found</td>
                            @endif
                       </tbody>
                    </table>
                 </div>
                </div>
           </div>
           {{ $product->links() }}
        </div>
    </div>    <!-- row-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Product</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <input type="hidden" name="bookId" id="bookId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="btn_ok_1" class="btn btn-primary">Sure</button>
            </div>
        </div>
    </div>
  </div>

</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{asset('public/assets/js/table2excel.js')}}"></script>
<script>
    $(document).on("click", ".onclick", function () {
         var myBookId = $(this).data('id');
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var productID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'product/delete/'+productID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+productID).css('display','none');
                }
           }
        });
    });
$("#btnExport").click(function () {
             $("#printableArea").remove(".ac").table2excel({
            exclude: ".ac",
                name: "Employee data",
            filename: "Product_detail"
            });
        });
</script>
@stop