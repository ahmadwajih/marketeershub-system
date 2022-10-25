@extends('admin.layouts.app')
@section('title','Advertisers')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('Create New Advertiser') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.advertisers.store')}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                    <div class="alert-icon">
                                        <i class="flaticon2-bell-5"></i>
                                    </div>
                                    <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span>
                                                <i class="ki ki-close"></i>
                                            </span>
                                    </button>
                                    </div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>* اسم الشركة باللغة العربية :</label>
                                                <input type="text" name="company_name_ar" class="form-control"  value="{{old('company_name_ar')}}" />
                                                @if ($errors->has('company_name_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('company_name_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="col-lg-4">
                                                <label>* Company Name In English:</label>
                                                <input type="text" name="company_name_en" class="form-control"  value="{{old('company_name_en')}}" />
                                                @if ($errors->has('company_name_en'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('company_name_en') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-2">
                                                <label>{{ __('Exclusive') }}</label>
                                                <span class="switch switch-icon">
                                                    <label>
                                                        <input type="checkbox" @if(old('exclusive') == 'on') checked="checked" @endif name="exclusive"/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>

                                            <div class="col-lg-2">
                                                <label>{{ __('Broker') }}</label>
                                                <span class="switch switch-icon">
                                                    <label>
                                                        <input type="checkbox" @if(old('broker') == 'on') checked="checked" @endif name="broker"/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Contact Person Name') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{old('name')}}" />
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}" />
                                                @if ($errors->has('phone'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('phone') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Email') }} :</label>
                                                <input type="email" name="email" class="form-control"  value="{{old('email')}}" />
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Website Link') }} :</label>
                                                <input type="url" name="website" class="form-control" value="{{old('website')}}" />
                                                @if ($errors->has('website'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('website') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Source') }} :</label>
                                                <input type="text" name="validation_source" class="form-control" value="{{old('validation_source')}}" />
                                                @if ($errors->has('validation_source'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('validation_source') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Duration') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{old('validation_duration')}}" />
                                                @if ($errors->has('validation_duration'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('validation_duration') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                           
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_validation_type" name="validation_type" >
                                                    <option value="system">{{ __('System') }}</option>
                                                    <option value="sheet">{{ __('Excel Sheet') }}</option>
                                                    <option value="manual_report_via_email">{{ __('Manual Report Via Email') }}</option>
                                                </select>
                                                @if ($errors->has('validation_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('validation_type') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" >
                                                    <option value="active">{{ __('Active') }}</option>
                                                    <option value="inactive">{{ __('Un Active') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ _('Country') }} :</label>
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id" >
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}">{{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('country_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ _('City') }} :</label>
                                                <select class="form-control select2" id="kt_select_city_id" name="city_id" >
                                                    <option value="0">{{ __("Select Country") }}</option>
                                                </select>
                                                @if ($errors->has('city_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('city_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Address') }} :</label>
                                                <input type="text" name="address" class="form-control" value="{{old('address')}}" />
                                                @if ($errors->has('address'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('address') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Categories') }} :</label>
                                                <select class="form-control select2" id="kt_select_categories" name="categories[]"  multiple>
                                                    @foreach ($categories as $category)
                                                        <option {{ old('categories')?(in_array($category->id,old('categories'))?'selected':''):''  }} value="{{ $category->id }}">{{  $category->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('categories'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('categories') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                           
                                           
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Access Username Or Email') }} :</label>
                                                <input type="text" name="access_username" class="form-control" value="{{old('access_username')}}" />
                                                @if ($errors->has('access_username'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('access_username') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Access Password') }} :</label>
                                                <input type="text" name="access_password" class="form-control"  value="{{old('access_password')}}" />
                                                @if ($errors->has('access_password'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('access_password') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-lg-6">
                                                <label>* {{ __('Currency') }} :</label>
                                                <select class="form-control select2" id="kt_select_currency_id" name="currency_id">
                                                    @foreach ($currencies as $currency)
                                                        <option {{ old('currency_id')?($currency->id == old('currency_id') ?'selected':''):''  }} value="{{ $currency->id }}">{{  $currency->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('currency_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('currency_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="col-lg-6">
                                                <label>* {{ __('Language') }} :</label>
                                                <select class="form-control select2" id="kt_select_language" name="language" >
                                                    <option value="ar">{{ __('AR') }}</option>
                                                    <option value="en">{{ __('En') }}</option>
                                                    <option value="ar_en">{{ __('AR & EN') }}</option>
                                                </select>
                                                @if ($errors->has('language'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('language') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>{{ __('Contract') }} :</label>
                                                <input type="file" name="contract" class="form-control" value="{{old('contract')}}" />
                                                @if ($errors->has('contract'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('contract') }}</p>
                                                    </div>  
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>{{ __('NDA') }} :</label>
                                                <input type="file" name="nda" class="form-control" value="{{old('nda')}}" />
                                                @if ($errors->has('nda'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('nda') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>{{ __('IO') }} :</label>
                                                <input type="file" name="io" class="form-control" value="{{old('io')}}" />
                                                @if ($errors->has('io'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('io') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Note') }} :</label>
                                                <textarea name="note"  class="form-control" id="" cols="30" rows="10">{{old('note')}}</textarea>
                                                @if ($errors->has('note'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('note') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ __("Submit") }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')
    <script>

        $('#kt_select_status').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_country_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_city_id').select2({
            placeholder: "You sholud select country",
        });

        $('#kt_select_validation_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_categories').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_language').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_currency_id').select2({
            placeholder: "Select Option",
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#kt_select_country_id").on("change",function(){
                var countryId = $("#kt_select_country_id").val();
                console.log(countryId);
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.ajax.cities')}}",
                    data: { countryId: countryId}, 
                })
                .done(function(res) {
                    console.log(res);
                    $("#kt_select_city_id").html(res)
                });
            });
        });


    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
@endpush
