@extends('dashboard.layouts.app')
@section('title','Offers')
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
                            <h2 class="card-title">{{ __('Create New Offer') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('dashboard.offers.store')}}" method = "POST" enctype="multipart/form-data">
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
                                <div class="mb-2">
                                    <label class="col-12 text-center mb-5">{{ __('Thumbnail') }}</label>
                                    <div class="form-group row">
                                        <div class="col-12 text-center">
                                            <div class="image-input image-input-outline image-input-circle" id="kt_image">
                                                <div class="image-input-wrapper" style="background-image: url({{asset('dashboard/images/placeholder.png')}})"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Upload image">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg" />
                                                    {{-- <input type="hidden" name="profile_avatar_remove" /> --}}
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Delete image">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                            </div>
                                            <span class="form-text text-muted mt-5 mb-5">{{ __('Available extensions is : png، jpg، jpeg،') }}</span>
                                            @if ($errors->has('thumbnail'))
                                                <div>
                                                    <p class="invalid-input">{{ $errors->first('thumbnail') }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Offer Name') }} :</label>
                                                <input type="text" name="name" class="form-control"  value="{{old('name')}}" required/>
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* {{ __('Advertiser') }} :</label>
                                                <select class="form-control select2" id="kt_select_advertiser_id" name="advertiser_id" >
                                                    <option selected value="">{{ __('No one') }}</option>
                                                    @foreach ($advertisers as $advertiser)
                                                        <option {{ old('advertiser_id')==$advertiser->id?'selected':''  }} value="{{ $advertiser->id }}">{{  $advertiser->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('advertiser_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('advertiser_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Description') }} :</label>
                                                <textarea class="form-control" name="description" cols="30" rows="10">{{old('description')}}</textarea>
                                                @if ($errors->has('description'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('description') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Website') }} :</label>
                                                <input type="url" name="website" class="form-control" value="{{old('website')}}" />
                                                @if ($errors->has('website'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('website') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Offer URL') }} :</label>
                                                <input type="url" name="offer_url" class="form-control"  value="{{old('offer_url')}}" />
                                                @if ($errors->has('offer_url'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('offer_url') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Category') }} :</label>
                                                <input type="text" name="category" class="form-control" value="{{old('category')}}" />
                                                @if ($errors->has('category'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('category') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ _('Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_type" name="type" >
                                                    <option value="coupon_tracking">{{ __('Coupon Tracking') }}</option>
                                                    <option value="link_tracking">{{ __('Link Tracking') }}</option>
                                                    </select>
                                                @if ($errors->has('type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('type') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ _('Country') }} :</label>
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id" >
                                                    @foreach($countries as $country)
                                                        <option {{old('country_id')==$country->id?"selected":""}} value="{{$country->id}}">{{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('country_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Payout Type') }} :</label>
                                                <input type="text" name="payout_type" class="form-control" value="{{old('payout_type')}}" />
                                                @if ($errors->has('payout_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('payout_type') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Payout Default') }} :</label>
                                                <input type="number" name="default_payout" class="form-control" value="{{old('default_payout')}}" />
                                                @if ($errors->has('default_payout'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('default_payout') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Expire Date') }} :</label>
                                                <input type="date" name="expire_date" class="form-control" value="{{old('expire_date')}}" />
                                                @if ($errors->has('expire_date'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('expire_date') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Status') }} :</label>
                                                <select class="form-control select2" id="kt_select_status" name="status" >
                                                    <option {{ old('status')=="pending"?"selected":"" }} value="pending">{{ __('Pending') }}</option>
                                                    <option {{ old('status')=="active"?"selected":"" }} value="active">{{ __('Active') }}</option>
                                                    <option {{ old('status')=="pused"?"selected":"" }} value="pused">{{ __('Pused') }}</option>
                                                    <option {{ old('status')=="expire"?"selected":"" }} value="expire">{{ __('Expire') }}</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('status') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Note') }} :</label>
                                                <textarea class="form-control" name="note" cols="30" rows="10">{{old('note')}}</textarea>
                                                @if ($errors->has('note'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('note') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Terms And Conditions') }} :</label>
                                                <textarea class="form-control" name="terms_and_conditions" cols="30" rows="10">{{old('terms_and_conditions')}}</textarea>
                                                @if ($errors->has('terms_and_conditions'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('terms_and_conditions') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ __("Update") }}</button>
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

        $('#kt_select_status').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_advertiser_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_country_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_city_id').select2({
            placeholder: "You sholud select country",
        });

    </script>
    <script>
        $(document).ready(function(){
            $("#kt_select_country_id").on("change",function(){
                var countryId = $("#kt_select_country_id").val();
                console.log(countryId);
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('dashboard.ajax.cities')}}",
                    data: { countryId: countryId}, 
                })
                .done(function(res) {
                    console.log(res);
                    $("#kt_select_city_id").html(res)
                });
            });
        });


    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
@endpush
