<?php
$args = [];
$args['new_feedback'] = [];
$args['new_feedback']['cnt'] = 0;
$kernel = [];
$kernel['username'] = '';   
$kernel['id_user'] = 0;
$args['config'] = [];
$args['config']['modules_name'] = [];
$args['subtitle'] =1;
$args['mod_parents'] = [];
$args['mod'] = '1';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Riplister') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/admin_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
{{--    <link href="/admin_assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">--}}
    <link href="/admin_assets/global/plugins/select2/select2.css" rel="stylesheet">
    <link href="/admin_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link href="{{ asset('admin_assets/css/all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/css/custom.css?1') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin_assets/css/preloader.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .select2-container{padding: 0; width: auto !important; min-width: 150px;}
        .select2-container .select2-choice{border-radius: 0; line-height: 32px; height: auto;}
        .select2-container .select2-choice .select2-arrow b{background-position: 0 4px;}
        .editable-buttons button{margin-right: 4px !important;}
    </style>
    {!! \Assets::css() !!}

    @stack('css')

    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/admin_assets/favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">

<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{ route('admin.index') }}">
                <img src="/img/logo.svg" style="width: 130px" alt="logo" class="logo-default"/>
            </a>
            <div class="sidebar-toggler si-icon si-icon-hamburger" data-icon-name="hamburger"></div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <!--		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>-->
        <div class="responsive-toggler si-icon si-icon-hamburger-resp" data-icon-name="hamburger" data-toggle="collapse" data-target=".navbar-collapse"></div>

        <!-- END RESPONSIVE MENU TOGGLER -->

        <div class="page-actions">
            <div class="btn-group">
                <a class="btn btn-sm blue" href="{{ route('home') }}" target="_blank"><i class="fa fa-eye"></i> Перейти на сайт</a>
            </div>

        </div>

        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">

            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"> </li>
                    @include('core::partials.feedback_block')
                    @include('core::partials.user_block')
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->

    @include('core::partials.left-menu')

    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>@yield('page-title')</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="/admin/">CMS</a>
                </li>

                @yield('breadcrumb')

                <li class="active">
                    @if(request()->segment(2))
                        <i class="fa fa-circle"></i>@yield('page-title')
                    @else
                        <i class="fa fa-circle"></i> Главная
                    @endif
                </li>
            </ul>
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">
                <div class="col-md-12">
                    @if (flash()->message)
                        <div class="alert {{ flash()->class }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ flash()->message }}
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->

        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        {{ date('Y') }} &copy; <a href="/" title="RIP LISTER" target="_blank">RIP LISTER</a>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<div class="preloader">
    <div class="container">
        <div class="box1"></div>
        <div class="box2"></div>
        <div class="box3"></div>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="/admin_assets/global/plugins/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="{{ asset('admin_assets/js/all.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin_assets/js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin_assets/js/serialize.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin_assets/js/tiny.js') }}?1" type="module"></script>
<!-- END PAGE LEVEL SCRIPTS -->
{!! \Assets::js() !!}
@stack('scripts')
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="/admin_assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="/admin_assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script src="/admin_assets/global/plugins/select2/select2.full.js"></script>
<script src="/admin_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>