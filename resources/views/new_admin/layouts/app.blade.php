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
    <base href="">
    <title> @yield('title', 'Home Page') - @yield('subtitle') - {{ __('Admin Dashboard') }} - {{ __('Marketeershub') }}</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="Marketeers Hub is a performance marketing agency built to solidify your digital presence, in order to create impact and achieve your business goals. Our highly experienced team connects your business with the largest local and international affiliate networks via data-driven strategies that deliver unprecedented & sustainable results." />
    <meta name="keywords"
        content="Marketeers Hub is a performance marketing agency built to solidify your digital presence, in order to create impact and achieve your business goals. Our highly experienced team connects your business with the largest local and international affiliate networks via data-driven strategies that deliver unprecedented & sustainable results." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title"
        content="Marketeers Hub is a performance marketing agency built to solidify your digital presence, in order to create impact and achieve your business goals. Our highly experienced team connects your business with the largest local and international affiliate networks via data-driven strategies that deliver unprecedented & sustainable results." />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset('new_dashboard') }}/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('new_dashboard') }}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('new_dashboard') }}/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('new_dashboard') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('new_dashboard') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    @stack('styles')
    <style>
        .custom-class-in-form-repeater{
            box-shadow: 0px 0px 15px -5px #fff;
            border-radius: 15px;
            padding: 10px;
            margin:  20px 0;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body data-kt-name="metronic" id="kt_body" class="header-fixed header-tablet-and-mobile-fixed">
    <!--begin::Theme mode setup on page load-->
    <script>
        if (document.documentElement) {
            const defaultThemeMode = "system";
            const name = document.body.getAttribute("data-kt-name");
            let themeMode = localStorage.getItem("kt_" + (name !== null ? name + "_" : "") + "theme_mode_value");
            if (themeMode === null) {
                if (defaultThemeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            document.documentElement.setAttribute("data-theme", 'dark');
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('new_admin.layouts.header')
                <div class="d-flex flex-column-fluid">
                    @include('new_admin.layouts.aside')
                    <!--begin::Container-->
                    <div class="d-flex flex-column flex-column-fluid container-fluid">
                        <!--begin::Post-->
                        <div class="content flex-column-fluid" id="kt_content">
                            @if ($errors->any())
                                <!--begin::Alert-->
                                <div class="alert alert-danger d-flex align-items-center p-5">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-3"><i
                                            class="fa-solid fa-triangle-exclamation fa-2x"></i></span>
                                    <!--end::Icon-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Title-->
                                        <h4 class="mb-1 text-dark">Error</h4>
                                        <!--end::Title-->
                                        <!--begin::Content-->
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Alert-->
                            @endif
                            @if (session()->has('message'))
                                <!--begin::Alert-->
                                <div class="alert alert-success d-flex align-items-center p-5">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-success me-3"><i class="fa-solid fa-check fa-2x"></i></span>
                                    <!--end::Icon-->

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Title-->
                                        <h4 class="mb-1 text-dark">Success</h4>
                                        <!--end::Title-->
                                        <!--begin::Content-->
                                        <p>{{session()->get('message')}}</p>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Close-->
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <span class="svg-icon svg-icon-2x svg-icon-light"><i class="fa-solid fa-xmark fa-2x"></i></span>
                                        </button>
                                        <!--end::Close-->
                                </div>
                                <!--end::Alert-->
                            @endif

                            @yield('content')
                        </div>
                        @include('new_admin.layouts.footer')
                    </div>
                </div>

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('new_dashboard') }}/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('new_dashboard') }}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('new_dashboard') }}/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="{{ asset('new_dashboard') }}/js/widgets.bundle.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/custom/widgets.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/custom/utilities/modals/create-app.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <script>
        var csrfToken = "{{ csrf_token() }}";
    </script>
    @stack('scripts')
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
