@extends('admin.layouts.app')
@push('styles')
    <style>
        .list-group li {
            list-style: none;
            margin-bottom: 10px;
        }
    </style>

@endpush
@section('title','Offers')
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

                            <h2 class="card-title">{{ __('Offer Name :') . $offer->name }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="mb-2">
                                            <div class="col-12 text-center">
                                                <div class="image-input image-input-outline image-input" id="kt_image">
                                                    <div class="image-input-wrapper"  style="background-image: url( {{getImagesPath('Offers', $offer->thumbnail)}}" ></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label> {{ __('Name') }} :</label>
                                                    <input readonly disabled type="text" class="form-control"  value="{{$offer->name}}" required/>
                                                </div>
    
                                                <div class="col-lg-6">
                                                    <label> {{ __('Advertiser') }} :</label>
                                                    <input readonly disabled type="text" class="form-control"  value="{{$offer->advertiser?$offer->advertiser->company_name:''}}" required/>
                                                </div>
    
                                            </div>
    
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <label> {{ __('Description') }} :</label>
                                                    <textarea readonly disabled class="form-control" cols="30" rows="10">{{$offer->description}}</textarea>
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label> {{ __('Website') }} :</label>
                                                    <a class="form-control" href="{{$offer->website}}">{{ $offer->website}}</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label> {{ __('Offer URL') }} :</label>
                                                    <a class="form-control" href="{{$offer->offer_url}}">{{ $offer->offer_url}}</a>
                                                </div>
    
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label> {{ __('Category') }} :</label>
                                                    <input readonly disabled type="text" class="form-control" value="{{$offer->category}}" />
                                                </div>
                                                <div class="col-lg-6">
                                                    <label> {{ __('Country') }} :</label>
                                                    <input readonly disabled type="text" class="form-control" value="{{$offer->country?$offer->country->name_en:''}}" />
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label> {{ __('Payout Type') }} :</label>
                                                    <input readonly disabled type="text" class="form-control" value="{{$offer->payout_type}}" />
                                                </div>
                                                <div class="col-lg-6">
                                                    <label> {{ __('Payout Default') }} :</label>
                                                    <input readonly disabled type="number" class="form-control" value="{{$offer->default_payout}}" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label> {{ __('Expire Date') }} :</label>
                                                    <input readonly disabled type="date" class="form-control" value="{{$offer->expire_date}}" />
                                                </div>
                                                <div class="col-lg-6">
                                                    <label> {{ __('Status') }} :</label>
                                                    <input readonly disabled type="date" class="form-control" value="{{$offer->status}}" />

                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <label> {{ __('Note') }} :</label>
                                                    <textarea disabled readonly class="form-control" cols="30" rows="10">{{$offer->note}}</textarea>
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <label> {{ __('Terms And Conditions') }} :</label>
                                                    <textarea disabled readonly class="form-control" cols="30" rows="10">{{$offer->terms_and_conditions}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-label">
                                    {{ __('Showing Offer') }}
                                    <small class="ml-2">{{$offer->name}}</small>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-xs btn-success font-weight-bold">{{ __('Edit') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="text-dark-50">{{ __('Name') }} : <strong class="text-dark">{{$offer->name}}</strong></li>
                                <li class="text-dark-50">{{ __('Advertiser') }} : <strong class="text-dark">{{$offer->advertiser->name}}</strong></li>
                                <li class="text-dark-50">{{ __('Description') }} : <strong class="text-dark">{{$offer->description}}</strong></li>
                                <li class="text-dark-50">{{ __('Website') }} : <a href="{{$offer->website}}"><strong class="text-dark">{{ $offer->website}}</strong></a></li>
                                <li class="text-dark-50">{{ __('Offer URL') }} : <a href="{{$offer->offer_url}}"><strong class="text-dark">{{ $offer->offer_url}}</strong></a></li>
                                <li class="text-dark-50">{{ __('Category') }} : <strong class="text-dark">{{$offer->category}}</strong></li>
                                <li class="text-dark-50">{{ __('Country') }} : <strong class="text-dark">{{$offer->country?$offer->country->name_en:''}}</strong></li>
                                <li class="text-dark-50">{{ __('Payout Type') }} : <strong class="text-dark">{{$offer->payout_type}}</strong></li>
                                <li class="text-dark-50">{{ __('Payout Default') }} : <strong class="text-dark">{{$offer->default_payout}}</strong></li>
                                <li class="text-dark-50">{{ __('Expire Date') }} : <strong class="text-dark">{{$offer->expire_date}}</strong></li>
                                <li class="text-dark-50">{{ __('Status') }} : <strong class="text-dark">{{$offer->status}}</strong></li>
                                <li class="text-dark-50">{{ __('Note') }} :  <strong class="text-dark">{{$offer->note}}</strong></li>
                                <li class="text-dark-50">{{ __('Terms And Conditions') }} :{{$offer->terms_and_conditions}}</li></li>
                            </ul>
                        <!--begin::Form-->
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
