@extends('new_admin.layouts.app')
@section('title', 'Advertisers')
@section('subtitle', 'Edit')
@section('content')

    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Edit {{ $advertiser->company_name }}</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Advertisers</li>
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
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{route('admin.advertisers.update',$advertiser->id)}}" method="POST" enctype="multipart/form-data">
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
                                    <div class="col-md-6">
                                        <div class="form-check form-check-custom form-check-solid mb-10">
                                            <input @if(old('exclusive') == 'on') checked='checked' @elseif($advertiser->exclusive) checked='checked' @endif class="form-check-input" type="checkbox" name="exclusive" id="exclusive"/>
                                            <label class="form-check-label" for="exclusive">
                                                {{ __('Exclusive') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid mb-10">
                                            <input @if(old('broker') == 'on') checked='checked' @elseif($advertiser->broker) checked='checked' @endif  class="form-check-input" type="checkbox" name="broker" id="broker"/>
                                            <label class="form-check-label" for="broker">
                                                {{ __('Broker') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Company Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="company_name_en" class="form-control mb-2" placeholder="Company Name" value="{{ old('company_name_en') ?? $advertiser->company_name_en }}" />
                                            @if ($errors->has('company_name_en'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('company_name_en') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Responsable Person Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2" placeholder="Responsable Person Name" value="{{ old('name') ?? $advertiser->name }}" />
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
                                            <label class="required form-label">Responsable Person Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="phone" class="form-control mb-2" placeholder="Responsable Person Phone" value="{{ old('phone') ?? $advertiser->phone }}" />
                                            @if ($errors->has('phone'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('phone') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Responsable Person Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="email" name="email" class="form-control mb-2" placeholder="Responsable Person Email" value="{{ old('email') ?? $advertiser->email }}" />
                                            @if ($errors->has('email'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('email') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Website</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="url" name="website" class="form-control mb-2" placeholder="Website" value="{{ old('website') ?? $advertiser->website }}" />
                                            @if ($errors->has('website'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('website') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Validation Source</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="validation_source" class="form-control mb-2" placeholder="Validation Source" value="{{ old('validation_source') ?? $advertiser->validation_source }}" />
                                            @if ($errors->has('validation_source'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('validation_source') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Validation Duration</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="validation_duration" class="form-control mb-2" placeholder="Validation Duration" value="{{ old('validation_duration')?? $advertiser->validation_duration }}" />
                                            @if ($errors->has('validation_duration'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('validation_duration')  }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Validation Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="validation_type" data-control="select2" class="form-select">
                                                <option {{ $advertiser->validation_type == 'sheet' ? 'selected' : '' }} value="sheet">{{ __('Excel Sheet') }}</option>
                                                <option {{ $advertiser->validation_type == 'system' ? 'selected' : '' }} value="system">{{ __('System') }}</option>
                                                <option {{ $advertiser->validation_type == 'manual_report_via_email' ? 'selected' : '' }} value="manual_report_via_email">{{ __('Manual Report Via Email') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('validation_type'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('validation_type') }}</div></div>
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
                                                <option {{ $advertiser->status == 'active' ? 'selected' : '' }} value="active">{{ __('Active') }}</option>
                                                <option {{ $advertiser->status == 'unactive' ? 'selected' : '' }} value="unactive">{{ __('Un Active') }}</option>
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
                                            <label class="form-label">Country</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="country" name="country_id" data-control="select2" class="form-select form-select-sm">
                                                @foreach ($countries as $country)
                                                    <option {{ old('country_id') == $country->id ? "selected" : ($advertiser->country_id == $country->id ? 'selected' : '') }} value="{{ $country->id }}">{{  $country->name }}</option>
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
                                            <label class="form-label">City</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="cities" name="city_id" data-control="select2" class="form-select form-select-sm">
                                                <option value="">You have to select country</option>
                                                @foreach ($cities as $city)
                                                    <option {{ old('city_id') == $city->id ? "selected" :  ($advertiser->city_id == $city->id ? 'selected' : '')}} value="{{ $city->id }}">{{  $city->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('city_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('city_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Address</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="address" class="form-control mb-2" placeholder="Address" value="{{ old('address') ?? $advertiser->address }}" />
                                            @if ($errors->has('address'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('address') }}</div></div>
                                            @endif
                                            <!--end::Input-->
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
                                            <select name="categories[]" multiple data-control="select2" class="form-select form-select-sm">
                                                @foreach ($categories as $category)
                                                <option {{ old('categories') ? (in_array($category->id, old('categories')) ? 'selected':'') : (in_array($category->id, $advertiser->categories->pluck('id')->toArray())?'selected':'')  }} value="{{ $category->id }}">{{  $category->title }}</option>
                                            @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('Categories'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('Categories') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Access Username Or Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="access_username" class="form-control mb-2" placeholder="Access Username Or Email" value="{{ old('access_username') ?? $advertiser->access_username }}" />
                                            @if ($errors->has('access_username'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('access_username') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Access Password</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="access_password" class="form-control mb-2" placeholder="Access Password" value="{{ old('access_password') ?? $advertiser->access_password }}" />
                                            @if ($errors->has('access_password'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('access_password') }}</div></div>
                                            @endif
                                            <!--end::Input-->
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
                                                    <option {{ old('currency_id')?($currency->id == old('currency_id') ?'selected': ($advertiser->currency_id == $currency->id ? 'selected' : '')):''  }} value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('currency_id'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('currency_id') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Language</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="language" data-control="select2" class="form-select">
                                                <option {{ old('language')=='ar'?'selected':($advertiser->language =='ar'?'selected':'' )}}  value="ar">{{ __('AR') }}</option>
                                                <option {{ old('language')=='en'?'selected':($advertiser->language =='en'?'selected':'') }} value="en">{{ __('En') }}</option>
                                                <option {{old('language')=='ar_en'?'selected':($advertiser->language =='ar_en'?'selected':'') }} value="ar_en">{{ __('AR & EN') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('language'))
                                                <div class="fv-plugins-message-container invalid-feedback">
                                                    <div data-field="text_input">{{ $errors->first('language') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Contract</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="contract" class="form-control mb-2" value="{{ old('contract') }}" />
                                            @if ($errors->has('contract'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('contract') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">NDA</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="nda" class="form-control mb-2" value="{{ old('nda') }}" />
                                            @if ($errors->has('nda'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('nda') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">IO</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="io" class="form-control mb-2" value="{{ old('io') }}" />
                                            @if ($errors->has('io'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('io') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Note</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea name="note" class="form-control mb-2" >{{ old('note') ?? $advertiser->note }}</textarea>
                                            @if ($errors->has('note'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('note') }}</div></div>
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
                <a href="{{ route('admin.advertisers.index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
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
    })
</script>
@endpush
