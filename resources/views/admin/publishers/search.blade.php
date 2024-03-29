@extends('admin.layouts.app')
@section('title','Publishers')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

@endpush
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
                    <form action="{{ route('admin.publishers.search') }}" method="GET">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-xl-12 mb-5">
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
                                                    <option {{isset($status)&&$status=='active'?'selected':'' }} value="active">{{ __('Live') }}</option>
                                                    <option {{isset($status)&&$status=='closed'?'selected':'' }} value="closed">{{ __('Closed') }}</option>
                                                    <option {{isset($status)&&$status=='pending'?'selected':'' }} value="pending">{{ __('Paused') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 my-2 my-md-0">
                                            <div class="d-flex align-items-center">
                                                <label class="mr-3 mb-0 d-none d-md-block">{{ __('Category') }}</label>
                                                <select class="form-control selectpicker" data-live-search="true" id="" name="category_id" >
                                                    <option selected value="">{{ __('All') }}</option>
                                                    @foreach($categories as $category)
                                                        <option {{isset($category_id)&&$category_id==$category->id?'selected':'' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <label class="mr-3 mb-0 d-none d-md-block">{{ __('AM') }}</label>
                                                <select class="form-control selectpicker" data-live-search="true" id="" name="account_manager_id" >
                                                    <option value="">{{ __('All') }}</option>
                                                    <option {{isset($account_manager_id)&&$account_manager_id=='unassigned'?'selected':'' }} value="unassigned">{{ __('Un Assigned') }}</option>
                                                    @foreach($accountManagers as $accountManager)
                                                        <option {{isset($account_manager_id)&&$account_manager_id==$accountManager->id?'selected':'' }}  value="{{ $accountManager->id }}">{{ $accountManager->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 mt-5 mt-lg-0">
                                    <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block">{{ __('Search') }}</button>
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
                                            <input type="text" class="form-control" placeholder="{{ __('Search...') }}" id="kt_datatable_search_query" />
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
                    <table id="example" class="display">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>{{ __('Full Name') }}</th>
                                <th>{{ __('SM Platform') }}</th>
                                <th>{{ __('Account Manager') }}</th>
                                <th>{{ __('Offers') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Team') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publishers as $publisher)
                                <tr>
                                    <td>{{ $publisher->id }}</td>
                                    <td>{{ $publisher->name }}</td>
                                    <td>
                                        @foreach($publisher->socialLinks as $link)
                                        <a href="{{ $link->link }}" class="btn btn-sm btn-clean btn-icon" target="_blank" title="{{ $link->platform }}">
                                            <i class="fab fa-{{ $link->platform }}"></i>
                                        </a>
                                        @endforeach
                                    </td>
                                    <td>{{ $publisher->parent?$publisher->parent->name:'' }}</td>
                                    <td>{{ $publisher->offersCount }}</td>
                                    <td>{{ $publisher->email }}</td>
                                    <td>
                                        @if($publisher->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $publisher->team }}</td>
                                    <td>{{ $publisher->phone }}</td>
                                    <td>
                                        <div class="dropdown dropdown-inline">
                                            <a href="{{ route('admin.publishers.show', $publisher->id) }}" class="btn btn-sm btn-clean btn-icon" title="Show">
                                             <i class="flaticon-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.publishers.edit', $publisher->id) }}" class="btn btn-sm btn-clean btn-icon" title="Show">
                                             <i class="flaticon-edit"></i>
                                            </a>
                                        </div>    
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script>
    let table = new DataTable('#example', {
        // options
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

@endpush
