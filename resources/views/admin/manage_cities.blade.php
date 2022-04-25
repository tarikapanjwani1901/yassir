@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Reviews
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
    <h1>Manage Cities</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Manage Citys</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
    <form action="search" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        <div class="input-group">
            
            
        
            <input type="search" name="search" class="form-control" placeholder="Search" value="<?php
             if(isset($_GET['search'])){ echo $_GET['search']; } ?>">
            <span class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Search</button>
               <a href="{{url('/admin/managescitys')}}" data-toggle="tooltip" title="reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            </span>
             <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
        </div>
    </form>
</div>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
            
        <div class="portlet box warning">
            <!-- <div class="portlet-title">
                <div class="caption">
                    <div align="right">
                        <a href="{{ URL::to('admin/managescitys/create_cities') }}" class="btn btn-sm btn-default">
                            <span class="glyphicon glyphicon-plus"></span> Add</a></div>
                </div>
            </div> -->
            <div class="portlet-body">

                <div class="table-responsive">
                        <table class="table table-bordered" id="printableArea">
                       
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>City Name</th>
                                <th>Status</th>
                                <th class="ac">Action</th>
                            </tr>
                        </thead>
                         <tbody>
                            @php $i = ($city_info->currentpage()-1)*$city_info->perpage() + 1 @endphp
                           @if(count($city_info))
                            
                                @foreach($city_info as $s)
                                    <tr id="tr_{{$s->City_Id}}">
                                        <td>{{$i++}}</td>
                                        <td>{{$s->City_Name}}</td>
                                         <td>{{$s->status}}</td>
                                        <td class="ac">
                                            @if($s->status == "in-active") 
                                            <a href="" data-toggle="modal" data-target="#tes_delete_confirm" data-id="{{ $s->City_Id }}" class="onclick default btn btn-success active" style="width:80px;" >  Active
                                            </a>
                                            <input type="hidden" name="cid" id="cid" value="">
                                            @endif
                                            @if($s->status == "active") 
                                            <a href="" data-toggle="modal" data-target="#tes_delete_confirm" data-id="{{ $s->City_Id }}" class="onclick default btn btn-delete inactive">   
                                            Deactive
                                            </a>
                                            <input type="hidden" name="cid" id="cid" value="">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">No result found</td>
                                </tr>    
                            @endif
                        </tbody>
                   
                    </table>
                     {{ $city_info->links() }}
                </div>
            </div>
        </div>
    </div>    <!-- row-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Review</h4>
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
<script>
    $(document).on("click", ".onclick", function () {
         var myBookId = $(this).data('id');
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var reviewID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'managescitys/delete/'+reviewID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+reviewID).css('display','none');
                }
           }
        });
    });

    $(".inactive").on('click',function(){
        location.reload();
        var cityids = $(this).data('id');
        $("#cid").val(cityids);
        var ciid = $("#cid").val();
        $.ajax({
           type:'POST',
           url:'managescitys/inactive_city/'+ciid,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                $('.successs').text('akljsbdkajsbdjkasd');
                
           }
        });
    });

    $(".active").on('click',function(){
        location.reload();
        var cityidsg = $(this).data('id');
        $("#cid").val(cityidsg);
        var ciidss = $("#cid").val();
        $.ajax({
           type:'POST',
           url:'managescitys/active_city/'+ciidss,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                 $('.successs').text('akljsbdkajsbdjkasd');
           }
        });
    });

$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});
</script>
<script src="{{asset('public/assets/js/table2excel.js')}}"></script>
<script type="text/javascript">
$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "Cities_details"
                });
            });
</script>
@stop