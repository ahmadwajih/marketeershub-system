@extends('admin.layouts.app')
@section('title','Categories')
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
                            <h2 class="card-title">{{ __('Create New Category') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.categories.store')}}" method = "POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-custom alert-light-danger" role="alert" id="kt_form_2_msg" >
                                    <div class="alert-icon">
                                        <i class="flaticon2-bell-5"></i>
                                    </div>
                                    <div class="alert-text font-weight-bold">{{ __('Validation error') }}</div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
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
                                                <label>* اسم القسم باللغه العربية :</label>
                                                <input type="text" name="title_ar" class="form-control"  value="{{old('title_ar')}}" required />
                                                @if ($errors->has('title_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('title_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* Category Title In English :</label>
                                                <input type="text" name="title_en" class="form-control"  value="{{old('title_en')}}" required />
                                                @if ($errors->has('title_en'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('title_en') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-4">
                                                <label>* {{ __('Category Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_type" name="type" >
                                                    <option {{ old('type')=="advertisers"?"selected":"" }} value="advertisers">{{ __('Advertisers') }}</option>
                                                    <option {{ old('type')=="publishers"?"selected":"" }} value="publishers">{{ __('Publishers') }}</option>
                                                    <option {{ old('type')=="offers"?"selected":"" }} value="offers">{{ __('Offers') }}</option>
                                                    <option {{ old('type')=="other"?"selected":"" }} value="other">{{ __('Other') }}</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('type') }}</p>
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
                                        <button type="reset" class="btn btn-light-primary font-weight-bold">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">{{ __("Submit") }}</button>
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
       $('#kt_select_type').select2({
            placeholder: "Select Option",
        });
    </script> 
@endpush

