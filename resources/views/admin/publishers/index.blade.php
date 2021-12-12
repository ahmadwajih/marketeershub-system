@extends('admin.layouts.app')@section('title','Publishers')
@push('styles')
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

@endpush
@php
$columns = [
    ['name'=> 'id', 'label' => __('ID')],
    ['name'=> 'full_name', 'label' => __('Full Name')],
    ['name'=> 'email', 'label' => __('Email')],
    ['name'=> 'sm_platform', 'label' => __('SM Platform'), 'checked' => true],
    ['name'=> 'account_manager', 'label' => __('Account Manager'), 'checked' => true],
    ['name'=> 'offers', 'label' => __('Offers')],
    ['name'=> 'categories', 'label' => __('Categories')],
    ['name'=> 'phone', 'label' => __('Phone')],
    ['name'=> 'referral_am', 'label' => __('Referral AM'), 'checked' => true],
    ['name'=> 'join_date', 'label' => __('Join Date'), 'checked' => true],
    ['name'=> 'status', 'label' => __('Status')],
    ['name'=> 'action', 'label' => __('Action'), 'disabled'=> true],
];
$thead = '';
@endphp
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
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span> <span class="m-2">{{ __('Manage Columns') }}</span>
                            </button>
                            <div class="dropdown-menu float-right w-100" style="width: 300px !important;">
                                <!--begin: Search Form-->
                                <div class="px-4 py-3">
                                    <div class="checkbox-inline">
                                        <div class="row">
                                            @foreach($columns as $key=>$column)
                                                @php $thead .= '<th>'.$column['label'].'</th>' @endphp
                                                @continue(isset($column['disabled']))
                                                <div class="col-md-6">
                                                    <label class="checkbox checkbox-square" style="font-size: 11px">
                                                        <input class="toggle-column" type="checkbox" @isset($column['checked']) checked="checked" @endisset
                                                               value="{{$column['name']}}">
                                                        <span></span> {{$column['label']}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Search Form-->
                            </div>
                        </div>
                        <!--end::Dropdown-->
                        <!--begin::Dropdown-->
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"/>
                                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span> <span class="m-2">{{ __('Sort By') }}</span>
                            </button>
                            <div id="parent-dropdown" class="dropdown-menu float-right w-100" style="width: 300px !important;">
                                <!--begin: Search Form-->
                                <form class="px-4 py-3" action="{{ route('admin.publishers.search') }}" method="GET">
                                    <div class="form-group">
                                        <label>{{ __('Team') }}</label> <select class="form-control " id="" name="team">
                                            <option selected value="">{{ __('All') }}</option>
                                            <option {{ isset($team)&&$team=='affiliate'?'selected':'' }} value="affiliate">{{ __('Affiliate') }}</option>
                                            <option {{ isset($team)&&$team=='media_buying'?'selected':'' }} value="media_buying">{{ __('Media Buying') }}</option>
                                            <option {{ isset($team)&&$team=='influencer'?'selected':'' }} value="influencer">{{ __('Influencer') }}</option>
                                            <option {{ isset($team)&&$team=='prepaid'?'selected':'' }} value="prepaid">{{ __('Prepaid') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select class="form-control " id="kt_datatable_search_status" name="status">
                                            <option value="">{{ __('All') }}</option>
                                            <option {{isset($status)&&$status=='active'?'selected':'' }} value="active">{{ __('Active') }}</option>
                                            <option {{isset($status)&&$status=='closed'?'selected':'' }} value="closed">{{ __('Unactive') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Category') }}</label>
                                        <select class="form-control " data-live-search="true" id="" name="category_id">
                                            <option selected value="">{{ __('All') }}</option>
                                            @foreach($categories as $category)
                                                <option {{isset($category_id)&&$category_id==$category->id?'selected':'' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Social Media') }}</label>
                                        <select class="form-control " data-live-search="true" id="" name="platform">
                                            <option value="">{{ __('All') }}</option>
                                            <option {{isset($platform)&&$platform=='facebook'?'selected':'' }} value="facebook">{{ __('Facebook') }}</option>
                                            <option {{isset($platform)&&$platform=='instagram'?'selected':'' }} value="instagram">{{ __('Instagram') }}</option>
                                            <option {{isset($platform)&&$platform=='twitter'?'selected':'' }} value="twitter">{{ __('Twitter') }}</option>
                                            <option {{isset($platform)&&$platform=='snapchat'?'selected':'' }} value="snapchat">{{ __('Snapchat') }}</option>
                                            <option {{isset($platform)&&$platform=='tiktok'?'selected':'' }} value="tiktok">{{ __('Tiktok') }}</option>
                                            <option {{isset($platform)&&$platform=='youtube'?'selected':'' }} valuothere="youtube">{{ __('Youtube') }}</option>
                                            <option {{isset($platform)&&$platform=='other'?'selected':'' }} valuothere="other">{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-light-primary px-6 font-weight-bold btn-block">{{ __('Search') }}</button>
                                    </div>
                                </form>
                                <!--begin::Search Form-->
                            </div>
                        </div>
                        <!--end::Dropdown-->

                        <a href="{{route('admin.publishers.create')}}" class="btn btn-primary font-weight-bolder ">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <circle fill="#000000" cx="9" cy="15" r="6"/>
                                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span> {{ __('Add New Publisher') }}
                        </a>
                        <!--end::Button-->
                    </div>
                </div>

                <div class="card-body">
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
                    {{--
                    <div id="example_wrapper" class="dataTables_wrapper no-footer">
                    <div class="dataTables_length" id="example_length">
                        <label>
                            Show
                            <select name="example_length" aria-controls="example" class="">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            entries
                        </label>
                    </div>
                    <div id="example_filter" class="dataTables_filter">
                        <label>Search:<input type="search" class="" placeholder="" aria-controls="example"></label>
                    </div>
                    --}}
                    <script>

                    </script>
                    <table id="publisherTable" class="display dataTable no-footer" data-columns="{!! htmlspecialchars(json_encode($columns)) !!}">
                        <thead>
                        <tr>
                            {!! $thead !!}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($publishers as $publisher)
                            <tr>
                                <td class="sorting_1">{{ $publisher->id }}</td>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->email }}</td>
                                <td>
                                    @foreach($publisher->socialMediaLinks as $link)
                                        <a href="{{ $link->link }}" class="sm-platform" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ __('Followers :num', ['num'=>$link->followers]) }}"><i class="fab fa-{{ $link->platform }}"></i></a>
                                    @endforeach
                                </td>
                                <td>{!! $publisher->parent?$publisher->parent->name:" <button class='btn badge btn-success assignToMe' data-affiliate='".$publisher->id."'>".__('Assign To Me')."</button>" !!}</td>
                                <td>{{ $publisher->offersCount }}</td>
                                <td>
                                    @if($publisher->categories)
                                        @foreach($publisher->categories as $category)
                                            {{ $category->title }}
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $publisher->phone }}</td>
                                <td>{{ $publisher->referral_account_manager }}</td>
                                <td>{{ $publisher->created_at }}</td>
                                <td>
                                    @if($publisher->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Unactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown dropdown-inline">
                                        <a href="{{ route('admin.publishers.show', $publisher->id) }}" class="btn btn-sm btn-clean btn-icon" title="Show">
                                            <i class="flaticon-eye"></i> </a>
                                        <a href="{{ route('admin.publishers.edit', $publisher->id) }}" class="btn btn-sm btn-clean btn-icon" title="Show">
                                            <i class="flaticon-edit"></i> </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                    {{-- </div>--}}
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
        $('#kt_select_team').select2({
            placeholder: "Select Option",
        });
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.assignToMe').on('click', function () {
                var assignToMe = $(this);
                var affiliateId = $(this).data('affiliate');
                Swal.fire({
                    title: "{{ __('Are you sure?') }}",
                    text: '{{ "You won`t be able to revert this!" }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#dd3333',
                    confirmButtonText: '{{ __("Yes, assign!") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'post',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "{{ route('admin.publishers.updateAccountManager') }}",
                            data: {
                                affiliateId: affiliateId
                            },
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
                            console.log(res)
                            assignToMe.parent().html('<span class="btn btn-success">{{ __("Done") }}</span>');
                            Swal.fire(
                                '{{ __("Assigned Successfully!") }}',
                                'success'
                            )
                        });

                    }
                })
            })
        })
    </script>
@endpush
