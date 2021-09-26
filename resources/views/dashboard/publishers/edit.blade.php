@extends('dashboard.layouts.app')
@section('title','Users')
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
                            <h2 class="card-title"> {{ __('User Name') }} : {{ $user->name }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('dashboard.users.update',$user->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">خطأ في التحقق من الصحة ، قم بتغيير بعض الأشياء وحاول الإرسال مرة أخرى.</div>
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
                                            <div class="col-lg-6">
                                                <label>* Subdomain :</label>
                                                <input type="text" name="subdomain_name" class="form-control" placeholder="name.shoppn.io"  value="{{old('subdomain_name') ?: $user->subdomain_name}}" />
                                                @if ($errors->has('subdomain_name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('subdomain_name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>*  اسم مدير المتجر :</label>
                                                <input type="text" name="store_manager" class="form-control" placeholder="اسم مدير المتجر"  value="{{old('store_manager') ?: $user->store_manager}}" />
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
                                                <input type="text" name="store_name" class="form-control" placeholder="اسم المتجر"  value="{{old('store_name') ?: $user->store_name}}" />
                                                @if ($errors->has('store_name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('store_name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>الموقع الالكتروني :</label>
                                                <input type="text" name="website" class="form-control" placeholder="اذا كان لديكم موقع الكتروني"  value="{{old('website') ?: $user->website}}" />
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
                                                <input type="email" name="email" class="form-control" placeholder="أدخل البريد الالكتروني "  value="{{old('email') ?: $user->email}}" />
                                                @if ($errors->has('email'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('email') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>*  الرقم السري :</label>
                                                <input type="text" name="password" class="form-control" placeholder="الرقم السري"  value="{{old('password') ?: $user->password}}" />
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
                                                    <option value="playing_around" {{old('are_you_selling')=='playing_around'||$user->are_you_selling=='playing_around'?'selected':''}}>بتجرب التطبيق</option>
                                                    <option value="not_selling_yet" {{old('are_you_selling')=='not_selling_yet'||$user->are_you_selling=='not_selling_yet'?'selected':''}}>لا أبيع شئ الأن</option>
                                                    <option value="selling_offline" {{old('are_you_selling')=='selling_offline'||$user->are_you_selling=='selling_offline'?'selected':''}}>لدي متجر </option>
                                                    <option value="selling_online" {{old('are_you_selling')=='selling_online'||$user->are_you_selling=='selling_online'?'selected':''}}>لدي متجر اونلين</option>
                                                    <option value="none_of_above" {{old('are_you_selling')=='none_of_above'||$user->none_of_above=='none_of_above'?'selected':''}}>لا شئ مما سبق</option>
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
                                                        <option value="{{$level->id}}" {{old('level_id')==$level->id||$user->level_id==$level->id?'selected':''}}>{{$level->name}}</option>
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
                                                <input type="text" name="your_online_store" class="form-control" placeholder="ادخل لينك متجرك الإلكتروني (اذا كان لديك متجر الكتروني)"  value="{{old('your_online_store') ?: $user->your_online_store}}" />
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
                                                        <option value="{{$package->id}}" {{old('package_id')==$package->id||$user->package_id==$package->id?'selected':''}}>{{$package->name}}</option>
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
                                                        <option value="{{$country->id}}" {{old('country_id')==$country->id||$user->country_id==$country->id?'selected':''}}>{{$country->name}}</option>
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
                                                        <option value="{{$governorate->id}}" {{old('governorate_id')==$governorate->id||$user->governorate_id==$governorate->id?'selected':''}}>{{$governorate->name}}</option>
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
                                                <input type="text" name="address" class="form-control" placeholder="أدخل  العنوان" value="{{old('address') ?: $user->address}}" />
                                                @if ($errors->has('address'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('address') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* الرقم البريدي :</label>
                                                <input type="number" name="post_code" class="form-control"  placeholder="أدخل الرقم البريدي"  value="{{old('post_code') ?: $user->post_code}}" />
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
                                                <input type="text" name="phone" class="form-control" placeholder="أدخل رقم الموبيل" value="{{old('phone') ?: $user->phone}}" />
                                                @if ($errors->has('phone'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('phone') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <label>اضافة سعر مخصص لتجديد الباقة :</label>
                                                <input type="number" name="renewal_price" class="form-control" placeholder="100" value="{{old('renewal_price') ?: $user->renewal_price}}" />
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
                                                    <option value="monthly" {{old('renewal_price')=="monthly"||$user->subscription_type=="monthly" ?"selected":""}}> شهري</option>
                                                    <option value="annual" {{old('renewal_price')=="annual"||$user->subscription_type=="annual" ?"selected":""}}>سنوي</option>
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
