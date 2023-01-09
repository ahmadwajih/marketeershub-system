@extends('new_admin.layouts.app')
@section('title', 'Coupons')
@section('subtitle', 'Edit')
@push('styles')

    <style>
       
        #static_payout,
        #new_old_payout,
        #slaps_payout{
            display: none;
        }
        #{{ $coupon->payout_cps_type }}_payout{
            display: block;
        }

    </style>


    @if(count($coupon->cps) == 0)
        <style>
            #custom_payout {
                    display: none;
                }
        </style>
    @endif

@endpush

@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Edit Coupon</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Coupon</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Edit Coupon</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <!--begin::Form-->
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row"
        action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="row">

                                    <div class="col-md-4">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Coupon Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="coupon" class="form-control mb-2"
                                                placeholder="Coupon Code" value="{{ old('coupon') ?? $coupon->coupon }}" />
                                            @if ($errors->has('coupon'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('coupon') }}</div>
                                                </div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-4">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Offer</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="offer_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($offers as $offer)
                                                    <option
                                                        {{ old('offer_id') == $offer->id ? 'selected' : ($coupon->offer_id == $offer->id ? 'selected' : '') }}
                                                        value="{{ $offer->id }}">{{ $offer->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('offer_id'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('offer_id') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                
                                    <div class="col-md-4">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Publisher</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="user_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($users as $user)
                                                    <option
                                                        {{ old('user_id') == $user->id ? 'selected' : ($coupon->user_id  == $user->id ? 'selected' : '') }}
                                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('user_id'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('user_id') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-check form-switch form-check-custom form-check-solid mt-13">
                                            <input class="form-check-input switcher" type="checkbox" data-input="select" name="have_custom_payout"
                                                onchange="mainSwitcherFunction('custom_payout', this)" value="{{ count($coupon->cps) > 0 ? 'on' : 'off' }}" {{ count($coupon->cps) > 0 ? 'checked' : '' }}/>
                                            <label class="form-check-label">
                                                Custom Payout
                                            </label>
                                        </div>
                                    </div>


                                    <div class=" mt-7 " id="custom_payout">

                                        <div class="col-md-11">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">CPS Type</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="payout_cps_type" data-control="select2" class="form-select"
                                                    id="cps_type_payout">
                                                    <option {{ old('payout_cps_type') == 'static' ? 'selected' : ($coupon->payout_cps_type == 'static' ? 'selected' : '') }} value="static"> {{ __('Fixed Model') }}</option>
                                                    <option {{ old('payout_cps_type') == 'new_old' ? 'selected' : ($coupon->payout_cps_type == 'new_old' ? 'selected' : '') }} value="new_old"> {{ __('New-old Model') }}</option>
                                                    <option {{ old('payout_cps_type') == 'slaps' ? 'selected' : ($coupon->payout_cps_type == 'slaps' ? 'selected' : '') }} value="slaps"> {{ __('Slabs Model') }}</option>
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

                                        @include('new_admin.coupons.edit.payout.cps_static_offer')
                                        @include('new_admin.coupons.edit.payout.cps_new_old_offer')
                                        @include('new_admin.coupons.edit.payout.cps_slaps_offer')
                                    </div>

                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{ route('admin.coupons.index') }}" id="kt_ecommerce_add_product_cancel"
                    class="btn btn-light me-5">Cancel</a>
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
    <script>
        function mainSwitcherFunction(switcherId, switcher) {
            if (switcher.value == 'on') {

                switcher.value = 'off';
                $('#' + switcherId).fadeOut('slow');
            } else {
                switcher.value = 'on';
                $('#' + switcherId).fadeIn('slow');
            }
        }
    </script>
    <script src="{{ asset('new_dashboard') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>

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

        $('#kt_docs_repeater_slaps_payout').repeater({
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
    <script>
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
    </script>

@endpush
