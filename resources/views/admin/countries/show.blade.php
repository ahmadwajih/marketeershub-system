@extends('admin.layouts.app')
@section('title','الدول')
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
                            <h2 class="card-title"> الدولة : {{$country->name}}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-12 text-center">
                                                <div class="image-input image-input-outline image-input" id="kt_image">
                                                    <div class="image-input-wrapper"  style="background-image: url( {{getImagesPath("Countries").$country->flag}}" ></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> اسم الدولة :</label>
                                                <input class="form-control" disabled  value="{{$country->name}}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>  كود الدولة :</label>
                                                <input class="form-control" disabled  value="{{$country->code}}" />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label> لغة الدولة :</label>
                                                <input class="form-control" disabled  value="{{$country->language->name}}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label>  عملة الدولة :</label>
                                                <input class="form-control" disabled  value="{{$country->currency->name}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.admins.index')}}">
                                            <button type="button" class="btn btn-primary font-weight-bold mr-2">
                                                العـوده
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
