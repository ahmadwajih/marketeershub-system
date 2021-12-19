@extends('admin.layouts.app')
@push('styles')
    <style>
        .card-body .list-group li {
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
                            <div class="card-title">
                                <div class="card-icon">
                                    <div class="bg-radial-gradient-success d-flex flex-center w-50px h-50px mr-2 rounded" style="background-image: url( {{asset("Images/Offers/").$offer->thumbnail}}" ></div>
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
