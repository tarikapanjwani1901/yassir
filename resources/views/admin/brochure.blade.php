@extends('admin/layouts/default')



{{-- Page title --}}

@section('title')

OTPListing

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

<section class="content-header">

    <h1>Vendor Product Brochure</h1>

    <ol class="breadcrumb">

        <li>

            <a href="{{ route('admin.dashboard') }}">

                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>

                Dashboard

            </a>

        </li>

        <li class="active">Vendor Product Brochure</li>

    </ol>

</section>

<!-- Main content -->

<section class="content paddingleft_right15">

    <div class="row">

        <div class="portlet box warning">

                <div class="portlet-title">

                <div class="portlet-body testimoniallist">

                 <div class="table-responsive">

                    <table class="table table-bordered">

                       <thead>

                          <tr>

                             <th>Vendor Name</th>

                             <th>Action</th>

                          </tr>

                       </thead>

                       <tbody>      

                        @foreach($usde as $usdes)

                                <tr>

                                    <td> {{ $usdes->l_title }} </td>

                                    <td><a target="_blank" href="{{url('/')}}/admin/brochure/{{$usdes->id}}" class="btn btn success" data-id="{{$usdes->id}}" style="color: white">Create Brochure</a>

                                    </td>

                                </tr>

                        @endforeach

                                    

                       </tbody>

                    </table>

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



@stop