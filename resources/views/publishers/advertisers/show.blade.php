@extends('new_admin.layouts.app')
@section('title', 'Advertisers')
@section('subtitle', 'Show')
@section('content')
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Advertisers List</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Advertisers</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Advertisers Show</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="content flex-column-fluid" id="kt_content">
        <div class="card card-dashed">
            <div class="card-header">
                <h3 class="card-title">{{ $advertiser->company_name_en }}</h3>
                <div class="card-toolbar">
                    @if ($advertiser->status == 'active')
                        <button type="button" class="btn btn-sm btn-success"
                            onclick="changeStatus('{{ $advertiser->id }}','{{ $advertiser->id }}', 'inactive')">
                            Active
                        </button>
                    @else
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="changeStatus('{{ $advertiser->id }}','{{ $advertiser->id }}', 'active')">
                            Unctive
                        </button>
                    @endif
                    <a href="{{ route('admin.advertisers.edit', $advertiser->id) }}" style="margin-left: 7px;" class="btn btn-warning btn-sm">Edit</a>
                </div>
            </div>
            <div class="card-body">
                <div class="py-5">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 gy-7">

                            <tbody>
                                <tr>
                                    <td width="20%">Company Name</td>
                                    <td>{{$advertiser->company_name_ar}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Contact Person Name</td>
                                    <td>{{$advertiser->name}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Phone</td>
                                    <td>{{$advertiser->phone}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Email</td>
                                    <td>{{$advertiser->email}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Website Link</td>
                                    <td>{{$advertiser->website}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Validation Source</td>
                                    <td>{{$advertiser->validation_source}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Validation Duration</td>
                                    <td>{{$advertiser->validation_duration}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Validation Type</td>
                                    <td>{{$advertiser->validation_type}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Country</td>
                                    <td>{{$advertiser->country ? $advertiser->country->name : ''}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">City</td>
                                    <td>{{$advertiser->city?$advertiser->city->name:''}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Address</td>
                                    <td>{{$advertiser->address}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Categories</td>
                                    <td>
                                        @foreach($advertiser->categories as $category) {{ $category->title }} , @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">Access Username Or Email</td>
                                    <td>{{$advertiser->access_username}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Access Password</td>
                                    <td>{{$advertiser->access_password}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Currency</td>
                                    <td>{{$advertiser->currency?$advertiser->currency->name:''}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Language</td>
                                    <td>{{$advertiser->language}}</td>
                                </tr>
                                <tr>
                                    <td width="20%">Contract</td>
                                    <td>
                                        <div class="d-flex flex-aligns-center pe-10 pe-lg-20">
                                            <!--begin::Icon-->
                                            <img alt="" class="w-30px me-3" src="{{ asset('new_dashboard') }}/media/svg/files/pdf.svg" />
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="ms-1 fw-semibold">
                                                <!--begin::Desc-->
                                                <a href="{{ getImagesPath('Advertisers', $advertiser->contract) }}" download class="fs-6 text-hover-primary fw-bold">{{ $advertiser->contract }}</a>
                                                <!--end::Desc-->
                                            </div>
                                            <!--begin::Info-->
                                        </div>    
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">NDA</td>
                                    <td>
                                        <div class="d-flex flex-aligns-center pe-10 pe-lg-20">
                                            <!--begin::Icon-->
                                            <img alt="" class="w-30px me-3" src="{{ asset('new_dashboard') }}/media/svg/files/pdf.svg" />
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="ms-1 fw-semibold">
                                                <!--begin::Desc-->
                                                <a href="{{ getImagesPath('Advertisers', $advertiser->nda) }}" download class="fs-6 text-hover-primary fw-bold">{{ $advertiser->nda }}</a>
                                                <!--end::Desc-->
                                            </div>
                                            <!--begin::Info-->
                                        </div>    
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">IO</td>
                                    <td>
                                        <div class="d-flex flex-aligns-center pe-10 pe-lg-20">
                                            <!--begin::Icon-->
                                            <img alt="" class="w-30px me-3" src="{{ asset('new_dashboard') }}/media/svg/files/pdf.svg" />
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="ms-1 fw-semibold">
                                                <!--begin::Desc-->
                                                <a href="{{ getImagesPath('Advertisers', $advertiser->io) }}" download class="fs-6 text-hover-primary fw-bold">{{ $advertiser->io }}</a>
                                                <!--end::Desc-->
                                            </div>
                                            <!--begin::Info-->
                                        </div>    
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">Note</td>
                                    <td>{{$advertiser->Note}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var route = "{{ route('admin.advertisers.index') }}";
    </script>
    <script src="{{ asset('new_dashboard') }}/js/datatables/advertisers/change-status.js"></script>
@endpush
