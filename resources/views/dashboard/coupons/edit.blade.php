@extends('dashboard.layouts.app')
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
                            <h2 class="card-title">إضـافه كوبون جـديد</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.coupons.update',$coupon->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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

                                            <div class="col-lg-6">
                                                <label>* الكود :</label>
                                                <input type="text" name="code" class="form-control" placeholder="أدخل كود الخصم" value="{{old('code') ?: $coupon['code']}}" />
                                                @if ($errors->has('code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('code') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* قيمه الخصم :</label>
                                                <input type="number" name="discount" class="form-control" placeholder="أدخل قيمه الخصم" value="{{old('discount') ?: $coupon['discount']}}" />
                                                @if ($errors->has('discount'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('discount') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group row mb-10">

                                            <div class="col-lg-6">
                                                <label>* طريقه حساب قيمه الخصم :</label>
                                                <select class="form-control" id="discount_type" name="discount_type">
                                                    <option value="percentage" @if( $coupon['type'] ==  'percentage') selected @endif>نسبه مئويه</option>
                                                    <option value="number" @if( $coupon['type'] ==  'number') selected @endif>مبلغ محدد</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6" id="max_discount" @if( $coupon['type'] ==  'number') style="display:none" @endif>
                                                <label>* الحد الأقصي للخصم بالريال :</label>
                                                <input type="number" name="max_discount"  class="form-control" placeholder="أدخل الحد الأقصي للخصم بالريال" value="{{old('max_discount') ?: $coupon['max_discount']}}" />
                                                @if ($errors->has('max_discount'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('max_discount') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>


                                        <div class="form-group row mt-10 text-center">
                                            <div class="col-lg-12">
                                                <label><b>* طريقه انتهاء الكوبون : </b></label>
                                                <div class="radio-inline text-center mx-auto mt-5"  style="width:fit-content">
                                                    <label class="radio radio-primary">
                                                        <input type="radio" name="use_type" @if( $coupon['use_type'] == "date") checked @endif value="date" onclick="selectedDate()" />تاريخ محدد
                                                        <span class="m-2"></span>
                                                    </label>

                                                    <label class="radio radio-danger">
                                                        <input type="radio"  name="use_type"  @if( $coupon['use_type'] == "count") checked @endif value="count" onclick="selectedCount()" />عدد استخدام محدد
                                                        <span class="m-2"></span>
                                                    </label>

                                                    <label class="radio radio-danger">
                                                        <input type="radio"  name="use_type"  @if( $coupon['use_type'] == "both") checked @endif value="both" onclick="selectedBoth()" /> تاريخ محدود - عدد استخدام محدد
                                                        <span class="m-2"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row radio-child date both" id="date"  >
                                            <div class="col-lg-12">
                                                <label>* تاريخ بدايه و نهايه الكوبون :</label>
                                                <div class="input-daterange input-group" id="kt_datepicker_5">
                                                    <input type="text" class="form-control" name="from"  readonly value="{{$coupon['from']}}" />
                                                    <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-ellipsis-h"></i>
															</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="to" readonly value="{{$coupon['to']}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row radio-child date both" >
                                            <div class="col-6">
                                                @if ($errors->has('from'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('from') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-6">
                                                @if ($errors->has('to'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('to') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group row radio-child count both" id="count" @if($coupon['use_type'] != "count") style="display:none" @endif>
                                            <div class="col-lg-12">
                                                <label>* العدد المحدود :</label>
                                                <input type="number" name="count_use" class="form-control" placeholder="أدخل العدد المحدود"  value="{{$coupon['count_use']}}" />
                                                @if ($errors->has('count_use'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('count_use') }}</p>
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
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">إلـغـاء</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">تـأكيـد</button>
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
        $('#discount_type').select2({
            placeholder:"أختر طريقه حساب قيمه الخصم"
        });

        $('#discount_type').change( function(){
            $('#max_discount').toggle();
        });

        $(function () {
            $(".count,.both,.date").hide();

            $("input[name='use_type']").click(function (index, value) {
                var radioBtnValue = $(this).val();
                $("." + radioBtnValue).show();
                $(".radio-child:not(." + radioBtnValue + ")").hide()
            })

            $("input[name='use_type']").each(function (index, value) {
                if($(this).is(':checked')) {
                    var radioBtnValue = $(this).val();
                    $("." + radioBtnValue).show();
                }

            })
        })
    </script>
    <script src="{{asset('dashboard/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>


@endpush
