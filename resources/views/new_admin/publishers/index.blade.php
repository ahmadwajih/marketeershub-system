@extends('new_admin.layouts.app')
@section('title', 'Publishers')
@section('subtitle', 'View')
@section('content')

    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Publishers List</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">User Management</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Users</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Users List</li>
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
                    <form action="{{ route('admin.publishers.index') }}">
                            <!--end::Svg Icon-->
                            <div class="input-group mb-5">
                                <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}"/>
                                <button class="input-group-text" id="basic-addon2">Go</button>  <span class="mx-3 mt-3"> {{ $publishers->total() }} Publisher</span>
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
                            <form action="{{ route('admin.publishers.index') }}" method="GET">
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Team:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid"  name="team" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a">
                                                <option value="">All</option>
                                                <option {{session('publishers_filter_team') == 'media_buying' ? "selected" : '' }} value="media_buying">{{ __('Media Buying') }}</option>
                                                <option {{session('publishers_filter_team') == 'influencer' ? "selected" : '' }} value="influencer">{{ __('Influencer') }}</option>
                                                <option {{session('publishers_filter_team') == 'affiliate' ? "selected" : '' }} value="affiliate">{{ __('Affiliate') }}</option>
                                                <option {{session('publishers_filter_team') == 'prepaid' ? "selected" : '' }} value="prepaid">{{ __('Prepaid') }}</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">AM:</label>
                                        <select class="form-select form-select-solid fw-bold filter-input" data-column="6" name="parent_id" data-kt-select2="true" data-placeholder="Select option">
                                            <option value="">All</option>
                                            @foreach($accountManagers as $accountManager)
                                                <option {{ session('publishers_filter_parent_id') == $accountManager->id ? "selected" : '' }} value="{{ $accountManager->id }}">{{ $accountManager->name  }}</option>
                                            @endforeach
                                        </select>
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
                                                <option {{ session('publishers_filter_status') == 'active' ? 'selected' :''}} value="active">{{ __('Live') }}</option>
                                                <option {{ session('publishers_filter_status') == 'pending' ? 'selected' :''}} value="inactive">{{ __('Paused') }}</option>
                                                <option {{ session('publishers_filter_status') == 'inactive' ? 'selected' :''}} value="inactive">{{ __('Cancelled') }}</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.publishers.clear.sessions') }}" class="btn btn-sm btn-secondary w-100 mx-2">Clear Filter</a>
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
                        @can('create_publishers')
                        <a href="{{ route('admin.publishers.upload.form') }}" class="btn btn-success mr-2"
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
                            <a href="{{ route('admin.publishers.create') }}" class="btn btn-primary">
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
                                <!--end::Svg Icon-->Add Publisher
                            </a>
                        @endcan
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    @can('delete_publishers')
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
                                <th>ID</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Team') }}</th>
                                <th>{{ __('Acc. Manager') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Join Date') }}</th>
                                <th class="text-end min-w-100px">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($publishers) > 0)
                            @foreach ($publishers as $publisher)
                                <tr class="tr-{{ $publisher->id }}">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input table-checkbox" name="item_check" type="checkbox"
                                                value="{{ $publisher->id }}" />
                                        </div>
                                    </td>
                                    <td>{{ $publisher->id }}</td>
                                    <td><a href="{{ route('admin.publisher.profile', $publisher->id) }}">{{ $publisher->name }}</a></td>
                                    <td>{{ $publisher->email }}</td>
                                    <td>{{ $publisher->phone }}</td>
                                    <td>{{ $publisher->updated_team }}</td>
                                    <td>{{ $publisher->parent ? $publisher->parent->name : '' }}</td>
                                    <td>
                                        <button onclick="changeStatus('{{ $publisher->id }}','{{ $publisher->name }}', 'inactive')" class="btn btn-light-success btn-sm  active-btn-{{ $publisher->id }} {{ $publisher->status == 'active' ?: 'd-none' }}">Live</button> 
                                        <button onclick="changeStatus('{{ $publisher->id }}','{{ $publisher->name }}', 'active')" class="btn btn-light-warning btn-sm  pending-btn-{{ $publisher->id }} {{ $publisher->status == 'pending' ?: 'd-none' }}">Paused</button> 
                                        <button onclick="changeStatus('{{ $publisher->id }}','{{ $publisher->name }}', 'active')" class="btn btn-light-danger btn-sm inactive-btn-{{ $publisher->id }} {{ $publisher->status == 'inactive' ?: 'd-none' }}">Cancelled</button>
                                    </td>
                                    <td>{{ $publisher->humans_created_at }}</td>
                                    <td>
                                        @can('update_publishers')
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
                                                        <a href="{{ route('admin.publishers.edit', $publisher->id) }}"
                                                            class="menu-link px-3">Edit</a>
                                                    </div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)" class="menu-link px-3" onclick="delete_row('{{ $publisher->id }}', '{{ $publisher->coupon }}')">Delete</a>
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
                            {!! $publishers->links() !!}
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
@endsection
@push('scripts')
<script>
var route = "{{route('admin.publishers.index')}}";
var publishersRoute = "{{route('admin.publisher.profile')}}";
</script>
<script src="{{ asset('new_dashboard') }}/js/datatables/publishers/change-status.js"></script>
<script src="{{ asset('new_dashboard') }}/js/datatables/publishers/delete.js"></script>

<script src="{{ asset('new_dashboard') }}/js/tables_btns.js"></script>

@endpush
