@extends('new_admin.layouts.app')
@section('content')
    <!--begin::Toolbar-->
    <div class="d-flex flex-wrap flex-stack pb-7">
        <!--begin::Title-->
        <div class="d-flex flex-wrap align-items-center my-1">
            <h3 class="fw-bold me-5 my-1">Offers ({{ $offers->count() }})</h3>
        </div>
        <!--end::Title-->
        <!--begin::Controls-->
        <div class="d-flex flex-wrap my-1">
            <!--begin::Tab nav-->
            <ul class="nav nav-pills me-6 mb-2 mb-sm-0">
                <li class="nav-item m-0">
                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary me-3 " data-bs-toggle="tab" href="#kt_project_users_card_pane">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor" />
                                    <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                    <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                    <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3" />
                                </g>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                </li>
                <li class="nav-item m-0">
                    <a class="btn btn-sm btn-icon btn-light btn-color-muted btn-active-primary active" data-bs-toggle="tab" href="#kt_project_users_table_pane">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                                <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                </li>
            </ul>
            <!--end::Tab nav-->

        </div>
        <!--end::Controls-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Tab Content-->
    <div class="tab-content">
        <!--begin::Tab pane-->
        <div id="kt_project_users_card_pane" class="tab-pane fade">
            <!--begin::Row-->
           
            <div class="row g-6 g-xl-9">
                @foreach ($offers as $offer)
                 <!--begin::Col-->
                 <div class="col-md-6 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-65px symbol-circle mb-5">
                                <img src="{{ getImagesPath('Offers', '') }}" alt="image" />
                                <div class="bg-success position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ $offer->name }}</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="fw-semibold text-gray-400 mb-6">
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
                            </div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="text-left">
                                <p class="p-0 m-0">Advertiser: {{ $offer->advertiser->company_name }}</p>
                                <hr>
                                <p class="p-0 m-0">Revenue Type: {{ $offer->cps_type == 'static' ? $offer->revenue_type : '' }} {{ $offer->cps_type == 'new_old' ? ($offer->newOld ? $offer->newOld->new_revenue_type : '') : '' }}</p>
                                <hr>
                                <p class="p-0 m-0">CPS Type: {{ $offer->cps_type }}</p>
                                <hr>
                                <p class="p-0 m-0">Discount: {{ $offer->discount }}{{ $offer->discount_type == 'percentage' ? '%' : ' ' .$offer->currency->code }}</p>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            @endforeach
            </div>
            <!--end::Row-->
            <!--begin::Pagination-->
            {{-- <div class="d-flex flex-stack flex-wrap pt-10">
                <div class="fs-6 fw-semibold text-gray-700">Showing 1 to 10 of 50 entries</div>
                <!--begin::Pages-->
                <ul class="pagination">
                    <li class="page-item previous">
                        <a href="#" class="page-link">
                            <i class="previous"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a href="#" class="page-link">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">2</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">3</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">4</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">5</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">6</a>
                    </li>
                    <li class="page-item next">
                        <a href="#" class="page-link">
                            <i class="next"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Pages-->
            </div> --}}
            <!--end::Pagination-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
        <div id="kt_project_users_table_pane" class="tab-pane fade show active">
            <!--begin::Card-->
            <div class="card card-flush">

                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    @can('create_offers')
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add product-->
                        <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">Add Offer</a>
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
                    @endcan
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed" id="kt_ecommerce_products_table">
                            <!--begin::Head-->
                            <thead class="fs-7 text-gray-400 text-uppercase">
                                <tr>
                                    <th class="min-w-250px">Thumbnail</th>
                                    <th class="min-w-90px">Status</th>
                                    <th class="min-w-90px">Revenue Type</th>
                                    <th class="min-w-90px">CPS Type</th>
                                    <th class="min-w-90px">Discount</th>
                                    <th class="min-w-90px">Target Market</th>
                                    <th class="min-w-90px">Discount</th>
                                    <th class="min-w-50px text-end">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Head-->
                            <!--begin::Body-->
                            <tbody class="fs-6">
                                @foreach ($offers as $offer)
                                    <tr>
                                        <td>
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Wrapper-->
                                                <div class="me-5 position-relative">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="{{ getImagesPath('Offers', '') }}" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a href="" class="mb-1 text-gray-800 text-hover-primary" data-kt-ecommerce-product-filter="offer_name">{{ $offer->name }}</a>
                                                    @if($offer->advertiser)<div class="fw-semibold fs-6 text-gray-400">{{  $offer->advertiser->company_name_en }}</div>@endif
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::User-->
                                        </td>
                                        <td data-order="{{ $offer->status }}">
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
                                        <td>{{ $offer->cps_type == 'static' ? $offer->revenue_type : '' }} {{ $offer->cps_type == 'new_old' ? ($offer->newOld ? $offer->newOld->new_revenue_type : '') : '' }}</td>
                                        <td>{{ $offer->cps_type }}</td>
                                        <td>{{ $offer->discount }}{{ $offer->discount_type == 'percentage' ? '%' : ' ' .$offer->currency->code }}</td>
                                        <td>
                                            @foreach ($offer->countries as $country)
                                                {{ $country->name_en }} @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td> {{ $offer->discount }}{{ $offer->discount_type == 'percentage' ? '%' : ' ' .$offer->currency->code }}
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon--></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.offers.show', $offer->id) }}" class="menu-link px-3">View</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    @can('update_offers')
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.offers.edit', $offer->id) }}" class="menu-link px-3">Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    @endcan
                                                    @can('delete_offers')
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" data-kt-delte-url="{{ route('admin.offers.destroy', $offer->id) }}" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    @endcan
                                                </div>
                                                <!--end::Menu-->
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <!--end::Body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Tab pane-->
    </div>
    <!--end::Tab Content-->
@endsection
@push('scripts')
<script src="{{ asset('new_dashboard') }}/js\datatables\offers.js"></script>

@endpush
