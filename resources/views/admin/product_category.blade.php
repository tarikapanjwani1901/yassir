@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Product Category
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
    <h1>Product Category</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Product Category</li>
    </ol>
</section>

<div class="col-md-12 manage-clt">
    <form action="product_searchh" method="get" autocomplete="off">
        @if (session()->has('status'))
                <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        <div class="input-group">                            
            <input type="search" name="product_searchh" class="form-control" placeholder="Search">
            <span class="input-group-prepend">
                <button type="submit" class="btn btn-primary">Search</button>
               <a href="{{url('/admin/product/category')}}" data-toggle="tooltip" title="reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            </span>
             <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
        </div>
    </form>
</div>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        Product Category
                    </h4>
                    <div class="pull-right">
                        <a href="category/add" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create</a>
                    </div>
                </div>

                <br>

                <div class="panel-body">
                 <div class="table-responsive productimges">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                          <tr>
                             <th class="ac">Category Image</th>
                             <th>Category Name</th>
                             <th>Category Description</th>
                             <th class="ac">Actions</th>
                          </tr>
                       </thead>
                       <tbody>
                        @if(count($category))
                            @foreach($category as $cat)
                                <tr id="tr_{{$cat->cate_id}}">
                                    @if (isset($cat->cate_image) && $cat->cate_image != '')
                                        <td class="ac" align="center"><img src="{{ asset('public/images/product_category') }}/{{$cat->cate_id}}/{{$cat->cate_image}}" class="prodctimg"></td>
                                    @else
                                        <td align="center"><img src="{{ asset('public/images/noimage.png') }}" class="prodctimg"></td>
                                    @endif
                                    <td>{{ $cat->cate_name }}</td>
                                    <td>{{ $cat->cate_desc }}</td>
                                    <td class="ac">
                                        <a href="category/edit/{{$cat->cate_id}}" class="btn btn-success">Edit</a>
                                        <a href="#" class="btn btn-danger btn-info btn-lg onclick" data-id="{{ $cat->cate_id }}" data-toggle="modal" data-target="#myModal">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                             @else
                            <tr> 
                                <td colspan="10">No records found</td>
                            </tr>
                            @endif
                       </tbody>
                    </table>
                 </div>
                </div>
           </div>
           {{ $category->links() }}
        </div>
    </div>    <!-- row-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Category</h4>
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

<script>
    $(document).on("click", ".onclick", function () {
         var myBookId = $(this).data('id');
         $(".modal-dialog #bookId").val( myBookId );
    });

    jQuery("#btn_ok_1").on('click',function(){
        var categoryID = jQuery("#bookId").val();
        $.ajax({
           type:'POST',
           url:'category/delete/'+categoryID,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(data){
                if (data == 'success') {
                    $( ".close" ).trigger( "click" );
                    $("#tr_"+categoryID).css('display','none');
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
                filename: "Product_Category_detail"
                });
            });
</script>
@stop