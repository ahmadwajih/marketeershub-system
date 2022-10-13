@extends('new_admin.layouts.app')
@push('styles')
    <style>
        .modal-content{
            width: 1250px;
            left: -350px;
        }
        #new_old_payout,
        #slaps_payout,
        #custom_payout{
            display: none;
        }
    </style>
@endpush
@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Coupons List</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Coupons</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Coupons List</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="content flex-column-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-user-table-filter="search"
                            class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">                       
                        <!--begin::Add user-->
                        @can('create_coupons')
                        <a href="{{ route('admin.coupons.upload.form') }}" class="btn btn-success mr-2" style="display: block !important;margin-right: 9px;">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Bulk Upload
                        </a>
                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                        rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add Coupon
                        </a>
                        
                        @endcan
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                            Selected</button>

                        <button type="button" class="btn btn-warning mx-2" data-bs-toggle="modal" data-bs-target="#kt_modal_scrollable_1">Edit Selected</button>
                    </div>
                    <!--end::Group actions-->
                    <!--begin::Modal - Adjust Balance-->
                    {{-- <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header">
                                    <!--begin::Modal title-->
                                    <h2 class="fw-bold">Export Users</h2>
                                    <!--end::Modal title-->
                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                    <!--begin::Form-->
                                    <form id="kt_modal_export_users_form" class="form" action="#">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">Select Roles:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                <option></option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="Analyst">Analyst</option>
                                                <option value="Developer">Developer</option>
                                                <option value="Support">Support</option>
                                                <option value="Trial">Trial</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold form-label mb-2">Select Export Format:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                <option></option>
                                                <option value="excel">Excel</option>
                                                <option value="pdf">PDF</option>
                                                <option value="cvs">CVS</option>
                                                <option value="zip">ZIP</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div> --}}
                    <!--end::Modal - New Card-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table id="kt_table_users" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                                </div>
                            </th>
                            <th>#</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Offer Name') }}</th>
                            <th>{{ __('Publisher Name') }}</th>
                            <th>{{ __('Publisher ID') }}</th>
                            <th>{{ __('Team') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Payout') }}</th>
                            <th class="text-end min-w-100px">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                    </tbody>
                </table>
                <!--end::Datatable-->
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Post-->

    <!--start::Modal-->
    <div class="modal fade" tabindex="-1" id="payout_details">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Payout Details</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>
    
                <div class="modal-body" id="payout_details_body">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
    <!--start::Modal-->
    
        <div class="modal fade" tabindex="-1" id="kt_modal_scrollable_1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Bulk edit coupons') }}</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body" >
                        <form action="{{ route('admin.coupons.bulk.update') }}" method="post" id="bulk_edit_coupon_form">
                            @csrf
                            <div class="col-md-11">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Publisher</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="user_id" data-control="select2" class="form-select">
                                        <option selected value=""> {{ __('No One') }}</option>
                                        @foreach ($publishers as $publisher)
                                            <option {{ old('user_id') == $publisher->id ? 'selected' : '' }} value="{{ $publisher->id }}"> {{ $publisher->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    @if ($errors->has('user_id'))
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div data-field="text_input">{{ $errors->first('user_id') }}</div>
                                        </div>
                                    @endif
                                </div>
                                <!--end::Input group-->
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch form-check-custom form-check-solid mt-13">
                                    <input class="form-check-input switcher" type="checkbox" data-input="select" name="have_custom_payout"
                                        onchange="switcherFunctionXpng('custom_payout', this)" value="off" />
                                    <label class="form-check-label">
                                        Custom Payout
                                    </label>
                                </div>
                            </div>
                           <div id="custom_payout">
                            <div class="col-md-11">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">CPS Type</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="payout_cps_type" data-control="select2" class="form-select"
                                        id="cps_type_payout">
                                        <option {{ old('revenue_cps_type') == 'static' ? 'selected' : '' }} value="static"> {{ __('Fixed Model') }}</option>
                                        <option {{ old('revenue_cps_type') == 'new_old' ? 'selected' : '' }} value="new_old"> {{ __('New-old Model') }}</option>
                                        <option {{ old('revenue_cps_type') == 'slaps' ? 'selected' : '' }} value="slaps"> {{ __('Slabs Model') }}</option>
                                    </select>
                                    <!--end::Input-->
                                    @if ($errors->has('payout_cps_type'))
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div data-field="text_input">{{ $errors->first('payout_cps_type') }}</div>
                                        </div>
                                    @endif
                                </div>
                                <!--end::Input group-->
                            </div>
                            @include('new_admin.coupons.payout.cps_static_offer')
                            @include('new_admin.coupons.payout.cps_new_old_offer')
                            @include('new_admin.coupons.payout.cps_slaps_offer')
                           </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  data-kt-user-table-select="edit_selected">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <!--end::Modal-->


@endsection
@push('scripts')
    <script>
        var route = "{{ route('admin.coupons.index') }}";
    </script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/coupons/table.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/coupons/edit.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/coupons/change-status.js"></script>
    <script src="{{ asset('new_dashboard') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script>
        function switcherFunctionXpng(switcherId, switcher) {
            if (switcher.value == 'on') {

                switcher.value = 'off';
                $('#' + switcherId).fadeOut('slow');
            } else {
                switcher.value = 'on';
                $('#' + switcherId).fadeIn('slow');
            }
        }
    </script>
    <script>

        function switcherFunction(switcher) {

            var switcherParent = switcher.parentNode.parentNode.parentNode;
            if (switcher.value == 'on') {

                switcher.value = 'off';
                if (switcher.getAttribute('data-input') == 'text') {
                    var selectedInput = switcherParent.querySelectorAll("input[type='text']");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = true;
                    }

                }
                if (switcher.getAttribute('data-input') == 'select') {
                    var selectedInput = switcherParent.querySelectorAll("select");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = true;
                    }

                }
            } else {
                switcher.value = 'on';
                if (switcher.getAttribute('data-input') == 'text') {
                    var selectedInput = switcherParent.querySelectorAll("input[type='text']");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = false;
                    }
                }
                if (switcher.getAttribute('data-input') == 'select') {
                    var selectedInput = switcherParent.querySelectorAll("select");
                    for(var i = 0; i < selectedInput.length; i++){
                        selectedInput[i].disabled = false;
                    }
                }
            }
        }
    </script>
      <script>
        $('#kt_docs_repeater_advanced_payout').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select22"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                // Init select2
                $('[data-kt-repeater="select22"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });
    </script>
    <script>
        $('#kt_docs_repeater_advanced_new_old_payout').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select-payout"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function() {
                // Init select2
                $('[data-kt-repeater="select-payout"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });

        $('#kt_docs_repeater_slaps_payout').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });


    </script>
    <script>
        $("#cps_type_payout").change(function() {
                if ($(this).val() == 'new_old') {
                    $('#static_payout').fadeOut();
                    $('#slaps_payout').fadeOut();
                    $('#new_old_payout').fadeIn();
                }
                if ($(this).val() == 'static') {
                    $('#static_payout').fadeIn();
                    $('#slaps_payout').fadeOut();
                    $('#new_old_payout').fadeOut();
                }
                if ($(this).val() == 'slaps') {
                    $('#static_payout').fadeOut();
                    $('#slaps_payout').fadeIn();
                    $('#new_old_payout').fadeOut();
                }
            });
    </script>

    <script>
        function loadPayoutDetails(couponId){
            $.ajax({
                method: "GET",
                headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: route + "/load/payout",
                data: {
                    id: couponId,
                },
            })
                .done(function (res) {
                    $('#payout_details_body').html(res);                
                })
                .fail(function (res) {
                    Swal.fire({
                        text:
                        name + " was not " + action,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton:
                                "btn fw-bold btn-primary",
                        },
                    });
                });
        }
    </script>
@endpush
