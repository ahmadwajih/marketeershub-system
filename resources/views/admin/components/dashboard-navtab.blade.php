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
<div class="row">
    <div class="col-lg-12">

        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">{{ __('Services') }}</span>
                </h3>
                {{-- <div class="card-toolbar">
                  <a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">New Report</a>
                  <a href="#" class="btn btn-danger font-weight-bolder font-size-sm">Create</a>
                </div> --}}
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
                <div class="row">
                    <div class="col-4">

                        <ul class="nav flex-column nav-pills">
                            @foreach($tabNavs as $nav)
                                <li class="nav-item mb-2">
                                    <a class="nav-link @if($i === 1) active @endif" id="db-tabnav-{{$i}}" data-toggle="tab" href="#{{ $nav['id']  }}">
                                <span class="nav-icon">
                                    <i class="{{ $nav['icon']  }}"></i>
                                </span> <span class="nav-text">{{ $nav['label']  }}</span> </a>
                                </li>
                                @php $i++ @endphp
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-8 shadow-left">
                        <div class="tab-content" id="myTabContent5">
                            <div class="tab-pane fade show active" id="kpis" role="tabpanel" aria-labelledby="db-tabnav-tab-1">

                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Nick</td>
                                        <td>Stone</td>
                                        <td>
                                            <span class="label label-inline label-light-primary font-weight-bold">Pending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Ana</td>
                                        <td>Jacobs</td>
                                        <td>
                                            <span class="label label-inline label-light-success font-weight-bold">Approved</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>Pettis</td>
                                        <td>
                                            <span class="label label-inline label-light-danger font-weight-bold">New</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="overall" role="tabpanel" aria-labelledby="db-tabnav-tab-2">2</div>
                            <div class="tab-pane fade" id="teamPerformance" role="tabpanel" aria-labelledby="db-tabnav-tab-3">3</div>
                            <div class="tab-pane fade" id="publishersAnalytics" role="tabpanel" aria-labelledby="db-tabnav-tab-4">4</div>
                            <div class="tab-pane fade" id="offers" role="tabpanel" aria-labelledby="db-tabnav-tab-5">5</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
