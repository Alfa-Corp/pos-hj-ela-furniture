<template>
    <Head>
        <title>Riwayat Produk Masuk - Sistem Kasir</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shopping-bag"></i> HISTORY IN PRODUCT {{ title ? title : "" }}</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="filter">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">DARI TANGGAL</label>
                                                <input type="date" v-model="start_date" class="form-control">
                                            </div>
                                            <div v-if="errors.start_date" class="alert alert-danger">
                                                {{ errors.start_date }}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">SAMPAI TANGGAL</label>
                                                <input type="date" v-model="end_date" class="form-control">
                                            </div>
                                            <div v-if="errors.end_date" class="alert alert-danger">
                                                {{ errors.end_date }}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-white">*</label>
                                                <button class="btn btn-md btn-purple border-0 shadow w-100"><i class="fa fa-filter"></i> FILTER</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="export text-end mb-3">
                                    <a :href="`/apps/products/${product_id}/in/export?start_date=${start_date}&end_date=${end_date}`" target="_blank" class="btn btn-success btn-md border-0 shadow me-3"><i class="fa fa-file-excel"></i> EXCEL</a>
                                    <a :href="`/apps/products/${product_id}/in/pdf?start_date=${start_date}&end_date=${end_date}`" target="_blank" class="btn btn-secondary btn-md border-0 shadow"><i class="fa fa-file-pdf"></i> PDF</a>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">No Telp</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Harga / Qty</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(product, index) in products.purchase_transaction_details" :key="index">
                                            <td>{{ product.created_at }}</td>
                                            <td>{{ product.purchase_transaction.supplier_id ? product.purchase_transaction.supplier.name_company : "Umum" }}</td>
                                            <td>{{ product.purchase_transaction.supplier_id ? product.purchase_transaction.supplier.no_telp : "" }}</td>
                                            <td>{{ product.purchase_transaction.supplier_id ? product.purchase_transaction.supplier.address : "" }}</td>
                                            <td>Rp.{{ formatPrice(product.price_per_qty) }}</td>
                                            <td>{{ product.qty }}</td>
                                            <td>Rp.{{ formatPrice(product.price) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
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

    //import Heade and Link from Inertia
    import { Head, Link } from '@inertiajs/inertia-vue3';

    //import hook ref
    import { ref } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        //layout
        layout: LayoutApp,

        //register components
        components: {
            Head,
            Link,
        },

        //props
        props: {
            errors: Object,
            products: Object,
        },

        //composition API
        setup(props) {
            const product_id = props.products.id;
            const title = props.products.title;
            const start_date = ref('' || (new URL(document.location)).searchParams.get('start_date'));
            const end_date = ref('' || (new URL(document.location)).searchParams.get('end_date'));

            const filter = () => {
                Inertia.get(`/apps/products/${props.products.id}/in/filter`, {
                    // send data to server
                    start_date: start_date.value,
                    end_date: end_date.value,
                });
            }

            return {
                product_id,
                start_date,
                end_date,
                title,
                filter,
            }
        }
    }
</script>

<style>

</style>
