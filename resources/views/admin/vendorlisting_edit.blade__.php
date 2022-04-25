@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit Product Listing
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link type="text/css" href="{{ asset('public/assets/vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('public/assets/vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />
<link href="{{ asset('public/assets/css/pages/tagsinput.css') }}" rel="stylesheet" />

<link href="{{ asset('public/assets/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('public/assets/css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/pages/wizard.css') }}" rel="stylesheet">
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Edit Listing</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Edit Listing</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary testimonialadd">
        <div class="panel-heading">
          <h4 class="panel-title">Edit Listing</h4>
        </div>
        <div class="panel-body">
          <form method="post" id="addtestimonail" enctype="multipart/form-data">
            <div class="bs-example">
              <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                  <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">Company Info</a>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled>Personal Info</a>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled>Working Hrs</a>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled>Project Gallery</a>
                  </div>
                </div>
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="listing">

                  <div class="row setup-content" id="step-1">
                      <div class="col-md-6 paddleft0">


                        @if (!Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Category:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="category" id="category" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($category as $c)
                                @if (isset($lisitng) && $c->id == $lisitng->l_category)
                                <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                @else
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        @else
                          <input type="hidden" name="category" id="category" value="{{ Sentinel::getUser()->user_category }}">
                        @endif

                        <div class="form-group" id="mul" hidden>
                          <div class="row">
                            <label class="control-label col-sm-12">Select Sub Category:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="sub[]" id="select57" class="form-control select2" required multiple>
                                <option value="">Select Sub Category</option>
                                @if ($lisitng->l_sub_category != '')
                                  <?php $sub = explode(',', $lisitng->l_sub_category); ?>
                                    @foreach($type as $key => $val)
                                      @if (in_array($val->id,$sub))
                                       <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                      @else
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                      @endif
                                    @endforeach
                                @endif
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="sigale">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Sub Category:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="sub_cat" id="sub_cat" class="form-control" required>
                                <option value="">Select Sub Category</option>
                                @foreach($type as $val)
                                  @if($val->id == $lisitng->l_sub_category)
                                    <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                  @else
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>

                        @if (!Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Vendor:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="vendor" id="vendor" class="form-control" required>
                                <option value="">Select Vendor</option>
                                @foreach($vendors as $v)
                                  @if($v->id == $lisitng->u_id)
                                    <option value="{{$v->id}}" selected="selected">{{$v->company_name}}</option>
                                  @else
                                    <option value="{{$v->id}}">{{$v->company_name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        @else
                          <input type="hidden" name="vendor" id="vendor" value="{{ Sentinel::getUser()->id }}">
                        @endif

                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">URL Name:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" value="{{ $lisitng->url_name }}" class="form-control" name="url_name" id="url_name" placeholder="URL Name">
                            </div>
                          </div>
                        </div>
                        <p id="url" style="color: red;"></p>

                        <div class="form-group" id="pro_cate" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Product Category:</label>
                            <div class="col-sm-12 select_margin">
                              <select id="select22" class="form-control select2" name="product_category[]" multiple>
                                @if ($lisitng->product_category != '')
                                  <?php $prcategory = explode(',', $lisitng->product_category); ?>
                                  @foreach($proCate  as $key => $val)
                                      @if (in_array($val->cate_id,$prcategory))
                                          <option value="{{ $val->cate_id }}" selected>{{ $val->cate_name }}</option>
                                      @else
                                          <option value="{{ $val->cate_id }}">{{ $val->cate_name }}</option>
                                      @endif
                                  @endforeach
                                @endif
                              </select>
                            </div>
                          </div>
                        </div>
                          <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">RERA Number:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->rera_number }}" name="rera_number" id="rera_number" placeholder="RERA Number">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Property Price:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->price }}" name="price" id="price" placeholder="Property Price">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Price/ft2:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->price_perft }}" name="price_perft" id="price_perft" placeholder="Property Price">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class"   style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Short Title:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->short_title }}" name="p_short" id="p_short" placeholder="Ex. 1bhk 515 sq-ft flat">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Bedroom:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->bedroom }}" name="bedroom" id="bedroom" placeholder="Bedrooms">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Bathrooms:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->bathroom }}" name="bathrooms" id="bathrooms" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Built Up area:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->super_area }}" name="super_area" id="super_area" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Carpet area:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->carpet_area }}" name="carpet_area" id="carpet_area" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Status:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->status }}" name="p_status" id="p_status" placeholder="Property Status">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Floor:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->floor }}" name="floor" id="floor" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Transaction type:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->type }}" name="transaction_type" id="transaction_type" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Car parking:</label>
                            <div class="col-sm-12 select_margin">
                              <select name="car_parking" id="car_parking" class="form-control">
                                <option value="1" <?php ($lisitng->car_parking == '1') ? 'selected ': '' ?>>Yes</option>
                                <option value="0" <?php ($lisitng->car_parking == '0') ? 'selected ': '' ?>>No</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Furnishing:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->furnishing }}" name="furnishing" id="furnishing" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Listed By:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->listed_by }}" name="listed_by" id="listed_by" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="amenities">Amenities:</label>
                            <div class="col-sm-12">
                              <input type="text" name="pro_amenities" value="{{ $lisitng->amenities }}" data-role="tagsinput"/>
                            </div>
                          </div>
                        </div>

                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="brochure">Brochure:</label>
                            <div class="col-sm-12">
                              <input type="file" name="brochure" id="brochure" />
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-6 paddleft0">
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="project_name">Project Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->l_title }}" name="project_name" id="project_name" placeholder="Project Name" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="address">Address:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->l_location }}" name="address" id="address" placeholder="Address" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="near_by">Location:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="near_by" value="{{ $lisitng->l_nearby }}" name="near_by" placeholder="Near By Location" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="city">City:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="city" value="{{ $lisitng->city }}" id="city" placeholder="City" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="Zip_Code">Zip Code:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->Zip_Code }}" name="Zip_Code" id="Zip_Code" placeholder="Zip Code" required >
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="tags">Project Tags:</label>
                            <div class="col-sm-12">
                              <input type="text" name="pro_tags" value="{{ $lisitng->l_key_area }}" data-role="tagsinput" required/>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="video">Video:</label>
                            <div class="col-sm-12">
                             <input type="file" name="video" id="file" accept="video/*" onchange="GetFileSize()"/>
                             <label>{{ $lisitng->l_video }}</label>
                             <br>
                             <p id="fp" style="color:red"><strong>NOTE:</strong> Max Video Size Is 50MB</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12">
                      <div class="form-group">
                          <label for="about_project">About Project</label>
                          <textarea class="form-control resize_vertical" name="about_project" id="about_project" rows="3" required>{{ $lisitng->l_description }}</textarea>
                      </div>

                      </div>
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>

                    <div class="row setup-content" id="step-2">
                      <div class="row">
                        <div class="col-md-6 paddleft0">
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="first_Name" name="first_Name" value="{{$lisitng->first_name}}" placeholder="First Name" required>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="last_Name">Last Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{$lisitng->last_name}}" name="last_Name" id="last_Name" placeholder="Last Name" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="email">Email:</label>
                            <div class="col-sm-12">
                              <input type="email" class="form-control" value="{{$lisitng->email}}" name="email" id="email" placeholder="Email" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Phone:</label>
                            <div class="col-sm-12">
                              <input type="number" name="phone_Number" value="{{$lisitng->Phone}}" class="form-control" id="phone_Number" placeholder="Phone Number" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Website:</label>
                            <div class="col-sm-12">
                              <input type="text" name="website" value="{{$lisitng->website}}" class="form-control" id="website" placeholder="Website">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Face book:</label>
                            <div class="col-sm-12">
                              <input type="text" name="face_book" value="{{$lisitng->facebook}}" class="form-control" id="face_book" placeholder="FB Link">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">You tube:</label>
                            <div class="col-sm-12">
                              <input type="text" name="you_tube" value="{{$lisitng->youtube}}" class="form-control" id="you_tube" placeholder="Your Tube">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Video Link:</label>
                            <div class="col-sm-12">
                              <input type="text" name="l_video_link" value="{{$lisitng->l_video_link}}" class="form-control" id="l_video_link" placeholder="Promo Video Link">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 paddleft0">
                          <div class="form-group">
                              <label for="area" class="control-label col-sm-12">Achievements</label>
                               <div class="col-sm-12"> <textarea class="form-control resize_vertical" name="achievements" id="achievements" rows="3">{{$lisitng->achievements}}</textarea>
                          </div> </div>

                          <div class="form-group">
                              <label for="area" class="control-label col-sm-12">Past Projects</label>
                               <div class="col-sm-12"> <textarea class="form-control resize_vertical" name="past_project" id="past_project" rows="3">{{$lisitng->past_projects}}</textarea>
                          </div> </div>

                          <div class="form-group">
                              <label for="area" class="control-label col-sm-12">Current Project</label>
                              <div class="col-sm-12">  <textarea class="form-control resize_vertical" name="current_project" id="current_project" rows="3">{{$lisitng->current_project}}</textarea>
                          </div> </div>
                           @if (!Sentinel::inRole('vendor'))
                          <div class="form-group">
                              <div class="row ">
                                  <div class="makeit-popular-checkbox">
                                      <input type="checkbox" name="l_feature" id="l_feature" <?php echo ($lisitng->l_featured == '1') ? 'checked=checked' : ''?>>
                                    <label>Make it popular:</label>
                                  </div>
                                </div>
                              </div>
                              @endif
                          </div>


                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                         </div>
                    </div>

                    <?php $workingdays = explode(',', $lisitng->working_hr); ?>

                    <div class="row setup-content" id="step-3">
                      <div class="row">
                        <div class="form-group checkboxgroup">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Working Days:</label>
                            <div class="col-sm-12">
                              <div class="checkbox">
                                  <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox1" value="1" aria-label="Single checkbox One" <?php echo (in_array('1', $workingdays)) ? 'checked="checked"' : ''?>>
                                  <label>Monday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox2" value="2" aria-label="Single checkbox One" <?php echo (in_array('2', $workingdays)) ? 'checked="checked"' : ''?>>
                                <label>Tuesday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox3" value="3" aria-label="Single checkbox One" <?php echo (in_array('3', $workingdays)) ? 'checked="checked"' : ''?>>
                                <label>Wednesday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox4" value="4" aria-label="Single checkbox One" <?php echo (in_array('4', $workingdays)) ? 'checked="checked"' : ''?>>
                                <label>Thursday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox5" value="5" aria-label="Single checkbox One" <?php echo (in_array('5', $workingdays)) ? 'checked="checked"' : ''?>>
                                <label>Friday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox6" value="6" aria-label="Single checkbox One" <?php echo (in_array('6', $workingdays)) ? 'checked="checked"' : ''?>>
                                <label>Saturday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox7" value="7" aria-label="Single checkbox One" <?php echo (in_array('7', $workingdays)) ? 'checked="checked"' : ''?>>
                                <label>Sunday</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Working Hrs:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="working_time" value="{{ $lisitng->working_time }}" id="working_time" placeholder="Working Time">
                            </div>
                          </div>
                        </div>
                      </div>
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>

                    <div class="row setup-content" id="step-4">
                      <div class="row">
                      <div class="form-group" id="gallery_images">
                          <div class="row">
                              <label class="col-sm-12 control-label" for="form-file-multiple-input">Gallery Images</label>
                                 <div class="col-sm-12">
                                    <div class="sliderimages">
                                <input type="file" id="form-file-multiple-input" name="inputFile[]" multiple="">
                                  </div>
                              </div>

                              <div class="col-sm-12 pad-top20 galleryphotos">

                                  <?php
                                      $directory = "public/images/".$lisitng->vl_id."/pics/";
                                      if (is_dir($directory)) {
                                      $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                      $img = '';
                                      foreach ($files as $key => $value) { ?>
                                        <div id="d_{{$key}}" class="productimg">
                                          <img src="/public/images/{{ $lisitng->vl_id }}/pics/{{ $value }}" id="img_{{$key}}" >

                                         <a href="#" class="cross"> <span class="glyphicon glyphicon-remove img_remove"  id="{{$key}}"></span>
                                         </a>
                                       </div>
                                      <?php } }
                                  ?>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="row">
                              <label class="col-sm-12 control-label" for="form-file-multiple-input">Banner Images</label>
                              <div class="col-sm-12">
                                    <div class="sliderimages">
                                <input type="file" id="form-file-multiple-input" name="banner[]" multiple="">
                                  </div>
                              </div>

                              <div class="col-sm-12 pad-top20 galleryphotos">


                                  <?php
                                      $directory = "public/images/".$lisitng->vl_id."/banner/";
                                      if (is_dir($directory)) {
                                      $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                      $img = '';
                                      foreach ($files as $key => $value) { ?>
                                        <div id="b_{{$key}}" class="productimg">
                                          <img src="/public/images/{{ $lisitng->vl_id }}/banner/{{ $value }}" id="bimg_{{$key}}">

                                         <a href="#" class="cross"> <span class="glyphicon glyphicon-remove b_remove"  id="{{$key}}"></span>
                                         </a>
                                       </div>
                                      <?php } }
                                  ?>
                              </div>
                          </div>
                      </div>

                       <div class="form-group">
                          <div class="row">
                              <label class="col-sm-12 control-label" for="featured_image">Featured Image</label>
                              <div class="col-sm-12">
                                    <div class="sliderimages">
                                <input type="file" name="featured_image">
                                  </div>
                              </div>

                              <div class="col-sm-12 pad-top20 galleryphotos">
                                  <?php
                                      $directory = "public/images/".$lisitng->vl_id."/featured_image/";
                                      if (is_dir($directory)) {
                                      $files = array_values(array_diff(scandir($directory), array('..', '.')));
                                      $img = '';
                                      foreach ($files as $key => $value) { ?>
                                        <div id="f_{{$key}}" class="productimg">
                                          <img src="/public/images/{{ $lisitng->vl_id }}/featured_image/{{ $value }}" id="fimg_{{$key}}">

                                         <a href="#" class="cross"> <span class="glyphicon glyphicon-remove f_remove"  id="{{$key}}"></span>
                                         </a>
                                       </div>
                                      <?php } }
                                  ?>
                              </div>
                          </div>
                      </div>

                      </div>
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit">Publish</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <input type="hidden" value="{{ $lisitng->vl_id }}" name="vl_id" id="vl_id">
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
  <script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" ></script>
  <script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
  <script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" ></script>
  <script src="{{asset('public/assets/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/select2/js/select2.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/sifter/sifter.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/microplugin/microplugin.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/vendors/selectize/js/selectize.min.js') }}"></script>
  <script language="javascript" type="text/javascript" src="{{ asset('public/assets/js/pages/custom_elements.js') }}"></script>
  <script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/assets/js/pages/edituser.js') }}"></script>
  <script src="{{asset('public/assets/vendors/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
  <script  src="{{ asset('public/assets/vendors/ckeditor/js/ckeditor.js') }}"  type="text/javascript"></script>
  <script  src="{{ asset('public/assets/vendors/ckeditor/js/jquery.js') }}"  type="text/javascript" ></script>
  <script  src="{{ asset('public/assets/vendors/ckeditor/js/config.js') }}"  type="text/javascript"></script>
  <script src="{{ asset('public/assets/js/pages/editor.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/assets/vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"  type="text/javascript"></script>

  <script type="text/javascript">
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
         }
      });
    });
      $('.b_remove').click(
    function()
    {
      var file = $("#bimg_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"{{'/admin/vendorlisting/del_image'}}",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#b_"+id).hide();
         }
      });
    });
            $('.f_remove').click(
    function()
    {
      var file = $("#fimg_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"{{'/admin/vendorlisting/del_image'}}",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#f_"+id).hide();
         }
      });
    });
      $(document).ready(function() {
        var cat = $('#category').val();
          if(cat=='4')
          {
            $('#mul').show();
            $('#sigale').hide();
            $('#sub_cat').attr('required',false);
            $('#select57').attr('required',true);
            $('#gallery_images').hide();
          }
          else
          {
            $('#sigale').show();
            $('#mul').hide();
            $('#sub_cat').attr('required',true);
            $('#select57').attr('required',false);
            $('#gallery_images').show();
          }

          //Grab the category
          var catt = "<?php echo Sentinel::getUser()->user_category ?>";

          if (catt == '2' || catt == '3' || catt == '4' || catt == '') {
            $("[for=project_name]").html("Company Name");
            $("#project_name").attr('placeholder',"Company Name");
            $("[for=tags]").html("Company Tags");
            $("[for=about_project]").html("About Company");
          } else {
            $("[for=project_name]").html("Project Name");
            $("#project_name").attr('placeholder',"Project Name");
            $("[for=tags]").html("Project Tags");
            $("[for=about_project]").html("About Project");
          }

          var navListItems = $('div.setup-panel div a'),
              allWells = $('.setup-content'),
              allNextBtn = $('.nextBtn');
          allPrevBtn = $('.prevBtn');

          allWells.hide();

          navListItems.click(function(e) {
              e.preventDefault();
              var $target = $($(this).attr('href')),
                  $item = $(this);

              if (!$item.hasClass('disabled')) {
                  navListItems.removeClass('btn-primary').addClass('btn-default');
                  $item.addClass('btn-primary');
                  allWells.hide();
                  $target.show();
                  $target.find('input:eq(0)').focus();
              }
          });

          allNextBtn.click(function() {
              var curStep = $(this).closest(".setup-content"),
                  curStepBtn = curStep.attr("id"),
                  nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                  curInputs = curStep.find("input[type='text'],input[type='url'],input[type='email'],input[type='number'],select,textarea"),
                  isValid = true;

              $(".form-group").removeClass("has-error");
              for (var i = 0; i < curInputs.length; i++) {
                  if (!curInputs[i].validity.valid) {
                      isValid = false;
                      console.log(curInputs[i]);
                      $(curInputs[i]).closest(".form-group").addClass("has-error");
                  }
              }

              if (isValid)
                  nextStepWizard.removeAttr('disabled').trigger('click');
          });
          allPrevBtn.click(function() {

              var curStep = $(this).closest(".setup-content"),

                  curStepBtn = curStep.attr("id"),

                  prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

              prevStepWizard.removeAttr('disabled').trigger('click');

          });

          $('div.setup-panel div a.btn-primary').trigger('click');


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
                          if(cat=='4')
                        {
                          $('#mul').show();
                          $('#sigale').hide();
                          $('#sub_cat').attr('required',false);
                          $('#select57').attr('required',true);
                          $("#select57").empty();
                          $('#gallery_images').hide();
                          $("#select57").append('<option value="">Select Sub Category</option>');
                          $.each(data, function(key, value) {
                              $("#select57").append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                        }
                        else
                        {
                         $('#sigale').show();
                          $('#mul').hide();
                          $('#sub_cat').attr('required',true);
                          $('#select57').attr('required',false);
                          $("#pro_cate").css('display','none');
                          $("#select22").hide();
                          $('#gallery_images').show();
                          $("#select22").attr("required", false);
                          $("#sub_cat").empty();
                          $("#sub_cat").append('<option value="">Select Sub Category</option>');
                          $.each(data, function(key, value) {
                              $("#sub_cat").append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                        }
                      }
                  }
              })


              $.ajax({
                  type:"GET",
                  dataType: "json",
                  url:"{{url('/admin/report/add/vendor')}}?category="+this.value+"&sub_cat=",
                  success:function(data){
                      if ( data ) {
                          //Empty Drop Down
                          $("#vendor").empty();
                          $("#vendor").append('<option value="">Vendor</option>');
                          $.each( data, function( key, value ) {
                              $("#vendor").append('<option value="'+value.user_id+'">'+value.company_name+'</option>');
                          });
                      }
                  }
              })

              //Grab the all the category list if category is Material

              if (cat == '1') {
                $(".property_class").css('display','block');
                $(".property_class input[name]").attr("required", "true");
                $(".property_class select[name]").attr("required", "true");
                $(".property_class input[name='brochure']").prop('required',false);
              } else {
                $(".property_class").css('display','none');
                $(".property_class input").prop('required',false);
                $(".property_class select").prop('required',false);
              }


          } else {
              $("#sub_cat").empty();
              $("#sub_cat").append('<option value="">Sub Category</option>');
          }
      });


      jQuery("#vendor").on('change', function() {

        var cat = $('#category').val();
        var vendor = $("#vendor").val();

        if (cat == '4' && vendor != '') {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{url('/admin/vendorlisting/getProductCategory')}}?vendor=" + vendor + "&category=" + cat,
                success: function(data) {
                    if (data) {
                        $("#pro_cate").css('display','block');
                        $("#select22").attr("required", "true");
                        $.each(data, function(key, value) {
                          $("#select22").append('<option value="' + value.cate_id + '">' + value.cate_name + '</option>');
                        });
                    }
                }
            })
        }
      });

      $('#url_name').on('blur',function(){
        var url_name=$('#url_name').val();
        var vl_id=$('#vl_id').val();
        $.ajax({
              type:"POST",
              url:"{{url('/admin/vendorlisting/url_name')}}",
              data: {url_name : url_name , vl_id : vl_id},
              success:function(data){
                 // alert(data);
                  if ( data != "" ) {
                    $('.nextBtn').attr('disabled',true);
                    $('#url').html(data);
                  }
                  else{
                    $('.nextBtn').attr('disabled',false);
                     $('#url').html(data);
                  }
              }
          })
      });

      //Show Fields based on the category value
      var cate = $("#category").val();

      if (cate == '1') {
        $(".property_class").css('display','block');
        $(".property_class input[name]").attr("required", "true");
        $(".property_class select[name]").attr("required", "true");
        $(".property_class input[name='brochure']").prop('required',false);
      } else {
        $(".property_class").css('display','none');
        $(".property_class input").prop('required',false);
        $(".property_class select").prop('required',false);
      }

      if (cate == '4') {
        $("#pro_cate").css('display','block');
        $("#select22").prop('required',true);
        $("#select57").prop('required',true);
      } else {
        $("#pro_cate").css('display','none');
        $("#select22").empty();
        $("#select22").prop('required',false);
        $("#select57").empty();
        $("#select57").prop('required',false);
      }

      $("#sub_cat").on('change',function(){

          var cat = $('#category').val();
          var sub_cat = $("#sub_cat").val();

          $.ajax({
              type:"GET",
              dataType: "json",
              url:"{{url('/admin/report/add/vendor')}}?category="+cat+"&sub_cat="+sub_cat,
              success:function(data){
                  if ( data ) {
                    if(cat!='4')
                    {
                      //Empty Drop Down
                      $("#vendor").empty();
                      $("#vendor").append('<option value="">Select Vendor</option>');
                      $.each( data, function( key, value ) {
                          $("#vendor").append('<option value="'+value.user_id+'">'+value.company_name+'</option>');
                      });
                    }
                  }
              }
          })
      });

    });
function GetFileSize()
{
        var fi = document.getElementById('file'); // GET THE FILE INPUT.
        // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
        if (fi.files.length > 0)
        {
            // RUN A LOOP TO CHECK EACH SELECTED FILE.
            for (var i = 0; i <= fi.files.length - 1; i++)
            {
                var fsize = fi.files.item(i).size;      // THE SIZE OF THE FILE.
            }
            $mb=(fsize/1024)/1024;
            if($mb>50)
            {
                    document.getElementById('fp').innerHTML =
                    '<b>Video size should not accessed to 50MB. Current size is:'+$mb.toFixed(2)+'MB</b>';
                    document.getElementById('b').disabled = true;
            }
            else
            {
                  document.getElementById('b').disabled = false;
            }
        }
}
  </script>

@stop