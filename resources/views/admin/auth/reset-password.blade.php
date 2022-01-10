
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
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="{{ asset('dashboard') }}/css/pages/login/login-4.css" rel="stylesheet" type="text/css" />
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
			<div class="login login-signin-on login-4 d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url({{ asset('dashboard') }}/images/bg-2.jpg);">
					<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-15">
							<a href="#">
								<img src="{{ asset('dashboard') }}/images/logo.png?d=<?php echo time()?>" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-20">
								<h3 class="opacity-40 font-weight-normal">{{ __('Login to dashboard') }}</h3>
								<p class="opacity-40">{{ __('Enter your details to login to your account:') }}</p>
							</div>
							@if($errors->any())
								<div class="alert alert-danger">
                                        <p class="invalid-input">{{$errors->first()}}</p>
                                    </div>
                                @endif
							@if ($errors->has('message'))
								<div class="alert alert-danger">
									<p class="invalid-input">{{ $errors->first('message') }}</p>
								</div>
							@endif
							@if ($errors->has('email'))
								<div class="alert alert-danger">
									<p class="invalid-input">{{ $errors->first('email') }}</p>
								</div>
							@endif
							
							<form action="{{ route('admin.reset.password') }}" class="form" method="POST">
								@csrf
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="email" placeholder="Email" name="email" autocomplete="off" />
								</div>
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="verification code" name="code" autocomplete="off" />
								</div>
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="New Password" name="password" />
								</div>
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Confirm New Password" name="password_confirmation" />
								</div>
								<div class="form-group text-center mt-10">
									<button type="submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">{{ __('Reset Password') }}</button>
								</div>
							</form>
							<div class="mt-10">
								<span class="opacity-40 mr-4">{{ __('Do you need to login?') }}</span>
								<a href="javascript:;" id="kt_login_signup" class="text-white opacity-30 font-weight-normal">{{ __('Login') }}</a>
							</div>
						</div>
						<!--end::Login Sign in form-->
						<!--begin::Login Sign up form-->
						<div class="login-signup">
								<div class="mb-20">
									<h3 class="opacity-40 font-weight-normal">{{ __('Login to dashboard') }}</h3>
									<p class="opacity-40">{{ __('Enter your details to login to your account:') }}</p>
								</div>
								@if ($errors->has('message'))
									<div class="alert alert-danger">
										<p class="invalid-input">{{ $errors->first('message') }}</p>
									</div>
								@endif
								@if ($errors->has('email'))
									<div class="alert alert-danger">
										<p class="invalid-input">{{ $errors->first('email') }}</p>
									</div>
								@endif
								
								<form action="{{ route('admin.login') }}" class="form" method="POST">
									@csrf
									<div class="form-group">
										<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="email" placeholder="Email" name="email" autocomplete="on" />
									</div>
									<div class="form-group">
										<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Password" name="password" />
									</div>
									<div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
										<label class="checkbox checkbox-outline checkbox-white text-white m-0">
										<input type="checkbox" name="remember" />Remember me
										<span></span></label>
										<a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Forget Password ?</a>
									</div>
									<div class="form-group text-center mt-10">
										<button type="submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">Sign In</button>
										<button id="kt_login_signup_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel</button>
									</div>
								</form>
								{{-- <div class="mt-10">
									<span class="opacity-40 mr-4">Don't have an account yet?</span>
									<a href="javascript:;" id="kt_login_signin" class="text-white opacity-30 font-weight-normal">Sign Up</a>
								</div> --}}

						</div>
						<!--end::Login Sign up form-->
						<!--begin::Login forgot password form-->
						<div class="login-forgot">
							<div class="mb-20">
								<h3 class="opacity-40 font-weight-normal">{{ __('Forgotten Password ?') }}</h3>
								<p class="opacity-40">{{ __('Enter your email to reset your password') }}</p>
							</div>
							<form action="{{ route('admin.forgot.password') }}" class="form" method="POST">
								@csrf
								<div class="form-group mb-10">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="on" />
								</div>
								<div class="form-group">
									<button  type="submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">Request</button>
									<button id="kt_login_forgot_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel</button>
								</div>
							</form>
						</div>
						<!--end::Login forgot password form-->
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
		<script src="{{ asset('dashboard') }}/js/pages/custom/login/login.js"></script>
        <!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>