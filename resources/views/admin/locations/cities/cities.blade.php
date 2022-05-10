@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Cities
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
    <h1>Cities</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Cities</a></li>
        <li class="active">All List</li>
    </ol>
</section>

<div class="col-md-12 manage-clt">
     
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        
</div>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="portlet box warning">
                <div class="portlet-title">
                    <div class="caption">
                       All City
                    </div>
                </div>
                <form method="get" class="padd15" name="search" action="cities_search"  autocomplete="off">
              <div class="row form-inline">
            <input type="search" value="{{$search_keyword}}" name="search_keyword" class="form-control" placeholder="City" style="height: 33px;">
            
            {!! Form::select('search_country', $countries,$search_country,['class' => 'form-control search_country', 'id' => 'search_country']) !!}
            
            {!! Form::select('search_state', $states,$search_state,['class' => 'form-control search_state', 'id' => 'search_state']) !!}
            {!! Form::select('search_status', $status,$search_status,['class' => 'form-control search_status', 'id' => 'search_status']) !!}
                                                   
            

            <input type="submit" value="Submit">
            <a href="{{url('/admin/cities')}}" data-toggle="tooltip" title="Reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>
        	  </div>
        </form>
                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="printableArea">
                            <thead>
                            <tr>
                                <th>City Name</th>
                                <th>State Name</th>
                                <th>Country Name</th>
                                <th>Status</th>
                                
                                <th class="ac">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($cities))
                                <?php foreach ($cities as $key => $value) { ?>
                                    <tr id="tr_{{ $value->city_id}}">
                                        <td><?php echo $value->city_name; ?></td>
                                        <td><?php echo $value->state_name; ?></td>
                                        <td><?php echo $value->country_name; ?></td>
                                        <td><?php echo $value->status; ?></td>
                                        <td class="ac">
                                            <a href="cities/edit/{{ $value->city_id}}" class="btn default btn-edit">
                                                Edit
                                            </a>
                                            <a href="#" data-toggle="modal" data-target="#cities_delete_confirm"  data-id="{{ $value->city_id}}" class="onclick default btn btn-delete ">
                                                Delete
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>
                                 @else
                            <tr> 
                                <td colspan="6">No records found</td>
                            </tr>
                            @endif

                            </tbody>
                        </table>
                        {{ $cities->links() }}
                    </div>
                </div>
        </div>
    </div>    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

<div class="modal-dialog" role="document" id="cities_delete_confirm" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Delete City</h4>
    </div>
    <div class="modal-body">
        Are you sure?
    </div>
    <input type="hidden" name="deleted_id" id="deleted_id" value=""/>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="button" id="btn_ok_1" class="btn btn-primary">OK</button>
    </div>
  </div>
</div>

<script>
    $(document).on("click", ".onclick", function () {
         var ID = $(this).data('id');
         $(".modal-dialog #deleted_id").val( ID );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var DeletedID = jQuery("#deleted_id").val();
        $.ajax({
           type:'POST',
           url:'cities/delete/'+DeletedID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+DeletedID).css('display','none');
                }
           }
        });
    });
	
	
	
$("#search_country").on('change',function(){

    var category = "";
    var search_country = $('#search_country').val();
	$("#search_state").empty();
					 $("#search_state").append('<option value="">Please select state</option>');
                   
    if (search_country !== '') {

        //Populate Sub Category Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/getState')}}?country="+this.value,
            success:function(data){
                if ( data ) {
                    
                    $.each( data, function( key, value ) {
                        $("#search_state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
		
	}
});
</script>
@stop
