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
    <h1>All Skill labor</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">All Skill labor</li>
    </ol>
</section>
<div class="col-md-12 manage-clt">
    <form action="skill_search" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        <div class="input-group">     
            <input type="search" name="skill_search" class="form-control" placeholder="Search">
            
                <select class="reviewselect" name="city_name" id="s_city">
                    <option value="" >Select city</option>
                    @if (!empty($city_info))
                      @foreach($city_info as $d)
                        @if ($city_name == $d->City_Name)
                        <option value="{{$d->City_Name}}" selected>{{$d->City_Name}}</option>
                        @else
                        <option value="{{$d->City_Name}}">{{$d->City_Name}}</option>
                         @endif 
                      @endforeach
                    @endif
                </select>

                <select name="area" id="state" class="reviewselect">
                        <option value="">Select Area</option>
                </select>

                <select class="reviewselect" name="skill_name" id="skill_name">
                    <option value="" >Select Skill</option>
                    @if (!empty($skill_info))
                      @foreach($skill_info as $d)
                        @if ($skill_name == $d->id)
                        <option value="{{$d->id}}" selected>{{$d->name}}</option>
                        @else
                        <option value="{{$d->id}}">{{$d->name}}</option>
                         @endif 
                      @endforeach
                    @endif
                </select>    


            <span class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Search</button>
               <a href="{{url('/admin/skill_labors')}}" data-toggle="tooltip" title="reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>

               
            </span>
            <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
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
                        <table class="table table-bordered" id="printableArea">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Skill</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Area</th>
                                <th>Experience</th>
                                <th>Age</th>
                                <th>Adharnumber</th>
                                <th class="ac">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($skill_details))
                            @foreach($skill_details as $skill_detail)
                            <tr id="tr_{{ $skill_detail->vl_id }}">
                            <td>{{ $skill_detail->first_name }}</td>
                            <td>{{ $skill_detail->name }}</td>
                            <td>{{ $skill_detail->Phone }}</td>
                            <td>{{ $skill_detail->city }}</td>
                            <td>{{ $skill_detail->area }}</td>
                            <td>{{ $skill_detail->experience_details }}</td>
                            <td>{{ $skill_detail->age_details }} </td>
                            <td>{{ $skill_detail->adharnumber_details }} </td>
                            <td class="ac">
                                

                                 <a href="skill_labors/edit/{{ $skill_detail->vl_id }}" class="btn default btn-edit">Edit
                                            </a>
                                 

                                <a href="#" data-toggle="modal" data-target="#tes_delete_confirm"  data-id="{{ $skill_detail->vl_id }}" class="onclick btn btn-delete">
                                                Delete
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
                        {{ $skill_details->links() }}
                        
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
    $(document).on("click", ".oncldfdick", function () {
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
                if(data==true){
                   alert('doneeeeeee');
                }
           }
        });
    });

    $(document).on("click", ".onclick", function () {
        var myBookId = $(this).data('id');

        $(".modal-dialog #bookId").val(myBookId);
    });

    $("#btn_ok_1").on('click',function(){
        var reviewID = $("#bookId").val();
        $.ajax({
           url:'skill_labors/delete/'+reviewID,
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
<script>
    $("#s_city").on('change',function(){
        var City_Id = $(this).val(); 
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#state").empty();
                    $("#state").append('<option value="">Select Area</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
    });
</script>
<script src="{{asset('public/assets/js/table2excel.js')}}"></script>
<script type="text/javascript">
$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "SkillLabor_details"
                });
            });
</script>
@stop
