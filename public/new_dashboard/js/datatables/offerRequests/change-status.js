"use strict";
function changeStatus(id, name, action, className){
     // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
     var table = document.getElementById('kt_table_users');
    var datatable = $('#kt_table_users').DataTable();

     Swal.fire({
        text:
            "Are you sure you want to " + action + '?',
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes " + action + '!',
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton:
                "btn fw-bold btn-active-light-primary",
        },
    }).then(function (result) {
        if (result.value) {
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
                    status: action,
                },
            })
                .done(function (res) {
                    // Simulate delete request -- for demo purpose only
                    
                    Swal.fire({
                        text:
                            "You have " + action + ' ' + name +"!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton:
                                "btn fw-bold btn-primary",
                        },
                    }).then(function () {
                        if(action == 'approved'){
                            $('.active-btn-'+id).removeClass('d-none');
                            $('.inactive-btn-'+id).addClass('d-none');
                        }else{
                            $('.active-btn-'+id).addClass('d-none');
                            $('.inactive-btn-'+id).removeClass('d-none');
                        }
                    });
                })
                .fail(function (res) {
                    Swal.fire({
                        text:
                        name + " was not " + action,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton:
                                "btn fw-bold btn-primary",
                        },
                    });
                });
        } else if (result.dismiss === "cancel") {
            Swal.fire({
                text: name + " was not " + action,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                },
            });
        }
    });
}