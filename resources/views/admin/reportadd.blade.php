@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add Report
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Add Listing</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> All Listing</a></li>
        <li class="active">Add Listing</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Add Report</h4>
                </div>
                <div class="panel-body testimonialedit">

                <form method="post" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Select Vendor
                                         <span style="color:red"> * </span></label>
                                        <div class="col-md-10 col-sm-9">
                                            <select name="vendor" id="vendor" class="form-control"  >
                                                <option value="">Select Vendor</option>
                                                    @foreach($data as $d)
                                                        @if ($rid == $d->id)
                                                            <option value="{{ $d->id }}" selected>{{$d->user_company}}</option>
                                                        @else
                                                            <option value="{{$d->id}}">{{$d->user_company}}</option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Select Category
                                         <span style="color:red"> * </span></label>
                                        <div class="col-md-10 col-sm-9">
                                            <select name="category" id="category" class="form-control"  >
                                                <option value="">Select Category</option>
                                                    @foreach($category as $c)
                                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty" id="sub" hidden>
                                        <label class="control-label col-md-2 col-sm-3" for="name">Select Sub Category
                                         <span style="color:red"> * </span></label>
                                        <div class="col-md-10 col-sm-9">
                                            <select name="sub_category" id="sub_category" class="form-control"  >

                                            </select>
                                        </div>
                                    </div>
                                <div id="all">
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Title <span style="color:red"> * </span></label>
                                        <div class="col-md-10 col-sm-9">
                                        <input id="l_title" name="l_title" type="text"  class="form-control" value=""  >
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Location <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="l_location" name="l_location" rows="5"  ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Nearby <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="l_nearby" name="l_nearby" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                <div id="pro" hidden>
                                    <!-- Message body -->
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Description <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="l_description" name="l_description" rows="5"  ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Bedroom <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="bedroom" name="bedroom" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Bathroom <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="bathroom" name="bathroom" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Super Area <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="super_area" name="super_area" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Carpet Area <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="carpet_area" name="carpet_area" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Status <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="status" name="status" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Floor <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="floor" name="floor" type="text" pattern="[A-Za-z0-9]+" class="form-control" value=""  ></div>
                                    </div>

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Car Parking <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="car_parking" name="car_parking" type="number" min="0" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Furnishing <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="furnishing" name="furnishing" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Type <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="type" name="type" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Price <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="price" name="price" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>

                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Listed By <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="listed_by" name="listed_by" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                </div>
                                <div id="product" hidden>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Name <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_name" name="product_name" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Category <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_category" name="product_category" type="text"  class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Price <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_price" name="product_price" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Quantity <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_qty" name="product_qty" type="number" min="1" class="form-control" value=""  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Product Details <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="product_detail" name="product_detail" rows="5"  ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Product Image </label><div class="col-md-10 col-sm-9">
                                        <input id="product_img" name="product_img" type="file" class="form-control" value=""></div>
                                    </div>
                                    </div>
                                </div>
                                    <!-- Form actions -->
                                    <div class="form-group">
                                        <div class=" text-right">
                                            <input type="submit" value="Submit" name="submit">
                                        </div>
                                    </div>

                            </fieldset>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript">
     jQuery("#category").on('change',function(){
        var category="";
        var cat=$('#category').val();
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/report/add/sub')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    $('#sub').show();
                    //Empty Drop Down
                    $("#sub_category").empty();

                    $("#sub_category").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#sub_category").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
                if(cat==1)
                {
                    $('#pro').show();
                }
                else
                {
                    $('#pro').hide();

                }
                 if(cat==4)
                 {
                    $('#all').hide();

                    $('#product').show();
                 }
                 else
                 {
                    $('#all').show();
                    $('#product').hide();

                 }
            }
        })
    });
</script>
@stop
