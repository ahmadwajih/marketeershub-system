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
                            <h2 class="card-title"> {{ __('Company Name') }} {{ $advertiser->company_name }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.advertisers.update',$advertiser->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                        <ul>
                                            @foreach($errors->all() as $error )
                                                <li>{{$error}}</li>
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
                                                <input type="text" name="company_name_ar" class="form-control"  value="{{old('company_name_ar')??$advertiser->company_name_ar}}" />
                                                @if ($errors->has('company_name_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('company_name_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="col-lg-4">
                                                <label>* Company Name In English:</label>
                                                <input type="text" name="company_name_en" class="form-control"  value="{{old('company_name_en')??$advertiser->company_name_en}}" />
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
                                                        <input type="checkbox" @if(old('exclusive')) @if(old('exclusive') == 'on') checked='checked' @endif @elseif($advertiser->exclusive) checked='checked' @endif name="exclusive"/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>

                                            <div class="col-lg-2">
                                                <label>{{ __('Broker') }}</label>
                                                <span class="switch switch-icon">
                                                    <label>
                                                        <input type="checkbox" @if(old('broker')) @if(old('broker') == 'on') checked='checked' @endif @elseif($advertiser->broker) checked='checked' @endif name="broker"/>
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Contact Person Name') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{old('name')??$advertiser->name}}" />
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control" value="{{old('phone')??$advertiser->phone}}" />
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
                                                <input type="email" name="email" class="form-control"  value="{{old('email')??$advertiser->email}}" />
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Website Link') }} :</label>
                                                <input type="url" name="website" class="form-control" value="{{old('website')??$advertiser->website}}" />
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
                                                <input type="text" name="validation_source" class="form-control" value="{{old('validation_source') ?? $advertiser->validation_source}}" />
                                                @if ($errors->has('validation_source'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('validation_source') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Duration') }} :</label>
                                                <input type="text" name="validation_duration" class="form-control" value="{{old('validation_duration')??$advertiser->validation_duration}}" />
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
                                                    <option {{ old('validation_type')=='system'?'selected':($advertiser->validation_type =='system'?'selected':'') }} value="system">{{ __('System') }}</option>
                                                    <option {{ old('validation_type')=='sheet'?'selected':($advertiser->validation_type =='sheet'?'selected':'') }} value="sheet">{{ __('Excel Sheet') }}</option>
                                                    <option {{ old('validation_type')=='manual_report_via_email'?'selected':($advertiser->validation_type =='manual_report_via_email'?'selected':'') }} value="manual_report_via_email">{{ __('Manual Report Via Email') }}</option>
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
                                                    <option {{ old('status')=='active'?'selected':($advertiser->status =='active'?'selected':'') }} value="active">{{ __('active') }}</option>
                                                    <option {{ old('status')=='unactive'?'selected':($advertiser->status =='unactive'?'selected':'') }} value="unactive">{{ __('Un Active') }}</option>
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
                                                        <option {{old('country_id') == $country->id ? "selected" : ($advertiser->country_id==$country->id?'selected':'')}} value="{{$country->id}}">{{$country->name}}</option>
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
                                                    @foreach($cities as $city)
                                                        <option {{old('city_id')==$city->id?'selected':($advertiser->city_id==$city->id?'selected':'')}} value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
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
                                                <input type="text" name="address" class="form-control" value="{{old('address')??$advertiser->address}}" />
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
                                                        <option {{ old('categories') ? (in_array($category->id, old('categories')) ? 'selected':'') : (in_array($category->id, $advertiser->categories->pluck('id')->toArray())?'selected':'')  }} value="{{ $category->id }}">{{  $category->title }}</option>
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
                                                <input type="text" name="access_username" class="form-control" value="{{old('access_username')??$advertiser->access_username}}" />
                                                @if ($errors->has('access_username'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('access_username') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Access Password') }} :</label>
                                                <input type="text" name="access_password" class="form-control"  value="{{old('access_password')??$advertiser->access_password}}" />
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
                                                        <option {{ old('currency_id')?($currency->id == old('currency_id') ?'selected': ($advertiser->currency_id == $currency->id ? 'selected' : '')):''  }} value="{{ $currency->id }}">{{  $currency->name }}</option>
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
                                                    <option {{ old('language')=='ar'?'selected':($advertiser->language =='ar'?'selected':'' )}}   value="ar">{{ __('AR') }}</option>
                                                    <option {{ old('language')=='en'?'selected':($advertiser->language =='en'?'selected':'') }}  value="en">{{ __('En') }}</option>
                                                    <option {{old('language')=='ar_en'?'selected':($advertiser->language =='ar_en'?'selected':'') }}  value="ar_en">{{ __('AR & EN') }}</option>
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
                                                <textarea name="note"  class="form-control" id="" cols="30" rows="10">{{old('note')??$advertiser->note}}</textarea>
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
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ _('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ _('Submit') }}</button>
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
        $('#kt_select_validation_source').select2({
            placeholder: "Select Option",
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
