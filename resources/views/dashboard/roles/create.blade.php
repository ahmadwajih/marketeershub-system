@extends('dashboard.layouts.app')
@section('title','Roles')
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
                            <h2 class="card-title">{{ __('Create New Role') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('dashboard.roles.store')}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body p-0">
                                @if ($errors->any())
                                <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                    <div class="alert-icon">
                                        <i class="flaticon2-bell-5"></i>
                                    </div>
                                    <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                    <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span>
                                                <i class="ki ki-close"></i>
                                            </span>
                                    </button>
                                    </div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row p-10">
                                            <label for="example-name-ar-input" class="col-2 col-form-label">{{ __('Role Name') }}</label>
                                            <div class="col-10">
                                                <input class="form-control" name="name" type="text" value="{{ old('name') }}" id="example-name-ar-input"/>
                                                @if ($errors->has('name'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                    <table class="table bg-light">

                                        @foreach($models as $model)
                                            <thead class="thead-dark">
                                            <tr>
                                                <th colspan="2"
                                                    style="text-align: center">{{__(ucwords(str_replace('_', ' ', $model)))}}</th>
                                            </tr>
                                            <tr style="text-align: center">
                                                <td>{{ __('Role Name') }}</td>
                                                <td>{{ __('Status') }}</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($abilities as $ability)
                                                @if(strpos($ability->name, $model) !== false)
                                                    <tr style="text-align: center">
                                                        <td>{{$ability->label}}</td>
                                                        <td>
                                                        <span class="switch switch-icon mx-auto text-center"
                                                              style="width:fit-content">
                                                            <label>
                                                                <input type="checkbox" name="{{$ability->name}}"/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        @endforeach
                                    </table>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ __('Submit') }}</button>
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
