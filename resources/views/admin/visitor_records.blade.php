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
    <h1>Search Records</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Search Records</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">

    <div class="row">
        <div class="portlet box warning">
            <div class="portlet-title">
                <div class="caption">
                    All Search Records
                </div>
            </div>

            <div class="portlet-body">
                <div class="">
                        <table class="table table-bordered" id="printableArea">
                        <thead>
                            <tr>    
                                <th>Id</th>
                                <th>Search keyword</th>
                                <th>Device</th>
                                <th>OS</th>
                                <th>Ip address</th>
                                <th>Date</th>
                                <Th>Time</Th>
                            </tr>
                        </thead>
                         <tbody>
                            @php $i = ($visitor_records->currentpage()-1)*$visitor_records->perpage() + 1 @endphp
                            @if(count($visitor_records))
                                @foreach($visitor_records as $s)
                                    <tr id="tr_{{$s->id}}">
                                        <td>{{$i++}}</td>
                                        <td>{{$s->search_keyword}}</td>
                                        <td>{{$s->device}}</td>
                                        <td>{{$s->ios}}</td>
                                        <td>{{$s->ip}}</td>
                                        <td><?php echo date('d/M/Y', strtotime($s->created_at)) ?></td>
                                         <td>{{ $s->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="7">No Result Found</td>
                            </tr>    
                            @endif
                        </tbody>
                    </table>
                </div>
                   @if(isset($visitor_records))
                {{ $visitor_records->appends(request()->query())->links() }}
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

@stop