@extends('admin.layouts.app')
@section('title','Payments')
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
                            <h2 class="card-title">{{ __('Create New Payment') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.payments.store')}}" method = "POST" enctype="multipart/form-data">
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
                                            <div class="col-lg-6">
                                                <label>* {{ __('Amount Paid') }} :</label>
                                                <input type="number" step="0.1" name="amount_paid" class="form-control"  value="{{old('amount_paid')}}" required />
                                                @if ($errors->has('amount_paid'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('amount_paid') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Publisher') }} :</label>
                                                <select class="form-control select2" id="kt_select_publisher_id" name="publisher_id">
                                                    @foreach($publishers as $publisher)
                                                        <option value="{{$publisher->id}}" {{old('publisher_id') == $publisher->id?'selected':''}}>{{$publisher->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('publisher_id'))
                                                <div>
                                                    <p class="invalid-input">{{ $errors->first('publisher_id') }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('From Date') }} :</label>
                                                <input type="date"  name="from" class="form-control"  value="{{old('from')}}" required />
                                                @if ($errors->has('from'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('from') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('To Date') }} :</label>
                                                <input type="date"  name="to" class="form-control"  value="{{old('to')}}" required />
                                                @if ($errors->has('to'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('to') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>* {{ __('Slip') }} :</label>
                                                <input type="file" name="slip" class="form-control"  value="{{old('slip')}}" />
                                                @if ($errors->has('slip'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('slip') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label>* {{ __('Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_type" name="type">
                                                    <option value="validation" selected {{old('type') == 'validation'?'selected':''}}>{{ __('After Validation') }}</option>
                                                    <option value="update"  {{old('type') == 'update'?'selected':''}}>{{ __('Upddate') }}</option>
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
        $('#kt_select_publisher_id').select2({
            placeholder: "Select Publisher",
        });
        $('#kt_select_type').select2({
            
        });
    </script>
@endpush

