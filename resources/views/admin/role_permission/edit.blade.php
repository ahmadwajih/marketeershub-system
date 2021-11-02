@extends('admin.layouts.app')
@section('title','الأحياء')
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
                            <h2 class="card-title"> تعديل حــي {{$district->name_ar}}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('districts.update',$district->id)}}" method = "POST">
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
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* اسم الحي بالأنجليزيه :</label>
                                                <input type="text" name="name_en" class="form-control"  value="{{old('name_en') ?: $district->name_en }}" />
                                                @if ($errors->has('name_en'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name_en') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* اسم الحي بالعربيه :</label>
                                                <input type="text" name="name_ar" class="form-control"  value="{{old('name_ar') ?: $district->name_ar }}" />
                                                @if ($errors->has('name_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 mt-10">
                                                <label>* اسم المدينه :</label>
                                                <select class="form-control select2" id="kt_select_city" name="city_id">
                                                    <option  value="{{old('city_id')  ?: $district->city_id }}">{{ old('city_id') ?  App\Models\City::find(old('city_id'))->name_ar . ' - '. App\Models\City::find(old('city_id'))->name_en :  $district->city->name_ar . ' - '. $district->city->name_en }}</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}">{{$city->name_ar  . ' - '. $city->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('city_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('city_id') }}</p>
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
        $('#kt_select_city').select2({
            placeholder: "اختر المدينه",
        });
    </script>
@endpush
