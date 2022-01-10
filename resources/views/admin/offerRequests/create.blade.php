@extends('admin.layouts.app')
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
                            <h2 class="card-title">{{ __('Create New Request') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.offerRequests.store')}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                    <div class="alert-icon">
                                        <i class="flaticon2-bell-5"></i>
                                    </div>
                                    <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span>
                                                <i class="ki ki-close"></i>
                                            </span>
                                    </button>
                                    </div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>{{ _('User') }} :</label>
                                                <select class="form-control select2 update-coupons" id="kt_select_user_id" name="user_id" required>
                                                    <option value="">{{ __('No One') }}</option>
                                                    @foreach($users as $user)
                                                        <option {{old('user_id')==$user->id?"selected":""}} value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('user_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('user_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* {{ _('Offer') }} :</label>
                                                <select class="form-control select2 update-coupons" id="kt_select_offer_id" name="offer_id" required >
                                                    @foreach($offers as $offer)
                                                        <option {{old('offer_id')==$offer->id?"selected":""}} value="{{$offer->id}}">{{$offer->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('offer_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('offer_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" required>
                                                    <option {{ old('status')=="pending"?"selected":"" }} value="pending">{{ __('Pending') }}</option>
                                                    <option {{ old('status')=="approved"?"selected":"" }} value="approved">{{ __('Approved') }}</option>
                                                    <option {{ old('status')=="rejected"?"selected":"" }} value="rejected">{{ __('Rejected') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div id="coupons"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ __("Submit") }}</button>
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
@push('scripts')
    <script>
        $('#kt_select_offer_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_user_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_status').select2({
            placeholder: "Select Option",
        });
    </script>

<script>
    $(document).ready(function(){

            var offerId = $("#kt_select_offer_id").val();
            var userId = $("#kt_select_user_id").val();
            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('admin.offerRequest.ajax.coupons')}}",
                data: { 
                    offer_id: offerId,
                    user_id: userId
                }, 
            })
            .done(function(res) {
                console.log(res);
                $("#coupons").html(res)
            });


        $(".update-coupons").on("change",function(){
            var offerId = $("#kt_select_offer_id").val();
            var userId = $("#kt_select_user_id").val();
            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{route('admin.offerRequest.ajax.coupons')}}",
                data: { 
                    offer_id: offerId,
                    user_id: userId
                }, 
            })
            .done(function(res) {
                console.log(res);
                $("#coupons").html(res)
            });
        });
    });


</script>

@endpush
