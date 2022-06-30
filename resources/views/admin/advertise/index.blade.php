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
    <h1>Advertisement</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Advertisement</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        Advertisement
                    </h4>
                    <div class="pull-right">
                        <a href="advertise/create" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>

                    </div>
                </div>

                <br>

                <div class="panel-body">
                 <div class="table-responsive productimges">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                          <tr>
                             <th class="ac w1">Title</th>
                             <th class="w2">Vendor Name</th>
                             <th class="ac w7">Actions</th>
                          </tr>
                       </thead>
                       <tbody>
                        <?php // echo "<pre>"; print_r($product); exit; ?>
                            @if(count($advertise))
                            @foreach($advertise as $ad)
                                <tr id="tr_{{$ad->id}}">
                                    
                                    <td class="w2">{{ $ad->title }}</td>
                                    
                                    <td class="w3">{{ $ad->company_name }}</td>
                                   
                                    
                                    <td class="ac w7">
                                        <a href="advertise/edit/{{$ad->id}}" class="btn btn-success">Edit</a>
                                        <a href="#" class="btn btn-danger btn-info btn-lg onclick" data-id="{{ $ad->id }}" data-toggle="modal" data-target="#myModal">Delete</a>
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
           {{ $advertise->links() }}
        </div>
    </div>    <!-- row-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Advertise</h4>
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
        var adID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'advertise/delete/'+adID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+adID).css('display','none');
                }
           }
        });
    });

</script>
@stop