@extends('new_admin.layouts.app')
@push('styles')
    <style>
        table tr {
            border-bottom: 1px dashed #eee !important;
        }
        
    </style>
@endpush
@section('content')
    <!--begin::Row-->
    <div id="overview" class="tab">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header d-flex justify-content-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title text-center">
                    <h2 class="mb-9">{{ $offer->name }}</h2>
                </div>
            </div>
            <!--begin::Body-->
            <div class="card-body py-10">
                <div class="me-7 mb-4 m-auto text-center">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ asset('new_dashboard') }}/media/avatars/300-1.jpg" alt="image" />
                    </div>
                </div>

                <table class="table">
                    <tr>
                        <td><strong>{{ __('Name') }} : </strong></td>
                        <td>{{ $offer->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Description') }} : </strong></td>
                        <td>{{ $offer->description }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Advertiser') }} : </strong></td>
                        <td>{{ $offer->advertiser ? $offer->advertiser->company_name : '' }}</td>
                    </tr>
                    @if ($offer->offer_url)
                        <tr>
                            <td><strong>{{ __('Offer URL') }} : </strong></td>
                            <td><a href="{{ $offer->offer_url }}">{{ $offer->offer_url }}</a></td>
                        </tr>
                    @endif
                    @if ($offer->categories->count() > 0)
                        <tr>
                            <td><strong>{{ __('Category') }} : </strong></td>
                            <td>
                                @foreach ($offer->categories as $category)
                                    <span class="badge badge-light m-1">{{ $category->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if ($offer->countries->count() > 0)
                        <tr>
                            <td><strong>{{ __('Geo`s') }} : </strong></td>
                            <td>
                                @foreach ($offer->countries as $country)
                                    <span class="badge badge-light m-1">{{ $country->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if ($offer->payout_type)
                        <tr>
                            <td><strong>{{ __('Payout Type') }} : </strong></td>
                            <td>{{ $offer->payout_type }}</td>
                        </tr>
                    @endif
                    @if ($offer->default_payout)
                        <tr>
                            <td><strong>{{ __('Payout Default') }} : </strong></td>
                            <td>{{ $offer->default_payout }}</td>
                        </tr>
                    @endif
                    @if ($offer->discount)
                        <tr>
                            <td><strong>{{ __('Discount') }} : </strong></td>
                            <td>{{ $offer->discount }}
                                {{ $offer->discount_type == 'percentage' ? '%' : ($offer->currency ? $offer->currency->code : '') }}
                            </td>
                        </tr>
                    @endif
                    @if ($offer->expire_date)
                        <tr>
                            <td><strong>{{ __('Expire Date') }} : </strong></td>
                            <td>{{ $offer->expire_date }}</td>
                        </tr>
                    @endif
                    @if ($offer->status)
                        <tr>
                            <td><strong>{{ __('Status') }} : </strong></td>
                            <td>
                                @if ($offer->status == 'active')
                                    <span class="badge badge-success">Active</span>
                                @elseif ($offer->status == 'pused')
                                    <span class="badge badge-warning">Pused</span>
                                @elseif ($offer->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($offer->status == 'expire')
                                    <span class="badge badge-danger">Expire</span>
                                @else
                                @endif
                            </td>
                        </tr>
                    @endif
                    @if ($offer->note)
                    <tr>
                        <td><strong>{{ __('Note') }} : </strong></td>
                        <td>{{ $offer->note }}</td>
                    </tr>
                    @endif
                    @if ($offer->terms_and_conditions)
                    <tr>
                        <td><strong>{{ __('Terms And Conditions') }} : </strong></td>
                        <td>{{ $offer->terms_and_conditions }}</td>
                    </tr>
                    @endif

                </table>
            </div>
            <!--end::Body-->
        </div>

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
                                <button type="button" class="btn btn-warning mx-2" data-kt-user-table-select="edit_selected">Edit
                                    Selected</button>
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
    <!--End::Row-->
@endsection
@push('scripts')
    <script>
        var couponsRoute = "{{ route('admin.offers.coupons', ['offer' => $offer->id]) }}";
        var route = "{{ route('admin.coupons.index') }}";
    </script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/offers/coupons.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/coupons/edit.js"></script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/coupons/change-status.js"></script>
@endpush
