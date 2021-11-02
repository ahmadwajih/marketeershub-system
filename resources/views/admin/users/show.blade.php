@extends('admin.layouts.app')
@section('title','Users')
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
                                                <input class="form-control" disabled  value="{{$user->name }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Phone') }}</label>
                                                <input class="form-control" disabled  value="{{$user->phone}}" />
                                            </div>
                                        </div>

                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Email') }}:</label>
                                                <input class="form-control" disabled  value="{{$user->email }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Team') }} :</label>
                                                <input class="form-control" disabled  value="{{$user->team}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Position') }}:</label>
                                                <input class="form-control" disabled  value="{{$user->position }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Belongs To') }} :</label>
                                                <input class="form-control" disabled  value="{{$user->parent_id?$user->parent->name:'none'}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Genner') }}:</label>
                                                <input class="form-control" disabled  value="{{$user->gender }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Status') }} :</label>
                                                <input class="form-control" disabled  value="{{$user->status}}" />
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Country') }}</label>
                                                <input class="form-control" disabled  value="{{$user->country_id != null ? $user->country->name_en:"" }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('City') }}</label>
                                                <input class="form-control" disabled  value="{{$user->city_id !=null ? $user->city->name_en:""}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> {{ __('Years Of Experience') }} </label>
                                                <input class="form-control" disabled  value="{{$user->years_of_experience }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label> {{ __('Address') }}</label>
                                                <input class="form-control" disabled  value="{{$user->address}}" />
                                            </div>
                                        </div>
       

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.users.index')}}">
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
