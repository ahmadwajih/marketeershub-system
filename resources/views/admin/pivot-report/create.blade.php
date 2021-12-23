@extends('admin.layouts.app')
@section('title','Pivot Report')
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
                            <h2 class="card-title">{{ __('Upload Pivot Report') }}</h2>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="kt_form" action="{{route('admin.pivot-report.store')}}" method = "POST" enctype="multipart/form-data">
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
                                                <label>* {{ __('Type') }} :</label>
                                                <select class="form-control select2" id="kt_select_type" name="type" >
                                                    <option value="update">{{ __('Update') }}</option>
                                                    <option value="validation">{{ __('Validation Report') }}</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('type') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-4">
                                                <label>* {{ _('Offer') }} :</label>
                                                <select class="form-control select2" id="kt_select_offer_id" name="offer_id" required >
                                                    @foreach($offers as $offer)
                                                        <option {{old('offer_id')==$offer->id?"selected":""}} value="{{$offer->id}}">{{$offer->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('offer_id'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('offer_id') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-4">
                                                <label>* {{ __('Date') }} :</label>
                                                <input type="date" name="date" class="form-control"  value="{{old('date')}}" required />
                                                @if ($errors->has('date'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('date') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-9">
                                                <label>* {{ __('Upload Pivot Report') }} :</label>
                                                <input type="file" name="report" class="form-control"  value="{{old('report')}}" required />
                                                @if ($errors->has('report'))
                                                    <div>
                                                        <p class="invalid-input">{{ $errors->first('report') }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-lg-3">
                                                <br>
                                                <a href="{{ asset('dashboard/excel-sheets-examples/pivot.xlsx') }}" class="btn btn-primary mt-2" download>{{ __('Download Example') }}</a>
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
        $('#kt_select_offer_id').select2({
            placeholder: "Select Option",
        });
        $('#kt_select_type').select2({
            placeholder: "Select Option",
        });
    </script>
@endpush
