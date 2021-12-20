@extends('admin.layouts.app')
@section('title','City')
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
                            <h2 class="card-title"> {{ __('City') }} {{ $city->name }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.cities.update',$city->id)}}" method = "POST" enctype="multipart/form-data">
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
                                            <div class="col-lg-6">
                                                <label>* اسم المدينة باللغة العربية :</label>
                                                <input type="text" name="name_ar" class="form-control"  value="{{old('name_ar') ?? $city->name_ar}}" />
                                                @if ($errors->has('name_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>    
                                            <div class="col-lg-6">
                                                <label>* City Name In English :</label>
                                                <input type="text" name="name_en" class="form-control"  value="{{old('name_en') ?? $city->name_en}}" />
                                                @if ($errors->has('name_en'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('name_en') }}</p>
                                                    </div>
                                                @endif
                                            </div>  
                                             
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Code') }}:</label>
                                                <input type="text" name="code" class="form-control"  value="{{old('code') ?? $city->code}}" />
                                                @if ($errors->has('code'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('code') }}</p>
                                                    </div>
                                                @endif
                                            </div> 
                                            <div class="col-lg-6">
                                                <label>* {{ _('Country') }} :</label>
                                                <select class="form-control select2" id="kt_select_country_id" name="country_id" required>
                                                    @foreach($countries as $country)
                                                        <option {{old('country_id') == $country->id?'selected' : ($city->country_id==$country->id?'selected':'')}} value="{{$country->id}}">{{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('country_id') }}</p>
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
@push('scripts')
    <script>
        $('#kt_select_country_id').select2({
            placeholder: "Select Option",
        });
    </script>
@endpush