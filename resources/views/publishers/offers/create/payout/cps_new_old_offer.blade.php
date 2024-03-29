<div class="row mb-5" id="new_old_payout">

    
    <div class="row">
        <div class="col-md-11">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">New Payout Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="new_old_payout_type" data-control="select2" class="form-select">
                    <option {{ old('new_old_payout_type')=="flat"?"selected":"" }} value="flat">{{ __('Per Order') }}</option>
                    <option {{ old('new_old_payout_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                </select>
                <!--end::Input-->
                @if ($errors->has('new_old_payout_type'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_old_payout_type') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>


    </div>

    <!--begin::Repeater-->
    <div id="kt_docs_repeater_advanced_new_old_payout">
        <!--begin::Form group-->
        <div class="form-group">
            <div data-repeater-list="new_old_payout">
                <div data-repeater-item class="custom-class-in-form-repeater">
                    <div class="form-group row mb-5">
                        <div class="col-md-12 mb-3">
                            <!--begin::Input group-->
                            <div class="row">
                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="required form-label mt-4">New Payout</label>
                                </div>
                                <!--end::Label-->
                                <div class="col-md-8">
                                    <!--begin::Input-->
                                <input type="number" step="0.1" min="0.1"  name="new_payout" class="form-control mb-2" placeholder="New Payout"
                                value="{{ old('payout') }}" />
                                <!--end::Input-->
                                @if ($errors->has('new_payout'))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="text_input">{{ $errors->first('new_payout') }}</div>
                                    </div>
                                @endif
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-md-12 mb-3">
                            <!--begin::Input group-->
                            <div class="row">
                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="required form-label mt-4">Old Payout</label>
                                </div>
                                <!--end::Label-->
                                <div class="col-md-8">
                                    <!--begin::Input-->
                                <input type="number" step="0.1" min="0.1"  name="old_payout" class="form-control mb-2" placeholder="Old Revemue"
                                value="{{ old('old_payout') }}" />
                                <!--end::Input-->
                                @if ($errors->has('old_payout'))
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="text_input">{{ $errors->first('old_payout') }}</div>
                                    </div>
                                @endif
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch form-check-custom form-check-solid mt-9">
                                <input class="form-check-input form-check-input-payout switcher" data-input="text" name="date_range" type="checkbox" onchange="switcherFunction(this)"
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
                                <input class="form-check-input form-check-input-payout switcher" name="countries" type="checkbox" data-input="select" onchange="switcherFunction(this)"
                                    value="off" />
                                <label class="form-check-label">
                                    Countries
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <label class="form-label">Select Options:</label>
                            <select class="form-select" data-kt-repeater="select-payout" name="countries_ids" data-placeholder="Select an option" disabled
                                multiple>
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