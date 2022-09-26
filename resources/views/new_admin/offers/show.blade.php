@extends('new_admin.layouts.app')
@push('styles')
    <style>
        table tr {
            border-bottom: 1px dashed #eee !important;
        }
        
    </style>
@endpush
@section('content')
    <!--begin::Row-->
    <div id="overview" class="tab">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header d-flex justify-content-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title text-center">
                    <h2 class="mb-9">{{ $offer->name }}</h2>
                </div>
            </div>
            <!--begin::Body-->
            <div class="card-body py-10">
                <div class="me-7 mb-4 m-auto text-center">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ asset('new_dashboard') }}/media/avatars/300-1.jpg" alt="image" />
                    </div>
                </div>

                <table class="table">
                    <tr>
                        <td><strong>{{ __('Name') }} : </strong></td>
                        <td>{{ $offer->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Description') }} : </strong></td>
                        <td>{{ $offer->description }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Advertiser') }} : </strong></td>
                        <td>{{ $offer->advertiser ? $offer->advertiser->company_name : '' }}</td>
                    </tr>
                    @if ($offer->offer_url)
                        <tr>
                            <td><strong>{{ __('Offer URL') }} : </strong></td>
                            <td><a href="{{ $offer->offer_url }}">{{ $offer->offer_url }}</a></td>
                        </tr>
                    @endif
                    @if ($offer->categories->count() > 0)
                        <tr>
                            <td><strong>{{ __('Category') }} : </strong></td>
                            <td>
                                @foreach ($offer->categories as $category)
                                    <span class="badge badge-light m-1">{{ $category->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if ($offer->countries->count() > 0)
                        <tr>
                            <td><strong>{{ __('Geo`s') }} : </strong></td>
                            <td>
                                @foreach ($offer->countries as $country)
                                    <span class="badge badge-light m-1">{{ $country->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if ($offer->payout_type)
                        <tr>
                            <td><strong>{{ __('Payout Type') }} : </strong></td>
                            <td>{{ $offer->payout_type }}</td>
                        </tr>
                    @endif
                    @if ($offer->default_payout)
                        <tr>
                            <td><strong>{{ __('Payout Default') }} : </strong></td>
                            <td>{{ $offer->default_payout }}</td>
                        </tr>
                    @endif
                    @if ($offer->discount)
                        <tr>
                            <td><strong>{{ __('Discount') }} : </strong></td>
                            <td>{{ $offer->discount }}
                                {{ $offer->discount_type == 'percentage' ? '%' : ($offer->currency ? $offer->currency->code : '') }}
                            </td>
                        </tr>
                    @endif
                    @if ($offer->expire_date)
                        <tr>
                            <td><strong>{{ __('Expire Date') }} : </strong></td>
                            <td>{{ $offer->expire_date }}</td>
                        </tr>
                    @endif
                    @if ($offer->status)
                        <tr>
                            <td><strong>{{ __('Status') }} : </strong></td>
                            <td>
                                @if ($offer->status == 'active')
                                    <span class="badge badge-success">Active</span>
                                @elseif ($offer->status == 'pused')
                                    <span class="badge badge-warning">Pused</span>
                                @elseif ($offer->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($offer->status == 'expire')
                                    <span class="badge badge-danger">Expire</span>
                                @else
                                @endif
                            </td>
                        </tr>
                    @endif
                    @if ($offer->note)
                    <tr>
                        <td><strong>{{ __('Note') }} : </strong></td>
                        <td>{{ $offer->note }}</td>
                    </tr>
                    @endif
                    @if ($offer->terms_and_conditions)
                    <tr>
                        <td><strong>{{ __('Terms And Conditions') }} : </strong></td>
                        <td>{{ $offer->terms_and_conditions }}</td>
                    </tr>
                    @endif

                </table>
            </div>
            <!--end::Body-->
        </div>
    </div>
    <!--End::Row-->
@endsection
@push('scripts')
@endpush
