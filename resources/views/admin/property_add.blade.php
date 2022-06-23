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
<link href="{{ asset('resources/views/admin/amenities/flaticon.css') }}" rel="stylesheet" type="text/css"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>
<style type="text/css">.glyph .glyph-icon {
        padding: 10px;
        display: block;
        font-family:"Flaticon";
        font-size: 64px;
        line-height: 1;
    }select {
  font-family: "Flaticon";}
    .burger-menu {text-align: right;display: block;margin-left: 100px;
  margin-right: auto;margin-bottom: auto;margin-top: 1px;cursor: pointer;}
.dropdown {position: relative;display: inline-block;width: 100%;
    border: 1px solid #ccc;border-radius: 3px;padding: 6px 6px;
    color: #555;}
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #ffffff;
    min-width: 170px;
    z-index: 1;
    top: 29px;
    left: 0;
    border: 1px solid #ccc;
}

.dropdown-content span {
    color:#515763;
    border-bottom: 1px solid #eaeaea;
    padding: 8px 10px;
    text-align: center;
    text-decoration: none;
    display: block;
    text-align: left;
    font-size:14px;
}

.dropdown-content span:hover {
  background-color: #ffffff;
  color: black;
  border-bottom: 1px solid #999;
}

.dropdown .dropdown-content.show {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #ffffff;
}
.dropdown .glyph-icon {display: inline-block;
    padding: 0 10px 0px 0px;}
.dropdown .flaticon-book:before {position: relative;top: 2px;margin-left: 0;}
  </style>


