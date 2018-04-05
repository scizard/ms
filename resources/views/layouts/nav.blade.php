<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7 no-js" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 no-js" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="en" class="no-js">

<!-- Mirrored from haintheme.com/demo/html/{{env('APP_NAME')}}/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 Feb 2018 13:22:06 GMT -->
<head>
    <!-- Basic need -->
    <title>{{env('APP_NAME')}}</title>
    <meta charset="UTF-8">
    <meta name="description" content="{{env('APP_NAME')}} - Real Estate HTML Template">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="profile" href="#">
    <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->

    <!-- Mobile specific meta -->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone-no">
    <link rel="stylesheet" href="{{asset("homeStyles/css/plugins.css")}}">
    <link rel="stylesheet" href="{{asset('homeStyles/css/style.css')}}">
</head>

<body>
<div id="page-loader">
    <div class="page-loader__logo">
        <img src="{{asset('homeStyles/images/uploads/logo.png')}}" alt="{{env('APP_NAME')}} Logo">
    </div><!-- .page-loader__logo -->

    <div class="sk-folding-cube">
        <div class="sk-cube1 sk-cube"></div>
        <div class="sk-cube2 sk-cube"></div>
        <div class="sk-cube4 sk-cube"></div>
        <div class="sk-cube3 sk-cube"></div>
    </div><!-- .sk-folding-cube -->
</div><!-- .page-loader -->

<header class="header header--blue header--top">
    <div class="container">
        <div class="topbar">
            <ul class="topbar__contact">
                <li><span class="ion-ios-telephone-outline topbar__icon"></span><a href="tel:8801234567"
                                                                                   class="topbar__link">+254 706 256 130</a>
                </li>
                <li><span class="ion-ios-email-outline topbar__icon"></span><a
                            href="mailto:{{env('APP_NAME')}}@support.com"
                            class="topbar__link">{{env('APP_NAME')}}@support.com</a></li>
            </ul><!-- .topbar__contact -->
        </div><!-- .topbar -->

        <div class="header__main">
            <div class="header__logo">
                <a href="{{ route('index') }}">
                    <h1 class="screen-reader-text">{{env('APP_NAME')}}</h1>
                    <img src="{{asset('homeStyles/images/uploads/logo.png')}}" alt="{{env('APP_NAME')}}">
                </a>
            </div><!-- .header__main -->

            <div class="nav-mobile">
                <a href="#" class="nav-toggle">
                    <span></span>
                </a><!-- .nav-toggle -->
            </div><!-- .nav-mobile -->

            <div class="header__menu header__menu--v1">
                <ul class="header__nav">
                    <li class="header__nav-item">
                        <a href=" {{ route('index') }}" class="header__nav-link">Home</a>
                    </li>
                    <li class="header__nav-item">
                        <a href="#about" class="header__nav-link">About</a>
                    </li>
                    <li class="header__nav-item">
                        <a href="#" class="header__nav-link">Property</a>
                        <ul>
                            <li><a href="{{ route('rentals') }}">Rentals</a></li>
                            <li><a href="{{ route('hostels') }}">Hostels</a></li>
                            <li><a href="{{ route('commercials') }}">Commercials</a></li>
                            <li><a href="{{ route('apartments') }}">Apartments</a></li>
                        </ul>
                    </li>

                    <li class="header__nav-item">
                        <a href="#contact" class="header__nav-link">Contact us</a>
                    </li>
                    <li class="header__nav-item">
                        <a href=" {{ route('index') }}" class="header__nav-link">Help</a>
                    </li>
                </ul><!-- .header__nav -->

            </div><!-- .header__menu -->
            <ul class="header__nav">
                <li class=" header__cta ">
                    <a href="#" class="header__cta">Register</a>
                    <ul>
                        <li><a href="{{ url('/register') }}">Tenant</a></li>
                        <li><a href="{{ route('landlord.register') }}">Landlord</a></li>
                    </ul>
                </li>
                <li class="header__cta">
                    <a href="#" class=" header__cta">Login</a>
                    <ul>
                        <li><a href="{{ url('/login') }}">Tenant</a></li>
                        <li><a href="{{ route('landlord.login') }}">Landlord</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- .header__main -->
    </div><!-- .container -->
</header>