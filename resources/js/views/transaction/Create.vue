<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grif-cols-2 xl:grid-cols-2 gap-4 ">
        <div class="card">
            <div class="card-header">
                Create New Transaction
            </div>
            <div class="card-body">
                <div v-if="error" class="alert alert-danger">{{error}}</div>
                <div class="form-group">
                    <label for="">For</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="forss" />
                </div>
                <div class="form-group pb-4">
                    <label for="">Type</label>
                    <select class="form-select" v-model="type">
                        <option value="Debit">Debit</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="amount" />
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
            forss:null,
            type:'Debit',
            amount:0,
            password:null,
            create:true,
            id:null,
            error:null,
        }
    },
    created(){
    },
    methods:{
        submit(){
            const data={'for':this.forss,'type':this.type,'amount':this.amount};
            axios.post('/api/createtransaction',data).then(response=>{
                console.log(response.data);
                if(response.data.error){
                    this.error=response.data.error;
                }else{
                    router.push({ path: '/admin/transaction' })
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