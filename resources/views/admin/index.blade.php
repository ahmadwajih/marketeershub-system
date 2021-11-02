@extends('admin.layouts.master')
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ __('Dashboard') }}</h5>
                <!--end::Page Title-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            {{-- <div class="d-flex align-items-center">
                <a href="https://mansour.shop/" target="_blank"  class="btn btn-sm btn-primary font-weight-bold mr-2"  data-placement="left">
                    <span class="font-size-base font-weight-bold mr-2 text-light">رابط الموقع</span>
                    <i class="flaticon2-website"></i>
                </a>

                <a href="http://webmail.mansour.shop/" target="_blank"  class="btn btn-sm btn-danger font-weight-bold mr-2"  data-placement="left">
                    <span class="font-size-base font-weight-bold mr-2">رابط الأيميل</span>
                    <i class="flaticon2-mail"></i>
                </a>

                <a href="https://web.whatsapp.com/" target="_blank" class="btn btn-sm btn-success font-weight-bold mr-2"  data-placement="left">
                    <span class="font-size-base font-weight-bold mr-2">رابط الواتساب</span>
                    <i class="flaticon-whatsapp"></i>
                </a>

            </div> --}}
            <!--end::Toolbar-->
        </div>
    </div>
    <!--begin::Entry-->
    {{-- <div class="d-flex flex-column-fluid" style="margin:1.5rem"> --}}
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-6 col-xxl-6 chart">
                    <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="col-lg-6 col-xxl-6 chart">
                    <canvas id="myChart2" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="col-lg-6 col-xxl-6 chart">
                    <canvas id="myChart3" style="width:100%"></canvas>
                </div>
                <div class="col-lg-6 col-xxl-6 chart">
                    <canvas id="myChart4" style="width:100%;max-width:600px"></canvas>
                </div>
                <div class="col-lg-12 col-xxl-12 chart">
                    <canvas id="myChart5" style="width:100%"></canvas>
                </div>
         
            </div>
            <!--end::Row-->
            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    {{-- </div> --}}
    <!--end::Entry-->

@endsection
@push('styles')
<style>
    .chart{
        margin: 50px auto;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    {{-- Chart 1 --}}
    <script>
        var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
        var yValues = [55, 49, 44, 24, 15];
        var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
        ];
        
        new Chart("myChart1", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: barColors,
            data: yValues
            }]
        },
        options: {
            title: {
            display: true,
            text: "World Wide Wine Production 2018"
            }
        }
        });
    </script>
    {{-- cHART 2 --}}
    <script>
        var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
        var yValues = [55, 49, 44, 24, 15];
        var barColors = [
          "#b91d47",
          "#00aba9",
          "#2b5797",
          "#e8c3b9",
          "#1e7145"
        ];
        
        new Chart("myChart2", {
          type: "doughnut",
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            title: {
              display: true,
              text: "World Wide Wine Production 2018"
            }
          }
        });
    </script>

    {{-- Chart 3 3 --}}
    <script>
        var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
        var yValues = [55, 49, 44, 24, 15];
        var barColors = ["red", "green","blue","orange","brown"];
        
        new Chart("myChart3", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: barColors,
            data: yValues
            }]
        },
        options: {
            legend: {display: false},
            title: {
            display: true,
            text: "World Wine Production 2018"
            }
        }
        });
    </script>

    {{-- Chart 4 --}}
    <script>
        var xValues = [50,60,70,80,90,100,110,120,130,140,150];
        var yValues = [7,8,8,9,9,9,10,11,14,14,15];
        
        new Chart("myChart4", {
          type: "line",
          data: {
            labels: xValues,
            datasets: [{
              fill: false,
              lineTension: 0,
              backgroundColor: "rgba(0,0,255,1.0)",
              borderColor: "rgba(0,0,255,0.1)",
              data: yValues
            }]
          },
          options: {
            legend: {display: false},
            scales: {
              yAxes: [{ticks: {min: 6, max:16}}],
            }
          }
        });
    </script>
    {{-- Chart 5 --}}
    <script>
        var xValues = [100,200,300,400,500,600,700,800,900,1000];
        
        new Chart("myChart5", {
          type: "line",
          data: {
            labels: xValues,
            datasets: [{ 
              data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
              borderColor: "red",
              fill: false
            }, { 
              data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
              borderColor: "green",
              fill: false
            }, { 
              data: [300,700,2000,5000,6000,4000,2000,1000,200,100],
              borderColor: "blue",
              fill: false
            }]
          },
          options: {
            legend: {display: false}
          }
        });
        </script>
        
@endpush
