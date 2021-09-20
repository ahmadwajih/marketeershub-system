    @extends('dashboard.layouts.app')
@section('title','اضافة طبيب')
@section('content')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">
            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
            <!--end::Page Title-->
            <!--begin::Actions-->
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4">#XRS-45670</span>
            <a href="#" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</a>
            <!--end::Actions-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Actions-->
            <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Today</a>
            <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Month</a>
            <a href="#" class="btn btn-clean btn-sm font-weight-bold font-size-base mr-1">Year</a>
            <!--end::Actions-->
            <!--begin::Daterange-->
            <a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" id="kt_dashboard_daterangepicker" data-toggle="tooltip" title="Select dashboard daterange" data-placement="left">
                <span class="text-muted font-size-base font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">Today</span>
                <span class="text-primary font-size-base font-weight-bolder" id="kt_dashboard_daterangepicker_date">Aug 16</span>
            </a>
            <!--end::Daterange-->
            <!--begin::Dropdowns-->
            <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
                <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-success svg-icon-lg">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
                    <!--begin::Navigation-->
                    <ul class="navi navi-hover py-5">
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-drop"></i>
                                </span>
                                <span class="navi-text">New Group</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-list-3"></i>
                                </span>
                                <span class="navi-text">Contacts</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-rocket-1"></i>
                                </span>
                                <span class="navi-text">Groups</span>
                                <span class="navi-link-badge">
                                    <span class="label label-light-primary label-inline font-weight-bold">new</span>
                                </span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-bell-2"></i>
                                </span>
                                <span class="navi-text">Calls</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-gear"></i>
                                </span>
                                <span class="navi-text">Settings</span>
                            </a>
                        </li>
                        <li class="navi-separator my-3"></li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-magnifier-tool"></i>
                                </span>
                                <span class="navi-text">Help</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link">
                                <span class="navi-icon">
                                    <i class="flaticon2-bell-2"></i>
                                </span>
                                <span class="navi-text">Privacy</span>
                                <span class="navi-link-badge">
                                    <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <!--end::Navigation-->
                </div>
            </div>
            <!--end::Dropdowns-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        اضافة طبيب
                    </h3>
                </div>
                <!--begin::Form-->
                <form action="{{route('doctors.store')}}" enctype="multipart/form-data" method="POST">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $message)
                                    <li>{{$message}}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                    @csrf

                    <div class="card-body">
                        {{-- AR Name  --}}
                        <div class="form-group row">
                            <label for="example-name-ar-input" class="col-2 col-form-label">الاسم باللغة العربية</label>
                            <div class="col-10">
                                <input class="form-control" name="name_ar" type="text" value="{{ old('name_ar') }}" id="example-name-ar-input" placeholder="الاسم باللغة العربية"/>
                            </div>
                        </div>

                        {{-- EN Name  --}}
                        <div class="form-group row">
                            <label for="example-name-en-input" class="col-2 col-form-label">الاسم باللغة الانجليزية</label>
                            <div class="col-10">
                                <input class="form-control" name="name_en" type="text" value="{{ old('name_en') }}" id="example-name-en-input" placeholder="الاسم باللغة الانجليزية"/>
                            </div>
                        </div>

                        {{-- AR Bio --}}
                        <div class="form-group row">
                            <label for="example-bio_ar-input" class="col-2 col-form-label">جملة وصفية باللغة العربية</label>
                            <div class="col-10">
                                <input class="form-control" name="bio_ar" type="text" value="{{ old('bio_ar') }}" id="example-bio_ar-input" placeholder="جملة وصفية"/>
                            </div>
                        </div>
                        {{-- EN Bio --}}
                        <div class="form-group row">
                            <label for="example-bio_en-input" class="col-2 col-form-label">جملة وصفية باللغة الانجليزية</label>
                            <div class="col-10">
                                <input class="form-control" name="bio_en" type="text" value="{{ old('bio_en') }}" id="example-bio_en-input" placeholder="جملة وصفية باللغة الانجليزية"/>
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="form-group row">
                            <label class="col-2 col-form-label" for="">البريد الالكتروني <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <input type="email" name="email" value="{{ old('email')}}" class="form-control"  placeholder="البريد الالكتروني"/>
                                <span class="form-text text-muted"> لن يتم مشاركة بريدك الالكتروني مع اي شخص</span>
                            </div>
                        </div>
                        {{-- Passord --}}
                        <div class="form-group row">
                            <label class="col-2 col-form-label" for="exampleInputPassword1">الرقم السري  <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="الرقم السري لتسجيل الدخول"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label" for="exampleInputConfirmPassword">تأكيد الرقم السري <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <input type="password"  name="password_confirmation" class="form-control" id="exampleInputConfirmPassword" placeholder="تأكيد الرقم السري لتسجيل الدخول"/>
                            </div>
                        </div>
                        {{-- Profile Image --}}
                        <div class="form-group row">
                            <label class="col-form-label col-2">الصورة الشخصية</label>
                            <div class="col-10">
                                <input type="file" name="profile_pic">
                            </div>
                        </div>
                        {{-- Specialize  --}}
                        <div class="form-group row">
                            <label class="col-2 col-form-label"  for="exampleSelect2">التخصص <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <select class="form-control" id="exampleSelect2" name="specialize_id">
                                    <option  value="">اختيار التخصص</option>
                                    @foreach ($specializes as  $specialize)
                                        <option value="{{ $specialize->id }}">{{ $specialize->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Mobile --}}
                        <div class="form-group row">
                            <label for="example-tel-input" class="col-2 col-form-label">رقم الموبيل</label>
                            <div class="col-10">
                                <input class="form-control" name="mobile" type="tel" value="{{ old('mobile') }}" id="example-tel-input"/>
                            </div>
                        </div>
                        {{-- Gender --}}
                        <div class="form-group row">
                            <label class="col-2 col-form-label"  for="exampleSelect1">الجنس <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <select class="form-control" id="exampleSelect1" name="gender">
                                    <option  value="male">ذكر</option>
                                    <option value="female">انثي</option>
                                </select>
                            </div>
                        </div>

                        {{-- AR Clinic Info --}}
                        <div class="form-group row">
                            <label for="example-clinic_info_ar-input" class="col-2 col-form-label"> بيانات العيادة باللغة العربية</label>
                            <div class="col-10">
                                <input class="form-control" name="clinic_info_ar" type="text" value="{{ old('clinic_info_ar') }}" id="example-clinic_info_ar-input" placeholder="بيانات العيادة باللغة العربية"/>
                            </div>
                        </div>
                        {{-- EN Clinic Info --}}
                        <div class="form-group row">
                            <label for="example-clinic_info_en-input" class="col-2 col-form-label"> بيانات العيادة باللغة الانجليزية</label>
                            <div class="col-10">
                                <input class="form-control" name="clinic_info_en" type="text" value="{{ old('clinic_info_en') }}" id="example-clinic_info_en-input" placeholder="بيانات العيادة باللغة الانجليزية"/>
                            </div>
                        </div>
                        {{-- AR clinic service  --}}
                        <div class="form-group row">
                            <label for="example-clinic_service_ar-input" class="col-2 col-form-label"> خدمات العيادة باللغة العربية</label>
                            <div class="col-10">
                                <input class="form-control" name="clinic_service_ar" type="text" value="{{ old('clinic_service_ar') }}" id="example-clinic_service_ar-input" placeholder="خدمات العيادة باللغة العربية"/>
                            </div>
                        </div>
                        {{-- EN clinic service  --}}
                        <div class="form-group row">
                            <label for="example-clinic_service_en-input" class="col-2 col-form-label"> خدمات العيادة باللغة الانجليزية</label>
                            <div class="col-10">
                                <input class="form-control" name="clinic_service_en" type="text" value="{{ old('clinic_service_en') }}" id="example-clinic_service_en-input" placeholder="خدمات العيادة باللغة الانجليزية"/>
                            </div>
                        </div>
                        {{-- AR Address --}}
                        <div class="form-group row">
                            <label for="example-address_ar-input" class="col-2 col-form-label">  عنوان العيادة باللغة العربية</label>
                            <div class="col-10">
                                <input class="form-control" name="address_ar" type="text" value="{{ old('address_ar') }}" id="example-address_ar-input" placeholder="خدمات العيادة باللغة العربية"/>
                            </div>
                        </div>
                        {{-- EN Address --}}
                        <div class="form-group row">
                            <label for="example-address_en-input" class="col-2 col-form-label">  عنوان العيادة باللغة الانجليزية</label>
                            <div class="col-10">
                                <input class="form-control" name="address_en" type="text" value="{{ old('address_en') }}" id="example-address_en-input" placeholder="خدمات العيادة باللغة الانجليزية"/>
                            </div>
                        </div>
                        {{-- Location --}}
                        <div class="form-group row">
                            <label for="example-location-input" class="col-2 col-form-label"> العنوان</label>
                            <div class="col-10">
                                <input class="form-control" name="location" type="text" value="{{ old('location') }}" id="example-location-input" placeholder=" العنوان علي الخريطة "/>
                            </div>
                        </div>
                        {{-- Longitude --}}
                        <div class="form-group row">
                            <label for="example-long-input" class="col-2 col-form-label">خطوط الطول</label>
                            <div class="col-10">
                                <input class="form-control" name="long" type="text" value="{{ old('long') }}" id="example-long-input" placeholder="خطوط الطول"/>
                            </div>
                        </div>
                        {{-- Latitude --}}
                        <div class="form-group row">
                            <label for="example-lat-input" class="col-2 col-form-label">دوائر العرض</label>
                            <div class="col-10">
                                <input class="form-control" name="lat" type="text" value="{{ old('lat') }}" id="example-lat-input" placeholder="دوائر العرض"/>
                            </div>
                        </div>
                        {{-- Price --}}
                        <div class="form-group row">
                            <label for="example-price-input" class="col-2 col-form-label">سعر الكشف</label>
                            <div class="col-10">
                            <input class="form-control" name="price" type="number" value="{{ (old('price') != null) ? old('price') : 0 }}" id="example-price-input"/>
                            </div>
                        </div>
                        {{-- is emergenc --}}
                        <div class="form-group row">
                            <label class="col-2 col-form-label">يدعم الطوارئ</label>
                            <div class="col-10">
                                <span class="switch switch-icon">
                                    <label>

                                        <input type="checkbox" checked="checked" name="is_emergenc" value="0"/>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>


                        {{-- City --}}
                        <div class="form-group row">
                            <label class="col-2 col-form-label" for="city">المدينة <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <select class="form-control" id="city" name="city_id">
                                    @foreach ( $cites as $city)
                                        <option value="{{ $city->id}}">{{ $city->name_ar}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                         {{-- district --}}
                         <div class="form-group row" id="district"></div>


                        <div class="form-group row">
                            <label class="col-form-label col-2">Tags</label>
                            <div class="col-10">
                                <input id="kt_tagify_1" class="form-control tagify" name='tags' placeholder='type...' value='css, html, javascript' autofocus="" data-blacklist='.NET,PHP' />
                                <div class="mt-3">
                                    <a href="javascript:;" id="kt_tagify_1_remove" class="btn btn-sm btn-light-primary font-weight-bold">Remove tags</a>
                                </div>
                                <div class="mt-3 text-muted">In this example, the field is pre-occupied with 4 tags. The last tag (CSS) has the same value as the first tag, and will be removed, because the duplicates setting is set to true.</div>
                            </div>
                        </div>



                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>



@endsection
@push('scripts')
    {{-- Select2 --}}
    <script src="{{ asset('dashboard') }}/assets/js/pages/crud/forms/widgets/select2.js"></script>
    {{-- touch spin --}}
    <script src="{{ asset('dashboard') }}/assets/js/pages/crud/forms/widgets/bootstrap-touchspin.js"></script>
    {{-- tagify --}}
    <script src="{{ asset('dashboard') }}/assets/js/pages/crud/forms/widgets/tagify.js"></script>
    {{-- date range picker --}}
    <script src="{{ asset('dashboard') }}/assets/js/pages/crud/forms/widgets/bootstrap-daterangepicker.js"></script>
    <script>
        var demos = function () {

        // input group and left alignment setup
        $('#kt_daterangepicker_2').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary'
            }, function(start, end, label) {
            $('#kt_daterangepicker_2 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
        });

        return {
        // public functions
            init: function() {
                demos();
            }
        };
        }();

        jQuery(document).ready(function() {
            KTBootstrapDaterangepicker.init();
        });
    </script>

    {{-- Text Editor --}}
    <script src="{{ asset('dashboard') }}/assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/pages/crud/forms/editors/tinymce.js"></script>
    <script>
    // Class definition

    var KTTinymce = function () {
        // Private functions
        var demos = function () {
            tinymce.init({
                selector: '#kt-tinymce-4',
                menubar: false,
                toolbar: ['styleselect fontselect fontsizeselect',
                    'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                    'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
                plugins : 'advlist autolink link image lists charmap print preview code'
            });
        }

    return {
        // public functions
        init: function() {
            demos();
        }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTTinymce.init();
    });
    </script>
    {{-- custom file upload --}}
    <script src="{{ asset('dashboard') }}/assets/js/pages/crud/file-upload/dropzonejs.js"></script>

    {{-- jQuery --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function(){

            $("#city").change(function(){
                    var cityId = $( this).val();
                $.ajax({
                    type:'GET',
                    url:'/admin/get-district/'+cityId,
                    data:'_token = <?php echo csrf_token() ?>',
                    success:function(data) {
                        console.log(data);
                        $("#district").html(data);
                    }
                });
            });

        });


    </script>

@endpush
