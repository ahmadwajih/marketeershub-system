@extends('admin.layouts.app')
@section('title','العملات')
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
                            <h2 class="card-title">   {{$currency->name}} </h2>
                        </div>
                        <!--begin::Form-->
                        {{-- 
                            name
                            
                            sign
                            --}}
                        <form class="form">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>* الأسم  :</label>
                                                <input type="text" class="form-control" disabled value="{{$currency->name}}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>الكود  :</label>
                                                <input type="text" class="form-control" disabled value="{{$currency->code }}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label>العلامة  :</label>
                                                <input type="text" class="form-control" disabled value="{{$currency->sign }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.currencies.index')}}">
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

