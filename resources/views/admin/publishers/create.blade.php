@extends('admin.layouts.app')
@section('title','Publishers')
@push('styles')
    <style>
        .influncers{
            display: none;
        }
    </style>
@endpush
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
                            <h2 class="card-title">{{ __('Create New Publisher') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.publishers.store')}}" method = "POST" enctype="multipart/form-data">
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
                                        <label class="col-12 text-center mb-5">{{ __('Profile Image') }}</label>
                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <div class="image-input image-input-outline image-input-circle" id="kt_image">
                                                    <div class="image-input-wrapper" style="background-image: url({{asset('dashboard/images/placeholder.png')}})"></div>
                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Upload image">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg" />
                                                        {{-- <input type="hidden" name="profile_avatar_remove" /> --}}
                                                    </label>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Delete image">
                                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                        </span>
                                                </div>
                                                <span class="form-text text-muted mt-5 mb-5">{{ __('Available extensions is : png، jpg، jpeg،') }}</span>
                                                @if ($errors->has('image'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('image') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
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
                                            <div class="col-lg-4">
                                                <label>* {{ __('Team') }} :</label>
                                                <select class="form-control select2" id="kt_select_team" name="team" required>
                                                    <option {{ old('team')=='affiliate'?'selected':'' }} value="affiliate">{{ __('Affiliate') }}</option>
                                                    <option {{ old('team')=='media_buying'?'selected':'' }} value="media_buying">{{ __('Media Buying') }}</option>
                                                    <option {{ old('team')=='influencer'?'selected':'' }} value="influencer">{{ __('Influencer') }}</option>
                                                    <option {{ old('team')=='prepaid'?'selected':'' }} value="prepaid">{{ __('Prepaid') }}</option>
                                                </select>
                                                @if ($errors->has('team'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('team') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-4">
                                                <label>* {{ __('Belongs To') }} :</label>
                                                <select class="form-control select2" id="kt_select_parent_id" name="parent_id" required>
                                                    @foreach ($users as $user)
                                                        <option {{ old('parent_id')==$user->id?'selected':'' }} value="{{ $user->id }}">{{  $user->name }} from team {{  $user->team }} position {{  $user->position }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('parent_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('parent_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-4">
                                                <label>* {{ _('Role') }} :</label>
                                                <select class="form-control select2" id="kt_select_role_id" name="roles[]" required multiple>
                                                    @foreach($roles as $role)
                                                        <option {{ old('roles')?(in_array($role->id,old('roles'))?'selected':''):''  }} value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('roles'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('roles') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Gender') }} :</label>
                                                <select class="form-control select2" id="kt_select_gender" name="gender" required>
                                                    <option {{ old('gender')=='male'?'selected':'' }} value="male">{{ __('Male') }}</option>
                                                    <option {{ old('gender')=='female'?'selected':'' }} value="female">{{ __('female') }}</option>
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
                                                    <option {{ old('status')=='active'?'selected':'' }} value="active">{{ __('Active') }}</option>
                                                    <option {{ old('status')=='pending'?'selected':'' }} value="pending">{{ __('Pending') }}</option>
                                                    <option {{ old('status')=='closed'?'selected':'' }} value="closed">{{ __('Closed') }}</option>
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
                                                        <option  {{ old('country_id')==$user->id?'$country':'' }} value="{{$country->id}}">{{$country->name_en}}</option>
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
                                                    @if(old('country_id'))
                                                      @foreach(App\Models\Country::findOrFail(old('country_id'))->cities as $city)
                                                        <option {{ old('city_id')==$city->id?'selected':'' }} value="0">{{ $city->name_en }}</option>
                                                      @endforeach
                                                    @else
                                                        <option value="0">{{ __("Select Country") }}</option>
                                                    @endif
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
                                                <label> {{ __('Address') }} :</label>
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

                                        {{-- Affiliates Data  --}}

                                        <div class="affiliates">
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
    
                                        </div>
                                        
                                        {{-- Influncers --}}
                                        <div class="influncers">
                                            <div class="form-group row d-block" id="social_media">
                                                <div id="kt_repeater_1">
                                                    <div class="form-group row" id="kt_repeater_1">
                                                        <label class="col-form-label text-right"><b>{{ __('Socia Media Accounts') }}</b></label>
                                                        <div data-repeater-list="social_media" class="col-lg-12">
                                                            @for($i = 0; $i < 6; $i++)
                                                            <div data-repeater-item class="form-group row align-items-center">
                                                                <div class="col-md-6">
                                                                    <label>{{ __('Link') }}</label>
                                                                    <input type="url" name="link" class="form-control" />
                                                                    <div class="d-md-none mb-2"></div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label>{{__('Platform') }}</label>
                                                                    <select class="form-control form-select" name="platform" style="display: block" >
                                                                        <option {{ $i=='0'?'selected':'' }} value="facebook">{{ __('Facebook') }}</option>
                                                                        <option {{ $i=='1'?'selected':'' }} value="instagram">{{ __('Instagram') }}</option>
                                                                        <option {{ $i=='2'?'selected':'' }} value="twitter">{{ __('Twitter') }}</option>
                                                                        <option {{ $i=='3'?'selected':'' }} value="snapchat">{{ __('Snapchat') }}</option>
                                                                        <option {{ $i=='4'?'selected':'' }} value="tiktok">{{ __('Tiktok') }}</option>
                                                                        <option {{ $i=='5'?'selected':'' }} value="youtube">{{ __('Youtube') }}</option>
                                                                        <option value="other">{{ __('Other') }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label>{{__('Number Of Followers') }}</label>
                                                                    <select class="form-control form-select" name="followers" style="display: block" >
                                                                        <option selected="selected" value="lethThan10k">< 10K</option>
                                                                        <option value="10Kto50K">10K : 50K</option>
                                                                        <option value="50Kto100K">50K : 100K</option>
                                                                        <option value="100Kto500K">100K : 500K</option>
                                                                        <option value="500Kto1M">500K : 1M</option>
                                                                        <option value="morethan1M">> 1M</option>
                                                                    </select>
                                                                </div>
        
                                                                <div class="col-md-2">
                                                                    <br>
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger btn-block">
                                                                        <i class="la la-trash-o"></i>حذف
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            @endfor
                                                        </div>
        
                                                    </div>
                                                    <div class="form-group row">
                                                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary btn-block">
                                                            <i class="la la-plus"></i>إضافة
                                                        </a>
                                                    </div>
                                                </div>
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
            placeholder: "Select Option",
        });
        $('#kt_select_role_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_categories').select2({
            placeholder: "Select Option",
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#kt_select_country_id").on("change",function(){
                var countryId = $("#kt_select_country_id").val();
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

            $("#kt_select_team").on("change",function(){
                var team = $("#kt_select_team").val();
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.ajax.account.managers')}}",
                    data: {team: team}, 
                })
                .done(function(res) {
                    $("#kt_select_parent_id").html(res)
                });
                if(team == 'affiliate' || team == 'media_buying'){
                    $('.affiliates').fadeIn('slow');
                    $('.influncers').fadeOut('slow');
                }
                if(team == 'influencer' || team == 'prepaid'){
                    $('.influncers').fadeIn('slow');
                    $('.affiliates').fadeOut('slow');
                }
            });
        });


    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script>
        // Class definition
        var KTFormRepeater = function() {
        // Private functions
        var demo1 = function() {
            $('#kt_repeater_1').repeater({
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
        }

        return {
            // public functions
            init: function() {
                demo1();
            }
        };
        }();

        jQuery(document).ready(function() {
            KTFormRepeater.init();
        });
    </script>
@endpush
