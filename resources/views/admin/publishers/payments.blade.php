@extends('admin.layouts.app')
@section('title','Publishers')
@push('styles')
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

@endpush
@php
    $columns = [
        ['label' => __('Slip'), 'data'=> 'slip', 'disabled'=> true, 'checked' => true, 'bSearchable' => false],
        ['label' => __('ID'), 'data'=> 'id', 'disabled'=> true,  'bSearchable' => true],
        ['label' => __('Paid Amount'),'data'=> 'amount_paid', 'disabled'=> false, 'checked' => true, 'bSearchable' => true],
        ['label' => __('From'),'data'=> 'from', 'bSearchable' => true,  'disabled'=> true,],
        ['label' => __('To'),'data'=> 'to',   'bSearchable' => true],
        ['label' => __('Note'), 'data'=> 'note', 'bSearchable' => true, 'bSearchable' => false],
        ['label' => __('Action'), 'data'=> 'action', 'disabled'=> true, 'checked' => true, 'bSearchable' => false],

    ];
//dd(json_encode($columns));
    $thead = '';
    $dtColumns = [];
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

                                                @php
                                                 $thead .= '<th>'.$column['label'].'</th>';
                                                 $dtColumns[] = [
                                                     'name' =>$column['data'],
                                                     'data' =>$column['data'],
                                                     'bSearchable' =>$column['bSearchable'],
                                                     ];
                                                @endphp

                                                @continue(isset($column['disabled']))
                                                <div class="col-md-6">
                                                    <label class="checkbox checkbox-square" style="font-size: 11px">
                                                        <input class="toggle-column" type="checkbox" @isset($column['checked']) checked="checked" @endisset value="{{$column['data']}}">
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


                    </div>
                </div>

                <div class="card-body table-loading position-relative">
                    <table id="publisherTable" class="display dataTable no-footer" data-columns="{!! htmlspecialchars(json_encode($dtColumns)) !!}" data-action="{{ route('admin.publisher.payments', request()->all()) }}">
                        <thead>
                        <tr>
                            {!! $thead !!}
                        </tr>
                        </thead>
                        <tbody></tbody>
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



@endpush
