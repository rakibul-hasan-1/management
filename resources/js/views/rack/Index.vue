<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grif-cols-2 xl:grid-cols-2 gap-4">
        <div class="card" v-if="create">
            <div class="card-header">
                Create New
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="name" />
                </div>
                <div class="form-group pb-4">
                    <label for="">Godown</label>
                    <select class="form-select" v-model="godown_id">
                        <option value="none">Select</option>
                        <option v-for="(data,index) in godown" :value="data.id" :key="index">{{data.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="submit()">Submit</button>
                </div>
            </div>
        </div>
        <div class="card" v-else>
            <div class="card-header">
                Edit Rack
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" placeholder="Write Comment" v-model="name" />
                </div>
                <div class="form-group pb-4">
                    <label for="">Godown</label>
                    <select class="form-select" v-model="godown_id">
                        <option value="none">Select</option>
                        <option v-for="(data,index) in godown" :value="data.id" :key="index">{{data.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="update()">Update</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Rack List
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Godown</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.godown.name}}</td>
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
<script>
import axios from 'axios'
export default{
    data(){
        return{
            items:[],
            name:null,
            godown_id:'none',
            create:true,
            id:null,
            godown:[]
        }
    },
    created(){
        axios.get('/api/getrack').then(response=>{
            console.log(response.data.data);
            this.items=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
        axios.get('/api/getgodown').then(response=>{
            this.godown=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        creates(){
            axios.get('/api/getrack').then(response=>{
                console.log(response.data.data);
                this.items=response.data.data;
            }).catch(error=>{
                console.log(error)
            });
        },
        submit(){
            const data={'name':this.name,'godown_id':this.godown_id,'location':this.location};
            axios.post('/api/getrack',data).then(response=>{
                console.log(response.data.data);
                this.items.push(response.data.data);
                console.log(this.items);
                this.name=null
                this.godown_id='none'
            }).catch(error=>{
                console.log(error)
            });
        },
        edit(id){
            this.create=false
            this.id=id
            const data={'id':this.id}
            axios.post('/api/rack/edits',data).then(response=>{
                console.log(response);
                this.name=response.data.name
                this.godown_id=response.data.godown_id
            }).catch(error=>{
                console.log(error)
            });
        },
        update(){
            this.create=true            
            const data={'id':this.id,'name':this.name,'godown_id':this.godown_id}
            axios.post('/api/rack/update',data).then(response=>{
                console.log(response);
                this.name=null
                this.godown_id='none'
                this.id=null
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        },
        deletes(id){
            const data={'id':id}
            axios.post('/api/rack/delete',data).then(response=>{
                console.log(response);
                this.creates();
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>