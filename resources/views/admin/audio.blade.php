 @extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('groups/title.management')
@parent
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>Manage Audio</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Manage Audio</a></li>
        <li class="active">Manage Audio</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-body">
                   
                        <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Audio</th>
                                    <th>Message</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count=1; @endphp
                                        @if(count($audio_info))
                                        @foreach ($audio_info as $value)

                                        <tr>
                                            <td>{{$count++}}</td>
                                            <td>
                                                {{$value->audio_name}}
                                            </td>
                                             <td>
                                                {{$value->audio_description}}
                                            </td>
                                            <td>
                                                {{$value->created_at}}
                                            </td>
                                            <td>
                                                @if($value->audio_name)
                                                   <a class="btn default" href="{{url('/')}}/public/uploads/audio/{{$value->audio_id}}/{{$value->audio_name}}"><i class="fa fa-play" data-toggle="tooltip" title="" data-original-title="Play this audio"></i></a>

                                                   <a download class="btn default" href="{{url('/')}}/public/uploads/audio/{{$value->audio_id}}/{{$value->audio_name}}"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="" data-original-title="Download Audio"></i></a>
                                                @endif   

                                                @if(Sentinel::inRole('admin'))   


                                                @if($value->audio_name)
                                                <a href="{{url('/')}}/admin/edit_audio/{{$value->audio_id}}/{{$value->audio_name}}" data-id="{{url('/')}}/public/uploads/audio/{{$value->audio_id}}/{{$value->audio_name}}" > <button name="submit" class="btn default">Edit </button>  
                                                </a>
                                                @else
                                                <a href="{{url('/')}}/admin/edit_audios/{{$value->audio_id}}" data-id="{{url('/')}}/public/uploads/audio/{{$value->audio_id}}" > <button name="submit" class="btn default">Edit </button>  
                                                </a>
                                                @endif

                                                


                                               
                                                @if($value->audio_name)
                                                    <a href="{{url('/')}}/admin/del_audio/{{$value->audio_id}}/{{$value->audio_name}}" data-id="{{url('/')}}/public/uploads/audio/{{$value->audio_id}}/{{$value->audio_name}}" class="cross"> <span class="glyphicon glyphicon-remove"></span>
                                                    </a>
                                                @else
                                                     <a href="{{url('/')}}/admin/del_audios/{{$value->audio_id}}" data-id="{{$value->audio_id}}" class="cross" id="dels"> <span class="glyphicon glyphicon-remove video_remove"></span>
                                                    </a>    
                                                @endif
                                                @endif
                                             </td>
                                        </tr>

                                        @endforeach
                                         @else
                                        <tr>
                                            <td colspan="5">No Audio file found</td>
                                        </tr>
                                        @endif
                                           
                            </tbody>
                        </table>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>






@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="modal fade" id="users_exists" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                @lang('groups/message.users_exists')
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
    $(document).on("click", ".users_exists", function () {

        var group_name = $(this).data('name');
        $(".modal-header h4").text( group_name+" Group" );
    });


    

</script>
<script type="text/javascript">
    $(document).ready(function(){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    })

    $('.video_remove').click(function()
    {   
        
        var file = $("#dels").attr("data-id");
        
        var id = this.id;
      $.ajax({
        type:"GET",
        url:"{{url('/')}}/{{'admin/del_audios'}}",
        data:{file:file},
        dataType: "json",
        success: function(result){
         
         }
      });

 });

    });
</script>
@stop

                       