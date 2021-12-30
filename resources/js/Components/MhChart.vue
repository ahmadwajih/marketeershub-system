<template>
    <div class="col-lg-4">
        <div class="card card-custom card-stretch gutter-b">
            <div v-if="label" class="card-header border-0 pt-5">
                <h3 class="card-title font-weight-bolder">{{label}}</h3>
            </div>
            <div class="card-body d-flex flex-column">
                <div class="flex-grow-1">
                    <apexchart :type="type" :options="chartOptions" :series="series"></apexchart>
                </div>
                <div class="pt-5" slot="content"/>
            </div>
        </div>
    </div>
</template>
<script>
    import VueApexCharts from 'vue-apexcharts'

    export default {
        name: "MhChart",
        inheritAttrs: false,
        components: {
            apexchart: VueApexCharts,
        },
        props: {
            label: {
                type: String,
                default: 'Offers Market Share'
            },
            type: {
                type: String,
                default: 'pie'
            },
            segment: {
                type: String,
                default: 'chart/offers-market-share'
            }
        },
        data() {
            return {
                series: [],
                chartOptions: []
            }
        },
        created() {
            this.getChartData()
        },
        methods: {
            async getChartData() {
                await axios.get(this.segment).then(({data}) => {
                    this.series = data.series
                    this.chartOptions = data.chartOptions
                })
            }
        }
    }
</script>
