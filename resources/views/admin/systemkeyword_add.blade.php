@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add Vendor Listing
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link type="text/css" href="{{ asset('public/assets/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('public/assets/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />
<link href="{{ asset('public/assets/css/pages/tagsinput.css') }}" rel="stylesheet" />

<link href="{{ asset('public/assets/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('public/assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Add System Report</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Add System Report</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary testimonialadd">
        <div class="panel-heading">
          <h4 class="panel-title">Add System Report</h4>
        </div>
        <div class="panel-body">
          <form method="post" id="addtestimonail" enctype="multipart/form-data">

                 <div class="form-group">
                        <div class="row">
                            <label class="control-label col-sm-4 col-md-2">Select Category:</label>
                            <div class="col-sm-8 col-md-10 select_margin ">
                              <select name="category" id="category" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($category as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-4 col-md-2">Select Sub Category:</label>
                            <div class="col-sm-8 col-md-10 select_margin ">
                              <select name="sub_cat" id="sub_cat" class="form-control" required>
                                <option value="">Select Sub Category</option>
                                @if(isset($type))
                                  @foreach($type as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                  @endforeach
                                @endif
                              </select>
                            </div>
                          </div>
                        </div>
                         <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-4 col-md-2">Keyword:</label>
                            <div class="col-sm-8 col-md-10 select_margin ">
                              <textarea rows="5"  name="Keyword" class="form-control" placeholder="Ex: Test,Test1,Test2... Values must be added comma seprated"></textarea>
                            </div>
                          </div>
                        </div>
                        <input type="submit" class="btn btn-primary">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>

      			</div>
    		</div>

  </div>
  </div>

</section>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" ></script>
  <script src="{{asset('public/assets/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/select2/js/select2.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/sifter/sifter.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/microplugin/microplugin.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/selectize/js/selectize.min.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/js/pages/custom_elements.js') }}"></script>

  <script src="{{asset('public/assets/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
  <script  src="{{ asset('public/assets/vendors/ckeditor/js/ckeditor.js') }}"  type="text/javascript"></script>
  <script  src="{{ asset('public/assets/vendors/ckeditor/js/jquery.js') }}"  type="text/javascript" ></script>
  <script  src="{{ asset('public/assets/vendors/ckeditor/js/config.js') }}"  type="text/javascript"></script>
  <script src="{{ asset('public/assets/js/pages/editor.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/assets/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"  type="text/javascript"></script>

  <script type="text/javascript">
      $(document).ready(function() {
      jQuery("#category").on('change', function() {
          var category = "";
          var cat = $('#category').val();

          if (cat != '') {
              $.ajax({
                  type: "GET",
                  dataType: "json",
                  url: "{{url('/admin/report/add/sub')}}?category=" + this.value,
                  success: function(data) {
                      if (data) {
                          $('#sub_cat').show();
                          //Empty Drop Down
                          $("#sub_cat").empty();
                          $("#sub_cat").append('<option value="">Select Sub Category</option>');
                          $.each(data, function(key, value) {
                              $("#sub_cat").append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                      }
                  }
              })

          } else {
              $("#sub_cat").empty();
              $("#sub_cat").append('<option value="">Sub Category</option>');
          }
      });

    });

  </script>

@stop