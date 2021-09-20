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
                        <form class="form" id="kt_form" action="{{route('admin.coupons.store')}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger">{{$error}}</div>
                                    @endforeach
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
                                                <input type="text" name="code" class="form-control" placeholder="أدخل كود الخصم" value="{{old('code')}}" />
                                                @if ($errors->has('code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('code') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-6">
                                                <label>* قيمه الخصم :</label>
                                                <input type="number" name="discount_amount" class="form-control" placeholder="أدخل قيمه الخصم" value="{{old('discount_amount')}}" />
                                                @if ($errors->has('discount_amount'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('discount_amount') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-group row mb-10">

                                            <div class="col-lg-6">
                                                <label>* طريقه حساب قيمه الخصم :</label>
                                                <select class="form-control" id="discount_type" name="discount_type">
                                                    <option value="percentage">نسبه مئويه</option>
                                                    <option value="number">مبلغ محدد</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6" id="max_discount">
                                                <label>* الحد الأقصي للخصم بالجنبه :</label>
                                                <input type="number" name="max_discount"  class="form-control" placeholder="أدخل الحد الأقصي للخصم بالريال" value="{{old('max_discount')}}" />
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
                                                        <input type="radio" name="use_type" @if(old('use_type') == "time_period") checked @endif checked value="time_period" />تاريخ محدد
                                                        <span class="m-2"></span></label>
                                                    <label class="radio radio-danger">
                                                        <input type="radio"  name="use_type"  @if(old('use_type') == "count_use") checked @endif value="count_use"  />عدد استخدام محدد
                                                        <span class="m-2"></span>
                                                    </label>
                                                    <label class="radio radio-danger">
                                                        <input type="radio"  name="use_type"  @if( old('use_type') == "both") checked @endif value="both"  /> تاريخ محدود - عدد استخدام محدد
                                                        <span class="m-2"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row radio-child time_period both"  >
                                            <div class="col-lg-6">
                                                <label>* تاريخ بدايه الكوبون :</label>
                                                <div class="input-daterange input-group">
                                                    <input type="date" class="form-control" name="from"   value="{{old('from')}}" />
                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* تاريخ انتهاء الكوبون :</label>
                                                <div class="input-daterange input-group">
                                                    <input type="date" class="form-control" name="to"  value="{{old('to')}}" />
                                                   
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row radio-child time_period both" >
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


                                        <div class="form-group row radio-child count_use both" id="count">
                                            <div class="col-lg-12">
                                                <label>* العدد المحدود :</label>
                                                <input type="number" name="count_use" class="form-control" placeholder="أدخل العدد المحدود"  value="{{old('count_use')}}" />
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
            console.log('step 1');
            $(".count,.both,.date").hide();
            console.log('step 2');

            $("input[name='use_type']").click(function (index, value) {
                console.log($(this).val());
                var radioBtnValue = $(this).val();
                $("." + radioBtnValue).show();
                $(".radio-child:not(." + radioBtnValue + ")").hide()
            });
            console.log('step 3');

            $("input[name='use_type']").each(function (index, value) {
                console.log($(this).val());

                if($(this).is(':checked')) {
                    var radioBtnValue = $(this).val();
                    $("." + radioBtnValue).show();
                }

            });
        })
    </script>
    <script src="{{asset('dashboard/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
@endpush
