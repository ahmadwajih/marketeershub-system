@extends('dashboard.layouts.app')
@section('title','الصلاحيات')
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
                            <h2 class="card-title font-weight-bolder">  تعديل صلاحيه  {{$role->name}} </h2>
                        </div>

                    </div>
                    <div class="kt-portlet__body">


                        <form method = "POST" action="{{route('admin.roles.update',$role->id)}}">
                            @csrf
                            @method('PUT')
                            
                            <div class="kt-section">
                                <div class="kt-section__content">
                                    <div class="mb-3">
                                        <div class="mb-2">
                                            <div class="form-group row p-10">
                                                <label for="example-name-ar-input" class="col-2 col-form-label">اسم الصلاحيه</label>
                                                <div class="col-10">
                                                    <input class="form-control" name="name" type="text" value="{{ (old('name')!=null)?old('name'):$role->name }}" id="example-name-ar-input" placeholder="اسم الصلاحيه"/>
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

                                        @foreach($captions as $caption)
                                            <thead class="thead-dark">
                                            <tr>
                                                <th colspan="2"
                                                    style="text-align: center">{{__(ucwords(str_replace('_', ' ', $caption)))}}</th>
                                            </tr>
                                            <tr style="text-align: center">
                                                <td>الصلاحيه</td>
                                                <td>الحاله</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $ability)
                                                @if(strpos($ability->name, $caption) !== false)
                                                    <tr style="text-align: center">
                                                        <td>{{$ability->label}}</td>
                                                        <td>
                                                        <span class="switch switch-icon mx-auto text-center"
                                                              style="width:fit-content">
                                                            <label>
                                                                <input type="checkbox"    {{ (old($ability->name) ?: $role_permissions->contains($ability))? 'checked' : '' }} name="{{$ability->name}}"/>
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
                            </div>
                            <div class="kt-portlet__foot" style="text-align: center">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-12 mt-5">
                                                <button type="submit" class="btn btn-primary font-weight-bold mr-2">
                                                    حفظ
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

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

