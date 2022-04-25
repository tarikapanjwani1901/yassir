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
    <h1>Generate Invoice(All User)</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Generate Invoice</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
    <form action="skill_search" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company Name</th>
                                <th>Expiry Date</th>
                                <th>Expiry Date1</th>
                                
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $count = ($users->currentpage()-1)*$users->perpage() + 1;?>
                            
                            @if(count($users))
                            @foreach($users as $skill_detail)
                            <tr id="tr_{{ $skill_detail->id }}">
                             <td>{{ $count++ }}</td>
                            <td>{{ $skill_detail->first_name }}</td>
                            <td>{{ $skill_detail->email }}</td>
                            <td>{{ $skill_detail->company_name }}</td>
                             <td>{{ $skill_detail->expiry_date }}</td>
                             <td>{{ $skill_detail->notify_date }}</td>

                            <td>
                            <a href="manage_invoice/edit/{{ $skill_detail->id }}" class="btn default btn-edit">Add Invoice</a>

                            @if($skill_detail->u_id)
                             <a href="invoice/{{ $skill_detail->id }}" class="btn btn-edit"><i class="fa fa-files-o" aria-hidden="true"></i> Invoice</a>

                             <a href="javascript:void(0);" class="btn btn-delete onclick" data-toggle="modal" data-target="#tes_delete_confirm" data-id="{{ $skill_detail->invoiceid }}">Delete</a>
                            @endif

                            </td>    

                            </tr>
                            @endforeach    
                            @else
                            <tr>
                                <td colspan="10">No records found</td>
                            @endif
                            
                            </tbody>


                        </table>
                      {{ $users->links() }}
                        
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
      <h4 class="modal-title" id="myModalLabel">Delete Invoice </h4>
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
           type:'GET',
           url:'manage_invoice/delete/'+reviewID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    location.reload();
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+reviewID).css('display','none');
                }
           }
        });
    });
</script>
@stop
