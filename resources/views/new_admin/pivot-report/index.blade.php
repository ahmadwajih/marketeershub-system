@extends('new_admin.layouts.app')
@section('title', 'Update Reports')
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
    @if(isset(request()->success) && request()->success == 'true')
        <!--begin::Alert-->
        <div class="alert alert-success d-flex align-items-center p-5">
            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                <i class="fa-solid fa-check fa-2x"></i>
            </span>
            <!--end::Icon-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column">
                <!--begin::Title-->
                <h4 class="mb-1 text-dark">Success</h4>
                <!--end::Title-->
                <!--begin::Content-->
                <p> {{ __('The report is Uploaded Successfully.') }}</p>
                @if($import_file)
                    <ul>
                        <li>Added : {{ $import_file->new  }}</li>
                        <li>Updated : {{ $import_file->updated }}</li>
                        <li>Issues : {{ $import_file->issues }}
                            @if($import_file->issues > 0)
                                <a download href="{{ $fileUrl }}/issues" class="btn btn-danger btn-sm">Download</a>
                            @endif
                        </li>
                        @if($import_file->failed > 0)
                            <br/>
                        @endif
                        <li>Failed : {{ $import_file->failed }}
                            @if($import_file->failed > 0)
                                <a download href="{{ $fileUrl }}/failed" class="btn btn-danger btn-sm">Download</a>
                            @endif
                        </li>
                        @if($import_file->duplicated > 0)
                            <br/>
                        @endif
                        <li>
                            Duplicated : {{ $import_file->duplicated }}
                            @if($import_file->duplicated > 0)
                                <a download href="{{ $fileUrl }}/duplicated" class="btn btn-danger btn-sm">Download</a>
                            @endif
                        </li>
                    </ul>
                @endif
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Close-->
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <span class="svg-icon svg-icon-2x svg-icon-light">
                    <i class="fa-solid fa-xmark fa-2x"></i>
                </span>
            </button>
            <!--end::Close-->
        </div>
        <!--end::Alert-->
    @endif
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Report Transactions List</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Report Transactions</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Report Transactions List</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar-->
    <div class="content flex-column-fluid" id="kt_content">
        <div class="uploading-progress-bar d-none">
             <h3 class="text-center progress-title">Uploading...</h3>
             <div class="progress">
                 <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><h5 id="progress-bar-percentage"><strong>0%</strong></h5></div>
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
                       <form action="{{ route('admin.reports.index') }}">
                            <!--end::Svg Icon-->
                            <div class="input-group mb-5">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search" aria-label="Search"
                                       aria-describedby="basic-addon2" value="{{ request()->search }}"
                                />
                                <button class="input-group-text" id="basic-addon2">Go</button>  <span class="mx-3 mt-3"> {{ $reports->total() }} Record</span>
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
                            <form action="{{ route('admin.reports.index') }}" method="GET">
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Offer:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid"  name="offer_id" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_62cfb00b8671a" >
                                                <option value="">No One</option>
                                                @foreach ($offers as $offer)
                                                    <option {{ session('pivot_report_filter_offer_id') == $offer->id ? 'selected' :''}} value="{{ $offer->id }}">{{ $offer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    @include('new_admin.components.publishers_filter')

                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Publisher:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid publishers_filter"
                                                    name="user_id" data-kt-select2="true" data-placeholder="Select option"
                                                    data-dropdown-parent="#kt_menu_62cfb00b8671a"
                                                    id="publishers_filter"
                                            >
                                                <option value="">No One</option>
                                                @if($publisherForFilter)
                                                    <option value="{{$publisherForFilter->id}}" selected >{{$publisherForFilter->name}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.reports.clear.sessions') }}" class="btn btn-sm btn-secondary w-100 mx-2">Clear Filter</a>
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
                        @can('create_pivot_report')
                            <a href="{{ route('admin.reports.create') }}" class="btn btn-primary">
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
                                <!--end::Svg Icon-->Upload Report
                            </a>
                        @endcan
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    @can('delete_pivot_report')
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
                                <th>#</th>
                                <th>{{ __('Offer Name') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Publisher Name') }}</th>
                                <th>{{ __('Team') }}</th>
                                <th>{{ __('Orders') }}</th>
                                <th>{{ __('Sales') }}</th>
                                <th>{{ __('Revenue') }}</th>
                                <th>{{ __('Payout') }}</th>
                                <th class="text-end min-w-100px">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($reports) > 0)
                            @foreach ($reports as $report)
                                <tr class="tr-{{ $report->id }}">
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input table-checkbox" name="item_check" type="checkbox"
                                                value="{{ $report->id }}" />
                                        </div>
                                    </td>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ $report->offer ? $report->offer->name :'' }}</td>
                                    <td>{{ $report->coupon ? $report->coupon->coupon :'' }}</td>
                                    <td>{{ $report->user ? $report->user->name :'' }}</td>
                                    <td>{{ $report->user ? $report->user->updated_team : '' }}</td>
                                    <td>{{ $report->orders }}</td>
                                    <td>{{  round($report->sales, 2) }}$</td>
                                    <td>{{  round($report->revenue, 2) }}$</td>
                                    <td>{{  round($report->payout, 2) }}$</td>
                                    <td>
                                        @can('update_coupons')
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
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="javascript:void(0)" class="menu-link px-3" onclick="delete_row('{{ $report->id }}', '{{ $report->coupon->coupon }}')">Delete</a>
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
                                    <td colspan="11">
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
                            {!! $reports->withQueryString()->links() !!}
                        </div>
                    </div>
                </div><!--end::Table-->
            </div><!--end::Card body-->
        </div><!--end::Card-->
     </div>
@endsection
@push('scripts')
    <script>
        let route = "{{ route('admin.reports.index') }}";
        let search = "{{ request()->search }}";
    </script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/pivot-report/delete_v2.js?v=60112212022"></script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/search.js?v=60112212022"></script>
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
                let numberOfChecked = $('.table-checkbox:checked').length;
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
    @if(isset(request()->uploading) && request()->uploading == 'true')
        <script>
            let import_status = 0;
            RepeatFun();
            let counter;
            $('.uploading-progress-bar').removeClass('d-none');
            function RepeatFun() {
                setInterval(function () {
                    if (import_status !== 1) {
                        $.ajax({
                            url: "{{ route('admin.reports.import.status') }}",
                        }).
                        done(function (data) {
                            if(data.started === false){
                                window.location.href = route + '?success=true';
                            }
                            if (data.started === true) {
                                let percent = ((data.current_row /data.total_rows) * 100 );
                                $('#progress-bar-percentage').html(Math.round(percent) + '%');
                                $("#progress-bar").width(Math.round(percent) +"%");
                            }
                        }).
                        fail(function (data) {
                            console.log('Job not added....' + data);
                        });
                    }
                }, 3000);
            }
        </script>
    @endif
@endpush
