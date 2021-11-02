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
                            <h2 class="card-title">إضـافه </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('role-permission.store')}}" method = "POST">
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
                                        <div class="form-group row">

                                            <div class="col-lg-12 mt-10">
                                                <label>* اسم القاعدة :</label>
                                                    <select class="form-control select2" id="kt_select_role" name="role_id">
                                                        <option value="">اختار القاعدة</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->id}}" {{old('role_id') == $role->id?'selected':''}}>{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('city_id'))
                                                <div>
                                                    <p class="invalid-input">{{ $errors->first('city_id') }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-12 mt-10">
                                                <label>* اسم التصريح :</label>
                                                    <select class="form-control select2" id="kt_select_permission" name="permission_id">
                                                        <option value="">اختار التصريح</option>
                                                    @foreach($permissions as $permission)
                                                        <option value="{{$permission->id}}" {{old('permission_id') == $permission->id?'selected':''}}>{{$permission->name}}</option>
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
        $('#kt_select_role').select2({
            placeholder: "اختر القاعدة",
        });
        $('#kt_select_permission').select2({
            placeholder: "اختر التصريح",
        });
    </script>
@endpush
