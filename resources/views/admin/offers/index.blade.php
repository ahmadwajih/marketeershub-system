@extends('admin.layouts.app')
@section('title','Offers')
@push('styles')
    <style>
        .card-footer{
            padding: 10px;
        }
        .card-footer .rounded{
            border: 1px solid #ddd;
            border-radius: 50%;
            background-color: #Dfd;
            padding: 5px 10px
        }
        .modal{
            /* display: block; */
            overflow: scroll;
            background: #05032a30;
        }
        .modal .modal-body{
            /* background: #ddd; */
            font-size: 14px;
            color: #000;
        }
        .modal .modal-footer button{
            width: 100%
        }
        .modal .close i{
            font-size: 24px !important;
        }
        .modal .modal-footer{
            padding: 5px;
        }
        .edit-offer{
            position: absolute;
            right: 5px;
            background: #1e1e2d;
            width: 30px;
            height: 30px;
            text-align: center;
            top: 37px;
            line-height: 33px;

            border-radius: 50%;
        }
        .edit-offer i{
            color: #fff;
        }
        .show-offer{
            position: absolute;
            right: 5px;
            background: #1e1e2d;
            width: 30px;
            height: 30px;
            text-align: center;
            border-radius: 50%;
            top: 5px;
            line-height: 32px;

        }
        .show-offer i{
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div id="coupons"></div>

            <div class="row">
                @if(count($offers)> 0)
                @foreach($offers as $offer)
                    {{-- @dd($offer->thumbnail) --}}
                    <div class="col-3">
                        <div class="card-deck">
                            <div class="card">
                                @if($update)<a class="edit-offer" href="{{ route('admin.offers.edit', $offer->id) }}"><i class="fas fa-pen"></i></a>@endif
                                <a class="show-offer" href="{{ route('admin.offers.show', $offer->id) }}"><i class="fas fa-eye"></i></a>
                            <img class="card-img-top" src="{{getImagesPath('Offers', $offer->thumbnail)}}" alt="{{ $offer->name }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title font-weight-bold">{{ $offer->name }}</h4>
                                    <p class="card-title font-weight-bold">{{ __('Target Market:') }} @foreach($offer->countries as $country) {{$country->name_en}} @if(!$loop->last),@endif @endforeach</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="card-title font-weight-bold">{{ __('Payout:') }}
                                        @if($offer->cps_type == 'static')
                                            {{$offer->revenu}}
                                        @elseif($offer->cps_type == 'new_old')
                                        new_old
                                            {{-- <p>{{ __('New Payout:') . $offer->newOld->new_payout }}</p>
                                            <p>{{ __('Old Payout:') . $offer->newOld->old_payout }}</p> --}}
                                        @elseif($offer->cps_type == 'slaps')
                                        slaps
                                        {{-- @dd($offer->slaps) --}}
                                        @endif
                                    </p>

                                    <p class="card-title font-weight-bold">{{ __('Discount:') }}
                                        {{ $offer->discount }} {{ $offer->discount_type == 'percentage'?'%':'' }}
                                    </p>
                                </div>
                                
                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <div class="rounded">{{ __('Online') }}</div>
                                    {{-- Check if this offer was requested by current login user --}}
                                    @if(in_array($offer->id, $offerRequestsArray))
                                        {{-- Check if request is exists --}}
                                        @if(getOfferRequest($offer->id))
                                            {{-- Check if status approved --}}
                                            @if(getOfferRequest($offer->id)->status=='approved')
                                                @if($offer->type == 'link_tracking')
                                                    <button class="rounded view-coupons" data-offer="{{ $offer->id }}">{{ __('View Links') }}</button>
                                                @else
                                                    <button class="rounded view-coupons" data-offer="{{ $offer->id }}">{{ __('View Coupons') }}</button>
                                                @endif

                                            @endif
                                            {{-- Check if status pending --}}
                                            @if(getOfferRequest($offer->id)->status=='pending')
                                                <button class="rounded">{{ __('In Review') }}</button>
                                            @endif
                                            {{-- check if status rejected --}}
                                            @if(getOfferRequest($offer->id)->status=='rejected')
                                                <button class="rounded">{{ __('Rejected') }}</button>
                                            @endif
                                        @endif
                                    @else
                                        @if($offer->type == 'link_tracking')
                                            <button class="rounded requestOffer" data-modal="{{ 'modal'.$offer->id }}">{{ __('Request Link') }}</button>
                                        @elseif($offer->type == 'coupon_tracking')
                                            <button class="rounded requestOffer" data-modal="{{ 'modal'.$offer->id }}">{{ __('Request Coupons') }}</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal" tabindex="-1" role="dialog" id='modal{{ $offer->id }}'>
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">{{ __('To Continue you must agree to the T&Cs') }}</h5>
                              <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                                <i class="far fa-times-circle"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="english" dir="ltr">
                                    <h2>Restrictions</h2>
                                    <ul>
                                        <li>You may not bid on any of the <b>{{ $offer->name }}</b> terms or variations in paid search ads, such as Google Adwords, Google PPC, and FaceBook Ads.</li>
                                        <li>You may not use the <b>{{ $offer->name }}</b> name or any of its variations in pop-ups and pop-unders, as the name of your newsletter, in retargeting campaigns, in your app push notifications ads, or in wrong or misleading messages.</li>
                                        <li>You may not use methods such as cookie stuffing.</li>
                                        <li>ou may not promote <b>{{ $offer->name }}</b> in any sexually explicit materials, violent materials, libelous or defamatory materials, or any illegal activities.</li>
                                        <li>You may not promote <b>{{ $offer->name }}</b> if you employ discriminatory practices, based on race, sex, religion, nationality, disability, sexual orientation, or age.</li>
                                        <li>You may not use a link to <b>{{ $offer->name }}</b> which includes a redirecting link, that is generated or displayed on a Search Engine in response to a general Internet keyword search query, whether those links appear through your submission of data to that site or otherwise.</li>
                                    </ul>
                                </div>
                                <div class="arabic text-right" dir="rtl">
                                    <h2>تقييدات</h2>
                                    <ul>
                                        <li>لا يحق لك المُزايدة على أي من عبارات ومُصطلحات <b>{{ $offer->name }}</b> المدفوعة مُسبقًا على شبكة البحث, مثل- Google Adwords, Google PPC و إعلانات فيسبوك.</li>
                                        <li>لا يجوز لك استخدام اسم <b>{{ $offer->name }}</b> أو أي من أشكاله في نوافذ الإعلانات المُنبثقة في الأعلى وفي الخلف, مثل اسم نشرتك الإعلانية لإعادة توجيه الحملات, في إعلانات تطبيق إشعارات الدّفع, أو من خلال رسائل خاطئة ومُضلّلة.</li>
                                        <li>لا يجوز لك استخدام أساليب كحشو الْــ cookie.</li>
                                        <li>للا يجوز لك التّرويج لِـــ <b>{{ $offer->name }}</b> في أي مواد جنسية واضحة أو مواد عنيفة أو مواد تشهيريّة أو أي افتراء أو نشاط غير قانوني.</li>
                                        <li>لا يجوز لك التّرويج لِـــ <b>{{ $offer->name }}</b> إذا كنت تستخدم عادات تمييزية, على أساس العرق, الجنس, الدين, القومية, الإعاقة الجسدية, التوجّه الجنسي أو العمر.</li>
                                        <li>للا يجوز لك استخدام رابط لِــ <b>{{ $offer->name }}</b> يحتوي على رابط إعادة توجيه, يتم إنشاؤه أو عرضه على مُحرّك البحث استجابة لطلب بحث الكلمة الرئيسيّة على الانترنت, سواء كانت هذه الروابط تظهر خلال إرسال المعلومات إلى الموقع أو غير ذلك.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                @if($offer->type == 'link_tracking')
                                <button type="button" class="btn btn-primary request-codes" data-offer="{{ $offer->id }}">{{ __('Request Link') }}</button>
                                @elseif($offer->type == 'coupon_tracking')
                                <button type="button" class="btn btn-primary request-codes" data-offer="{{ $offer->id }}">{{ __('Request Codes') }}</button>
                                @endif

                            </div>
                          </div>
                        </div>
                      </div>
                @endforeach
                @else
                      <div class="col-12"><div class="alert alert-warning d-block text-center">{{ __('No Offers Yet') }}</div></div>
                @endif
            </div>
            
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')
    <script type="text/javascript">

        $(document).ready(function(){
            // Loade MOdal 
            $(".requestOffer").click(function(){
                var modal = $(this).data('modal');
                $('#'+modal).fadeIn('slow');
            });

            // Close Modal
            $(".close-modal").click(function(){
                $('.modal').css('display', 'none');
            });

            // Send Request
            $(".request-codes").click(function(){
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
                .done(function(res) {
                        $(".request-codes").addClass('btn-success');
                        $(".request-codes").removeClass('btn-primary');
                        $(".request-codes").text('Success.');
                        $(".requestOffer").text('In Review.');
                        $(".requestOffer").removeClass('requestOffer');
                        $('.modal').fadeOut('slow');
                })
                .fail(function(res){
                    $(".request-codes").addClass('btn-danger');
                    $(".request-codes").removeClass('btn-primary');
                    $(".request-codes").text('You have sent request before.');
                    $(".requestOffer").text('In Review.');
                    $(".requestOffer").removeClass('requestOffer');
                    setTimeout(function(){ $('.modal').fadeOut('slow'); }, 3000);

                    
                });
            });

            // Send Request
            $(".view-coupons").click(function(){
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
                .done(function(response) {
                        $("#coupons").html(response);
                })
                .fail(function(response){
                });
            });

            
        });
    </script>
@endpush
