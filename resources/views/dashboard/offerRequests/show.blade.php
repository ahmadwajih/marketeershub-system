@extends('dashboard.layouts.app')
@section('title','Offer Request')
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
                            <h2 class="card-title">{{ __('Request') . $offerRequest->id }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">

                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>{{ __('User Name') }}</label>
                                                <input class="form-control" disabled  value="{{$offerRequest->user?$offerRequest->user->name:''}}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>{{ __('Offer') }}</label>
                                                <input class="form-control" disabled  value="{{$offerRequest->offer->name}}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>{{ __('Status') }}</label>
                                                <input class="form-control" disabled  value="{{$offerRequest->status }}" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('dashboard.offerRequests.index')}}">
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
