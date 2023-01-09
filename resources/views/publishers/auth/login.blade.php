@extends('new_admin.auth.layouts.app')
@section('title', 'Login')
@section('content')
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
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset('new_dashboard') }}/media/auth/bg10.jpeg');
            }

            [data-theme="dark"] body {
                background-image: url('{{ asset('new_dashboard') }}/media/auth/bg10-dark.jpeg');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-up -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid" style="z-index: 1;background: #0080002e;">

            <!--begin::Body-->
            <div class="d-flex flex-column-fluid  justify-content-center p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-1000px p-10 m-auto">
                    <!--begin::Content-->
                    <div class="w-500">
                        <!--begin::Form-->
                       <!--begin::Form-->
							<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('admin.login') }}" method="POST">
                                @csrf
								<!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->

								<!--begin::Separator-->
								<div class="separator separator-content my-14">
									<span class="w-125px text-gray-500 fw-semibold fs-7">with email</span>
								</div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

								<!--end::Separator-->
								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Email-->
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                    @if ($errors->has('email'))
                                        <div>
                                            <p class="invalid-input">{{ $errors->first('email') }}</p>
                                        </div>
                                    @endif
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-3">
									<!--begin::Password-->
									<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                                    @if ($errors->has('password'))
                                        <div>
                                            <p class="invalid-input">{{ $errors->first('password') }}</p>
                                        </div>
                                    @endif
									<!--end::Password-->
								</div>
								<!--end::Input group=-->
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div>
                                        <div class="fv-row mb-1 mt-2">
                                            <label class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="remember_me"/>
                                                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Remember Me</span>
                                            </label>
                                        </div>
                                    </div>
									<!--begin::Link-->
									<a href="{{ route('admin.forgot.password.form') }}" class="link-primary">Forgot Password ?</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->



								<!--begin::Submit button-->
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<!--begin::Indicator label-->
										<span class="indicator-label">Sign In</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div>
								<!--end::Submit button-->
								<!--begin::Sign up-->
								<div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
								<a href="{{ route('admin.register.form') }}" class="link-primary">Sign up</a></div>
								<!--end::Sign up-->
							</form>
							<!--end::Form-->
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-up-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
@endsection
@push('styles')
<style>
    .w-500{
        width: 500px;
    }
</style>
@endpush
@push('scripts')


@endpush
