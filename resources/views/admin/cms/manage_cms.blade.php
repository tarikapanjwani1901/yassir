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
    <h1>All CMS</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Category</a></li>
        <li class="active">All CMS</li>
    </ol>
</section>

<!-- Main content -->
<section class="content multiple-file_upload paddingleft_right15">
        <div class="">

            <div class="row">
               <div class="portlet box warning">
                <div class="portlet-title">
                    <div class="caption">
                       All CMS
                    </div>
                </div>

                

                <div class="portlet-body testimoniallist">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($cms_info))
                            @foreach($cms_info as $cms)
                            <tr>
                                 <td>
                                    {{ $cms->id }}
                                </td>
                                <td>
                                    {{ $cms->title }}
                                </td>
                                 
                                <td>
                                        
                                    <!--
                                    @if($cms->status == "in-active")   
                                    <a href="" data-toggle="modal" data-target="#tes_delete_confirm" data-id="{{ $cms->id }}" class="onclick default btn btn-success active" style="width:80px;" >  

                                        Active
                                    </a>
                                    <input type="hidden" name="cid" id="cid" value="">
                                    @endif
                                   
                                        
                                   @if($cms->status == "active")   
                                    <a href="" data-toggle="modal" data-target="#tes_delete_confirm" data-id="{{ $cms->id }}" class="onclick default btn btn-delete inactive">   
                                    Deactive
                                    </a>
                                    <input type="hidden" name="cid" id="cid" value="">
                                    @endif--->
                                           
                                         <a href="manage_cms/edit/{{ $cms->id }}" class="btn default btn-edit">Edit
                                            </a>

                                         <a href="{{url('/')}}/{{ $cms->link }}" class="btn default" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="View Page" data-original-title="reset"></i>
                                            </a>   
                                            
                                        </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No records found</td>
                            </tr>
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

<script>


    $(".inactive").on('click',function(){
        var cityids = $(this).data('id');
        $("#cid").val(cityids);
        var id = $("#cid").val();
       
        $.ajax({
           type:'POST',
           url:'manage_cms/inactive_cms/'+id,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                $('.successs').text('akljsbdkajsbdjkasd');
                
           }
        });
    });

    $(".active").on('click',function(){
        var cityidsg = $(this).data('id');
        $("#cid").val(cityidsg);
        var id = $("#cid").val();
       
        $.ajax({
           type:'POST',
           url:'manage_cms/active_cms/'+id,
           data:'_token = <?php echo csrf_token() ?>',
           success:function(){
                 $('.successs').text('akljsbdkajsbdjkasd');
           }
        });
    });

</script>
@stop
