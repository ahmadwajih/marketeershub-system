@extends('admin.layouts.app')
@section('title','Country')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">

            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h2 class="card-title">{{ __('Country') . $country->name }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">

                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>اسم الدولة باللغة العربية</label>
                                                <input class="form-control" disabled  value="{{$country->name_ar }}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Country Name In English</label>
                                                <input class="form-control" disabled  value="{{$country->name_en }}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>{{ __("Code") }}</label>
                                                <input class="form-control" disabled  value="{{$country->code }}" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.countries.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                {{ __('Back') }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                    @can('view_user_activities')
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <h2 class="card-title">{{ __('User Activities') }} </h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                        <th scope="col">{{ __('Mission') }}</th>
                                        <th scope="col">{{ __('Updated By') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col">{{ __('Show History') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(getActivity('Country',$country->id ) as $activity)
                                            <tr>
                                                <td>{{ $activity->mission }}</td>
                                                <td> <a href="{{ route('admin.users.show',  $activity->user_id) }}" target="_blank" >{{ $activity->user->name }}</a> </td>
                                                <td>{{ $activity->created_at }}</td>
                                                <td>
                                                    @if(unserialize($activity->history))
                                                    <button class="btn btn-success show-history" data-id="{{ $activity->id }}">{{ __('Show') }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
