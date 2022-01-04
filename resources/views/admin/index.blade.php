@extends('admin.layouts.app')@section('title','Dashboard')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="app">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                    <!--end::Page Title-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        @include('admin.components.dashboard-navtab')
<<<<<<< Updated upstream
=======
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <mh-chart width="100%"></mh-chart>
                    <mh-chart
                        height="350px"
                        label="Gross Margin Vs. Pay out (Aff)"
                        type="bar"
                        segment="chart/gm-v-po"
                    ></mh-chart>
                </div>
            </div>
        </div>
>>>>>>> Stashed changes
    </div>
@endsection
