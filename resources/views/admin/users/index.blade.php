@extends('admin.layouts.app')
@section('title','Users')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                
                @if(session()->has('message'))
                @include('admin.temps.success')
                @endif
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3>{{ __('Users') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('admin.users.create')}}" class="btn btn-primary font-weight-bolder ">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span> {{ __('Add New User') }}
                        </a>

                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Search Form-->
                              <!--begin::Search Form-->
                              <div class="mb-7">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-xl-8">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 my-2 my-md-0">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" placeholder="{{ __('Search') }} ..." id="kt_datatable_search_query" />
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4 my-2 my-md-0">
                                                <div class="d-flex align-items-center">
                                                    <label class="mr-3 mb-0 d-none d-md-block">{{ __('Type') }}</label>
                                                    <select class="form-control" id="kt_datatable_search_team">
                                                        <option value="">All</option>
                                                        <option value="influencer">Influencer</option>
                                                        <option value="affiliate">Affiliate</option>
                                                        <option value="media_buying">Media buying</option>
                                                        <option value="digital_operation">Digital operation</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-4 my-2 my-md-0">
                                                <div class="d-flex align-items-center">
                                                    <label class="mr-3 mb-0 d-none d-md-block">الـنـوع:</label>
                                                    <select class="form-control" id="kt_datatable_search_type">
                                                        <option value="">الجمـيـع</option>
                                                        <option value="1">Online</option>
                                                        <option value="2">Retail</option>
                                                        <option value="3">Direct</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold">بــحــث</a>
                                    </div> --}}
                                </div>
                            </div>
                            <!--end::Search Form-->
                    <!--begin: Datatable-->
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')
<script>
     $('#kt_datatable_search_team').select2({
            placeholder: "Select Option",
        });
    var route = "{{ route('admin.users.index') }}";
    var publishers = "{{ route('admin.publisher.profile') }}";
</script>

<script src="{{asset('js/datatables/users.js')}}"></script>
@endpush
