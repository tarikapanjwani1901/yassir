@include('backend.header')

<div class="content-header">
  <h1>Page title</h1>
</div>
<div class="breadcrumb">
  <a href="#"> <i class="fa fa-home"></i></a>
  <a href="#"> Dashboard</a>
  Dashboard
</div>
<div class="col-sm-12">
  <form class="form-horizontal formdesign" action="#">
     <div class="form-group">
        <div class="col-sm-6">
           <label class="control-label" for="name">Name</label>
           <input id="name" name="name" placeholder="Your name" class="form-control" type="text">
        </div>
        <div class="col-sm-6">
           <label class="control-label" for="name">Name</label>
           <input id="name" name="name" placeholder="Your name" class="form-control" type="text">
        </div>
     </div>
     <div class="form-group">
        <div class="col-sm-6">
           <label class="control-label" for="name">File Upload</label>
           <div class="input-group image-preview" data-original-title="" title="">
              <input class="form-control image-preview-filename" disabled="disabled" type="text"> <!-- don't give a name === doesn't send on POST/GET -->
              <span class="input-group-btn">
                 <!-- image-preview-clear button -->
                 <button type="button" class="btn btn-default image-preview-clear">
                 <span class="fa  fa-remove"></span> Clear
                 </button>
                 <!-- image-preview-input -->
                 <div class="btn btn-default image_radius image-preview-input" style="margin-left:-3px;">
                    <span class="fa fa-folder-open"></span>
                    <span class="image-preview-input-title">Browse</span>
                    <input accept="image/png, image/jpeg, image/gif" name="input-file-preview" type="file"> <!-- rename it -->
                 </div>
              </span>
           </div>
        </div>
        <div class="col-sm-6">
           <label class="control-label" for="name">Name</label>
           <input id="name" name="name" placeholder="Your name" class="form-control" type="text">
        </div>
     </div>
     <div class="form-group">
        <div class="col-sm-6 checkborow">
           <div class="checknumber">
              <input type="checkbox">
              <label>Checkobx1</label>
           </div>
           <div class="checknumber">
              <input type="checkbox">
              <label>Checkobx1</label>
           </div>
           <div class="checknumber">
              <input type="checkbox">
              <label>Checkobx1</label>
           </div>
           <div class="checknumber">
              <input type="checkbox">
              <label>Checkobx1</label>
           </div>
        </div>
        <div class="col-sm-6 radiorow">
           <div class="radiobtn">
              <input type="radio">
              <label>Checkobx1</label>
           </div>
           <div class="radiobtn">
              <input type="radio">
              <label>Checkobx1</label>
           </div>
           <div class="radiobtn">
              <input type="radio">
              <label>Checkobx1</label>
           </div>
           <div class="radiobtn">
              <input type="radio">
              <label>Checkobx1</label>
           </div>
        </div>
     </div>
     <div class="form-group">
        <div class="col-sm-12">
           <select class="form-control" id="select1">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
           </select>
        </div>
     </div>
     <!-- forma action row-->
     <div class="form-group">
        <div class="text-right col-sm-12">
           <button type="submit" class="commonbtn"> <i class="fa fa-send"></i> Submit</button>
        </div>
     </div>
  </form>
</div>

@include('backend.footer')