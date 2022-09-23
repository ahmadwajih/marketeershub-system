@extends('new_admin.layouts.app')
@section('content')
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ asset('new_dashboard') }}/media/avatars/300-1.jpg" alt="image" />
                        <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="javascript:void(0)" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $publisher->name }}</a>
                                <a href="javascript:void(0)">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                    <span class="svg-icon svg-icon-1 svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                            <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor" />
                                            <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                @if($publisher->parent)
                                <a href="javascript:void(0)" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z" fill="currentColor" />
                                        <path d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z" fill="currentColor" />
                                        <rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->{{ $publisher->parent->name }}</a>
                                @endif
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" />
                                        <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->{{ ucfirst(str_replace('_', ' ', $publisher->team)) }}</a>
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor" />
                                        <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->{{ $publisher->email }}</a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                        <!--begin::Actions-->
                        <!-- right buttons -->
                        <div class="d-flex my-4">
                            <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                <span class="svg-icon svg-icon-3 d-none">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                        <path d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Assign To Me</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </a>
                            <a href="{{ route('admin.publishers.edit', $publisher->id) }}" class="btn btn-sm btn-primary me-2">Edit Profile</a>
                            <!--begin::Menu-->
        
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap flex-stack">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $publisher->payments->sum('amount_paid') }}" data-kt-countup-prefix="$">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Earnings</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $publisher->offers->count() }}">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Offers</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                    </div>
                                    <!--end::Number-->
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Success Rate</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-semibold fs-6 text-gray-400">Profile Compleation</span>
                                <span class="fw-bold fs-6">50%</span>
                            </div>
                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <div class="form">

                <form class="mx-auto w-100 pt-15 pb-10" novalidate="novalidate" id="kt_modal_create_project_form" action="{{ route('admin.publisher.profile', request()->id ?? null) }}" method="get">
                    <div class="row">
                        <div class="col-4">
                            <div class="fv-row mb-8">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">From Date</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify project name"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid" placeholder="Enter From Date"  value="{{ request()->from }}"  name="from" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="fv-row mb-8">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">To Date</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify project name"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" class="form-control form-control-solid" placeholder="Enter To Date"  value="{{ request()->to }}" name="to" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary mt-9 btn-block">Change Dates</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--begin::Navs-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="javascript:void(0)" data-tab="overview">Overview</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="javascript:void(0)" data-tab="offers">Offers</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="javascript:void(0)" data-tab="payments">Payments</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5" href="javascript:void(0)" data-tab="coupons">Coupons</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Navbar-->

    <!--begin::Row-->
    <div id="overview" class="tab">
        <div class="card mb-5 mb-xl-10">
            <!--begin::Body-->
            <div class="card-body py-10">
                <h2 class="mb-9">Overview</h2>
                <!--begin::Stats-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-info pb-1 px-2">Orders</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                            <span data-kt-countup="true" data-kt-countup-value="{{ $totalNumbers->orders ?? 0 }}">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-success pb-1 px-2">Sales</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
                            <span data-kt-countup="true" data-kt-countup-value="{{ $totalNumbers->sales ?? 0 }}">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-danger pb-1 px-2">Revenue</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
                            <span data-kt-countup="true" data-kt-countup-value="{{ $totalNumbers->revenue ?? 0 }}">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-primary pb-1 px-2">Payout</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
                            <span data-kt-countup="true" data-kt-countup-value="{{ $totalNumbers->payout ?? 0 }}">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <div class="card card-dashed flex-center min-w-175px my-3 p-6">
                            <span class="fs-4 fw-semibold text-warning pb-1 px-2">Gross Margin</span>
                            <span class="fs-lg-2tx fw-bold d-flex justify-content-center">$
                            <span data-kt-countup="true" data-kt-countup-value="{{ (isset($totalNumbers->payout) && isset($totalNumbers->revenue)) ? $totalNumbers->revenue - $totalNumbers->payout : 0 }}">0</span></span>
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Stats-->


                <div class="charts mt-4">
                    <h2 class="mb-9">Offers Charts</h2>
                    <div class="d-flex justify-content-between">
                        <!--start::orders-->
                        <div class="card ">
                            <h4 class="p-0 m-0 text-center">Orders</h4>
                            <div class="card-body pb-0">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap flex-sm-nowrap">
                                    {!! $offersOrdersChart->container() !!}
                                </div>
                            </div>
                        </div>
                        <!--end::orders-->
                        <!--start::sales-->
                        <div class="card ">
                            <h4 class="p-0 m-0 text-center">Sales</h4>
                            <div class="card-body pb-0">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap flex-sm-nowrap">
                                    {!! $offersSalesChart->container() !!}
                                </div>
                            </div>
                        </div>
                        <!--end::sales-->

                        <!--end::revenue-->
                        <div class="card ">
                            <h4 class="p-0 m-0 text-center">Revenue</h4>
                            <div class="card-body pb-0">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap flex-sm-nowrap">
                                    {!! $offersRevenueChart->container() !!}
                                </div>
                            </div>
                        </div>
                        <!--end::revenue-->
                    </div>

                    <h2 class="mb-9 mt-9">Coupons Charts</h2>

                    <!--start::orders-->
                    <div class="card ">
                        <h3 class="p-9 m-9 text-center">Orders</h3>
                        <div class="card-body pb-0">
                            <!--begin::Details-->
                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                {!! $couponsOrdersChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <!--end::orders-->
                    <!--start::sales-->
                    <div class="card ">
                        <h3 class="p-9 m-9 text-center">Sales</h3>
                        <div class="card-body pb-0">
                            <!--begin::Details-->
                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                {!! $couponsSalesChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <!--end::sales-->
                    <!--start::revenue-->
                    <div class="card ">
                        <h3 class="p-9 m-9 text-center">Revenue</h3>
                        <div class="card-body pb-0">
                            <!--begin::Details-->
                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                {!! $couponsRevenueChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <!--end::revenue-->

                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>
    <!--End::Row-->
    <!--begin::Row-->
    <div id="offers" class="tab fade-out-tab">
        <div class="row g-5 g-xxl-8">
            <!--begin::Followers toolbar-->
            <div class="d-flex flex-wrap flex-stack">
                <!--begin::Title-->
                <h3 class="fw-bold my-2">My Offers
                <span class="fs-6 text-gray-400 fw-semibold ms-1">({{ count($offers) }})</span></h3>
                <!--end::Title-->
                <!--begin::Controls-->
                <div class="d-flex my-2">
                    <!--begin::Select-->
                    <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-sm bg-body border-body w-125px">
                        <option value="Active" selected="selected">Active</option>
                        <option value="Approved">In Progress</option>
                        <option value="Declined">To Do</option>
                        <option value="In Progress">Completed</option>
                    </select>
                    <!--end::Select-->
                </div>
                <!--end::Controls-->
            </div>
            <!--end::Followers toolbar-->
            <!--begin::Row-->
            <div class="row g-6 mb-6 g-xl-9 mb-xl-9">
                <!--begin::Followers-->
                @if($activeOffers && count($activeOffers) > 0)
                @foreach($activeOffers as $offer)
                <!--begin::Col-->
                <div class="col-md-6 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column py-9 px-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-65px symbol-circle mb-5">
                                <img src="{{ getImagesPath('Offers', $offer->thumbnail) }}" alt="{{ $offer->offer_name }}" />
                                @if($offer->status == 'active' && $offer->expire_date >= now()->format('Y-m-d'))
                                    <div class="bg-success position-absolute rounded-circle translate-middle start-100 top-100 border border-4 border-body h-15px w-15px ms-n3 mt-n3"></div>
                                @endif
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ $offer->offer_name }}</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="fw-semibold text-gray-400 mb-6">{{ $offer->description }}</div>
                            <!--end::Position-->
                             <!--begin::Info-->
                             <div class="d-flex flex-wrap mb-5 text-center">
                                <!--begin::Due-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-2 mb-3">
                                    <div class="fs-6 text-gray-800 fw-bold">{{ $offer->orders }}</div>
                                    <div class="fw-semibold text-gray-400">Order</div>
                                </div>
                                <!--end::Due-->
                                <!--begin::Budget-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                    <div class="fs-6 text-gray-800 fw-bold">${{ $offer->revenue }}</div>
                                    <div class="fw-semibold text-gray-400">Revenue</div>
                                </div>
                                <!--end::Budget-->
                            </div>
                            <!--end::Info-->
                             <!--begin::Progress-->
                             <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 50% completed">
                                <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!--end::Progress-->
                            <!--end::Follow-->
                        </div>
                        <!--begin::Card body-->
                    </div>
                    <!--begin::Card-->
                </div>
                <!--end::Col-->
                @endforeach
                @else
                    <div class="alert alert-danger">
                        No Avaliabel offers
                    </div>
                @endif
                <!--end::Followers-->
            </div>
            <!--end::Row-->
        </div>
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div id="payments" class="tab fade-out-tab">
        <!--begin::Col-->
        <div class="col-xl-12 mb-5 mb-xl-12">
            <!--begin::Table Widget 4-->
            <div class="card card-flush h-xl-100">
                <!--begin::Card header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">My Payments </span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ count($payments) }} Paid payment</span>
                    </h3>
                    <!--end::Title-->
        
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-2">
                    <!--begin::Table-->* 
                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_4_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">ID</th>
                                <th class="text-end min-w-100px">Amount</th>
                                <th class="text-end min-w-125px">Period From</th>
                                <th class="text-end min-w-125px">Period To</th>
                                <th class="text-end min-w-100px">note</th>
                                <th class="text-end min-w-100px">type</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @foreach($payments as $payment)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" class="text-gray-800 text-hover-primary">#MH-1000{{ $payment->id }}</a>
                                    </td>
                                    <td class="text-end">{{ $payment->amount_paid }}$</td>
                                    <td class="text-end">{{ $payment->from }}</td>
                                    <td class="text-end">{{ $payment->to }}</td>
                                    <td class="text-end">{{ $payment->note }}</td>
                                    <td class="text-end">{{ $payment->type }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Table Widget 4-->
        </div>
        <!--end::Col-->
    </div>
    <!--End::Row-->
    <!--begin::Row-->
    <div id="coupons" class="tab fade-out-tab">
         <!--begin::Col-->
         <div class="col-xl-12 mb-5 mb-xl-12">
            <!--begin::Table Widget 4-->
            <div class="card card-flush h-xl-100">
                <!--begin::Card header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">My Payments </span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ count($payments) }} Paid payment</span>
                    </h3>
                    <!--end::Title-->
        
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-2">
                    <!--begin::Table-->* 
                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_4_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">ID</th>
                                <th class="text-end min-w-100px">Coupon</th>
                                <th class="text-end min-w-125px">Offer Name</th>
                                <th class="text-end min-w-125px">Orders</th>
                                <th class="text-end min-w-125px">Sales</th>
                                <th class="text-end min-w-100px">Revenue</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" class="text-gray-800 text-hover-primary">#MH-1000{{ $coupon->id }}</a>
                                    </td>
                                    <td class="text-end">{{ $coupon->coupon }}</td>
                                    <td class="text-end">{{ $coupon->offer_name }}</td>
                                    <td class="text-end">{{ $coupon->orders }}</td>
                                    <td class="text-end">{{ $coupon->sales }}$</td>
                                    <td class="text-end">{{ $coupon->revenue }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Table Widget 4-->
        </div>
        <!--end::Col-->
    </div>
    <!--End::Row-->
    
    
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script>
    $(document).ready(function(){
        $('.fade-out-tab').fadeOut('fast');
       $('.nav-link').click(function(){
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.tab').fadeOut('fast');
            $('#'+$(this).data('tab')).fadeIn('slow');
       })
    })
</script>
{!! $offersOrdersChart->script() !!}
{!! $offersSalesChart->script() !!}
{!! $offersRevenueChart->script() !!}
{!! $couponsOrdersChart->script() !!}
{!! $couponsSalesChart->script() !!}
{!! $couponsRevenueChart->script() !!}

@endpush




