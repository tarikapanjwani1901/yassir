@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Category
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
    <h1>All Popular Categories Listing</h1>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>

        <li class="active">All Popular Categories Listing</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
    <form action="property_search" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif

            <div style="color:red;">
                 Notes : use this link listing?s_key=&s_city=&s_category=1&s_type=
            </div>

        
    </form>
</div>
<!-- Main content -->
<section class="content multiple-file_upload paddingleft_right15">
        <div class="">

            <div class="row">
               <div class="portlet box warning">
                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($popular_list))
                            @foreach($popular_list as $property_detail)
                            <tr id="tr_{{ $property_detail->id }}">
                            <td>{{ $property_detail->title }}</td>
                            <td>{{ $property_detail->link }}</td>
                            <td>          

                                 <a href="manage_popular_categories/edit/{{ $property_detail->id }}" class="btn default btn-edit">Edit
                                            </a>      

                                <a href="#" data-toggle="modal" data-target="#tes_delete_confirm"  data-id="{{ $property_detail->id }}" class="onclick btn btn-delete">
                                                Delete
                                </a>    

                                <a class="btn default" href="{{url('/')}}/{{ $property_detail->link }}" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View"></i></a>

                            </td>
                            </tr>
                            @endforeach    
                            @else
                            <tr>
                                <td colspan="10">No records found</td>
                            @endif
                            
                            </tbody>

                        </table>
                       
                        
                    </div>
                </div>
        </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

<div class="modal-dialog" role="document" id="tes_delete_confirm" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Delete Popular Categories</h4>
    </div>
    <div class="modal-body">
        Are you sure?
    </div>
    <input type="hidden" name="bookId" id="bookId" value=""/>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="button" id="btn_ok_1" class="btn btn-primary">OK</button>
    </div>
  </div>
</div>

<script>
    $(document).on("click", ".onclick", function () {
        var myBookId = $(this).data('id');

        $(".modal-dialog #bookId").val(myBookId);
    });

    $("#btn_ok_1").on('click',function(){
        var reviewID = $("#bookId").val();
        //alert(reviewID);
        $.ajax({
           type:'POST',
           url:'manage_popular_categories/delete/'+reviewID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+reviewID).css('display','none');
                }
           }
        });
    });
</script>
@stop