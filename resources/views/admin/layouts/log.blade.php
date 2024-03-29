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
        <link href="{{ asset($assets) }}/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/google-material-color/dist/palette.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

        <!-- CSS -->
        <link href="{{ asset($assets) }}/css/app.min.1.css" rel="stylesheet">
        <link href="{{ asset($assets) }}/css/app.min.2.css" rel="stylesheet"> 

        <!-- Custom -->
        <link href="{{ asset($assets) }}/custom/custom.css" rel="stylesheet"> 

    </head>
    
    <body>

        <!-- Main Page -->
        @include("admin/pages/$site_page")
        <!-- End Main Page -->

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

        <!-- Javascript Libraries -->
        <script src="{{ asset($assets) }}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{{ asset($assets) }}/vendors/bower_components/Waves/dist/waves.min.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="{{ asset($assets) }}/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="{{ asset($assets) }}/js/functions.js"></script>
        <script src="{{ asset($assets) }}/custom/custom.js"></script>
        
    </body>
</html>