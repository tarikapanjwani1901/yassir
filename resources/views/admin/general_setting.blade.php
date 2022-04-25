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
    <h1>Manage General Setting</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Manage General Setting</li>
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
                                <th>Contact No.</th>
                                <th>Facebook Link</th>
                                <th>Twitter Link</th>
                                <th>Instagram Link</th>
                                <th>Youtube Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>

                           @if(count($setting))
                                @foreach($setting as $s) 
                                    <tr id="tr_{{$s->id}}">
                                        <td>{{$s->contact_no}}</td>
                                         <td>{{$s->facebook_link}}</td>
                                         <td>{{$s->twitter_link}}</td>
                                         <td>{{$s->instagram_link}}</td>
                                         <td>{{$s->youtube_link}}</td>
                                        <td> 
                                            <a href="{{url('/')}}/admin/edit_general_setting/{{$s->id}}" class="onclick default btn btn-success" style="width:80px;" >  Edit
                                            </a>
                                            
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