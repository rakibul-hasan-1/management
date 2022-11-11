<template>
<div class="modal" id="modal" tabindex="-1">
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
        <button type="button" class="btn btn-primary bg-primary" @click="savemodal()">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="breadcrumb flex items-end border-b border-gray-300 pb-4 mb-6">
    <p class="text-xl mr-1 font-semibold mr-2">Supplier Transaction Request List</p>
    <ul>
        <li class="border-r border-gray-400 inline pr-2 dark:text-gray-400">Supplier</li>
        <li class="inline pl-2 dark:text-gray-400">Supplier Transaction Request List</li>
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
                            <th>For</th>
                            <th>Prevoius Total</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Approve/Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items.data" :key="index" :class="item.type">
                            <td>{{index+1}}</td>
                            <td>{{item.date}}</td>
                            <td>
                                <span v-if="item.transaction.product">
                                Product Name: {{item.transaction.product.name ?? ""}}
                                </span>
                            </td>
                            <td>{{item.ptotal}}</td>
                            <td>
                                {{item.total}}
                            </td>
                            <td>{{item.paid}}</td>
                            <td>{{item.due}}</td>
                            <td>
                                <span v-if="item.status == 'Pending'" class="badge badge-danger">{{item.status}}</span>
                                <span v-else class="badge badge-warning">{{item.status}}</span>
                            </td>
                            <td>
                                <a class="btn btn-primary m-1" @click="acceptsuppliertransaction(item.id,item.paid)">Accept</a>
                                <a class="btn btn-danger m-1" @click="deletesuppliertransaction(item.id)"> Delete</a>
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
            paid:0,
            from:null,
            to:null,
        }
    },
    created(){
        axios.get('/api/suppliertransactionrequest').then(response=>{
            console.log(response.data);
            this.items=response.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        getResults(page = 1) {
            axios.get('/api/suppliertransactionrequest?page=' + page)
                .then(response => {
                    this.items = response.data;
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
        acceptsuppliertransaction(id,paid){
            this.id=id;
            this.paid=paid
            document.getElementById('modal').setAttribute('style','display:block !important');
            
        },
        savemodal(){
            const data={'paid':this.paid,'id':this.id}
            console.log(data);
            axios.post('/api/suppliertransaction/approve',data).then(response=>{
                console.log(response);
                document.getElementById('modal').setAttribute('style','display:none !important');
                this.getResults();
            }).catch(error=>{
                console.log(error)
            });
        },
        deletesuppliertransaction(id){
            const data={'id':id}
            console.log(data)
            axios.post('/api/suppliertransaction/delete',data).then(response=>{
                this.getResults();
            }).catch(error=>{
                console.log(error)
            });
        },
        hidemodal(){
            document.getElementById('modal').setAttribute('style','display:none !important');
        },
        filter(){
            const data={'id':this.id,'from':this.from,'to':this.to};
            console.log(data);
            axios.post('/api/supplierpendingtransactionfilter',data).then(response=>{
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