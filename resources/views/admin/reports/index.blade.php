@extends('admin.layouts.app')
@section('title','Reports')
@push('styles')
    <style>
        tr.yellow{
            background-color: yellow;
        }
        tr.red{
            background-color: red;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3>{{ __('Report') }}</h3>
                    </div>
                </div>
                {{-- Validation Data --}}
                <div class="container m-5">
                    <div class="row">
                        <div class="col-4">
                            <div class="badge badge-primary d-block">
                                <h2> Total Orders:</h2>
                                <p>{{ $totalOrders }} {{ __('Order') }}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="badge badge-primary d-block">
                                <h2> Total Sales:</h2>
                                <p>${{ $totalSales }}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="badge badge-primary d-block">
                                <h2> Total Payout:</h2>
                                <p>${{ $totalPayout }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Pending Data --}}
                <div class="container m-5">
                    <div class="row">
                        <div class="col-4">
                            <div class="badge badge-primary d-block">
                                <h2>Pending Total Orders:</h2>
                                <p>{{ $pendingTotalOrders }} {{ __('Order') }}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="badge badge-primary d-block">
                                <h2>Pending Total Sales:</h2>
                                <p>${{ $pendingTotalSales }}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="badge badge-primary d-block">
                                <h2>Pending Total Payout:</h2>
                                <p>${{ $pendingTotalPayout }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="accordion">
                        @foreach($offers as $offer)
                            <div class="card">
                            <div class="card-header" id="heading{{ $offer->id }}">
                                <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $offer->id }}" aria-expanded="true" aria-controls="collapse{{ $offer->id }}">
                                    {{ $offer->name }}
                                </button>
                                </h5>
                            </div>
                        
                            <div id="collapse{{ $offer->id }}" class="collapse" aria-labelledby="heading{{ $offer->id }}" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th scope="col">{{ _('Coupon') }}</th>
                                            <th scope="col">{{ _('Coupon Status') }}</th>
                                            <th scope="col">{{ _('Discount') }}</th>
                                            <th scope="col">{{ _('Camping') }}</th>
                                            <th scope="col">{{ _('Orders') }}</th>
                                            <th scope="col">{{ __('Sales') }}</th>
                                            <th scope="col">{{ _('Payout') }}</th>
                                            <th scope="col">{{ _('V Orders') }}</th>
                                            <th scope="col">{{ __('V Sales') }}</th>
                                            <th scope="col">{{ _('V Payout') }}</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($offer->coupons as $coupon)
                                                <tr class="{{ $coupon->report&&$coupon->report->orders <= 20 && $coupon->report->orders > 10 ? 'yellow':'' }} {{ $coupon->report&&$coupon->report->orders <= 10 ? 'red' :'' }}">
                                                    <td>{{ $coupon->coupon }}</td>
                                                    <td>{{ $coupon->report&&$coupon->report->orders > 1 ?'Active':'None Active' }}</td>
                                                    <td>{{ $offer->discount }} {{ $offer->discount_type=='flat'?$offer->currency->code:'%' }}</td>
                                                    <td>{{ $offer->name }}</td>
                                                    <td>{{ $coupon->report?$coupon->report->orders:0 }}</td>
                                                    <td>{{ $coupon->report?$coupon->report->sales:0 }}</td>
                                                    <td>{{ $coupon->report?$coupon->report->payout:0 }}</td>
                                                    <td>{{ $coupon->report?$coupon->report->v_orders:0 }}</td>
                                                    <td>{{ $coupon->report?$coupon->report->v_sales:0 }}</td>
                                                    <td>{{ $coupon->report?$coupon->report->v_payout:0 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                            </div>
                        @endforeach
                      </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

