"use strict";
function restore(id, model, name) {
    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
    var table = document.getElementById("kt_table_users");
    var datatable = $("#kt_table_users").DataTable();

    Swal.fire({
        text: "Are you sure you want to restore " + name + "?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes restore!",
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary",
        },
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: restoreRoute,
                data: {
                    _token: csrfToken,
                    _method: "PUT",
                    id: id,
                    model: model,
                },
            })
                .done(function (res) {
                    // Simulate restore request -- for demo purpose only
                    Swal.fire({
                        text: "You have restored " + name + "!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    }).then(function () {
                        // restore row data from server and re-draw datatable
                        datatable.draw();
                    });
                })
                .fail(function (res) {
                    Swal.fire({
                        text:" You cant restore " + name,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                });
        } else if (result.dismiss === "cancel") {
            Swal.fire({
                text:" Canceled successfuly.",
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


const restoreSelected = document.querySelector('[data-kt-user-table-select="restore_selected"]');


        // Toggle restore selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Restored selected rows
        if (restoreSelected) {
            // Restored selected rows
            restoreSelected.addEventListener("click", function () {
                alert(this.value);
                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to restore selected customers?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Yes, restore!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        $('input[name="item_check"]:checked').each(function (index) {
                            $.ajax({
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content"),
                                },
                                url: restoreRoute,
                                data: {
                                    _token: csrfToken,
                                    _method: "DELETE",
                                    id: this.value,
                                    model: 'users',

                                },
                            })
                                .done(function (res) {
                                    Swal.fire({
                                        text: "Deleting " + customerName,
                                        icon: "info",
                                        buttonsStyling: false,
                                        showConfirmButton: false,
                                        timer: 1,
                                    });
                                    // Remove header checked box
                                    const headerCheckbox =
                                        container.querySelectorAll(
                                            '[type="checkbox"]'
                                        )[0];
                                    headerCheckbox.checked = false;
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
                                text: "You have restored all selected customers!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                },
                            }).then(function () {
                                // restore row data from server and re-draw datatable
                                datatable.draw();
                            });
                        });
                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: "Selected customers was not restored.",
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

