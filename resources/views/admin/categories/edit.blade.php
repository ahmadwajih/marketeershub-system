@extends('admin.layouts.app')
@section('title','Category')
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
                            <h2 class="card-title"> {{ __('Category') }} {{ $category->title }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.categories.update',$category->id)}}" method = "POST" enctype="multipart/form-data">
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
                                                <label>* اسم القسم باللغة العربية :</label>
                                                <input type="text" name="title_ar" class="form-control"  value="{{old('title_ar') ?? $category->title_ar}}" />
                                                @if ($errors->has('title_ar'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('title_ar') }}</p>
                                                    </div>
                                                @endif
                                            </div>    
                                            <div class="col-lg-4">
                                                <label>* Category Name In English :</label>
                                                <input type="text" name="title_en" class="form-control"  value="{{old('title_en') ?? $category->title_en}}" />
                                                @if ($errors->has('title_en'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('title_en') }}</p>
                                                    </div>
                                                @endif
                                            </div>  
                                            <div class="col-lg-4">
                                                <label>* {{ __('Category Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_type" name="type" >
                                                    <option {{ old('type')=="affiliate"?"selected":($category->type=='affiliate'?"selected":'') }} value="affiliate">{{ __('Affiliate') }}</option>
                                                    <option {{ old('type')=="influencer"?"selected":($category->type=='influencer'?"selected":'') }} value="influencer">{{ __('Influencer') }}</option>
                                                    <option {{ old('type')=="advertisers"?"selected":($category->type=='advertisers'?"selected":'') }} value="advertisers">{{ __('Advertisers') }}</option>
                                                    <option {{ old('type')=="offers"?"selected":($category->type=='offers'?"selected":'') }} value="offers">{{ __('Offers') }}</option>
                                                    <option {{ old('type')=="other"?"selected":($category->type=='other'?"selected":'') }} value="other">{{ __('Other') }}</option>
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
       $('#kt_select_type').select2({
            placeholder: "Select Option",
        });
    </script> 
@endpush