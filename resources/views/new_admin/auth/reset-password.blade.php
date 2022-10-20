@extends('new_admin.auth.layouts.app')
@section('title', 'Reset Password')
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
                        <!--begin::Form-->
                        <form class="form w-100" action="{{ route('admin.reset.password') }}" method="POST">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                                    <a href="{{ route('admin.login.form') }}" class="link-primary fw-bold">Sign in</a>
                                </div>

                                @if ($errors->any())
                                    <!--begin::Alert-->
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <!--begin::Icon-->
                                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3"><i class="fa-sharp fa-solid fa-bell"></i></span>
                                        <p class="mb-1 text-dark">{{ $errors->first() }}</p>
                                    </div>
                                    <!--end::Alert-->
                                @endif
                                @if ($errors->has('message'))
                                    <!--begin::Alert-->
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <!--begin::Icon-->
                                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3"><i class="fa-sharp fa-solid fa-bell"></i></span>
                                        <p class="mb-1 text-dark">{{ $errors->first('message') }}</p>
                                    </div>
                                    <!--end::Alert-->
                                @endif
                                @if ($errors->has('email'))
                                    <!--begin::Alert-->
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <!--begin::Icon-->
                                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3"><i class="fa-sharp fa-solid fa-bell"></i></span>
                                        <p class="mb-1 text-dark">{{ $errors->first('email') }}</p>
                                    </div>
                                    <!--end::Alert-->
                                @endif

                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                             <!--begin::Input group=-->
                             <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email"
                                    class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Input group-->
                             <!--begin::Input group=-->
                             <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="code" name="code"
                                    class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--begin::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password" placeholder="Password"
                                            name="password" autocomplete="off" />
                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="bi bi-eye-slash fs-2"></i>
                                            <i class="bi bi-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <!--end::Input wrapper-->
                                    <!--begin::Meter-->
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group=-->
                            <!--end::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Repeat Password-->
                                <input type="password" placeholder="Repeat Password" name="password_confirmation"
                                    autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Repeat Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Input group=-->
                            {{-- <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-6 ms-1">I Agree &amp;
                                        <a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
                                </label>
                            </div> --}}
                            <!--end::Input group=-->
                            <!--begin::Action-->
                            <div class="d-grid mb-10">
                                <button type="submit"  class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Submit</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                                <a href="{{ route('admin.login.form') }}"
                                    class="btn btn-light mt-3">Cancel</a>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
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
    <script src="{{ asset('new_dashboard/') }}/js/custom/authentication/password-reset/new-password.js"></script>
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
