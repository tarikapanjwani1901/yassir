@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Inquires
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
<style type="text/css">
  .dt1 {
    width: 150px;
    display: inline-block;
    margin-left: 6px;
}
</style>
<section class="content-header">
    <h1>Inquires</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Inquires</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="">

             <form class="reportform padd15" action="" method="get" name="inquiry" autocomplete="off">

                   <input type="search" name="inquiry_name" id="inquiry_name" placeholder="search" style="height: 33px;     width: 20%;">
                    
                    @if(Sentinel::inRole('admin'))
                    <select class="reviewselect" name="vendors" id="vendors">
                        <option value="">Select Vendor</option>
                        @if (!empty($vendors_info))
                              @foreach($vendors_info as $d)
                                 @if ($vendors == $d->vl_id)
                                <option value="{{$d->vl_id}}" selected="selected">{{$d->l_title}}</option>
                                @else
                                  <option value="{{$d->vl_id}}" >{{$d->l_title}}</option>
                                  @endif  
                              @endforeach
                        @endif
                    </select>
                    @endif
                     <input id="datetimepicker6" name="from" type="text" class="form-control dt1" data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="Start date"/>

                          <input id="datetimepicker7" name="to" type="text" class="form-control dt1"
                                                               data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="End date"/>
                     <input type="submit" value="Submit" id="submit">
                     <a href="{{url('/')}}/admin/inquiry" data-toggle="tooltip" title="" data-original-title="Reset" class="btn btn-primary exporting"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            </form>    

           <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        Inquires &nbsp;&nbsp;  
                        @if(Sentinel::inRole('admin'))
                        (Total Inquires : {{$total_inquity}})
                        @endif
                    </h4>
                    <div style="float: right;display:none;">
                        <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>    
                    </div>
                </div>
                <br>

                <div class="panel-body">
                 <div class="table-responsive">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                          <tr>
                            <th>Id</th>
                             <th>Property Name</th>
                             <th>Name</th>
                             <th>Email</th>
                             <th>Phone</th>
                             <th>Info</th>
                             <th>Date & Time</th>
                          </tr>
                       </thead>
                       <tbody>
                          @php $i = ($inquires->currentpage()-1)*$inquires->perpage() + 1 @endphp
                        @if(count($inquires))
                            @foreach($inquires as $inquire)
                                <tr id="tr_{{$inquire->id}}">
                                    <td> {{$i++}}</td>
                                    <td> {{ ucfirst($inquire->l_title) }} </td>
                                    <td> {{ ucfirst($inquire->name) }} </td>
                                    <td> {{ ucfirst($inquire->email) }} </td>
                                    <td> {{ $inquire->contact }} </td>
                                    <td> {{ $inquire->message }} </td>
                                    <td> <?php echo date('M j h:ia', strtotime($inquire->created_at)) ?> </td>
                                </tr>
                            @endforeach
                            @else
                            <td colspan="7">No Result Found</td>
                            @endif
                       </tbody>
                    </table>
                    {{$inquires->links()}}
                 </div>
                </div>
           </div>
        </div>
    </div>    <!-- row-->

</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/pages/datepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
<script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/pages/adduser.js') }}"></script>
<script type="text/javascript">

    $("#btnExport").click(function () {
            $("#printableArea").remove(".ac").table2excel({
        exclude: ".ac",
            name: "Employee data",
        filename: "employee_detail"
        });
    });

    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker();
    });

</script>
@stop