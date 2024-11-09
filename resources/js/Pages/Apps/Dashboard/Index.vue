<template>

    <Head>
        <title>Dashboard - Sistem Kasir</title>
    </Head>

    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <!-- RESELLER -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="header">
                            <h1>RESELLER</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.sales_chart_reseller'])" class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PENJUALAN RESELLER CHART 7 HARI</span>
                            </div>
                            <div class="card-body">
                                <BarChart :chartData="chartSellResellerWeek" :options="options" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.best_reseller_selling_product'])" class="card border-0 rounded-3 shadow border-top-warning">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-pie"></i> PRODUK TERLARIS DI RESELLER</span>
                            </div>
                            <div class="card-body">
                                <DoughnutChart :chartData="chartResellerBestProduct" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.sales_today_reseller'])" class="card border-0 rounded-3 shadow border-top-info mb-4">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-line"></i> PENJUALAN RESELLER HARI INI</span>
                            </div>
                            <div class="card-body">
                                <strong>
                                    {{ count_sales_reseller_today }}
                                </strong> PENJUALAN
                                <hr>
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_sales_reseller_today) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.sales_month_reseller'])" class="card border-0 rounded-3 shadow border-top-info mb-4">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-line"></i> PENJUALAN RESELLER BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <strong>
                                    {{ count_sales_reseller_month }}
                                </strong> PENJUALAN
                                <hr>
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_sales_reseller_month) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.profits_today_reseller'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFITS RESELLER HARI INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_profits_reseller_today) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.profits_month_reseller'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFITS RESELLER BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_profits_reseller_month) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UMUM -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="header">
                            <h1>UMUM</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.sales_chart_umum'])" class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PENJUALAN UMUM CHART 7 HARI</span>
                            </div>
                            <div class="card-body">
                                <BarChart :chartData="chartSellUmumWeek" :options="options" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.best_umum_selling_product'])" class="card border-0 rounded-3 shadow border-top-warning">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-pie"></i> PRODUK TERLARIS DI UMUM</span>
                            </div>
                            <div class="card-body">
                                <DoughnutChart :chartData="chartUmumBestProduct" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.sales_today_umum'])" class="card border-0 rounded-3 shadow border-top-info mb-4">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-line"></i> PENJUALAN UMUM HARI INI</span>
                            </div>
                            <div class="card-body">
                                <strong>
                                    {{ count_sales_umum_today }}
                                </strong> PENJUALAN
                                <hr>
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_sales_umum_today) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.sales_month_umum'])" class="card border-0 rounded-3 shadow border-top-info mb-4">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-line"></i> PENJUALAN UMUM BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <strong>
                                    {{ count_sales_umum_month }}
                                </strong> PENJUALAN
                                <hr>
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_sales_umum_month) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.profits_today_umum'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFITS UMUM HARI INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_profits_umum_today) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div v-if="hasAnyPermission(['dashboard.profits_month_umum'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFITS UMUM BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(sum_profits_umum_month) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.sales_all_transaction_month'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PENJUALAN ALL TRANSACTION BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(sales_all_transaction_month) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.profit_all_transaction_month'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFIT ALL TRANSACTION BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(profit_all_transaction_month) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.cost_month'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PENGELUARAN BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(cost_month) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.profit_net_month'])"  class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> PROFIT NET BULAN INI</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(profit_net_month) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.assets'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> ASSET</span>
                            </div>
                            <div class="card-body">
                                <h5 class="fw-bold">Rp. {{ formatPrice(assets) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="hasAnyPermission(['dashboard.product_stock'])" class="card border-0 rounded-3 shadow border-top-success">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-box-open"></i> PRODUK FAVORITE STOCK</span>
                            </div>
                            <div class="card-body">
                                <div v-if="products_limit_stock.length > 0">
                                    <ol class="list-group list-group-numbered">
                                        <li v-for="product in products_limit_stock" :key="product.id" class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">{{ product.title }}</div>
                                            </div>
                                            <template v-if="parseInt(product.stock) < parseInt(product.stock_minimal)">
                                                <span class="badge bg-danger rounded-pill">kurang {{ parseInt(product.stock_minimal) - parseInt(product.stock) }} dari {{ parseInt(product.stock_minimal) }}</span>
                                                <span class="badge bg-danger rounded-pill">Rp.{{ formatPrice((parseInt(product.buy_price) * parseInt(product.stock)) - (parseInt(product.buy_price) * parseInt(product.stock_minimal))) }}</span>
                                            </template>
                                            <template v-else>
                                                <span class="badge bg-success rounded-pill">lebih {{ parseInt(product.stock) - parseInt(product.stock_minimal) }} dari {{ parseInt(product.stock_minimal) }}</span>
                                                <span class="badge bg-success rounded-pill">Rp.{{ formatPrice((parseInt(product.buy_price) * parseInt(product.stock)) - (parseInt(product.buy_price) * parseInt(product.stock_minimal))) }}</span>
                                            </template>
                                        </li>
                                    </ol>
                                </div>
                                <div v-else class="alert alert-danger border-0 shadow rounded-3">
                                    Data Tidak Tersedia!.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</template>

<script>
    //import layout
    import LayoutApp from '../../../Layouts/App.vue';

    //import Heade and useForm from Inertia
    import { Head } from '@inertiajs/inertia-vue3';

    //import ref from vue
    import { ref } from 'vue';

    //chart
    import { BarChart, DoughnutChart } from 'vue-chart-3';
    import { Chart, registerables } from "chart.js";

    //register chart
    Chart.register(...registerables);

    export default {

        //layout
        layout: LayoutApp,

        //register component
        components: {
            Head,
            BarChart,
            DoughnutChart
        },

        props: {
            // Reseller
            //total penjualan hari ini reseller
            count_sales_reseller_today: Number,

            //total penjualan bulan ini reseller
            count_sales_reseller_month: Number,

            //jumlah (Rp.) penjualan hari ini reseller
            sum_sales_reseller_today: Number,

            //jumlah (Rp.) penjualan hari ini reseller
            sum_sales_reseller_month: Number,

            //jumlah profit/laba hari ini reseller
            sum_profits_reseller_today: Number,

            //jumlah profit/laba hari ini reseller
            sum_profits_reseller_month: Number,

            //chart sales reseller
            sales_reseller_date: Array,
            reseller_grand_total: Array,

            //produk terlaris reseller
            reseller_product: Array,
            reseller_total: Array,

            // Umum
            //total penjualan hari ini Umum
            count_sales_umum_today: Number,

            //total penjualan bulan ini Umum
            count_sales_umum_month: Number,

            //jumlah (Rp.) penjualan hari ini Umum
            sum_sales_umum_today: Number,

            //jumlah (Rp.) penjualan bulan ini Umum
            sum_sales_umum_month: Number,

            //jumlah profit/laba hari ini Umum
            sum_profits_umum_today: Number,

            //jumlah profit/laba bulan ini Umum
            sum_profits_umum_month: Number,

            //chart sales Umum
            sales_umum_date: Array,
            umum_grand_total: Array,

            //produk terlaris Umum
            umum_product: Array,
            umum_total: Array,

            //produk limit stock
            products_limit_stock: Array,

            // Jumlah sales bulan ini dari seluruh transaction
            sales_all_transaction_month: Number,

            // Jumlah profit/laba bulan ini dari seluruh transaction
            profit_all_transaction_month: Number,

            // Jumlah cost/bulan
            cost_month: Number,

            // Profit Nett
            profit_net_month: Number,

            // asset
            assets: Number
        },

        setup(props) {

            //method random color
            function randomBackgroundColor(length) {
                var data = [];
                for (var i = 0; i < length; i++) {
                    data.push(getRandomColor());
                }
                return data;
            }

            //method generate random color
            function getRandomColor() {
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            //option chart
            const options = ref({
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                    },
                },
                beginZero: true
            });

            //chart sell week
            const chartSellResellerWeek = {
                labels: props.sales_reseller_date,
                datasets: [{
                    data: props.reseller_grand_total,
                    backgroundColor: randomBackgroundColor(props.sales_reseller_date.length),
                }, ],
            };

            //chart produk terlaris
            const chartResellerBestProduct = {
                labels: props.reseller_product,
                datasets: [{
                    data: props.reseller_total,
                    backgroundColor: randomBackgroundColor(5),
                }, ],
            };

            //chart sell week
            const chartSellUmumWeek = {
                labels: props.sales_umum_date,
                datasets: [{
                    data: props.umum_grand_total,
                    backgroundColor: randomBackgroundColor(props.sales_umum_date.length),
                }, ],
            };

            //chart produk terlaris
            const chartUmumBestProduct = {
                labels: props.umum_product,
                datasets: [{
                    data: props.umum_total,
                    backgroundColor: randomBackgroundColor(5),
                }, ],
            };

            return {
                options,

                chartSellResellerWeek,
                chartResellerBestProduct,

                chartSellUmumWeek,
                chartUmumBestProduct,

            }

        }
    }
</script>

<style>

</style>
