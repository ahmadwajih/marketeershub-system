"use strict";
// Class definition
var datatable;

var KTDatatableRemoteAjaxDemo = function() {

    // basic demo
    var demo = function() {

        datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url:route,
                        method:'GET',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function(raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            console.log('start');
                            console.log(dataSet);
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
                saveState: false,

            },

            // layout definition
            layout: {
                scroll: true,
                footer: false,
                icons:{
                    pagination:{
                        pagination: {
                            next: 'la la-angle-right',
                            prev: 'la la-angle-left',
                            first: 'la la-angle-double-left',
                            last: 'la la-angle-double-right',
                            more: 'la la-ellipsis-h'
                          }
                    }
                }
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            }, rows: {
                afterTemplate: function (row, data, index) {
                    row.find('.delete-item').on('click', function () {
                        swal.fire({
                            text: "Are you sure you want to delete this item?",
                            confirmButtonText: "Yes, Delete!",
                            icon: "warning",
                            confirmButtonClass: "btn font-weight-bold btn-danger",
                            showCancelButton: true,
                            cancelButtonText: "No, Cancel",
                            cancelButtonClass: "btn font-weight-bold btn-primary"
                        }).then(function (result) {
                            if (result.value) {
                                swal.fire({
                                    title: "Loading ...",
                                    onOpen: function () {
                                        swal.showLoading();
                                    }
                                });
                                $.ajax({
                                    method: 'delete',
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    url: route + '/' + data.id,
                                    error: function (err) {
                                        if (err.hasOwnProperty('responseJSON')) {
                                            if (err.responseJSON.hasOwnProperty('message')) {
                                                swal.fire({
                                                    title: "Error !",
                                                    text: err.responseJSON.message,
                                                    confirmButtonText: "Ok",
                                                    icon: "error",
                                                    confirmButtonClass: "btn font-weight-bold btn-primary",
                                                });
                                            }
                                        }
                                        console.log(err);
                                    }
                                }).done(function (res) {
                                    swal.fire({
                                        text: "Deleted successfully ",
                                        confirmButtonText: "Accept",
                                        icon: "success",
                                        confirmButtonClass: "btn font-weight-bold btn-primary",
                                    });
                                    datatable.reload();
                                });
                            }
                        });
                    });
                }
            },

            // columns definition
            columns: [{
                field: 'id',
                title: '#',
                sortable: 'desc',
                width: 30,
                type: 'number',
                textAlign: 'center',

            },{
                field: 'user_id',
                title: "User ID",
                selector: false,
                textAlign: 'center',
            },{
                field: 'name',
                title: "Full Name",
                selector: false,
                textAlign: 'center',
            },{
                field: 'email',
                title: "Email",
                selector: false,
                textAlign: 'center',
            }, {
                field: 'created_at',
                title: "Date",
                selector: false,
                textAlign: 'center',
            }],

        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        // public functions
        init: function() {
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    KTDatatableRemoteAjaxDemo.init();
     
    $('#deletedAll').on('click', function(){

    var selected = datatable.getSelectedRecords();
    // foreach(selected as item){
    //     console.log(item);
    // }

    $.each(selected, function(index, item){
        console.log(item);
    })
    });
});