@extends('new_admin.layouts.app')
@section('title', 'Payments')
@section('subtitle', 'Create')

@push('styles')

@endpush
@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Add New Payment</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Payment</li>
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
        action="{{ route('admin.payments.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="row">

                                    <div class="col-md-12">
                                        @include('new_admin.components.publishers_filter')
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Publisher</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="publishers_filter"  name="publisher_id" data-control="select2" class="form-select publishers_filter">
                                                <option selected value="">{{ __('No one') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('publisher_id'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('publisher_id') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Amount paid</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="amount_paid" class="form-control mb-2"  value="{{ old('amount_paid') }}" />
                                            @if ($errors->has('amount_paid'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('amount_paid') }}</div>
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
                                            <label class="form-label">Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select  name="type" data-control="select2" class="form-select">
                                                <option value="">No One</option>
                                                <option {{ old('type')  == 'validation' ? 'selected' : ''}} value="validation">{{ __('Validations') }}</option>
                                                <option {{ old('type')  == 'update' ? 'selected' : ''}} value="update">{{ __('Updates') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('type'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('type') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">From Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="date" name="from" class="form-control mb-2" value="{{ old('from') }}" />
                                            @if ($errors->has('from'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('from') }}</div>
                                                </div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">To Date</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="date" name="to" class="form-control mb-2" value="{{ old('to') }}" />
                                            @if ($errors->has('to'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('to') }}</div>
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
                                            <label class="form-label">Receipt Image</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="slip" class="form-control mb-2" value="{{ old('slip') }}" />
                                            @if ($errors->has('slip'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('slip') }}</div>
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
                                            <label class="form-label">Note</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control mb-2" name="note" cols="30" rows="10">{{ old('note') }}</textarea>
                                            @if ($errors->has('note'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('note') }}</div>
                                                </div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
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
                <a href="{{ route('admin.payments.index') }}" id="kt_ecommerce_add_product_cancel"
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

@endpush
