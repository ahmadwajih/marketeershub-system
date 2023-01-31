@extends('new_admin.layouts.app')
@section('title', 'Offers')
@section('subtitle', 'View')
@push('styles')
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
    <!--begin::Toolbar-->
    <div class="d-flex flex-wrap flex-stack pb-7">
        <!--begin::Title-->
        <div class="d-flex flex-wrap align-items-center my-1">
            <h3 class="fw-bold me-5 my-1">Offers ({{ $offers->count() }})</h3>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Tab Content-->
    <div class="tab-content">
        <div class="uploading-progress-bar d-none">
            <h3 class="text-center progress-title">Uploading...</h3>
            <div class="progress">
                <div id="progress-bar"
                     class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                     role="progressbar"
                     style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                >
                    <h5 id="progress-bar-percentage"><strong>0%</strong></h5>
                </div>
            </div>
        </div>

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
                                <img src="{{ getImagesPath('Offers', $offer->thumbnail) }}" alt="image" />
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
                                @if($offer->advertiser)
                                <p class="p-0 m-0">Advertiser: {{ $offer->advertiser->company_name }}</p>
                                <hr>
                                @endif
                                <p class="p-0 m-0">Revenue Type: {{ $offer->cps_type == 'static' ? $offer->revenue_type : '' }} {{ $offer->cps_type == 'new_old' ? ($offer->newOld ? $offer->newOld->new_revenue_type : '') : '' }}</p>
                                <hr>
                                <p class="p-0 m-0">CPS Type: {{ $offer->cps_type }}</p>
                                <hr>
                                @if($offer->discount)
                                <p class="p-0 m-0">Discount: {{ $offer->discount }}</p>
                                @endif
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
                            <form action="{{ route('admin.offers.index') }}">
                                <!--end::Svg Icon-->
                                <div class="input-group mb-5">
                                    <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}"/>
                                    <button class="input-group-text" id="basic-addon2">Go</button>
                                </div>
                            </form>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    @can('create_offers')
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5" id="add_btn">
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
                            <form action="{{ route('admin.offers.index') }}" method="GET">
                                <div class="px-7 py-5">
                                     <!--begin::Input group-->
                                     <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" name="status" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a">
                                                <option value="">No One</option>
                                                <option {{ session('offers_filter_status') == 'active' ? 'selected' :''}} value="active">{{ __('Active') }}</option>
                                                <option {{ session('offers_filter_status') == 'inactive' ? 'selected' :''}} value="inactive">{{ __('Inactive') }}</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Revenue Type:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid"  name="revenue_cps_type" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a">
                                                <option value="">All</option>
                                                <option {{session('offers_filter_revenue_cps_type') == 'static' ? "selected" : '' }} value="static">{{ __('Static') }}</option>
                                                <option {{session('offers_filter_revenue_cps_type') == 'new_old' ? "selected" : '' }} value="new_old">{{ __('New Old') }}</option>
                                                <option {{session('offers_filter_revenue_cps_type') == 'slaps' ? "selected" : '' }} value="slaps">{{ __('Slaps') }}</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Payout Type:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid"  name="payout_cps_type" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a">
                                                <option value="">All</option>
                                                <option {{session('offers_filter_payout_cps_type') == 'static' ? "selected" : '' }} value="static">{{ __('Static') }}</option>
                                                <option {{session('offers_filter_payout_cps_type') == 'new_old' ? "selected" : '' }} value="new_old">{{ __('New Old') }}</option>
                                                <option {{session('offers_filter_payout_cps_type') == 'slaps' ? "selected" : '' }} value="slaps">{{ __('Slaps') }}</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.offers.clear.sessions') }}" class="btn btn-sm btn-secondary w-100 mx-2">Clear Filter</a>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Menu 1-->

                        <!--begin::Add product-->
                        <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">Add Offer</a>
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
                    @endcan
                    @can('delete_offers')
                        <!--begin::Group actions-->
                        <div id="delete_btn" class="d-flex justify-content-end align-items-center d-none"
                            data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" id="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger" onclick="delete_selected()" >Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
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
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" id="main_form_check" type="checkbox" data-kt-check="true" value="1" />
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th class="min-w-250px">Thumbnail</th>
                                    <th class="min-w-90px">Status</th>
                                    <th class="min-w-90px">Revenue Type</th>
                                    <th class="min-w-90px">CPS Type</th>
                                    <th class="min-w-90px">Target Market</th>
                                    <th class="min-w-90px">Discount</th>
                                    <th class="min-w-50px text-end">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Head-->
                            <!--begin::Body-->
                            <tbody class="fs-6">
                                @forelse ($offers as $offer)
                                    <tr class="tr-{{ $offer->id }}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input table-checkbox" name="item_check" type="checkbox"
                                                    value="{{ $offer->id }}" />
                                            </div>
                                        </td>
                                        <td>{{ $offer->id }}</td>
                                        <td>
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Wrapper-->
                                                <div class="me-5 position-relative">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="{{ getImagesPath('Offers', $offer->thumbnail) }}" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-column justify-content-center">
                                                    <a href="{{ route('admin.offers.show', $offer->id) }}" class="mb-1 text-gray-800 text-hover-primary" data-kt-users-table-filter="offer_name">{{ $offer->name }}</a>
                                                    @if($offer->advertiser)<div class="fw-semibold fs-6 text-gray-400">{{  $offer->advertiser->company_name_en }}</div>@endif
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::User-->
                                        </td>
                                        <td data-order="{{ $offer->status }}">
                                            <button onclick="changeStatus('{{ $offer->id }}','{{ $offer->name }}', 'inactive')" class="btn btn-light-success btn-sm  active-btn-{{ $offer->id }} {{ $offer->status == 'active' ?: 'd-none' }}">Active</button>
                                            <button onclick="changeStatus('{{ $offer->id }}','{{ $offer->name }}', 'active')" class="btn btn-light-danger btn-sm inactive-btn-{{ $offer->id }} {{ $offer->status != 'active' ?: 'd-none' }}">Inactive</button>
                                        </td>
                                        <td>{{ $offer->cps_type == 'static' ? $offer->revenue_type : '' }} {{ $offer->cps_type == 'new_old' ? ($offer->newOld ? $offer->newOld->new_revenue_type : '') : '' }}</td>
                                        <td>{{ $offer->cps_type }}</td>
                                        <td>
                                            @foreach ($offer->countries as $country)
                                                {{ $country->name_en }} @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td> {{ $offer->discount }} </td>
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
                                                        <a href="javascript:void(0)" class="menu-link px-3" onclick="delete_row('{{ $offer->id }}', '{{ $offer->name }}')">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    @endcan
                                                </div>
                                                <!--end::Menu-->
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger text-center">No data</div>
                                @endforelse

                            </tbody>
                            <!--end::Body-->
                        </table>
                        <!--end::Table-->
                        <div class="d-flex justify-content-between">
                            <div>
                                @include('new_admin.components.table_length')
                            </div>
                            <div>
                                {!! $offers->links() !!}
                            </div>
                        </div>

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
<script>
    let route = "{{route('admin.offers.index')}}";
    let search = "{{ request()->search }}";
</script>
{{-- <script src="{{ asset('new_dashboard') }}/js/datatables/offers/table.js"></script> --}}
<script src="{{ asset('new_dashboard') }}/js/datatables/offers/delete.js"></script>

<script src="{{ asset('new_dashboard') }}/js/datatables/offers/change-status.js"></script>

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
<script src="{{ asset('new_dashboard') }}/js/datatables/search.js?v=60112212022"></script>
@endpush
