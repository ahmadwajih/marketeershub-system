const editSelected = document.querySelector('[data-kt-user-table-select="edit_selected"]');



if (editSelected) {
    // Deleted selected rows
    editSelected.addEventListener("click", function () {
        
        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
        Swal.fire({
            text: "Are you sure you want to edit selected coupons?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            html:`
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="form-label">Custom Revenue Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select id="payout_type" name="payout_type" data-control="select2" class="form-select">
                    <option value="flat">Flat</option>
                    <option value="percentage">Percentage</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <div class="mb-10 fv-row">
                <!--begin::Label-->
                <label class="required form-label">Custom Payout</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input id="payout" type="number" name="payout" class="form-control mb-2" placeholder="payout" />
                <!--end::Input-->
            </div>
            `,
            showLoaderOnConfirm: true,
            confirmButtonText: "Yes, update!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        }).then(function (result) {
            if (result.value) {
                var payout_type = $('#payout_type').val();
                var payout = $('#payout').val();
                $('input[name="item_check"]:checked').each(function (index) {
                    
                        $.ajax({
                            method: "POST",
                            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
                            url: route + "/change/revenue",
                            data: {
                                _token: csrfToken,
                                id: this.value,
                                payout_type: payout_type,
                                payout: payout,
                            },
                        })
                            .done(function (res) {
                                console.log(res);
                                Swal.fire({
                                    text: "Updating",
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 1,
                                });

                                

                            })
                            .fail(function (res) {
                                Swal.fire({
                                    text: res.responseJSON.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton:
                                            "btn fw-bold btn-primary",
                                    },
                                });
                            });

                    Swal.fire({
                        text: "You have updated all selected coupons!.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    }).then(function () {
                        // delete row data from server and re-draw datatable
                        $('#kt_table_users').DataTable().draw();
                    });
                });
                $('#kt_table_users').DataTable().draw();
            } else if (result.dismiss === "cancel") {
                Swal.fire({
                    text: "Selected coupns was not updated.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    },
                });
            }
        });
    });
}
