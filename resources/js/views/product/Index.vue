<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Product List
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
                            <th>Name</th>
                            <th>Supplier</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Godown</th>
                            <th>Rack</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.supplier.name}}</td>
                            <td>{{item.quantity}}</td>
                            <td>{{item.cost}}</td>
                            <td>{{item.godown.name}}</td>
                            <td>{{item.rack.name}}</td>
                            <td>
                                <router-link :to="{ name: 'productedit', params: { id: item.id }}" class="btn btn-primary mx-2">Edit</router-link>
                                <router-link :to="{ name: 'addvariant', params: { id: item.id }}" class="btn btn-primary mx-2">Add Variant</router-link>
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
        axios.get('/api/getproduct').then(response=>{
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