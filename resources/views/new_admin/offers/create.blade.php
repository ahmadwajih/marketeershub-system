@extends('new_admin.layouts.app')
@push('styles')
<style>
    #oldNew, #slaps{
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
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <!--begin::Image input placeholder-->
                                <style>.image-input-placeholder { background-image: url('{{ asset("new_dashboard") }}/media/svg/files/blank-image.svg'); } [data-theme="dark"] .image-input-placeholder { background-image: url('{{ asset("new_dashboard") }}/media/svg/files/blank-image-dark.svg'); }</style>
                                <!--end::Image input placeholder-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true" style="&lt;br /&gt; &lt;b&gt;Warning&lt;/b&gt;: Undefined variable $imageBg in &lt;b&gt;C:\wamp64\www\keenthemes\core\html\dist\view\pages\apps\ecommerce\catalog\edit-product\_thumbnail.php&lt;/b&gt; on line &lt;b&gt;30&lt;/b&gt;&lt;br /&gt;">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="thumbnail" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                                <!--end::Description-->
                                @if ($errors->has('thumbnail'))
                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('thumbnail') }}</div></div>
                                @endif                            
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
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
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Offer Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name_en" class="form-control mb-2" placeholder="Offer name" value="{{ old('name_en') }}" />
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
                                            <label class="form-label">Partner</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="partener" data-control="select2" class="form-select" id="select_partener">
                                                <option {{ old('partener')=='none'?'selected':''  }} value="none"" >{{ __('No one') }}</option>
                                                <option {{ old('partener')=='salla'?'selected':''  }} value="salla">{{ __('Salla') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('partener'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('partener') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12" id="sallaUserEmail" @if(old('partener')!='salla') style="display: none" @endif>
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Vendor email in salla</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="salla_user_email" class="form-control mb-2" placeholder="Salla user email" value="{{ old('salla_user_email') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('salla_user_email'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('salla_user_email') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Advertiser</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="advertiser_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($advertisers as $advertiser)
                                                    <option {{ old('advertiser_id') == $advertiser->id ? "selected" : '' }} value="{{ $advertiser->id }}">{{  $advertiser->company_name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('advertiser_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('advertiser_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div> 

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Categories</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="categories[]" multiple data-control="select2" class="form-select">
                                                @foreach ($categories as $category)
                                                    <option {{ old('categories')?(in_array($category->id,old('categories'))?'selected':''):''  }}  value="{{ $category->id }}">{{  $category->title }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('categories'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('categories') }}</div></div>
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
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('description_en') }}</div></div>
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
                                            <input type="url" name="offer_url" class="form-control mb-2" placeholder="Offer URL" value="{{ old('offer_url') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('offer_url'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('offer_url') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Geo's</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="countries[]" multiple data-control="select2" class="form-select">
                                                @foreach ($countries as $country)
                                                    <option {{ old('countries')?(in_array($country->id,old('countries'))?'selected':''):''  }}  value="{{ $country->id }}">{{  $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('countries'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('countries') }}</div></div>
                                            @endif
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
                                            <select name="partener" data-control="select2" class="form-select" id="type">
                                                <option  {{ old('type')=='coupon_tracking'?'selected':''  }} value="coupon_tracking">{{ __('Coupon Tracking') }}</option>
                                                <option  {{ old('type')=='link_tracking'?'selected':''  }} value="link_tracking">{{ __('Link Tracking') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('partener'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('partener') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12" id="uploadCoupons" @if(old('type') != null && old('type')!='coupon_tracking') style="display: none" @endif>
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Coupon Codes</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="email" class="form-control mb-2" placeholder="Coupons" value="{{ old('coupons') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('coupons'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('coupons') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">CPS Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="cps_type" data-control="select2" class="form-select" id="cps_type">
                                                <option {{ old('cps_type')=="static"?"selected":"" }} value="static">{{ __('Static') }}</option>
                                                <option {{ old('cps_type')=="new_old"?"selected":"" }} value="new_old">{{ __('New old') }}</option>
                                                <option {{ old('cps_type')=="slaps"?"selected":"" }} value="slaps">{{ __('Slaps') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('cps_type'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('cps_type') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="row" id="static">
                                        <div class="col-md-6">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">Revenue Type</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="revenue_type" data-control="select2" class="form-select">
                                                    <option {{ old('revenue_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                                                    <option {{ old('revenue_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                                                </select>
                                                <!--end::Input-->
                                                @if ($errors->has('revenue_type'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('revenue_type') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-md-6">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Revenue</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" name="revenue" class="form-control mb-2" placeholder="revenue" value="{{ old('revenue') }}" />
                                                <!--end::Input-->
                                                @if ($errors->has('revenue'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('revenue') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-md-6">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">Payout Type</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="payout_type" data-control="select2" class="form-select">
                                                    <option {{ old('payout_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                                                    <option {{ old('payout_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                                                </select>
                                                <!--end::Input-->
                                                @if ($errors->has('payout_type'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('payout_type') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        <div class="col-md-6">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Payout</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" name="payout" class="form-control mb-2" placeholder="Payout" value="{{ old('payout') }}" />
                                                <!--end::Input-->
                                                @if ($errors->has('payout'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('payout') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>

                                    <div id="oldNew">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">New Revenue Type</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="new_revenue_type" data-control="select2" class="form-select">
                                                        <option {{ old('new_revenue_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                                                        <option {{ old('new_revenue_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                                                    </select>
                                                    <!--end::Input-->
                                                    @if ($errors->has('new_revenue_type'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_revenue_type') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">New Revenue</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="number" name="new_revenue" class="form-control mb-2" placeholder="New Revenue" value="{{ old('new_revenue') }}" />
                                                    <!--end::Input-->
                                                    @if ($errors->has('new_revenue'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_revenue') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">New Payout Type</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="new_payout_type" data-control="select2" class="form-select">
                                                        <option {{ old('new_payout_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                                                        <option {{ old('new_payout_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                                                    </select>
                                                    <!--end::Input-->
                                                    @if ($errors->has('new_payout_type'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_payout_type') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">New Payout</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="number" name="new_payout" class="form-control mb-2" placeholder="New Payout" value="{{ old('new_payout') }}" />
                                                    <!--end::Input-->
                                                    @if ($errors->has('new_payout'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_payout') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            {{--  Old  --}}

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">Old Revenue Type</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="old_revenue_type" data-control="select2" class="form-select">
                                                        <option {{ old('old_revenue_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                                                        <option {{ old('old_revenue_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                                                    </select>
                                                    <!--end::Input-->
                                                    @if ($errors->has('old_revenue_type'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_revenue_type') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">Old Revenue</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="number" name="old_revenue" class="form-control mb-2" placeholder="Old Revenue" value="{{ old('old_revenue') }}" />
                                                    <!--end::Input-->
                                                    @if ($errors->has('old_revenue'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_revenue') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">Old Payout Type</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="old_payout_type" data-control="select2" class="form-select">
                                                        <option {{ old('old_payout_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                                                        <option {{ old('old_payout_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                                                    </select>
                                                    <!--end::Input-->
                                                    @if ($errors->has('old_payout_type'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_payout_type') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>

                                            <div class="col-md-6">
                                                <!--begin::Input group-->
                                                <div class="mb-10 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">Old Payout</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="number" name="old_payout" class="form-control mb-2" placeholder="Old Payout" value="{{ old('old_payout') }}" />
                                                    <!--end::Input-->
                                                    @if ($errors->has('old_payout'))
                                                        <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_payout') }}</div></div>
                                                    @endif
                                                </div>
                                                <!--end::Input group-->
                                            </div>


                                        </div>
                                    </div>

                                    <div id="slaps">
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
                                                        <div data-repeater-list="slaps">
                                                            <div data-repeater-item>
                                                                <div class="form-group row mb-5">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Orders Type:</label>
                                                                        <select  data-control="select2" class="form-select" name="slap_type">
                                                                            <option value="number_of_orders">{{{ __('Number Of Orders') }}}</option>
                                                                            <option value="ammount_of_orders">{{{ __('Ammount Of Orders') }}}</option>
                                                                        </select>
                                                                    </div>
                                                                    
    
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">From:</label>
                                                                        <input type="number" name="from" class="form-control mb-2 mb-md-0"  />
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label class="form-label">To:</label>
                                                                        <input type="number" name="to" class="form-control mb-2 mb-md-0"  />
                                                                    </div>

                                                                    <div class="col-md-4 mt-5">
                                                                        <label class="form-label">Revenue:</label>
                                                                        <input type="number" name="revenue" class="form-control mb-2 mb-md-0"  />
                                                                    </div>

                                                                    <div class="col-md-4 mt-5">
                                                                        <label class="form-label">Payout:</label>
                                                                        <input type="number" name="payout" class="form-control mb-2 mb-md-0"  />
                                                                    </div>

                                                                    <div class="col-md-2 mt-5">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-lg btn-light-danger mt-8 mt-md-8">
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

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Offer Discount Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="discount_type" data-control="select2" class="form-select">
                                                <option value="flat">{{ __('Flat') }}</option>
                                                <option value="percentage">{{ __('Percentage') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('discount_type'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('discount_type') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Offer Discount</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="discount" class="form-control mb-2" placeholder="Email" value="{{ old('discount') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('discount'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('discount') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Currency</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="currency_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($currencies as $currency)
                                                    <option {{ old('currency_id')==$currency->id?'selected':''  }} value="{{ $currency->id }}">{{  $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('currency_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('currency_id') }}</div></div>
                                            @endif
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
                                            <input type="date" name="expire_date" class="form-control mb-2" placeholder="Email" value="{{ old('expire_date') }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('expire_date'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('expire_date') }}</div></div>
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
                                                <option {{ old('status')=="active"?"selected":"" }} value="active">{{ __('Active') }}</option>
                                                <option {{ old('status')=="pending"?"selected":"" }} value="pending">{{ __('Pending') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('status'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('status') }}</div></div>
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
                                           <textarea  name="terms_and_conditions_en" class="form-control mb-2"  >{{ old('terms_and_conditions_en') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('terms_and_conditions_en'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('terms_and_conditions_en') }}</div></div>
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
                                           <textarea  name="note" class="form-control mb-2"  id="" >{{ old('note') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('note'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('note') }}</div></div>
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
    $(document).ready(function(){
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

        $("#select_partener").change(function () {
            if ($(this).val() == 'salla') {
                $('#sallaUserEmail').fadeIn();
            }else{
                $('#sallaUserEmail').fadeOut();
            }
        });

        $("#type").change(function () {
            if ($(this).val() == 'link_tracking') {
                $('#uploadCoupons').fadeOut();
            }else{
                $('#uploadCoupons').fadeIn();
            }
        });

        $("#cps_type").change(function () {
            if ($(this).val() == 'new_old') {
                $('#static').fadeOut();
                $('#slaps').fadeOut();
                $('#oldNew').fadeIn();
            }
            if ($(this).val() == 'static') {
                $('#static').fadeIn();
                $('#slaps').fadeOut();
                $('#oldNew').fadeOut();
            }
            if ($(this).val() == 'slaps') {
                $('#static').fadeOut();
                $('#slaps').fadeIn();
                $('#oldNew').fadeOut();
            }
        });

    })
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
