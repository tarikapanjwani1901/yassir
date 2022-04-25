@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Users List
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<style type="text/css">
    .exportExcel{
  padding: 5px;
  border: 1px solid grey;
  margin: 5px;
  cursor: pointer;
}
</style>
<section class="content-header">
    <h1>Users</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Users</a></li>
        <li class="active">Users List</li>
    </ol>
</section>

        <div class="">
                <form class="reportform padd15"  method="get" name="inquiry">
    
                   
                <input type="search" name="users_search" placeholder="search" style="height: 33px;">               
                    <select id="s_category" name="s_category" class="reviewselect">           
                        <option value="">Category</option>
                    @foreach ($category as $key => $value)
                        @if ($main_category == $value->id)
                       <option value="{{ $value->id }}" selected>{{$value->name}}</option>
                        @else
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                    @endforeach
                    </select>
                    <select id="sub_category" name="sub_category" class="reviewselect">
                    <option value="">Sub Category</option>
                    <?php if ($type) {
                        foreach ($type as $key => $value) { ?>
                            @if ($sub_category == $value->id)
                                <option value="{{ $value->id }}" selected>{{$value->name}}</option>
                            @else
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endif

                        <?php }
                    } ?>
                    </select>
                    <select class="reviewselect" name="s_city" id="s_city">
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
                    <!--<select class="reviewselect" name="roles" id="roles">
                        <option value="">Select Role</option>
                        @if (!empty($role_info))
                          @foreach($role_info as $d)
                            @if ($role_name == $d->id)
                            <option value="{{$d->id}}" selected>{{$d->name}}</option>
                            @else
                            <option value="{{$d->id}}">{{$d->name}}</option>
                             @endif 
                          @endforeach
                        @endif
                    </select>-->
                    <input type="submit" value="Submit" id="submit">
                    <a href="{{url('/')}}/admin/users"  data-toggle="tooltip" title="" data-original-title="Reset" class="btn btn-primary exporting"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    <!-- <button type="button" id="btnExportpdf" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate PDF"><i class="fa fa-download"></i> Generate PDF</button> -->
                    <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
            </form>
        </div>

        
