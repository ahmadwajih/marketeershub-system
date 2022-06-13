@extends('admin.layouts.app')
@section('title','Help & Support')
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
                            <h2 class="card-title">{{ __('Edit') }} : {{ $help->title }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.helps.update', $help->id)}}" method = "POST" enctype="multipart/form-data">
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
                                            <div class="col-lg-12">
                                                <label>* {{ __('Title') }} :</label>
                                                <input type="text" name="title" class="form-control"  value="{{old('title') ??  $help->title}}" required />
                                                @if ($errors->has('title'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('title') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

   
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>* {{ __('Content') }} :</label>
                                                    <textarea class="summernote" id="kt_summernote_1" name="content">{!! old('content') ?? $help->content !!}</textarea>
                                                @if ($errors->has('content'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('content') }}</p>
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
        // Class definition

        var KTSummernoteDemo = function() {
            // Private functions
            var demos = function() {
                $('.summernote').summernote({
                    height: 150
                });
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTSummernoteDemo.init();
        });
    </script>
@endpush


