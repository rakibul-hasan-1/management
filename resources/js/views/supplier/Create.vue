<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grif-cols-2 xl:grid-cols-2 gap-4 ">
        <div class="card">
            <div class="card-header">
                Create New Supplier
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="name" />
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="tel" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="phone" />
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="email" />
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="address" />
                </div>
                <div class="form-group pb-4">
                    <label for="">Status</label>
                    <select class="form-select" v-model="status">
                        <option value="none">Select</option>
                        <option value="Active">Active</option>
                        <option value="Deactive">Deactive</option>
                    </select>
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
import router from '../../router'
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
                router.push({ path: '/admin/supplier' })
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