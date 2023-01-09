@extends('new_admin.auth.layouts.app')
@section('title', 'Forget Password')
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
                background-image: url('assets/media/auth/bg10.jpeg');
            }

            [data-theme="dark"] body {
                background-image: url('assets/media/auth/bg10-dark.jpeg');
            }

            .flex-column-fluid {
                z-index: 2;
            }

            .flex-column-fluid {
                margin: auto;
                background: #1e1e2d6b;
                width: 100%;
                height: 100%;
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Password reset -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
                <!--begin::Wrapper-->
                <div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10 m-auto">
                    <!--begin::Content-->
                    <div class="w-500">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form"
                            data-kt-redirect-url="{{ route('admin.reset.password') }}"
                            data-kt-post-route-url="{{ route('admin.forgot.password') }}"
                            action="#">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email" autocomplete="off"
                                    class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Actions-->
                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Submit</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                                <a href="{{ route('admin.login.form') }}"
                                    class="btn btn-light">Cancel</a>
                            </div>
                            <!--end::Actions-->
                        </form>
                    </div>
                    <!--end::Form-->
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Password reset-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('new_dashboard/') }}/plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('new_dashboard/') }}/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="{{ asset('new_dashboard/') }}/js/custom/authentication/reset-password/reset-password.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection
@push('styles')
    <style>
        .w-500 {
            width: 500px;
        }
    </style>
@endpush
@push('scripts')
@endpush
