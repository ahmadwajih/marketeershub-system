@extends('admin.layouts.app')
@section('title','Offer Requests')
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
                            <h2 class="card-title"> {{ __('Request') }} {{ $offerRequest->id }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.offerRequests.update',$offerRequest->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                        <ul>
                                            @foreach($errors->all() as $error )
                                                <li>{{$error}}</li>
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
                                                <select class="form-control select2" id="kt_select_user_id" name="user_id" disabled readonly >
                                                    @foreach($users as $user)
                                                        <option {{old('user_id')==$user->id?'selected':($offerRequest->user_id==$user->id?"selected":"")}} value="{{$user->id}}">{{$user->name}}</option>
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
                                                <select class="form-control select2" id="kt_select_offer_id" name="offer_id" disabled readonly >
                                                    @foreach($offers as $offer)
                                                        <option {{old('offer_id')==$offer->id?'selected':($offerRequest->offer_id==$offer->id?"selected":"")}} value="{{$offer->id}}">{{$offer->name}}</option>
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
                                                    <option {{ old('status')=="pending"||$offerRequest->status=="pending"?"selected":"" }} value="pending">{{ __('Pending') }}</option>
                                                    <option {{ old('status')=="approved"||$offerRequest->status=="approved"?"selected":"" }} value="approved">{{ __('Approved') }}</option>
                                                    <option {{ old('status')=="rejected"||$offerRequest->status=="rejected"?"selected":"" }} value="rejected">{{ __('Rejected') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                        @if($offerRequest->offer->type == 'coupon_tracking')
                                        <div class="form-group row">
                                            <div class="col-lg-8" style="max-height: 400px !important;overflow: scroll;">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        @foreach($offerRequest->offer->coupons as $coupon)
                                                            <tr>
                                                                <td width="2%"><input type="checkbox"  {{ $coupon->user_id==$offerRequest->user_id?'checked':'' }} name='coupons[]' value="{{ $coupon->id }}"></td>
                                                                <td>{{ $coupon->coupon }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                  </table>
                                                  {{-- {!! $coupons->links() !!} --}}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ _('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ _('Submit') }}</button>
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
@endpush