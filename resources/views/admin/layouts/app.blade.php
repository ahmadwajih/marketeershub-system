<!DOCTYPE html>
<html @if(app()->getLocale()=='ar') direction="rtl" dir="rtl" style="direction: rtl" @endif>
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>@yield('title') - MarketeersHub </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">

		<!--end::Fonts-->

		@if(app()->getLocale()=='en')
			<!--begin::Page Vendors Styles(used by this page)-->
			<link href="{{ asset('dashboard') }}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
			<!--end::Page Vendors Styles-->
			<!--begin::Global Theme Styles(used by all pages)-->
			<link href="{{ asset('dashboard') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
			<!--end::Global Theme Styles-->
			<!--begin::Layout Themes(used by all pages)-->
			<link href="{{ asset('dashboard') }}/css/themes/layout/header/base/dark.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/themes/layout/header/menu/dark.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		@else
			<!--begin::Page Vendors Styles(used by this page)-->
			<link href="{{ asset('dashboard') }}/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />
			<!--end::Page Vendors Styles-->
			<!--begin::Global Theme Styles(used by all pages)-->
			<link href="{{ asset('dashboard') }}/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/plugins/custom/prismjs/prismjs.bundle.rtl.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/style.bundle.rtl.css" rel="stylesheet" type="text/css" />
			<!--end::Global Theme Styles-->
			<!--begin::Layout Themes(used by all pages)-->
			<link href="{{ asset('dashboard') }}/css/themes/layout/header/base/light.rtl.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/themes/layout/header/menu/light.rtl.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/themes/layout/brand/dark.rtl.css" rel="stylesheet" type="text/css" />
			<link href="{{ asset('dashboard') }}/css/themes/layout/aside/dark.rtl.css" rel="stylesheet" type="text/css" />
		@endif
        <!--begin::Custom Style -->
        <link href="{{asset('dashboard/css/custom.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Custom Style-->

        <!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{ asset('dashboard') }}/media/logos/favicon.ico" />
        <script src="{{ mix('js/app.js') }}?id={{ assetsId() }}" defer></script>
        @stack('headers')
        @stack('styles')
    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="{{route('admin.index')}}">
                <img src="{{ asset('dashboard') }}/images/logo.png?d=<?php echo time()?>" alt="Logo" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--end::Header Menu Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">


                @include('admin.layouts.aside')


				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">


                    @include('admin.layouts.page_header')


					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--begin::Subheader-->
                        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap mr-2">
                                    <!--begin::Page Title-->
                                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">@yield('title')</h5>
                                    <!--end::Page Title-->
                                </div>
                                <!--end::Info-->

                            </div>
                        </div>
                        <!--end::Subheader-->
						<div id="history"></div>

                        @yield('content')

					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between mx-auto" style="width: fit-content">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class=" font-weight-bold mr-2"> © 2021</span>
								<a href="#" target="_blank" class="text-dark-75 text-hover-primary"><b>MarketeersHub</b></a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>

        <script src="{{ asset('dashboard') }}/js/dashboard.js"></script>
		<!--end::Main-->
        <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('dashboard') }}/plugins/global/plugins.bundle.js"></script>
		<script src="{{ asset('dashboard') }}/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="{{ asset('dashboard') }}/js/scripts.bundle.js"></script>
		{{-- Toster Js --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="{{ asset('dashboard') }}/js/main.js"></script>

		<!--end::Page Vendors-->
		<script>
			// Define Globe route to use it in trashed files
			var trashGetUrl = '/admin/trashed/';
			var trashForceDeleteUrl = '/admin/trashed/force-delete/';
			var trashRestoreUrl = '/admin/trashed/restore/';
		</script>
		{{-- Begin::read notifications  --}}
		<script>
			$(document).ready(function(){
				$('#notification-bell').on('click', function(){
					// var notificationId = $(this).data('notification');
					$.ajax({
						method: "POST",
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						url: "{{route('admin.ajax.read.notifications')}}",
					})

				});
			})
		</script>
		<script>
			$(document).ready(function(){
				// Show history
				$(".show-history").on("click",function(){
					var activityId = $(this).data('id');
					$.ajax({
						method: "POST",
						cache: false,
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						url: "{{route('admin.ajax.view.activity.history')}}",
						data: {
							activityId: activityId,
						},
					})
					.done(function(response) {
							$("#history").html(response);
					})
					.fail(function(response){
					});
				});
			});

		</script>
		{{-- End::read notifications  --}}
        @stack('scripts')
	</body>
	<!--end::Body -->
</html>
