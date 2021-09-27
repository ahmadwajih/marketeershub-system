@extends('dashboard.layouts.app')
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
                            <h2 class="card-title">{{ __('Comppany Name :') . $advertiser->company_name }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Company Name') }}</label>
                                                <input class="form-control" disabled  value="{{$advertiser->company_name }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Responsible Name') }}</label>
                                                <input class="form-control" disabled  value="{{$advertiser->name}}" />
                                            </div>
                                        </div>

                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Phone') }}</label>
                                                <input class="form-control" disabled  value="{{$advertiser->phone}}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Email') }}:</label>
                                                <input class="form-control" disabled  value="{{$advertiser->email }}" />
                                            </div>

                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Country') }}</label>
                                                <input class="form-control" disabled  value="{{$advertiser->country_id != null ? $advertiser->country->name_en:"" }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('City') }}</label>
                                                <input class="form-control" disabled  value="{{$advertiser->city_id !=null ? $advertiser->city->name_en:""}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Status') }} :</label>
                                                <input class="form-control" disabled  value="{{$advertiser->status}}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Address') }}</label>
                                                <input class="form-control" disabled  value="{{$advertiser->address}}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>{{ __('Website') }} :</label>
                                                <a class="form-control" target="_blank"  href="{{$advertiser->website}}">{{$advertiser->website}}</a>
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
