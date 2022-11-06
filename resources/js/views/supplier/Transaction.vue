<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Supplier Transaction List
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
                            <td>{{item}}</td>
                            <td>
                                {{item.total}}
                            </td>
                            <td>{{item.paid}}</td>
                            <td>{{item.due}}</td>
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
import { useRoute } from 'vue-router'
import router from '../../router'
export default{
    data(){
        return{
            items:[],
            id:null
        }
    },
    created(){
        const route = useRoute()
        const id = route.params.id
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