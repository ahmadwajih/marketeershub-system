@extends('dashboard.layouts.app')
@section('title','Offers')
@push('styles')
  <style>
        #oldNew ,#slaps{
            display: none;
        }
    </style>  
@endpush
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
                                                    <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg, .svg" />
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
                                                        <option {{ old('advertiser_id')==$advertiser->id?'selected':''  }} value="{{ $advertiser->id }}">{{  $advertiser->company_name }}</option>
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
                                            <div class="col-lg-4">
                                                <label>* {{ __('Categories') }} :</label>
                                                <select class="form-control select2" id="kt_select_categories" name="categories[]"  multiple>
                                                    @foreach ($categories as $category)
                                                        <option {{ old('categories')?(in_array($category->id,old('categories'))?'selected':''):''  }} value="{{ $category->id }}">{{  $category->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('categories'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('categories') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* {{ _('Country') }} :</label>
                                                <select class="form-control select2" id="kt_select_countries" name="countries[]" multiple>
                                                    @foreach($countries as $country)
                                                        <option {{ old('countries')?(in_array($country->id,old('countries'))?'selected':''):''  }} value="{{$country->id}}">{{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('countries'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('countries') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
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
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Payout Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_payout_type" name="payout_type" >
                                                    <option {{ old('payout_type')=="cps_flat"?"selected":"" }} value="cps_flat">{{ __('CPS Flat') }}</option>
                                                    <option {{ old('payout_type')=="cps_percentage"?"selected":"" }} value="cps_percentage">{{ __('CPS Percentage') }}</option>
                                                </select>
                                                @if ($errors->has('payout_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('payout_type') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('CPS Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_cps_type" name="cps_type" >
                                                    <option {{ old('cps_type')=="static"?"selected":"" }} value="static">{{ __('Static') }}</option>
                                                    <option {{ old('cps_type')=="new_old"?"selected":"" }} value="new_old">{{ __('New old') }}</option>
                                                    <option {{ old('cps_type')=="slaps"?"selected":"" }} value="slaps">{{ __('Slaps') }}</option>
                                                </select>
                                                @if ($errors->has('cps_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('cps_type') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row" id="static">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Revenu') }} :</label>
                                                <input type="number" step="0.1" name="revenue" class="form-control" value="{{old('revenue')}}" />
                                                @if ($errors->has('revenue'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('revenue') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Payout') }} :</label>
                                                <input type="number" step="0.1" name="payout" class="form-control" value="{{old('payout')}}" />
                                                @if ($errors->has('payout'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('payout') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div id="oldNew">
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label>* {{ __('New Payout') }} :</label>
                                                    <input type="number" step="0.1" name="new_payout" placeholder="10" class="form-control" value="{{old('new_payout')}}" />
                                                    @if ($errors->has('new_payout'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('new_payout') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>* {{ __('New Revenue') }} :</label>
                                                    <input type="number" step="0.1" name="new_revenue" placeholder="5" class="form-control" value="{{old('new_revenue')}}" />
                                                    @if ($errors->has('new_revenue'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('new_revenue') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>* {{ __('Old Payout') }} :</label>
                                                    <input type="number" step="0.1" name="old_payout" placeholder="10" class="form-control" value="{{old('old_payout')}}" />
                                                    @if ($errors->has('old_payout'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('old_payout') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>* {{ __('Old Revenue') }} :</label>
                                                    <input type="number" step="0.1" name="old_revenue" placeholder="5" class="form-control" value="{{old('old_revenue')}}" />
                                                    @if ($errors->has('old_revenue'))
                                                        <div>
                                                            <p class="invalid-input">{{ $errors->first('old_revenue') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="form-group row" id="slaps">
                                            <div id="kt_repeater_1">
                                                <div class="form-group row" id="kt_repeater_1">
                                                    <label class="col-form-label text-right"><b>{{ __('Slaps') }}</b></label>
                                                    <div data-repeater-list="slaps" class="col-lg-12">
                                                        <div data-repeater-item class="form-group row align-items-center">
                                                            <div class="col-12"><h3>{{ __('Slap') }}</h3></div>
                                                            <div class="col-md-4">
                                                                <label>{{__('Orders Type') }}</label>
                                                                <select class="form-control form-select" name="slap_type" style="display: block" >
                                                                    <option value="number_of_orders">{{{ __('Number Of Orders') }}}</option>
                                                                    <option value="ammount_of_orders">{{{ __('Ammount Of Orders') }}}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>{{ __('From') }}</label>
                                                                <input type="number" name="from" class="form-control" placeholder="1"/>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>{{ __('To') }}</label>
                                                                <input type="number" name="to" class="form-control" placeholder="1"/>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>{{ __('Revenue') }}</label>
                                                                <input type="number" name="revenue" class="form-control" placeholder="1"/>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>{{ __('Payout') }}</label>
                                                                <input type="number" name="payout" class="form-control" placeholder="1"/>
                                                                <div class="d-md-none mb-2"></div>
                                                            </div>
    
                                                            <div class="col-md-4">
                                                                <br>
                                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger btn-block">
                                                                    <i class="la la-trash-o"></i>حذف
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                </div>
                                                <div class="form-group row">
                                                    <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary btn-block">
                                                        <i class="la la-plus"></i>إضافة
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ _('Offer Discount Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_discount_type" name="discount_type" >
                                                    <option value="flat">{{ __('Flat') }}</option>
                                                    <option value="percentage">{{ __('Percentage') }}</option>
                                                </select>
                                                @if ($errors->has('discount_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('discount_type') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Offer Discount') }} :</label>
                                                <input type="number" step="0.1" name="discount" class="form-control" value="{{old('discount')}}" />
                                                @if ($errors->has('discount'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('discount') }}</p>
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
                                                <label>{{ __('Note') }} :</label>
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
                                                <label>{{ __('Terms And Conditions') }} :</label>
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

        $('#kt_select_status').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_advertiser_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_countries').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_city_id').select2({
            placeholder: "You sholud select country",
        });
        $('#kt_select_categories').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_payout_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_cps_type').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_discount_type').select2({
            placeholder: "Select Option",
        });

    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script>
        // Class definition
        var KTFormRepeater = function() {
        // Private functions
        var demo1 = function() {
            $('#kt_repeater_1').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        }

        return {
            // public functions
            init: function() {
                demo1();
            }
        };
        }();

        jQuery(document).ready(function() {
            KTFormRepeater.init();
        });
    </script>

    <script>
        $(document).ready(function(){
            $("#kt_select_cps_type").change(function(){
                if($(this).val() == 'new_old'){
                    $('#static').fadeOut();
                    $('#slaps').fadeOut();
                    $('#oldNew').fadeIn();
                }
                if($(this).val() == 'static'){
                    $('#static').fadeIn();
                    $('#slaps').fadeOut();
                    $('#oldNew').fadeOut();
                }
                if($(this).val() == 'slaps'){
                    $('#static').fadeOut();
                    $('#slaps').fadeIn();
                    $('#oldNew').fadeOut();
                }
            });
        });
    </script>
@endpush
