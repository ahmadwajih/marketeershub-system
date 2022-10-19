<!DOCTYPE html>
<!--
Author: Ahmed Wageh
Product Name: MarketeersHub statem
Contact: ahmad.wajih@marketeershub.com - a.ahmedwageh@gmail.com
Facebook: https://www.facebook.com/a.ahmed.wagih/
LinkedIn: https://www.linkedin.com/in/ahmed-wagih-829bb4124/
-->
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../../">
    <title>MH System Login</title>
    <meta charset="utf-8" />
    <meta name="description"
    content="Marketeers Hub is a performance marketing agency built to solidify your digital presence, in order to create impact and achieve your business goals. Our highly experienced team connects your business with the largest local and international affiliate networks via data-driven strategies that deliver unprecedented & sustainable results." />
    <meta name="keywords"
        content="Marketeers Hub is a performance marketing agency built to solidify your digital presence, in order to create impact and achieve your business goals. Our highly experienced team connects your business with the largest local and international affiliate networks via data-driven strategies that deliver unprecedented & sustainable results." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Marketeers Hub is a performance marketing agency built to solidify your digital presence, in order to create impact and achieve your business goals. Our highly experienced team connects your business with the largest local and international affiliate networks via data-driven strategies that deliver unprecedented & sustainable results." />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('new_dashboard') }}/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('new_dashboard') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('new_dashboard') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%; 
            min-height: 100%;
            z-index: 0;
        }
    </style>
    @stack('styles')
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="metronic" id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <video autoplay muted loop id="myVideo">
        <source src="{{ asset('new_dashboard/media/videos') }}/Marketeers Hub - Motion Graphic.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    
    @yield('content')
    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ asset('new_dashboard') }}/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('new_dashboard') }}/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="{{ asset('new_dashboard') }}/js/custom/authentication/sign-up/general.js"></script>
    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
