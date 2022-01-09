<template>
    <div class="col-lg-6">
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
        name: "OffersOrders",
        inheritAttrs: false,
        components: {
            apexchart: VueApexCharts,
        },
        props: {
            label: {
                type: String,
                default: 'Offers Orders'
            },
            type: {
                type: String,
                default: 'pie'
            },
            segment: {
                type: String,
                default: 'charts/offers-orders'
            }, 
            for : {
                type: String,
                default: 'orders'
            }
        },
        data() {
            return {
                series: [],
                chartOptions: []
            }
        },
        created() {
            this.getChartData
        },
        methods: {

        },
         computed: {
            async getChartData() {
                await axios.get(this.segment).then(({data}) => {
                    if(this.for == 'orders'){
                        this.series = data.orders.series
                        this.chartOptions = data.orders.chartOptions
                    }
                    if(this.for == 'revenue'){
                        this.series = data.revenue.series
                        this.chartOptions = data.revenue.chartOptions
                    }
                    if(this.for == 'grossmargin'){
                        this.series = data.grossmargin.series
                        this.chartOptions = data.grossmargin.chartOptions
                    }
                    if(this.for == 'payout'){
                        this.series = data.payout.series
                        this.chartOptions = data.payout.chartOptions
                    }
                })
            }
        }
    }
</script>
