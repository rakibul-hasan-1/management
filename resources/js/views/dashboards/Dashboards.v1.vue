<script>
    import { 
        dashboardOne, 
        dashboardTwo, 
        splineAreaWidgetTwo, 
        splineAreaWidgetThree
    } from '@/data/dashboard.v1.js';
    import Breadcrumbs from '@/components/Breadcrumbs.vue'
import axios from 'axios';
    export default{
        data(){
            return{
                items:[],
                customer:0,
                supplier_cost:0,
                order:0,
                total_sell:0,
                total_product:0,
                total_credit:0,
                total_debit:0,
                orders:[],
            }
        },
        created(){
            axios.get('/api/getstock')
                    .then(response => {
                        this.items = response.data;
                    });
            axios.get('/api/detdashboarddetails')
                    .then(response => {
                        this.customer = response.data.customer;
                        this.supplier_cost = response.data.supplier_cost;
                        this.order = response.data.order;
                        this.total_sell = response.data.total_sell;
                        this.total_product = response.data.total_product;
                        this.total_credit = response.data.total_credit;
                        this.total_debit = response.data.total_debit;
                    });
            axios.get('/api/getrecentorder')
                    .then(response => {
                        this.orders = response.data;
                    });
        },
        methods:{
            getResults(page = 1) {
                axios.get('/api/getstock?page=' + page)
                    .then(response => {
                        this.items = response.data;
                    });
            },
            getResultss(page = 1) {
                axios.get('/api/getrecentorder?page=' + page)
                    .then(response => {
                        this.orders = response.data;
                    });
            },
        }
    }
    
</script>

<template>
    <div class="container mx-auto">
        <Breadcrumbs parentTitle="Dashboard" subParentTitle="Dashboard v1" />
        <div class="grid grid-cols-12 gap-5">
            <div
                class="
                    col-span-12
                    xl:col-span-3
                    lg:col-span-6
                    md:col-span-6
                    sm:col-span-6
                "
            >
                <BaseCard>
                    <div class="flex align-center">
                        <i class="i-Add-User text-6xl text-purple-200"></i>
                        <div class="m-auto">
                            <p class="text-gray-400">Total Customer</p>
                            <p class="text-xl text-primary">{{customer}}</p>
                        </div>
                    </div>
                </BaseCard>
            </div>
            <div
                class="
                    col-span-12
                    xl:col-span-3
                    lg:col-span-6
                    md:col-span-6
                    sm:col-span-6
                "
            >
                <BaseCard>
                    <div class="flex align-center">
                        <i class="i-Money-2 text-6xl text-purple-200"></i>
                        <div class="m-auto">
                            <p class="text-gray-400">Supplier Cost</p>
                            <p class="text-xl text-primary">{{supplier_cost}}</p>
                        </div>
                    </div>
                </BaseCard>
            </div>
            <div
                class="
                    col-span-12
                    xl:col-span-3
                    lg:col-span-6
                    md:col-span-6
                    sm:col-span-6
                "
            >
                <BaseCard>
                    <div class="flex align-center">
                        <i
                            class="i-Checkout-Basket text-6xl text-purple-200"
                        ></i>
                        <div class="m-auto">
                            <p class="text-gray-400">Orders</p>
                            <p class="text-xl text-primary">{{order}}</p>
                        </div>
                    </div>
                </BaseCard>
            </div>
            <div
                class="
                    col-span-12
                    xl:col-span-3
                    lg:col-span-6
                    md:col-span-6
                    sm:col-span-6
                "
            >
                <BaseCard>
                    <div class="flex align-center">
                        <i class="i-Money-2 text-6xl text-purple-200"></i>
                        <div class="m-auto">
                            <p class="text-gray-400">Total Sell</p>
                            <p class="text-xl text-primary">{{total_sell}}</p>
                        </div>
                    </div>
                </BaseCard>
            </div>
            <div
                class="
                    col-span-12
                    xl:col-span-3
                    lg:col-span-6
                    md:col-span-6
                    sm:col-span-6
                "
            >
                <BaseCard>
                    <div class="flex align-center">
                        <i class="i-Money-2 text-6xl text-purple-200"></i>
                        <div class="m-auto">
                            <p class="text-gray-400">Total Credit</p>
                            <p class="text-xl text-primary">{{total_credit}}</p>
                        </div>
                    </div>
                </BaseCard>
            </div>
            <div
                class="
                    col-span-12
                    xl:col-span-3
                    lg:col-span-6
                    md:col-span-6
                    sm:col-span-6
                "
            >
                <BaseCard>
                    <div class="flex align-center">
                        <i class="i-Money-2 text-6xl text-purple-200"></i>
                        <div class="m-auto">
                            <p class="text-gray-400">Total Debit</p>
                            <p class="text-xl text-primary">{{total_debit}}</p>
                        </div>
                    </div>
                </BaseCard>
            </div>
            <div class="col-span-12 xl:col-span-8 md:col-span-6">
            </div>
            <div class="col-span-12 xl:col-span-4 md:col-span-6">
            </div>
            <div class="col-span-12 xl:col-span-6 lg:col-span-6 md:col-span-12 sm:col-span-12">
                <BaseCard noPadding class="overflow-hidden">
                    <div class="p-3">
                        <div class="text-gray-500">Stock Alert</div>
                        <hr>
                        <div class="table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Color Code</th>
                                        <th>Volume</th>
                                        <th>Cartoon/Pieces</th>
                                        <th>Rack</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in items.data" :key="index">
                                        <td>{{item.color_code}}</td>
                                        <td>{{item.volume}}</td>
                                        <td>{{item.cartoon}}</td>
                                        <td>{{item.rack.name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination :data="items" @pagination-change-page="getResults" />
                    </div>
                </BaseCard>
            </div>
            <div class="col-span-12 xl:col-span-6 lg:col-span-6 md:col-span-12 sm:col-span-12">
                <BaseCard noPadding class="overflow-hidden">
                    <div class="p-3">
                        <div class="text-gray-500">Recent Orders</div>
                        <hr>
                        <div class="table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order Id</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>View/Invoice</th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in orders.data" :key="index">
                                        <td>{{item.date}}</td>
                                        <td>{{item.order_no}}</td>
                                        <td>{{item.discount}}</td>
                                        <td>{{item.total}}</td>
                                        <td>
                                            <router-link :to="{ name: 'orderview', params: { id: item.id }}" class="btn btn-primary mx-2">View</router-link>
                                            <router-link :to="{ name: 'orderinvoiceview', params: { id: item.id }}" class="btn btn-primary mx-2" target="_blank">Invoice</router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination :data="orders" @pagination-change-page="getResultss" />
                    </div>
                </BaseCard>
            </div>
        </div>
    </div>
</template>
