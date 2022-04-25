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
    <h1>Invoice information</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Invoice information</li>
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
                                
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(count($users))
                            @foreach($users as $skill_detail)
                            <tr id="tr_{{ $skill_detail->id }}">
                             <td>{{ $skill_detail->id }}</td>
                            <td>{{ $skill_detail->first_name }}</td>
                            <td>{{ $skill_detail->email }}</td>
                            <td>{{ $skill_detail->company_name }}</td>
                            <td>
                            @if($skill_detail->u_id) 
                                    <a href="invoice/{{ $skill_detail->id }}" class="btn btn-edit"><i class="fa fa-files-o" aria-hidden="true"></i> Invoice</a>
                            @endif  
                            </td>
                            @if($skill_detail->manual_invoice)
                            <td>

                    @php
                    $directory = "public/uploads/manual_invoice";
                    $files = array_values(array_diff(scandir($directory), array('..', '.')));
                    @endphp

                    @foreach ($files as $key => $value)
                            <a target="_blank"  href="{{url('/')}}/public/uploads/manual_invoice/{{$value}}/{{$skill_detail->manual_invoice}}">Check Invoice</a> 
                    @endforeach
                    </td>   
                            @endif
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
      <h4 class="modal-title" id="myModalLabel">Delete Skill labor</h4>
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
           url:'skill_labors/delete/'+reviewID,
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
