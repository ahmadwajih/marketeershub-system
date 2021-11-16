@extends('admin.layouts.app')
@section('title','Publishers')
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                
                @if(session()->has('message'))
                @include('admin.temps.success')
                @endif
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3>{{ __('Publishers') }}</h3>
                    </div>
                    <div class="card-toolbar">
                         <!--begin::Dropdown-->
                         <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span> <span class="m-2">{{ __('Sort By') }}</span>
                            </button>
                        </div>
                        <!--end::Dropdown-->

                        <a href="{{route('admin.publishers.create')}}" class="btn btn-primary font-weight-bolder ">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span> {{ __('Add New Publisher') }}
                        </a>
                        <!--end::Button-->
                    </div>
                </div>

                <div class="card-body">
                    <!--begin: Search Form-->
                    <form action="{{ route('admin.publishers.search') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-xl-12">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 my-2 my-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="{{ __('Search') }}" id="kt_datatable_search_query" />
                                                <span>
                                                    <i class="flaticon2-search-1 text-muted"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 my-2 my-md-0">
                                            <div class="d-flex align-items-center">
                                                <label class="mr-3 mb-0 d-none d-md-block">{{ __('Status') }}</label>
                                                <select class="form-control" id="kt_datatable_search_status" name="status">
                                                    <option value="">{{ __('All') }}</option>
                                                    <option {{isset($status)&&$status=='active'?'selected':'' }} value="active">{{ __('Active') }}</option>
                                                    <option {{isset($status)&&$status=='unactive'?'selected':'' }} value="unactive">{{ __('Unactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 my-2 my-md-0">
                                            <div class="d-flex align-items-center">
                                                <label class="mr-3 mb-0 d-none d-md-block">{{ __('Category') }}</label>
                                                <select class="form-control select2" id="kt_datatable_search_category_id" name="category_id" >
                                                    <option value="">{{ __('All') }}</option>
                                                    @foreach($categories as $category)
                                                        <option {{isset($category_id)&&$category_id==$category->id?'selected':'' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3  mt-5">
                                            <div class="d-flex align-items-center">
                                                <label class="d-none d-md-block">{{ __('Account Manager') }}</label>
                                                <select class="form-control select2" id="kt_select_account_manager_id" name="account_manager_id" >
                                                    <option value="">{{ __('All') }}</option>
                                                    @foreach($accountManagers as $accountManager)
                                                        <option {{isset($account_manager_id)&&$account_manager_id==$accountManager->id?'selected':'' }}  value="{{ $accountManager->id }}">{{ $accountManager->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 mt-5 mt-lg-0">
                                    <button type="submit" class="btn btn-light-primary px-6 font-weight-bold">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--begin::Search Form-->
                    <div class="mb-7">
                        <div class="row align-items-center">
                            {{-- <div class="col-lg-9 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="بــحــث ..." id="kt_datatable_search_query" />
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
      
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                                <a href="#" class="btn btn-light-primary px-6 font-weight-bold">بــحــث</a>
                            </div> --}}
                        </div>
                    </div>
                    <!--begin: Datatable-->
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')


<script>
    $('#kt_datatable_search_category_id').select2({
        placeholder: "Select Option",
    });
    $('#kt_select_account_manager_id').select2({
        placeholder: "Select Option",
    });
</script>

<script>
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
                        url:"{{ route('admin.publishers.search') }}?status={{ $status }}&category_id={{ $category_id }}&account_manager_id={{ $account_manager_id }}",
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
                scroll: false,
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
                                        confirmButtonText: "موافق",
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
                field: 'ho_id',
                title: 'HO ID',
                width: 30,
                type: 'number',
                textAlign: 'center',

            },{
                field: 'name',
                title: "Full Name",
                selector: false,
                textAlign: 'center',
            },{
                field: 'SM Platforms',
                title: "SM Platforms",
                sortable: false,
                width: 125,
                overflow: 'visible',
                selector: false,
                textAlign: 'center',
                autoHide: false,
                template: function(row) {
                    if(row.team == 'influencer'){
                        var data = row.socialLinks;
                        var links = '';
                        data.forEach(function (value, index) {
                            links += '\
                                <a href="' + value.link + '" class="btn btn-sm btn-clean btn-icon" target="_blank" title="'+value.platform+'">\
                                    \<i class="fab fa-'+value.platform+'"></i>\
                                </a>\
                            ';
    
                        });
                        return  links;
                    }
                    return null;
                },
            },{
                field: 'parent.name',
                title: "Account Manager",
                selector: false,
                textAlign: 'center',
            },{
                field: 'offersCount',
                title: "Offers",
                sortable:false,
                selector: false,
                textAlign: 'center',
            },{
                field: 'email',
                title: "Email",
                selector: false,
                textAlign: 'center',
            }, {
                field: 'phone',
                title: "Phone",
                selector: false,
                textAlign: 'center',
            },{
                field: 'team',
                title: "Team",
                selector: false,
                textAlign: 'center',
            }, {
                field: 'Status',
                title: "Status",
                sortable: false,
                width: 125,
                overflow: 'visible',
                selector: false,
                textAlign: 'center',
                autoHide: false,
                template: function(row) {
                    if(row.sumOrders){
                        return '<span class="badge badge-success">Active</span>';
                    }
                    return '<span class="badge badge-danger">Unactive</span>';
                },
            },{
                field: 'Actions',
                title: "Actions",
                sortable: false,
                width: 125,
                overflow: 'visible',
                selector: false,
                textAlign: 'center',
                autoHide: false,
                template: function(row) {
                    return '\
                        <div class="dropdown dropdown-inline">\
                            <a href="' + route + '/' + row.id  + '" class="btn btn-sm btn-clean btn-icon" title="Show">\
                             \<i class="flaticon-eye"></i>\
                            </a>\
                        </div>\
                        <a href="'+ route + '/' + row.id +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit">\
                            <span class="svg-icon svg-icon-md">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete-item" title="Delete">\
                            <span class="svg-icon svg-icon-md">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                    ';
                },
            }],

        });

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

</script>
@endpush
