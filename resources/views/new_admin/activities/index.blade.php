@extends('new_admin.layouts.app')
@section('title', 'User Activites')
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
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3"><i class="fa-solid fa-check fa-2x"></i></span>
            <!--end::Icon-->


            <!--begin::Close-->
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <span class="svg-icon svg-icon-2x svg-icon-light"><i class="fa-solid fa-xmark fa-2x"></i></span>
            </button>
            <!--end::Close-->
        </div>
        <!--end::Alert-->
    @endif
    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">User Activites</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">User Activites</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">User Activites List</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar-->
    <div class="content flex-column-fluid" id="kt_content">
         <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table class="table table-hover gy-3 gs-3">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>#</th>
                                <th>{{ __('USER NAME') }}</th>
                                <th>{{ __('ACTION') }}</th>
                                <th>{{ __('MODEL') }}</th>
                                <th>{{ __('SHOW') }}</th>
                                <th>{{ __('CREATED AT') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $activity)
                                <tr class="tr-{{ $activity->id }}">
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->user ? $activity->user->name :'' }}</td>
                                    <td>{{ $activity->mission }}</td>
                                    <td>{{ $activity->object }}</td>
                                    <td>
                                        <a href="{{ $activity->element }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>{{ $activity->created_at }}</td>

                                </tr>
                            @empty
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
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <div>
                            @include('new_admin.components.table_length')
                        </div>
                        <div>
                            {!! $activities->withQueryString()->links() !!}
                        </div>
                    </div>
                </div><!--end::Table-->
            </div><!--end::Card body-->
        </div><!--end::Card-->
     </div>
@endsection
