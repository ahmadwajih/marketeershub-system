@extends('new_admin.layouts.app')
@section('title', 'Coupons')
@section('subtitle', 'Index')
@push('styles')
    <style>
        .modal-content {
            width: 1250px;
            left: -350px;
        }

        #new_old_payout,
        #slaps_payout,
        #custom_payout {
            display: none;
        }

        span.select2-container {
            z-index: 10050;
        }
    </style>
    <style>
        .uploading-progress-bar{
            position: fixed;
            z-index: 999;
            background: #474761;
            width: 37% !important;
            height: 20% !important;
            border-radius: 10px;
            box-shadow: 8px 13px 33px 1px #171623;
            margin: 151px;
        }
        .uploading-progress-bar .progress{
            margin: 3% auto auto;
            height: 26px;
            width: 63%;
        }
        .progress-title{
            margin-top: 10%;
        }
    </style>

@endpush
@section('content')
    @if(isset(request()->success) && request()->success == 'true')
         <!--begin::Alert-->
         <div class="alert alert-success d-flex align-items-center p-5">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3"><i class="fa-solid fa-check fa-2x"></i></span>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark">Success</h4>
                <!--end::Title-->
                <!--begin::Content-->
                <p> {{ Session::get('uploaded_coupons') . ' ' . __('Coupon Uploaded Successfully.') }}</p>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Close-->
                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                    <span class="svg-icon svg-icon-2x svg-icon-light"><i class="fa-solid fa-xmark fa-2x"></i></span>
                </button>
                <!--end::Close-->
        </div>
        <!--end::Alert-->
    @endif
    <div class="uploading-progress-bar d-none">
        <h3 class="text-center progress-title">Uploading...</h3>
          <div class="progress">
            <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><h5 id="progress-bar-percentage"><strong>0%</strong></h5></div>
        </div>
    </div>
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
                       <form action="{{ route('admin.coupons.index') }}">
                            <!--end::Svg Icon-->
                            <div class="input-group mb-5">
                                <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}"/>
                                <button class="input-group-text" id="basic-addon2">Go</button>  <span class="mx-3 mt-3"> {{ $coupons->total() }} Coupon</span>
                            </div>

                        </form>

                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div id="add_btn" class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Filter-->
                        <a href="#" class="btn btn-light fw-bold mx-3" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            Filter
                        </a>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                            id="kt_menu_62cfb00b8671a">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Menu separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Menu separator-->
                            <!--begin::Form-->
                            <form action="{{ route('admin.coupons.index') }}" method="GET">
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Offer:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid"  name="offer_id" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a" >
                                                <option value="">No One</option>
                                                @foreach ($offers as $offer)
                                                    <option {{ session('coupons_filter_offer_id') == $offer->id ? 'selected' :''}} value="{{ $offer->id }}">{{ $offer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        @include('new_admin.components.publishers_filter')
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Publisher:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid publishers_filter" name="user_id" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a">
                                                <option value="">No One</option>
                                                @if($publisherForFilter)
                                                    <option value="{{$publisherForFilter->id}}" selected >{{$publisherForFilter->name}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" name="status" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a"
                                                >
                                                <option value="">No One</option>
                                                <option {{ session('coupons_filter_status') == 'active' ? 'selected' :''}} value="active">{{ __('Active') }}</option>
                                                <option {{ session('coupons_filter_status') == 'inactive' ? 'selected' :''}} value="inactive">{{ __('Inactive') }}</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.coupons.clear.sessions') }}" class="btn btn-sm btn-secondary w-100 mx-2">Clear Filter</a>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Menu 1-->

                        <!--end::Filter-->
                        <!--begin::Add user-->
                        @can('create_coupons')
                            <a href="{{ route('admin.coupons.upload.form') }}" class="btn btn-success mr-2"
                                style="display: block !important;margin-right: 9px;">
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
                    @can('delete_coupons')
                        <!--begin::Group actions-->
                        <div id="delete_btn" class="d-flex justify-content-end align-items-center d-none"
                            data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" id="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger" onclick="delete_selected()" >Delete Selected</button>

                            <button type="button" class="btn btn-warning mx-2" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_scrollable_1">Edit Selected</button>
                        </div>
                        <!--end::Group actions-->
                    @endcan

                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table class="table table-hover gy-3 gs-3">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" id="main_form_check" type="checkbox" data-kt-check="true" value="1" />
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
                        <tbody>
                            @if(count($coupons) > 0)
                            @foreach ($coupons as $coupon)
                                <tr class="tr-{{ $coupon->id }}">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input table-checkbox" name="item_check" type="checkbox"
                                                value="{{ $coupon->id }}" />
                                        </div>
                                    </td>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->coupon }}</td>
                                    <td>{{ $coupon->offer ? $coupon->offer->name :'' }}</td>
                                    <td>{{ $coupon->user ? $coupon->user->name : '' }}</td>
                                    <td>{{ $coupon->user ? $coupon->user->id : '' }}</td>
                                    <td>{{ $coupon->user ? $coupon->user->updated_team : '' }}</td>
                                    <td>
                                        <button onclick="changeStatus('{{ $coupon->id }}','{{ $coupon->coupon }}', 'inactive')" class="btn btn-light-success btn-sm  active-btn-{{ $coupon->id }} {{ $coupon->status == 'active' ?: 'd-none' }}">Active</button>
                                        <button onclick="changeStatus('{{ $coupon->id }}','{{ $coupon->coupon }}', 'active')" class="btn btn-light-danger btn-sm inactive-btn-{{ $coupon->id }} {{ $coupon->status == 'inactive' ?: 'd-none' }}">Inactive</button>
                                    </td>
                                    <td>
                                        <button onclick="loadPayoutDetails('{{ $coupon->id }}')" data-bs-toggle="modal"
                                            data-bs-target="#payout_details" class="btn btn-light-info btn-sm ">Show
                                            Payout</button>
                                    </td>
                                    <td>
                                        @can('update_coupons')
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                                            class="menu-link px-3">Edit</a>
                                                    </div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)" class="menu-link px-3" onclick="delete_row('{{ $coupon->id }}', '{{ $coupon->coupon }}')">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="10">
                                        <!--begin::Alert-->
                                        <div class="alert alert-danger d-flex align-items-center p-5 text-center">
                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column text-center">
                                                <!--begin::Content-->
                                                <span>{{ __('There is no data') }}</span>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Alert-->
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <div>
                            @include('new_admin.components.table_length')
                        </div>
                        <div>
                            {!! $coupons->links() !!}
                        </div>
                    </div>
                </div>



                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Post-->
    <!--start::Modal-->
    <div class="modal fade" id="payout_details">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Payout Details</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
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
    <div class="modal fade" id="kt_modal_scrollable_1" role="dialog" aria-hidden="false">
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

                <div class="modal-body" style="overflow:hidden;">

                    <form action="{{ route('admin.coupons.bulk.update') }}" method="post" id="bulk_edit_coupon_form">
                        @csrf
                        <div class="col-md-11">

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                @include('new_admin.components.publishers_filter')

                                <!--begin::Label-->
                                <label class="form-label">Publisher</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="user_id" id="mySelect2" data-control="select2"
                                    class="form-select publisher-select-2 publishers_filter" data-placeholder="Select an option">
                                    <option selected value=""> {{ __('No One') }}</option>
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
                                <input class="form-check-input switcher" type="checkbox" data-input="select"
                                    name="have_custom_payout" onchange="switcherFunctionXpng('custom_payout', this)"
                                    value="off" />
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
                                        <option {{ old('revenue_cps_type') == 'static' ? 'selected' : '' }}
                                            value="static"> {{ __('Fixed Model') }}</option>
                                        <option {{ old('revenue_cps_type') == 'new_old' ? 'selected' : '' }}
                                            value="new_old"> {{ __('New-old Model') }}</option>
                                        <option {{ old('revenue_cps_type') == 'slaps' ? 'selected' : '' }} value="slaps">
                                            {{ __('Slabs Model') }}</option>
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
                            @include('new_admin.coupons.create.payout.cps_static_offer')
                            @include('new_admin.coupons.create.payout.cps_new_old_offer')
                            @include('new_admin.coupons.create.payout.cps_slaps_offer')
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-kt-user-table-select="edit_selected">Save
                        changes</button>
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
    <script src="{{ asset('new_dashboard') }}/js/datatables/coupons/delete.js"></script>
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
                    for (var i = 0; i < selectedInput.length; i++) {
                        selectedInput[i].disabled = true;
                    }

                }
                if (switcher.getAttribute('data-input') == 'select') {
                    var selectedInput = switcherParent.querySelectorAll("select");
                    for (var i = 0; i < selectedInput.length; i++) {
                        selectedInput[i].disabled = true;
                    }

                }
            } else {
                switcher.value = 'on';
                if (switcher.getAttribute('data-input') == 'text') {
                    var selectedInput = switcherParent.querySelectorAll("input[type='text']");
                    for (var i = 0; i < selectedInput.length; i++) {
                        selectedInput[i].disabled = false;
                    }
                }
                if (switcher.getAttribute('data-input') == 'select') {
                    var selectedInput = switcherParent.querySelectorAll("select");
                    for (var i = 0; i < selectedInput.length; i++) {
                        selectedInput[i].disabled = false;
                    }
                }
            }
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#main_form_check').change(function(){
                if(this.checked) {
                    $('.table-checkbox').prop('checked', true);
                    $('#delete_btn').removeClass('d-none');
                    $('#add_btn').addClass('d-none');
                }else{
                    $('.table-checkbox').prop('checked', false);
                    $('#delete_btn').addClass('d-none');
                    $('#add_btn').removeClass('d-none');
                }
                var numberOfChecked = $('.table-checkbox:checked').length;
                $('#selected_count').html(numberOfChecked);
            });

            $('.table-checkbox').change(function(){
                var numberOfChecked = $('.table-checkbox:checked').length;
                if(this.checked) {
                    $('#delete_btn').removeClass('d-none');
                    $('#add_btn').addClass('d-none');
                }else{
                    if(numberOfChecked == 0){
                        $('#delete_btn').addClass('d-none');
                        $('#add_btn').removeClass('d-none');
                    }
                }
                numberOfChecked = $('.table-checkbox:checked').length;
                $('#selected_count').html(numberOfChecked);
            });

        });
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
            show: function() {
                $(this).slideDown();
            },
            hide: function(deleteElement) {
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
        function loadPayoutDetails(couponId) {
            $.ajax({
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: route + "/load/payout",
                    data: {
                        id: couponId,
                    },
                })
                .done(function(res) {
                    $('#payout_details_body').html(res);
                })
                .fail(function(res) {
                    Swal.fire({
                        text: name + " was not " + action,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                })
            ;
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#mySelect2").select2({
                dropdownParent: $("#kt_modal_scrollable_1")
            });
        });
    </script>
    @if(isset(request()->uploading) && request()->uploading == 'true')
        <script>
            let status_url = "{{ route('admin.coupons.upload.status') }}";
        </script>
        <script src="{{ asset('new_dashboard') }}/js/import.js"></script>
    @endif
@endpush
