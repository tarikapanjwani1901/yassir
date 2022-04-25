<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        YasSir | Your Corporate Motto
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- global css -->

    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <!-- font Awesome -->

    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
            <!--end of page level css-->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/images/favicon.ico') }}">

<body class="skin-josh">
<header class="header">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <img src="{{ asset('public/assets/img/logo.png') }}" alt="logo" >

    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <a class="btn btn-danger btn-flat" href="{{url('/')}}" target="_blank" style="margin-top:8px; background-color:#8c1730"><span class="glyphicon glyphicon-log-in"></span>&nbsp; &nbsp; Go to Front-End</a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Sentinel::getUser()->pic)
                                <img src="{!! url('/').'/public/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "male")
                                <img src="{{ asset('public/assets/images/authors/avatar3.png') }}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "female")
                                <img src="{{ asset('public/assets/images/authors/avatar5.png') }}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>

                            @else
                                <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>
                            @endif
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</p>
                                <span>
                                        <i class="caret"></i>
                                    </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            @if(Sentinel::getUser()->pic)
                                <img src="{!! url('/').'/public/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "male")
                                <img src="{{ asset('public/assets/images/authors/avatar3.png') }}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>

                            @elseif(Sentinel::getUser()->gender === "female")
                                <img src="{{ asset('public/assets/images/authors/avatar5.png') }}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>
                            @else
                                <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px"
                                     class="img-square img-responsive pull-left"/>
                            @endif
                            <p class="topprofiletext">{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</p>
                        </li>
                        <!-- Menu Body -->
                        <li>
                            <a href="{{ URL::route('admin.users.show',Sentinel::getUser()->id) }}">
                                <i class="livicon" data-name="user" data-s="18"></i>
                                My Profile
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <li>
                            @if(Sentinel::inRole('vendor'))
                                <a href="{{ URL::to('my-account') }}">
                            @else
                                <a href="{{ route('admin.users.edit', Sentinel::getUser()->id) }}">
                            @endif
                                <i class="livicon" data-name="gears" data-s="18"></i>
                                Account Settings
                            </a>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ URL::route('lockscreen',Sentinel::getUser()->id) }}">
                                    <i class="livicon" data-name="lock" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>
                                    Lock
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ URL::to('admin/logout') }}">
                                    <i class="livicon" data-name="sign-out" data-s="15"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="nav_icons">
                    <ul class="sidebar_threeicons">
                        <li>
                            <a href="{{ URL::to('admin/groups') }}">
                                <i class="livicon" data-name="image" title="Group" data-loop="true"
                                   data-color="#418BCA" data-hc="#418BCA" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/users') }}">
                                <i class="livicon" data-name="user" title="Users" data-loop="true"
                                   data-color="#6CC66C" data-hc="#6CC66C" data-s="25"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('admin.layouts._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
        <div id="notific">
        @include('notifications')
        </div>

                <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('public/assets/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/jquery.validate.min.js') }}"></script>
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
</body>
</html>
