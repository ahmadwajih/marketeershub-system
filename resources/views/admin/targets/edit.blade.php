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
                            <h2 class="card-title"> {{ __('Country') }} {{ $country->name }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.countries.update',$country->id)}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                        <div class="alert-icon">
                                            <i class="flaticon2-bell-5"></i>
                                        </div>
                                        <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                        <ul>
                                            @foreach($errors->all() as $error )
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
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
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <label>* اسم الدولة باللغة العربية :</label>
                                                <input type="text" name="name_ar" class="form-control"  value="{{old('name_ar') ?? $country->name_ar}}" />
                                                @if ($errors->has('name_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>    
                                            <div class="col-lg-4">
                                                <label>* Country Name In English :</label>
                                                <input type="text" name="name_en" class="form-control"  value="{{old('name_en') ?? $country->name_en}}" />
                                                @if ($errors->has('name_en'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name_en') }}</p>
                                                    </div>
                                                @endif
                                            </div>  
                                            <div class="col-lg-4">
                                                <label>* {{ __('Code') }}:</label>
                                                <input type="text" name="code" class="form-control"  value="{{old('code') ?? $country->code}}" />
                                                @if ($errors->has('code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('code') }}</p>
                                                    </div>
                                                @endif
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ _('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ _('Submit') }}</button>
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
