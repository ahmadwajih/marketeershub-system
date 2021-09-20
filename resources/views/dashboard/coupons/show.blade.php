@extends('admin.layouts.app')
@section('title','الكوبونات')
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
                            <h2 class="card-title">بيانات الكوبون </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.coupons.store')}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">خطأ في التحقق من الصحة ، قم بتغيير بعض الأشياء وحاول الإرسال مرة أخرى.</div>
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

                                        <div class="form-group row mb-10">
                                            <div class="col-lg-9">
                                                <label>* قيمه الخصم :</label>
                                                <input class="form-control" value="{{ $coupon['discount'] }}" disabled />

                                            </div>
                                            <div class="col-lg-3">
                                                <label>* طريقه حساب قيمه الخصم :</label>
                                                <select class="form-control"  disabled>
                                                    <option @if($coupon['discount_type'] == "percentage") selected @endif >نسبه مئويه</option>
                                                    <option @if($coupon['discount_type'] == "number") selected @endif >مبلغ محدد</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row mt-10 text-center">
                                            <div class="col-lg-12">
                                                <label><b>* طريقه انتهاء الكوبون : </b></label>
                                                <div class="radio-inline text-center mx-auto mt-5"  style="width:fit-content">
                                                    <label class="radio radio-primary">
                                                        <input type="radio"  @if($coupon['use_type'] == "date") checked @endif disabled/>تاريخ محدد
                                                        <span class="m-2"></span>
                                                    </label>

                                                    <label class="radio radio-danger">
                                                        <input type="radio"   @if($coupon['use_type'] == "count") checked @endif disabled />عدد استخدام محدد
                                                        <span class="m-2"></span>
                                                    </label>
                                                    <label class="radio radio-danger">
                                                        <input type="radio"   @if($coupon['use_type'] == "both") checked @endif disabled />عدد استخدام محدد
                                                        <span class="m-2"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        @if($coupon['use_type'] == "date" || $coupon['use_type'] == "both")
                                        <div class="form-group row" id="date">
                                            <div class="col-lg-12">
                                                <label>* تاريخ بدايه و نهايه الكوبون :</label>
                                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                                    <input type="text" class="form-control"   readonly value="{{$coupon['from']}}" disabled/>
                                                    <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-ellipsis-h"></i>
															</span>
                                                    </div>
                                                    <input type="text" class="form-control"  readonly value="{{$coupon['to']}}" disabled />
                                                </div>
                                            </div>
                                        </div>

                                        @endif

                                        @if($coupon['use_type'] == "count" || $coupon['use_type'] == "both")
                                        <div class="form-group row" id="count" >
                                            <div class="col-lg-12">
                                                <label>* العدد المحدود :</label>
                                                <input type="number" name="count_use" disabled class="form-control" placeholder="أدخل العدد المحدود"  value="{{old('count_use')}}" />
                                                @if ($errors->has('count_use'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('count_use') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.coupons.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                العـوده
                                            </button>
                                        </a>
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

