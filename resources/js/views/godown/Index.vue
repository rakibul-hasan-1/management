<script>
import axios from 'axios'
export default{
    data(){
        return{
            items:[],
            name:null,
            location:null,
            create:true,
            id:null
        }
    },
    created(){
        axios.get('/api/getgodown').then(response=>{
            console.log(response.data.data);
            this.items=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        creates(){
            axios.get('/api/getgodown').then(response=>{
                console.log(response.data.data);
                this.items=response.data.data;
            }).catch(error=>{
                console.log(error)
            });
        },
        submit(){
            const data={'name':this.name,'location':this.location};
            axios.post('/api/getgodown',data).then(response=>{
                console.log(response.data.data);
                this.items.push(response.data.data);
                console.log(this.items);
                this.name=null
                this.location=null
            }).catch(error=>{
                console.log(error)
            });
        },
        edit(id){
            this.create=false
            this.id=id
            const data={'id':this.id}
            axios.post('/api/godown/edits',data).then(response=>{
                console.log(response);
                this.name=response.data.name
                this.location=response.data.location
            }).catch(error=>{
                console.log(error)
            });
        },
        update(){
            this.create=true            
            const data={'id':this.id,'name':this.name,'location':this.location}
            axios.post('/api/godown/update',data).then(response=>{
                console.log(response);
                this.name=null
                this.location=null
                this.id=null
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        },
        deletes(id){
            const data={'id':id}
            axios.post('/api/godown/delete',data).then(response=>{
                console.log(response);
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>
<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grif-cols-2 xl:grid-cols-2 gap-4">
        <div class="card" v-if="create">
            <div class="card-header">
                Create New
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" placeholder="Write Comment" v-model="name" />
                </div>
                <div class="form-group">
                    <label for="">Location</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" placeholder="Write Comment" v-model="location" />
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="submit()">Submit</button>
                </div>
            </div>
        </div>
        <div class="card" v-else>
            <div class="card-header">
                Edit Godown
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" placeholder="Write Comment" v-model="name" />
                </div>
                <div class="form-group">
                    <label for="">Location</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" placeholder="Write Comment" v-model="location" />
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="update()">Update</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Godown List
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.location}}</td>
                            <td>
                                <a @click="edit(item.id)" class="btn btn-primary mx-2">Edit</a>
                                <a @click="deletes(item.id)" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>