<div class="row mb-5" id="new_old_revenue">

    <div class="row">
        <div class="col-md-11">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">Revenue Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="new_old_revenue_type" data-control="select2" class="form-select">
                    <option {{ old('new_old_revenue_type') == 'flat' ? 'selected' : ($offer->revenue_cps_type == 'new_old' && $offer->cps->where('type', 'revenue') && $offer->cps->where('type', 'revenue')->first()->amount_type == 'flat' ? 'selected' : 'flat') }} value="flat">{{ __('Per Order') }}</option>
                    <option {{ old('new_old_revenue_type') == 'percentage' ? 'selected' : ($offer->revenue_cps_type == 'new_old' && $offer->cps->where('type', 'revenue') && $offer->cps->where('type', 'revenue')->first()->amount_type == 'percentage' ? 'selected' : 'percentage') }} value="percentage">{{ __('Percentage') }}</option>
                </select>
                <!--end::Input-->
                @if ($errors->has('new_old_revenue_type'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_old_revenue_type') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>
    </div>

    <!--begin::Repeater-->
    <div id="kt_docs_repeater_advanced_new_old_revenue">
        <!--begin::Form group-->
        <div class="form-group">
            <div data-repeater-list="new_old_revenue">
                @if($offer->revenue_cps_type == 'new_old')
                    @foreach ($offer->cps->where('type', 'revenue') as $cps)
                        <div data-repeater-item>
                            <div class="form-group custom-class-in-form-repeater row mb-5">
                                <div class="col-md-12 mb-3">
                                    <!--begin::Input group-->
                                    <div class="row">
                                        <!--begin::Label-->
                                        <div class="col-md-3">
                                            <label class="required form-label mt-4">New Revenue</label>
                                        </div>
                                        <!--end::Label-->
                                        <div class="col-md-8">
                                            <!--begin::Input-->
                                        <input type="number" step="0.1" min="0.1"  name="new_revenue" class="form-control mb-2" placeholder="New Revenue"
                                        value="{{ old('revenue') ?? $cps->new_amount }}" />
                                        <!--end::Input-->
                                        @if ($errors->has('new_revenue'))
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div data-field="text_input">{{ $errors->first('new_revenue') }}</div>
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
                                            <label class="required form-label mt-4">Old Revenue</label>
                                        </div>
                                        <!--end::Label-->
                                        <div class="col-md-8">
                                            <!--begin::Input-->
                                        <input type="number" step="0.1" min="0.1"  name="old_revenue" class="form-control mb-2" placeholder="Old Revemue"
                                        value="{{ old('old_revenue') ?? $cps->old_amount }}" />
                                        <!--end::Input-->
                                        @if ($errors->has('old_revenue'))
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div data-field="text_input">{{ $errors->first('old_revenue') }}</div>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mt-9">
                                        <input class="form-check-input form-check-input-revenue switcher" name="date_range" data-input="text"  type="checkbox" onchange="switcherFunction(this)" {{ $cps->date_range ? 'checked' : '' }}
                                            value="{{ $cps->date_range ? 'on' : 'off' }}" />
                                        <label class="form-check-label">
                                            Date Range
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">From Date:</label>
                                    <input class="form-control" data-kt-repeater="datepicker" name="from_date" value="{{ $cps->from_date }}" placeholder="Pick a date" {{ $cps->date_range ? '' : 'disabled' }}/>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">To Date:</label>
                                    <input class="form-control" data-kt-repeater="datepicker" name="to_date" value="{{ $cps->to_date }}" placeholder="Pick a date" {{ $cps->date_range ? '' : 'disabled' }}/>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check form-switch form-check-custom form-check-solid mt-13">
                                        <input class="form-check-input form-check-input-revenue switcher" type="checkbox" name="countries" data-input="select" onchange="switcherFunction(this)" {{ $cps->countries ? 'checked' : '' }}
                                            value="{{ $cps->countries ? 'on' : 'off' }}" />
                                        <label class="form-check-label">
                                            Countries
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-4">
                                    <label class="form-label">Select Options:</label>
                                    <select class="form-select" data-kt-repeater="select-revenue" name="countries_ids" data-placeholder="Select an option" disabled
                                        multiple>
                                        <option></option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $cps->countries_ids && in_array($country->id, json_decode($cps->countries_ids)) ? 'selected' : '' }}>{{ $country->name }}</option>
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
                    <div data-repeater-item>
                        <div class="form-group custom-class-in-form-repeater row mb-5">
                            <div class="col-md-12 mb-3">
                                <!--begin::Input group-->
                                <div class="row">
                                    <!--begin::Label-->
                                    <div class="col-md-3">
                                        <label class="required form-label mt-4">New Revenue</label>
                                    </div>
                                    <!--end::Label-->
                                    <div class="col-md-8">
                                        <!--begin::Input-->
                                    <input type="number" step="0.1" min="0.1"  name="new_revenue" class="form-control mb-2" placeholder="New Revenue"
                                    value="{{ old('revenue') }}" />
                                    <!--end::Input-->
                                    @if ($errors->has('new_revenue'))
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div data-field="text_input">{{ $errors->first('new_revenue') }}</div>
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
                                        <label class="required form-label mt-4">Old Revenue</label>
                                    </div>
                                    <!--end::Label-->
                                    <div class="col-md-8">
                                        <!--begin::Input-->
                                    <input type="number" step="0.1" min="0.1"  name="old_revenue" class="form-control mb-2" placeholder="Old Revemue"
                                    value="{{ old('old_revenue') }}" />
                                    <!--end::Input-->
                                    @if ($errors->has('old_revenue'))
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div data-field="text_input">{{ $errors->first('old_revenue') }}</div>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>

                            <div class="col-md-3">
                                <div class="form-check form-switch form-check-custom form-check-solid mt-9">
                                    <input class="form-check-input form-check-input-revenue switcher" name="date_range" data-input="text"  type="checkbox" onchange="switcherFunction(this)"
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
                                    <input class="form-check-input form-check-input-revenue switcher" type="checkbox" name="countries" data-input="select" onchange="switcherFunction(this)"
                                        value="off" />
                                    <label class="form-check-label">
                                        Countries
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-8 mt-4">
                                <label class="form-label">Select Options:</label>
                                <select class="form-select" data-kt-repeater="select-revenue" name="countries_ids" data-placeholder="Select an option" disabled
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