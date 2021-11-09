@extends('admin.layouts.app')
@section('title',auth()->user()->name)

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Profile 4-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Body-->
                            <div class="card-body pt-4">
                                
                                <!--begin::User-->
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                        <div class="symbol-label" style="background-image:url('{{ getImagesPath('Users', $publisher->image) }}')"></div>
                                        <i class="symbol-badge bg-success"></i>
                                    </div>
                                    <div>
                                        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ $publisher->name }}</a>
                                        <div class="text-muted">{{ $publisher->updated_position }} @ {{ $publisher->updated_team }} </div>
                                        {{-- <div class="mt-2">
                                            <a href="#" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Chat</a>
                                            <a href="#" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">Follow</a>
                                        </div> --}}
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->
                                <div class="pt-8 pb-6">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">Email:</span>
                                        <a href="#" class="text-muted text-hover-primary">{{ $publisher->email }}</a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">Phone:</span>
                                        <span class="text-muted">{{ $publisher->phone }}</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="font-weight-bold mr-2">Location:</span>
                                        <span class="text-muted">{{ $publisher->country?$publisher->country->name_en:'' }}</span>
                                    </div>
                                </div>
                                <!--end::Contact-->
                                <!--begin::Contact-->
                                <div class="pb-6">@foreach ($publisher->categories as $category) {{ $category }} , @endforeach</div>
                                <!--end::Contact-->
                                {{-- <a href="#" class="btn btn-light-success font-weight-bold py-3 px-6 mb-2 text-center btn-block">Profile Overview</a> --}}
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                
                    </div>
                    <!--end::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Base Table Widget 1-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label font-weight-bolder text-dark">{{ __('Best Coupons') }}</span>
                                            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than {{ count($publisher->offers) }} offers</span>
                                        </h3>
                                        {{-- <div class="card-toolbar">
                                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_1">Month</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_1_2">Week</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_1_3">Day</a>
                                                </li>
                                            </ul>
                                        </div> --}}
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-2 pb-0">
                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-vertical-center">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0" style="width: 50px"></th>
                                                        <th class="p-0" style="min-width: 150px"></th>
                                                        <th class="p-0" style="min-width: 200px"></th>
                                                        <th class="p-0" style="min-width: 40px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($publisher->offers as $offer)
                                                    {{-- @dd($offer); --}}
                                                    <tr>
                                                        <td class="pl-0 py-5">
                                                            <div class="symbol symbol-50 symbol-light mr-2">
                                                                <span class="symbol-label">
                                                                    <img src="{{ getImagesPath('Offers', $offer->thumbnail) }}" class="h-50 align-self-center" alt="" />
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $offer->name }}</a>
                                                            <span class="text-muted font-weight-bold d-block">{{ $offer->description }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column w-100 mr-2">
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrders }}</span>
                                                                    <span class="text-muted font-size-sm font-weight-bold">Progress</span>
                                                                </div>
                                                                {{ __('Order') }}

                                                                {{-- <div class="progress progress-xs w-100">
                                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 65%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div> --}}
                                                            </div>
                                                        </td>
                                                        <td class="text-right pr-0">
                                                            <a href="#" class="btn btn-icon btn-light btn-sm">
                                                                <span class="svg-icon svg-icon-md svg-icon-success">
                                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                        </g>
                                                                    </svg>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
    
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                </div>
                                <!--end::Base Table Widget 1-->
                            </div>
                            {{-- <div class="col-lg-6">
                                <!--begin::Charts Widget 3-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header h-auto border-0">
                                        <div class="card-title py-5">
                                            <h3 class="card-label">
                                                <span class="d-block text-dark font-weight-bolder">Recent Orders</span>
                                                <span class="d-block text-muted mt-2 font-size-sm">More than 500+ new orders</span>
                                            </h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_1">
                                                        <span class="nav-text font-size-sm">Month</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_2">
                                                        <span class="nav-text font-size-sm">Week</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_3">
                                                        <span class="nav-text font-size-sm">Day</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <div id="kt_charts_widget_3_chart"></div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 3-->
                            </div> --}}
                        </div>
                        <!--end::Row-->
                        <!--begin::Advance Table Widget 8-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">{{ __("Coupons") }}</span>
                                    <span class="text-muted mt-3 font-weight-bold font-size-sm">More than {{ $publisher->coupons->count() }} coupon</span>
                                </h3>
                                {{-- <div class="card-toolbar">
                                    <a href="#" class="btn btn-success font-weight-bolder font-size-sm">
                                    <span class="svg-icon svg-icon-md svg-icon-white">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>Add New Member</a>
                                </div> --}}
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-0 pb-3">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-head-bg table-vertical-center table-borderless">
                                        <thead>                                            
                                            
                                            <tr class="bg-gray-100 text-left">
                                                <th style="min-width: 250px" class="pl-7">
                                                    <span class="text-dark-75">{{ _('Coupon') }}</span>
                                                </th>
                                                <th scope="col">{{ _('Coupon Status') }}</th>
                                                <th scope="col">{{ _('Discount') }}</th>
                                                <th scope="col">{{ _('Camping') }}</th>
                                                <th scope="col">{{ _('Orders') }}</th>
                                                <th scope="col">{{ __('Sales') }}</th>
                                                <th scope="col">{{ _('Payout') }}</th>
                                                <th scope="col">{{ _('V Orders') }}</th>
                                                <th scope="col">{{ __('V Sales') }}</th>
                                                <th scope="col">{{ _('V Payout') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($publisher->coupons as $coupon)
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                            <div class="symbol-label" style="background-image: url('{{ getImagesPath('Offers', $coupon->offer->thumbnail) }}')"></div>
                                                        </div>
                                                        <div>
                                                            <a href="javascript:void(0)" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $coupon->coupon }}</a>
                                                            <span class="text-muted font-weight-bold d-block">{{ $coupon->offer->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$2,790</span>
                                                    <span class="text-muted font-weight-bold">Paid</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$520</span>
                                                    <span class="text-muted font-weight-bold">Paid</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Bradly Beal</span>
                                                    <span class="text-muted font-weight-bold">Insurance</span>
                                                </td>
                                                <td>
                                                    <span class="label label-lg label-light-primary label-inline">Approved</span>
                                                </td>
                                                <td class="pr-0 text-right">
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Bookmark.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path d="M8,4 L16,4 C17.1045695,4 18,4.8954305 18,6 L18,17.726765 C18,18.2790497 17.5522847,18.726765 17,18.726765 C16.7498083,18.726765 16.5087052,18.6329798 16.3242754,18.4639191 L12.6757246,15.1194142 C12.2934034,14.7689531 11.7065966,14.7689531 11.3242754,15.1194142 L7.67572463,18.4639191 C7.26860564,18.8371115 6.63603827,18.8096086 6.26284586,18.4024896 C6.09378519,18.2180598 6,17.9769566 6,17.726765 L6,6 C6,4.8954305 6.8954305,4 8,4 Z" fill="#000000" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td class="pl-0 py-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                            <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-3.jpg')"></div>
                                                        </div>
                                                        <div>
                                                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Telegram Development</a>
                                                            <span class="text-muted font-weight-bold d-block">C#, ASP.NET, MS SQL</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$4,600</span>
                                                    <span class="text-muted font-weight-bold">Pending</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$1,600</span>
                                                    <span class="text-muted font-weight-bold">Rejected</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Chris Thompson</span>
                                                    <span class="text-muted font-weight-bold">NBA Player</span>
                                                </td>
                                                <td>
                                                    <span class="label label-lg label-light-warning label-inline">In Progress</span>
                                                </td>
                                                <td class="pr-0 text-right">
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Bookmark.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path d="M8,4 L16,4 C17.1045695,4 18,4.8954305 18,6 L18,17.726765 C18,18.2790497 17.5522847,18.726765 17,18.726765 C16.7498083,18.726765 16.5087052,18.6329798 16.3242754,18.4639191 L12.6757246,15.1194142 C12.2934034,14.7689531 11.7065966,14.7689531 11.3242754,15.1194142 L7.67572463,18.4639191 C7.26860564,18.8371115 6.63603827,18.8096086 6.26284586,18.4024896 C6.09378519,18.2180598 6,17.9769566 6,17.726765 L6,6 C6,4.8954305 6.8954305,4 8,4 Z" fill="#000000" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                            <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-5.jpg')"></div>
                                                        </div>
                                                        <div>
                                                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Payrol Application</a>
                                                            <span class="text-muted font-weight-bold d-block">PHP, Laravel, VueJS</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$23,800</span>
                                                    <span class="text-muted font-weight-bold">Paid</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$6,700</span>
                                                    <span class="text-muted font-weight-bold">Paid</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Zoey McGee</span>
                                                    <span class="text-muted font-weight-bold">Ruby Developer</span>
                                                </td>
                                                <td>
                                                    <span class="label label-lg label-light-success label-inline">Success</span>
                                                </td>
                                                <td class="pr-0 text-right">
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Bookmark.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path d="M8,4 L16,4 C17.1045695,4 18,4.8954305 18,6 L18,17.726765 C18,18.2790497 17.5522847,18.726765 17,18.726765 C16.7498083,18.726765 16.5087052,18.6329798 16.3242754,18.4639191 L12.6757246,15.1194142 C12.2934034,14.7689531 11.7065966,14.7689531 11.3242754,15.1194142 L7.67572463,18.4639191 C7.26860564,18.8371115 6.63603827,18.8096086 6.26284586,18.4024896 C6.09378519,18.2180598 6,17.9769566 6,17.726765 L6,6 C6,4.8954305 6.8954305,4 8,4 Z" fill="#000000" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0 py-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50 flex-shrink-0 mr-4">
                                                            <div class="symbol-label" style="background-image: url('assets/media/stock-600x400/img-18.jpg')"></div>
                                                        </div>
                                                        <div>
                                                            <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">HR Management System</a>
                                                            <span class="text-muted font-weight-bold d-block">Python, PostgreSQL, ReactJS</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$57,000</span>
                                                    <span class="text-muted font-weight-bold">Paid</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$14,000</span>
                                                    <span class="text-muted font-weight-bold">Paid</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">Brandon Ingram</span>
                                                    <span class="text-muted font-weight-bold">NBA Player</span>
                                                </td>
                                                <td>
                                                    <span class="label label-lg label-light-danger label-inline">Rejected</span>
                                                </td>
                                                <td class="pr-0 text-right">
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mr-3">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Bookmark.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path d="M8,4 L16,4 C17.1045695,4 18,4.8954305 18,6 L18,17.726765 C18,18.2790497 17.5522847,18.726765 17,18.726765 C16.7498083,18.726765 16.5087052,18.6329798 16.3242754,18.4639191 L12.6757246,15.1194142 C12.2934034,14.7689531 11.7065966,14.7689531 11.3242754,15.1194142 L7.67572463,18.4639191 C7.26860564,18.8371115 6.63603827,18.8096086 6.26284586,18.4024896 C6.09378519,18.2180598 6,17.9769566 6,17.726765 L6,6 C6,4.8954305 6.8954305,4 8,4 Z" fill="#000000" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Advance Table Widget 8-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Profile 4-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection