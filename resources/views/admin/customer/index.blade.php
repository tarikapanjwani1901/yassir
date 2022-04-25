@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Users List
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/v/bs/jq-2.2.4/dt-1.10.15/r-2.1.1/datatables.min.css'>
<link rel="stylesheet" href="{{asset('public/admins/css/style.css')}}">
@stop
{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Customer</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Customer</a></li>
        <li class="active">Customer List</li>
    </ol>
</section>
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Customer List
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered width100" id="datatables">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>User E-mail</th>
                            <th>Company Name</th>
                            <th>City</th>
                            <th>State</th>
                            <th>User Role</th>
                                  </tr>
                              </thead>
                            <tbody>
                            @php $count = 1; @endphp
                          @foreach($cust as $user)
                              <tr>
                                <td>{{ $count++ }} </td>
                                <td>{{ $user->first_name }} </td>
                                <td>{{ $user->last_name }} </td>
                                <td>{{ $user->email }} </td>
                                <td>{{ $user->company_name }} </td>
                                <td>{{ $user->city }} </td>
                                <td>{{ $user->user_state }} </td>
                                    <?php if($user->user_role == 5){ ?>
                                <td>Customer</td>
                                <?php } ?>
                              </tr>
                              @endforeach
                     </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
  <script src="{{asset('public/export/js/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('public/export/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/export/js/datatables.min.js')}}"></script>
<script src="{{asset('public/export/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/export/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/export/js/jszip.min.js')}}"></script>
<script src="{{asset('public/export/js/pdfmake.min.js')}}"></script>
<script src="{{asset('public/export/js/vfs_fonts.js')}}"></script>
<script src="{{asset('public/export/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/export/js/buttons.print.min.js')}}"></script>

  
<script  src="{{asset('public/export/js/index.js')}}"></script>
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
@stop