@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Add Listing</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">Add Listing</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary testimonialadd">
        <div class="panel-heading">
          <h4 class="panel-title">Add Listing</h4>
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
                  <div class="stepwizard-step" id="work3name">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled>Working Hrs</a>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled>Project Gallery</a>
                  </div>
                  <div class="stepwizard-step">
                  <a href="#step-5" type="button" class="btn btn-default btn-circle shop_info" disabled>Shop Info</a>
                  </div>
                </div>
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="listing">
                    <div class="row setup-content" id="step-1">
                      <div class="col-md-6 paddleft0">


                          <input type="hidden" name="category" id="category" value="1">
                        
                        
                        <div class="form-group" id="sigale">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Sub Category:</label>
                            <div class="col-sm-12 select_margin">
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

                          <input type="hidden" name="vendor" id="vendor" value="{{ Sentinel::getUser()->id }}">
                       
                        <div class="form-group" id="urname">
                          <div class="row">
                            <label class="control-label col-sm-12">URL Name:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="url_name" id="url_name" placeholder="URL Name">
                            </div>
                          </div>
                        </div>
                        
                        
                        
                        <p id="url" style="color: red;"></p>

                          <div class="form-group property_class"  >
                          <div class="row">
                            <label class="control-label col-sm-12">RERA Number:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="rera_number" id="rera_number" placeholder="RERA Number">
                            </div>
                          </div>
                        </div>

                         <div class="form-group property_class"  >
                          <div class="row">
                            <label class="control-label col-sm-12">RERA Link:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="rera_link" id="rera_link" placeholder="RERA Link">
                            </div>
                          </div>
                        </div>

                        <div class="form-group" id="pname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="project_name">Project Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="address">Address:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="locname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="near_by">Location:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="near_by" name="near_by" placeholder="Near By Location" required>
                            </div>
                          </div>
                        </div>
                  
                        <div class="form-group">
                           <div class="row">
                          <label class="control-label col-sm-12" for="near_by">City:</label>
                          <div class="col-sm-12">
                          <select id="l_city" name="city" class="form-control">
                           <option value="">City</option>
                              @foreach($city_info as  $citys)
                                  
                                  <option value="{{ $citys->City_Name }}">{{ $citys->City_Name }}</option>
                                   
                              @endforeach
                          </select>  
                          </div>
                        </div>
                        </div>

                        <div class="form-group">
                           <div class="row">
                          <label class="control-label col-sm-12" for="near_by">Area:</label>
                          <div class="col-sm-12">
                          <select id="state" name="area" class="form-control">
                           <option value="">Area name</option>
                          </select>  
                          </div>
                        </div>
                        </div>  

                        <div class="form-group" id="zipname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="Zip_Code">Zip Code:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="Zip_Code" id="Zip_Code" placeholder="Zip Code" required >
                            </div>
                          </div>
                        </div>

                        <div class="form-group" id="ptagname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="tags">Project Tags:</label>
                            <div class="col-sm-12">
                              <input type="text" name="pro_tags" id="pro_tags" value="" data-role="tagsinput" required/>
                            </div>
                          </div>
                        </div>
                         <div class="form-group" style="display: none">
                          <div class="row">
                            <label class="control-label col-md-3" for="video">Video:</label>
                            <div class="col-md-9">
                             <input type="file" name="video" id="file">
                             <br>
                             <p id="fp" style="color:red"><strong>NOTE:</strong> Max Video Size Is 50MB</p>
                            </div>
                          </div>
                        </div>


                        
                        <div class="form-group property_class" >
                          <div class="row">
                            <label class="control-label col-sm-12">Listed By:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="listed_by" id="listed_by" placeholder="" value="Owner">
                            </div>
                          </div>
                        </div>

                         <div class="form-group property_class" >
                          <div class="row">
                            <label class="control-label col-sm-2" for="amenities" >Amenities:</label>
                            <input class="form-pls" value="Add" type="button" name="submit" id="AmenitiesAdd">
                           <div class="col-sm-6">
                              <select class="form-control" id="ameniti_id">
                                <option>Select</option>
                                <option value="1">Power Backup</option>
                                <option value="2">Lift</option>
                                <option value="3">24*7 Water Supply</option>
                                <option value="4">24*7 Security Service</option>
                                <option value="5">Parking Space</option>
                                <option value="6">Vaastu Compliant Design</option>
                                <option value="7">Ventilation</option>
                                <option value="9">Fitness Center / GYM</option>
                                <option value="10">Spa</option>
                                <option value="11">Yoga</option>
                                <option value="12">Swimming Pool</option>
                                <option value="13">Playground</option>
                                <option value="14">Community Center</option>
                                <option value="15">Media Room</option>
                                <option value="16">Party Room</option>
                                <option value="17">Community events and classes</option>
                                <option value="18">Outdoor Areas</option>
                                <option value="19">Jogging/walking</option>
                                <option value="20">Eco Friendly</option>
                                <option value="21">Proximity Area</option>
                                <option value="22">On Site Maintenance</option>
                                <option value="23">Electric car charging stations</option>
                                <option value="24">Pets Allowed</option>
                                <option value="25">Wood Flooring</option>
                                <option value="26">Storage in unit</option>
                                <option value="27">Wi-Fi</option>
                                <option value="28">High-Speed Internet</option>
                                <option value="29">Cable TV</option>
                                <option value="30">Close to schools</option>
                                <option value="31">Babysitting Services</option>
                                <option value="32">CCTV Surveillance</option>
                                <option value="33">Doorman</option>
                                <option value="34">Gated Access</option>
                                <option value="35">Valet Trash</option>
                                <option value="36">Recycling Center</option>
                                <option value="37">Doorstep Recycling Collection</option>
                                <option value="38">Laundry Facility</option>
                                <option value="39">Dance studio</option>
                                <option value="40">Video Door Phone</option>
                                <option value="41">Gas Connection</option>
                                <option value="42">Main Entrance Door</option>
                                <option value="43">Wi- Fi Smart Homes</option>
                                <option value="44">Customized Wi- Fi Smart Homes</option>
                                <option value="45">Terrace Garden</option>
                                <option value="46">Garden GYM</option>
                                <option value="47">Senior Citizen Seating</option>
                                <option value="48">Indoor Games</option>
                                <option value="49">Celebration Lawn</option>
                                <option value="50">Rest Room</option>
                                <option value="51">River Facing</option>
                                <option value="52">Basement</option>
                                <option value="53">Fire Safety</option>
                                <option value="54">Management Office</option>
                                <option value="55">Library</option>
                                <option value="56">School Drop off Zone</option>
                                <option value="57">Earthquake Resistance RCC Structure</option>
                                <option value="58">Indoor Games Club House</option>
                                <option value="59">Guest waiting Room</option>
                                <option value="60">Hydro. Pressure Pump</option>
                                <option value="61">Z+ Security System</option>
                                <option value="62">Adequate Street Light</option>
                                <option value="63">Steam Bathroom</option>
                                <option value="64">Splash Pool</option>
                                <option value="65">Basketball Hoop</option>
                                <option value="66">Skating Area</option>
                              </select>    

                              <img src="" id="amenitiimg_id" hidden="">                          
                            </div>
                          </div>
                        </div>

                       <div class="form-group property_class" >
                          <div class="row">
                            <label class="control-label col-sm-12">Multiple Amenities:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="" name="pro_amenities" id="amenities" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="form-group property_class" >
                          <div class="row">
                            <label class="control-label col-sm-12" for="brochure">Brochure:</label>
                            <div class="col-sm-12">
                              <input type="file" name="brochure" id="brochure" />
                            </div>
                          </div>
                        </div>

                        
                      </div>

                      <div class="col-md-6 paddleft0">
                        <div class="form-group property_class multiple-form-group col-sm-12"  >
                          <div class="select_margin">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="input-group-btn input-group-select">
                                <button type="button" class="btn btn-default dropdown-toggle bhkbtn" data-toggle="dropdown">
                                  <span class="concept">Select</span> 
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="#Hk" class="shop_select">Hk</a></li>
                                  <li><a href="#1Bhk" class="shop_select">1Bhk</a></li>
                                  <li><a href="#1&#8228;5Bhk" class="shop_select">1&#8228;5Bhk</a></li>
                                  <li><a href="#2Bhk" class="shop_select">2Bhk</a></li>
                                  <li><a href="#2&#8228;5Bhk" class="shop_select">2&#8228;5Bhk</a></li>
                                  <li><a href="#3Bhk" class="shop_select">3Bhk</a></li>
                                  <li><a href="#3&#8228;5Bhk" class="shop_select">3&#8228;5Bhk</a></li>
                                  <li><a href="#4Bhk" class="shop_select">4Bhk</a></li>
                                  <li><a href="#5Bhk" class="shop_select">5Bhk</a></li>
                                   <li><a href="#6Bhk" class="shop_select">6Bhk</a></li>
                                  <li><a href="#6&#8228;5Bhk" class="shop_select">6&#8228;5Bhk</a></li>
                                  <li><a href="#shop" class="res_shop">Shop</a></li>
                                </ul>
                                
                                <input type="hidden" class="input-group-select-val" name="super_area[type][]" value="2bhk" placeholder="super_area">
                                <input type="hidden" class="input-group-select-val" name="carpet_area[type][]" value="2bhk" placeholder="carpet_area">
                                <input type="hidden" class="input-group-select-val" name="transaction_type[type][]" value="2bhk" placeholder="transaction_type">
                                <input type="hidden" class="input-group-select-val" name="bathrooms[type][]" value="2bhk" placeholder="Bathroom">
                                <input type="hidden" class="input-group-select-val" name="bedroom[type][]" value="2bhk" placeholder="Bedroom">
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="row">
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label property_class">Built Up area:</label>
                                            <input type="text" class="form-control namevalue super_area" name="super_area[2bhk][]" id="super_area" placeholder="SqrYd">
                                          </div>
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-add add-bedroom">+</button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label property_class">Price/ft2:</label>
                                            <input type="text" class="form-control price_perft" name="price_perft" id="price_perft" placeholder="Property Price">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label property_class">Short Title:</label>
                                            <input type="text" class="form-control p_short" name="p_short" id="p_short" placeholder="Ex. 1bhk 515 sq-ft flat">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group hide_section"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label  property_class">Bedroom:</label>
                                            <input type="text" class="form-control namevalue bedroom" name="bedroom[2bhk][]" id="bedroom" placeholder="Bedrooms">
                                          </div>
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-add">+</button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group" >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                             <label class="control-label property_class bathroom">Bathrooms:</label>
                                            <label class="control-label washroom" style="display: none">Washroom:</label>
                                            <input type="text" class="form-control namevalue bathrooms" name="bathrooms[2bhk][]" id="bathrooms" placeholder="">
                                          </div>
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-add">+</button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label property_class">Property Price:</label>
                                           <input type="text" class="form-control price" name="price" id="price" placeholder="Property Price">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox possession_date">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label property_class">Possession Date:</label>
                                           <input type="text" class="form-control" name="possession_date" id="possession_date" placeholder="Possession Date">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="row">
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class="propertiesbox" id="carpet_area">
                                      <div class="row">
                                        <div class="select_margin">
                                               <div class="form-group">
                                          <label class="control-label  property_class">Carpet Area:</label>
                                          <input type="text" class="form-control namevalue carpet_area" name="carpet_area[2bhk][]" id="carpet_area" placeholder="SqrYd">
                                        </div>
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-add">+</button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class="propertiesbox" id="transaction_type">
                                      <div class="row">
                                        <div class="select_margin">
                                               <div class="form-group">
                                          <label class="control-label  property_class">Transaction Type:</label>
                                          <input type="text" class="form-control namevalue transaction_type" name="transaction_type[2bhk][]" id="transaction_type" placeholder="SqrYd">
                                        </div>
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-add">+</button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group" >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                               <div class="form-group">
                                          <label class="control-label property_class">Status:</label>
                                          <input type="text" class="form-control p_status" name="p_status" id="p_status" placeholder="Property Status">
                                                </div>
                                               
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                               <div class="form-group">
                                          <label class="control-label property_class">Floor:</label>
                                          <input type="text" class="form-control floor" name="floor" id="floor" placeholder="">
                                        </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                                <div class="form-group">
                                          <label class="control-label property_class">Car parking:</label>
                                          <select name="car_parking" id="car_parking" class="form-control car_parking">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                          </select>
                                         </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group hide_section"  >
                                    <div class=" propertiesbox">
                                      <div class="row">
                                        <div class="select_margin">
                                                <div class="form-group">
                                          <label class="control-label property_class">Furnishing:</label>
                                       <input type="text" class="form-control furnishing" name="furnishing" id="furnishing" placeholder="Furnishing">
                                     </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group property_class multiple-form-group"  >
                                    <div class=" propertiesbox tower">
                                      <div class="row">
                                        <div class="select_margin">
                                          <div class="form-group">
                                            <label class="control-label property_class">Tower:</label>
                                            <input type="text" class="form-control" name="tower" id="tower" placeholder="Tower">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-success btn-add hide_section">+</button>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-12" id="abname">
                        <div class="form-group">
                            <label for="about_project" class=" ">About Project</label>
                            <textarea class="form-control resize_vertical " name="about_project" id="about_project" rows="3" required></textarea>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                      </div>
                    </div>

                    <div class="row setup-content" id="step-2">
                      <div class="row">
                        <div class="col-md-6 paddleft0">
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="first_Name" name="first_Name" placeholder="First Name" required>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="last_Name">Last Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="last_Name" id="last_Name" placeholder="Last Name" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="email">Email:</label>
                            <div class="col-sm-12">
                              <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Phone:</label>
                            <div class="col-sm-12">
                              <input type="number" name="phone_Number" class="form-control" id="phone_Number" placeholder="Phone Number" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="webname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Website:</label>
                            <div class="col-sm-12">
                              <input type="text" name="website" class="form-control" id="website" placeholder="Website">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="fbname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Face book:</label>
                            <div class="col-sm-12">
                              <input type="text" name="face_book" class="form-control" id="face_book" placeholder="FB Link">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="yuname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">You tube:</label>
                            <div class="col-sm-12">
                              <input type="text" name="you_tube" class="form-control" id="you_tube" placeholder="Your Tube">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="viname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Video Link:</label>
                            <div class="col-sm-12">
                              <input type="text" name="l_video_link" class="form-control" id="l_video_link" placeholder="Promo Video Link">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 paddleft0">
                          <div class="form-group" id="achname">
                              <label for="area" class="control-label col-sm-12">Achievements</label>
                              <div class="col-sm-12"><textarea class="form-control resize_vertical" name="achievements" id="achievements" rows="3"></textarea> </div>
                          </div>

                          <div class="form-group" id="ppname">
                              <label for="area" class="control-label col-sm-12">Past Projects</label>
                            <div class="col-sm-12">  <textarea class="form-control resize_vertical" name="past_project" id="past_project" rows="3"></textarea> </div>
                          </div>

                          <div class="form-group" id="cpname">
                              <label for="area" class="control-label col-sm-12">Current Project</label>
                              <div class="col-sm-12"><textarea class="form-control resize_vertical" name="current_project" id="current_project" rows="3"></textarea> </div>
                          </div>
                          <div class="form-group">
                            <label for="area" class="control-label col-sm-12">Logo</label>
                              <div class="col-sm-12">
                              <input type="file" name="logo"> 
                              </div>
                          </div>
                          <br>
                          <div class="form-group" id="chname">
                          <div class="row">
                              <div class="makeit-popular-checkbox">
                                   <input type="checkbox" name="l_feature" id="l_feature">
                                <label>Make it popular</label>
                              </div>
                            </div>
                          </div>
                          <div class="form-group" id="chname">
                          <div class="row">
                              <div class="makeit-popular-checkbox">
                                   <input type="checkbox" name="l_feature" id="l_feature">
                                <label>Prime Customer</label>
                              </div>
                            </div>
                          </div>
                      </div>
                      </div>
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>

                    <div class="row setup-content" id="step-3">
                      <div class="row">
                        <div class="form-group checkboxgroup" id="workname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Working Days:</label>
                            <div class="col-sm-12">
                              <div class="checkbox">
                                  <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox1" value="1" aria-label="Single checkbox One">
                                  <label>Monday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox2" value="2" aria-label="Single checkbox One">
                                <label>Tuesday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox3" value="3" aria-label="Single checkbox One">
                                <label>Wednesday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox4" value="4" aria-label="Single checkbox One">
                                <label>Thursday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox5" value="5" aria-label="Single checkbox One">
                                <label>Friday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox6" value="6" aria-label="Single checkbox One">
                                <label>Saturday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox7" value="7" aria-label="Single checkbox One">
                                <label>Sunday</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="workhrname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Working Hrs:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="working_time" id="working_time" placeholder="Working Time">
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
                              <div class="col-sm-12 pad-top20">
                                      <div class="sliderimages">
                                  <input type="file" id="form-file-multiple-input" class="gallery_image" name="inputFile[]" multiple="" required="required">
                                  </div>
                          </div>
                      </div></div>
                      <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12 control-label" for="form-file-multiple-input">Banner Images</label>
                            <div class="col-sm-12 pad-top20">
                                     <div class="sliderimages">
                                <input type="file" id="form-file-multiple-input" class="banner_image" name="banner[]" multiple="" required="required">
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <label class="col-sm-12 control-label" for="eatured">Featured Image</label>
                            <div class="col-sm-12 pad-top20">
                                     <div class="sliderimages">
                                      <input type="file" name="featured_image">
                                    </div>
                            </div>
                        </div>
                      </div>

                      </div>
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right nxt " type="button" >Next</button>
                      

                       <button class="btn btn-primary  btn-lg pull-right pub fb" type="submit" >Publish</button>
                    </div>


                    <div class="row setup-content" id="step-5">
                      <div class="row">
                      <div class="form-group  multiple-form-group" >
                          <div class=" propertiesbox">
                          <div class="row">
                          <div class="select_margin">
                          <div class="form-group">
                          <label class="control-label property_class">Price:</label>
                          <input type="text" class="form-control namevalue price" name="shop_price" id="shop_price" placeholder="Property Price">
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="form-group  multiple-form-group">
                          <div class=" propertiesbox">
                          <div class="row">
                          <div class="select_margin">
                          <div class="form-group">
                          <label class="control-label property_class">Built Up area:</label>
                          <input type="text" class="form-control namevalue super_area" name="shop_area" id="shop_area" placeholder="">
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="form-group  multiple-form-group" >
                          <div class=" propertiesbox">
                          <div class="row">
                          <div class="select_margin">
                          <div class="form-group">
                          <label class="control-label property_class">Washrooms:</label>
                          <input type="text" class="form-control namevalue bathrooms" name="shop_washroom" id="shop_washroom" placeholder="">
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="form-group  multiple-form-group" >
                          <div class=" propertiesbox">
                          <div class="row">
                          <div class="select_margin">
                          <div class="form-group">
                          <label class="control-label property_class">Floor:</label>
                          <input type="text" class="form-control namevalue floor" name="shop_floor" id="shop_floor" placeholder="">
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          <div class="form-group  multiple-form-group" >
                          <div class=" propertiesbox">
                          <div class="row">
                          <div class="select_margin">
                          <div class="form-group">
                          <label class="control-label property_class">Car parking:</label>
                          <select name="shop_car_parking" id="shop_car_parking" class="form-control namevalue car_parking">
                          <option value="">Select</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                          </select>
                      </div>
                      </div>
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
  
  var BuilUpCategoryCount;
  $("#sub_cat").on('change', function() {
    var categorys = $('#sub_cat').find(":selected").val();

if(categorys == 1)
{
    BuilUpCategoryCount=1;
    $('#bedroom').val("1");
}
});
  $(document).on("click", ".add-bedroom", function() {

    var categorys = $('#sub_cat').find(":selected").val();

if(categorys == 1)
{
    if ($(this).html()== "+") {
        BuilUpCategoryCount = BuilUpCategoryCount + 1;
        let a="";
        for(i=1;i<=BuilUpCategoryCount;i++){
          a += '"'+i+'",'; 
        }
      a=a.slice(0, -1); 
    
    var d = $('#bedroom').val(a);

    }else if ($(this).html()== "–") {
        BuilUpCategoryCount = BuilUpCategoryCount - 1;
        let a="";
        for(i=1;i<=BuilUpCategoryCount;i++){
          a += '"'+i+'",'; 
        }
      a=a.slice(0, -1); 
    
    var d = $('#bedroom').val(a);

    }
    }
  });
 

 
      $(document).ready(function() {
           $('.shop_info').css('display','none');
		   $('.pub').show();
   		   $('.nxt').hide();
 

        $('input#tower').prop('required',false);
        $('input#possession_date').prop('required',false);

        $('.nextBtn').click(function(){
            $('input#possession_date').prop('required',false);
            $('input#tower').prop('required',false);
            
        });



        $('.tower').css('display','none');
         $(".gallery_image").prop('required',true);
          $(".banner_image").prop('required',true);
           $('#possession_date').prop('required',false);
           $('#tower').prop('required',false);

        

         $("#sub_cat").on('change', function() {

          var maincat = $('#category').val();
          var subcat = $('#sub_cat').val();

          var category = $('#sub_cat').find(":selected").val();
         
		  if(maincat == 1 )
          {
            if(subcat == 1){
              
              $('.shop_info').css('display','none');

                 $('input#tower').prop('required',false);
        	$('input#possession_date').prop('required',false);
            
            $('.hide_section').css('display','none');
            $('.washroom').css('display','block');
            $('.bathroom').css('display','none');
            $("#ameniti_id").prop('required',false);
            $("#p_short").prop('required',false);
            $("#bedroom").prop('required',false);
            $("#bathrooms").prop('required',false);
            $("#p_status").prop('required',false);
            $("#transaction_type").prop('required',false);
            $("#furnishing").prop('required',false);
            $('.shop_select').css('display','none');
            $('.possession_date').show();
            $('.tower').show();
          }
          else{
             $('.hide_section').css('display','block');
             $('.washroom').css('display','none');
             $('.bathroom').css('display','block');
             $('.res_shop').css('display','none');
             $('.possession_date').css('display','none');
             $('.tower').css('display','none');
          }
        }else{

             $('.bathroom').css('display','block');
             $('.washroom').css('display','none');

        }
      });

        
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
          $('.gallery_image').click(function(){

            $(this).prop("required", "true");

          });
      
      $('#url_name').on('blur',function(){
        var url_name=$('#url_name').val();
        $.ajax({
              type:"POST",
              url:"{{url('/admin/vendorlisting/url_name')}}",
              data: {url_name : url_name},
              success:function(data){
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
    });
	
function getDataCategory(){
	
          var category = "";
          var cat = 1;
          if (cat != '') {
              $.ajax({
                  type: "GET",
                  dataType: "json",
                  url: "{{url('/admin/report/add/sub')}}?category=" + cat,
                  success: function(data) {
                      if (data) {
                        
                          $('#mul').hide();
                          $("#sub_cat").empty();
                          $("#sub_cat").append('<option value="">Select Sub Category</option>');
                          $.each(data, function(key, value) {
                              $("#sub_cat").append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                        
                      }
                  }
              })
               
          
		  
		
		  } 
      
}	
(function ($) {
    $(function () {
		
		getDataCategory();
        var addFormGroup = function (event) {
            event.preventDefault();
            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();
            $(this)
                .toggleClass('btn-success btn-add btn-danger btn-remove')
                .html('–');

            $formGroupClone.find('input').val('');
            $formGroupClone.find('.concept').text('Select');
            $formGroupClone.insertAfter($formGroup);
            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            }
        };
        var removeFormGroup = function (event) {
            event.preventDefault();
            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }
            $formGroup.remove();
        };
        var selectFormGroup = function (event) {
            event.preventDefault();
            var $selectGroup = $(this).closest('.input-group-select');
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).text();
            var $formGroup = $(this).closest('.form-group');
            $formGroup.find(".namevalue").each( function() {
              var name = $(this).attr('class').split(' ')[2];
              $(this).attr('name',name+'['+param+'][]');
            });
            $selectGroup.find('.concept').text(concept);
            $selectGroup.find('.input-group-select-val').val(param);
        }
        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };
        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);
        $(document).on('click', '.dropdown-menu a', selectFormGroup);

    });
})(jQuery);
</script>
<script type="text/javascript">
 $("#l_city").on('change',function(){
        var City_Id = $(this).val(); 
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if (data) {
                    //Empty Drop Down
                    $("#state").empty();

                    $("#state").append('<option value="">Select Area name</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        })
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
  $("#AmenitiesAdd").click(function(){
      var obj = new Object();
          obj =  $('#ameniti_id').val().split(',')
      var a = obj[obj.length-1];
      var b = $('#ameniti_id').find(":selected").text();
      var c = b +"~"+ a;
      var temp = $('#amenities').val();
      $('#amenities').val(temp+ " " +  c + ","); 
      $('#ameniti_id').val("")
    });
});
$("#ameniti_id").change(function(){
   var b = $('#ameniti_id').find(":selected").val();
   var src = "{{url('/')}}/public/images/amenities/"+ b +".png";
   var image = $('#amenitiimg_id').attr('src', src);
});
</script>
@stop