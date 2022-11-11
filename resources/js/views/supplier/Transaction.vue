<template>
<div class="modal" id="modal12" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Paid Amount</h5>
        <button type="button" class="btn-danger" data-bs-dismiss="modal" aria-label="Close" @click="hidemodal()">X</button>
      </div>
      <div class="modal-body">
        <input type="number" v-model="paid" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary bg-danger" @click="hidemodal()">Close</button>
        <button type="button" class="btn btn-primary bg-primary" @click="savemodals()">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="breadcrumb flex items-end border-b border-gray-300 pb-4 mb-6">
    <p class="text-xl mr-1 font-semibold mr-2">Supplier Transaction List</p>
    <ul>
        <li class="border-r border-gray-400 inline pr-2 dark:text-gray-400">Supplier</li>
        <li class="inline pl-2 dark:text-gray-400">Supplier Transaction List</li>
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
                        <button class="btn btn-primary" @click="openmodal()">
                            Create New
                        </button>
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
                            <th>Previous Total</th>
                            <th>New Added</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items.data" :key="index" :class="item.type">
                            <td>{{index+1}}</td>
                            <td>{{item.date}}</td>
                            <td>{{item.type}}</td>
                            <td>
                                <span v-if="item.transaction.product">
                                Product Name: {{item.transaction.product.name ?? ""}}
                                </span>
                            </td>
                            <td>{{item.ptotal}}</td>
                            <td>{{item.total-item.ptotal}}</td>
                            <td>
                                {{item.total}}
                            </td>
                            <td>{{item.paid}}</td>
                            <td>{{item.due}}</td>
                            <td>
                                <span v-if="item.status == 'Pending'" class="badge badge-danger">{{item.status}}</span>
                                <span v-else class="badge badge-warning">{{item.status}}</span>
                                
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
import { useRoute } from 'vue-router'
import router from '../../router'
export default{
    data(){
        return{
            items:[],
            id:null,
            paid:0,
            from:null,
            to:null,
        }
    },
    created(){
        const route = useRoute()
        const id = route.params.id
        this.id=id
        const data={"id":id};
        axios.post('/api/suppliertransaction',data).then(response=>{
            console.log(response.data);
            this.items=response.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        getResults(page = 1) {
            const data={"id":this.id};
            axios.post('/api/suppliertransaction?page=' + page,data)
                .then(response => {
                    this.items = response.data;
                });
        },
        openmodal(){
            document.getElementById('modal12').setAttribute('style','display:block !important');
        },
        hidemodal(){
            document.getElementById('modal12').setAttribute('style','display:none !important');
        },
        savemodals(){
            const data={'id':this.id,'paid':this.paid};
            console.log(data);
            axios.post('/api/createsuppliertransaction',data).then(response=>{
                console.log(response);
                document.getElementById('modal12').setAttribute('style','display:none !important');
                this.getResults();
            }).catch(error=>{
                console.log(error)
            });
        },
        filter(){
            const data={'id':this.id,'from':this.from,'to':this.to};
            console.log(data);
            axios.post('/api/suppliertransactionfilter',data).then(response=>{
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