
<!DOCTYPE html>
<html >
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>MarketeersHub - Admin Login</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="{{ asset('dashboard') }}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ asset('dashboard') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('dashboard') }}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('dashboard') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{ asset('dashboard') }}/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('dashboard') }}/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('dashboard') }}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('dashboard') }}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{ asset('dashboard') }}/media/logos/favicon.ico" />
    </head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('/public/dashboard/media/bg/bg-3.jpg');">
					<div class="login-form text-center p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center">
							<a href="#">
								<img src="{{ asset('dashboard') }}/images/logo.png?d=<?php echo time()?>" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-20 mt-20">
								<h3>Login to dashboard</h3>
								<div class="text-muted font-weight-bold">Pleas enter your email and password</div>
							</div>
							<form action="{{ route('admin.login') }}" class="form" id="kt_login_signin_form" method="POST">
								@csrf
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
								</div>
								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
								 </div>
								<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
									<div class="checkbox-inline">
										<label class="checkbox m-0 text-muted">
										<input type="checkbox" name="remember" />
										<span></span>Remeber Me</label>
									</div>
									{{-- <a href="javascript:;" id="kt_login_forgot" cla ss="text-muted text-hover-primary">نسيت كلمة المرور؟</a> --}}
								</div>
								<button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Login</button>
							</form>

						</div>
						<!--end::Login Sign in form-->
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('dashboard') }}/plugins/global/plugins.bundle.js"></script>
		<script src="{{ asset('dashboard') }}/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="{{ asset('dashboard') }}/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="{{ asset('dashboard') }}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Vendors-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="{{ asset('dashboard') }}/js/pages/widgets.js"></script>
        <!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>