@extends('admin.layouts.app')
@push('styles')
    <style>
        .card-body .list-group li {
            list-style: none;
            margin-bottom: 10px;
        }
        .offer-request-modal .modal-dialog {
            max-width: 960px;
        }
    </style>
@endpush
@section('title','Offers')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div id="coupons"></div>

            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="card-icon">
                                    <div class="bg-radial-gradient-success d-flex flex-center w-50px h-50px mr-2 rounded" style="background-image: url( {{  getImagesPath('Offers', $offer->thumbnail)}}); background-size: cover;" ></div>
                                </div>
                                <h3 class="card-label">
                                    {{ __('Showing Offer') }}
                                    <small class="ml-2">{{$offer->name}}</small>
                                </h3>
                            </div>
                            @can('update_offers')
                                <div class="card-toolbar">
                                    <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-xs btn-success font-weight-bold">{{ __('Edit') }}</a>
                                </div>
                            @endcan

                            @if(auth()->user()->position == 'publisher')
                                <div class="card-toolbar">
                                    @can('create_offer_requests')
                                        @if($offerRequest)
                                            {{-- Check if status approved --}}
                                            @if($offerRequest->status=='approved')
                                                @if($offer->type == 'link_tracking')
                                                    <button class="rounded view-coupons btn btn-success btn-xs mr-2" data-offer="{{ $offer->id }}">{{ __('View Links') }}</button>
                                                @else
                                                    <button class="rounded view-coupons btn btn-success btn-xs mr-2" data-offer="{{ $offer->id }}">{{ __('View Coupons') }}</button>
                                                @endif
                                            @endif
                                            {{-- Check if status pending --}}
                                            @if($offerRequest->status=='pending')
                                                <button class="rounded btn btn-primary btn-xs mr-2">{{ __('Your Request In Review') }}</button>
                                            @endif
                                            {{-- check if status rejected --}}
                                            @if($offerRequest->status=='rejected')
                                                <button class="rounded btn btn-danger btn-xs mr-2">{{ __('Your request has been rejected') }}</button>
                                            @endif
                                        
                                        @else
                                            @if($offer->type == 'link_tracking')
                                                <button class="rounded requestOffer btn btn-warning btn-xs mr-2" data-offer="{{ $offer->id }}" data-modal="{{ 'modal'.$offer->id }}">{{ __('Request Link') }}</button>
                                            @elseif($offer->type == 'coupon_tracking')
                                                <button class="rounded requestOffer btn btn-warning btn-xs mr-2 request-coupons" data-offer="{{ $offer->id }}">{{ __('Request Coupons') }}</button>
                                            @endif
                                        @endif
                                    @endcan
                                </div>
                            @endif

                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="text-dark-50">{{ __('Name') }} : <strong class="text-dark">{{$offer->name}}</strong></li>
                                <li class="text-dark-50">{{ __('Advertiser') }} : <strong class="text-dark">{{$offer->advertiser?$offer->advertiser->company_name:''}}</strong></li>
                                <li class="text-dark-50">{{ __('Description') }} : <strong class="text-dark">{{$offer->description}}</strong></li>
                                @if($offer->website)<li class="text-dark-50">{{ __('Website') }} : <a href="{{$offer->website}}"><strong class="text-dark">{{ $offer->website}}</strong></a></li>@endif
                                @if($offer->offer_url)<li class="text-dark-50">{{ __('Offer URL') }} : <a href="{{$offer->offer_url}}"><strong class="text-dark">{{ $offer->offer_url}}</strong></a></li>@endif
                                @if($offer->categories->count() > 0)
                                <li class="text-dark-50">{{ __('Category') }} : 
                                    @foreach($offer->categories as $category)
                                        <span class="badge badge-light m-1">{{ $category->title }}</span>
                                    @endforeach
                                </li>
                                @endif
                                @if($offer->countries->count() > 0)
                                <li class="text-dark-50">{{ __('Country') }} : 
                                    @foreach($offer->countries as $country)
                                        <span class="badge badge-light m-1">{{ $country->name }}</span>
                                    @endforeach
                                </li>
                                @endif
                                @if($offer->payout_type)<li class="text-dark-50">{{ __('Payout Type') }} : <strong class="text-dark">{{$offer->payout_type}}</strong></li>@endif
                                @if($offer->default_payout)<li class="text-dark-50">{{ __('Payout Default') }} : <strong class="text-dark">{{$offer->default_payout}}</strong></li>@endif
                                @if($offer->expire_date)<li class="text-dark-50">{{ __('Expire Date') }} : <strong class="text-dark">{{$offer->expire_date}}</strong></li>@endif
                                @if($offer->status)<li class="text-dark-50">{{ __('Status') }} : <strong class="text-dark">{{$offer->status}}</strong></li>@endif
                                @if($offer->note)<li class="text-dark-50">{{ __('Note') }} :  <strong class="text-dark">{{$offer->note}}</strong></li>@endif
                                @if($offer->terms_and_conditions)<li class="text-dark-50">{{ __('Terms And Conditions') }} :{{$offer->terms_and_conditions}}</li></li>@endif
                            </ul>
                        <!--begin::Form-->
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
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
                                    @foreach(getActivity('Offer',$offer->id ) as $activity)
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
        // $(".requestOffer").click(function () {
        //     var modal = $(this).data('modal');
        //     $('#' + modal).fadeIn('slow');
        // });

        // Close Modal
        $("body").on('click', '.close-modal', function ()  {
            $('.modal').fadeOut('slow');
        });

        // Send CouponsRequest
        $(".requestOffer").click(function () {
            var $self = $(this);
            var offerId = $self.data('offer');
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
                    $(".requestOffer").removeClass('requestOffer');
                    $(res).insertAfter('#kt_footer')
                        .addClass('offer-request-modal').fadeIn('slow')
                        .end()
                        .next('.modal')
                        .remove();
                })
        });
    // Send Request
    $(".view-coupons").click(function () {
        var offerId = $(this).data('offer');
        $.ajax({
            method: "POST",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{route('admin.offerRequest.ajax.view.coupons')}}",
            data: {
                offer_id: offerId,
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
