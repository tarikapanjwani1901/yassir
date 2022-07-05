@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Advertise
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
    <h1>Book Visit</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Book Visit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        Book Visit
                    </h4>
                </div>

                <br>

                <div class="panel-body">
                 <div class="table-responsive productimges">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                            <tr class="filters">
                                <th>Property Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Booking Date</th>
                                <th>Timing</th>
                                <th>Action</th>
                            </tr>
                       </thead>
                       <tbody>
                        <?php // echo "<pre>"; print_r($product); exit; ?>
                            @if(count($bookvisit))
                            @foreach($bookvisit as $bv)
                                <tr id="tr_{{$bv->id}}">
                                   <td>{{$bv->l_title}}</td> 
                                   <td>{{$bv->name}}</td> 
                                   <td>{{$bv->email}}</td> 
                                   <td>{{$bv->contact}}</td> 
                                   <td>{{date("d/M/Y", strtotime($bv->book_date))}}</td> 
                                   <td>{{date("h:i A", strtotime($bv->book_from_time))}} - {{ date("h:i A", strtotime($bv->book_to_time)) }}</td> 
                                   <td><a href="#" class="btn btn-danger btn-info btn-lg onclick" data-id="{{ $bv->id }}" data-toggle="modal" data-target="#myModal">Delete</a></td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                              <td colspan="7">No result found</td>
                            @endif
                       </tbody>
                    </table>
                 </div>
                </div>
           </div>
           {{ $bookvisit->links() }}
        </div>
    </div>    <!-- row-->

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Book Visit</h4>
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
        var bvID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'bookvisit/delete/'+bvID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+bvID).css('display','none');
                }
           }
        });
    });
</script>
@stop