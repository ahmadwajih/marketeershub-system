<div id="slaps_payout">
    <div class="card card-flush py-4">
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Repeater-->

            <div id="kt_docs_repeater_slaps_payout" class="mb-5 mt-5">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="payout_slaps">
                        <div data-repeater-item>
                            <div class="form-group  row mb-5 custom-class-in-form-repeater">
                                
                                <div class="col-md-3">
                                    <label class="form-label">From:</label>
                                    <input type="number" name="from" class="form-control mb-2 mb-md-0"  />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">To:</label>
                                    <input type="number" name="to" class="form-control mb-2 mb-md-0"  />
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Payout:</label>
                                    <input type="number" name="payout" class="form-control mb-2 mb-md-0"  />
                                </div>

                                <div class="col-md-3">
                                    <a href="javascript:;" data-repeater-delete class="btn btn-lg btn-light-danger mt-8 mt-md-8">
                                        <i class="la la-trash-o"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
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