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
    <h1>Reviews</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Reviews</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="portlet box warning">
            <div class="portlet-title">
                <div class="caption">
                    All Reviews
                </div>
            </div>

        <form method="get" class="padd15" name="reviewpost" autocomplete="off">
            <input type="search" name="search" placeholder="search" style="height: 33px;">
            <select id="s_category" name="s_category" class="reviewselect">
                <option value="">Category</option>
                <?php foreach ($category as $key => $value) { ?>
                    @if ($cat == $value->id)
                        <option value="{{ $value->id }}" selected>{{$value->name}}</option>
                    @else
                        <option value="{{$value->id}}">{{$value->name}}</option>
                    @endif
                <?php } ?>
            </select>

            <select id="sub_category" name="sub_category" class="reviewselect">
                <option value="">Sub Category</option>
                <?php if ($type) {
                    foreach ($type as $key => $value) { ?>
                        @if ($sub == $value->id)
                            <option value="{{ $value->id }}" selected>{{$value->name}}</option>
                        @else
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endif

                    <?php }
                } ?>
            </select>

            <select name="review" class="reviewselect" id="vendor_list">
                <option value="">Select Vendor</option>
                @foreach($data as $d)
                @if ($rid == $d->u_id)
                     <option value="{{ $d->u_id }}" selected>{{$d->company_name}}</option>
                @else
                <option value="{{$d->u_id}}">{{$d->company_name}}</option>
                @endif
                @endforeach
            </select>

            <input type="submit" value="Submit">
            <a href="{{url('/admin/review')}}" data-toggle="tooltip" title="reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
        </form>
            <div class="portlet-body">
                <div class="">
                        <table class="table table-bordered" id="printableArea">
                        <thead>
                            <tr>    
                                <th>Id</th>
                                <th>Reviewer Name</th>
                                <th>Review</th>
                                <th>Comment</th>
                                <th>Listing</th>
                                <th class="ac">Action</th>
                            </tr>
                        </thead>
                         <tbody>
                             @php $i = ($showreview->currentpage()-1)*$showreview->perpage() + 1 @endphp
                            @if(isset($showreview))
                                @foreach($showreview as $s)
                                    <tr id="tr_{{$s->id}}">
                                        <td>{{$i++}}</td>
                                        <td>{{ucfirst($s->reviewer_name)}}</td>
                                        <td>{{$s->l_review}}</td>
                                        <td>{{ucfirst($s->l_comment)}}</td>
                                        <td>{{$s->l_title}}</td>
                                        <td class="ac">
                                            <a href="#" class="btn btn-danger btn-info btn-lg onclick" data-id="{{ $s->id }}" data-toggle="modal" data-target="#myModal">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                   @if(isset($showreview))
                {{ $showreview->appends(request()->query())->links() }}
            @endif
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
<script src="{{asset('public/assets/js/table2excel.js')}}"></script>
<script>
    $(document).on("click", ".onclick", function () {
         var myBookId = $(this).data('id');
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var reviewID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'review/delete/'+reviewID,
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
<script>

$("#s_category").on('change',function(){

    var category = "";
    var cat = $('#s_category').val();

    if (cat !== '') {

        //Populate Sub Category Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/report/add/sub')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    $('#sub_category').show();
                    //Empty Drop Down
                    $("#sub_category").empty();
                    $("#sub_category").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#sub_category").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })

        //Populate Vendor Drop Down
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/admin/report/add/vendor')}}?category="+this.value+"&sub_cat=",
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#vendor_list").empty();
                    $("#vendor_list").append('<option value="">Vendor</option>');
                    $.each( data, function( key, value ) {
                        $("#vendor_list").append('<option value="'+value.user_id+'">'+value.company_name+'</option>');
                    });
                }
            }
        })

    } else {
        $('#sub_category').empty();
        $("#sub_category").append('<option value="">Sub Category</option>');
    }
});

$("#sub_category").on('change',function(){

    var cat = $('#s_category').val();
    var sub_cat = $("#sub_category").val();

    $.ajax({
        type:"GET",
        dataType: "json",
        url:"{{url('/admin/report/add/vendor')}}?category="+cat+"&sub_cat="+sub_cat,
        success:function(data){
            if ( data ) {
                //Empty Drop Down
                $("#vendor_list").empty();
                $("#vendor_list").append('<option value="">Select Vendor</option>');
                $.each( data, function( key, value ) {
                    $("#vendor_list").append('<option value="'+value.user_id+'">'+value.company_name+'</option>');
                });
            }
        }
    })
});
$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "Reviews_detail"
                });
            });
</script>
</script>
@stop