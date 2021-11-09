@extends('admin.layouts.app')@section('title','Publishers')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                        <!--begin: Pic-->
                        <div class="mr-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{asset('/images/150-26.jpg')}}" alt="image"/>
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
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
                                    <div class="mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary font-size-h3 font-weight-bolder mr-1">{{$publisher->name}}</a>
                                        <span class="d-block">{{__('Account Manager')}}:  <strong>{{$publisher->parent->name}}</strong></span>
                                    </div>
                                    <!--end::Name-->
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"/>
                                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">4500</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">{{__('Total Earned')}}</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-3 svg-icon-danger mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="black"/>
                                                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="black"/>
                                                    </svg>
                                                </span>
                                                <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="75">0</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">{{__('Pending Earning')}}</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"/>
                                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">80</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">{{__('Validated Unpaid Payout')}}</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                <span class="svg-icon svg-icon-3 svg-icon-success mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"/>
                                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="%">80</div>
                                            </div>
                                            <div class="fw-bold fs-6 text-gray-400">{{__('# Active Offers')}}</div>
                                        </div>
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Progress-->
                            {{--<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                    <span class="fw-bold fs-6 text-gray-400">Profile Compleation</span>
                                    <span class="font-weight-bolder fs-6">50%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                    <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>--}}
                            <!--end::Progress-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                </div>
            </div>
            <!--end::Navbar-->
            <div class="row gy-5 g-xl-10">

                <div class="col-xl-4">
                    <div class="card card-xl-stretch mb-xl-10">
                        <div class="card-header border-0 pb-0 d-flex flex-wrap flex-stack align-items-start">
                            <h3 class="card-title align-items-start flex-column flex-grow-1" style="margin-bottom: 0">
                                <span class="card-label fw-bolder fs-3 mb-1 font-weight-bolder">Recent Statistics</span>
                                <span class="text-muted fw-bold fs-7 d-block">More than 400 new members</span>
                            </h3>
                            <div class=" flex-column">
                                <button class="btn btn-light-danger btn-bg-info">Offer Type</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"></rect>
                                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                        <!--end::Svg Icon-->
                                        <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">4500</div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400">Total Orders</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                    <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-3 svg-icon-danger mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="black"></rect>
                                                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                        <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="75">0</div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400">Total Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card card-xl-stretch mb-xl-10">
                        <div class="card-header border-0 pb-0 d-flex flex-wrap flex-stack align-items-start">
                            <h3 class="card-title align-items-start flex-column flex-grow-1" style="margin-bottom: 0">
                                <span class="card-label fw-bolder fs-3 mb-1 font-weight-bolder">Top Offer</span>
                                <span class="text-muted fw-bold fs-7 d-block">Showing Top Offer</span>
                            </h3>
                            <div class=" flex-column">
                                <button class="btn btn-light-danger btn-bg-info">Offer Type</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"></rect>
                                                        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                        <!--end::Svg Icon-->
                                        <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">4500</div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400">Total Earned</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mr-6 mb-3">
                                    <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-3 svg-icon-danger mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="black"></rect>
                                                        <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                        <div class="font-size-h3 font-weight-bolder" data-kt-countup="true" data-kt-countup-value="75">0</div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400">Pending Earning</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card card-xl-stretch mb-xl-10">
                        <div class="card-header border-0 pb-0 d-flex flex-wrap flex-stack align-items-start">
                            <h3 class="card-title align-items-start flex-column flex-grow-1" style="margin-bottom: 0">
                                <span class="card-label fw-bolder fs-3 mb-1 font-weight-bolder">Recent Coupons</span>
                                <span class="text-muted fw-bold fs-7 d-block">Showing recent coupons</span>
                            </h3>
                        </div>
                        <div class="card-body">

                                @if($publisher->coupons()->count())
                                    <div class="timeline timeline-6 mt-3">
                                        @foreach($publisher->coupons()->orderBy('id','desc')->take(5)->get() as $coupons)
                                            <div class="timeline-item align-items-start">
                                                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">{{  $coupons->created_at }}</div>
                                                <div class="timeline-badge">
                                                    <i class="fa fa-genderless text-warning icon-xl"></i>
                                                </div>
                                                <div class="font-weight-mormal font-size-lg timeline-content text-muted pl-3">
                                                    <strong>{{  $coupons->offer->name }}</strong> - {{  $coupons->coupon }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                {{__("No Coupon Found!")}}
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title m-0">
                        <h3 class="card-label fw-bolder fs-3 font-weight-bolder">Coupons</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-checkable" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>Coupon Status</th>
                            <th>Offer Name</th>
                            <th>Discount Rate</th>
                            <th>Coupon</th>
                            <th>Order</th>
                            <th>Sales</th>
                            <th>Payout</th>
                            <th>V-Orders</th>
                            <th>V-Payout</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($publisher->coupons()->count())
                                @foreach($publisher->coupons()->orderBy('id','desc')->take(20)->get() as $coupons)
                                    <tr>
                                        <td> --- </td>
                                        <td>{{  $coupons->offer->name }}</td>
                                        <td> --- </td>
                                        <td>{{  $coupons->coupon }}</td>
                                        <td> --- </td>
                                        <td> --- </td>
                                        <td> --- </td>
                                        <td> --- </td>
                                        <td> --- </td>
                                    </tr>
                                @endforeach
                        @else
                            {{__("No Coupon Found!")}}
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!--end::Entry-->
@endsection

