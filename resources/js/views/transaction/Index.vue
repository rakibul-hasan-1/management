<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Transaction List
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
                            <th>Date</th>
                            <th>Type</th>
                            <th>For</th>
                            <th>Details</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items.data" :key="index" :class="item.type">
                            <td>{{index+1}}</td>
                            <td>{{item.date}}</td>
                            <td>{{item.type}}</td>
                            <td>{{item.for}}</td>
                            <td>
                                <div v-if="item.product">
                                Product Name: {{item.product.name}}
                                </div>
                                <div v-if="item.customer">
                                Customer Name: {{item.customer.name}}
                                <br>
                                Customer Phone: {{item.customer.phone}}
                                </div>
                                <div v-if="item.supplier">
                                Supplier Name: {{item.supplier.name}}
                                <br>
                                Supplier Phone: {{item.supplier.phone}}
                                </div>
                                <div v-if="item.user">
                                User Name: {{item.user.name}}
                                <br>
                                User Phone: {{item.user.phone}}
                                </div>
                                <div v-if="item.order">
                                Order Id: {{item.order.order_no}}
                                </div>
                            </td>
                            <td>{{item.credit}}</td>
                            <td>{{item.debit}}</td>
                            <td><span class="badge badge-danger">{{item.status}}</span></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <pagination :data="items" @pagination-change-page="getResults" />
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
        axios.get('/api/transaction').then(response=>{
            console.log(response.data);
            this.items=response.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        getResults(page = 1) {
            axios.get('/api/getproduct?page=' + page)
                .then(response => {
                    this.items = response.data;
                });
        },
        creates(){
            axios.get('/api/getproduct').then(response=>{
                console.log(response.data);
                this.items=response.data;
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
<style scoped>
.Debit{
    background-color:#fb03031f;
}
.Credit{
    background-color:blue;
}
.badge-warning {
    color: #212529;
    background-color: #ffc107;
}
.badge-danger {
    color: #fff;
    background-color: #dc3545;
}
.badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}
</style>