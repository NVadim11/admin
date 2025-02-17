<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../../"/>
    <title>{{ config('app.name', 'TommyCat') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ config('app.name', 'TommyCat') }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'TommyCat') }}" />
    <link rel="shortcut icon" href="{{ config('assets.metronic.assets_path', '') }}/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ config('assets.metronic.assets_path', '') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ config('assets.metronic.assets_path', '') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>body { background-image: url('{{ config('assets.metronic.assets_path', '') }}/media/auth/bg4.jpg'); } [data-bs-theme="dark"] body { background-image: url('{{ config('assets.metronic.assets_path', '') }}/media/auth/bg4-dark.jpg'); }</style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="{{ route('login') }}" class="mb-7">
                    <img alt="Logo" style="height: 100px;" src="/img/logo-white.png" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0">What kind of lion is this tiger?</h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <!--begin::Form-->
                    @yield('content')
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
{{--                @include('core::layouts.themes.' . config('assets.metronic.theme_path') . '.signin.particles.locales')--}}
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "{{ config('assets.metronic.assets_path', '') }}/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ config('assets.metronic.assets_path', '') }}/plugins/global/plugins.bundle.js"></script>
<script src="{{ config('assets.metronic.assets_path', '') }}/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ config('assets.base.scripts', '') }}/sign-in/general.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
