<div id="slaps_revenue" {!!  old('revenue_cps_type') == 'slaps' ?:  ' style="display: none" '!!}>
    <div class="card card-flush py-4">
        <!--begin::Card body-->
        <div class="card-body pt-0">

            <div id="kt_docs_repeater_slaps_revenue" class="mb-5 mt-5">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="revenue_slaps">
                        @if(old('revenue_cps_type') == 'slaps' && count(old('revenue_slaps')) > 0)
                        @foreach (old('revenue_slaps') as $slap)
                            <div data-repeater-item>
                                <div class="form-group custom-class-in-form-repeater row mb-5">
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">From:</label>
                                        <input type="number" step="0.1" min="0.1"  name="from" class="form-control mb-2 mb-md-0" value="{{ $slap['from'] }}" />
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">To:</label>
                                        <input type="number" step="0.1" min="0.1"  name="to" class="form-control mb-2 mb-md-0"   value="{{ $slap['to'] }}"/>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Revenue:</label>
                                        <input type="number" step="0.1" min="0.1"  name="revenue" class="form-control mb-2 mb-md-0"  value="{{ $slap['revenue'] }}" />
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
                                    <label class="form-label">Revenue:</label>
                                    <input type="number" step="0.1" min="0.1"  name="revenue" class="form-control mb-2 mb-md-0"  />
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