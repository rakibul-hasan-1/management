<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Order List
                    </div>
                    <div class="col-md-6 text-end">
                        <router-link to="/admin/order/create" class="btn btn-primary">
                            Create New
                        </router-link>
                    </div>
                </div>
                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Previous Due</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items.data" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{item.order_no}}</td>
                            <td>
                                {{item.customer.name}}
                                <br>
                                {{item.customer.phone}}
                            </td>
                            <td>{{item.discount}}</td>
                            <td>{{item.total}}</td>
                            <td>{{item.previous_due}} ({{item.previous_invoice_id}})</td>
                            <td>{{item.paid}}</td>
                            <td>{{item.due}}</td>
                            <td>{{item.status}}</td>
                            <td>
                                <router-link :to="{ name: 'orderview', params: { id: item.id }}" class="btn btn-primary mx-2">View</router-link>
                                <router-link :to="{ name: 'orderinvoiceview', params: { id: item.id }}" class="btn btn-primary mx-2">Invoice</router-link>
                                <a @click="deletes(item.id)" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
                </div>
                <Pagination :data="items" @pagination-change-page="getResults" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import LaravelVuePagination from 'laravel-vue-pagination';

export default{
    components: {
        'Pagination': LaravelVuePagination
    },
    data(){
        return{
            items:[],
            id:null
        }
    },
    created(){
        axios.get('/api/getorder').then(response=>{
            console.log(response.data);
            this.items=response.data;
        }).catch(error=>{
            console.log(error)
        });
        this.getResults();
    },
    methods:{
        getResults(page = 1) {
            axios.get('/api/getorder?page=' + page)
                .then(response => {
                    this.items = response.data;
                });
        },
        deletes(id){
            const data={'id':id};
            axios.post('/api/deleteorder',data)
                .then(response => {
                    this.getResults();
                });
        }
    }
}
</script>