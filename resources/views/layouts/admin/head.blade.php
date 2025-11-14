<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>@yield('title', 'Admin | Dashboard')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
	<meta name="color-scheme" content="light dark" />
	<meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
	<meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
	<meta name="supported-color-schemes" content="light dark" />

	{{-- Fonts & plugins --}}
	<link rel="preload" href="{{ asset('assets/css/adminlte.css') }}" as="style" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print" onload="this.media='all'" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />

    {{-- Main AdminLTE CSS (local build) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.css') }}" />

    {{-- Optional third-party css (apexcharts, jsvectormap) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" crossorigin="anonymous" />

    {{-- Custom CSS for AdminLTE components --}}
    <style>
        /* Small Box Styles */
        .small-box {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            display: block;
            margin-bottom: 20px;
            position: relative;
        }
        .small-box > .inner {
            padding: 10px;
        }
        .small-box > .small-box-footer {
            background-color: rgba(0,0,0,.1);
            color: rgba(255,255,255,.8);
            display: block;
            padding: 3px 0;
            position: relative;
            text-align: center;
            text-decoration: none;
            z-index: 10;
        }
        .small-box > .small-box-footer:hover {
            background-color: rgba(0,0,0,.15);
            color: #fff;
        }
        .small-box h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 10px;
            padding: 0;
            white-space: nowrap;
        }
        .small-box p {
            font-size: 1rem;
        }
        .small-box .icon {
            color: rgba(0,0,0,.15);
            z-index: 0;
        }
        .small-box .icon > i {
            font-size: 70px;
            position: absolute;
            right: 15px;
            top: 15px;
            transition: transform .3s linear;
        }
        .small-box:hover .icon > i {
            transform: scale(1.1);
        }
        
        /* Button App Styles */
        .btn-app {
            border-radius: 3px;
            position: relative;
            padding: 15px 5px;
            margin: 0 0 10px 10px;
            min-width: 80px;
            height: 60px;
            text-align: center;
            color: #666;
            border: 1px solid #ddd;
            background-color: #f4f4f4;
            font-size: 12px;
        }
        .btn-app > .bi {
            font-size: 20px;
            display: block;
        }
        .btn-app:hover {
            background: #f4f4f4;
            color: #444;
            border-color: #aaa;
        }
        
        /* Card Styles */
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0,0,0,.125);
            padding: 0.75rem 1.25rem;
            position: relative;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }
        
        /* User Menu Styles */
        .user-menu .user-image {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .user-menu .dropdown-menu {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            padding: 0;
            width: 280px;
        }
        .user-header {
            height: 175px;
            padding: 10px;
            text-align: center;
        }
        .user-header img {
            z-index: 5;
            height: 90px;
            width: 90px;
            border: 3px solid;
            border-color: transparent;
            border-color: rgba(255,255,255,.2);
        }
        .user-header p {
            z-index: 5;
            color: #fff;
            color: rgba(255,255,255,.8);
            font-size: 17px;
            margin-top: 10px;
        }
        .user-header p small {
            display: block;
            font-size: 12px;
        }
        .user-body {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            border-top: 1px solid #dee2e6;
        }
        .user-body a {
            color: #495057;
        }
        .user-footer {
            background-color: #f8f9fa;
            padding: 10px;
        }
        .user-footer .btn-default {
            color: #6c757d;
        }
    </style>

    @stack('head')
</head>