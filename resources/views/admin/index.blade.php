@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
        <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
        <!--end::Page Title-->
        <!--begin::Actions-->
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">#XRS-45670</span>
        <a href="#" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</a>
        <!--end::Actions-->
      </div>
      <!--end::Info-->
      <!--begin::Toolbar-->
      <div class="d-flex align-items-center">
        <!--begin::Actions-->
        <a href="#" class="btn btn-clean btn-hover-light-primary- active btn-sm font-weight-bold font-size-base mr-1">Today</a>
        <a href="#" class="btn btn-clean btn-hover-light-primary- btn-sm font-weight-bold font-size-base mr-1">Month</a>
        <a href="#" class="btn btn-clean btn-hover-light-primary- btn-sm font-weight-bold font-size-base mr-1">Year</a>
        <!--end::Actions-->
        <!--begin::Dropdowns-->
        <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
          <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="svg-icon svg-icon-success svg-icon-lg">
              <!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg-->
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <polygon points="0 0 24 0 24 24 0 24" />
                  <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                  <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
                </g>
              </svg>
              <!--end::Svg Icon-->
            </span>
          </a>
          <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
            <!--begin::Navigation-->
            <ul class="navi navi-hover py-5">
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-drop"></i>
                  </span>
                  <span class="navi-text">New Group</span>
                </a>
              </li>
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-list-3"></i>
                  </span>
                  <span class="navi-text">Contacts</span>
                </a>
              </li>
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-rocket-1"></i>
                  </span>
                  <span class="navi-text">Groups</span>
                  <span class="navi-link-badge">
                    <span class="label label-light-primary label-inline font-weight-bold">new</span>
                  </span>
                </a>
              </li>
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-bell-2"></i>
                  </span>
                  <span class="navi-text">Calls</span>
                </a>
              </li>
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-gear"></i>
                  </span>
                  <span class="navi-text">Settings</span>
                </a>
              </li>
              <li class="navi-separator my-3"></li>
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-magnifier-tool"></i>
                  </span>
                  <span class="navi-text">Help</span>
                </a>
              </li>
              <li class="navi-item">
                <a href="#" class="navi-link">
                  <span class="navi-icon">
                    <i class="flaticon2-bell-2"></i>
                  </span>
                  <span class="navi-text">Privacy</span>
                  <span class="navi-link-badge">
                    <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                  </span>
                </a>
              </li>
            </ul>
            <!--end::Navigation-->
          </div>
        </div>
        <!--end::Dropdowns-->
      </div>
      <!--end::Toolbar-->
    </div>
  </div>
  <!--end::Subheader-->
  <!--begin::Entry-->
  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      <!--begin::Dashboard-->
      <!--begin::Row-->
      <div class="row">
        <div class="col-lg-12">
          <!--begin::Advance Table Widget 4-->
          <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">{{ __('Main Dashboard') }}</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"> {{ __('More than ') . App\Models\Offer::count() . __(' offer ') .  __('ًWith More than ')  . $offers->count() . __(' offer') }} </span>
              </h3>
              {{-- <div class="card-toolbar">
                <a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">New Report</a>
                <a href="#" class="btn btn-danger font-weight-bolder font-size-sm">Create</a>
              </div> --}}
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
              <div class="tab-content">
                <!--begin::Table-->
                <div class="table-responsive">
                  <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th style="min-width: 250px" class="pl-7">
                          <span class="text-dark-75">{{ __('Offer') }}</span>
                        </th>
                        <th style="min-width: 100px">{{ __('Team') }}</th>
                        <th style="min-width: 100px">{{ __('Orders') }}</th>
                        <th style="min-width: 100px">{{ __('Revenue') }}</th>
                        <th style="min-width: 100px">{{ __('Payout') }}</th>
                        <th style="min-width: 130px">{{ __('Gross Margin') }}</th>
                        <th style="min-width: 80px">{{ __('Total') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($offers as $offer)
                      <tr>
                        <td class="pl-0 py-8">
                          <div class="d-flex align-items-center">
                            <div class="symbol symbol-50 symbol-light mr-4">
                              <span class="symbol-label">
                                <img src="{{ asset('dashboard') }}/media/svg/avatars/001-boy.svg" class="h-75 align-self-end" alt="" />
                              </span>
                            </div>
                            <div>
                              <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Brad Simmons</a>
                              <span class="text-muted font-weight-bold d-block">HTML, JS, ReactJS</span>
                            </div>
                          </div>
                        </td>
                        <td>
                          <table>
                            <tr>
                              <td>
                                {{ __('Influncers') }}
                              </td>
                            </tr>
                            <tr>
                              <td>
                                {{ __('Affiliate') }}
                              </td>
                            </tr>

                              <tr>
                                <td>
                                  {{ __('Media Buying') }}
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  {{ __('Prepaid') }}
                                </td>
                              </tr>
                          </table>
                        </td>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>

                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                          </table>
                        </td>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>

                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                          </table>
                        </td>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>

                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                          </table>
                        </td>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>

                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                          </table>
                        </td>
                        <td>
                          <table>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                              </td>
                            </tr>

                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="text-dark-75 font-weight-bolder d-block font-size-lg">$8,000,000</span>
                                </td>
                              </tr>
                          </table>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!--end::Table-->
              </div>
            </div>
            <!--end::Body-->
          </div>
          <!--end::Advance Table Widget 4-->
        </div>
      </div>
      <!--end::Row-->
      <!--end::Dashboard-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::Entry-->
</div>
@endsection