<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
               <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Users List   ({{$total_users_info}}) <br>

                    Active users ({{$active_users_info}}) <br>

                    Deactive users ({{$deactive_users_info}})
                </h4>
            </div>
            <!--  <button id="exportButton" class="btn btn-lg btn-danger clearfix"><span class="fa fa-file-excel-o"></span> Export to Excel</button> -->
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered width100" id="printableArea">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Status</th>
                            <th>User Name</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Company</th>  
                            <th>Last login</th>
                            <th>Gst</th>
                            <th>Role</th>
                            <th>Register at</th>
                            <th>Updated at</th>
                            <th>Package End Date</th>
                            <th>Package Duration</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Category</th> 
                            
                            <th>subcategory</th>
                            <th class="ac">Actions</th>
                        </tr>
                            
                        <?php 

                       
                        $i = ($users->currentpage()-1)*$users->perpage() + 1;?>
                        @if(count($users))

                      
                            
                        @foreach($users as $user)

                        <tr>
                     
                            <td>{{$i++}}</td>
                       
                                    @if($user->completed == 1)
                            <td style="color:green">
                                Activated
                            </td>
                            @else
                            <td style="color:red">Deactivated</td>
                            @endif
                            <td>{{ucfirst($user->first_name)}} &nbsp; {{$user->last_name}}<br><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                           
                            <td>{{$user->address}}</td>
                             <td>{{$user->mobile}}</td>
                              <td>{{$user->company_name}}</td> 
                              @if(!$user->last_login == "")
                               <td>{{date('d/M/Y', strtotime($user->last_login))}}</td>
                              @else
                              <td>Not Login</td>
                              @endif 
                            <td>{{$user->gst_number}}</td>
                                                           
                                    
                            @if($user->user_role == '1')
                                <td>Admin</td>
                            @elseif($user->user_role == '3')
                                <td>Vendor</td>
                            @elseif($user->user_role == '4')
                             <td>Sales Team</td>
                            @else
                             <td>User</td>
                            @endif
                            <td>{{date('d/M/Y', strtotime($user->created_at))}}</td>
                             <td>{{date('d/M/Y', strtotime($user->updated_at))}}</td>
                            <td> @if($user->package_duration)
                            {{date('d/M/Y', strtotime($user->end_date))}}
                            @endif</td>
                            <td>{{$user->package_duration}}</td>
                            <td>{{$user->user_state}}</td>
                            <td>{{$user->city}}</td>
                            
                            
                            @if($user->user_category == '1')
                                <td>Properties</td>
                            @elseif($user->user_category == '2')
                                <td>Consultancy</td>
                            @elseif($user->user_category == '3')
                             <td>Contractor</td>
                            @elseif($user->user_category == '4')
                             <td>Material</td>
                            @elseif($user->user_category == '5')
                             <td>Skill labor</td>
                            @else
                            <td>
                                
                            </td>
                            @endif
                           
                            <td>

                            @if($main_category)
                                
                                @if($user->user_category==1)                          
                                    @foreach(explode(',', $user->user_sub_cate) as $info)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{ $typeProcess[$info] }}
                                    @endforeach
                                @elseif($user->user_category==4)
                                    @foreach(explode(',', $user->user_sub_cate) as $info)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{ $typeProcess[$info] }}
                                    @endforeach
                                @elseif($user->user_category==2)
                                    @foreach(explode(',', $user->user_sub_cate) as $info)
                                        {{ $loop->first ? '' : ', ' }}
                                       {{ $typeProcess[$info] }}
                                    @endforeach    
                            
                                @elseif($user->user_category==3)
                                    @foreach(explode(',', $user->user_sub_cate) as $info)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{ $typeProcess[$info] }}
                                    @endforeach
                                @else
                                    {{$typeProcess[$user->user_sub_cate]}}             
                                @endif  
                            @else
                                 {{$user->name}}
                            @endif             
                                 </td>

                             <td class="ac">
                                
                              

                                <a href="users/{{$user->id}}/edit"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update user"></i></a>

                                
                                <a href="users/{{$user->id}}/confirm-delete" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i></a>


                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="20">No records found</td>
                        </tr>
                        @endif

                    </thead>
                    <tbody>

    
                    </tbody>
                </table>
                {{$users->appends(request()->query())->links()}}
                 
               
                </div>
            </div>

            <table class="table table-bordered width100" id="excel" style="display:none;">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Status</th>
                            <th>User Name</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Phone</th>
                            <th>Company</th>  
                            <th>Last login</th>
                            <th>Gst</th>
                            <th>Trade</th>
                            <th>Role</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>State</th>
                            <th>City</th>
                            <th>category</th> 
                            <th>subcategory</th>   
                            <th class="ac">Actions</th>
                        </tr>
                        
                         <?php $i = 1; ?>
                        @if(count($users_info1))
                        @foreach($users_info1 as $user)

                        <tr>
                            <td>{{$i++}}</td>
                                @if($user->completed == 1)
                            <td style="color:green">
                                Activated
                            </td>
                            @else
                            <td style="color:red">Deactivated</td>
                            @endif
                            <td>{{ucfirst($user->first_name)}} &nbsp; {{$user->last_name}}<br><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                           
                            <td>{{$user->address}}</td>
                             <td>{{$user->mobile}}</td>
                              <td>{{$user->phone}}</td>
                              <td>{{$user->company_name}}</td> 
                               <td>{{date('d/M/Y', strtotime($user->last_login))}}</td>
                               <td>{{$user->gst_number}}</td>
                                                           
                                    
                            @if($user->user_role == '1')
                                <td>Admin</td>
                            @elseif($user->user_role == '3')
                                <td>Vendor</td>
                            @elseif($user->user_role == '4')
                             <td>Sales Team</td>
                            @else
                             <td>User</td>
                            @endif
                            <td>{{date('d/M/Y', strtotime($user->created_at))}}</td>
                            <td>{{date('d/M/Y', strtotime($user->end_date))}}</td>

                            <td>{{$user->user_state}}</td>
                            <td>{{$user->city}}</td>
                            
                            
                            @if($user->user_category == '1')
                                <td>Properties</td>
                            @elseif($user->user_category == '2')
                                <td>Consultancy</td>
                            @elseif($user->user_category == '3')
                             <td>Contractor</td>
                            @elseif($user->user_category == '4')
                             <td>Material</td>
                            @else
                             <td>Skill labor</td>
                            @endif
                            <td>{{$user->name}}</td>

                             <td class="ac">
                                
                              

                                <a href="users/{{$user->id}}/edit"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update user"></i></a>

                                
                                <a href="users/{{$user->id}}/confirm-delete" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i></a>


                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="10">No records found</td>
                        </tr>
                        @endif

                    </thead>
                    <tbody>

    
                    </tbody>
                </table>
        </div>
    </div>    <!-- row-->
</section>
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
<script src="{{ asset('public/js/select2.full.min.js') }}"></script>

<script type="text/javascript">
      $(function () {
        $('.select2').select2()
         });
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
</script>
<script type="text/javascript">
        $("body").on("click", "#btnExportpdf", function () {
          $('.ac').hide();
            html2canvas($('#printableArea')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500,
                            scrollX:500,
                            scrollY:500,
                            windowWidth:500,
                            windowHeight:500


                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
          $('.exporting').show();
        });
    </script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.js"></script>

     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="{{asset('public/assets/js/table2excel.js')}}"></script>
<script type="text/javascript">
$("#btnExport").click(function () {
                 $("#excel").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "employee_detail"
                });
            });
</script>
@stop
