<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $site_title }}</title>

        <meta name="author" content="Core Lite Team">
        <meta name="robots" content="noindex, nofollow">

        <!-- Favicon Load -->
        <link rel="shortcut icon" href="{{ asset($assets) }}/favicon.ico" type="image/x-icon">

        <!-- Vendor CSS -->
        <link href="{{ asset($assets) }}/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">    
        <link href="{{ asset($assets) }}/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/google-material-color/dist/palette.css" rel="stylesheet">

        <link href="{{ asset($assets) }}/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/farbtastic/farbtastic.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/summernote/dist/summernote.css" rel="stylesheet">

        <!-- CSS -->
        <link href="{{ asset($assets) }}/css/app.min.1.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/css/app.min.2.css" rel="stylesheet"> 

        <!-- Custom -->
        <link href="{{ asset($assets) }}/custom/custom.css" rel="stylesheet"> 

        <!-- Font Awsome -->
        <script src="{{ asset($assets) }}/js/fontawesome.js"></script>
        
        <!-- Include Head -->
        @include("admin/functions/incl_head")
        <!-- End Include Head -->

    </head>


    <body data-ma-header="teal">
        <header id="header" class="media">
            <div class="pull-left h-logo">
                <a href="{{url('dashboard')}}" class="hidden-xs">
                    CORE  
                    <small>The Lite</small>
                </a>
                
                <div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
                    <div class="mc-wrap">
                        <div class="mcw-line top palette-White bg"></div>
                        <div class="mcw-line center palette-White bg"></div>
                        <div class="mcw-line bottom palette-White bg"></div>
                    </div>
                </div>
            </div>

            <ul class="pull-right h-menu">
                <li class="dropdown hidden-xs">
                    <a data-toggle="dropdown" href="#"><i class="hm-icon zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        <li class="hidden-xs">
                            <a data-action="fullscreen" href="#"><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown hm-profile">
                    <a data-toggle="dropdown" href="#">
                        <img src="{!!asset($CoreForm->userProfile())!!}" alt="">
                    </a>
                    
                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a class="core-sub-link" href="{{url('/')}}" target="_blank">
                                <i class="zmdi zmdi-view-web"></i> View Website
                            </a>
                        </li>
                        <li>
                            <a href='{{url("profile")}}'><i class="zmdi zmdi-account"></i> My Profile</a>
                        </li>
                        <li>
                            <a href='{{url("admin/logout")}}'><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <div class="media-body h-search hidden-xs hidden-sm">
                <div class="p-relative">
                    <span class="welcome-header">
                    </span>
                </div>
            </div>
            
        </header>



        <section id="main">

            <aside id="s-main-menu" class="sidebar">
                <div class="smm-header">
                    <i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
                </div>

                <ul class="smm-alerts">
                    <li class="core-sub-item">
                        <i class="zmdi zmdi-flash"></i>
                    </li>
                </ul>

                <ul class="main-menu">

                    <li class="dashboard">
                        <a class="core-sub-link" href='{{url("dashboard")}}'><i class="zmdi zmdi-input-composite"></i>
                        Dashboard
                        </a>
                    </li>
                    <?php if ($CoreLoad->auth('blog')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle">
                            <i class="zmdi zmdi-format-color-text green_less"></i> Blog 
                        </a>
                        <ul>
                            <li class=""><a href="{{url('blogs/new')}}">New</a></li>
                            <li class=""><a href="{{url('blogtag')}}">Tags</a></li>
                            <li class=""><a href="{{url('blogcategory')}}">Category</a></li>
                            <li class=""><a href="{{url('blogs')}}">Manage</a></li> <!--active -->
                        </ul>
                    </li>
                    <li class="" style="display: none;"><a href="#"><i class="zmdi zmdi-comment-list"></i> Blog Comments</a></li>
                    <?php endif ?>
                    <?php if ($CoreLoad->auth('page')): ?>
                    <li class="sub-menu">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-file-plus green_less"></i> Page </a>
                        <ul>
                            <li class=""><a href="{{url('pages/new')}}">New</a></li>
                            <li class=""><a href="{{url('pages')}}">Manage</a></li>
                        </ul>
                    </li>
                    <?php endif ?>

                    <!-- Extensions Menu -->
                    @include("admin/menus/extensions")
                    <!-- End Extensions Menu -->

                    <?php if ($CoreLoad->auth('autofield')): ?>
                    <li class=""><a href="{{url('autofields')}}">
                        <i class="zmdi zmdi-folder-star zmdi-hc-fw blue"></i> Auto Fields</a>
                    </li>
                    <?php endif ?>

                    <!-- Extensions -->
                    <?php if ($CoreLoad->auth('extension')): ?>
                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-puzzle-piece green"></i> Extensions </a>
                        <ul>
                            <li class=""><a href="{{url('extensions')}}">Manage</a></li>
                            <li class=""><a href="{{url('extensions/new')}}">New</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <!-- Fields Menu -->
                    @include("admin/menus/fields")
                    <!-- End Fields Menu -->

                    <?php if ($CoreLoad->auth('control')): ?>
                    <li class="sub-menu">
                        <a class="core-sidebar-link" href="#" data-ma-action="submenu-toggle">
                            <i class="zmdi zmdi-settings red_less"></i> Controls </a>
                        <ul>
                            <li class="core-sub-item" style="display: none;"><a href="#">Store</a></li>
                            <li class="core-sub-item" style="display: none;"><a href="#">Import</a></li>
                            <?php if ($CoreLoad->auth('inheritance')): ?>
                            <li class="core-sub-item"><a href="{{url('inheritances')}}">Inheritance</a></li>
                            <?php endif ?>
                            <?php if ($CoreLoad->auth('customfield')): ?>
                            <li class="core-sub-item">
                                <a class="core-sub-link" href="{{url('customfields')}}">
                                Custom Fields
                                </a>
                            </li>
                            <?php endif ?>
                            <?php if ($CoreLoad->auth('level')): ?>
                            <li class="core-sub-item">
                                <a class="core-sub-link" href="{{url('level')}}">
                                Access Level
                                </a>
                            </li>
                            <?php endif ?>
                            <!-- Controls Menu -->
                            @include("admin/menus/controls")
                            <!-- End Controls Menu -->
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($CoreLoad->auth('user')): ?>
                    <li class="sub-menu">
                        <a class="core-sidebar-link" href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-alt"></i> User </a>
                        <ul>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('users/open/add')}}">New</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('users')}}">Manage</a></li> 
                        </ul>
                    </li>
                    <?php endif ?>

                    <!-- Start Menu -->
                    @include("admin/menus/menu")
                    <!-- End Menu -->

                    <?php if ($CoreLoad->auth('setting')): ?>
                    <li class="sub-menu">
                        <a class="core-sidebar-link" href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-wrench red_less"></i> Settings </a>
                        <ul>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/general')}}">General</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/link')}}">Link</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/blog')}}">Page / Blog</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/mail')}}">Mail</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/seo')}}">Seo</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/inheritance')}}">Set Inheritance</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="{{url('settings/open/module')}}">Modules</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-swap-vertical-circle blue"></i> About </a>
                        <ul>
                            <li class=""><a href="#">Core</a></li>
                            <li class=""><a href="#">News</a></li>
                            <li class=""><a href="#">Updates</a></li>
                        </ul>
                    </li>

                    <li class=""><a href="{{url('admin/logout')}}">
                        <i class="zmdi zmdi-square-right zmdi-hc-fw"></i> Logout</a>
                    </li>
                </ul>

            </aside>
