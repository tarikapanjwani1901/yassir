@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Report
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
    <h1>All Listing</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Listing Report</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="portlet box warning">
            <div class="portlet-title">
                <div class="caption">
                    All Listing
                </div>
            </div>
            <div class="">
                <form class="reportform padd15">
                    <select name="category" id="category">
                        <option value="">Select Category</option>
                        @foreach($category as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>

                    <select name="sub_cat" id="sub_cat">
                        <option value="">Select Sub Category</option>
                    </select>

                    <select name="vendor" id="vendor">
                        <option value="">Select Vendor</option>
                        @foreach($data as $d)
                            @if ($rid == $d->id)
                                 <option value="{{ $d->id }}" selected>{{$d->user_company}}</option>
                            @else
                                <option value="{{$d->id}}">{{$d->user_company}}</option>
                            @endif
                        @endforeach
                    </select>

                     <select name="listing" id="listing" hidden>
                        <option value="">Select Listing</option>
                    </select>

                    <select name="review" id="review">
                        <option value="">Select Reviews</option>
                        @for($i=5;$i>=1;$i--)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>

                    <input type="button" value="Submit" id="submit">
                </form>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable" id="property" hidden>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Bedroom</th>
                                <th>Bathroom</th>
                                <th>Super Area</th>
                                <th>Carpet Area</th>
                                <th>Floor</th>
                                <th>Rating</th>
                                <th>Reviewer Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
                <div class="table-scrollable" id="consultancy" hidden>
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Location</th>
                                <th>NearBy</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Listed By</th>
                                <th>Rating</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody id="consultancy_body">

                        </tbody>
                    </table>
                </div>
                <div class="table-scrollable" id="product" hidden>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Product Price</th>
                                <th>Product Quantity</th>
                                <th>Product Details</th>
                                <th>Product Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody id="product_body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    <!-- row-->

</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});
$(document).ready(function (){
    function getdata()
    {
        var vendor=$("#vendor").val();
        var review=$('#review').val();
        var category=$('#category').val();
        var sub_cat=$('#sub_cat').val();

        if (vendor !== '') {
            $("#listing").show();

            $.ajax({
                method:'POST',
                url:'/admin/report',
                data:{v:vendor,r:review,c:category,sc:sub_cat},
                success:function(data)
                {
                    $("#listing").empty();
                    $("#listing").append('<option value="">Select Listing</option>');
                    $('#listing').append($.parseJSON(data).select);
                }
            });
        } else {
            $("#listing").empty();
            $("#listing").append('<option value="">Select Listing</option>');
        }
    }

    function getd()
    {
        var vendor=$("#vendor").val();
        var review=$('#review').val();
        var category=$('#category').val();
        var sub_cat=$('#sub_cat').val();

        $.ajax({
            method:'POST',
            url:'/admin/report',
            data:{v:vendor,r:review,c:category,sc:sub_cat},
            success:function(data)
            {
                if(category==4)
                {

                    $('#product').show();
                    $('#product_body').html($.parseJSON(data).rec);
                    $('#property').hide();
                    $("#listing").hide();
                    $('#consultancy').hide();
                }
                else if(category==2 || category==3)
                {
                    $('#consultancy').show();
                    $('#consultancy_body').html($.parseJSON(data).rec);
                    $('#property').hide();
                    $("#listing").hide();
                    $('#product').hide();
                }
                else
                {
                    $('#property').show();
                    $('#tbody').html($.parseJSON(data).rec);
                    $('#product').hide();
                    $('#consultancy').hide();
                    $('#product').hide();
                }
            }
        });

    }
    $('#vendor').change(getdata);
    $('#submit').click(getd);

});

jQuery("#category").on('change',function(){
        var category="";
        var cat=$('#category').val();

        if (cat != '') {
            $.ajax({
                type:"GET",
                dataType: "json",
                url:"{{url('/admin/report/add/sub')}}?category="+this.value,
                success:function(data){
                    if ( data ) {
                        $('#sub_cat').show();
                        //Empty Drop Down
                        $("#sub_cat").empty();
                        $("#sub_cat").append('<option value="">Select Sub Category</option>');
                        $.each( data, function( key, value ) {
                            $("#sub_cat").append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                }
            })

            //Populate Vendor Drop Down
            $.ajax({
                type:"GET",
                dataType: "json",
                url:"{{url('/admin/report/add/vendor')}}?category="+this.value+"&sub_cat=",
                success:function(data){
                    if ( data ) {
                        //Empty Drop Down
                        $("#vendor").empty();
                        $("#vendor").append('<option value="">Vendor</option>');
                        $.each( data, function( key, value ) {
                            $("#vendor").append('<option value="'+value.user_id+'">'+value.user_company+'</option>');
                        });
                    }
                }
            })

            //Rest the listing drop down
            $("#listing").empty();
            $("#listing").append('<option value="">Select Listing</option>');

        } else {
            $("#sub_cat").empty();
            $("#sub_cat").append('<option value="">Sub Category</option>');
        }


    });

$("#sub_cat").on('change',function(){

    var cat = $('#category').val();
    var sub_cat = $("#sub_cat").val();

    $.ajax({
        type:"GET",
        dataType: "json",
        url:"{{url('/admin/report/add/vendor')}}?category="+cat+"&sub_cat="+sub_cat,
        success:function(data){
            if ( data ) {
                //Empty Drop Down
                $("#vendor").empty();
                $("#vendor").append('<option value="">Select Vendor</option>');
                $.each( data, function( key, value ) {
                    $("#vendor").append('<option value="'+value.user_id+'">'+value.user_company+'</option>');
                });
            }
        }
    })

    //Rest the listing drop down
    $("#listing").hide();
    $("#listing").empty();
    $("#listing").append('<option value="">Select Listing</option>');
});

</script>
@stop