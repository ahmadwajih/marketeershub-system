@extends('admin.layouts.app')
@section('title','Publishers')
@push('styles')
    @if($publisher->team=='influencer')
        <style>
            .affiliates{
                display: none;
            }
        </style>
    @else
        <style>
            .influncers{
                display: none;
            }
        </style>
    @endif
@endpush
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            @if(session()->has('message'))
                @include('admin.temps.success')
            @endif
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h2 class="card-title"> {{ __('Publisher Name') }} {{ $publisher->name }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.publishers.update',$publisher->id)}}" method = "POST" enctype="multipart/form-data">
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
                                        <label class="col-12 text-center mb-5">{{ __('Profile Image') }}</label>
                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <div class="image-input image-input-outline image-input-circle" id="kt_image">
                                                    <div class="image-input-wrapper" style="background-image: url({{ getImagesPath('Users', $publisher->image) }})"></div>
                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Upload image">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
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
                                                <input type="text" name="name" class="form-control"  value="{{old('name') ?? $publisher->name}}" required />
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Phone') }} :</label>
                                                <input type="text" name="phone" class="form-control check-phone-exists" value="{{old('phone') ?? $publisher->phone}}" required />
                                                <div class="exists-phone-alert"></div>
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
                                                <input type="email" name="email" class="form-control check-email-exists"  value="{{old('email') ?? $publisher->email}}" required/>
                                                <div class="exists-email-alert"></div>
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Password') }} :</label>
                                                <input type="password" name="password" class="form-control"  value="{{old('password')}}" />
                                                <b>{{ __('If you don`t need to change password don`t write any thing here.') }}</b>
                                                <b >{{ __('Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol') }}</b>
                                                @if ($errors->has('password'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('password') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if(auth()->user()->id != $publisher->id)
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Team') }} :</label>
                                                <select class="form-control select2" id="kt_select_team" name="team" required>
                                                    <option {{ $publisher->team=='affiliate'?'selected':'' }} value="affiliate">{{ __('Affiliate') }}</option>
                                                    <option {{ $publisher->team=='media_buying'?'selected':'' }} value="media_buying">{{ __('Media Buying') }}</option>
                                                    <option {{ $publisher->team=='influencer'?'selected':'' }} value="influencer">{{ __('Influencer') }}</option>
                                                    <option {{ $publisher->team=='prepaid'?'selected':'' }} value="prepaid">{{ __('Prepaid') }}</option>
                                                </select>
                                                @if ($errors->has('team'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('team') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Belongs To') }} :</label>
                                                <select class="form-control select2" id="kt_select_parent_id" name="parent_id">
                                                    <option value=" ">{{ __('None') }}</option>
                                                    @foreach ($parents as $parent)
                                                        <option {{ $publisher->parent_id==$parent->id?'selected':'' }} value="{{ $parent->id }}">{{  $parent->name }}</option>
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
                                            @can('update_roles')
                                            <div class="col-lg-6">
                                                <label>* {{ _('Role') }} :</label>
                                                <select class="form-control select2" id="kt_select_role_id" name="roles[]" required multiple>
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->id}}" {{old('roles') ? (in_array($role->id, old('roles'))?'selected':''): ($publisher->roles->contains($role)?'selected':'')}} >{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('roles'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('roles') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            @endcan
                                            <div class="col-lg-6">
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" required>
                                                    <option {{ $publisher->status=='active'?'selected':'' }} value="active">{{ __('Live') }}</option>
                                                    <option {{ $publisher->status=='pending'?'selected':'' }} value="pending">{{ __('Paused') }}</option>
                                                    <option {{ $publisher->status=='closed'?'selected':'' }} value="closed">{{ __('Closed') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif


                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ _('Country') }} :</label>
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id">
                                                    @foreach($countries as $country)
                                                        <option {{$publisher->country_id==$country->id?'selected':''}} value="{{$country->id}}">{{$country->name_en}}</option>
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
                                                        <option {{$publisher->city_id==$city->id?'selected':''}} value="{{$city->id}}">{{$city->name_en}}</option>
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
                                                <label> {{ __('Address') }} :</label>
                                                <input type="text" name="address" class="form-control" value="{{old('address') ?? $publisher->address}}" />
                                                @if ($errors->has('address'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('address') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Gender') }} :</label>
                                                <select class="form-control select2" id="kt_select_gender" name="gender" >
                                                    <option {{ $publisher->gender=='male'?'selected':'' }} value="male">{{ __('Male') }}</option>
                                                    <option {{ $publisher->gender=='female'?'selected':'' }} value="female">{{ __('female') }}</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('gender') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                        
                                        {{-- Affiliates --}}
                                        <div class="affiliates">
                                            <div class="form-group row">

                                                <div class="col-lg-6">
                                                    <label>{{ __('Years Of Experience') }} :</label>
                                                    <input type="text" name="years_of_experience" class="form-control" value="{{old('years_of_experience') ?? $publisher->years_of_experience}}" />
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
                                                    <select class="form-control select2" id="kt_select_traffic_sources" name="traffic_sources[]" multiple>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('website', old('traffic_sources')) ? 'selected' : '') : (in_array('google_ad_words', $publisher->traffic_sources) ? "selected":"") }} value="google_ad_words">{{ __('Google Ad words.') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('website', old('traffic_sources')) ? 'selected' : '') : (in_array('facebook_ig_ads', $publisher->traffic_sources) ? "selected" :"") }} value="facebook_ig_ads">{{ __('Facebook & IG Ads.') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('instagram', old('traffic_sources')) ? 'selected' : '') : (in_array('instagram', $publisher->traffic_sources) ? "selected" :"") }} value="instagram">{{ __('Instagram') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('twitter', old('traffic_sources')) ? 'selected' : '') : (in_array('twitter', $publisher->traffic_sources) ? "selected" :"") }} value="twitter">{{ __('Twitter') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('snapchat', old('traffic_sources')) ? 'selected' : '') : (in_array('snapchat', $publisher->traffic_sources) ? "selected" :"") }} value="snapchat">{{ __('Snapchat') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('tiktok', old('traffic_sources')) ? 'selected' : '') : (in_array('tiktok', $publisher->traffic_sources) ? "selected" :"") }} value="tiktok">{{ __('Tiktok') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('youtube', old('traffic_sources')) ? 'selected' : '') :( in_array('youtube', $publisher->traffic_sources) ? "selected" :"") }} value="youtube">{{ __('Youtube') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('pinterest', old('traffic_sources')) ? 'selected' : '') : (in_array('pinterest', $publisher->traffic_sources) ? "selected" :"") }} value="pinterest">{{ __('Pinterest') }}</option>
                                                        <option {{ old('traffic_sources') !== null ? (in_array('other', old('traffic_sources')) ? 'selected' : '') : (in_array('other', $publisher->traffic_sources) ? "selected" :"") }} value="other">{{ __('Other') }}</option>
                                                    </select>
                                                    @if ($errors->has('traffic_sources'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('traffic_sources') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label> {{ __('Affiliate Networks') }} :</label>
                                                    <input type="text" name="affiliate_networks" class="form-control" value="{{old('affiliate_networks') ?? $publisher->affiliate_networks}}" />
                                                    @if ($errors->has('affiliate_networks'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('affiliate_networks') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                            </div>

                                            <div class="form-group row d-block" id="digital_asset">
                                                <div id="kt_repeater_2">
                                                    <div class="form-group row" id="kt_repeater_2">
                                                        <label class="col-form-label text-right m-4"><b>{{ __('Owened Digital Assets') }}</b></label>
                                                        <div data-repeater-list="digital_asset" class="col-lg-12">
                                                            @if($publisher->team == 'affiliate' && count($publisher->digitalAssets) > 0)
                                                                @foreach($publisher->digitalAssets as $item)
                                                                <div data-repeater-item class="form-group row align-items-center">
                                                                   
                                                                    <div class="col-md-2">
                                                                        <label>{{__('Platform') }}</label>
                                                                        <select class="form-control form-select" name="platform" style="display: block" >
                                                                            <option {{ $item->platform == 'website' ? 'selected' : '' }}  value="website">{{ __('Website') }}</option>
                                                                            <option {{ $item->platform == 'mobile_app' ? 'selected' : '' }}  value="mobile_app">{{ __('Mobile App') }}</option>
                                                                            <option {{ $item->platform == 'facebook' ? 'selected' : '' }}  value="facebook">{{ __('Facebook') }}</option>
                                                                            <option {{ $item->platform == 'instagram' ? 'selected' : '' }}  value="instagram">{{ __('Instagram') }}</option>
                                                                            <option {{ $item->platform == 'twitter' ? 'selected' : '' }}  value="twitter">{{ __('Twitter') }}</option>
                                                                            <option {{ $item->platform == 'snapchat' ? 'selected' : '' }}  value="snapchat">{{ __('Snapchat') }}</option>
                                                                            <option {{ $item->platform == 'tiktok' ? 'selected' : '' }}  value="tiktok">{{ __('Tiktok') }}</option>
                                                                            <option {{ $item->platform == 'youtube' ? 'selected' : '' }}  value="youtube">{{ __('Youtube') }}</option>
                                                                            <option {{ $item->platform == 'pinterest' ? 'selected' : '' }}  value="pinterest">{{ __('Pinterest') }}</option>
                                                                            <option {{ $item->platform == 'other' ? 'selected' : '' }}  value="other">{{ __('Other') }}</option>
                                                                        </select>
                                                                    </div>
                              
                                                                    <div class="col-md-6">
                                                                        <label>{{ __('Link') }}</label>
                                                                        <input type="url" name="link" class="form-control" value="{{ $item->link }}"/>
                                                                        <div class="d-md-none mb-2"></div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <br>
                                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger btn-block">
                                                                            <i class="la la-trash-o"></i>Delete
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            @else
                                                            <div data-repeater-item class="form-group row align-items-center">
                                                                <div class="col-md-2">
                                                                    <label>{{__('Platform') }}</label>
                                                                    <select class="form-control form-select digital-asset-platform" name="platform" style="display: block" >
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
                                                                <div class="col-md-6 ">
                                                                    <label>{{ __('Link') }}</label>
                                                                    <input type="url" name="link" class="form-control" />
                                                                    <div class="d-md-none mb-2"></div>
                                                                </div>
                            
                                                                <div class="col-md-2">
                                                                    <br>
                                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger btn-block">
                                                                        <i class="la la-trash-o"></i>Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
        
                                                    </div>
                                                    <div class="form-group row">
                                                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary btn-block">
                                                            <i class="la la-plus"></i>Add
                                                        </a>
                                                    </div>
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
                                                            @if($publisher->team == 'influencer' && count($publisher->socialMediaLinks) > 0)
                                                                @foreach($publisher->socialMediaLinks as $item)
                                                                <div data-repeater-item class="form-group row align-items-center">
                                                                    <div class="col-md-6">
                                                                        <label>{{ __('Link') }}</label>
                                                                        <input type="url" name="link" class="form-control" value="{{ $item->link }}"/>
                                                                        <div class="d-md-none mb-2"></div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>{{__('Platform') }}</label>
                                                                        <select class="form-control form-select" name="platform" style="display: block" >
                                                                            <option {{ $item->platform=="facebook"?"selected":"" }} value="facebook">{{ __('Facebook') }}</option>
                                                                            <option {{ $item->platform=="instagram"?"selected":"" }}  value="instagram">{{ __('Instagram') }}</option>
                                                                            <option {{ $item->platform=="twitter"?"selected":"" }}  value="twitter">{{ __('Twitter') }}</option>
                                                                            <option {{ $item->platform=="snapchat"?"selected":"" }}  value="snapchat">{{ __('Snapchat') }}</option>
                                                                            <option {{ $item->platform=="tiktok"?"selected":"" }}  value="tiktok">{{ __('Tiktok') }}</option>
                                                                            <option {{ $item->platform=="youtube"?"selected":"" }}  value="youtube">{{ __('Youtube') }}</option>
                                                                            <option {{ $item->platform=="other"?"selected":"" }}  value="other">{{ __('Other') }}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>{{__('Number Of Followers') }}</label>
                                                                        <select class="form-control form-select" name="followers" style="display: block" >
                                                                            <option {{ $item->platform=="lethThan10k"?"selected":"" }} value="lethThan10k">< 10K</option>
                                                                            <option {{ $item->platform=="10Kto50K"?"selected":"" }} value="10Kto50K">10K : 50K</option>
                                                                            <option {{ $item->platform=="50Kto100K"?"selected":"" }} value="50Kto100K">50K : 100K</option>
                                                                            <option {{ $item->platform=="100Kto500K"?"selected":"" }} value="100Kto500K">100K : 500K</option>
                                                                            <option {{ $item->platform=="500Kto1M"?"selected":"" }} value="500Kto1M">500K : 1M</option>
                                                                            <option {{ $item->platform=="morethan1M"?"selected":"" }} value="morethan1M">> 1M</option>
                                                                        </select>
                                                                    </div>
            
                                                                    <div class="col-md-2">
                                                                        <br>
                                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger btn-block">
                                                                            <i class="la la-trash-o"></i>حذف
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            @else
                                                            <div data-repeater-item class="form-group row align-items-center">
                                                                <div class="col-md-6">
                                                                    <label>{{ __('Link') }}</label>
                                                                    <input type="url" name="link" class="form-control" />
                                                                    <div class="d-md-none mb-2"></div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label>{{__('Platform') }}</label>
                                                                    <select class="form-control form-select" name="platform" style="display: block" >
                                                                        <option selected="selected" value="facebook">{{ __('Facebook') }}</option>
                                                                        <option value="instagram">{{ __('Instagram') }}</option>
                                                                        <option value="twitter">{{ __('Twitter') }}</option>
                                                                        <option value="snapchat">{{ __('Snapchat') }}</option>
                                                                        <option value="tiktok">{{ __('Tiktok') }}</option>
                                                                        <option value="youtube">{{ __('Youtube') }}</option>
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
                                                            @endif
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
                                        @if($publisher->position == 'publisher')
                                        <div class="form-group row">
                                                
                                            <div class="col-lg-6">
                                                <label>{{ __('Categories') }} :</label>
                                                <select class="form-control select2" id="kt_select_categories" name="categories[]"  multiple>
                                                    @foreach ($categories as $category)
                                                        <option {{ old('categories') ? (in_array($category->id, old('categories')) ? 'selected':'') : (in_array($category->id, $publisher->categories->pluck('id')->toArray())?'selected':'')  }} value="{{ $category->id }}">{{  $category->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('categories'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('categories') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>{{ __('Referral Account Manager') }} :</label>
                                                <select class="form-control select2" id="kt_select_referral_account_manager" name="referral_account_manager" >
                                                    <option value=" ">{{ __('No One') }}</option>
                                                    @foreach ($accountManagers as $accountManager)
                                                        <option value="{{ $accountManager->id }}" {{ old('referral_account_manager') ? (old('referral_account_manager') == $accountManager->id ? "selected" : '') : ($publisher->referral_account_manager == $accountManager->id ? "selected" : "")  }}>{{ $accountManager->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('referral_account_manager'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('referral_account_manager') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                            {{-- Bank Account Details --}}
                                            <h3 class="text-center mt-20 mb-15">{{ __('Bank Account Details') }}</h3>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label>{{ __('Account Title') }} :</label>
                                                    <input type="text" name="account_title" class="form-control" value="{{old('account_title') ?? $publisher->account_title}}" />
                                                    @if ($errors->has('account_title'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('account_title') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>{{ __('Bank Name') }} :</label>
                                                    <input type="text" name="bank_name" class="form-control" value="{{old('bank_name') ?? $publisher->bank_name}}" />
                                                    @if ($errors->has('bank_name'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('bank_name') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label>{{ __('Bank Branch Code') }} :</label>
                                                    <input type="text" name="bank_branch_code" class="form-control" value="{{old('bank_branch_code') ?? $publisher->bank_branch_code}}"  />
                                                    @if ($errors->has('bank_branch_code'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('bank_branch_code') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>{{ __('Swift Code') }} :</label>
                                                    <input type="text" name="swift_code" class="form-control" value="{{old('swift_code') ?? $publisher->swift_code}}" />
                                                    @if ($errors->has('swift_code'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('swift_code') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label>{{ __('Iban') }} :</label>
                                                    <input type="text" name="iban" class="form-control" value="{{old('iban') ?? $publisher->iban}}" />
                                                    @if ($errors->has('iban'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('iban') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>{{ __('Currency') }} :</label>
                                                    <select class="form-control select2" id="kt_select_currency_id" name="currency_id">
                                                        @foreach ($currencies as $currency)
                                                            <option {{ old('currency_id')?($currency->id == old('currency_id') ?'selected': ($publisher->currency_id == $currency->id ? 'selected' : '')):''  }} value="{{ $currency->id }}">{{  $currency->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('currency_id'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('currency_id') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- End Bank Account Details --}}
                                        @endif
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
        $('#kt_select_package_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_country_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_city_id').select2({
            placeholder: "You sholud select country",
        });
        $('#kt_select_subscription_type').select2({
            placeholder: "Select Option",
        });

        $('#kt_select_categories').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_role_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_currency_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_referral_account_manager').select2({
            placeholder: "Select Referral Account Manager",
        });
        $('#kt_select_traffic_sources').select2({
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
                    $("#kt_select_referral_account_manager").html(res)
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

            $('.check-phone-exists').on('focusout', function(){
                var value = $(this).val();
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.publishers.check.exists')}}",
                    data: { column : value}, 
                })
                .done(function(res) {
                    $(".exists-phone-alert").html(res)
                });
            })
            $('.check-email-exists').on('focusout', function(){
                var value = $(this).val();
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.publishers.check.exists')}}",
                    data: { column : value}, 
                })
                .done(function(res) {
                    $(".exists-email-alert").html(res)
                });
            })
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
    <script>
        // Class definition
        var KTFormRepeater2 = function() {
        // Private functions
        var demo2 = function() {
            $('#kt_repeater_2').repeater({
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
                demo2();
            }
        };
        }();

        jQuery(document).ready(function() {
            KTFormRepeater2.init();
        });
    </script>
@endpush
