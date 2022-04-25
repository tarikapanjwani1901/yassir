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
    <h1>Deleted Skill labor</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">Deleted Skill labor</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
</div>
<!-- Main content -->
<section class="content multiple-file_upload paddingleft_right15">
        <div class="">
             <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
            <div class="row">
               <div class="portlet box warning">
                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="printableArea">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Skill</th>
                                <th>Phone</th>
                                <th>Experience</th>
                                <th>Age</th>
                                <th>Adharnumber</th>
                                <th class="ac">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($deleted_skilllabor))
                            @foreach($deleted_skilllabor as $skill_detail)
                            <tr id="tr_{{ $skill_detail->vl_id }}">
                            <td>{{ $skill_detail->first_name }}</td>
                            <td>{{ $skill_detail->name }}</td>
                            <td>{{ $skill_detail->Phone }}</td>
                            <td>{{ $skill_detail->experience_details }}</td>
                            <td>{{ $skill_detail->age_details }} </td>
                            <td>{{ $skill_detail->adharnumber_details }} </td>
                            <td class="ac">
                                

                              

                                <a href="#" data-toggle="modal" data-target="#tes_delete_confirm"  data-id="{{ $skill_detail->vl_id }}" class="onclick btn btn-delete">
                                                Restore
                                </a>    

                            </td>
                            </tr>
                            @endforeach    
                            @else
                            <tr>
                                <td colspan="10">No records found</td>
                            @endif
                            
                            </tbody>

                        </table>
                        {{ $deleted_skilllabor->links() }}
                        
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
      <h4 class="modal-title" id="myModalLabel">Restore Skill labor</h4>
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
        $.ajax({
           url:'skill_labors/restore/'+reviewID,
           type:'get',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+reviewID).css('display','none');
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
                filename: "employee_detail"
                });
            });
</script>
@stop
