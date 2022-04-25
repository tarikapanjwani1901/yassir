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
    <h1>Manage Contact</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Manage Contact</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="portlet box warning">
            <div class="portlet-body">
                <div class="table-responsive">
                        <table class="table table-bordered">                       
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Phone No.</th>
                                <th>Email Id</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>

                           @if(count($contact))
                                @foreach($contact as $s) 
                                    <tr id="tr_{{$s->id}}">
                                        <td>{{$s->description}}</td>
                                         <td>{{$s->address}}</td>
                                         <td>{{$s->phone_no}}</td>
                                         <td>{{$s->email_id}}</td>
                                        <td> 
                                            <a href="{{url('/')}}/admin/edit_contact_detail/{{$s->id}}" class="onclick default btn btn-success" >  Edit
                                            </a>
                                            <a href="{{url('/')}}/contact-us" class="onclick default btn btn-success"  target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="View Page"></i>
                                            </a>
                                            <input type="hidden" name="cid" id="cid" value="">
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5">No result found</td>
                                </tr>    
                            @endif
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

@stop