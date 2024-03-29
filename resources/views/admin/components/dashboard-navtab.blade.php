@push('styles')
    <style>
        .shadow-left {
            -webkit-box-shadow: -2px 0 0 0 rgba(50, 50, 50, 0.19);
            -moz-box-shadow: -2px 0 0 0 rgba(50, 50, 50, 0.19);
            box-shadow: -2px 0 0 0 rgba(50, 50, 50, 0.19);
        }
    </style>
@endpush
@php
    $tabNavs = [
                    [
                        'id' => 'kpis',
                        'icon' => 'flaticon2-chat-1',
                        'label' => __('KPIs')
                    ],
                     [
                        'id' => 'overall',
                        'icon' => 'flaticon2-chat-1',
                        'label' => __('Overall')
                    ],
                     [
                        'id' => 'teamPerformance ',
                        'icon' => 'flaticon2-chat-1',
                        'label' => __('Team Performance')
                    ],
                     [
                        'id' => 'publishersAnalytics',
                        'icon' => 'flaticon2-chat-1',
                        'label' => __('Publishers Analytics')
                    ],
                     [
                        'id' => 'offers',
                        'icon' => 'flaticon2-chat-1',
                        'label' => __('Offers')
                    ]
                ];
$i = 1;
@endphp
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row  mt-10">
            <div class="col-lg-12">
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Header-->
                {{--<div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">{{ __('Services') }}</span>
                    </h3>
                    --}}{{-- <div class="card-toolbar">
                      <a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">New Report</a>
                      <a href="#" class="btn btn-danger font-weight-bolder font-size-sm">Create</a>
                    </div> --}}{{--
                </div>--}}
                <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-0 pb-3">
                        <ul class="nav nav-tabs" style="margin-top: -41px;">
                            @foreach($tabNavs as $nav)
                                <li class="nav-item">
                                    <a class="nav-link @if($i === 2) active @endif" id="db-tabnav-{{$i}}" data-toggle="tab" href="#{{ $nav['id']  }}">
                                <span class="nav-icon">
                                    <i class="{{ $nav['icon']  }}"></i>
                                </span> <span class="nav-text">{{ $nav['label']  }}</span> </a>
                                </li>
                                @php $i++ @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content min-h-300px pt-4" id="myTabContent5">
                            <div class="tab-pane fade show " id="kpis" role="tabpanel" aria-labelledby="db-tabnav-tab-1">
                                @include('admin.components.kpis')
                            </div>
                            <div class="tab-pane active" id="overall" role="tabpanel" aria-labelledby="db-tabnav-tab-2">
                                @include('admin.components.overall')
                            </div>
                            <div class="tab-pane fade" id="teamPerformance" role="tabpanel" aria-labelledby="db-tabnav-tab-3">
                                @include('admin.components.team-performance')
                            </div>
                            <div class="tab-pane fade" id="publishersAnalytics" role="tabpanel" aria-labelledby="db-tabnav-tab-4">
                                @include('admin.components.publishers-analytics')
                            </div>
                            <div class="tab-pane fade" id="offers" role="tabpanel" aria-labelledby="db-tabnav-tab-5">
                                @include('admin.components.offers')
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
    </div>
</div>
