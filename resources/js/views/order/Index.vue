<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Order List
                    </div>
                    <div class="col-md-6 text-end">
                        <router-link to="/admin/product/create" class="btn btn-primary">
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
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{item.order_no}}</td>
                            <td>{{item.customer.name}}</td>
                            <td>{{item.customer.phone}}</td>
                            <td>{{item.discount}}</td>
                            <td>{{item.total}}</td>
                            <td>{{item.status}}</td>
                            <td>
                                <router-link :to="{ name: 'productedit', params: { id: item.id }}" class="btn btn-primary mx-2">View</router-link>
                                <router-link :to="{ name: 'addvariant', params: { id: item.id }}" class="btn btn-primary mx-2">Invoice</router-link>
                                <a @click="deletes(item.id)" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default{
    data(){
        return{
            items:[],
            id:null
        }
    },
    created(){
        axios.get('/api/getorder').then(response=>{
            console.log(response.data.data);
            this.items=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        creates(){
            axios.get('/api/getproduct').then(response=>{
                console.log(response.data.data);
                this.items=response.data.data;
            }).catch(error=>{
                console.log(error)
            });
        },
        deletes(id){
            const data={'id':id}
            axios.post('/api/product/delete',data).then(response=>{
                console.log(response);
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>