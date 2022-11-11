<template>
    <div class="breadcrumb flex items-end border-b border-gray-300 pb-4 mb-6">
    <p class="text-xl mr-1 font-semibold mr-2">Transaction Request List</p>
    <ul>
        <li class="border-r border-gray-400 inline pr-2 dark:text-gray-400">Transaction</li>
        <li class="inline pl-2 dark:text-gray-400">Transaction Request List</li>
    </ul>
</div>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 d-flex flex-wrap justify-content-between align-items-center">
                        <div class="form-group">
                            <label for="">From</label>
                            <input type="date" class="form-control" v-model="from" />
                        </div>
                        <div class="form-group">
                            <label for="">To</label>
                            <input type="date" class="form-control" v-model="to" />
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <button type="button" class="btn btn-info bg-info" @click="filter()">Filter</button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
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
                            <th>Approve/Reject</th>
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
                            <td>
                                <span v-if="item.status == 'Pending'" class="badge badge-danger">{{item.status}}</span>
                                <span v-else class="badge badge-warning">{{item.status}}</span>
                            </td>
                            <td>
                                <a class="btn btn-primary m-1" @click="accepttransaction(item.id)">Accept</a>
                                <a class="btn btn-danger m-1" @click="deletetransaction(item.id)"> Delete</a>

                            </td>
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
            id:null,
            from:null,
            to:null,
        }
    },
    created(){
        axios.get('/api/pendingtransaction').then(response=>{
            console.log(response.data);
            this.items=response.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        getResults(page = 1) {
            axios.get('/api/pendingtransaction?page=' + page)
                .then(response => {
                    this.items = response.data;
                });
        },
        creates(){
            axios.get('/api/pendingtransaction').then(response=>{
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
        },
        accepttransaction(id){
            const data={'id':id}
            axios.post('/api/transaction/approve',data).then(response=>{
                console.log(response);
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        },
        deletetransaction(id){
            const data={'id':id}
            axios.post('/api/transaction/delete',data).then(response=>{
                console.log(response);
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        },
        filter(){
            const data={'from':this.from,'to':this.to};
            console.log(data);
            axios.post('/api/pendingtransactionfilter',data).then(response=>{
                this.items = response.data;
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
    background-color:#18fd0d87;
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