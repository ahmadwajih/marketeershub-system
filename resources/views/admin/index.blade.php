@extends('admin.layouts.app')
@section('title','Dashboard')
@push('styles')
  <style>
    .table  td {
      border: 1px solid #1e1e2d;
      color: #000;
    }
  </style>

@endpush
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
      </div>
      <!--end::Info-->
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
                  <table class="table table-head-custom table-head-bg  table-vertical-center" border="1">
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
                        <td class="pl-0 py-8" rowspan="4">
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
                      </tr>
                      <tr>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Affiliate') }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncer') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncer') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncer') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncer') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncer') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Influncer') }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
                        </td>
                        <td>  
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ __('Media Buying') }}</span>
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
