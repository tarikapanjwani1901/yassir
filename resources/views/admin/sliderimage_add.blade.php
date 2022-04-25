@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add Vendor Listing
@parent
@stop

{{-- page level styles --}}
@section('header_styles')


@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Add Slider Image</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Add Slider Image</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary testimonialadd">
        <div class="panel-heading">
          <h4 class="panel-title">Add Slider Image</h4>
        </div>
        <div class="panel-body">
          <form method="post" enctype="multipart/form-data">
            <div class="form-group galleryphotos">
                <div class="row">
                    <label class="col-sm-12 control-label" for="form-file-multiple-input">Slider Image</label>

                    <div class="col-sm-12">
                          <div class="sliderimages">
                        <input type="file" id="form-file-multiple-input" name="inputFile">
                         <input type="submit" value="Upload" class="btn btn-primary" >
                         <img id="image_upload_preview" height="100" width="100" style="display: none;" />
                              </div>
                      </div>
                          <div class="col-sm-12 pad-top20">
                        <?php
                            $directory = "public/images/home_galery";
                            if (is_dir($directory)) {
                            $files = array_values(array_diff(scandir($directory), array('..', '.')));
                            $img = '';
                            foreach ($files as $key => $value) { ?>
                              <div id="d_{{$key}}" class="productimg">
                                <img src="/public/images/home_galery/{{ $value }}" id="img_{{$key}}">

                               <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove img_remove"  id="{{$key}}"></span>
                               </a>
                             </div>
                            <?php } }
                        ?>
                    </div>
                </div>
            </div>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>

      <form method="post" enctype="multipart/form-data" action="{{url('admin/add_image')}}">
          <div class="form-group galleryphotos">
              <div class="row">
                  <label class="col-sm-12 control-label" for="form-file-multiple-input">Add Video</label>

                  <div class="col-sm-12">
                        <div class="sliderimages">
                      <input type="file" id="form-file-multiple-input1" name="inputFile">
                       <input type="submit" value="Upload" class="btn btn-primary" >
                            </div>
                    </div>
                        <div class="col-sm-12 pad-top20">
                      <?php
                          $directory = "public/images/home_add";
                          if (is_dir($directory)) {
                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                          $img = '';
                          foreach ($files as $key => $value) { ?>
                            <div id="add_{{$key}}" class="productimg">
                             

                             <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove video_remove"  id="{{$key}}"></span>
                             </a>
                           </div>
                          <?php } }
                      ?>
                  </div>
              </div>
          </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>
       <form method="post" enctype="multipart/form-data" action="{{url('admin/brand_image')}}">
          <div class="form-group galleryphotos">
              <div class="row">
                  <label class="col-sm-12 control-label" for="form-file-multiple-input">Add Brand Logo</label>

                  <div class="col-sm-12">
                        <div class="sliderimages">
                      <input type="file" id="form-file-multiple-input2" name="brand_file">
                       <input type="submit" value="Upload" class="btn btn-primary" >
                       <img id="image_upload_preview2" height="100" width="100" style="display: none;" />
                            </div>
                    </div>
                        <div class="col-sm-12 pad-top20">
                      <?php
                          $directory = "public/images/brand";
                          if (is_dir($directory)) {
                          $files = array_values(array_diff(scandir($directory), array('..', '.')));
                          $img = '';
                          foreach ($files as $key => $value) { ?>
                            <div id="add_{{$key}}" class="productimg">
                              <img src="/public/images/brand/{{ $value }}" id="imgrmv{{$key}}">

                             <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove brand_remove"  id="{{$key}}"></span>
                             </a>
                           </div>
                          <?php } }
                      ?>
                  </div>
              </div>
          </div>
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

  <script>
  	$('.img_remove').click(
    function()
    {
      var file = $("#img_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"{{'/admin/vendorlisting/del_image'}}",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#d_"+id).hide();
           window.location.reload();
         }
      });

 });

    $('.brand_remove').click(
    function()
    {
      
      var file = $("#imgrmv"+this.id).attr("src");
      var id = this.id;
      
      $.ajax({
        type:"POST",
        url:"{{url('/')}}/{{'admin/vendorlisting/del_video'}}",
        data:{file:file},
        dataType: "json",
        success: function(data){
          $("#imgrmv"+id).hide();
          window.location.reload();
         }
      });

 });

      $('.imgadd_remove').click(
    function()
    {
      var file = $("#imgadd_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"{{'/admin/vendorlisting/del_image'}}",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#add_"+id).hide();
           window.location.reload();
         }
      });

 });

      $('.video_remove').click(
    function()
    {
      
      var file = $("#imgadd_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"{{url('/')}}/{{'admin/vendorlisting/del_video'}}",
        data:{file:file},
        dataType: "json",
        success: function(data){
          $("#imgadd_"+id).hide();
           window.location.reload();
         }
      });

 });
  </script>

  <script type="text/javascript">
      function readURL(input) {
      if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
      $('#image_upload_preview').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
      }
      }

      $("#form-file-multiple-input").change(function () {
      $('#image_upload_preview').show();
      readURL(this);
});
       function readURL2(input) {
      if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
      $('#image_upload_preview2').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
      }
      }

      $("#form-file-multiple-input2").change(function () {
      $('#image_upload_preview2').show();
      readURL2(this);
});
</script>
@stop