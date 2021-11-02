@extends('admin.layouts.app')
@section('title','Publishers')
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
                            <h2 class="card-title">{{ __('Publisher Name :') . $publisher->name }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        @if($publisher->coupons)
                                        @foreach($publisher->coupons as $coupon)
                                            
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>{{ __('Coupon') }}</label>
                                                <input class="form-control" disabled  value="{{$coupon->coupon}}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>{{ __('Orders') }}</label>
                                                <input class="form-control" disabled  value="{{$coupon->report->orders}}" />
                                            </div>

                                            <div class="col-lg-4">
                                                <label>{{ __('Revenue') }}</label>
                                                <input class="form-control" disabled  value="{{$coupon->report->payout}}" />
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Use Name') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->name }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Phone') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->phone}}" />
                                            </div>
                                        </div>

                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Email') }}:</label>
                                                <input class="form-control" disabled  value="{{$publisher->email }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Team') }} :</label>
                                                <input class="form-control" disabled  value="{{$publisher->team}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Position') }}:</label>
                                                <input class="form-control" disabled  value="{{$publisher->position }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Belongs To') }} :</label>
                                                <input class="form-control" disabled  value="{{$publisher->parent_id?$publisher->parent->name:'none'}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Genner') }}:</label>
                                                <input class="form-control" disabled  value="{{$publisher->gender }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Status') }} :</label>
                                                <input class="form-control" disabled  value="{{$publisher->status}}" />
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Country') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->country_id != null ? $publisher->country->name_en:"" }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('City') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->city_id !=null ? $publisher->city->name_en:""}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Years Of Experience') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->years_of_experience }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Address') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->address}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Skype') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->skype }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Category') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->category}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __(' Traffic Sources') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->traffic_sources }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Affiliate Networks') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->affiliate_networks}}" />
                                            </div>
                                        </div>
       
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Owened Digital Assets') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->owened_digital_assets }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Category') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->category}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Affiliate Networks') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->affiliate_networks }}" />
                                            </div>
                                        </div>

                                        {{-- Bank Account Details --}}
                                        <h3 class="text-center mt-20 mb-15">{{ __('Bank Account Details') }}</h3>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Account Title') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->account_title }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __(' Bank Name') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->bank_name}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Bank Branch Code') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->bank_branch_code }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Swift Code') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->swift_code}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Iban') }} </label>
                                                <input class="form-control" disabled  value="{{$publisher->iban }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Currency ') }}</label>
                                                <input class="form-control" disabled  value="{{$publisher->currency }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.publishers.index')}}">
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
