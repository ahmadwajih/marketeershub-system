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
                                            <div class="col-lg-6">
                                                <label>* {{ __('Company Name') }} :</label>
                                                <input type="text" name="company_name" class="form-control"  value="{{old('company_name')}}" />
                                                @if ($errors->has('company_name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('company_name') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Contact Person') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{old('name')}}" />
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}" />
                                                @if ($errors->has('phone'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('phone') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Email') }} :</label>
                                                <input type="email" name="email" class="form-control"  value="{{old('email')}}" />
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
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
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" >
                                                    <option value="pending">{{ __('Pending') }}</option>
                                                    <option value="rejected">{{ __('Rejected') }}</option>
                                                    <option value="approved">{{ __('Approved') }}</option>
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
                                                <label>* {{ __('Link') }} :</label>
                                                <input type="url" name="website" class="form-control" value="{{old('website')}}" />
                                                @if ($errors->has('website'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('website') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('source') }} :</label>
                                                <input type="url" name="source" class="form-control" value="{{old('source')}}" />
                                                @if ($errors->has('source'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('source') }}</p>
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
                                                <input type="password" name="access_password" class="form-control"  value="{{old('access_password')}}" />
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
                                                <input type="text" name="currency" class="form-control" value="{{old('currency')}}" />
                                                @if ($errors->has('currency'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('currency') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Language') }} :</label>
                                                <input type="text" name="language" class="form-control"  value="{{old('language')}}" />
                                                @if ($errors->has('language'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('language') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Note') }} :</label>
                                                <input type="text" name="validation_period" class="form-control" value="{{old('validation_period')}}" />
                                                @if ($errors->has('validation_period'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('validation_period') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Validation Type') }} :</label>
                                                <input type="text" name="validation_type" class="form-control"  value="{{old('validation_type')}}" />
                                                @if ($errors->has('validation_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('validation_type') }}</p>
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
