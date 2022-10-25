@extends('new_admin.layouts.app')
@section('title', 'Team Members')
@section('subtitle', 'Edit')
@section('content')

    <div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bold my-1 fs-3">Edit Team Member</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="{{ route('admin.index') }}" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Users</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Team Member</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Edit</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <!--begin::Form-->
    <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <!--begin::Image input placeholder-->
                                <style>.image-input-placeholder { background-image: url('{{ getImagesPath("Users", $user->image) }}'); } [data-theme="dark"] .image-input-placeholder { background-image: url('{{ getImagesPath("Users", $user->image) }}'); }</style>
                                <!--end::Image input placeholder-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true" style="">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                                <!--end::Description-->
                                @if ($errors->has('image'))
                                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('image') }}</div></div>
                                @endif
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="row">

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Role</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="roles[]" aria-label="Select a Role" data-control="select2" data-placeholder="Select Role" class="form-select form-select-sm">
                                                @foreach($roles as $role)
                                                    <option {{ old('roles') && in_array($role->id, old('roles')) ? 'selected' : (in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '') }} value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('roles'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('roles') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Full Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2" placeholder="Full name" value="{{ old('name') ?? $user->name }}" required/>
                                            <!--end::Input-->
                                            @if ($errors->has('name'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('name') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" value="{{ old('email') ?? $user->email }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('email'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('email') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" value="{{ old('phone') ?? $user->phone }}" />
                                            <!--end::Input-->
                                            @if ($errors->has('phone'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('phone') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Password</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="password" name="password" class="form-control mb-2" placeholder="Password" autocomplete="off"/>
                                            <p >{{ __('Password should have at least 1 lowercase and 1 uppercase and 1 number and 1 symbol min 8 chars') }}</p>

                                            <!--end::Input-->
                                            @if ($errors->has('password'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('password') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Password Confirmation</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="password" name="password_confirmation" class="form-control mb-2" placeholder="Password" autocomplete="off"/>
                                            
                                            <!--end::Input-->
                                            @if ($errors->has('password_confirmation'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('password_confirmation') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Team</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="team" aria-label="Select a Team" data-control="select2" data-placeholder="date_period" class="form-select form-select-sm">
                                                <option {{ (old('team') && old('team')  == 'management' ) ? "selected" : ($user->team == 'management' ? "selected" : '') }} value="management">{{ __('Management') }}</option>
                                                <option {{ (old('team') && old('team')  == 'digital_operation' ) ? "selected" : ($user->team == 'digital_operation' ? "selected" : '') }} value="digital_operation">{{ __('Digital Operation') }}</option>
                                                <option {{ (old('team') && old('team')  == 'finance' ) ? "selected" : ($user->team == 'finance' ? "selected" : '') }} value="finance">{{ __('Finance') }}</option>
                                                <option {{ (old('team') && old('team')  == 'influencer' ) ? "selected" : ($user->team == 'influencer' ? "selected" : '') }} value="influencer">{{ __('Influencer') }}</option>
                                                <option {{ (old('team') && old('team')  == 'affiliate' ) ? "selected" : ($user->team == 'affiliate' ? "selected" : '') }} value="affiliate">{{ __('Affiliate') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('team'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('team') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Belongd To</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="parent_id" data-control="select2" class="form-select form-select-sm">
                                                <option selected value="">{{ __('No one') }}</option>
                                                @foreach ($parents as $parent)
                                                    <option {{ (old('parent_id') && old('parent_id') == $parent->id ) ? "selected" : ($user->parent_id == $parent->id ? "selected" : '') }} value="{{ $parent->id }}">{{  $parent->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('parent_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('parent_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Gender</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select name="gender" aria-label="Select a Gender" data-control="select2" data-placeholder="Select Gender" class="form-select form-select-sm">
                                                <option {{ old('gender') == 'male' ? "selected" : ($user->gender == 'male' ? "selected" : '') }} value="male">{{ __('Male') }}</option>
                                                <option {{ old('gender') == 'female' ? "selected" : ($user->gender == 'female' ? "selected" : '') }} value="female">{{ __('Female') }}</option>
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('gender'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('gender') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>

                                    <div class="col-md-6">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label">Country</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select id="country" name="country_id" data-control="select2" class="form-select form-select-sm">
                                                @foreach ($countries as $country)
                                                    <option {{ old('country_id') == $country->id ? "selected" : ($user->country_id == $country->id ? 'selected' : '') }} value="{{ $country->id }}">{{  $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                            @if ($errors->has('country_id'))
                                                <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('country_id') }}</div></div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="reset" class="btn btn-light me-5">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit"  class="btn btn-primary">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->

@endsection
@push('scripts')
{{-- <script src="{{ asset('new_dashboard') }}/js/custom/apps/ecommerce/catalog/save-product.js"></script> --}}

{{-- <script src="{{ asset('new_dashboard') }}/js/datatables\users\table.js"></script> --}}

<script>
    $(document).ready(function(){
        // get countries based on country
        $("#country").change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get({
                url: '{{ route('admin.ajax.cities') }}',
                data: {
                    countryId: $(this).val(),
                },
                beforeSend: function() {
                    $('#loading').show()
                },
                success: function(data) {
                    $('#cities').html(data)
                },
                complete: function() {
                    $('#loading').hide()
                }
            });


        });
    })
</script>

@endpush
