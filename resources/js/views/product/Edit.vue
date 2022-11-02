<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grif-cols-2 xl:grid-cols-2 gap-4 ">
        <div class="card">
            <div class="card-header">
                Edit Product
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="name" />
                </div>
                <div class="form-group">
                    <label for="">Quantity</label>
                    <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="quantity" />
                </div>
                <div class="form-group py-2">
                    <label for="">Supplier</label>
                    <select class="form-select" v-model="supplier_id">
                        <option value="none">Select</option>
                        <option v-for="(item,index) in supplier" :value="item.id" :key="index">{{item.name}}</option>
                    </select>
                </div>
                <div class="form-group py-2">
                    <label for="">Godown</label>
                    <select class="form-select" v-on:change="changegodown" v-model="godown_id">
                        <option value="none">Select</option>
                        <option v-for="(item,index) in godown" :value="item.id" :key="index">{{item.name}}</option>
                    </select>
                </div>
                <div class="form-group py-2">
                    <label for="">Rack</label>
                    <select class="form-select" v-model="rack_id">
                        <option value="none">Select</option>
                        <option v-for="(item,index) in rack" :value="item.id" :key="index">{{item.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Cost</label>
                    <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="cost" />
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="update()">Submit</button>
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
            quantity :0,
            supplier_id:'none',
            godown_id:'none',
            rack_id:'none',
            cost:0,
            supplier:[],
            godown:[],
            rack:[],
            id:null,

        }
    },
    created(){
        const route = useRoute()
        const id = route.params.id
        const data={'id':id}
        axios.post('/api/product/edits',data).then(response=>{
            console.log(response);
            this.name=response.data.name
            this.quantity=response.data.quantity
            this.supplier_id=response.data.supplier_id
            this.godown_id=response.data.godown_id
            this.rack_id=response.data.rack_id
            this.cost=response.data.cost
            this.id=id;
            const data1={'id':this.godown_id};
            console.log(data1);
            axios.post('/api/getracks',data1).then(response=>{
                console.log("racks",response.data.data);
                this.rack=response.data.data;
            }).catch(error=>{
                console.log(error)
            });
        }).catch(error=>{
            console.log(error)
        });
        axios.get('/api/getsupplier').then(response=>{
            console.log(response.data.data);
            this.supplier=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
        axios.get('/api/getgodown').then(response=>{
            console.log(response.data.data);
            this.godown=response.data.data;
        }).catch(error=>{
            console.log(error)
        });
        
    },
    methods:{
        changegodown(){
            const data={'id':this.godown_id}
            console.log(data)
            axios.post('/api/getracks',data).then(response=>{
                console.log(response.data.data);
                this.rack=response.data.data;
            }).catch(error=>{
                console.log(error)
            });
        },
        submit(){
            const data={'name':this.name,'quantity':this.quantity,'supplier_id':this.supplier_id,'godown_id':this.godown_id,'rack_id':this.rack_id,'cost':this.cost};
            axios.post('/api/getproduct',data).then(response=>{
                console.log(response.data.data);
                router.push({ path: '/admin/product' })
            }).catch(error=>{
                console.log(error)
            });
        },
        update(){
            this.create=true            
            const data={'id':this.id,'name':this.name,'quantity':this.quantity,'supplier_id':this.supplier_id,'godown_id':this.godown_id,'rack_id':this.rack_id,'cost':this.cost};
            axios.post('/api/product/update',data).then(response=>{
                console.log(response);
                router.push({ path: '/admin/product' })
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>