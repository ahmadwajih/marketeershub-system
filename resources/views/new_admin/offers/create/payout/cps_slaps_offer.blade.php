<div id="slaps_payout"  {!!  old('payout_cps_type') == 'slaps' ?:  ' style="display: none" '!!}>
    <div class="card card-flush py-4">
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Repeater-->

            <div id="kt_docs_repeater_slaps_payout" class="mb-5 mt-5">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="payout_slaps">
                        @if(old('payout_cps_type') == 'slaps' && count(old('payout_slaps')) > 0)
                        @foreach (old('payout_slaps') as $slap)
                            <div data-repeater-item>
                                <div class="form-group custom-class-in-form-repeater row mb-5">
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">From:</label>
                                        <input type="number" step="0.1" min="0.1"  name="from" class="form-control mb-2 mb-md-0" value="{{ $slap['from'] }}" />
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">To:</label>
                                        <input type="number" step="0.1" min="0.1"  name="to" class="form-control mb-2 mb-md-0"  value="{{ $slap['to'] }}"/>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Payout:</label>
                                        <input type="number" step="0.1" min="0.1"  name="payout" class="form-control mb-2 mb-md-0"  value="{{ $slap['payout'] }}"/>
                                    </div>

                                    <div class="col-md-3">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-lg btn-light-danger mt-8 mt-md-8">
                                            <i class="la la-trash-o"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div data-repeater-item>
                                <div class="form-group custom-class-in-form-repeater row mb-5">
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">From:</label>
                                        <input type="number" step="0.1" min="0.1"  name="from" class="form-control mb-2 mb-md-0"  />
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">To:</label>
                                        <input type="number" step="0.1" min="0.1"  name="to" class="form-control mb-2 mb-md-0"  />
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Payout:</label>
                                        <input type="number" step="0.1" min="0.1"  name="payout" class="form-control mb-2 mb-md-0"  />
                                    </div>

                                    <div class="col-md-3">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-lg btn-light-danger mt-8 mt-md-8">
                                            <i class="la la-trash-o"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end::Form group-->

                <!--begin::Form group-->
                <div class="form-group mt-5">
                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                        <i class="la la-plus"></i>Add
                    </a>
                </div>
                <!--end::Form group-->
            </div>
            <!--end::Repeater-->
        </div>
        <!--end::Card header-->
    </div>
</div>