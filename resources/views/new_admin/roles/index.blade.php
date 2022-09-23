@extends('new_admin.layouts.app')
@section('content')
    <!--begin::Products-->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
        @foreach ($roles as $role)
            <!--begin::Col-->
            <div class="col-md-4">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>{{ $role->name }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role->users()->count() }}
                        </div>
                        <!--end::Users-->
                        <!--begin::Permissions-->
                        <div class="d-flex flex-column text-gray-600">
                            @foreach ($role->abilities as $index => $ability)
                                @if ($index == 5)
                                @break
                            @endif
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>{{ $ability->label }}
                            </div>
                        @endforeach
                        @if ($role->abilities()->count() - 5 > 1)
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary me-3'></span>
                                <em>and {{ $role->abilities()->count() - 5 }} more...</em>
                            </div>
                        @endif
                    </div>
                    <!--end::Permissions-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer flex-wrap pt-0">
                    @can('show_roles')
                    <a href="{{ route('admin.roles.show', $role->id) }}"
                        class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                    @endcan
                    @can('update_roles')
                    <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                        onclick="loadRole({{ $role->id }})"
                        data-bs-target="#kt_modal_update_role">Edit Role</button>
                    @endcan
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    @endforeach
    @can('create_roles')
    <!--begin::Add new card-->
    <div class="ol-md-4">
        <!--begin::Card-->
        <div class="card h-md-100">
            <!--begin::Card body-->
            <div class="card-body d-flex flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_add_role">
                    <!--begin::Illustration-->
                    <img src="{{ asset('new_dashboard') }}/media/illustrations/sigma-1/4.png" alt=""
                        class="mw-100 mh-150px mb-7" />
                    <!--end::Illustration-->
                    <!--begin::Label-->
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                    <!--end::Label-->
                </button>
                <!--begin::Button-->
            </div>
            <!--begin::Card body-->
        </div>
        <!--begin::Card-->
    </div>
    <!--begin::Add new card-->
    @endcan
</div>
<!--end::Products-->
    @can('create_roles')
        <!--begin::Modal - Add role-->
            @include('new_admin.roles.create')
        <!--end::Modal - Add role-->
    @endcan
    @can('update_roles')
        <!--begin::Modal - Update role-->
        <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-1000px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Update Role</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-roles-modal-action="close">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                        rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_update_role_form" class="form" action="#" method="POST" test = " fffff">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                                data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header"
                                data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">

                                <img src="https://static.collectui.com/shots/3678774/dash-loader-large" alt="">
                            </div>
                                {{-- Ajax here --}}
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3"
                                    data-kt-roles-modal-action="cancel">Discard</button>
                                <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - Update role-->
    @endcan
@endsection
@push('scripts')
<script>
    var route = "{{ route('admin.roles.store') }}";
    var csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('new_dashboard') }}/js/roles/add.js"></script>
<script src="{{ asset('new_dashboard') }}/js/roles/update.js"></script>
@endpush

