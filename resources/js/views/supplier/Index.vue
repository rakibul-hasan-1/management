<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Supplier List
                    </div>
                    <div class="col-md-6 text-end">
                        <router-link to="/admin/supplier/create" class="btn btn-primary">
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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Adress</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Transaction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.phone}}</td>
                            <td>{{item.email}}</td>
                            <td>{{item.address}}</td>
                            <td>{{item.status}}</td>
                            <td>
                                <router-link :to="{ name: 'supplieredit', params: { id: item.id }}" class="btn btn-primary mx-2">Edit</router-link>
                                <a @click="deletes(item.id)" class="btn btn-danger">Delete</a>
                            </td>
                            <td>
                                <router-link :to="{ name: 'suppliertransaction', params: { id: item.id }}" class="btn btn-primary mx-2">Transaction</router-link>
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
            name:null,
            phone:null,
            email:null,
            address:null,
            status:'none',
            create:true,
            id:null
        }
    },
    created(){
        axios.get('/api/getsupplier').then(response=>{
            console.log(response.data.data);
            this.items=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        creates(){
            axios.get('/api/getsupplier').then(response=>{
                console.log(response.data.data);
                this.items=response.data.data;
            }).catch(error=>{
                console.log(error)
            });
        },
        submit(){
            const data={'name':this.name,'status':this.status,'phone':this.phone,'email':this.email,'address':this.address};
            axios.post('/api/getsupplier',data).then(response=>{
                console.log(response.data.data);
                this.items.push(response.data.data);
                console.log(this.items);
                this.name=null
                this.phone=null
                this.email=null
                this.address=null
                this.status='none'
            }).catch(error=>{
                console.log(error)
            });
        },
        deletes(id){
            const data={'id':id}
            axios.post('/api/supplier/delete',data).then(response=>{
                console.log(response);
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>