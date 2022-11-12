<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grif-cols-2 xl:grid-cols-2 gap-4 ">
        <div class="card">
            <div class="card-header">
                Edit User
            </div>
            <div class="card-body">
                <div v-if="error" class="alert alert-danger">{{error}}</div>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="name" />
                </div>
                <div class="form-group">
                    <label for="">User Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="username" />
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="tel" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="phone" />
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="email" />
                </div>
                <div class="form-group pb-4">
                    <label for="">Type</label>
                    <select class="form-select" v-model="type">
                        <option value="Staff">Staff</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="password" />
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="submit()">Submit</button>
                </div>
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
            name:null,
            username:null,
            phone:null,
            email:null,
            type:'staff',
            password:null,
            create:true,
            id:null,
            error:null,
        }
    },
    created(){
        const route = useRoute()
        const id = route.params.id
        this.id=id;
        const data={"id":id};
        axios.post('/api/getuserbyid',data).then(response=>{
            console.log('result',response);
            this.name=response.data.name;
            this.username=response.data.username;
            this.phone=response.data.phone;
            this.email=response.data.email;
            this.type=response.data.type;
            
        }).catch(error=>{
            console.log(error)
        });
    },
    methods:{
        submit(){
            const data={'id':this.id,'name':this.name,'username':this.username,'phone':this.phone,'email':this.email,'type':this.type,'password':this.password};
            axios.post('/api/updateuser',data).then(response=>{
                console.log(response.data);
                if(response.data.error){
                    this.error=response.data.error;
                }else{
                    router.push({ path: '/admin/user' })
                }
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