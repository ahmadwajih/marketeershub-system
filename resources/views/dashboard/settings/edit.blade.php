@extends('dashboard.layouts.app')
@section('title','تعديل اعدادات الموقع')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        اعدادات الموقع
                    </h3>
                </div>
                <!--begin::Form-->
                <form action="{{route('admin.settings.update', 1)}}" enctype="multipart/form-data" method="POST">
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
                    @method('put')
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-form-label col-2">لوجو الموقع (فاتح اللون)</label>
                            <div class="col-5">
                                <input type="file" name="light_logo">
                            </div>
                            <div class="col-5">
                                <img src="{{asset(getImagesPath('Settings').$settings->light_logo)}}" alt="" width="60" height="60">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-2">لوجو الموقع (غامق اللون)</label>
                            <div class="col-5">
                                <input type="file" name="dark_logo">
                            </div>
                            <div class="col-5">
                                <img src="{{asset(getImagesPath('Settings').$settings->dark_logo)}}" alt="" width="60" height="60">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-2">لوجو الموقع في الفوتر </label>
                            <div class="col-5">
                                <input type="file" name="footer_logo">
                            </div>
                            <div class="col-5">
                                <img src="{{asset(getImagesPath('Settings').$settings->footer_logo)}}" alt="" width="60" height="60">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-2"> أيقونة الموقع</label>
                            <div class="col-5">
                                <input type="file" name="favicon">
                            </div>
                            <div class="col-5">
                                <img src="{{asset(getImagesPath('Settings').$settings->favicon)}}" alt="" width="60" height="60">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-2">ايقونه التحميل</label>
                            <div class="col-5">
                                <input type="file" name="loader">
                            </div>
                            <div class="col-5">
                                <img src="{{asset(getImagesPath('Settings').$settings->loader)}}" alt="" width="60" height="60">
                            </div>
                        </div>

                        {{--  Website Language  --}}
                        <div class="form-group row">
                            <label for="example-name-ar-input" class="col-2 col-form-label">لغه الموقع</label>
                            <div class="col-10">
                                <select class="form-control" id="exampleSelectd" name="lang">
                                    <option value="ar">العربية</option>
                                    <option value="en">English</option>
                                </select>                            
                            </div>
                        </div>

                        {{--  Website Name  --}}
                        <div class="form-group row">
                            <label for="example-name-ar-input" class="col-2 col-form-label">اسم الموقع</label>
                            <div class="col-10">
                                <input class="form-control" name="meta_title" type="text" value="{{ $settings->meta_title }}" id="example-name-ar-input" placeholder="اسم الموقع"/>
                            </div>
                        </div>

                        {{--  Footer Text   --}}
                        <div class="form-group row">
                            <label for="example-name-ar-input" class="col-2 col-form-label">نص الفوتر </label>
                            <div class="col-10">
                                <input class="form-control" name="footer_text" type="text" value="{{ $settings->footer_text }}" id="example-name-ar-input" placeholder="نص الفوتر"/>
                            </div>
                        </div>
                        {{-- SLider --}}
                        <div class="form-group row">
                            <label class="col-form-label col-2">الاسليدر</label>
                            <div class="col-2">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" name="slider_status" value="1" {{$settings->slider_status==1?"checked":""}} name="select" />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                      
                        </div>

                        {{-- Send SMS --}}
                        <div class="form-group row">
                            <label class="col-form-label col-2">ارسال الرسائل </label>
                            <div class="col-2">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" name="sms" value="1" {{$settings->sms==1?"checked":""}} name="select" />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                      
                        </div>

                        {{-- Send Emails --}}
                        <div class="form-group row">
                            <label class="col-form-label col-2">ارسال الايميلات</label>
                            <div class="col-2">
                                <span class="switch switch-icon">
                                    <label>
                                        <input type="checkbox" name="email" value="1" {{$settings->email==1?"checked":""}} name="select" />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                      
                        </div>

                        <b dir="rtl"> تحسين ال SEO</b>
                        {{-- Description  --}}
                        <div class="form-group row">
                            <label for="example-name-en-input" class="col-2 col-form-label">وصف الموقع </label>
                            <div class="col-10">
                                <input class="form-control" name="meta_description" type="text" value="{{ $settings->meta_description }}" id="example-name-en-input" placeholder="وصف الموقع "/>
                            </div>
                        </div>

                        {{-- Key Words --}}
                        <div class="form-group row">
                            <label for="example-app_description_ar-input" class="col-2 col-form-label">الكلمات الداليلية</label>
                            <div class="col-10">
                                <input class="form-control" name="meta_keywords" type="text" value="{{ $settings->meta_keywords }}" id="example-app_description_ar-input" placeholder="الكلمات الدالبيلية"/>
                            </div>
                        </div>

                        {{-- Author  --}}
                        <div class="form-group row">
                            <label for="example-app_description_ar-input" class="col-2 col-form-label">مالك الموقع</label>
                            <div class="col-10">
                                <input class="form-control" name="meta_auther" type="text" value="{{ $settings->meta_auther }}" id="example-app_description_ar-input" placeholder="مالك الوقع"/>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="form-group row">
                            <label for="example-address-input" class="col-2 col-form-label">  العنوان  </label>
                            <div class="col-10">
                                <input class="form-control" name="address" type="text" value="{{ $settings->address }}" id="example-address-input" placeholder="العنوان"/>
                            </div>
                        </div>

                         {{-- Footer text --}}
                         <div class="form-group row">
                            <label for="example-address-input" class="col-2 col-form-label">  النص في الفوتر  </label>
                            <div class="col-10">
                                <input class="form-control" name="footer_text" type="text" value="{{ $settings->footer_text }}" id="example-footer_text-input" placeholder="النص في الفوتر"/>
                            </div>
                        </div>


                         {{-- Copy Rights --}}
                         <div class="form-group row">
                            <label for="example-address-input" class="col-2 col-form-label">   حقوق النشر  </label>
                            <div class="col-10">
                                <input class="form-control" name="copyright" type="text" value="{{ $settings->copyright }}" id="example-copyright-input" placeholder="النص في الفوتر"/>
                            </div>
                        </div>

                        {{--  facebook  --}}
                        <div class="form-group row">
                            <label for="example-facebook-input" class="col-2 col-form-label">Facebook</label>
                            <div class="col-10">
                                <input class="form-control" name="facebook" type="text" value="{{ $settings->facebook }}" id="example-facebook-input" placeholder="Facebook"/>
                            </div>
                        </div>
                        {{-- LinkedIn --}}
                        <div class="form-group row">
                            <label for="example-linkedin-input" class="col-2 col-form-label">LinkedIn</label>
                            <div class="col-10">
                                <input class="form-control" name="linkedin" type="text" value="{{ $settings->linkedin }}" id="example-linkedin-input" placeholder="LinkedIn"/>
                            </div>
                        </div>
                        {{--  Twitter --}}
                        <div class="form-group row">
                            <label for="example-twitter-input" class="col-2 col-form-label">Twitter</label>
                            <div class="col-10">
                                <input class="form-control" name="twitter" type="text" value="{{ $settings->twitter }}" id="example-twitter-input" placeholder="Twitter"/>
                            </div>
                        </div>
                        {{-- Instgram  --}}
                        <div class="form-group row">
                            <label for="example-instagram-input" class="col-2 col-form-label"> Instagram</label>
                            <div class="col-10">
                                <input class="form-control" name="instagram" type="text" value="{{ $settings->instagram }}" id="example-instagram-input" placeholder="Instagram"/>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">حفظ</button>
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

@endpush
