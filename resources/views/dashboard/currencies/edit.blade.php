@extends('dashboard.layouts.app')
@section('title','العملات')
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
                            <h2 class="card-title"> تعديل  {{$currency->name}} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.currencies.update',$currency->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">{{__('Validation Error , Change a few things up and try submitting again.')}}</div>
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
                                                <label>* الأسم :</label>
                                                <input type="text" name="name" class="form-control" placeholder="أدخل اسم العملة" value="{{old('name') ?: $currency->name }}" />
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* الكود  :</label>
                                                <input type="text" name="code" class="form-control" placeholder="أدخل كود العملة  "  value="{{old('code') ?: $currency->code }}" />
                                                @if ($errors->has('code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('code') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* العلامة  :</label>
                                                <input type="text" name="sign" class="form-control" placeholder="أدخل علامة العملة  "  value="{{old('sign') ?: $currency->sign }}" />
                                                @if ($errors->has('sign'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('sign') }}</p>
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

