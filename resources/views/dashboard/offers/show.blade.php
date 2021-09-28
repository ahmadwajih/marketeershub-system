@extends('dashboard.layouts.app')
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
                                                    <div class="image-input-wrapper"  style="background-image: url( {{asset("Images/Offers/").$offer->thumbnail}}" ></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label> {{ __('Name') }} :</label>
                                                    <input readonly disabled type="text" class="form-control"  value="{{$offer->name}}" required/>
                                                </div>
    
                                                <div class="col-lg-6">
                                                    <label> {{ __('Advertiser') }} :</label>
                                                    <input readonly disabled type="text" class="form-control"  value="{{$offer->advertiser->name}}" required/>
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
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('dashboard.advertisers.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                {{ __('Back') }}
                                            </button>
                                        </a>
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
