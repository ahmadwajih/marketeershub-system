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
                            <div class="symbol symbol-50 symbol-lg-120 symbol-primary">
                                <img class="profile-image" src="{{ getImagesPath('Users', $user->image) }}" alt="image" />
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
                                    <a href="#" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $user->name }}</a>
                                    @if($user->parent)
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
                                        <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $user->email }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-calendar-3 mr-2 font-size-lg"></i>{{ $user->updated_position }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                        <i class="flaticon2-placeholder mr-2 font-size-lg"></i> {{ $user->updated_team }}</a>
                                    </div>
                                    <div class="pt-8 pb-6">
                                        <div class="d-flex align-items-center justify-content-left">
                                            <span class="font-weight-bold mr-2">{{ __('Location') }}:</span>
                                            <span class="text-muted">{{ $user->country?$user->country->name_en:'' }}</span>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-left">
                                            <span class="font-weight-bold mr-2">{{ __('Categories') }}:</span>
                                            <span class="text-muted">@foreach($user->categories as $category) {{ $category->title }} @if(!$loop->last) , @endif @endforeach</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mb-4">
                                        @foreach($user->socialLinks as $link)
                                            <a href="{{ $link->link }}" class="btn btn-sm btn-clean btn-icon" target="_blank" title="{{ $link->platform }}">
                                                <i class="fab fa-{{ $link->platform }}"></i>
                                            </a>
                                        @endforeach
                                        {{-- <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{ $user->email }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                        <i class="flaticon2-calendar-3 mr-2 font-size-lg"></i>{{ $user->updated_position }}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                        <i class="flaticon2-placeholder mr-2 font-size-lg"></i> {{ $user->updated_team }}</a> --}}
                                    </div>

                                </div>
                                <div class="">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success">{{ __('Edit Profile') }}</a>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <div class="separator separator-solid"></div>
                </div>
            </div>
            <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection