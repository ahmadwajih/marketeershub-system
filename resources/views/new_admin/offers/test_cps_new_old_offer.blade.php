<div id="oldNew">
    <div class="row">
        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">New Revenue Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="new_revenue_type" data-control="select2" class="form-select">
                    <option {{ old('new_revenue_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                    <option {{ old('new_revenue_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                </select>
                <!--end::Input-->
                @if ($errors->has('new_revenue_type'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_revenue_type') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="required form-label">New Revenue</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="new_revenue" class="form-control mb-2" placeholder="New Revenue" value="{{ old('new_revenue') }}" />
                <!--end::Input-->
                @if ($errors->has('new_revenue'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_revenue') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">New Payout Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="new_payout_type" data-control="select2" class="form-select">
                    <option {{ old('new_payout_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                    <option {{ old('new_payout_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                </select>
                <!--end::Input-->
                @if ($errors->has('new_payout_type'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_payout_type') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="required form-label">New Payout</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="new_payout" class="form-control mb-2" placeholder="New Payout" value="{{ old('new_payout') }}" />
                <!--end::Input-->
                @if ($errors->has('new_payout'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('new_payout') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        {{--  Old  --}}

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">Old Revenue Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="old_revenue_type" data-control="select2" class="form-select">
                    <option {{ old('old_revenue_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                    <option {{ old('old_revenue_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                </select>
                <!--end::Input-->
                @if ($errors->has('old_revenue_type'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_revenue_type') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="required form-label">Old Revenue</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="old_revenue" class="form-control mb-2" placeholder="Old Revenue" value="{{ old('old_revenue') }}" />
                <!--end::Input-->
                @if ($errors->has('old_revenue'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_revenue') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">Old Payout Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="old_payout_type" data-control="select2" class="form-select">
                    <option {{ old('old_payout_type')=="flat"?"selected":"" }} value="flat">{{ __('Flat') }}</option>
                    <option {{ old('old_payout_type')=="percentage"?"selected":"" }} value="percentage">{{ __('Percentage') }}</option>
                </select>
                <!--end::Input-->
                @if ($errors->has('old_payout_type'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_payout_type') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">
            <!--begin::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="required form-label">Old Payout</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="old_payout" class="form-control mb-2" placeholder="Old Payout" value="{{ old('old_payout') }}" />
                <!--end::Input-->
                @if ($errors->has('old_payout'))
                    <div class="fv-plugins-message-container invalid-feedback"><div data-field="text_input" >{{ $errors->first('old_payout') }}</div></div>
                @endif
            </div>
            <!--end::Input group-->
        </div>


    </div>
</div>