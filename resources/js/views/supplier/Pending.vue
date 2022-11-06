<template>
<div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Paid Amount</h5>
        <button type="button" class="btn-danger" data-bs-dismiss="modal" aria-label="Close" @click="hidemodal()">X</button>
      </div>
      <div class="modal-body">
        <input type="number" v-modal="paid" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary bg-danger" @click="hidemodal()">Close</button>
        <button type="button" class="btn btn-primary bg-primary" @click="savemodal()">Save</button>
      </div>
    </div>
  </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Supplier Transaction Request List
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
                            <th>For</th>
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
                                <span v-if="item.transaction.product.name">
                                Product Name: {{item.transaction.product.name ?? ""}}
                                </span>
</td>
                            <td>
                                {{item.total}}
                            </td>
                            <td>{{item.paid}}</td>
                            <td>{{item.due}}</td>
                            <td><span class="badge badge-danger">{{item.status}}</span></td>
                            <td>
                                <a class="btn btn-primary m-1" @click="acceptsuppliertransaction(item.id)">Accept</a>
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
        },
        acceptsuppliertransaction(id){
            this.id=id;
            const data={'id':id}
            console.log(data)
            document.getElementById('modal').setAttribute('style','display:block !important');
            // axios.post('/api/transaction/approve',data).then(response=>{
            //     console.log(response);
            //     this.creates();
            // }).catch(error=>{
            //     console.log(error)
            // });
        },
        savemodal(){
            const data={'paid':this.paid,'id':this.id}
            console.log(data);
        },
        deletesuppliertransaction(id){
            const data={'id':id}
            console.log(data)
            // axios.post('/api/transaction/delete',data).then(response=>{
            //     console.log(response);
            //     this.creates();
            // }).catch(error=>{
            //     console.log(error)
            // });
        },
        hidemodal(){
            document.getElementById('modal').setAttribute('style','display:none !important');
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