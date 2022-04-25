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
/**modal**/
/*--thank you pop starts here--*/
.thank-you-pop{
  width:100%;
  padding:20px;
  text-align:center;
}
.thank-you-pop img{
  width:76px;
  height:auto;
  margin:0 auto;
  display:block;
  margin-bottom:25px;
}

.thank-you-pop h1{
  font-size: 42px;
    margin-bottom: 25px;
  color:#5C5C5C;
}
.thank-you-pop p{
  font-size: 20px;
    margin-bottom: 27px;
  color:#5C5C5C;
}
.thank-you-pop h3.cupon-pop{
  font-size: 25px;
    margin-bottom: 40px;
  color:#222;
  display:inline-block;
  text-align:center;
  padding:10px 20px;
  border:2px dashed #222;
  clear:both;
  font-weight:normal;
}
.thank-you-pop h3.cupon-pop span{
  color:#03A9F4;
}
.thank-you-pop a{
  display: inline-block;
    margin: 0 auto;
    padding: 9px 20px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    background-color: #8BC34A;
    border-radius: 17px;
}
.thank-you-pop a i{
  margin-right:5px;
  color:#fff;
}
#ignismyModal .modal-header{
    border:0px;
}
/*--thank you pop ends here--*/


  </style>

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
                    <a href="#step-2" type="button" class="btn btn-default btn-circle">Personal Info</a>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle">Working Hrs</a>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle">Project Gallery</a>
                  </div>
                  <div class="stepwizard-step">
                  <a href="#step-5" type="button" class="btn btn-default btn-circle si">Shop Info</a>
                  </div>
                </div>
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="listing">

                  <div class="row setup-content" id="step-1">
                      <div class="col-md-6 paddleft0">
                      
                      @if (Sentinel::inRole('admin'))
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
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Category:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="category" id="category" class="form-control" required readonly>
                                <option value="" disabled="">Select Category</option>
                                @foreach($category as $c)
                                @if (isset($lisitng) && $c->id == $lisitng->l_category)
                                <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                @else
                                <option value="{{$c->id}}" disabled="">{{$c->name}}</option>
                                @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        @endif

                        
                       @if(Sentinel::inRole('admin'))
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
                        
                        @elseif(Sentinel::inRole('vendor'))
                        <div class="form-group" id="mul" hidden>
                          <div class="row">
                            <label class="control-label col-sm-12">Select Sub Category:</label>
                            <div class="col-sm-12 select_margin">
                              
                              <select name="sub[]" id="select57" class="form-control select2" required multiple readonly>
                                <option value="" disabled="">Select Sub Category</option>
                                @if ($lisitng->l_sub_category != '')
                                  <?php $sub = explode(',', $lisitng->l_sub_category); ?>
                                    @foreach($type as $key => $val)
                                      @if (in_array($val->id,$sub))
                                       <option value="{{$val->id}}" selected>{{$val->name}}</option>
                                      @else
                                        <option value="{{$val->id}}" disabled="">{{$val->name}}</option>
                                      @endif
                                    @endforeach
                                @endif
                              </select>
                            </div>
                          </div>
                        </div>
                        
                        @endif

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group" id="sigale">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Sub Category :</label>
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
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group" id="sigale">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Sub Category:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="sub_cat" id="sub_cat" class="form-control" required readonly>
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
                        @endif

                        @if (Sentinel::inRole('admin'))
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
                        @elseif (Sentinel::inRole('vendor'))
                          <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Vendor:</label>
                            <div class="col-sm-12 select_margin ">
                              <select name="vendor" id="vendor" class="form-control" required readonly>
                                <option value="" disabled="">Select Vendor</option>
                                @foreach($vendors as $v)
                                  @if($v->id == $lisitng->u_id)
                                    <option value="{{$v->id}}" selected="selected">{{$v->company_name}}</option>
                                  @else
                                    <option value="{{$v->id}}" disabled="">{{$v->company_name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">URL Name:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" value="{{ $lisitng->url_name }}" class="form-control" name="url_name" id="url_name" placeholder="URL Name">
                            </div>
                          </div>
                        </div>
                        
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12">URL Name:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" value="{{ $lisitng->url_name }}" class="form-control" name="url_name" id="url_name" placeholder="URL Name" readonly>
                            </div>
                          </div>
                        </div>
                        @endif

                        <div class="form-group" id="expname">
                          <div class="row">
                            <label class="control-label col-sm-12">Skill Labour Exp.:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="experience_details" id="experience_details" placeholder="Experience details" value="{{ $lisitng->experience_details }}">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="agename">
                          <div class="row">
                            <label class="control-label col-sm-12">Skill Labour Age:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="age_details" id="age_details" placeholder="Age details" value="{{ $lisitng->age_details }}">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="adname">
                          <div class="row">
                            <label class="control-label col-sm-12">Adharnumber:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" name="adharnumber_details" id="adharnumber_details" placeholder="Adharnumber details" value="{{ $lisitng->adharnumber_details}}">
                            </div>
                          </div>
                        </div>
                        <p id="url" style="color: red;"></p>

                        <div class="form-group" id="pro_cate" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Select Product Category:</label>
                            <div class="col-sm-12 select_margin">
                              <select id="select22" class="form-control select2" name="product_category[]" multiple required>
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

                        @if(Sentinel::inRole('admin'))
                          <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">RERA Number:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->rera_number }}" name="rera_number" id="rera_number" placeholder="RERA Number">
                            </div>
                          </div>
                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">RERA Number:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->rera_number }}" name="rera_number" id="rera_number" placeholder="RERA Number" readonly>
                            </div>
                          </div>
                        </div>
                        @endif

                       
                         <div class="form-group property_class"  style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">RERA Link:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->rera_link }}" name="rera_link" id="rera_link" placeholder="RERA Link">
                            </div>
                          </div>
                        </div>
                       


                         @if(isset($lisitng->prop) && $lisitng->prop != '')

                        @foreach($lisitng->prop['type'] as $key=>$value)


                         <?php


                    $last=end($lisitng->prop['type']);
                        ?>
                          <div class="form-group property_class multiple-form-group col-sm-12"  style="display: none;">
                            <div class="">
                              <div class="row">
                                <div class="select_margin">
                                  <div class="input-group-btn input-group-select">
                                    @if(Sentinel::inRole('admin'))
                                    <button type="button" class="btn btn-default dropdown-toggle bhkbtn" data-toggle="dropdown">
                                      <?php
                                      if(isset($key))
                                       echo '<span class="concept">'.$key.'</span>';
                                      else
                                       echo '<span class="concept">Select</span>';
                                      ?>
                                       <span class="caret"></span>
                                    </button>
                                    @elseif (Sentinel::inRole('vendor'))
                                    <button type="button" class="btn btn-default dropdown-toggle bhkbtn" data-toggle="dropdown" readonly>
                                      <?php
                                      if(isset($key))
                                       echo '<span class="concept">'.$key.'</span>';
                                      else
                                       echo '<span class="concept">Select</span>';
                                      ?>
                                       <span class="caret"></span>
                                    </button>
                                    @endif
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
                                    
                                <input type="hidden" class="input-group-select-val" name="price[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="price_perft[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="p_short[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="bedroom[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="bathrooms[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="super_area[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="carpet_area[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="p_status[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="floor[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="transaction_type[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="car_parking[type][]" value="{{$key}}">
                                <input type="hidden" class="input-group-select-val" name="furnishing[type][]" value="{{$key}}">
                              </div>
                             
                            @if(Sentinel::inRole('admin'))
                              @foreach($detail as $v)

                              <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Property Price:</label>
                                        <input type="text" class="form-control price" name="price" id="price" placeholder="Property Price" value="{{$v->price}}">
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                         
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                           @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Property Price:</label>
                                        <input type="text" class="form-control price" name="price" id="price" placeholder="Property Price" value="{{$v->price}}" readonly>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Price/ft2:</label>
                                        <input type="text" class="form-control price_perft" name="price_perft" id="price_perft" placeholder="Property Price" value="{{$v->price_perft}}">
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Price/ft2:</label>
                                        <input type="text" class="form-control price_perft" name="price_perft" id="price_perft" placeholder="Property Price" value="{{$v->price_perft}}" readonly>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Short Title:</label>
                                        <input type="text" class="form-control p_short" name="p_short" id="p_short" placeholder="Ex. 1bhk 515 sq-ft flat" value="{{$v->short_title}}">
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Short Title:</label>
                                        <input type="text" class="form-control p_short" name="p_short" id="p_short" placeholder="Ex. 1bhk 515 sq-ft flat" value="{{$v->short_title}}" readonly>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          <?php //print_r($lisitng->prop['bedroom']);exit;?>
                          @foreach($lisitng->prop['bedroom'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox bedroom">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Bedroom:</label>
                                        <input type="text" class="form-control bedroom" value="{{$v}}" name="bedroom[{{$key}}][]" id="bedroom" placeholder="Bedrooms">
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($lisitng->prop['bedroom'][$key] as $k=>$v)
                          <div class="form-group multiple-form-group bedroom">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Bedroom:</label>
                                        <input type="text" class="form-control bedroom" value="{{$v}}" name="bedroom[{{$key}}][]" id="bedroom" placeholder="Bedrooms" readonly>
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($lisitng->prop['bathroom'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Bathrooms:</label>
                                        <input type="text" class="form-control bathrooms" value="{{$v}}" name="bathrooms[{{$key}}][]" id="bathrooms" placeholder="">
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($lisitng->prop['bathroom'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Bathrooms:</label>
                                        <input type="text" class="form-control bathrooms" value="{{$v}}" name="bathrooms[{{$key}}][]" id="bathrooms" placeholder="" readonly> 
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($lisitng->prop['super_area'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Built Up Area:</label>
                                        <input type="text" class="form-control namevalue super_area get_value" value="{{ $v }}" name="super_area[{{$key}}][]" id="super_area" placeholder="SqrYd">
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove add-bedroom">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add add-bedroom">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($lisitng->prop['super_area'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Built Up Area:</label>
                                        <input type="text" class="form-control namevalue super_area" value="{{ $v }}" name="super_area[{{$key}}][]" id="super_area" placeholder="SqrYd" readonly>
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove" readonly>-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add" readonly>+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($lisitng->prop['carpet_area'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Carpet Area:</label>
                                        <input type="text" class="form-control namevalue carpet_area" value="{{$v}}" name="carpet_area[{{$key}}][]" id="carpet_area" placeholder="SqrYd">
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($lisitng->prop['carpet_area'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Carpet Area:</label>
                                        <input type="text" class="form-control namevalue carpet_area" value="{{$v}}" name="carpet_area[{{$key}}][]" id="carpet_area" placeholder="SqrYd" readonly>
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove" readonly>-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add" readonly>+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Status:</label>
                                        <input type="text" class="form-control p_status" value="{{$v->status}}" name="p_status" id="p_status" placeholder="Property Status">
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Status:</label>
                                        <input type="text" class="form-control p_status" value="{{$v->status}}" name="p_status" id="p_status" placeholder="Property Status" readonly>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Floor:</label>
                                        <input type="text" class="form-control floor" value="{{$v->floor}}" name="floor" id="floor" placeholder="">
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Floor:</label>
                                        <input type="text" class="form-control floor" value="{{$v->floor}}" name="floor" id="floor" placeholder="" readonly>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($lisitng->prop['type'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Transaction type:</label>
                                        <input type="text" class="form-control namevalue transaction_type" value="{{$v}}" name="transaction_type[{{$key}}][]" id="transaction_type" placeholder="">
                                      </div>
                                      <?php
                                        end($value);
                                    if($k != key($value)){
                                      ?>
                                      <span class="input-group-btn">
                                            <button type="button" class="btn btn-danger btn-remove">-</button>
                                          </span>
                                      <?php
                                    }else{
                                  ?>
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-add">+</button>
                                            </span>
                                          <?php
                                          }
                                        ?>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($lisitng->prop['type'][$key] as $k=>$v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Transaction type:</label>
                                        <input type="text" class="form-control namevalue transaction_type" value="{{$v}}" name="transaction_type[{{$key}}][]" id="transaction_type" placeholder="" readonly>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Car parking:</label>
                                          <select name="car_parking" id="car_parking" class="form-control car_parking">
                                            @if($v->car_parking==1)
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            @elseif($v->car_parking==0)
                                                <option value="1" >Yes</option>
                                                <option value="0" selected>No</option>
                                            @else
                                                <option value="1" >Yes</option>
                                                <option value="0" >No</option>
                                            @endif
                                          </select>
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @elseif (Sentinel::inRole('vendor'))
                          @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Car parking:</label>
                                          <select name="car_parking" id="car_parking" class="form-control car_parking" readonly>
                                            @if($v->car_parking==1)
                                                <option value="1" selected>Yes</option>
                                                <option value="0">No</option>
                                            @elseif($v->car_parking==0)
                                                <option value="1" >Yes</option>
                                                <option value="0" selected>No</option>
                                            @else
                                                <option value="1" >Yes</option>
                                                <option value="0" >No</option>
                                            @endif
                                          </select>
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endforeach
                          @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          @if($v->l_sub_category == 1)
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox" id="furnishing">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Furnishing:</label>
                                          <input type="text" class="form-control furnishing" value="2" name="furnishing" id="furnishing" placeholder="">
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @else
                          <div class="form-group property_class multiple-form-group"  style="display: none;">
                            <div class=" propertiesbox" id="furnishing">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Furnishing:</label>
                                          <input type="text" class="form-control furnishing" value="{{$v->furnishing}}" name="furnishing" id="furnishing" placeholder="">
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endif
                           @endforeach
                           @elseif (Sentinel::inRole('vendor'))
                           @foreach($detail as $v)
                          <div class="form-group multiple-form-group furnishing"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Furnishing:</label>
                                          <input type="text" class="form-control furnishing" value="{{$v->furnishing}}" name="furnishing" id="furnishing" placeholder="" readonly>
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                           @endforeach
                           @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          @if($v->l_sub_category == 1)
                          <div class="form-group property_class multiple-form-group possession_date possession_dates"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Possession Date:</label>
                                          <input type="text" class="form-control" value="{{$v->possession_date}}" name="possession_date" id="possession_date" placeholder="" required>
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endif
                           @endforeach
                           @elseif (Sentinel::inRole('vendor'))
                           @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group possession_date possession_dates">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Possession Date:</label>
                                          <input type="text" class="form-control" value="{{$v->possession_date}}" name="possession_date" id="possession_date" placeholder="" readonly>
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                           @endforeach
                           @endif

                          @if(Sentinel::inRole('admin'))
                          @foreach($detail as $v)
                          @if($v->l_sub_category == 1)
                          <div class="form-group property_class multiple-form-group tower towers"  style="display: none;">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Tower:</label>
                                          <input type="text" class="form-control" value="{{$v->tower}}" name="tower" id="tower" placeholder="">
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          @endif
                           @endforeach
                           @elseif (Sentinel::inRole('vendor'))
                           @foreach($detail as $v)
                          <div class="form-group property_class multiple-form-group tower towers">
                            <div class=" propertiesbox">
                                <div class="row">
                                  <div class="select_margin">
                                      <div class="form-group">
                                        <label class="control-label property_class">Tower:</label>
                                          <input type="text" class="form-control" value="{{$v->tower}}" name="tower" id="tower" placeholder="" readonly>
                                        </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                           @endforeach
                           @endif

                                @if(Sentinel::inRole('admin'))
                                <span class="input-group-btn">
                                <?php
                                  if($last != $value)
                                  {
                                  ?>
                                <button type="button" class="btn btn-danger btn-remove">-</button>
                                <?php
                              }else{
                                 ?>
                                <button type="button" class="btn btn-success btn-add">+</button>
                              <?php
                            }
                            ?>
                              </span>
                              @elseif (Sentinel::inRole('vendor'))
                              <span class="input-group-btn">
                                <?php
                                  if($last != $value)
                                  {
                                  ?>
                                <button type="button" class="btn btn-danger btn-remove" readonly>-</button>
                                <?php
                              }else{
                                 ?>
                                <button type="button" class="btn btn-success btn-add" readonly>+</button>
                              <?php
                            }
                            ?>
                              </span>
                              @endif
                            </div>
                        </div>
                      </div>

                    </div>


                        @endforeach
                        @endif
                        
                        @if(Sentinel::inRole('admin'))
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Listed By:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->listed_by }}" name="listed_by" id="listed_by" placeholder="">
                            </div>
                          </div>
                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Listed By:</label>
                            <div class="col-sm-12 select_margin">
                              <input type="text" class="form-control" value="{{ $lisitng->listed_by }}" name="listed_by" id="listed_by" placeholder="" readonly>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-2" for="amenities" >Amenities:</label>
                            <input class="form-pls" value="Add" type="button" name="submit" id="submit123">
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
                                <option value="13">Children Play Area</option>
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
                                <option value="45">Landscape Garden</option>
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

                       <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Multiple Amenities:</label>
                            <div class="col-sm-12 select_margin amen">
                              <textarea name="pro_amenities" id="amenities" rows="5" cols="100">{{$lisitng->amenities}}</textarea>
                            </div>
                          </div>
                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-2" for="amenities" >Amenities:</label>
                            <input class="form-pls" value="Add" type="button" name="submit" id="submit123">
                           <div class="col-sm-6">
                              <select class="form-control" id="ameniti_id" readonly>
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
                                <option value="13">Children Play Area</option>
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
                                <option value="45">Landscape Garden</option>
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

                       <div class="form-group property_class" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12">Multiple Amenities:</label>
                            <div class="col-sm-12 select_margin amen">
                              <input type="text" class="form-control" value="{{$lisitng->amenities}}" name="pro_amenities" id="amenities" placeholder="" readonly>
                            </div>
                          </div>
                        </div>
                        @endif
                      

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group">
                          
                       
                          <div class="row brochure_field" style="display: none;">
                            <label class="control-label col-sm-12" for="brochure">Brochure:</label>
                            <div class="col-sm-12">
                              <input type="file" name="brochure" id="brochure" />
                            </div>
                          </div>

                          <a target="_blank" href="{{url('/')}}/public/images/brochure/{{$lisitng->vl_id}}/{{$lisitng->l_brochure}}">{{$lisitng->l_brochure}}</a> 
                        

                          <br><br>
                          <div class="row">
                            <label class="control-label col-sm-12" for="brochure">Manual Invoice:</label>
                            <div class="col-sm-12">
                              <input type="file" name="manual_invoice" id="manual_invoice" />
                            </div>
                          </div>

                          <br><br>
                          <div class="row">
                            <label class="control-label col-sm-12" for="l_extravideo">Upload Video :</label>
                            <div class="col-sm-12">
                              <input type="file" name="l_extravideo_file" id="l_extravideo_file"  accept="video/*">
                            </div>
                          </div>
                        <div class="col-sm-12 pad-top20">
                          
                          <?php
                            $directory = "public/images/extravideo";
                            if (is_dir($directory)) {
                            $files = array_values(array_diff(scandir($directory), array('..', '.')));
                            $img = '';
                            foreach ($files as $key => $value) { ?>
                              <div id="d" class="productimg">
                                <img src="/public/images/extravideo/{{ $value }}/{{$lisitng->l_extravideo}}" id="img_{{$key}}" style="display: none;">

                               <a href="javascript:void(0);" class="cross"> <span class="glyphicon glyphicon-remove extravideo_remove"  id="{{$key}}"></span>
                               </a>
                             </div>
                            <?php } }
                        ?>


                    </div>
                      
                        
                       

                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="brochure">Brochure:</label>
                            <div class="col-sm-12">
                              <input type="file" name="brochure" id="brochure" readonly />
                            </div>
                          </div>
                        </div>
                        @endif

                      </div>

                      @if(Sentinel::inRole('admin'))
                      <div class="col-md-6 paddleft0">
                        <div class="form-group" id="pname">
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
                        <div class="form-group" id="locname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="near_by">Location:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="near_by" value="{{ $lisitng->l_nearby }}" name="near_by" placeholder="Near By Location" required>
                            </div>
                          </div>
                        </div>
                         <div class="form-group">
                           <div class="row">
                          <label class="control-label col-sm-12" for="near_by">City:</label>
                          <div class="col-sm-12">
                          <select id="l_city" name="city" class="form-control">
                           <option value="">City</option>
                         
                              @foreach($city_info as $d)

                              @if(isset($lisitng->city) && $d->City_Name == ($lisitng->city))
                              <?php echo "hii"; ?>
                                    <option value="{{ $d->City_Name }}" selected='selected'>{{ $d->City_Name }}</option>
                                     @else
                                     <option value="{{ $d->City_Name }}">{{ $d->City_Name }}</option>
                                     @endif
                                
                              @endforeach
                             
                            
                          </select>  
                          </div>
                        </div>
                        </div>

                        <div class="form-group">
                           <div class="row">
                          <label class="control-label col-sm-12" for="near_by">Area:</label>
                          <div class="col-sm-12">
                          <select id="state" name="area" class="form-control" required>
                           <option value="">Area name</option>
                          </select>  
                          </div>
                        </div>
                        </div> 
                        <div class="form-group" id="zipname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="Zip_Code">Zip Code:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->Zip_Code }}" name="Zip_Code" id="Zip_Code" placeholder="Zip Code" required >
                            </div>
                          </div>
                        </div>

                        <div class="form-group" id="ptagname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="tags">Project Tags:</label>
                            <div class="col-sm-12">
                              <input type="text" name="pro_tags" id="pro_tags" value="{{ $lisitng->l_key_area }}" data-role="tagsinput" required/>
                            </div>
                          </div>
                        </div>
                      </div>
                      @elseif (Sentinel::inRole('vendor'))
                      <div class="col-md-6 paddleft0">
                        <div class="form-group" id="pname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="project_name">Project Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->l_title }}" name="project_name" id="project_name" placeholder="Project Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="address">Address:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->l_location }}" name="address" id="address" placeholder="Address" required >
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="locname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="near_by">Location:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="near_by" value="{{ $lisitng->l_nearby }}" name="near_by" placeholder="Near By Location" required readonly>
                            </div>
                          </div>
                        </div>
                         <div class="form-group">
                           <div class="row">
                          <label class="control-label col-sm-12" for="near_by">City:</label>
                          <div class="col-sm-12">
                          <select id="l_city" name="city" class="form-control" readonly>
                           <option value="" disabled="">City</option>
                         
                              @foreach($city_info as $d)

                              @if(isset($lisitng->city) && $d->City_Name == ($lisitng->city))
                             
                                    <option value="{{ $d->City_Name }}" selected='selected'>{{ $d->City_Name }}</option>
                                     @else
                                     <option value="{{ $d->City_Name }}" disabled="">{{ $d->City_Name }}</option>
                                     @endif
                                
                              @endforeach
                          </select>  
                          </div>
                        </div>
                        </div>

                        <div class="form-group">
                           <div class="row">
                          <label class="control-label col-sm-12" for="near_by">Area:</label>
                          <div class="col-sm-12">
                          <select id="state" name="area" class="form-control" required readonly>
                           <option value="" disabled="">Area name</option>
                          </select>  
                          </div>
                        </div>
                        </div> 
                        <div class="form-group" id="zipname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="Zip_Code">Zip Code:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{ $lisitng->Zip_Code }}" name="Zip_Code" id="Zip_Code" placeholder="Zip Code" required readonly>
                            </div>
                          </div>
                        </div>

                        <div class="form-group" id="ptagname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="tags">Project Tags:</label>
                            <div class="col-sm-12">
                              <input type="text" name="pro_tags" id="pro_tags" value="{{ $lisitng->l_key_area }}" data-role="tagsinput" required readonly />
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif


                      @if(Sentinel::inRole('admin'))
                      <div class="col-sm-12">
                      <div class="form-group" id="abname">
                          <label for="about_project">About Project</label>
                          <textarea class="form-control resize_vertical" name="about_project" id="about_project" rows="3" required>{{ $lisitng->l_description }}</textarea>
                      </div>
                      </div>
                      @elseif (Sentinel::inRole('vendor'))
                      <div class="col-sm-12">
                      <div class="form-group" id="abname">
                          <label for="about_project">About Project</label>
                          <textarea class="form-control resize_vertical" name="about_project" id="about_project" rows="3" required readonly>{{ $lisitng->l_description }}</textarea>
                      </div>
                      </div>
                      @endif

                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>

                    <div class="row setup-content" id="step-2">
                      <div class="row">
                        <div class="col-md-6 paddleft0">
                        @if(Sentinel::inRole('admin'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="first_Name" name="first_Name" value="{{$lisitng->first_name}}" placeholder="First Name" required>
                            </div>
                          </div>
                        </div>
                        @elseif(Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="first_Name" name="first_Name" value="{{$lisitng->first_name}}" placeholder="First Name" required>
                            </div>
                          </div>
                        </div>
                @if($lisitng->l_category == 4 || $lisitng->l_category == 3 || $lisitng->l_category == 2)
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="price" name="price" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="price_perft" name="price_perft" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="p_short" name="p_short" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="bedroom" name="bedroom" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="bathrooms" name="bathrooms" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="p_status" name="p_status" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="floor" name="floor" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="car_parking" name="car_parking" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="furnishing" name="furnishing" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="furnishing" name="possession_date" value="NULL" placeholder="First Name" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="furnishing" name="tower" value="NULL" placeholder="First Name" readonly>
                            </div>
                          </div>
                        </div>

                        @endif        
                        @endif

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="last_Name">Last Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{$lisitng->last_name}}" name="last_Name" id="last_Name" placeholder="Last Name" required>
                            </div>
                          </div>
                        </div>
                         @if($lisitng->l_category == 4 || $lisitng->l_category == 3 || $lisitng->l_category == 2)
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="price" name="price" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="price_perft" name="price_perft" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="p_short" name="p_short" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="bedroom" name="bedroom" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="bathrooms" name="bathrooms" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="p_status" name="p_status" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="floor" name="floor" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="car_parking" name="car_parking" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="furnishing" name="furnishing" value="NULL" placeholder="First Name" required readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="furnishing" name="possession_date" value="NULL" placeholder="First Name" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="first_Name">First Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="furnishing" name="tower" value="NULL" placeholder="First Name" readonly>
                            </div>
                          </div>
                        </div>

                        @endif
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="last_Name">Last Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="NULL" name="possession_date" id="last_Name" placeholder="Last Name" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="display: none;">
                          <div class="row">
                            <label class="control-label col-sm-12" for="last_Name">Last Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="NULL" name="tower" id="last_Name" placeholder="Last Name" required>
                            </div>
                          </div>
                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="last_Name">Last Name:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" value="{{$lisitng->last_name}}" name="last_Name" id="last_Name" placeholder="Last Name" required>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="email">Email:</label>
                            <div class="col-sm-12">
                              <input type="email" class="form-control" value="{{$lisitng->email}}" name="email" id="email" placeholder="Email" required>
                            </div>
                          </div>
                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="email">Email:</label>
                            <div class="col-sm-12">
                              <input type="email" class="form-control" value="{{$lisitng->email}}" name="email" id="email" placeholder="Email" required readonly>
                            </div>
                          </div>
                        </div>
                        @endif

                        @if(Sentinel::inRole('admin'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Phone:</label>
                            <div class="col-sm-12">
                              <input type="text" name="phone_Number" value="{{$lisitng->Phone}}" class="form-control number" id="phone_Number" placeholder="Phone Number" required>
                            </div>
                          </div>
                        </div>
                        @elseif (Sentinel::inRole('vendor'))
                        <div class="form-group">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Phone:</label>
                            <div class="col-sm-12">
                              <input type="text" name="phone_Number" value="{{$lisitng->Phone}}" class="form-control number" id="phone_Number" placeholder="Phone Number" required readonly>
                            </div>
                          </div>
                        </div>
                        @endif
                        <div style="padding-left:15px;color:red;">www.Example.com</div>
                        <div class="form-group" id="webname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Website:</label>
                            <div class="col-sm-12">
                              <input type="text" name="website" value="{{$lisitng->website}}" class="form-control" id="website" placeholder="Website">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="fbname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Face book:</label>
                            <div class="col-sm-12">
                              <input type="text" name="face_book" value="{{$lisitng->facebook}}" class="form-control" id="face_book" placeholder="FB Link">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="yuname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">You tube:</label>
                            <div class="col-sm-12">
                              <input type="text" name="you_tube" value="{{$lisitng->youtube}}" class="form-control" id="you_tube" placeholder="Your Tube">
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="viname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Video Link:</label>
                            <div class="col-sm-12">
                              <input type="text" name="l_video_link" value="{{$lisitng->l_video_link}}" class="form-control" id="l_video_link" placeholder="Promo Video Link">
                            </div>
                          </div>
                        </div>
                      </div>

                      @if(Sentinel::inRole('admin'))
                      <div class="col-md-6 paddleft0">
                          <div class="form-group">
                              <label for="area" class="control-label col-sm-12">Achievements</label>
                               <div class="col-sm-12"> <textarea class="form-control resize_vertical" name="achievements" id="achievements" rows="3">{{$lisitng->achievements}}</textarea>
                          </div> </div>

                          <div class="form-group" id="ppname">
                              <label for="area" class="control-label col-sm-12">Past Projects</label>
                               <div class="col-sm-12"> <textarea class="form-control resize_vertical" name="past_project" id="past_project" rows="3">{{$lisitng->past_projects}}</textarea>
                          </div> </div>

                          <div class="form-group" id="cpname">
                              <label for="area" class="control-label col-sm-12">Current Project</label>
                              <div class="col-sm-12">  <textarea class="form-control resize_vertical" name="current_project" id="current_project" rows="3">{{$lisitng->current_project}}</textarea>
                          </div> </div>
                          <div class="form-group">
                            <label for="area" class="control-label col-sm-12">Owner Logo</label>
                              <div class="col-sm-12">
                              <input type="file" name="logo">
                              @if(!$lisitng->logo == "")
                              <img src="{{url('/')}}/public/images/logo/{{$lisitng->vl_id}}/{{$lisitng->logo}}"> 
                              @else
                                <img src="{{url('/')}}/public/images/noimage.png" width="100px;"> 
                                @endif
                              <br><br>
                              </div>
                          </div>
                          @if (Sentinel::inRole('admin'))
                                <div class="form-group"  id="chname">
                                    <div class="row ">
                                        <div class="makeit-popular-checkbox">
                                            <input type="checkbox" name="l_feature" id="l_feature" <?php echo ($lisitng->l_featured == '1') ? 'checked=checked' : ''?>>
                                          <label>Make it popular:</label>
                                        </div>
                                      </div>
                                    </div>
                                  <div class="form-group"  id="chname">
                                    <div class="row ">
                                        <div class="makeit-popular-checkbox">
                                            <input type="checkbox" name="l_prime" id="l_prime" <?php echo ($lisitng->l_prime == '1') ? 'checked=checked' : ''?>>
                                          <label>Prime Customer:</label>
                                        </div>
                                      </div>
                                    </div>
                          @endif
                          </div>
                          @elseif (Sentinel::inRole('vendor'))
                                <?php if($lisitng->l_featured == '1'){ ?>
                                  <div class="form-group"  id="chname">
                                    <div class="row ">
                                        <div class="makeit-popular-checkbox">
                                            <input type="checkbox" name="l_feature" id="l_feature" <?php echo ($lisitng->l_featured == '1') ? 'checked=checked' : ''?>>
                                          <label>Make it popular:</label>
                                        </div>
                                      </div>
                                  </div>
                                <?php } else {  ?>  
                                  <div class="form-group"  id="chname">
                                    <div class="row ">
                                        <div class="makeit-popular-checkbox">
                                            <input type="checkbox" disabled="disabled" name="l_feature" id="l_feature" <?php echo ($lisitng->l_featured == '1') ? 'checked=checked' : ''?>>
                                          <label>Make it popular:</label>
                                        </div>
                                      </div>
                                  </div>
                                <?php } ?>
                                 <?php if($lisitng->l_prime == '1'){ ?>  
                                  <div class="form-group"  id="chname">
                                    <div class="row ">
                                        <div class="makeit-popular-checkbox">
                                            <input type="checkbox" name="l_prime" id="l_prime" <?php echo ($lisitng->l_prime == '1') ? 'checked=checked' : ''?>>
                                          <label>Prime Customer:</label>
                                        </div>
                                      </div>
                                  </div>
                                <?php } else { ?>
                                  <div class="form-group"  id="chname">
                                    <div class="row ">
                                        <div class="makeit-popular-checkbox">
                                            <input type="checkbox" disabled="disabled" name="l_prime" id="l_prime" <?php echo ($lisitng->l_prime == '1') ? 'checked=checked' : ''?>>
                                          <label>Prime Customer:</label>
                                        </div>
                                      </div>
                                  </div>
                                <?php } ?>  
                          <div class="col-md-6 paddleft0">
                          <div class="form-group">
                              <label for="area" class="control-label col-sm-12">Achievements</label>
                               <div class="col-sm-12"> <textarea class="form-control resize_vertical" name="achievements" id="achievements" rows="3" readonly>{{$lisitng->achievements}}</textarea>
                          </div> </div>

                          <div class="form-group" id="ppname">
                              <label for="area" class="control-label col-sm-12">Past Projects</label>
                               <div class="col-sm-12"> <textarea class="form-control resize_vertical" name="past_project" id="past_project" rows="3" readonly>{{$lisitng->past_projects}}</textarea>
                          </div> </div>

                          <div class="form-group" id="cpname">
                              <label for="area" class="control-label col-sm-12">Current Project</label>
                              <div class="col-sm-12">  <textarea class="form-control resize_vertical" name="current_project" id="current_project" rows="3" readonly>{{$lisitng->current_project}}</textarea>
                          </div> </div>
                          
                          </div>
                          @endif
                     
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                         </div>
                    </div>

                    <?php $workingdays = explode(',', $lisitng->working_hr); ?>
                    @if(Sentinel::inRole('admin'))
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
                        <div class="form-group" id="workhrname">
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
                    @elseif (Sentinel::inRole('vendor'))
                    <div class="row setup-content" id="step-3">
                      <div class="row">
                        <div class="form-group checkboxgroup">
                          <div class="row">
                            <label class="control-label col-sm-12" for="phone_Number">Working Days:</label>
                            <div class="col-sm-12">
                              <div class="checkbox">
                                  <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox1" value="1" aria-label="Single checkbox One" <?php echo (in_array('1', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                  <label>Monday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox2" value="2" aria-label="Single checkbox One" <?php echo (in_array('2', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                <label>Tuesday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox3" value="3" aria-label="Single checkbox One" <?php echo (in_array('3', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                <label>Wednesday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox4" value="4" aria-label="Single checkbox One" <?php echo (in_array('4', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                <label>Thursday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox5" value="5" aria-label="Single checkbox One" <?php echo (in_array('5', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                <label>Friday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox6" value="6" aria-label="Single checkbox One" <?php echo (in_array('6', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                <label>Saturday</label>
                              </div>
                              <div class="checkbox">
                                <input type="checkbox" class="styled" name="workinghrs[]" id="singleCheckbox7" value="7" aria-label="Single checkbox One" <?php echo (in_array('7', $workingdays)) ? 'checked="checked"' : ''?> readonly>
                                <label>Sunday</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" id="workhrname">
                          <div class="row">
                            <label class="control-label col-sm-12" for="website">Working Hrs:</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" name="working_time" value="{{ $lisitng->working_time }}" id="working_time" placeholder="Working Time" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                      <button class="btn btn-primary prevBtn btn-lg pull-left" type="button" >Prev</button>
                      <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
                    @endif


                    <div class="row setup-content" id="step-4">
                      <div class="row">
                      <div class="form-group" id="gallery_images">
                          <div class="row">
                              <label class="col-sm-12 control-label" for="form-file-multiple-input">Gallery Images</label>
                                 <div class="col-sm-12">
                                    <div class="sliderimages">
                                <input type="file" id="form-file-multiple-input" name="inputFile[]" multiple="">
                                <img id="image_upload_preview" height="100" width="100" style="display: none;" />
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
                                <input type="file" id="form-file-multiple-input1" name="banner[]" multiple="">
                                <img id="image_upload_preview1" height="100" width="100" style="display: none;" />
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
                                <input type="file" id="form-file-multiple-input2" name="featured_image">
                                <img id="image_upload_preview2" height="100" width="100" style="display: none;" />
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
                      <button class="btn btn-primary nextBtn btn-lg pull-right nxt " type="button" style="display: none;">Next</button>
                      

                       <button class="btn btn-primary  btn-lg pull-right pub fb" type="submit" style="display: none;">Publish</button>
                    </div>

                    <div class="row setup-content" id="step-5">
                    <div class="row">
                    <div class="form-group  multiple-form-group">
                    <div class=" propertiesbox">
                    <div class="row">
                    <div class="select_margin">
                    <div class="form-group">
                    <label class="control-label ">Price:</label>
                    <input type="text" class="form-control namevalue price" name="shop_price" id="shop_price" placeholder="Property Price" value="{{$lisitng->shop_price}}">
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
                    <label class="control-label ">Built Up area:</label>
                    <input type="text" class="form-control namevalue super_area" name="shop_area" id="shop_area" placeholder="" value="{{$lisitng->shop_area}}">
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
                    <label class="control-label ">Washrooms:</label>
                    <input type="text" class="form-control namevalue bathrooms" name="shop_washroom" id="shop_washroom" placeholder=""  value="{{$lisitng->shop_washroom}}">
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
                    <label class="control-label ">Floor:</label>
                    <input type="text" class="form-control namevalue floor" name="shop_floor" id="shop_floor" placeholder="" value="{{$lisitng->shop_floor}}">
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
                    <label class="control-label ">Car parking:</label>
                    <select name="shop_car_parking" id="shop_car_parking" class="form-control namevalue car_parking"  value="{{$lisitng->shop_car_parking}}"> 
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
                    <input  class="btn btn-primary nextBtn btn-lg pull-right set_value" type="submit" value="Publish" style="display: none;">
                    <input  class="btn btn-primary nextBtn btn-lg pull-right for_all" type="submit" value="Publish">
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


        <div class="modal fade" id="ignismyModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
                     </div>
          
                    <div class="modal-body">
            <div class="thank-you-pop">
              <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
              <h1>Record has been updated successfully</h1>
              
              <h3 ><button class="btn btn-primary redirectbtn" data-dismiss="modal" aria-label="">Ok</button></h3>
              
            </div>
                         
                    </div>
          
                </div>
            </div>
        </div>
    

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

 
  var BuilUpCategoryCount;
    // $(document).ready(function () {

    //   var categorys = $('#sub_cat').find(":selected").val();
      
    //   if(categorys == 1) {
    //     var abc='';
    //     var a='';

    //   $('.get_value').each(function () {

    //     abc += $(this).attr('value') + '","'; 
        
    //     //a=abc.slice(0, -1);
    //   });

    //    // BuilUpCategoryCount=a;
    //     var aaa = $('#bedroom').val(abc.slice(0, -3));
    //     //alert(BuilUpCategoryCount);
    //   }
    // });

    $(document).on("change", ".get_value", function() {

        var abc="";
      $('.get_value').each(function () {

        abc += $(this).val()+'","';

      a=abc.slice(0, -3);
      });

      BuilUpCategoryCount = a; 

      var xx= $('#bedroom').val(BuilUpCategoryCount);
      //alert(xx);
    });


    $(document).on("click", ".add-bedroom", function() {
      
      if ($(this).html()== "–") {
    
        var abc="";
      $('.get_value').each(function () {

        abc += $(this).val()+'","';

      a=abc.slice(0, -3);
      });

      BuilUpCategoryCount =abc;

      $('#bedroom').val(BuilUpCategoryCount);
      }
    });

    $(document).on("click", ".set_value", function() {
     
      var abc="";
      $('.get_value').each(function () {
        abc += $(this).val()+'","';
      });
    
      var aa = $('#bedroom').val(abc.slice(0,-3));
  
    });

      var categoty_value = $('#category').val();
      var category = $('#category').find(":selected").val();

      var sub_cat_value = $('#sub_cat').val();
      var sub_cat = $('#sub_cat').find(":selected").val();
      
     //final submit buuton code
     if(category == 1 && sub_cat == 1)
     {
      $('.set_value').css('display','block');
      $('.for_all').css('display','none');
     }

     if(category == 1)
     {
      $('.brochure_field').css('display','block');
     }
     else
     {
      $('.brochure_field').css('display','none');
     }

     if(category == 2 || category == 4 || category == 3)
     {
      $('.si').css('display','none');
      $('.pub').show();
      $('.nxt').hide();
     }
     else
     {
       //$('.pub').hide();
       $('.nxt').show();
     }


      $(document).ready(function() {

         var sub_cat_infosing = $('#sub_cat').find(":selected").val();

         if(sub_cat_infosing == 1)
          {
            $('input.possession_dates').css('display','block');
            $('input.towers').css('display','block');
          }else{
            $('input.possession_dates').css('display','none');
            $('input.towers').css('display','none');
            }

         
        $('input#tower').prop('required',false);
        $('input.possession_date').prop('required',false);


      var sub_cat_info =   $('#sub_cat').find(":selected").val();
      
      if(sub_cat_info == 1)
      {
        $('.shop_select').css('display','none');
        $('.res_shop').css('display','block');
        $('.bedroom').css('display','none');
      }
      
    
    if(sub_cat == 1){
      $('#bedroom').prop('required',false);
      $('#furnishing').css('display','none');
      $('#furnishing').prop('required',false);
      $('input#tower').prop('required',false);
      $('input.possession_date').prop('required',false);
      }

      $("#sub_cat").on('change', function() {

      var sub_cat_infos =   $('#sub_cat').find(":selected").val();
      
      if(sub_cat_infos == 1)
      {
        $('.shop_select').css('display','none');
        $('.res_shop').css('display','block');
        $('.possession_date').css('display','block');
        $('.tower').css('display','block');
        $('.bedroom').css('display','none');
      }else{
        $('.shop_select').css('display','block');
        $('.res_shop').css('display','none');
        $('.possession_date').css('display','none');
        $('.tower').css('display','none');
        }

      });

          $("#category").on('change', function() {

         var maincat_value = $('#category').val();
        
           if(maincat_value == 2 ||maincat_value == 3 || maincat_value == 4)
          {
               $('.si').css('display','none');
          }
          else{
             $('.si').css('display','block');
          }
        });

        });

    function GetFileSize()
{
        var fi = document.getElementById('file'); // GET THE FILE INPUT.
        // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
        if (fi.files.length > 0) {
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
                    document.getElementById('b').readonly = true;
            }
            else
            {
                  document.getElementById('b').readonly = false;
            }
        }
}
  </script>
  </script>

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
        select();
        var cat = $('#category').val();
        $('#expname').hide();
        $('#agename').hide();
        $('#adname').hide();

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

          if (catt == '2' || catt == '3' || catt == '4' || catt == '5') {
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

              if (!$item.hasClass('readonly')) {
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
                  nextStepWizard.removeAttr('readonly').trigger('click');
          });
          allPrevBtn.click(function() {

              var curStep = $(this).closest(".setup-content"),

                  curStepBtn = curStep.attr("id"),

                  prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

              prevStepWizard.removeAttr('readonly').trigger('click');

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
                          $('#expname').hide();
                          $('#agename').hide();
                          $('#adname').hide();
                          $("#select57").append('<option value="">Select Sub Category</option>');
                          $.each(data, function(key, value) {
                              $("#select57").append('<option value="' + value.id + '">' + value.name + '</option>');
                          });
                        }

                        else if(cat=='5')
                        {
                           $("#sub_cat").empty();
                            $('#sigale').show();
                            $('#mul').hide();
                           $("#sub_cat").append('<option value="">Select Sub Category</option>');
                            $.each(data, function(key, value) {
                              $("#sub_cat").append('<option value="' + value.id + '">' + value.name + '</option>');
                            });

                            $("#project_name").prop('required',false);
                            $("#Zip_Code").prop('required',false);
                            $("#near_by").prop('required',false);
                            $("#about_project").prop('required',false);
                            $("#vendor").prop('required',false);
                            $("#address").prop('required',false);
                            $("#pro_tags").prop('required',false);
                            $('#city').prop('required',false);
                            $('#mul').prop('required',false);
                            $('#pname').hide();
                            $('#locname').hide();
                            $('#zipname').hide();
                            $('#ptagname').hide();
                            $('#urname').hide();
                            $('#webname').hide();
                            $('#fbname').hide();
                            $('#yuname').hide();
                            $('#viname').hide();
                            $('#achname').hide();
                            $('#ppname').hide();
                            $('#cpname').hide();
                            $('#chname').hide();
                            $('#workname').hide();
                            $('#workhrname').hide();
                            $('#work3name').hide();
                            $('#ctsname').hide();
                            $('#expname').show();
                            $('#agename').show();
                            $('#adname').show();
                             $('#mul').hide();
                              $('#sigale').show();
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
                          $('#expname').hide();
                          $('#agename').hide();
                          $('#adname').hide();
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
                        $("#pro_cate").css('display','none');
                        //$("#select22").attr("required", "true");
                         $("#select22").attr("required", false);
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
                    $('.nextBtn').attr('readonly',true);
                    $('#url').html(data);
                  }
                  else{
                    $('.nextBtn').attr('readonly',false);
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
        $("#pro_cate").css('display','none');
        $("#select22").prop('required',false);
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
// function GetFileSize()
// {
//         var fi = document.getElementById('file'); // GET THE FILE INPUT.
//         // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
//         if (fi.files.length > 0)
//         {
//             // RUN A LOOP TO CHECK EACH SELECTED FILE.
//             for (var i = 0; i <= fi.files.length - 1; i++)
//             {
//                 var fsize = fi.files.item(i).size;      // THE SIZE OF THE FILE.
//             }
//             $mb=(fsize/1024)/1024;
//             if($mb>50)
//             {
//                     document.getElementById('fp').innerHTML =
//                     '<b>Video size should not accessed to 50MB. Current size is:'+$mb.toFixed(2)+'MB</b>';
//                     document.getElementById('b').readonly = true;
//             }
//             else
//             {
//                   document.getElementById('b').readonly = false;
//             }
//         }
// }
(function ($) {
    $(function () {
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
                $lastFormGroupLast.find('.btn-add').attr('readonly', true);
            }
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('readonly', false);
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
 function select(){
       var City_Id = $('#l_city').val();
        var s = "<?php echo $lisitng->area; ?>";
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getareas')}}?City_Id="+City_Id,
            success:function(data){
                if (data) {
                    $("#state").empty();
                    $("#state").append('<option value="">Select Area</option>');
                    $.each( data, function( key, value ) {
                        $("#state").append('<option value="'+key+'">'+value+'</option>');
                         $('#state').val(s);
                    });
                }
            }
        })
    }

</script>

<script type="text/javascript">
  $(document).ready(function(){

  $("#submit123").click(function(){
    
      var obj = new Object();
          obj =  $('#ameniti_id').val().split(',')

      var a = obj[obj.length-1];

      var b = $('#ameniti_id').find(":selected").text();

      var c = b +"~"+ a;

      // var add = $('.amen').val().split(',');
      
      // var tags="<span class='tag label label-info'>"+b+"~"+a+"<span data-role='remove'></span></span>";

      // var obj1 = new Object();
      //     obj1 = $('#amenities').parent().find('.label-info').last().after(tags).append(tags);

     //alert(obj1);

      //$('#ameniti_id').val("");
      var temp = $('#amenities').val();

      $('#amenities').val(temp+ " " +  c + "," + "   " + "  " + "  "); 
      $('#ameniti_id').val("");

    });
});
</script>

<script type="text/javascript">
 $("#ameniti_id").change(function(){
 
   var b = $('#ameniti_id').find(":selected").val();

   var src = "{{url('/')}}/public/images/amenities/"+ b +".png";
   
   var image = $('#amenitiimg_id').attr('src', src);

});
</script>

<script>
  
  $(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });


  var d = $('#category ').find(":selected").val();

  var a = "{{url('/')}}/admin/vendorlisting?category="+d;

  //$("a").prop("href", "http://www.google.com/");

/*
  $('.fb').click(function() {

    var a = "{{url('/')}}/admin/vendorlisting?category="+d;
    window.location.href = a;
    return false;
  });
*/

$('.gg').prop("href",a);
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

       function readURL1(input) {
      if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
      $('#image_upload_preview1').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
      }
      }

      $("#form-file-multiple-input1").change(function () {
      $('#image_upload_preview1').show();
      readURL1(this);
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

      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 

      $('.nextBtn').click(function(){
$('input.possession_date').prop('required',false);
$('input.tower').prop('required',false);

      });

            $("#addtestimonail").on('submit',(function(e) {
            e.preventDefault();
            
            $.ajax({
                   url: "{{url('/')}}/admin/vendorlisting/edit/{{$lisitng->vl_id}}",
             type: "POST",
             data:  new FormData(this),
             contentType: false,
                   cache: false,
             processData:false,
             
             success: function(result)
                {
              $('#ignismyModal').modal('show');

                  setTimeout(function() {
                  $('#ignismyModal').fadeIn(70000);
                }, 70000); 
                  return false;

                   
                }       
              });
           }));

            $('.redirectbtn').click(function(){


              var d = $('#category ').find(":selected").val();  
      var a = "{{url('/')}}/admin/vendorlisting?category="+d;
      window.location.href = a;

            });
//video remove


 $('.brand_remove').click(function(){
  //alert('yes');
      var file = $("#imgrmv"+this.id).attr("src");
      var id = this.id;
      
      $.ajax({
        type:"POST",
        url:"{{url('/')}}/{{'admin/vendorlisting/del_extravideo'}}",
        data:{file:file},
        dataType: "json",
        success: function(data){
          $("#imgrmv"+id).hide();
          window.location.reload();
         }
      });

 });


 $('.extravideo_remove').click(
    function()
    {
      var file = $("#img_"+this.id).attr("src");
      var id = this.id;
      $.ajax({
        type:"POST",
        url:"{{'/admin/vendorlisting/del_extravideo'}}",
        data:{file:file},
        dataType: "json",

        success: function(data){
          $("#d").css('display','none');
           window.location.reload();
         }
      });

 });

</script>

@stop