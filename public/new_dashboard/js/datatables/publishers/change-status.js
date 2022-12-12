"use strict";
function changeStatus(id, name, action){
     // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
     var table = document.getElementById('kt_table_users');
    var datatable = $('#kt_table_users').DataTable();

     Swal.fire({
        text:
            "Are you sure you want to " + action + '?',
        icon: "warning",
        html:`
        <div class="mb-10 fv-row">
            <label class="form-label">Select Status</label>
            <select onchange="enableSwalConfirmationButton()" id="status" class="form-select form-control form-select-sm">
                <option value="" selected disabled>Select Status</option>
                <option value="active">Live</option>
                <option value="pending">Paused</option>
                <option value="inactive">Cancelled</option>
            </select>
        </div>
        `,
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Submit',
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton:
                "btn fw-bold btn-active-light-primary",
        },
    }).then(function (result) {
        if (result.value) {

            var status = $('#status').val(); 

            $.ajax({
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                url: route + "/change/status",
                data: {
                    _token: csrfToken,
                    _method: "POST",
                    id: id,
                    status: status,
                },
            })
                .done(function (res) {
                    // Simulate delete request -- for demo purpose only
                    Swal.fire({
                        text:
                            "Publisher's account status will be changed",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton:
                                "btn fw-bold btn-primary",
                        },
                    }).then(function () {
                        if(status == 'active'){
                            $('.active-btn-'+id).removeClass('d-none');
                            $('.pending-btn-'+id).addClass('d-none');
                            $('.inactive-btn-'+id).addClass('d-none');
                        }else if(status == 'pending'){
                            $('.active-btn-'+id).addClass('d-none');
                            $('.pending-btn-'+id).removeClass('d-none');
                            $('.inactive-btn-'+id).addClass('d-none');
                        }else{
                            $('.active-btn-'+id).addClass('d-none');
                            $('.pending-btn-'+id).addClass('d-none');
                            $('.inactive-btn-'+id).removeClass('d-none');
                        }
                        
                    });
                })
                .fail(function (res) {
                    Swal.fire({
                        text:
                        name + " was not " + status,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton:
                                "btn fw-bold btn-primary",
                        },
                    });
                });
        }else{
            $('.swal2-confirm').prop('disabled', false);
        }
    });

    $('.swal2-confirm').prop('disabled', true);
}

function enableSwalConfirmationButton(){
    $('.swal2-confirm').prop('disabled', false);
}