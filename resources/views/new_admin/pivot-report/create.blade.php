@extends('new_admin.layouts.app')
@section('title', 'Update Reports')
@section('subtitle', 'Upload')
@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Upload Report</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Reports</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Upload</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <!--begin::Form-->
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{route('admin.reports.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="row">

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Type</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="type" data-control="select2" class="form-select">
                                                <option value="update">{{ __('Update') }}</option>
                                                <option value="validation">{{ __('Validation Report') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('type'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('type') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-12">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label required">Offers</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="offer"  name="offer_id" data-control="select2" class="form-select form-select-sm" required>
                                                <option selected disabled value="">Select offer</option>
                                                @foreach($offers as $offer)
                                                    <option {{old('offer_id')==$offer->id?"selected":""}} value="{{$offer->id}}">{{$offer->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('offer_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('offer_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Excel File</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="file" name="report" class="form-control mb-2"  required />

                                            @if ($errors->has('report'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('report') }}</div></div>
                                            @endif
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <a id="download_btn" href="javascript:void(0)" class="btn btn-primary mt-3 btn-block d-none" download>{{ __('Select Offer First') }}</a>
                                    </div>
                                    @if(session('columnHaveIssue'))
                                        <a class="btn btn-danger" href="{{ route('admin.reports.deonload.errore') }}">Download Errors</a>
                                    @endif

                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->

                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="reset" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
                <button id="loading-button" class="btn btn-primary d-none" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only">Loading...</span>
                    Please wait...
                </button>
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

@endsection
@push('scripts')
    <script>
        let route = "{{ route('admin.reports.index') }}";
    </script>
    <script>
    $(document).ready(function(){
        document.forms["kt_ecommerce_add_product_form"].addEventListener("submit", async (event) => {
            event.preventDefault();
            $("#loading-button").removeClass("d-none");
            $("#kt_ecommerce_add_product_submit").addClass("d-none");
            try {
                const resp = await fetch(event.target.action, {
                    method: "POST",
                    body: new FormData(event.target),
                });
                const body = await resp.json();
                console.log(body);
                if(body.error){
                    let error = true;
                }
            }catch (e) {
                console.log(e);
            }
            window.location.href = route + '?uploading=true';
        });
        $("#offer").change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get({
                url: '{{ route('admin.define.excel.sheet.columns') }}',
                data: {
                    offer_id: $(this).val(),
                },
                beforeSend: function() {
                    $('#loading').show()
                },
                success: function(data) {
                    if(data.link || data.title){
                        $('#download_btn').removeClass('d-none');
                        $('#download_btn').attr("href", data.link);
                        $('#download_btn').html(data.title);
                    }else{
                        $('#download_btn').addClass('d-none');
                    }
                },
                complete: function() {
                    $('#loading').hide()
                }
            });
        });
    });
</script>
@endpush
