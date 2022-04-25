@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Testimonials
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
    <h1>Testimonials</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Testimonials</a></li>
        <li class="active">All List</li>
    </ol>
</section>

<div class="col-md-12 manage-clt">
    <form action="testimonial_search" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        <div class="input-group">                            
            <input type="search" name="testimonial_search" class="form-control" placeholder="Search">
            <span class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Search</button>
               <a href="{{url('/admin/testimonials')}}" data-toggle="tooltip" title="reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>

            </span>

        </div>
        <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
    </form>

</div>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="portlet box warning">
                <div class="portlet-title">
                    <div class="caption">
                       All Testimonials
                    </div>
                </div>
                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="printableArea">
                            <thead>
                            <tr>
                                <th class="ac" align="center">Image</th>
                                <th>Quote</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th class="ac">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($testimonials))
                                <?php foreach ($testimonials as $key => $value) { ?>
                                    <tr id="tr_{{ $value->t_id }}">
                                        <td class="ac" align="center"><img src="../../public/images/testimonial/{{ $value->t_id }}/{{ $value->t_image }}" class="testimonial-user"></td>
                                        <td><?php echo $value->t_quote; ?></td>
                                        <td><?php echo $value->t_name; ?></td>
                                        <td><?php echo $value->t_company; ?></td>
                                        <td class="ac">
                                            <a href="testimonials/edit/{{ $value->t_id }}" class="btn default btn-edit">
                                                Edit
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#tes_delete_confirm"  data-id="{{ $value->t_id }}" class="onclick default btn btn-delete ">
                                                Delete
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>
                                 @else
                            <tr> 
                                <td colspan="10">No records found</td>
                            </tr>
                            @endif

                            </tbody>
                        </table>
                        {{ $testimonials->links() }}
                    </div>
                </div>
        </div>
    </div>    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

<div class="modal-dialog" role="document" id="tes_delete_confirm" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Delete Testimonial</h4>
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
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var testimonialID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'testimonials/delete/'+testimonialID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+testimonialID).css('display','none');
                }
           }
        });
    });
</script>
<script src="{{asset('public/assets/js/table2excel.js')}}"></script>
<script type="text/javascript">
$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "Testimonial_details"
                });
            });
</script>
@stop
