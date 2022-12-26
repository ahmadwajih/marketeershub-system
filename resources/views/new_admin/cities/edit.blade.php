@extends('new_admin.layouts.app')
@section('title', 'Cities')
@section('subtitle', 'Edit')
@section('content')

    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Edit City</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Cities</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Edit</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <!--begin::Form-->
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{route('admin.cities.update', $city->id)}}" method="POST" enctype="multipart/form-data">
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
                                            <label class="required form-label">Name EN</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name_en" class="form-control mb-2" placeholder="Name EN" value="{{ old('name_en') ?? $city->name_en }}" />
                                            @if ($errors->has('name_en'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('name_en') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Name AR</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name_ar" class="form-control mb-2" placeholder="Name AR" value="{{ old('name_ar') ?? $city->name_ar}}" />
                                            @if ($errors->has('name_ar'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('name_ar') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                        
                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="code" class="form-control mb-2" placeholder="Code" value="{{ old('code') ?? $city->code }}" />
                                            @if ($errors->has('code'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('code') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Country</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="country_id" data-control="select2" class="form-select form-select-sm">
                                                @foreach ($countries as $country)
                                                    <option {{old('country_id') == $country->id?'selected' : ($city->country_id==$country->id?'selected':'')}} value="{{$country->id}}">{{$country->name_en}}</option>                                                
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('country_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('country_id') }}</div></div>
                                            @endif
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
                <a href="{{ route('admin.cities.index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
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
