@extends('new_admin.layouts.app')
@section('title', 'Offers')
@section('subtitle', 'Show')
@push('styles')
    <style>
        table tr {
            border-bottom: 1px dashed #eee !important;
        }
        #new_old_payout,
        #slaps_payout,
        #custom_payout{
            display: none;
        }
        .modal-content{
            width: 1250px;
            left: -350px;
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



        <div class="card mb-5 mb-xl-10">
            <div class="card-header">
                <h3 class="card-title">Payout Details</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded table-striped border gy-7 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Payout Type</th>
                                <th>Payout</th>
                                <th>New Payout</th>
                                <th>Old Payout</th>
                                <th>From Slab</th>
                                <th>To Slab</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Countries</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd() --}}
                            @foreach($offer->cps->where('type', 'payout') as $payout)
                            <tr>
                                <td>{{ $payout->amount_type }}</td>
                                <td>{{ $payout->amount }}</td>
                                <td>{{ $payout->new_amount }}</td>
                                <td>{{ $payout->old_amount }}</td>
                                <td>{{ $payout->from }}</td>
                                <td>{{ $payout->to }}</td>
                                <td>{{ $payout->from_date }}</td>
                                <td>{{ $payout->to_date }}</td>
                                <td>
                                    @php( $countryIds = json_decode($payout->countries_ids, true))
                                    @if($countryIds)
                                        @foreach(json_decode($payout->countries_ids, true) as $countryId)  
                                        <span class="badge badge-light m-1">{{ App\Models\Country::where('id', $countryId)->first() ? App\Models\Country::where('id', $countryId)->first()->name_en : '' }}</span>
                                        @endforeach
                                    @endif
                                </td>                      
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card mb-5 mb-xl-10">
            <div class="card-header">
                <h3 class="card-title">Revenue  Details</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded table-striped border gy-7 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Revenue Type</th>
                                <th>Revenue</th>
                                <th>New Revenue</th>
                                <th>Old Revenue</th>
                                <th>From Slab</th>
                                <th>To Slab</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Countries</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd() --}}
                            @foreach($offer->cps->where('type', 'revenue') as $payout)
                            <tr>
                                <td>{{ $payout->amount_type }}</td>
                                <td>{{ $payout->amount }}</td>
                                <td>{{ $payout->new_amount }}</td>
                                <td>{{ $payout->old_amount }}</td>
                                <td>{{ $payout->from }}</td>
                                <td>{{ $payout->to }}</td>
                                <td>{{ $payout->from_date }}</td>
                                <td>{{ $payout->to_date }}</td>
                                <td>
                                    @php( $countryIds = json_decode($payout->countries_ids, true))
                                    @if($countryIds)
                                        @foreach(json_decode($payout->countries_ids, true) as $countryId)  
                                        <span class="badge badge-light m-1">{{ App\Models\Country::where('id', $countryId)->first() ? App\Models\Country::where('id', $countryId)->first()->name_en : '' }}</span>
                                        @endforeach
                                    @endif
                                </td>                      
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                     <!--begin::Search-->
                     <div class="d-flex align-items-center position-relative my-1">
                        <form action="{{ route('admin.offers.show', $offer->id) }}">
                             <!--end::Svg Icon-->
                             <div class="input-group mb-5">
                                 <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}"/>
                                 <button class="input-group-text" id="basic-addon2">Go</button> <span class="mx-3 mt-3"> {{ $coupons->total() }} Coupon</span>
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
                        <form action="{{ route('admin.offers.show', $offer->id) }}" method="GET">
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Publisher:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div>
                                        <select class="form-select form-select-solid" name="user_id" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a"
                                            data-allow-clear="true">
                                            <option value="">No One</option>
                                            @foreach($publishers as $publisher)
                                                <option {{ request()->user_id == $publisher->id ? 'selected' :''}} value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                            @endforeach
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
                                            data-allow-clear="true">
                                            <option value="">No One</option>
                                            <option {{ request()->status == 'active' ? 'selected' :''}} value="active">{{ __('Active') }}</option>
                                            <option {{ request()->status == 'inactive' ? 'selected' :''}} value="inactive">{{ __('inactive') }}</option>
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
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
            </div>
            <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
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
                                    <td>{{ $coupon->offer->name }}</td>
                                    <td>{{ $coupon->user ? $coupon->user->name : '' }}</td>
                                    <td>{{ $coupon->user ? $coupon->user->id : '' }}</td>
                                    <td>{{ $coupon->user ? $coupon->user->updated_team : '' }}</td>
                                    <td>
                                        @if ($coupon->status == 'active')
                                            <button
                                                onclick="changeStatus('{{ $coupon->id }}','{{ $coupon->coupon }}', 'inactive')"
                                                class="btn btn-light-success btn-sm">Active</button>
                                        @else
                                            <button
                                                onclick="changeStatus('{{ $coupon->id }}','{{ $coupon->coupon }}', 'active')"
                                                class="btn btn-light-danger btn-sm">inactive</button>
                                        @endif
                                    </td>
                                    <td>
                                        <button onclick="loadPayoutDetails('{{ $coupon->id }}')" data-bs-toggle="modal"
                                            data-bs-target="#payout_details" class="btn btn-light-info btn-sm">Show
                                            Payout</button>
                                    </td>
                                    <td>
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
    <!--End::Row-->

    
    <!--start::Modal-->
    <div class="modal fade" id="payout_details">
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
    <div class="modal fade" id="kt_modal_scrollable_1"  role="dialog" aria-hidden="false">
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
                                <!--begin::Label-->
                                <label class="form-label">Publisher</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="user_id" id="mySelect2" data-control="select2" class="form-select publisher-select-2"  data-placeholder="Select an option">
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
                        @include('new_admin.coupons.create.payout.cps_static_offer')
                        @include('new_admin.coupons.create.payout.cps_new_old_offer')
                        @include('new_admin.coupons.create.payout.cps_slaps_offer')
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
                    if(this.checked) {
                        $('#delete_btn').removeClass('d-none');
                        $('#add_btn').addClass('d-none');
                    }else{
                        $('#delete_btn').addClass('d-none');
                        $('#add_btn').removeClass('d-none');
                    }
                    var numberOfChecked = $('.table-checkbox:checked').length;
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

<script>

    $(document).ready(function() {
      $("#mySelect2").select2({
        dropdownParent: $("#kt_modal_scrollable_1")
      });
    });
    
    </script>

@endpush



