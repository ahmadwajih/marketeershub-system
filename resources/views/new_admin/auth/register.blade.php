@extends('new_admin.auth.layouts.app')
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
                    <div class="w-90">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form"
                            data-kt-redirect-url="{{ route('admin.login.form') }}"
                            action="#">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                {{-- <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div> --}}
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Personal Info</span>
                            </div>
                            <!--end::Separator-->
                            <div class="row">
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::name-->
                                        <input type="text" placeholder="Name" name="name"
                                            class="form-control bg-transparent" />
                                        <!--end::name-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::phone-->
                                        <input type="text" placeholder="Phone" name="phone"
                                            class="form-control bg-transparent" />
                                        <!--end::phone-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Email-->
                                        <input type="text" placeholder="Email" name="email"
                                            class="form-control bg-transparent" />
                                        <!--end::Email-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-8" data-kt-password-meter="true">
                                        <!--begin::Wrapper-->
                                        <div class="mb-1">
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control bg-transparent" type="password"
                                                    placeholder="Password" name="password" autocomplete="off" />
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-2"></i>
                                                    <i class="bi bi-eye fs-2 d-none"></i>
                                                </span>
                                            </div>
                                            <!--end::Input wrapper-->
                                            <!--begin::Meter-->
                                            <div class="d-flex align-items-center mb-3"
                                                data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                            </div>
                                            <!--end::Meter-->
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Hint-->
                                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers
                                            &amp;
                                            symbols.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Repeat Password-->
                                        <input placeholder="Repeat Password" name="confirm-password" type="password"
                                            autocomplete="off" class="form-control bg-transparent" />
                                        <!--end::Repeat Password-->
                                    </div>
                                    <!--end::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="gender" aria-label="Gender" data-control="select2"
                                            data-placeholder="Gender" class="form-select">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>

                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="team" id="team" aria-label="Select a Team"
                                            data-control="select2" data-placeholder="Select Team" class="form-select">
                                            <option value="">Select Your Team</option>
                                            <option value="media_buying">Media Buying</option>
                                            <option value="influencer">Influencers</option>
                                            <option value="affiliate">Affiliate</option>
                                            <option value="prepaid">Prepaid Influencer</option>
                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="account_manager_id" aria-label="Referral by" data-control="select2"
                                            data-placeholder="Referral by" class="form-select" id="accountManagers">
                                            <option value="">Select who referred you</option>
                                            @foreach ($accountManagers as $accountManager)
                                                <option value="{{ $accountManager->id }}">{{ $accountManager->name }}
                                                </option>
                                            @endFOreach
                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="country_id" aria-label="Select Your Country" data-control="select2"
                                            data-placeholder="Select Your Country" class="form-select" id="country">
                                            <option value="">Select your country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endFOreach
                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="city_id" id="cities" aria-label="Select a city"
                                            data-control="select2" data-placeholder="Select city" class="form-select">
                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::Address-->
                                        <input type="text" placeholder="Address" name="address"
                                            class="form-control bg-transparent" />
                                        <!--end::Address-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="categories[]" aria-label="Select Categories" data-control="select2"
                                            multiple data-placeholder="Select Categories" class="form-select">
                                            <option value="">Select categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endFOreach
                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>
                                <div class="col-md-6">

                                </div>

                            </div>

                            <!-- Affiliates Inputs -->
                            <div class="affiliate">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-8">
                                            <!--begin::Affiliate Networks-->
                                            <input type="text" placeholder="Affiliate Networks"
                                                name="affiliate_networks" class="form-control bg-transparent" />
                                            <!--end::Affiliate Networks-->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fv-row mb-8">
                                            <!--begin::Years Of Experience-->
                                            <input type="text" placeholder="Years Of Experience"
                                                name="years_of_experience" class="form-control bg-transparent" />
                                            <!--end::Years Of Experience-->
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <select caria-label="Select Traffic Sources" data-control="select2"
                                                data-placeholder="Select Traffic Sources" class="form-select"
                                                name="traffic_sources[]" multiple>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('website', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="google_ad_words">{{ __('Google Ad words.') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('website', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="facebook_ig_ads">{{ __('Facebook & IG Ads.') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('instagram', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="instagram">{{ __('Instagram') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('twitter', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="twitter">{{ __('Twitter') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('snapchat', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="snapchat">{{ __('Snapchat') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('tiktok', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="tiktok">{{ __('Tiktok') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('youtube', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="youtube">{{ __('Youtube') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('pinterest', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="pinterest">{{ __('Pinterest') }}</option>
                                                <option
                                                    {{ old('traffic_sources') !== null && in_array('other', old('traffic_sources')) ? 'selected' : '' }}
                                                    value="other">{{ __('Other') }}</option>
                                            </select>
                                        </div>
                                        <!--begin::Input group=-->
                                    </div>
                                    <div class="col-12">
                                        <div class="card card-flush py-4">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Digital Asset</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Repeater-->
                                                <div id="kt_docs_repeater_basic" class="mb-5 mt-5">
                                                    <!--begin::Form group-->
                                                    <div class="form-group">
                                                        <div data-repeater-list="digital_asset">
                                                            <div data-repeater-item>
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Platform:</label>
                                                                        <select  class="form-select" name="platform">
                                                                            <option value="website">{{ __('Website') }}</option>
                                                                            <option value="mobile_app">{{ __('Mobile App') }}</option>
                                                                            <option value="facebook">{{ __('Facebook') }}</option>
                                                                            <option value="instagram">{{ __('Instagram') }}</option>
                                                                            <option value="twitter">{{ __('Twitter') }}</option>
                                                                            <option value="snapchat">{{ __('Snapchat') }}</option>
                                                                            <option value="tiktok">{{ __('Tiktok') }}</option>
                                                                            <option value="youtube">{{ __('Youtube') }}</option>
                                                                            <option value="pinterest">{{ __('Pinterest') }}</option>
                                                                            <option value="other">{{ __('Other') }}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Link:</label>
                                                                        <input type="link" name="link" class="form-control mb-2 mb-md-0" placeholder="https://www.example.com" />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                            <i class="la la-trash-o"></i>Delete
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->

                                                    <!--begin::Form group-->
                                                    <div class="form-group mt-5">
                                                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                            <i class="la la-plus"></i>Add
                                                        </a>
                                                    </div>
                                                    <!--end::Form group-->
                                                </div>
                                                <!--end::Repeater-->
                                            </div>
                                            <!--end::Card header-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Influencers Inputs -->
                            <div class="influencer">
                                <div class="col-12">
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Socia Media Accounts</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Repeater-->
                                            <div id="kt_docs_repeater_basic_1" class="mb-5 mt-5">
                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="social_media">
                                                        <div data-repeater-item>
                                                            <div class="form-group row mb-5">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Platform:</label>
                                                                    <select  class="form-select" name="platform">
                                                                        <option value="facebook">{{ __('Facebook') }}</option>
                                                                        <option value="instagram">{{ __('Instagram') }}</option>
                                                                        <option value="twitter">{{ __('Twitter') }}</option>
                                                                        <option value="snapchat">{{ __('Snapchat') }}</option>
                                                                        <option value="tiktok">{{ __('Tiktok') }}</option>
                                                                        <option value="youtube">{{ __('Youtube') }}</option>
                                                                        <option value="other">{{ __('Other') }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Number Of Followers:</label>
                                                                    <select  class="form-select" name="followers">
                                                                        <option selected="selected" value="lethThan10k">< 10K</option>
                                                                        <option value="10K : 50K">10K : 50K</option>
                                                                        <option value="50K : 100K">50K : 100K</option>
                                                                        <option value="100K : 500K">100K : 500K</option>
                                                                        <option value="500K : 1M">500K : 1M</option>
                                                                        <option value="> 1M">> 1M</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="form-label">Link:</label>
                                                                    <input type="link" name="link" class="form-control mb-2 mb-md-0" placeholder="https://www.example.com" />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                        <i class="la la-trash-o"></i>Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Form group-->

                                                <!--begin::Form group-->
                                                <div class="form-group mt-5">
                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                        <i class="la la-plus"></i>Add
                                                    </a>
                                                </div>
                                                <!--end::Form group-->
                                            </div>
                                            <!--end::Repeater-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                </div>
                            </div>
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Bank Account Info</span>
                            </div>
                            <div class="row">
                     
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::name-->
                                        <input type="text" placeholder="Account Title" name="account_title" class="form-control bg-transparent" />
                                        <!--end::name-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::name-->
                                        <input type="text" placeholder="Bank Name" name="bank_name" class="form-control bg-transparent" />
                                        <!--end::name-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::name-->
                                        <input type="text" placeholder="Bank Branch Code" name="bank_branch_code" class="form-control bg-transparent" />
                                        <!--end::name-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::name-->
                                        <input type="text" placeholder="Swift Code" name="swift_code" class="form-control bg-transparent" />
                                        <!--end::name-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <!--begin::name-->
                                        <input type="text" placeholder="IBAN" name="iban" class="form-control bg-transparent" />
                                        <!--end::name-->
                                    </div>
                                    <!--begin::Input group-->
                                </div>
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="mb-5">
                                        <select name="currency_id" aria-label="Select Currency" data-control="select2"
                                            data-placeholder="Select Currency" class="form-select">
                                            <option value="">Select Currency</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->sign }})</option>
                                            @endFOreach
                                        </select>
                                    </div>
                                    <!--begin::Input group=-->
                                </div>

                            </div>

                            <!--begin::Accept-->
                            {{-- <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
                                        <a href="#" class="ms-1 link-primary">Terms</a></span>
                                </label>
                            </div> --}}
                            <!--end::Accept-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign up</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                                <a href="{{ route('admin.login.form') }}"
                                    class="link-primary fw-semibold">Sign in</a>
                            </div>
                            <!--end::Sign up-->
                        </form>
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

@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.affiliate').fadeOut('fast');
            $('.influencer').fadeOut('fast');

            // Get acount managers based on team 
            $("#team").change(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.get({
                    url: '{{ route('admin.get.account.managers.based.on.team') }}',
                    data: {
                        team: $(this).val(),
                    },
                    beforeSend: function() {
                        $('#loading').show()
                    },
                    success: function(data) {
                        $('#accountManagers').html(data)
                    },
                    complete: function() {
                        $('#loading').hide()
                    }
                });
                
                if($(this).val() == 'influencer' || $(this).val() == 'prepaid'){
                    $('.influencer').fadeIn('slow');
                    $('.affiliate').fadeOut('slow');
                }else if($(this).val() == 'affiliate'){
                    $('.influencer').fadeOut('slow');
                    $('.affiliate').fadeIn('slow');  
                }else{
                    $('.affiliate').fadeOut('slow');
                    $('.influencer').fadeOut('slow');
                }

            });
            // get countries based on country
            $("#country").change(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.get({
                    url: '{{ route('admin.ajax.cities') }}',
                    data: {
                        countryId: $(this).val(),
                    },
                    beforeSend: function() {
                        $('#loading').show()
                    },
                    success: function(data) {
                        $('#cities').html(data)
                    },
                    complete: function() {
                        $('#loading').hide()
                    }
                });


            });
        });
    </script>
    <script>
        var route = "{{ route('admin.register') }}";
    </script>
		<script src="{{ asset('new_dashboard') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
        <script>
            $('#kt_docs_repeater_basic').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'foo'
                },
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
            $('#kt_docs_repeater_basic_1').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'foo'
                },
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        </script>
@endpush
