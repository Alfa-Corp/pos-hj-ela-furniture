<template>
    <Head>
        <title>Buat Baru Produk - Sistem Kasir</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shopping-bag"></i> BUAT BARU PRODUK</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Barcode</label>
                                                <input class="form-control" v-model="form.barcode" :class="{ 'is-invalid': errors.barcode }" type="text" placeholder="Barcode / Code Product">
                                            </div>
                                            <div v-if="errors.barcode" class="alert alert-danger">
                                                {{ errors.barcode }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Satuan Produk</label>
                                                <select class="form-select" :class="{ 'is-invalid': errors.unit_of_measurement_id }" v-model="form.unit_of_measurement_id">
                                                    <option v-for="(unit_of_measurement, index) in unit_of_measurements" :key="index" :value="unit_of_measurement.id">{{ unit_of_measurement.name }}</option>
                                                </select>
                                            </div>
                                            <div v-if="errors.unit_of_measurement_id" class="alert alert-danger">
                                                {{ errors.unit_of_measurement_id }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">Nama Produk</label>
                                                <input class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" type="text" placeholder="Title Product">
                                            </div>
                                            <div v-if="errors.title" class="alert alert-danger">
                                                {{ errors.title }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="fw-bold">Stock</label>
                                                <input class="form-control" v-model="form.stock" :class="{ 'is-invalid': errors.stock }" type="number" placeholder="Stock">
                                            </div>
                                            <div v-if="errors.stock" class="alert alert-danger">
                                                {{ errors.stock }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="fw-bold">Stock Minimal</label>
                                                <input class="form-control" v-model="form.stock_minimal" :class="{ 'is-invalid': errors.stock_minimal }" type="number" placeholder="Stock Minimal">
                                            </div>
                                            <div v-if="errors.stock_minimal" class="alert alert-danger">
                                                {{ errors.stock_minimal }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Deskripsi</label>
                                        <textarea class="form-control" v-model="form.description" :class="{ 'is-invalid': errors.description }" type="text" rows="4" placeholder="Deskripsi"></textarea>
                                    </div>
                                    <div v-if="errors.description" class="alert alert-danger">
                                        {{ errors.description }}
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Harga Beli</label>
                                        <input class="form-control" v-model="form.buy_price" @keyup="update" :class="{ 'is-invalid': errors.buy_price }" type="number" placeholder="Harga Beli">
                                    </div>
                                    <div v-if="errors.buy_price" class="alert alert-danger">
                                        {{ errors.buy_price }}
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Harga Jual Reseller</label>
                                        <input class="form-control" v-model="form.sell_price_reseller" @keyup="update" :class="{ 'is-invalid': errors.sell_price_reseller }" type="number" placeholder="Harga Jual Reseller">
                                    </div>
                                    <div v-if="errors.sell_price_reseller" class="alert alert-danger">
                                        {{ errors.sell_price_reseller }}
                                    </div>

                                    <div class="mb-3">
                                        <label class="fw-bold">Harga Jual Umum</label>
                                        <input class="form-control" v-model="form.sell_price_umum" @keyup="update" :class="{ 'is-invalid': errors.sell_price_umum }" type="number" placeholder="Harga Jual Umum">
                                    </div>
                                    <div v-if="errors.sell_price_umum" class="alert alert-danger">
                                        {{ errors.sell_price_umum }}
                                    </div>

                                    <div class="row">
                                        <div class="col-1">
                                            <label class="fw-bold">Favorite</label>
                                        </div>
                                        <div class="col-11">
                                            <input class="form-check-input" type="checkbox" v-model="form.is_favorite">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit"
                                            :disabled="
                                                form.buy_price <= 0 ||
                                                form.sell_price_reseller <= 0 ||
                                                form.sell_price_umum <= 0 ||
                                                form.sell_price_reseller < form.buy_price   ||
                                                form.sell_price_umum < form.buy_price"
                                            >SIMPAN</button>
                                            <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">RESET</button>
                                        </div>
                                    </div>
                                </form>

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

    //import reactive from vue
    import { reactive } from 'vue';

    //import inerita adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutApp,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            unit_of_measurements: Array
        },

        //composition API
        setup() {

            //define form with reactive
            const form = reactive({
                barcode: '',
                unit_of_measurement_id: '',
                title: '',
                description: '',
                buy_price: '',
                sell_price_reseller: '',
                sell_price_umum: '',
                stock: '',
                is_favorite: '',
                stock_minimal: '',
            });

            const update = () => {
                form.buy_price = form.buy_price;
                form.sell_price_reseller = form.sell_price_reseller;
                form.sell_price_umum  = form.sell_price_umum;
                form.is_favorite = form.is_favorite;
                form.stock_minimal = form.stock_minimal;
            }

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.post('/apps/products', {
                    //data
                    barcode: form.barcode,
                    unit_of_measurement_id: form.unit_of_measurement_id,
                    title: form.title,
                    description: form.description,
                    buy_price: form.buy_price,
                    sell_price_reseller: form.sell_price_reseller,
                    sell_price_umum: form.sell_price_umum,
                    stock: form.stock,
                    is_favorite: form.is_favorite,
                    stock_minimal: form.stock_minimal
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Product saved successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            return {
                form,
                submit,
                update,
            }

        }
    }
</script>

<style>

</style>
