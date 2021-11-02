@extends('admin.layouts.app')
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
                        <div class="card-header mx-auto text-center">
                            <h2 class="card-title font-weight-bolder">  {{ __('Role') }} {{$role->name}} </h2>
                        </div>

                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <div class="kt-section__content">

                                <table class="table bg-light">

                                    @foreach($models as $model)
                                        <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2" style="text-align: center">{{__(ucwords(str_replace('_', ' ', $model)))}}</th>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td>{{ __('Permission') }}</td>
                                            <td>{{ __('Status') }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($abilities as $ability)
                                            @if(strpos($ability->name, $model) !== false)
                                                <tr style="text-align: center">
                                                    <td>{{$ability->label}}</td>
                                                    <td>
                                                    <span class="switch switch-icon mx-auto text-center" style="width:fit-content">
                                                        <label>
                                                            <input type="checkbox"  disabled  {{ (old($ability->name) ?: $abilitiy_role->contains($ability))? 'checked' : '' }} />
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        <thead class="thead-dark">
                                        <tr>
                                            <th colspan="2"
                                                style="text-align: center">Settings</th>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td>{{ __('Permission') }}</td>
                                            <td>{{ __('Status') }}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr style="text-align: center">
                                            <td>View Settings</td>
                                            <td>
                                            <span class="switch switch-icon mx-auto text-center"
                                                  style="width:fit-content">
                                                <label>
                                                        <input type="checkbox" disabled {{ $abilitiy_role->contains(\App\Models\Ability::where('name','view_sittings')->first()) ? 'checked' : '' }} name="view_sittings"/>
                                                    <span></span>
                                                </label>
                                            </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="kt-portlet__foot" style="text-align: center">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 mt-5">
                                        <a href="{{route('admin.roles.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                {{ __('Back') }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end::Section-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

