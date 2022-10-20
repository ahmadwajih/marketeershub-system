@extends('new_admin.layouts.app')
@push('styles')
    <style>
        #new_old_payout,
        #slaps_payout,
        #new_old_revenue,
        #slaps_revenue,
        #percentage_discount{
            display: none;
        }
    </style>
@endpush
@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Add New Offer</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Offer</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Add New</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <!--begin::Form-->
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
        action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
    
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General Information</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="row">

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Offer Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name_en" class="form-control mb-2"
                                                placeholder="Offer name" value="{{ old('name_en') }}" />
                                            @if ($errors->has('name_en'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('name_en') }}</div>
                                                </div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Offer Thumbnail</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="thumbnail" class="form-control mb-2" />
                                            @if ($errors->has('thumbnail'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('thumbnail') }}</div>
                                                </div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    {{-- <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Partner</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="partener" data-control="select2" class="form-select"
                                                id="select_partener">
                                                <option {{ old('partener') == 'none' ? 'selected' : '' }} value="none"">
                                                    {{ __('No one') }}</option>
                                                <option {{ old('partener') == 'salla' ? 'selected' : '' }} value="salla">
                                                    {{ __('Salla') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('partener'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('partener') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div> --}}

                                    <div class="col-md-12" id="sallaUserEmail"
                                        @if (old('partener') != 'salla') style="display: none" @endif>
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Vendor email in salla</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="salla_user_email" class="form-control mb-2"
                                                placeholder="Salla user email" value="{{ old('salla_user_email') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('salla_user_email'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('salla_user_email') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label required">Advertiser</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="advertiser_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($advertisers as $advertiser)
                                                    <option {{ old('advertiser_id') == $advertiser->id ? 'selected' : '' }}
                                                        value="{{ $advertiser->id }}">{{ $advertiser->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('advertiser_id'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('advertiser_id') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label required">Categories</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="categories[]" multiple data-control="select2"
                                                class="form-select">
                                                @foreach ($categories as $category)
                                                    <option
                                                        {{ old('categories') ? (in_array($category->id, old('categories')) ? 'selected' : '') : '' }}
                                                        value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('categories'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('categories') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Description</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="description_en" class="form-control mb-2" cols="30" rows="10">{{ old('description_en') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('description_en'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('description_en') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Offer URL</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="url" name="offer_url" class="form-control mb-2"
                                                placeholder="Offer URL" value="{{ old('offer_url') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('offer_url'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('offer_url') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    {{-- <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Geo's</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="countries[]" multiple data-control="select2"
                                                class="form-select">
                                                @foreach ($countries as $country)
                                                    <option
                                                        {{ old('countries') ? (in_array($country->id, old('countries')) ? 'selected' : '') : '' }}
                                                        value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('countries'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('countries') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div> --}}

                                    {{-- <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="partener" data-control="select2" class="form-select"
                                                id="type">
                                                <option {{ old('type') == 'coupon_tracking' ? 'selected' : '' }}
                                                    value="coupon_tracking">{{ __('Coupon Tracking') }}</option>
                                                <option {{ old('type') == 'link_tracking' ? 'selected' : '' }}
                                                    value="link_tracking">{{ __('Link Tracking') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('partener'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('partener') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div> --}}

                                    <div class="col-md-12" id="uploadCoupons"
                                        @if (old('type') != null && old('type') != 'coupon_tracking') style="display: none" @endif>
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Coupon Codes</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="email" class="form-control mb-2"
                                                placeholder="Coupons" value="{{ old('coupons') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('coupons'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('coupons') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Offer Discount Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="discount_type" data-control="select2" class="form-select" id="discount_type">
                                                <option {{ old('discount_type') == 'flat' ? 'selected' : '' }} value="flat">{{ __('Flat') }}</option>
                                                <option {{ old('discount_type') == 'percentage' ? 'selected' : '' }} value="percentage">{{ __('Percentage') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('discount_type'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('discount_type') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label" style="margin-bottom: -20px; display: block;">Offer Discount</label>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="input-group mb-5">
                                            <input type="number" class="form-control" name="discount" placeholder="Discount Amount" value="{{ old('discount') }}" aria-label="Recipient's username" aria-describedby="basic-addon2"/>
                                            <span class="input-group-text" id="basic-addon2">
                                                <div id="currency_sellect">
                                                    <select name="currency_id" class="form-select" data-control="select2">
                                                        <option selected disabled value="">{{ __('Currency') }}</option>
                                                        @foreach ($currencies as $currency)
                                                            <option {{ old('currency_id') == $currency->id ? 'selected' : '' }}
                                                                value="{{ $currency->id }}">{{ $currency->code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="percentage_discount">%</div>
                                            </span>
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Expire Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="date" name="expire_date" class="form-control mb-2"
                                                placeholder="Email" value="{{ old('expire_date') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('expire_date'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('expire_date') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Status</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="status" data-control="select2" class="form-select">
                                                <option {{ old('status') == 'active' ? 'selected' : '' }} value="active">
                                                    {{ __('Active') }}</option>
                                                <option {{ old('status') == 'pending' ? 'selected' : '' }}
                                                    value="pending">
                                                    {{ __('Pending') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('status'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('status') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Offer Restrictions</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="terms_and_conditions_en" class="form-control mb-2">{{ old('terms_and_conditions_en') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('terms_and_conditions_en'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">
                                                        {{ $errors->first('terms_and_conditions_en') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Note</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="note" class="form-control mb-2" id="">{{ old('note') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('note'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('note') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Revenue Information</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="col-md-11">
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">CPS Type</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="revenue_cps_type" data-control="select2" class="form-select"
                                            id="cps_type_revenue">
                                            <option {{ old('revenue_cps_type') == 'static' ? 'selected' : '' }} value="static"> {{ __('Fixed Model') }}</option>
                                            <option {{ old('revenue_cps_type') == 'new_old' ? 'selected' : '' }} value="new_old"> {{ __('New-old Model') }}</option>
                                            <option {{ old('revenue_cps_type') == 'slaps' ? 'selected' : '' }} value="slaps"> {{ __('Slabs Model') }}</option>
                                        </select>
                                        <!--end::Input-->
                                        @if ($errors->has('revenue_cps_type'))
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div data-field="text_input">{{ $errors->first('revenue_cps_type') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <!--end::Input group-->
                                </div>

                                @include('new_admin.offers.create.revenue.cps_static_offer')
                                @include('new_admin.offers.create.revenue.cps_new_old_offer')
                                @include('new_admin.offers.create.revenue.cps_slaps_offer')
                            </div>
                        </div>

                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Payout Information</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="col-md-11">
                                    <!--begin::Input group-->
                                    <div class="mb-10 fv-row">
                                        <!--begin::Label-->
                                        <label class="form-label">CPS Type</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="payout_cps_type" data-control="select2" class="form-select"
                                            id="cps_type_payout">
                                            <option {{ old('revenue_cps_type') == 'static' ? 'selected' : '' }} value="static"> {{ __('Fixed Model') }}</option>
                                            <option {{ old('revenue_cps_type') == 'new_old' ? 'selected' : '' }} value="new_old"> {{ __('New-old Model') }}</option>
                                            <option {{ old('revenue_cps_type') == 'slaps' ? 'selected' : '' }} value="slaps"> {{ __('Slabs Model') }}</option>
                                        </select>
                                        <!--end::Input-->
                                        @if ($errors->has('payout_cps_type'))
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div data-field="text_input">{{ $errors->first('payout_cps_type') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <!--end::Input group-->
                                </div>

                                @include('new_admin.offers.create.payout.cps_static_offer')
                                @include('new_admin.offers.create.payout.cps_new_old_offer')
                                @include('new_admin.offers.create.payout.cps_slaps_offer')
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="reset" class="btn btn-light me-5">Reset</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->
@endsection
@push('scripts')
    {{-- <script src="{{ asset('new_dashboard') }}/js/custom/apps/ecommerce/catalog/save-product.js"></script> --}}

    {{-- <script src="{{ asset('new_dashboard') }}/js/datatables\users\table.js"></script> --}}

    <script>
        $(document).ready(function() {
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

            $("#select_partener").change(function() {
                if ($(this).val() == 'salla') {
                    $('#sallaUserEmail').fadeIn();
                } else {
                    $('#sallaUserEmail').fadeOut();
                }
            });


            $("#discount_type").change(function() {
                if ($(this).val() == 'percentage') {
                    $('#currency_sellect').fadeOut('fast');
                    $('#percentage_discount').fadeIn('slow');
                } else {
                    $('#percentage_discount').fadeOut('fast');
                    $('#currency_sellect').fadeIn('slow');
                }
            });

            $("#type").change(function() {
                if ($(this).val() == 'link_tracking') {
                    $('#uploadCoupons').fadeOut();
                } else {
                    $('#uploadCoupons').fadeIn();
                }
            });

            $("#cps_type_revenue").change(function() {
                if ($(this).val() == 'new_old') {
                    $('#static_revenue').fadeOut();
                    $('#slaps_revenue').fadeOut();
                    $('#new_old_revenue').fadeIn();
                }
                if ($(this).val() == 'static') {
                    $('#static_revenue').fadeIn();
                    $('#slaps_revenue').fadeOut();
                    $('#new_old_revenue').fadeOut();
                }
                if ($(this).val() == 'slaps') {
                    $('#static_revenue').fadeOut();
                    $('#slaps_revenue').fadeIn();
                    $('#new_old_revenue').fadeOut();
                }
            });

            $("#cps_type_payout").change(function() {
                if ($(this).val() == 'new_old') {
                    $('#static_payout').fadeOut();
                    $('#slaps_payout').fadeOut();
                    $('#new_old_payout').fadeIn();
                }
                if ($(this).val() == 'static') {
                    $('#static_payout').fadeIn();
                    $('#slaps_payout').fadeOut();
                    $('#new_old_payout').fadeOut();
                }
                if ($(this).val() == 'slaps') {
                    $('#static_payout').fadeOut();
                    $('#slaps_payout').fadeIn();
                    $('#new_old_payout').fadeOut();
                }
            });

        })
    </script>
    <script src="{{ asset('new_dashboard') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/offers/formrepeater-caller.js"></script>
    {{-- <script src="{{ asset('new_dashboard') }}/js/offers/revenu-static-switchers.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/offers/payout-static-switchers.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/offers/revenu-old-new-switchers.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/offers/payout-old-new-switchers.js"></script> --}}



    <script>
        $('#kt_docs_repeater_advanced_revenue').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select2"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                // Init select2
                $('[data-kt-repeater="select2"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });
    </script>
    <script>
        $('#kt_docs_repeater_advanced_payout').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select22"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                // Init select2
                $('[data-kt-repeater="select22"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });
    </script>
    <script>
        $('#kt_docs_repeater_advanced_new_old_revenue').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select-revenue"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                // Init select2
                $('[data-kt-repeater="select-revenue"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });
    </script>
    <script>
        $('#kt_docs_repeater_advanced_new_old_payout').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select-payout"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                // Init select2
                $('[data-kt-repeater="select-payout"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });
    </script>

    <script>

        function switcherFunction(switcher) {

            var switcherParent = switcher.parentNode.parentNode.parentNode;
            if (switcher.value == 'on') {

                switcher.value = 'off';
                if (switcher.getAttribute('data-input') == 'text') {
                    var selectedInput = switcherParent.querySelectorAll("input[type='text']");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = true;
                    }

                }
                if (switcher.getAttribute('data-input') == 'select') {
                    var selectedInput = switcherParent.querySelectorAll("select");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = true;
                    }

                }
            } else {
                switcher.value = 'on';
                if (switcher.getAttribute('data-input') == 'text') {
                    var selectedInput = switcherParent.querySelectorAll("input[type='text']");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = false;
                    }
                }
                if (switcher.getAttribute('data-input') == 'select') {
                    var selectedInput = switcherParent.querySelectorAll("select");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = false;
                    }
                }
            }
        }
    </script>
@endpush
