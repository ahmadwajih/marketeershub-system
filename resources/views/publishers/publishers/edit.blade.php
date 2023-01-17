@extends('publishers.layouts.app')
@section('title', 'Publishers')
@section('subtitle', 'Edit')
@section('content')

    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Edit Publisher</h1>
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
                <li class="breadcrumb-item text-gray-600">Publisher</li>
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
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('publisher.publisher.update', $publisher->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
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
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="separator separator-content my-7">
                                        <span class="w-125px fw-semibold fs-7">Basic Info</span>
                                    </div>
                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2" placeholder="Full name" value="{{ old('name') ?? $publisher->name }}" />
                                            @if ($errors->has('name'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('name') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" value="{{ old('email') ?? $publisher->email }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('email'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('email') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" onkeypress="clsNoOnly(event)" name="phone" min="1" class="form-control mb-2" placeholder="Phone" value="{{ old('phone') ?? $publisher->phone }}" required minlength="8" />
                                            <!--end::Input-->
                                            @if ($errors->has('phone'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('phone') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Gender</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="gender" aria-label="Select a Gender" data-control="select2" data-placeholder="Select Gender" class="form-select form-select-sm">
                                                <option {{ old('gender') == 'male' ? "selected" : ($publisher->gender == 'male' ? "selected" : '' ) }} value="male">{{ __('Male') }}</option>
                                                <option {{ old('gender') == 'female' ? "selected" : ($publisher->gender == 'female' ? "selected" : '' ) }} value="female">{{ __('Female') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('gender'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('gender') }}</div></div>
                                            @endif
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
                                            <select id="country" name="country_id" data-control="select2" class="form-select form-select-sm">
                                                @foreach ($countries as $country)
                                                    <option {{ old('country_id') == $country->id ? "selected" : ($publisher->country_id  == $country->id ? "selected" : '') }} value="{{ $country->id }}">{{  $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('country_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('country_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Publisher Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="team" name="team" aria-label="Select a Publisher Type" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm">
                                                <option {{ old('team') == 'affiliate' ? "selected" : ($publisher->team == 'affiliate' ? "selected" : '' )  }} value="affiliate">{{ __('Affiliate') }}</option>
                                                <option {{ old('team') == 'influencer' ? "selected" : ($publisher->team == 'influencer' ? "selected" : '' )  }} value="influencer">{{ __('Influencer') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('team'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('team') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Account Manager</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="parent_id" data-control="select2" class="form-select form-select-sm" id="accountManagers">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($users as $user)
                                                    <option {{ old('parent_id') == $user->id ? "selected" : ($publisher->parent_id == $user->id ? "selected" : '') }} value="{{ $user->id }}">{{  $user->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('parent_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('parent_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="separator separator-content my-14">
                                        <span class="w-125px fw-semibold fs-7">Additional Info</span>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Categories</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="categories" name="categories[]" aria-label="Select Categories" data-control="select2" multiple data-placeholder="Select Categories" class="form-select">
                                                <option value="">Select categories</option>
                                                @foreach ($categories as $category)
                                                    <option {{ old('categories') && in_array($category->id, old('categories')) ? 'selected' : (in_array($category->id, $publisher->categories->pluck('id')->toArray()) ? "selected" : '') }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endFOreach
                                            </select>                                            
                                            @if ($errors->has('categories'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('categories') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>

                                <div class="affiliate">
                                     <div class="row">

                                        <div class="col-md-12">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">Affiliate Networks</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="affiliate_networks" class="form-control mb-2" placeholder="Affiliate Networks " value="{{ old('affiliate_networks') ?? $publisher->affiliate_networks }}" />
                                                <!--end::Input-->
                                                @if ($errors->has('affiliate_networks'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('affiliate_networks') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                        
                                        <div class="col-md-12">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">Years of Experience</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" name="years_of_experience" class="form-control mb-2" placeholder="Years of Experience " value="{{ old('years_of_experience') ?? $publisher->years_of_experience }}" />
                                                <!--end::Input-->
                                                @if ($errors->has('years_of_experience'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('years_of_experience') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
                                        </div>


                                        <div class="col-md-12">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">Traffic Sources</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select caria-label="Select Traffic Sources" data-control="select2" data-placeholder="Select Traffic Sources" class="form-select" name="traffic_sources[]" multiple>
                                                <option {{ old('traffic_sources') !== null && in_array('website', old('traffic_sources')) ? 'selected' : ($publisher->traffic_sources !== null && in_array('google_ad_words', $publisher->traffic_sources) ? 'selected' : '') }} value="google_ad_words">{{ __('Google Ad words.') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('website', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('facebook_ig_ads', $publisher->traffic_sources) ? 'selected' : '') }} value="facebook_ig_ads">{{ __('Facebook & IG Ads.') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('instagram', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('instagram', $publisher->traffic_sources) ? 'selected' : '') }} value="instagram">{{ __('Instagram') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('twitter', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('twitter', $publisher->traffic_sources) ? 'selected' : '') }} value="twitter">{{ __('Twitter') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('snapchat', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('snapchat', $publisher->traffic_sources) ? 'selected' : '') }} value="snapchat">{{ __('Snapchat') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('tiktok', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('tiktok', $publisher->traffic_sources) ? 'selected' : '') }} value="tiktok">{{ __('Tiktok') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('youtube', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('youtube', $publisher->traffic_sources) ? 'selected' : '') }} value="youtube">{{ __('Youtube') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('pinterest', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('pinterest', $publisher->traffic_sources) ? 'selected' : '') }} value="pinterest">{{ __('Pinterest') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('coupon_app', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('coupon_app', $publisher->traffic_sources) ? 'selected' : '') }} value="coupon_app">{{ __('Coupon App') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('coupon_website', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('coupon_website', $publisher->traffic_sources) ? 'selected' : '') }} value="coupon_website">{{ __('Coupon Website') }}</option>
                                                <option {{ old('traffic_sources') !== null && in_array('other', old('traffic_sources')) ? 'selected' : ( $publisher->traffic_sources !== null && in_array('other', $publisher->traffic_sources) ? 'selected' : '') }} value="other">{{ __('Other') }}</option>
                                            </select>                                                
                                            <!--end::Input-->
                                                @if ($errors->has('affiliate_networks'))
                                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('affiliate_networks') }}</div></div>
                                                @endif
                                            </div>
                                            <!--end::Input group-->
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
                                                                @if(old('digital_asset') && count(old('digital_asset')) > 0  && old('team') == 'affiliate')
                                                                    @foreach (old('digital_asset') as $digitalAsset)
                                                                        <div data-repeater-item>
                                                                            <div class="form-group row mb-5">
                                                                                <div class="col-md-4">
                                                                                    <label class="form-label">Platform:</label>
                                                                                    <select  class="form-select" name="platform">
                                                                                        <option {{ $digitalAsset['platform'] == 'website' ? 'selected' : '' }} value="website">{{ __('Website') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'mobile_app' ? 'selected' : '' }} value="mobile_app">{{ __('Mobile App') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'facebook' ? 'selected' : '' }} value="facebook">{{ __('Facebook') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'instagram' ? 'selected' : '' }} value="instagram">{{ __('Instagram') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'twitter' ? 'selected' : '' }} value="twitter">{{ __('Twitter') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'snapchat' ? 'selected' : '' }} value="snapchat">{{ __('Snapchat') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'tiktok' ? 'selected' : '' }} value="tiktok">{{ __('Tiktok') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'youtube' ? 'selected' : '' }} value="youtube">{{ __('Youtube') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'pinterest' ? 'selected' : '' }} value="pinterest">{{ __('Pinterest') }}</option>
                                                                                        <option {{ $digitalAsset['platform'] == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Link:</label>
                                                                                    <input type="link" name="link" class="form-control mb-2 mb-md-0" placeholder="https://www.example.com"  value="{{ $digitalAsset['link'] }}"/>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                        <i class="la la-trash-o"></i>Delete
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @elseif ($publisher->digitalAssets && count($publisher->digitalAssets) > 0 && $publisher->team == 'affiliate')
                                                                    @foreach ($publisher->digitalAssets as $digitalAsset)
                                                                        <div data-repeater-item>
                                                                            <div class="form-group row mb-5">
                                                                                <div class="col-md-4">
                                                                                    <label class="form-label">Platform:</label>
                                                                                    <select  class="form-select" name="platform">
                                                                                        <option {{ $digitalAsset->platform == 'website' ? 'selected' : '' }} value="website">{{ __('Website') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'mobile_app' ? 'selected' : '' }} value="mobile_app">{{ __('Mobile App') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'facebook' ? 'selected' : '' }} value="facebook">{{ __('Facebook') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'instagram' ? 'selected' : '' }} value="instagram">{{ __('Instagram') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'twitter' ? 'selected' : '' }} value="twitter">{{ __('Twitter') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'snapchat' ? 'selected' : '' }} value="snapchat">{{ __('Snapchat') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'tiktok' ? 'selected' : '' }} value="tiktok">{{ __('Tiktok') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'youtube' ? 'selected' : '' }} value="youtube">{{ __('Youtube') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'pinterest' ? 'selected' : '' }} value="pinterest">{{ __('Pinterest') }}</option>
                                                                                        <option {{ $digitalAsset->platform == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Link:</label>
                                                                                    <input type="link" name="link" class="form-control mb-2 mb-md-0" placeholder="https://www.example.com"  value="{{ $digitalAsset->link }}"/>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                        <i class="la la-trash-o"></i>Delete
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
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
                                                                @endif

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

                                <div class="influencer">

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">City</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="city"  onkeypress="clsAlphaOnly(event)"  class="form-control mb-2" placeholder="City " value="{{ old('city') ?? $publisher->city }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('city'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('city') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class=" required form-label">Address</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="address" class="form-control mb-2" placeholder="Address " value="{{ old('address') ?? $publisher->address }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('address'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('address') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Influencer Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="influencer_type" aria-label="Select a Influencer Type" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm">
                                                <option {{ old('influencer_type') == 'performance' ? "selected" : ($publisher->influencer_type == 'performance' ? "selected" : '' )  }} value="performance">{{ __('Performance') }}</option>
                                                <option {{ old('influencer_type') == 'prepaid' ? "selected" : ($publisher->influencer_type == 'prepaid' ? "selected" : '' )  }} value="prepaid">{{ __('Prepaid') }}</option>
                                                <option {{ old('influencer_type') == 'express' ? "selected" : ($publisher->influencer_type == 'express' ? "selected" : '' )  }} value="express">{{ __('Express') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('influencer_type'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('influencer_type') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Influencer Rating</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="influencer_rating" aria-label="Select a Influencer Rating" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm">
                                                <option {{ old('influencer_rating') == 'nano' ? "selected" : ($publisher->influencer_rating == 'nano' ? "selected" : '' ) }} value="nano">{{ __('Nano') }}</option>
                                                <option {{ old('influencer_rating') == 'micro' ? "selected" : ($publisher->influencer_rating == 'micro' ? "selected" : '' ) }} value="micro">{{ __('Micro') }}</option>
                                                <option {{ old('influencer_rating') == 'macro' ? "selected" : ($publisher->influencer_rating == 'macro' ? "selected" : '' ) }} value="macro">{{ __('Macro') }}</option>
                                                <option {{ old('influencer_rating') == 'mega' ? "selected" : ($publisher->influencer_rating == 'mega' ? "selected" : '' ) }} value="mega">{{ __('Mega') }}</option>
                                                <option {{ old('influencer_rating') == 'celebrity' ? "selected" : ($publisher->influencer_rating == 'celebrity' ? "selected" : '' ) }} value="celebrity">{{ __('Celebrity') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('influencer_rating'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('influencer_rating') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

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
                                                            @if(old('social_media') && count(old('social_media')) > 0 && old('team' == 'influencer'))
                                                                @foreach (old('social_media') as $link)
                                                                    <div data-repeater-item>
                                                                        <div class="form-group row mb-5">
                                                                            <div class="col-md-3">
                                                                                <label class="form-label">Platform:</label>
                                                                                <select  class="form-select" name="platform">
                                                                                    <option {{ $link['platform'] == 'facebook' ? 'selected' : '' }} value="facebook">{{ __('Facebook') }}</option>
                                                                                    <option {{ $link['platform'] == 'instagram' ? 'selected' : '' }} value="instagram">{{ __('Instagram') }}</option>
                                                                                    <option {{ $link['platform'] == 'twitter' ? 'selected' : '' }} value="twitter">{{ __('Twitter') }}</option>
                                                                                    <option {{ $link['platform'] == 'snapchat' ? 'selected' : '' }} value="snapchat">{{ __('Snapchat') }}</option>
                                                                                    <option {{ $link['platform'] == 'tiktok' ? 'selected' : '' }} value="tiktok">{{ __('Tiktok') }}</option>
                                                                                    <option {{ $link['platform'] == 'youtube' ? 'selected' : '' }} value="youtube">{{ __('Youtube') }}</option>
                                                                                    <option {{ $link['platform'] == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label class="form-label">Number Of Followers:</label>
                                                                                <select  class="form-select" name="followers">
                                                                                    <option {{ $link['followers'] == 'lethThan10k' ? 'seleccted' : '' }} value="lethThan10k">< 10K</option>
                                                                                    <option {{ $link['followers'] == '10K : 50K' ? 'seleccted' : '' }} value="10K : 50K">10K : 50K</option>
                                                                                    <option {{ $link['followers'] == '50K : 100K' ? 'seleccted' : '' }} value="50K : 100K">50K : 100K</option>
                                                                                    <option {{ $link['followers'] == '100K : 500K' ? 'seleccted' : '' }} value="100K : 500K">100K : 500K</option>
                                                                                    <option {{ $link['followers'] == '500K : 1M' ? 'seleccted' : '' }} value="500K : 1M">500K : 1M</option>
                                                                                    <option {{ $link['followers'] == '> 1M' ? 'seleccted' : '' }} value="> 1M">> 1M</option>
                                                                                </select>
                                                                            </div>
            
                                                                            <div class="col-md-4">
                                                                                <label class="form-label">Link:</label>
                                                                                <input type="link" name="link" class="form-control mb-2 mb-md-0" placeholder="https://www.example.com" value="{{ $link['link'] }}" />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                    <i class="la la-trash-o"></i>Delete
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @elseif($publisher->socialMediaLinks && count($publisher->socialMediaLinks) > 0 && $publisher->team == 'influencer')
                                                                @foreach ($publisher->socialMediaLinks as $link)
                                                                    <div data-repeater-item>
                                                                        <div class="form-group row mb-5">
                                                                            <div class="col-md-3">
                                                                                <label class="form-label">Platform:</label>
                                                                                <select  class="form-select" name="platform">
                                                                                    <option {{ $link->platform == 'facebook' ? 'selected' : '' }} value="facebook">{{ __('Facebook') }}</option>
                                                                                    <option {{ $link->platform == 'instagram' ? 'selected' : '' }} value="instagram">{{ __('Instagram') }}</option>
                                                                                    <option {{ $link->platform == 'twitter' ? 'selected' : '' }} value="twitter">{{ __('Twitter') }}</option>
                                                                                    <option {{ $link->platform == 'snapchat' ? 'selected' : '' }} value="snapchat">{{ __('Snapchat') }}</option>
                                                                                    <option {{ $link->platform == 'tiktok' ? 'selected' : '' }} value="tiktok">{{ __('Tiktok') }}</option>
                                                                                    <option {{ $link->platform == 'youtube' ? 'selected' : '' }} value="youtube">{{ __('Youtube') }}</option>
                                                                                    <option {{ $link->platform == 'other' ? 'selected' : '' }} value="other">{{ __('Other') }}</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label class="form-label">Number Of Followers:</label>
                                                                                <select  class="form-select" name="followers">
                                                                                    <option {{ $link->followers == 'lethThan10k' ? 'seleccted' : '' }} value="lethThan10k">< 10K</option>
                                                                                    <option {{ $link->followers == '10K : 50K' ? 'seleccted' : '' }} value="10K : 50K">10K : 50K</option>
                                                                                    <option {{ $link->followers == '50K : 100K' ? 'seleccted' : '' }} value="50K : 100K">50K : 100K</option>
                                                                                    <option {{ $link->followers == '100K : 500K' ? 'seleccted' : '' }} value="100K : 500K">100K : 500K</option>
                                                                                    <option {{ $link->followers == '500K : 1M' ? 'seleccted' : '' }} value="500K : 1M">500K : 1M</option>
                                                                                    <option {{ $link->followers == '> 1M' ? 'seleccted' : '' }} value="> 1M">> 1M</option>
                                                                                </select>
                                                                            </div>
            
                                                                            <div class="col-md-4">
                                                                                <label class="form-label">Link:</label>
                                                                                <input type="link" name="link" class="form-control mb-2 mb-md-0" placeholder="https://www.example.com" value="{{ $link->link }}" />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                    <i class="la la-trash-o"></i>Delete
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
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
                                                            @endif


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
                                    <span class="w-125px fw-semibold fs-7">Bank Account Info</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">IBAN</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" onkeypress="clsAlphaNoOnly(event)" name="iban" class="form-control mb-2" placeholder="IBAN" value="{{ old('iban') ?? $publisher->iban }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('iban'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('iban') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">SWIFT Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" onkeypress="clsAlphaNoOnly(event)" name="swift_code" class="form-control mb-2" placeholder="Swift Code" value="{{ old('swift_code') ?? $publisher->swift_code }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('swift_code'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('swift_code') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Bank Account Title</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" onkeypress="clsAlphaOnly(event)" name="account_title" class="form-control mb-2" placeholder="Account Title" value="{{ old('account_title') ?? $publisher->account_title }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('account_title'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('account_title') }}</div></div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Bank Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" onkeypress="clsAlphaOnly(event)" name="bank_name" class="form-control mb-2" placeholder="Bank Name" value="{{ old('bank_name') ?? $publisher->bank_name }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('bank_name'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('bank_name') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Bank Branch Code</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" onkeypress="clsAlphaNoOnly(event)" name="bank_branch_code" class="form-control mb-2" placeholder="Bank Branch Code" value="{{ old('bank_branch_code') ?? $publisher->bank_branch_code }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('bank_branch_code'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('bank_branch_code') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Currency</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="currency" aria-label="Select a Currency" data-control="select2" data-placeholder="Select Currency" class="form-select form-select-sm">
                                                <option {{ old('currency') == 'USD' ? "selected" : ($publisher->currency == 'USD' ? "selected" : '') }} value="USD">USD</option>
                                                <option {{ old('currency') == 'SAR' ? "selected" : ($publisher->currency == 'SAR' ? "selected" : '') }} value="SAR">SAR</option>
                                                <option {{ old('currency') == 'AED' ? "selected" : ($publisher->currency == 'AED' ? "selected" : '') }} value="AED">AED</option>
                                                <option {{ old('currency') == 'KWD' ? "selected" : ($publisher->currency == 'KWD' ? "selected" : '') }} value="KWD">KWD</option>
                                                <option {{ old('currency') == 'EGP' ? "selected" : ($publisher->currency == 'EGP' ? "selected" : '') }} value="EGP">EGP</option>
                                            </select>                                            
                                            <!--end::Input-->
                                            @if ($errors->has('currency'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('currency') }}</div></div>
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
                <button type="reset" class="btn btn-light me-5">Cancel</button>
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
        @if(old('team') == 'affiliate' || $publisher->team == 'affiliate')
            $('.influencer').fadeOut('fast');
        @else
            $('.affiliate').fadeOut('fast');
        @endif
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
                // Get Categories
            $.get({
                url: '{{ route('admin.get.categories.based.on.team') }}',
                data: {
                    team: $(this).val(),
                },
                beforeSend: function() {
                    $('#loading').show()
                },
                success: function(data) {
                    $('#categories').html(data)
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
<script src="{{ asset('new_dashboard/js/custimize_inputs.js') }}"></script>
@endpush
