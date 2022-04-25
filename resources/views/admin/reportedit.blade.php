@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit Report
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
    <h1>Edit Report</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Report</a></li>
        <li class="active">Edit Report</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Report</h4>
                </div>
                <div class="panel-body testimonialedit">

                <form method="post" enctype="multipart/form-data">
                            <fieldset>
                                <!-- Name input-->
                                    @if(isset($report))
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="name">Title</label>
                                        <div class="col-md-10 col-sm-9">
                                        <input id="l_title" name="l_title" type="text" class="form-control" value="{{ $report[0]->l_title }}">
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Location</label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="l_location" name="l_location" rows="5">{{ $report[0]->l_location }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Nearby</label><div class="col-md-10 col-sm-9">
                                        <input id="l_nearby" name="l_nearby" type="text" class="form-control" value="{{ $report[0]->l_nearby }}"></div>
                                    </div>

                                    <!-- Message body -->
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Description</label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="l_description" name="l_description" rows="5">{{ $report[0]->l_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Price</label><div class="col-md-10 col-sm-9">
                                        <input id="price" name="price" type="text" class="form-control" value="{{ $report[0]->price }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Bedroom</label><div class="col-md-10 col-sm-9">
                                        <input id="bedroom" name="bedroom" type="number" class="form-control" value="{{ $report[0]-> bedroom }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Bathroom</label><div class="col-md-10 col-sm-9">
                                        <input id="bathroom" name="bathroom" type="number" class="form-control" value="{{ $report[0]-> bathroom }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Super Area</label><div class="col-md-10 col-sm-9">
                                        <input id="super_area" name="super_area" type="number" class="form-control" value="{{ $report[0]-> super_area }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Carpet Area</label><div class="col-md-10 col-sm-9">
                                        <input id="carpet_area" name="carpet_area" type="number" class="form-control" value="{{ $report[0]-> carpet_area }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Status</label><div class="col-md-10 col-sm-9">
                                        <input id="status" name="status" type="text" class="form-control" value="{{ $report[0]-> status }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Floor</label><div class="col-md-10 col-sm-9">
                                        <input id="floor" name="floor" type="number" class="form-control" value="{{ $report[0]-> floor }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Type</label><div class="col-md-10 col-sm-9">
                                        <input id="type" name="type" type="text" class="form-control" value="{{ $report[0]-> type }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Car Parking</label><div class="col-md-10 col-sm-9">
                                        <input id="car_parking" name="car_parking" type="number" class="form-control" value="{{ $report[0]-> car_parking }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Furnishing</label><div class="col-md-10 col-sm-9">
                                        <input id="furnishing" name="furnishing" type="text" class="form-control" value="{{ $report[0]-> furnishing }}"></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Listed By</label><div class="col-md-10 col-sm-9">
                                        <input id="listed_by" name="listed_by" type="text" class="form-control" value="{{ $report[0]-> listed_by }}"></div>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $report[0]->vl_id }}">
                                    @endif
                                    <div id="product">
                                        @if(isset($product))
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Name <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_name" name="product_name" type="text"  class="form-control" value="{{ $product[0]-> product_name }}"  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Category <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_category" name="product_category" type="text"  class="form-control" value=" {{$product[0]-> product_category }}"  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Price <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_price" name="product_price" type="text" class="form-control" value=" {{ $product[0]-> product_price }}"  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label  col-md-2 col-sm-3" for="name">Product Quantity <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <input id="product_qty" name="product_qty" type="text" class="form-control" value=" {{$product[0]-> product_qty }}"  ></div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Product Details <span style="color:red"> * </span></label><div class="col-md-10 col-sm-9">
                                        <textarea class="form-control" id="product_detail" name="product_detail" rows="5"  >{{ $product[0]-> product_detail }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row label-floating is-empty">
                                        <label class="control-label col-md-2 col-sm-3" for="message">Product Image </label><div class="col-md-10 col-sm-9">
                                        <input id="product_img" name="product_img" type="file" class="form-control" value=""></div>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $product[0]->id }}">
                                    <input type="hidden" name="cat_id" value="{{ $product[0]->cat_id }}">

                                    @endif
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
@stop
