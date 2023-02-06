"use strict";

// Delete One
function delete_row(id, title){
    Swal.fire({
        text: "Are you sure you want to delete " + title + "?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes, delete!",
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
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: route + "/" + id,
                data: {
                    _token: csrfToken,
                    _method: "DELETE",
                    id: id,
                },
            }).
            done(function (res) {
                    // Simulate delete request -- for demo purpose only
                    Swal.fire({
                        text: "You have deleted " + title + "!.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    }).then(function () {
                        // delete row data from server and re-draw datatable
                        $('.tr-'+id).remove();
                    });
                })
                .fail(function (res) {
                    Swal.fire({
                        title: title + " was not deleted.",
                        text:res.responseJSON.message,
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
                text: title + " was not deleted.",
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


// Delete Multi

function delete_selected(){

    Swal.fire({
        text: "Are you sure you want to delete selected publishers?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary",
        },
    }).then(function (result) {
        if (result.value) {
            // deleting progress bar
            $('.progress-title').html('Deleting...');
            $(".uploading-progress-bar").removeClass("d-none");
            function handler(e) {
                e.stopPropagation();
                e.preventDefault();
            }
            document.addEventListener("click", handler, true);
            //end
            let i = 1;
            let count = $(".table-checkbox:checked").length // will return count of checked checkboxes;
            $('.table-checkbox:checked').each(function () {
                let elValue = this.value;
                $.ajax({
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: route + "/" + this.value,
                    data: {
                        _token: csrfToken,
                        _method: "DELETE",
                        id: this.value,
                    },
                }).
                done(function (res) {
                    // Remove header checked box
                    $('.tr-'+elValue).remove();
                    // deleting progress bar
                    let percent = ((i /count) * 100 );
                    i++;
                    //progress-title
                    $('#progress-bar-percentage').html(Math.round(percent) + '%');
                    $("#progress-bar").width(Math.round(percent) +"%");
                    if (percent === 100){
                        $(".uploading-progress-bar").addClass("d-none");
                        document.removeEventListener('click', handler, true);
                        Swal.fire({
                            text: "You have deleted all selected publishers!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        });
                        $('.table-checkbox').prop('checked', false);
                        $('#delete_btn').addClass('d-none');
                        $('#add_btn').removeClass('d-none');
                    }
                    //end
                }).
                fail(function (res) {
                    Swal.fire({
                        text: res.responseJSON.message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                });
            });
        }
        else if (result.dismiss === "cancel") {
            Swal.fire({
                text: "Selected coupons was not deleted.",
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
