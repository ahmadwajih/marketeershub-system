@extends('admin.layouts.app')@section('title', 'Offers')
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

        .thumbnail {
            border: 1px solid #eaeaea;
            display: block;
            width: 60px;
            height: 60px;
            margin: 4px 0;
            line-height: 50px;
            overflow: hidden;
        }

        .thumbnail img {
            vertical-align: middle;
            border-style: none;
            width: 100%;
            height: auto;
            display: inline-block;
        }

        table.dataTable thead tr,
        table.dataTable tbody tr {
            z-index: 1;
        }

        .offer-request-modal .modal-dialog {
            max-width: 960px;
        }
        .swal2-popup{
            width: 74em !important;
        }
        .swal2-container .swal2-html-container {
            max-height: 100%;
        }
    </style>
@endpush
@php
$columns = [['name' => 'thumbnail', 'label' => __('Thumbnail')], ['name' => 'offer', 'label' => __('Offer')], ['name' => 'status', 'label' => __('Status'), 'checked' => true], ['name' => 'payout', 'label' => __('Payout'), 'checked' => true], ['name' => 'target_market', 'label' => __('Target Market')], ['name' => 'discount', 'label' => __('Discount')], ['name' => 'action', 'label' => __('Actions'), 'checked' => true]];
$thead = '';
@endphp
@section('content')
    @foreach ($columns as $key => $column)
        @php $thead .= '<th>'.$column['label'].'</th>' @endphp
    @endforeach
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div id="coupons"></div>

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
                            @if (count($offers) > 0)
                                @foreach ($offers as $offer)
                                    {{-- @dd($offer->thumbnail) --}}
                                    <tr>
                                        {{-- <td>{{ $offer->id }}</td> --}}
                                        <td>
                                            <a class="thumbnail show-offer"
                                                href="{{ route('admin.offers.show', $offer->id) }}">
                                                <img class="card-img-top"
                                                    src="{{ getImagesPath('Offers', $offer->thumbnail) }}"
                                                    alt="{{ $offer->name }}">
                                            </a>
                                        </td>
                                        <td>{{ $offer->name }}</td>
                                        <td>
                                            @if($offer->status == 'active')
                                                <span class="label label-success label-inline mr-2">{{ __('Live') }}</span>
                                            @else
                                                <span class="label label-danger label-inline mr-2">{{ ucfirst($offer->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($offer->cps_type == 'static')
                                                {{ $offer->revenu }}
                                            @elseif($offer->cps_type == 'new_old')
                                                New & Old
                                                {{-- <p>{{ __('New Payout:') . $offer->newOld->new_payout }}</p>
                                            <p>{{ __('Old Payout:') . $offer->newOld->old_payout }}</p> --}}
                                            @elseif($offer->cps_type == 'slaps')
                                                Slaps
                                                {{-- @dd($offer->slaps) --}}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($offer->countries as $country)
                                                {{ $country->name_en }} @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td> {{ $offer->discount }}{{ $offer->discount_type == 'percentage' ? '%' : '' }}
                                        </td>
                                        <td>
                                            @can('create_offer_requests')
                                                @if (in_array($offer->id, $offerRequestsArray))
                                                    {{-- Check if request is exists --}}
                                                    @if (getOfferRequest($offer->id))
                                                        {{-- Check if status approved --}}
                                                        @if (getOfferRequest($offer->id)->status == 'approved')
                                                            @if ($offer->type == 'link_tracking')
                                                                <button class="rounded view-coupons btn btn-success btn-xs mr-2"
                                                                    data-offer="{{ $offer->id }}">{{ __('View Links') }}</button>
                                                            @else
                                                                <button class="rounded view-coupons btn btn-success btn-xs mr-2"
                                                                    data-offer="{{ $offer->id }}">{{ __('View Coupons') }}</button>
                                                            @endif
                                                        @endif
                                                        {{-- Check if status pending --}}
                                                        @if (getOfferRequest($offer->id)->status == 'pending')
                                                            <button
                                                                class="rounded btn btn-primary btn-xs mr-2 in-review-btn" onclick="cancelOfferRequest({{ getOfferRequest($offer->id)->id }})">{{ __('In Review') }}</button>
                                                        @endif
                                                        {{-- check if status rejected --}}
                                                        @if (getOfferRequest($offer->id)->status == 'rejected')
                                                            <button
                                                                class="rounded btn btn-danger btn-xs mr-2">{{ __('Rejected') }}</button>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($offer->type == 'link_tracking')
                                                        <button class="rounded requestOffer btn btn-warning btn-xs mr-2"
                                                            data-offer="{{ $offer->id }}"
                                                            data-modal="{{ 'modal' . $offer->id }}">{{ __('Request Link') }}</button>
                                                    @elseif($offer->type == 'coupon_tracking')
                                                        <button
                                                            class="rounded requestOffer btn btn-warning btn-xs mr-2 request-coupons"
                                                            data-offer="{{ $offer->id }}">{{ __('Request Coupons') }}</button>
                                                    @endif
                                                @endif
                                            @endcan
                                            @can('update_offers')
                                                <a class="edit-offer btn btn-icon btn-success btn-xs mr-2"
                                                    href="{{ route('admin.offers.edit', $offer->id) }}"><i
                                                        class="fas fa-pen"></i></a>
                                            @endcan
                                            <a class="show-offer btn btn-icon btn-success btn-xs"
                                                href="{{ route('admin.offers.show', $offer->id) }}"><i
                                                    class="fas fa-eye"></i></a>
                                            @can('delete_offers')
                                                <button class="delete btn btn-icon btn-danger btn-xs mr-2"
                                                    data-offer="{{ $offer->id }}"><i class="fas fa-trash"></i></button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <div class="alert alert-warning d-block text-center">{{ __('No Offers Yet') }}
                                        </div>
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
        $(document).ready(function() {

            // Close Modal
            $("body").on('click', '.close-modal', function() {
                $('.modal').fadeOut('slow');
            });



            // Send CouponsRequest
            $(".requestOffer").click(function() {
                var $self = $(this);
                var offerId = $self.data('offer');
                $.ajax({
                        method: "GET",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('admin.offerRequest.ajax.form') }}",
                        data: {
                            offer_id: offerId,
                        },
                    })
                    .done(function(res) {
                        $(".requestOffer").removeClass('requestOffer');
                        $(res).insertAfter('#kt_footer')
                            .addClass('offer-request-modal').fadeIn('slow')
                            .end()
                            .next('.modal')
                            .remove();
                    })
            });
            // Send Request
            $(".view-coupons").click(function() {
                var offerId = $(this).data('offer');
                $.ajax({
                        method: "POST",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('admin.offerRequest.ajax.view.coupons') }}",
                        data: {
                            offer_id: offerId,
                        },
                    })
                    .done(function(response) {
                        $("#coupons").html(response);
                    })
                    .fail(function(response) {});
            });

        });
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete').on('click', function() {
                var offerId = $(this).data('offer');
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: '{{ "You won`t be able to revert this!" }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#dd3333',
                    confirmButtonText: '{{ __('Yes, Delete!') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('admin.offers.index') }}/" + offerId,
                            error: function(err) {
                                if (err.hasOwnProperty('responseJSON')) {
                                    if (err.responseJSON.hasOwnProperty('message')) {
                                        swal.fire({
                                            title: "Error !",
                                            text: err.responseJSON.message,
                                            confirmButtonText: "Ok",
                                            icon: "error",
                                            confirmButtonClass: "btn font-weight-bold btn-primary",
                                        });
                                    }
                                }
                            }
                        }).done(function(res) {
                            Swal.fire({
                                text: "Deleted successfully ",
                                confirmButtonText: "Okay",
                                icon: "success",
                                confirmButtonClass: "btn font-weight-bold btn-primary",
                            }).then((result) => {
                                location.reload();
                            });

                        });

                    }
                })
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.in-review-btn').mouseover(function(){
               $(this).text('Canel');
            });
            $('.in-review-btn').mouseleave(function(){
               $(this).text('In Review');
            });

        })

        // cancel offer request 
        function cancelOfferRequest(offerRequestId){
            Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: '{{ "You won`t be able to revert this!" }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#dd3333',
                    confirmButtonText: '{{ __('Yes, Cancel!') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('admin.offerRequests.index') }}/" + offerRequestId,
                            error: function(err) {
                                if (err.hasOwnProperty('responseJSON')) {
                                    if (err.responseJSON.hasOwnProperty('message')) {
                                        Swal.fire({
                                            title: "Error !",
                                            text: err.responseJSON.message,
                                            confirmButtonText: "Ok",
                                            icon: "error",
                                            confirmButtonClass: "btn font-weight-bold btn-primary",
                                        });
                                    }
                                }
                            }
                        }).done(function(res) {
                            Swal.fire({
                                text: "Canceled successfully ",
                                confirmButtonText: "Okay",
                                icon: "success",
                                confirmButtonClass: "btn font-weight-bold btn-primary",
                            }).then((result) => {
                                location.reload();
                            });

                        });

                    }
                })
        }
    </script>
@endpush
