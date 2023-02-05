@extends('errors::minimal')

@section('title', __('Not Found'))
@section('content')
	<!--begin::Wrapper-->
    <div class="card card-flush w-lg-650px py-5">
        <div class="card-body py-15 py-lg-20">
            <!--begin::Title-->
            <h1 class="fw-bolder fs-2qx text-gray-900 mb-4">Not Found</h1>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="fw-semibold fs-6 text-gray-500 mb-7">This page is not found.</div>
            <!--end::Text-->
            <!--begin::Illustration-->
            <div class="mb-11">
                <img src="{{ asset('new_dashboard') }}/media/auth/404-error.png" class="mw-100 mh-300px theme-light-show" alt="" />
                <img src="{{ asset('new_dashboard') }}/media/auth/404-error-dark.png" class="mw-100 mh-300px theme-dark-show" alt="" />
            </div>
            <!--end::Illustration-->
            <!--begin::Link-->
            <div class="mb-0">

                @if(auth()->user())
                    @if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid']))
                        <a href="{{ route('admin.publisher.profile') }}" class="btn btn-sm btn-primary">{{ __('Go To My Profile') }}</a>
                    @else
                        <a href="{{ route('admin.user.profile') }}" class="btn btn-sm btn-primary">{{ __('Go To My Profile') }}</a>
                    @endif
                @else
                    <a href="{{ route('admin.publisher.profile') }}" class="btn btn-sm btn-primary">{{ __('Go To My Profile') }}</a>
                @endif
            </div>
            <!--end::Link-->
        </div>
    </div>
    <!--end::Wrapper-->
@endsection


