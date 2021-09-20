@extends('dashboard.layouts.app')
@section('title','المستخدمين')
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
                            <h2 class="card-title">إضـافه مستخدم جـديد</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.users.store')}}" method = "POST" enctype="multipart/form-data">
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
                                        <label class="col-12 text-center mb-5">ارفق صوره شخصيه</label>
                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <div class="image-input image-input-outline image-input-circle" id="kt_image">
                                                    <div class="image-input-wrapper" style="background-image: url({{asset('images/placeholder.png')}})"></div>
                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="ارفق الصوره">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                        {{-- <input type="hidden" name="profile_avatar_remove" /> --}}
                                                    </label>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="احذف الصوره">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                                                </div>
                                                <span class="form-text text-muted mt-5 mb-5">أنواع الملفات المسموح بها: png، jpg، jpeg،</span>
                                                @if ($errors->has('image'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('image') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* Subdomain :</label>
                                                <input type="text" name="subdomain_name" class="form-control" placeholder="name.shoppn.io"  value="{{old('subdomain_name')}}" />
                                                @if ($errors->has('subdomain_name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('subdomain_name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>*  اسم مدير المتجر :</label>
                                                <input type="text" name="store_manager" class="form-control" placeholder="اسم مدير المتجر"  value="{{old('store_manager')}}" />
                                                @if ($errors->has('store_manager'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('store_manager') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* اسم المتجر :</label>
                                                <input type="text" name="store_name" class="form-control" placeholder="اسم المتجر"  value="{{old('store_name')}}" />
                                                @if ($errors->has('store_name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('store_name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>الموقع الالكتروني :</label>
                                                <input type="text" name="website" class="form-control" placeholder="اذا كان لديكم موقع الكتروني"  value="{{old('website')}}" />
                                                @if ($errors->has('website'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('website') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* البريد الالكتروني :</label>
                                                <input type="email" name="email" class="form-control" placeholder="أدخل البريد الالكتروني "  value="{{old('email')}}" />
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>*  الرقم السري :</label>
                                                <input type="password" name="password" class="form-control" placeholder="الرقم السري"  value="{{old('password')}}" />
                                                @if ($errors->has('password'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('password') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* هنا لكي :</label>
                                                <select class="form-control select2" id="kt_select_are_you_selling" name="are_you_selling" >
                                                    <option value="playing_around">بتجرب التطبيق</option>
                                                    <option value="not_selling_yet">لا أبيع شئ الأن</option>
                                                    <option value="selling_offline">لدي متجر </option>
                                                    <option value="selling_online">لدي متجر اونلين</option>
                                                    <option value="none_of_above">لا شئ مما سبق</option>
                                                </select>
                                                @if ($errors->has('are_you_selling'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('are_you_selling') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* مستوي مبيعاتي :</label>
                                                <select class="form-control select2" id="kt_select_level_id" name="level_id" >
                                                    @foreach($levels as $level)
                                                        <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('level_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('level_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>*  ادخل لينك متجرك الإلكتروني (اذا كان لديك متجر الكتروني) :</label>
                                                <input type="text" name="your_online_store" class="form-control" placeholder="ادخل لينك متجرك الإلكتروني (اذا كان لديك متجر الكتروني)"  value="{{old('your_online_store')}}" />
                                                @if ($errors->has('your_online_store'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('your_online_store') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* الباقات :</label>
                                                <select class="form-control select2" id="kt_select_package_id" name="package_id" >
                                                    @foreach($packages as $package)
                                                        <option value="{{$package->id}}">{{$package->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('package_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('package_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* الدولة :</label>
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id" >
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('country_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* المدينة :</label>
                                                <select class="form-control select2" id="kt_select_governorate_id" name="governorate_id" >
                                                    @foreach($governorates as $governorate)
                                                        <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('governorate_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('governorate_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* االعنوان :</label>
                                                <input type="text" name="address" class="form-control" placeholder="أدخل  العنوان" value="{{old('address')}}" />
                                                @if ($errors->has('address'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('address') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* الرقم البريدي :</label>
                                                <input type="number" name="post_code" class="form-control"  placeholder="أدخل الرقم البريدي"  value="{{old('post_code')}}" />
                                                @if ($errors->has('post_code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('post_code') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* رقم الموبيل :</label>
                                                <input type="text" name="phone" class="form-control" placeholder="أدخل رقم الموبيل" value="{{old('phone')}}" />
                                                @if ($errors->has('phone'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('phone') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>اضافة سعر مخصص لتجديد الباقة :</label>
                                                <input type="number" name="renewal_price" class="form-control" placeholder="100" value="{{old('renewal_price')}}" />
                                                @if ($errors->has('renewal_price'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('renewal_price') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* نوع الاشتراك  :</label>
                                                <select class="form-control select2" id="kt_select_subscription_type" name="subscription_type" >
                                                    <option value="monthly" selected> شهري</option>
                                                    <option value="annual">سنوي</option>
                                                </select>
                                                @if ($errors->has('subscription_type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('subscription_type') }}</p>
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
        $('#kt_select_are_you_selling').select2({
            placeholder: "اختر",
        });
        $('#kt_select_level_id').select2({
            placeholder: "اختر",
        });
        $('#kt_select_package_id').select2({
            placeholder: "اختر",
        });
        $('#kt_select_country_id').select2({
            placeholder: "اختر",
        });
        $('#kt_select_governorate_id').select2({
            placeholder: "يجب اختيار الدولة أولاً ",
        });
        $('#kt_select_subscription_type').select2({
            placeholder: "اختر",
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#kt_select_country_id").on("change",function(){
                var countryId = $("#kt_select_country_id").val();
               
                $.ajax({
                    method: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('admin.governorates.ajax')}}",
                    data: { countryId: countryId}, 
                })
                .done(function(msgs) {
                    $("#kt_select_governorate_id").html(msgs)
                });
            });
        });


    </script>
    <script src="{{asset('dashboard/js/pages/crud/file-upload/image-input.js')}}"></script>
@endpush
