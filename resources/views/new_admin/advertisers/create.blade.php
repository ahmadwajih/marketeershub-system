@extends('new_admin.layouts.app')
@section('content')

    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Add New Coupon</h1>
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
                <li class="breadcrumb-item text-gray-500">Add New</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <!--begin::Form-->
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.coupons.store') }}" method="POST" enctype="multipart/form-data">
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
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Company Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="company_name_en" class="form-control mb-2" placeholder="Company Name" value="{{ old('company_name_en') }}" />
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
                                            <input type="text" name="name" class="form-control mb-2" placeholder="Responsable Person Name" value="{{ old('name') }}" />
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
                                            <input type="text" name="phone" class="form-control mb-2" placeholder="Responsable Person Phone" value="{{ old('phone') }}" />
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
                                            <input type="email" name="email" class="form-control mb-2" placeholder="Responsable Person Email" value="{{ old('email') }}" />
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
                                            <input type="url" name="website" class="form-control mb-2" placeholder="Website" value="{{ old('website') }}" />
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
                                            <input type="text" name="validation_source" class="form-control mb-2" placeholder="Validation Source" value="{{ old('validation_source') }}" />
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
                                            <input type="text" name="validation_duration" class="form-control mb-2" placeholder="Validation Duration" value="{{ old('validation_duration') }}" />
                                            @if ($errors->has('validation_duration'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('validation_duration') }}</div></div>
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
                                                <option value="sheet">{{ __('Excel Sheet') }}</option>
                                                <option value="system">{{ __('System') }}</option>
                                                <option value="manual_report_via_email">{{ __('Manual Report Via Email') }}</option>
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
                                                <option value="active">{{ __('Active') }}</option>
                                                <option value="unactive">{{ __('Un Active') }}</option>
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
                                                    <option {{ old('country_id') == $country->id ? "selected" : 'null' }} value="{{ $country->id }}">{{  $country->name }}</option>
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
                                                    <option {{ old('city_id') == $city->id ? "selected" : 'null' }} value="{{ $city->id }}">{{  $city->name }}</option>
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
                                            <input type="text" name="address" class="form-control mb-2" placeholder="Address" value="{{ old('address') }}" />
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
                                            <select name="Categories[]" multiple data-control="select2" class="form-select form-select-sm">
                                                @foreach ($categories as $category)
                                                <option {{ old('categories')?(in_array($category->id,old('categories'))?'selected':''):''  }} value="{{ $category->id }}">{{  $category->title }}</option>
                                            @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('Categories'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('Categories') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>
{{-- 
                                    <div class="col-md-4">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Offer</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="offer_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach($offers as $offer)
                                                        <option {{old('offer_id')==$offer->id?"selected":""}} value="{{$offer->id}}">{{$offer->name}}</option>
                                                    @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('offer_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('offer_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div> --}}

                                    {{-- <div class="col-md-4">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Publisher</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="user_id" data-control="select2" class="form-select">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach($users as $user)
                                                    <option {{old('user_id')==$user->id?"selected":""}} value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('user_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('user_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div> --}}

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
                <a href="../../demo14/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
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
