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
                        {{-- <form class="form"> --}}
                            {{-- @csrf --}}
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        
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

                                        @can('view_user_activities')
                                        <div class="card card-custom example example-compact">
                                            <div class="card-header">
                                                <h2 class="card-title">{{ __('User Activities') }} </h2>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered text-center">
                                                    <thead>
                                                      <tr>
                                                        <th scope="col">{{ __('Mission') }}</th>
                                                        <th scope="col">{{ __('Updated By') }}</th>
                                                        <th scope="col">{{ __('Created At') }}</th>
                                                        <th scope="col">{{ __('Show History') }}</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(getActivity('User',$publisher->id ) as $activity)
                                                            <tr>
                                                                <td>{{ $activity->mission }}</td>
                                                                <td> <a href="{{ route('admin.users.show',  $activity->user_id) }}" target="_blank" >{{ $activity->user->name }}</a> </td>
                                                                <td>{{ $activity->created_at }}</td>
                                                                <td>
                                                                    @if(unserialize($activity->history))
                                                                    <button class="btn btn-success show-history" data-id="{{ $activity->id }}">{{ __('Show') }}</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                  </table>
                                            </div>
                                        </div>
                                        @endcan

                                         <!--begin::Profile 4-->
                                        <div class="d-flex flex-row">
                                            <!--begin::Content-->
                                            <div class="flex-row-fluid ">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <!--begin::Base Table Widget 1-->
                                                        <div class="card card-custom card-stretch gutter-b">
                                                            <!--begin::Header-->
                                                            <div class="card-header border-0 pt-5">
                                                                <h3 class="card-title align-items-start flex-column">
                                                                    <span class="card-label font-weight-bolder text-dark">{{ __('Active Offers') }}</span>
                                                                    <span class="text-muted mt-3 font-weight-bold font-size-sm">{{ __('More than') }} {{ count($publisher->offers) }} {{ __('offer') }}</span>
                                                                </h3>
                                                                {{-- <div class="card-toolbar">
                                                                    <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                                                        <li class="nav-item">
                                                                            <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_1">Month</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_2">Week</a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_1_3">Day</a>
                                                                        </li>
                                                                    </ul>
                                                                </div> --}}
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Body-->
                                                            <div class="card-body pt-2 pb-0">
                                                                <!--begin::Table-->
                                                                <div class="table-responsive">
                                                                    <table class="table table-borderless table-vertical-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="p-0">{{ __('Thumbnail') }}</th>
                                                                                <th class="p-0">{{ __('Offer') }}</th>
                                                                                <th class="p-0">{{ __('Total Orders') }}</th>
                                                                                <th class="p-0">{{ __('Total Sales') }}</th>
                                                                                <th class="p-0">{{ __('Total Revenue') }}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($publisher->offers as $offer)
                                                                            {{-- @dd($offer); --}}
                                                                            <tr>
                                                                                <td class="pl-0 py-5">
                                                                                    <div class="symbol symbol-50 symbol-light mr-2">
                                                                                        <span class="symbol-label">
                                                                                            <img src="{{ getImagesPath('Offers', $offer->thumbnail) }}" class="h-50 align-self-center" alt="" />
                                                                                        </span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="pl-0">
                                                                                    <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $offer->name }}</a>
                                                                                    <span class="text-muted font-weight-bold d-block">{{ $offer->description }}</span>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex flex-column w-100 mr-2">
                                                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                                                            <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrdersCount->sum('orders') }}</span>
                                                                                            {{-- <span class="text-muted font-size-sm font-weight-bold">Progress</span> --}}
                                                                                        </div>
                                                                                        {{ __('order') }}
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex flex-column w-100 mr-2">
                                                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                                                            <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrdersCount->sum('v_sales') }} {{ $offer->currency?$offer->currency->sign:__('SAR') }}</span>
                                                                                            {{-- <span class="text-muted font-size-sm font-weight-bold">Progress</span> --}}
                                                                                        </div>
                                                                                        {{ __('sales') }}
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex flex-column w-100 mr-2">
                                                                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                                                                            <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrdersCount->sum('v_payout') }} {{ $offer->currency?$offer->currency->sign:__('SAR') }}</span>
                                                                                        </div>
                                                                                        {{ __('revenue') }}
                                                                                    </div>
                                                                                </td>

                                                                            </tr>
                                                                            @endforeach
                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::Base Table Widget 1-->
                                                    </div>
                                                    {{-- <div class="col-lg-6">
                                                        <!--begin::Charts Widget 3-->
                                                        <div class="card card-custom card-stretch gutter-b">
                                                            <!--begin::Header-->
                                                            <div class="card-header h-auto border-0">
                                                                <div class="card-title py-5">
                                                                    <h3 class="card-label">
                                                                        <span class="d-block text-dark font-weight-bolder">Recent Orders</span>
                                                                        <span class="d-block text-muted mt-2 font-size-sm">More than 500+ new orders</span>
                                                                    </h3>
                                                                </div>
                                                                <div class="card-toolbar">
                                                                    <ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
                                                                        <li class="nav-item">
                                                                            <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_1">
                                                                                <span class="nav-text font-size-sm">Month</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_2">
                                                                                <span class="nav-text font-size-sm">Week</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-item">
                                                                            <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_3">
                                                                                <span class="nav-text font-size-sm">Day</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Body-->
                                                            <div class="card-body">
                                                                <div id="kt_charts_widget_3_chart"></div>
                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Charts Widget 3-->
                                                    </div> --}}
                                                </div>
                                                <!--end::Row-->
                                                <!--begin::Advance Table Widget 8-->
                                                <div class="card card-custom gutter-b">
                                                    <!--begin::Header-->
                                                    <div class="card-header border-0 py-5">
                                                        <h3 class="card-title align-items-start flex-column">
                                                            <span class="card-label font-weight-bolder text-dark">{{ __("Coupons") }}</span>
                                                            <span class="text-muted mt-3 font-weight-bold font-size-sm">{{ __('More than') }} {{ $publisher->coupons->count() }} {{ __('coupon') }}</span>
                                                        </h3>
                                                        {{-- <div class="card-toolbar">
                                                            <a href="#" class="btn btn-success font-weight-bolder font-size-sm">
                                                            <span class="svg-icon svg-icon-md svg-icon-white">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                                        <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                        <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>Add New Member</a>
                                                        </div> --}}
                                                    </div>
                                                    <!--end::Header-->
                                                    <div class="card-body">
                                                        <div id="accordion">
                                                            @foreach($publisher->offers as $offer)
                                                                <div class="card">
                                                                <div class="card-header" id="heading{{ $offer->id }}">
                                                                    <h5 class="mb-0">
                                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $offer->id }}" aria-expanded="true" aria-controls="collapse{{ $offer->id }}">
                                                                        {{ $offer->name }}
                                                                    </button>
                                                                    </h5>
                                                                </div>
                                                            
                                                                <div id="collapse{{ $offer->id }}" class="collapse" aria-labelledby="heading{{ $offer->id }}" data-parent="#accordion">
                                                                    <div class="card-body pt-0 pb-3">
                                                                        <!--begin::Table-->
                                                                        <div class="table-responsive">
                                                                            <table class="table table-head-custom table-head-bg table-vertical-center table-borderless">
                                                                                <thead>                                            
                                                                                    
                                                                                    <tr class="bg-gray-100 text-left">
                                                                                        <th style="min-width: 50px" class="pl-7">
                                                                                            <span class="text-dark-75">{{ __('Coupon') }}</span>
                                                                                        </th>
                                                                                        <th scope="col">{{ __('Coupon Status') }}</th>
                                                                                        <th scope="col">{{ __('Discount') }}</th>
                                                                                        <th scope="col">{{ __('Orders') }}</th>
                                                                                        <th scope="col">{{ __('Sales') }}</th>
                                                                                        <th scope="col">{{ __('Revenue') }}</th>
                                                                                        <th scope="col">{{ __('V Orders') }}</th>
                                                                                        <th scope="col">{{ __('V Sales') }}</th>
                                                                                        <th scope="col">{{ __('V Revenue') }}</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($publisher->coupons  as $coupon)
                                                                                    <tr>
                                                                                        <td class="pl-0 py-8">
                                                                                            <div class="d-flex align-items-center">
                                                                                                <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                                                                    <div class="symbol-label" style="background-image: url('{{ getImagesPath('Offers', $offer->thumbnail) }}')"></div>
                                                                                                </div>
                                                                                                <div>
                                                                                                    <a href="javascript:void(0)" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $coupon->coupon }}</a>
                                                                                                    <span class="text-muted font-weight-bold d-block">{{ $offer->name }}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            @if($coupon->report&&$coupon->report->orders > 1)
                                                                                                <span class="label label-lg label-success label-inline">{{ __('Active') }}</span>
                                                                                            @else
                                                                                                <span class="label label-lg label-danger label-inline">{{ __('Unactive') }}</span>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->discount }} {{ $offer->discount_type=='flat'?($offer->currency?$offer->currency->code:''):'%' }}</span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->orders:0 }}</span>
                                                                                            <span class="text-muted font-weight-bold">{{ __('order') }}</span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->sales:0 }}</span>
                                                                                        </td>
                                                                                        <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->payout:0 }} </span></td>
                                                                                        <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->v_orders:0 }} </span></td>
                                                                                        <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->v_sales:0 }} </span></td>
                                                                                        <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->v_payout:0 }} </span></td>
                                                                                    </tr>
                                                                                    @endforeach
                                        
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <!--end::Table-->
                                                                    </div>
                                                                    <!--end::Body-->
                                                                </div>
                                                                <!--begin::Body-->
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <!--end::Advance Table Widget 8-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Profile 4-->
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
                        {{-- </form> --}}
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

@endpush
