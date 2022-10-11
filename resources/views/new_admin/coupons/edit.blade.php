@extends('new_admin.layouts.app')
@push('styles')
    <style>
        #custom_payout {
            display: none;
        }
    </style>
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
                                                        {{ old('user_id') == $user->id ? 'selected' : ($coupon->user_id ? 'selected' : '') }}
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
                                            <input class="form-check-input switcher" type="checkbox" data-input="select"
                                                onchange="switcherFunction('custom_payout', this)" value="off" />
                                            <label class="form-check-label">
                                                Custom Payout
                                            </label>
                                        </div>
                                    </div>


                                    <div class=" mt-7 " id="custom_payout">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">Custom Revenue Type</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="payout_type" data-control="select2" class="form-select">
                                                        <option {{ old('payout_type') == 'flat' ? 'selected' : '' }}
                                                            value="flat">{{ __('Flat') }}</option>
                                                        <option {{ old('payout_type') == 'percentage' ? 'selected' : '' }}
                                                            value="percentage">{{ __('Percentage') }}</option>
                                                    </select>
                                                    <!--end::Input-->
                                                    @if ($errors->has('payout_type'))
                                                        <div class="fv-plugins-message-container invalid-feedback">
                                                            <div data-field="text_input">
                                                                {{ $errors->first('payout_type') }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">Custom Payout</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="number" name="payout" class="form-control mb-2"
                                                        placeholder="payout" value="{{ old('payout') }}" />
                                                    <!--end::Input-->
                                                    @if ($errors->has('payout'))
                                                        <div class="fv-plugins-message-container invalid-feedback">
                                                            <div data-field="text_input">{{ $errors->first('payout') }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                        </div>
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
                <a href="../../demo14/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel"
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
        function switcherFunction(switcherId, switcher) {
            if (switcher.value == 'on') {

                switcher.value = 'off';
                $('#' + switcherId).fadeOut('slow');
            } else {
                switcher.value = 'on';
                $('#' + switcherId).fadeIn('slow');
            }
        }
    </script>
@endpush
