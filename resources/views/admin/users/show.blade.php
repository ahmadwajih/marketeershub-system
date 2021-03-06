@extends('admin.layouts.app')
@section('title', 'Users')
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
                            <h2 class="card-title">{{ __('User Name :') . $user->name }} </h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Use Name') }}</label>
                                                <input class="form-control" disabled value="{{ $user->name }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Phone') }}</label>
                                                <input class="form-control" disabled value="{{ $user->phone }}" />
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Email') }}:</label>
                                                <input class="form-control" disabled value="{{ $user->email }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Team') }} :</label>
                                                <input class="form-control" disabled value="{{ $user->team }}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Position') }}:</label>
                                                <input class="form-control" disabled value="{{ $user->position }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Belongs To') }} :</label>
                                                <input class="form-control" disabled
                                                    value="{{ $user->parent_id ? $user->parent->name : 'none' }}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Genner') }}:</label>
                                                <input class="form-control" disabled value="{{ $user->gender }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Status') }} :</label>
                                                <input class="form-control" disabled value="{{ $user->status }}" />
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Country') }}</label>
                                                <input class="form-control" disabled
                                                    value="{{ $user->country_id != null ? $user->country->name_en : '' }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('City') }}</label>
                                                <input class="form-control" disabled
                                                    value="{{ $user->city_id != null ? $user->city->name_en : '' }}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Years Of Experience') }} </label>
                                                <input class="form-control" disabled
                                                    value="{{ $user->years_of_experience }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Address') }}</label>
                                                <input class="form-control" disabled value="{{ $user->address }}" />
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
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
                                                @foreach (getActivity('User', $user->id) as $activity)
                                                    <tr>
                                                        <td>{{ $activity->mission }}</td>
                                                        <td> <a href="{{ route('admin.users.show', $activity->user_id) }}"
                                                                target="_blank">{{ $activity->user->name }}</a> </td>
                                                        <td>{{ $activity->created_at }}</td>
                                                        <td>
                                                            @if (unserialize($activity->history))
                                                                <button type="button" class="btn  {{ $activity->approved ? 'btn-success' : 'btn-warning ' }}  show-history" data-id="{{ $activity->id }}">{{ __('Show') }}</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            @endcan

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{ route('admin.users.index') }}">
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
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
