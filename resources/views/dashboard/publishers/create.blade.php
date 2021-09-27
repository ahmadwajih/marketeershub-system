@extends('dashboard.layouts.app')
@section('title','Users')
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
                            <h2 class="card-title">{{ __('Create New User') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('dashboard.publishers.store')}}" method = "POST" enctype="multipart/form-data">
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
                                                <label>* {{ __('Name') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{old('name')}}" required/>
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}" required/>
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
                                                <input type="email" name="email" class="form-control"  value="{{old('email')}}" required/>
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>*  {{ __('Password') }} :</label>
                                                <input type="password" name="password" class="form-control"  value="{{old('password')}}" required/>
                                                @if ($errors->has('password'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('password') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Team') }} :</label>
                                                <select class="form-control select2" id="kt_select_team" name="team" required>
                                                    <option value="media_buying">{{ __('Media Buying') }}</option>
                                                    <option value="influencer">{{ __('Influencer') }}</option>
                                                    <option value="affiliate">{{ __('Affiliate') }}</option>
                                                </select>
                                                @if ($errors->has('team'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('team') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Belongs To') }} :</label>
                                                <select class="form-control select2" id="kt_select_parent_id" name="parent_id" required>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{  $user->name }} from team {{  $user->team }} position {{  $user->position }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('parent_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('parent_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Gender') }} :</label>
                                                <select class="form-control select2" id="kt_select_gender" name="gender" required>
                                                    <option value="male">{{ __('Male') }}</option>
                                                    <option value="female">{{ __('female') }}</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('gender') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" required>
                                                    <option value="active">{{ __('Active') }}</option>
                                                    <option value="pending">{{ __('Pending') }}</option>
                                                    <option value="closed">{{ __('Closed') }}</option>
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
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id" required>
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
                                                <select class="form-control select2" id="kt_select_city_id" name="city_id" required>
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
                                                <label> {{ __('Skype') }} :</label>
                                                <input type="text" name="skype" class="form-control" value="{{old('skype')}}" />
                                                @if ($errors->has('skype'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('skype') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label> {{ __('Address') }} :</label>
                                                <input type="text" name="address" class="form-control" value="{{old('address')}}" />
                                                @if ($errors->has('address'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('address') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Category') }} :</label>
                                                <input type="text" name="category" class="form-control" value="{{old('category')}}" />
                                                @if ($errors->has('category'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('category') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                           
                                            <div class="col-lg-6">
                                                <label>{{ __('Years Of Experience') }} :</label>
                                                <input type="text" name="years_of_experience" class="form-control" value="{{old('years_of_experience')}}" />
                                                @if ($errors->has('years_of_experience'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('years_of_experience') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Traffic Sources') }} :</label>
                                                <input type="text" name="traffic_sources" class="form-control" value="{{old('traffic_sources')}}" />
                                                @if ($errors->has('traffic_sources'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('traffic_sources') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Affiliate Networks') }} :</label>
                                                <input type="text" name="affiliate_networks" class="form-control" value="{{old('affiliate_networks')}}" />
                                                @if ($errors->has('affiliate_networks'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('affiliate_networks') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Owened Digital Assets') }} :</label>
                                                <input type="text" name="owened_digital_assets" class="form-control" value="{{old('owened_digital_assets')}}" />
                                                @if ($errors->has('owened_digital_assets'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('owened_digital_assets') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                          
                                        </div>

                                        {{-- Bank Account Details --}}
                                        <h3 class="text-center mt-20 mb-15">{{ __('Bank Account Details') }}</h3>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>*{{ __('Account Title') }} :</label>
                                                <input type="text" name="account_title" class="form-control" value="{{old('account_title')}}" required />
                                                @if ($errors->has('account_title'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('account_title') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Bank Name') }} :</label>
                                                <input type="text" name="bank_name" class="form-control" value="{{old('bank_name')}}" required />
                                                @if ($errors->has('bank_name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('bank_name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>*{{ __('Bank Branch Code') }} :</label>
                                                <input type="text" name="bank_branch_code" class="form-control" value="{{old('bank_branch_code')}}" required />
                                                @if ($errors->has('bank_branch_code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('bank_branch_code') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Swift Code') }} :</label>
                                                <input type="text" name="swift_code" class="form-control" value="{{old('swift_code')}}" required />
                                                @if ($errors->has('swift_code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('swift_code') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>*{{ __('Iban') }} :</label>
                                                <input type="text" name="iban" class="form-control" value="{{old('iban')}}" required />
                                                @if ($errors->has('iban'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('iban') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Currency') }} :</label>
                                                <input type="text" name="currency" class="form-control" value="{{old('currency')}}" required />
                                                @if ($errors->has('currency'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('currency') }}</p>
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
        $('#kt_select_team').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_position').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_parent_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_gender').select2({
            placeholder: "Select Option",
        });
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
                    url: "{{route('dashboard.ajax.cities')}}",
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
