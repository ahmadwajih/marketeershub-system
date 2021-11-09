@extends('admin.layouts.app')
@section('title',auth()->user()->name)

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                	<!--begin::Card-->
								<div class="card card-custom gutter-b">
									<div class="card-body">
										<!--begin::Details-->
										<div class="d-flex mb-9">
											<!--begin: Pic-->
											<div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
												<div class="symbol symbol-50 symbol-lg-120">
													<img src="{{ getImagesPath('Users', $publisher->image) }}" alt="image" />
												</div>
												<div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
													<span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
												</div>
											</div>
											<!--end::Pic-->
											<!--begin::Info-->
											<div class="flex-grow-1">
												<!--begin::Title-->
												<div class="d-flex justify-content-between flex-wrap mt-1">
													<div class="d-flex mr-3">
														<a href="#" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $publisher->name }}</a>
														@if($publisher->parent)
                                                        <a href="#">
															<i class="flaticon2-correct text-success font-size-h5"></i>
														</a>
                                                        @endif
													</div>
													{{-- <div class="my-lg-0 my-3">
														<a href="#" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-3">ask</a>
														<a href="#" class="btn btn-sm btn-info font-weight-bolder text-uppercase">hire</a>
													</div> --}}
												</div>
												<!--end::Title-->
												<!--begin::Content-->
												<div class="d-flex flex-wrap justify-content-between mt-1">
													<div class="d-flex flex-column flex-grow-1 pr-8">
														<div class="d-flex flex-wrap mb-4">
															<a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<i class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $publisher->email }}</a>
															<a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<i class="flaticon2-calendar-3 mr-2 font-size-lg"></i>{{ $publisher->updated_position }}</a>
															<a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
															<i class="flaticon2-placeholder mr-2 font-size-lg"></i> {{ $publisher->updated_team }}</a>
														</div>
                                                        <div class="pt-8 pb-6">
                                                            <div class="d-flex align-items-center justify-content-left mb-2">
                                                                <span class="font-weight-bold mr-2">Account Manager:</span>
                                                                <a href="#" class="text-muted text-hover-primary">{{ $publisher->parent->name }}</a>
                                                            </div>
        
                                                            <div class="d-flex align-items-center justify-content-left">
                                                                <span class="font-weight-bold mr-2">Location:</span>
                                                                <span class="text-muted">{{ $publisher->country?$publisher->country->name_en:'' }}</span>
                                                            </div>

                                                            <div class="d-flex align-items-center justify-content-left">
                                                                <span class="font-weight-bold mr-2">Categories:</span>
                                                                <span class="text-muted">@foreach($publisher->categories as $category) {{ $category->title }} @if(!$loop->last) , @endif @endforeach</span>
                                                            </div>
                                                        </div>
														<div class="d-flex flex-wrap mb-4">
                                                            @foreach($publisher->socialLinks as $link)
                                                                <a href="{{ $link->link }}" class="btn btn-sm btn-clean btn-icon" target="_blank" title="{{ $link->platform }}">
                                                                    <i class="fab fa-{{ $link->platform }}"></i>
                                                                </a>
                                                            @endforeach
															{{-- <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<i class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $publisher->email }}</a>
															<a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<i class="flaticon2-calendar-3 mr-2 font-size-lg"></i>{{ $publisher->updated_position }}</a>
															<a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
															<i class="flaticon2-placeholder mr-2 font-size-lg"></i> {{ $publisher->updated_team }}</a> --}}
														</div>

													</div>
													{{-- <div class="d-flex align-items-center w-25 flex-fill float-right mt-lg-12 mt-8">
														<span class="font-weight-bold text-dark-75">Progress</span>
														<div class="progress progress-xs mx-3 w-100">
															<div class="progress-bar bg-success" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
														<span class="font-weight-bolder text-dark">78%</span>
													</div> --}}
												</div>
												<!--end::Content-->
											</div>
											<!--end::Info-->
										</div>
										<!--end::Details-->
										<div class="separator separator-solid"></div>
										<!--begin::Items-->
										<div class="d-flex align-items-center flex-wrap mt-8">
											<!--begin::Item-->
											<div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
												<span class="mr-4">
													<i class="flaticon-piggy-bank display-4 text-muted font-weight-bold"></i>
												</span>
												<div class="d-flex flex-column text-dark-75">
													<span class="font-weight-bolder font-size-sm">Earnings</span>
													<span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 font-weight-bold">$</span>249,500</span>
												</div>
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
												<span class="mr-4">
													<i class="flaticon-confetti display-4 text-muted font-weight-bold"></i>
												</span>
												<div class="d-flex flex-column text-dark-75">
													<span class="font-weight-bolder font-size-sm">Expenses</span>
													<span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 font-weight-bold">$</span>164,700</span>
												</div>
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
												<span class="mr-4">
													<i class="flaticon-pie-chart display-4 text-muted font-weight-bold"></i>
												</span>
												<div class="d-flex flex-column text-dark-75">
													<span class="font-weight-bolder font-size-sm">Net</span>
													<span class="font-weight-bolder font-size-h5">
													<span class="text-dark-50 font-weight-bold">$</span>782,300</span>
												</div>
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
												<span class="mr-4">
													<i class="flaticon-file-2 display-4 text-muted font-weight-bold"></i>
												</span>
												<div class="d-flex flex-column flex-lg-fill">
													<span class="text-dark-75 font-weight-bolder font-size-sm">73 Tasks</span>
													<a href="#" class="text-primary font-weight-bolder">View</a>
												</div>
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
												<span class="mr-4">
													<i class="flaticon-chat-1 display-4 text-muted font-weight-bold"></i>
												</span>
												<div class="d-flex flex-column">
													<span class="text-dark-75 font-weight-bolder font-size-sm">648 Comments</span>
													<a href="#" class="text-primary font-weight-bolder">View</a>
												</div>
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											{{-- <div class="d-flex align-items-center flex-lg-fill mb-2 float-left">
												<span class="mr-4">
													<i class="flaticon-network display-4 text-muted font-weight-bold"></i>
												</span>
												<div class="symbol-group symbol-hover">
													<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Mark Stone">
														<img alt="Pic" src="assets/media/users/300_25.jpg" />
													</div>
													<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Charlie Stone">
														<img alt="Pic" src="assets/media/users/300_19.jpg" />
													</div>
													<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Luca Doncic">
														<img alt="Pic" src="assets/media/users/300_22.jpg" />
													</div>
													<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Nick Mana">
														<img alt="Pic" src="assets/media/users/300_23.jpg" />
													</div>
													<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Teresa Fox">
														<img alt="Pic" src="assets/media/users/300_18.jpg" />
													</div>
													<div class="symbol symbol-30 symbol-circle symbol-light">
														<span class="symbol-label font-weight-bold">5+</span>
													</div>
												</div>
											</div>
											<!--end::Item--> --}}
										</div>
										<!--begin::Items-->
									</div>
								</div>
								<!--end::Card-->

                <!--begin::Profile 4-->
                <div class="d-flex flex-row">
                    <!--begin::Content-->
                    <div class="flex-row-fluid ">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::Base Table Widget 1-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label font-weight-bolder text-dark">{{ __('Best Offers') }}</span>
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
                                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrdersCount->sum('orders') }}</span>
                                                                    {{-- <span class="text-muted font-size-sm font-weight-bold">Progress</span> --}}
                                                                </div>
                                                                {{ __('Order') }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column w-100 mr-2">
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrdersCount->sum('v_sales') }} {{ $offer->currency?$offer->currency->sign:__('SAR') }}</span>
                                                                    {{-- <span class="text-muted font-size-sm font-weight-bold">Progress</span> --}}
                                                                </div>
                                                                {{ __('Sales') }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column w-100 mr-2">
                                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                                    <span class="text-muted mr-2 font-size-sm font-weight-bold">{{ $publisher->sumOrdersCount->sum('v_payout') }} {{ $offer->currency?$offer->currency->sign:__('SAR') }}</span>
                                                                </div>
                                                                {{ __('Revene') }}
                                                            </div>
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
                                                <th style="min-width: 50px" class="pl-7">
                                                    <span class="text-dark-75">{{ _('Coupon') }}</span>
                                                </th>
                                                <th scope="col">{{ _('Coupon Status') }}</th>
                                                <th scope="col">{{ _('Discount') }}</th>
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
                                                    @if($coupon->report&&$coupon->report->orders > 1)
                                                        <span class="label label-lg label-success label-inline">Active</span>
                                                    @else
                                                        <span class="label label-lg label-danger label-inline">Unactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $offer->discount }} {{ $offer->discount_type=='flat'?$offer->currency->code:'%' }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->orders:0 }}</span>
                                                    <span class="text-muted font-weight-bold">Order</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->sales:0 }}</span>
                                                </td>
                                                <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->payout:0 }} </span></td>
                                                <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->v_orders:0 }} </span></td>
                                                <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->v_sales:0 }} </span></td>
                                                <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $coupon->report?$coupon->report->v_payout:0 }} </span></td>
                                            </tr>
                                            @endforeach
 
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