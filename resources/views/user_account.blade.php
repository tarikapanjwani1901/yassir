@extends('layouts.default')
{{-- Page title --}}
@section('title')
    User Account
    @parent
@stop
{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/css/minimal/blue.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
{{--    <link href="{{ asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/user_account.css') }}">
@stop
{{-- Page content --}}
@section('content')
    <div class="container">
             <div class="commonttl-subttl paddtop130">
                <h2>My Account</h2>
            </div>
        <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                    <!--main content-->
                    <div class=" formdesign">
                        <!-- Notifications -->
                        <div id="notific">
                        @include('notifications')
                        </div>
                <h3 class="text-center">Personal Information</h3>
                        {!! Form::model($user, ['url' => URL::to('my-account'), 'method' => 'put', 'class' => 'form-horizontal','enctype'=>"multipart/form-data"]) !!}
                        {{ csrf_field() }}
                        <div class="formheader">
                            <div class="form-group {{ $errors->first('pic', 'has-error') }}">
                                <label class="col-sm-12">Avatar:</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                               <span class="btn btn-primary fileinput-exists" data-dismiss="fileinput"><i class="fa fa-close"></i></span>
                                            @if($user->pic)
                                                @if((substr($user->pic, 0,5)) == 'https')
                                                    <img src="{{ $user->pic }}" alt="img"
                                                         class="img-responsive"/>
                                                @else
                                                    <img src="{!! url('/').'/public/uploads/users/'.$user->pic !!}" alt="img"
                                                         class="img-responsive"/>
                                                @endif
                                            @elseif($user->gender === "male")
                                                <img src="{{ asset('public/assets/images/authors/avatar3.png') }}" alt="..."
                                                     class="img-responsive"/>
                                            @elseif($user->gender === "female")
                                                <img src="{{ asset('public/assets/images/authors/avatar5.png') }}" alt="..."
                                                     class="img-responsive"/>
                                            @else
                                                <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="..."
                                                     class="img-responsive"/>
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-primary btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="pic" id="pic" />
                                            </span>
                                        </div>
                                    </div>
                                    <span class="help-block">{{ $errors->first('pic', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                <label class="col-sm-12">
                                    First Name:
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-sm-12">
                                        <input type="text" placeholder=" " name="first_name" id="uf-name"
                                               class="form-control" value="{!! old('first_name',$user->first_name) !!}">
                                    <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                <label class="col-sm-12">
                                    Last Name:
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-sm-12">
                                        <input type="text" placeholder=" " name="last_name" id="ul-name"
                                               class="form-control"
                                               value="{!! old('last_name',$user->last_name) !!}">
                                    <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                <label class="col-sm-12">
                                    Email:
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-sm-12">
                                        <input type="text" placeholder=" " id="email" name="email" class="form-control"
                                               value="{!! old('email',$user->email) !!}">
                                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                <p class="text-warning col-md-offset-2"><strong>If you don't want to change password... please leave them empty</strong></p>
                                <label class="col-sm-12">
                                    Password:
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-sm-12">
                                        <input type="password" name="password" placeholder=" " id="pwd" class="form-control">
                                    <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                <label class="col-sm-12">
                                    Confirm Password:
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-sm-12">
                                        <input type="password" name="password_confirm" placeholder=" " id="cpwd" class="form-control">
                                    <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Gender: </label>
                                <div class="col-sm-12 radiobox">
                                    <div class="radio">
                                            <input type="radio" name="gender" value="male" @if($user->gender === "male") checked="checked" @endif />
                                         <label>   Male
                                        </label>
                                    </div>
                                    <div class="radio">
                                            <input type="radio" name="gender" value="female" @if($user->gender === "female") checked="checked" @endif />
                                           <label>  Female
                                        </label>
                                    </div>
                                    <div class="radio">
                                            <input type="radio" name="gender" value="other" @if($user->gender === "other") checked="checked" @endif />
                                           <label>   Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  {{ $errors->first('bio', 'has-error') }}">
                                <label for="" class="col-sm-12">Bio <small>(brief intro):</small></label>
                                <div class="col-sm-12">
                                            <textarea name="bio" id="bio" class="form-control resize_vertical"
                                                      rows="4">{!! old('bio', $user->bio) !!}</textarea>
                                </div>
                                {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
                            </div>
                <h3 class="text-center">Contact</h3>
                            <div class="form-group {{ $errors->first('address', 'has-error') }}">
                                <label class="col-sm-12">
                                    Address:
                                </label>
                                <div class="col-sm-12">
                                            <textarea rows="5" cols="30" class="form-control resize_vertical" id="add1"
                                                      name="address">{!! old('address',$user->address) !!}</textarea>
                                </div>
                                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                            </div>
                            <div class="form-group {{ $errors->first('country', 'has-error') }}">
                                <label class="col-sm-12">Select Country: </label>
                                <div class="col-sm-12">
                                    {!! Form::select('country', $countries, $user->country,['class' => 'form-control select2', 'id' => 'countries']) !!}
                                    <span class="help-block">{{ $errors->first('country', ':message') }}</span>
                                </div>
                            </div>
                        <div class="form-group {{ $errors->first('user_state', 'has-error') }}">
                            <label class="col-sm-12" for="user_state">State:</label>
                                <div class="col-sm-12">
                                        <input type="text" placeholder=" " id="user_state" class="form-control"
                                               name="user_state" value="{!! old('city',$user->user_state) !!}"/>
                                </div>
                            <span class="help-block">{{ $errors->first('user_state', ':message') }}</span>
                            </div>
                            <div class="form-group {{ $errors->first('city', 'has-error') }}">
                                <label class="col-sm-12" for="city">City:</label>
                                <div class="col-sm-12">
                                        <input type="text" placeholder=" " id="city" class="form-control" name="city"
                                               value="{!! old('city',$user->city) !!}"/>
                                </div>
                                <span class="help-block">{{ $errors->first('city', ':message') }}</span>
                            </div>
                            <div class="form-group {{ $errors->first('postal', 'has-error') }}">
                                <label class="col-sm-12" for="postal">Postal:</label>
                                <div class="col-sm-12">
                                        <input type="text" placeholder=" " id="postal" class="form-control"
                                               name="postal" value="{!! old('postal',$user->postal) !!}"/>
                                    <span class="help-block">{{ $errors->first('postal', ':message') }}</span>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->first('dob', 'has-error') }}">
                                <label class="col-sm-12">
                                    DOB:
                                </label>
                                <div class="col-sm-12">
{{--                                        @if($user->dob === "0000-00-00")--}}
{{--                                            {!!  Form::text('dob', '', array('id' => 'datepicker','class' => 'form-control'))  !!}--}}
                                            @if($user->dob === '')
                                                {!!  Form::text('dob', null, array('id' => 'datepicker','class' => 'form-control'))  !!}
                                        @else
                                                 {!!  Form::text('dob', old('dob',$user->dob), array('id' => 'datepicker','class' => 'form-control', 'data-date-format'=> 'YYYY-MM-DD'))  !!}
                                        @endif
                                    <span class="help-block">{{ $errors->first('dob', ':message') }}</span>
                                </div>
                            </div>
</div>
<div class="formfooter text-center">
        <button class="btn btn-primary" type="submit">Save</button>
 </div>
        </form> {{--{!!  Form::close()  !!}--}}
    </div>
      </div>
        </div>
</div>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/user_account.js') }}"></script>
@stop
