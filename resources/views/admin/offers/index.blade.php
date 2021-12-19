@extends('admin.layouts.app')@section('title','Offers')
@push('styles')
    <style>
        table.dataTable {
            table-layout: auto;
            height: auto;
        }
        table.dataTable tr th,
        table tr td {
            width: auto;
        }
        table.dataTable tr th:first-child,
        table.dataTable tr td:first-child {
            max-width: 30px;
        }
        .thumbnail img {
            vertical-align: middle;
            border-style: none;
            max-width: 90px;
            max-height: 50px;
            height: auto;
            display: block;
            width: 100% !important;
        }
        table.dataTable thead tr,
        table.dataTable tbody tr {
            z-index: 1;

        }
    </style>
@endpush
@php
    $columns = [
        ['name'=> 'id', 'label' => __('ID')],
        ['name'=> 'thumbnail', 'label' => __('Thumbnail')],
        ['name'=> 'offer', 'label' => __('Offer')],
        ['name'=> 'status', 'label' => __('Status'), 'checked' => true],
        ['name'=> 'payout', 'label' => __('Payout'), 'checked' => true],
        ['name'=> 'target_market', 'label' => __('Target Market')],
        ['name'=> 'discount', 'label' => __('Discount')],
        ['name'=> 'action', 'label' => __('Actions'), 'checked' => true],
    ];
    $thead = '';
@endphp
@section('content')
    @foreach($columns as $key=>$column)
        @php $thead .= '<th>'.$column['label'].'</th>' @endphp
    @endforeach
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div id="modal"></div>
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <h3 class="card-label">Offers</h3>
                </div>
                <div class="card-body">
                    <table id="publisherTable" class="display dataTable no-footer" data-columns="{!! htmlspecialchars(json_encode($columns)) !!}">
                        <thead>
                        <tr>
                            {!! $thead !!}
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($offers)> 0)
                            @foreach($offers as $offer)
                                {{-- @dd($offer->thumbnail) --}}
                                <tr>
                                    <td>{{$offer->id}}</td>
                                    <td>
                                        <a class="thumbnail show-offer" href="{{ route('admin.offers.show', $offer->id) }}">
                                            <img class="card-img-top" src="{{getImagesPath('Offers', $offer->thumbnail)}}" alt="{{ $offer->name }}">
                                        </a>
                                    </td>
                                    <td>{{ $offer->name }}</td>
                                    <td>{{ __('Online') }}</td>
                                    <td>                     @if($offer->cps_type == 'static')

                                            {{$offer->revenu}}
                                        @elseif($offer->cps_type == 'new_old')
                                            new_old
                                            {{-- <p>{{ __('New Payout:') . $offer->newOld->new_payout }}</p>
                                            <p>{{ __('Old Payout:') . $offer->newOld->old_payout }}</p> --}}
                                        @elseif($offer->cps_type == 'slaps')
                                            slaps
                                            {{-- @dd($offer->slaps) --}}
                                        @endif</td>
                                    <td>@foreach($offer->countries as $country) {{$country->name_en}} @if(!$loop->last),@endif @endforeach</td>
                                    <td>  {{ $offer->discount }} {{ $offer->discount_type == 'percentage'?'%':'' }}</td>
                                    <td>
                                        @if(in_array($offer->id, $offerRequestsArray))
                                            {{-- Check if request is exists --}}
                                            @if(getOfferRequest($offer->id))
                                                {{-- Check if status approved --}}
                                                @if(getOfferRequest($offer->id)->status=='approved')
                                                    @if($offer->type == 'link_tracking')
                                                        <button class="rounded view-coupons btn btn-success btn-xs mr-2" data-offer="{{ $offer->id }}">{{ __('View Links') }}</button>
                                                    @else
                                                        <button class="rounded view-coupons btn btn-success btn-xs mr-2" data-offer="{{ $offer->id }}">{{ __('View Coupons') }}</button>
                                                    @endif
                                                @endif
                                                {{-- Check if status pending --}}
                                                @if(getOfferRequest($offer->id)->status=='pending')
                                                    <button class="rounded btn btn-primary btn-xs mr-2">{{ __('In Review') }}</button>
                                                @endif
                                                {{-- check if status rejected --}}
                                                @if(getOfferRequest($offer->id)->status=='rejected')
                                                    <button class="rounded btn btn-danger btn-xs mr-2">{{ __('Rejected') }}</button>
                                                @endif
                                            @endif
                                        @else
                                            @if($offer->type == 'link_tracking')
                                                <button class="rounded requestOffer btn btn-warning btn-xs mr-2" data-modal="{{ 'modal'.$offer->id }}"  data-offer="{{ $offer->id }}">{{ __('Request Link') }}</button>
                                            @elseif($offer->type == 'coupon_tracking')
                                                <button class="rounded requestOffer btn btn-warning btn-xs mr-2" data-modal="{{ 'modal'.$offer->id }}"  data-offer="{{ $offer->id }}">{{ __('Request Coupons') }}</button>
                                            @endif
                                        @endif
                                        @if($update)
                                            <a class="edit-offer btn btn-icon btn-success btn-xs mr-2" href="{{ route('admin.offers.edit', $offer->id) }}"><i class="fas fa-pen"></i></a>
                                        @endif
                                        <a class="show-offer btn btn-icon btn-success btn-xs" href="{{ route('admin.offers.show', $offer->id) }}"><i class="fas fa-eye"></i></a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <div class="alert alert-warning d-block text-center">{{ __('No Offers Yet') }}</div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')
    <script type="text/javascript">
 
        $(document).ready(function () {
            // Loade MOdal
            $(".requestOffer").click(function () {
                var offerId = $(this).data('offer');
                $.ajax({
                    method: "GET",
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.offerRequest.ajax.form')}}",
                    data: {
                        offer_id: offerId,
                    },
                })
                .done(function (res) {
                    console.log(res);
                    $('#modal').html(res);
                })
            });

            // Close Modal
            $(".close-modal").click(function () {
                $('.modal').css('display', 'none');
            });

            // Send Request
            $(".request-codes").click(function () {
                var offerId = $(this).data('offer');
                $.ajax({
                    method: "POST",
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.offerRequest.ajax')}}",
                    data: {
                        offerId: offerId,
                    },
                })
                    .done(function (res) {
                        $(".request-codes").addClass('btn-success');
                        $(".request-codes").removeClass('btn-primary');
                        $(".request-codes").text('Success.');
                        $(".requestOffer").text('In Review.');
                        $(".requestOffer").removeClass('requestOffer');
                        $('.modal').fadeOut('slow');
                    })
                    .fail(function (res) {
                        $(".request-codes").addClass('btn-danger');
                        $(".request-codes").removeClass('btn-primary');
                        $(".request-codes").text('You have sent request before.');
                        $(".requestOffer").text('In Review.');
                        $(".requestOffer").removeClass('requestOffer');
                        setTimeout(function () {
                            $('.modal').fadeOut('slow');
                        }, 3000);


                    });
            });

            // Send Request
            $(".view-coupons").click(function () {
                var offerId = $(this).data('offer');
                $.ajax({
                    method: "POST",
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.ajax.view.coupons')}}",
                    data: {
                        offerId: offerId,
                    },
                })
                    .done(function (response) {
                        $("#coupons").html(response);
                    })
                    .fail(function (response) {
                    });
            });


        });
    </script>
@endpush
