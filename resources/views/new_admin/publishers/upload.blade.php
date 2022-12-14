@extends('new_admin.layouts.app')
@section('title', 'Publishers')
@section('subtitle', 'Upload')
@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Add New Team Member</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Users</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Team Member</li>
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
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{route('admin.publishers.upload.store')}}" method = "POST" enctype="multipart/form-data">
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
                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">File</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="publishers" class="form-control mb-2" />
                                            @if ($errors->has('publishers'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('name') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>


                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Team</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="team" aria-label="Select a Team" data-control="select2" required data-placeholder="date_period" class="form-select form-select-sm">
                                                <option {{ old('team') == 'influencer' ? "selected" : '' }} value="influencer">{{ __('Influencer') }}</option>
                                                <option {{ old('team') == 'affiliate' ? "selected" : '' }} value="affiliate">{{ __('Affiliate') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('team'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('team') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="d-grid gap-2">
                                            <a href="{{ asset('dashboard/excel-sheets-examples/inflenucers.xlsx') }}" type="submit" class="btn btn-primary btn-block">
                                                <span class="indicator-label">Download Inflenucers File Example</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="d-grid gap-2">
                                            <a href="{{ asset('dashboard/excel-sheets-examples/affiliates.xlsx') }}" type="submit" class="btn btn-primary btn-block">
                                                <span class="indicator-label">Download Affiliates File Example</span>
                                            </a>
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
                <button  class="btn btn-light me-5" type="reset">Cancel</button>
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
