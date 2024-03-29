<div class="row mb-9" id="static_payout" {!!  old('payout_cps_type') == null || old('payout_cps_type') == 'static' ?:  ' style="display: none" '!!}>

    <div class="col-md-11">
        <!--begin::Input group-->
        <div class="mb-10 fv-row">
            <!--begin::Label-->
            <label class="form-label">Payout Type</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select name="static_payout_type" data-control="select2" class="form-select">
                <option {{ old('static_payout_type') == 'flat' ? 'selected' : '' }} value="flat">{{ __('Per Order') }}
                </option>
                <option {{ old('static_payout_type') == 'percentage' ? 'selected' : '' }} value="percentage">
                    {{ __('Percentage') }}
                </option>
            </select>
            <!--end::Input-->
            @if ($errors->has('static_payout_type'))
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="text_input">{{ $errors->first('static_payout_type') }}</div>
                </div>
            @endif
        </div>
        <!--end::Input group-->
    </div>

    <!--begin::Repeater-->
    <div id="kt_docs_repeater_advanced_payout">
        <!--begin::Form group-->
        <div class="form-group">
            <div data-repeater-list="static_payout">
                @if(old('payout_cps_type') == 'static' && count(old('static_payout')) > 0)
                @foreach (old('static_payout') as $oldStaticpayout)
                <div data-repeater-item class="custom-class-in-form-repeater">

                    <div class="col-md-12 mb-4">
                        <!--begin::Input group-->
                        <div class="row">
                            <!--begin::Label-->
                            <div class="col-md-3">
                                <label class="required form-label mt-4">Payout</label>
                            </div>
                            <!--end::Label-->
                            <div class="col-md-8">
                                <!--begin::Input-->
                            <input type="number" step="0.1" min="0.1"  name="payout" class="form-control mb-2" placeholder="payout" value="{{ $oldStaticpayout['payout'] }}" />
                            <!--end::Input-->
                            @if ($errors->has('payout'))
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="text_input">{{ $errors->first('payout') }}</div>
                                </div>
                            @endif
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>


                    <div class="form-group row mb-5">
                        <div class="col-md-3">
                            <div class="form-check form-switch form-check-custom form-check-solid mt-9">
                                <input class="form-check-input switcher" data-input="text" name="date_range"  type="checkbox" onchange="switcherFunction(this)"
                                value="{{ isset($oldStaticpayout['date_range']) ? $oldStaticpayout['date_range'][0] : 'off'  }}" {{ isset($oldStaticpayout['date_range']) &&  $oldStaticpayout['date_range'][0] == 'on' ? 'checked' : ''  }}/>
                                <label class="form-check-label">
                                    Date Range
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">From Date:</label>
                            <input class="form-control" data-kt-repeater="datepicker" name="from_date" placeholder="Pick a date"  value="{{ isset($oldStaticpayout['from_date']) ? $oldStaticpayout['from_date'] : null }}" {{ isset($oldStaticpayout['date_range']) &&  $oldStaticpayout['date_range'][0] == 'on' ? '' : 'disabled' }}/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">To Date:</label>
                            <input class="form-control" data-kt-repeater="datepicker" name="to_date" placeholder="Pick a date"  value="{{ isset($oldStaticpayout['to_date']) ? $oldStaticpayout['to_date'] : null }}" {{ isset($oldStaticpayout['date_range']) &&  $oldStaticpayout['date_range'][0] == 'on' ? '' : 'disabled' }}/>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch form-check-custom form-check-solid mt-13">
                                <input class="form-check-input switcher" type="checkbox" name="countries" data-input="select" onchange="switcherFunction(this)"
                                onchange="switcherFunction(this)"  value="{{ isset($oldStaticpayout['countries']) ? $oldStaticpayout['countries'][0] : 'off'  }}" {{ isset($oldStaticpayout['countries']) &&  $oldStaticpayout['countries'][0] == 'on' ? 'checked' : ''  }} />
                                <label class="form-check-label">
                                    Countries
                                </label>
                            </div>
                        </div>

                        <div class="col-md-8 mt-4">
                            <label class="form-label">Select Options:</label>
                            <select class="form-select" data-kt-repeater="select22" name="countries_ids" data-placeholder="Select an option" {{ isset($oldStaticpayout['countries']) &&  $oldStaticpayout['countries'][0] == 'on' ? '' : 'disabled' }} multiple>
                                <option></option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ isset($oldStaticpayout['countries_ids']) && in_array($country->id, $oldStaticpayout['countries_ids']) ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-1">
                            <a href="javascript:;" data-repeater-delete
                                class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                <i class="la la-trash-o fs-3"></i>Delete
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div data-repeater-item class="custom-class-in-form-repeater">

                    <div class="col-md-12 mb-4">
                        <!--begin::Input group-->
                        <div class="row">
                            <!--begin::Label-->
                            <div class="col-md-3">
                                <label class="required form-label mt-4">Payout</label>
                            </div>
                            <!--end::Label-->
                            <div class="col-md-8">
                                <!--begin::Input-->
                            <input type="number" step="0.1" min="0.1"  name="payout" class="form-control mb-2" placeholder="payout" value="{{ old('payout') }}" />
                            <!--end::Input-->
                            @if ($errors->has('payout'))
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="text_input">{{ $errors->first('payout') }}</div>
                                </div>
                            @endif
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>


                    <div class="form-group row mb-5">
                        <div class="col-md-3">
                            <div class="form-check form-switch form-check-custom form-check-solid mt-9">
                                <input class="form-check-input switcher" data-input="text" name="date_range"  type="checkbox" onchange="switcherFunction(this)"
                                    value="off" />
                                <label class="form-check-label">
                                    Date Range
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">From Date:</label>
                            <input class="form-control" data-kt-repeater="datepicker" name="from_date" placeholder="Pick a date" disabled/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">To Date:</label>
                            <input class="form-control" data-kt-repeater="datepicker" name="to_date" placeholder="Pick a date" disabled/>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch form-check-custom form-check-solid mt-13">
                                <input class="form-check-input switcher" type="checkbox" name="countries" data-input="select" onchange="switcherFunction(this)"
                                    value="off" />
                                <label class="form-check-label">
                                    Countries
                                </label>
                            </div>
                        </div>

                        <div class="col-md-8 mt-4">
                            <label class="form-label">Select Options:</label>
                            <select class="form-select" data-kt-repeater="select22" name="countries_ids" data-placeholder="Select an option" disabled multiple>
                                <option></option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-1">
                            <a href="javascript:;" data-repeater-delete
                                class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                <i class="la la-trash-o fs-3"></i>Delete
                            </a>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
        <!--end::Form group-->
        <!--begin::Form group-->
        <div class="form-group">
            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                <i class="la la-plus"></i>Add
            </a>
        </div>
        <!--end::Form group-->
    </div>
    <!--end::Repeater-->

</div>
