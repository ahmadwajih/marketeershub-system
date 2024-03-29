@extends('admin.layouts.app')@section('title','Offers')
@push('styles')
    <style>
        .display-none {
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
                    <form class="form new-form" id="kt_form" action="{{route('admin.offers.update',$offer->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="card-icon">
                                        <div class="form-group d-flex flex-center w-50px h-50px mr-2 mb-0">
                                            <div class="image-input image-input-outline image-input-circle" id="kt_image">
                                                <div class="image-input-wrapper w-50px h-50px rounded" style="background-image: url({{getImagesPath('Offers', $offer->thumbnail)}})"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Upload image">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg, .svg"/>
                                                    {{-- <input type="hidden" name="profile_avatar_remove" /> --}}
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Delete image">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                            </div>
                                            @if ($errors->has('thumbnail'))
                                                <div>
                                                    <p class="invalid-input">{{ $errors->first('thumbnail') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <h3 class="card-label">
                                        {{ __('Company Name') }} <small class="ml-2">{{ $offer->company_name }}</small>
                                    </h3>
                                </div>
                            </div>
                            <!--begin::Form-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        @if ($errors->any())
                                            <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg">
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
          
                                                    <div class="col-md-12">
                                                        <label>* {{ __('Offer Name') }} :</label>
                                                        <input type="text" name="name_en" class="form-control" value="{{old('name_en') ?? $offer->name_en}}"/>
                                                        @if ($errors->has('name_en'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('name_en') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>* {{ __('Partener') }} :</label>
                                                        <select class="form-control select2" id="kt_select_partener" name="partener">
                                                            <option {{ old('partener')=='none' || $offer->partener=='none'?'selected':''  }} value="none">{{  __('No One') }}</option>
                                                            <option {{ old('partener')=='salla'|| $offer->partener=='salla'?'selected':''  }} value="salla">{{  __('Salla') }}</option>
                                                        </select>
                                                        @if ($errors->has('partener'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('partener') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12" id='sallaUserEmail' @if(old('partener') == null && $offer->partener != 'salla') style="display: none" @endif @if(old('partener') != null && old('partener') != 'salla') style="display: none" @endif>
                                                        <label>* {{ __('Your email in salla') }} :</label>
                                                        <input type="text" name="salla_user_email" class="form-control" placeholder="Add the email that you registerd by it in Salla" value="{{old('salla_user_email') ?? $offer->salla_user_email}}"/>
                                                        @if ($errors->has('salla_user_email'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('salla_user_email') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>* {{ __('Advertiser') }} :</label>
                                                        <select class="form-control select2" id="kt_select_advertiser_id" name="advertiser_id" required>
                                                            <option selected value="">{{ __('No one') }}</option>
                                                            @foreach ($advertisers as $advertiser)
                                                                <option {{ old('advertiser_id')==$advertiser->id||$offer->advertiser_id==$advertiser->id?'selected':''  }} value="{{ $advertiser->id }}">{{  $advertiser->company_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('advertiser_id'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('advertiser_id') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <label>Description :</label>
                                                        <textarea class="form-control" name="description_en" cols="30" rows="10">{{old('description_en') ?? $offer->description_en}}</textarea>
                                                        @if ($errors->has('description_en'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('description_en') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label>* {{ __('Offer URL') }} :</label>
                                                        <input type="url" name="offer_url" class="form-control" value="{{old('offer_url') ?? $offer->offer_url}}"/>
                                                        @if ($errors->has('offer_url'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('offer_url') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <label>* {{ __('Categories') }} :</label>
                                                        <select class="form-control select2" id="kt_select_categories" name="categories[]" multiple>
                                                            @foreach ($categories as $category)
                                                                <option {{ old('categories') ? (in_array($category->id, old('categories')) ? 'selected':'') : (in_array($category->id, $offer->categories->pluck('id')->toArray())?'selected':'')  }} value="{{ $category->id }}">{{  $category->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('categories'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('categories') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label>* {{ _('Geo`s') }} :</label>
                                                        <select class="form-control select2" id="kt_select_countries" name="countries[]" multiple>
                                                            @foreach($countries as $country)
                                                                <option {{ old('countries')?(in_array($country->id, old('countries'))?'selected':''):(in_array($country->id, $offer->countries->pluck('id')->toArray())?"selected":"")}} value="{{$country->id}}">{{$country->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('countries'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('countries') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <label>* {{ _('Type') }} :</label>
                                                        <select class="form-control select2" id="kt_select_type" name="type">
                                                            <option {{ old('type')=='coupon_tracking' || $offer->type=='coupon_tracking'?'selected':''  }} value="coupon_tracking">{{ __('Coupon Tracking') }}</option>
                                                            <option {{ old('type')=='link_tracking' || $offer->type=='link_tracking'?'selected':''  }} value="link_tracking">{{ __('Link Tracking') }}</option>
                                                        </select>
                                                        @if ($errors->has('type'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('type') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">

                                                    <div class="col-md-12">
                                                        <label>* {{ __('CPS Type') }} :</label>
                                                        <select class="form-control select2" id="kt_select_cps_type" name="cps_type">
                                                            <option {{ old('cps_type')=="static"?"selected":($offer->cps_type=="static"?'selected':'') }} value="static">{{ __('Static') }}</option>
                                                            <option {{ old('cps_type')=="new_old"?"selected":($offer->cps_type=="new_old"?"selected":"") }} value="new_old">{{ __('New old') }}</option>
                                                            <option {{ old('cps_type')=="slaps"?"selected":($offer->cps_type=="slaps"?"selected":"") }} value="slaps">{{ __('Slaps') }}</option>
                                                        </select>
                                                        @if ($errors->has('cps_type'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('cps_type') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class=" {{ old('cps_type')&&old('cps_type')!="static"?"display-none":($offer->cps_type!="static"?"display-none":"") }}" id="static">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Revenue Type') }} :</label>
                                                            <select class="form-control select2" id="kt_select_revenue_type" name="revenue_type">
                                                                <option {{ old('revenue_type')=="flat"?"selected":($offer->revenue_type=="flat"?"selected":"") }} value="flat">{{ __('Flat') }}</option>
                                                                <option {{ old('revenue_type')=="percentage"?"selected":($offer->revenue_type=="percentage"?"selected":"") }} value="percentage">{{ __('Percentage') }}</option>
                                                            </select>
                                                            @if ($errors->has('revenue_type'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('revenue_type') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Revenu') }} :</label>
                                                            <input type="number" step="0.1" name="revenue" class="form-control" value="{{old('revenue') ?? $offer->revenue}}"/>
                                                            @if ($errors->has('revenue'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('revenue') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Payout Type') }} :</label>
                                                            <select class="form-control select2" id="kt_select_payout_type" name="payout_type">
                                                                <option {{ old('payout_type')=="flat"?"selected":($offer->payout_type=="flat"?"selected":"") }} value="flat">{{ __('Flat') }}</option>
                                                                <option {{ old('payout_type')=="percentage"?"selected":($offer->payout_type=="percentage"?"selected":"") }} value="percentage">{{ __('Percentage') }}</option>
                                                            </select>
                                                            @if ($errors->has('payout_type'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('payout_type') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Payout') }} :</label>
                                                            <input type="number" step="0.1" name="payout" class="form-control" value="{{old('payout') ?? $offer->payout}}"/>
                                                            @if ($errors->has('payout'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('payout') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="{{ old('cps_type')&&old('cps_type')!="new_old"?"display-none":($offer->cps_type!="new_old"?"display-none":"") }}" id="oldNew">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label>* {{ __('New Revenue Type') }} :</label>
                                                            <select class="form-control select2" id="kt_select_new_revenue_type" name="new_revenue_type">
                                                                <option {{ old('new_revenue_type')=="flat"?"selected":($offer->newOld&&$offer->newOld->new_revenue_type=="flat"?"selected":"") }} value="flat">{{ __('Flat') }}</option>
                                                                <option {{ old('new_revenue_type')=="percentage"?"selected":($offer->newOld&&$offer->newOld->new_revenue_type=="percentage"?"selected":"") }} value="percentage">{{ __('Percentage') }}</option>
                                                            </select>
                                                            @if ($errors->has('new_revenue_type'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('new_revenue_type') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>* {{ __('New Revenue') }} :</label>
                                                            <input type="number" step="0.1" name="new_revenue" placeholder="5" class="form-control" value="{{old('new_revenue') ? old('new_revenue') : ($offer->newOld ? $offer->newOld->new_revenue:'') }}"/>
                                                            @if ($errors->has('new_revenue'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('new_revenue') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label>* {{ __('New Payout Type') }} :</label>
                                                            <select class="form-control select2" id="kt_select_new_payout_type" name="new_payout_type">
                                                                <option {{ old('new_payout_type')=="flat"?"selected":($offer->newOld&&$offer->newOld->new_payout_type=="flat"?"selected":"") }} value="flat">{{ __('Flat') }}</option>
                                                                <option {{ old('new_payout_type')=="percentage"?"selected":($offer->newOld&&$offer->newOld->new_payout_type=="percentage"?"selected":"") }} value="percentage">{{ __('Percentage') }}</option>
                                                            </select>
                                                            @if ($errors->has('new_payout_type'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('new_payout_type') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>* {{ __('New Payout') }} :</label>
                                                            <input type="number" step="0.1" name="new_payout" placeholder="10" class="form-control" value="{{old('new_payout') ? old('new_payout') : ($offer->newOld ? $offer->newOld->new_payout:'') }}"/>
                                                            @if ($errors->has('new_payout'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('new_payout') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Old Revenue Type') }} :</label>
                                                            <select class="form-control select2" id="kt_select_old_revenue_type" name="old_revenue_type">
                                                                <option {{ old('old_revenue_type')=="flat"?"selected":($offer->newOld&&$offer->newOld->old_revenue_type=="flat"?"selected":"") }} value="flat">{{ __('Flat') }}</option>
                                                                <option {{ old('old_revenue_type')=="percentage"?"selected":($offer->newOld&&$offer->newOld->old_revenue_type=="percentage"?"selected":"") }} value="percentage">{{ __('Percentage') }}</option>
                                                            </select>
                                                            @if ($errors->has('old_revenue_type'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('old_revenue_type') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Old Revenue') }} :</label>
                                                            <input type="number" step="0.1" name="old_revenue" placeholder="5" class="form-control" value="{{old('old_revenue') ? old('old_revenue') : ($offer->newOld ? $offer->newOld->old_revenue:'') }}"/>
                                                            @if ($errors->has('old_revenue'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('old_revenue') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Old Payout Type') }} :</label>
                                                            <select class="form-control select2" id="kt_select_old_payout_type" name="old_payout_type">
                                                                <option {{ old('old_payout_type')=="flat"?"selected":($offer->newOld&&$offer->newOld->old_payout_type=="flat"?"selected":"") }} value="flat">{{ __('Flat') }}</option>
                                                                <option {{ old('old_payout_type')=="percentage"?"selected":($offer->newOld&&$offer->newOld->old_payout_type=="percentage"?"selected":"") }} value="percentage">{{ __('Percentage') }}</option>
                                                            </select>
                                                            @if ($errors->has('old_payout_type'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('old_payout_type') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label>* {{ __('Old Payout') }} :</label>
                                                            <input type="number" step="0.1" name="old_payout" placeholder="10" class="form-control" value="{{old('old_payout') ? old('old_payout') : ($offer->newOld ? $offer->newOld->old_payout:'') }}"/>
                                                            @if ($errors->has('old_payout'))
                                                                <div>
                                                                    <p class="invalid-input">{{ $errors->first('old_payout') }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row {{ old('cps_type')&&old('cps_type')!="slaps"?"display-none":($offer->cps_type!="slaps"?"display-none":"") }}" id="slaps">
                                                    <div id="kt_repeater_1">
                                                        <div class="form-group row" id="kt_repeater_1">
                                                            <label class="col-form-label text-right"><b>{{ __('Slaps') }}</b></label>
                                                            <div data-repeater-list="slaps" class="col-lg-12">
                                                                @if(old('cps_type') == 'slaps' || $offer->cps_type=="slaps")
                                                                    @if(old('cps_type') == 'slaps')
                                                                        @php
                                                                            $slaps = old('slaps');
                                                                            $old = true;
                                                                        @endphp
                                                                    @elseif($offer->cps_type=="slaps")
                                                                        @php
                                                                            $slaps = $offer->slaps;
                                                                            $old = true;
                                                                        @endphp
                                                                    @endif

                                                                    @foreach($slaps as $slap)
                                                                        <div data-repeater-item class="form-group row align-items-center">
                                                                            <div class="col-12">
                                                                                <h3>{{ __('Slap') }}</h3></div>
                                                                            <div class="col-md-4">
                                                                                <label>{{__('Orders Type') }}</label>
                                                                                <select class="form-control form-select" name="slap_type" style="display: block">
                                                                                    <option {{ $old ? ($slap['slap_type']=='number_of_orders'?'selected':''):($slap->slap_type=='number_of_orders'?'selected':'') }} value="number_of_orders">{{{ __('Number Of Orders') }}}</option>
                                                                                    <option {{ $old ? ($slap['slap_type']=='ammount_of_orders'?'selected':''):($slap->slap_type=='ammount_of_orders'?'selected':'') }} value="ammount_of_orders">{{{ __('Ammount Of Orders') }}}</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label>{{ __('From') }}</label>
                                                                                <input type="number" name="from" class="form-control" placeholder="1" value="{{ $old?$slap['from']:$slap->from }}"/>
                                                                                <div class="d-md-none mb-2"></div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label>{{ __('To') }}</label>
                                                                                <input type="number" name="to" class="form-control" placeholder="1" value="{{ $old?$slap['to']:$slap->to }}"/>
                                                                                <div class="d-md-none mb-2"></div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label>{{ __('Revenue') }}</label>
                                                                                <input type="number" name="revenue" class="form-control" placeholder="1" value="{{ $old?$slap['revenue']:$slap->revenue }}"/>
                                                                                <div class="d-md-none mb-2"></div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label>{{ __('Payout') }}</label>
                                                                                <input type="number" name="payout" class="form-control" placeholder="1" value="{{ $old?$slap['payout']:$slap->payout }}"/>
                                                                                <div class="d-md-none mb-2"></div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <br>
                                                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger btn-block">
                                                                                    <i class="la la-trash-o"></i>حذف
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary btn-block">
                                                                <i class="la la-plus"></i>إضافة </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label>* {{ _('Offer Discount Type') }} :</label>
                                                        <select class="form-control select2" id="kt_select_discount_type" name="discount_type">
                                                            <option {{old('discount_type')=='flat'?'selected':($offer->discount_type=='flat'?'selected':'')}} value="flat">{{ __('Flat') }}</option>
                                                            <option {{old('discount_type')=='percentage'?'selected':($offer->discount_type=='percentage'?'selected':'')}} value="percentage">{{ __('Percentage') }}</option>
                                                        </select>
                                                        @if ($errors->has('discount_type'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('discount_type') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>* {{ __('Offer Discount') }} :</label>
                                                        <input type="number" step="0.1" name="discount" class="form-control" value="{{old('discount')??$offer->discount}}"/>
                                                        @if ($errors->has('discount'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('discount') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label>* {{ __('Currency') }} :</label>
                                                        <select class="form-control select2" id="kt_select_currency_id" name="currency_id" required>
                                                            <option selected value="">{{ __('No one') }}</option>
                                                            @foreach ($currencies as $currency)
                                                                <option {{ old('currency_id')==$currency->id||$offer->currency_id==$currency->id?'selected':''  }} value="{{ $currency->id }}">{{  $currency->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('currency_id'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('currency_id') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label>{{ __('Expire Date') }} :</label>
                                                        <input type="date" name="expire_date" class="form-control" value="{{old('expire_date') ?? $offer->expire_date}}"/>
                                                        @if ($errors->has('expire_date'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('expire_date') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>* {{ __('Status') }} :</label>
                                                        <select class="form-control select2" id="kt_select_status" name="status">
                                                            <option {{ old('status')=="pending"||$offer->status=="pending"?"selected":"" }} value="pending">{{ __('Pending') }}</option>
                                                            <option {{ old('status')=="active"||$offer->status=="active"?"selected":"" }} value="active">{{ __('Active') }}</option>
                                                            <option {{ old('status')=="pused"||$offer->status=="pused"?"selected":"" }} value="pused">{{ __('Paused') }}</option>
                                                        </select>
                                                        @if ($errors->has('status'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <label>{{ __('Note') }} :</label>
                                                        <textarea class="form-control" name="note" cols="30" rows="10">{{old('note') ?? $offer->note}}</textarea>
                                                        @if ($errors->has('note'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('note') }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <label>{{ __('Offer Restrictions') }} :</label>
                                                        <textarea class="form-control" name="terms_and_conditions_en" cols="30" rows="10">{{old('terms_and_conditions_en') ?? $offer->terms_and_conditions_en}}</textarea>
                                                        @if ($errors->has('terms_and_conditions_en'))
                                                            <div>
                                                                <p class="invalid-input">{{ $errors->first('terms_and_conditions_en') }}</p>
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
                                </div>
                            </div>
                            <!--end::Form-->
                        </div>
                    </form>
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
        $('#kt_select_partener').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_advertiser_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_currency_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_countries').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_city_id').select2({
            placeholder: "You sholud select country",
        });
        $('#kt_select_categories').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_revenue_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_payout_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_cps_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_discount_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_new_revenue_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_new_payout_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_old_revenue_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_old_payout_type').select2({
            placeholder: "Select Option",
        });

    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script>
        // Class definition
        var KTFormRepeater = function () {
            // Private functions
            var demo1 = function () {
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
                init: function () {
                    demo1();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTFormRepeater.init();
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#kt_select_cps_type").change(function () {
                if ($(this).val() == 'new_old') {
                    $('#oldNew').fadeIn();
                    $('#static').fadeOut();
                    $('#slaps').fadeOut();
                }
                if ($(this).val() == 'static') {
                    $('#static').fadeIn();
                    $('#slaps').fadeOut();
                    $('#oldNew').fadeOut();
                }
                if ($(this).val() == 'slaps') {
                    $('#slaps').fadeIn();
                    $('#static').fadeOut();
                    $('#oldNew').fadeOut();
                }
            });

            $("#kt_select_partener").change(function () {
                if ($(this).val() == 'salla') {
                    $('#sallaUserEmail').fadeIn();
                }else{
                    $('#sallaUserEmail').fadeOut();
                }
            });
        });
    </script>
@endpush
