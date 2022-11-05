<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4 ">
        <div class="card">
            <div class="card-header">
                Add Variant
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="name" readonly/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group py-2">
                            <label for="">Supplier</label>
                            <select class="form-select my-2" v-model="supplier_id" disabled>
                                <option value="none">Select</option>
                                <option v-for="(item,index) in supplier" :value="item.id" :key="index">{{item.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group py-2">
                            <label for="">Godown</label>
                            <select class="form-select my-2" v-on:change="changegodown" v-model="godown_id" disabled>
                                <option value="none">Select</option>
                                <option v-for="(item,index) in godown" :value="item.id" :key="index">{{item.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Cost</label>
                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="cost" readonly/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group py-2">
                            <label for="">Rack</label>
                            <select class="form-select my-2" v-model="rack_id" disabled>
                                <option value="none">Select</option>
                                <option v-for="(item,index) in rack" :value="item.id" :key="index">{{item.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="quantity" readonly/>
                        </div>
                    </div>                    
                </div>
                <div class="row mt-3">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <h5>Variant List</h5>
                                <div style="height:30px"></div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Color Code</th>
                                            <th>Rack</th>
                                            <th>Volume (KG)</th>
                                            <th>Cartoon</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in items" :key="index">
                                            <td>
                                                <input type="text" class="form-control" v-model="item.name"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.color_code"/>
                                            </td>
                                            <td>
                                                <select class="form-select" v-model="item.rack_id">
                                                    <option value="none">Select</option>
                                                    <option v-for="(itemss,indexs) in rack" :value="itemss.id" :key="indexs">{{itemss.name}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.volume"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.cartoon"/>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.unit_price" v-on:keyup="changeunit(index)" />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" v-model="item.price" readonly/>
                                            </td>
                                            <td>
                                                <a class="btn btn-info my-1 text-white" @click="deleterow(index)">X</a>
                                                &nbsp;
                                                <a class="btn btn-danger my-1" @click="addrow()" v-if="items.length==index+1">+</a>&nbsp;
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row my-4">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary text-primary hover:!text-white" @click="submit()">Submit</button>
                    </div>
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
            items:[
                {
                    'name':null,
                    'color_code':null,
                    'rack_id':'none',
                    'volume':null,
                    'cartoon':null,
                    'price':0,
                }
            ],
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
        axios.post('/api/getvariant',data).then(response=>{
            console.log("Variant",response.data.data);
            if(response.data.data.length >0){
                this.items=response.data.data
                console.log('item',this.items);
            }
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
        addrow(){
            this.items.push({
                    'name':null,
                    'color_code':null,
                    'rack_id':'none',
                    'volume':null,
                    'cartoon':null,
                    'price':0,
                })
        },
        deleterow(index){
                this.items.splice(index,1)
        },
        submit(){
            const data={'id':this.id,'items':this.items};
            axios.post('/api/savevariant',data).then(response=>{
                router.push({ path: '/admin/product' })
            }).catch(error=>{
                console.log(error)
            });
        },
        changeunit(index){
            console.log(this.items[index].unit_price);
            if(this.items[index].volume){
                const volume=this.items[index].volume;
                const unit_price=this.items[index].unit_price;
                const total=volume*unit_price;
                console.log("volume",total);
                this.items[index].price=total;
            }else if(this.items[index].cartoon){
                const cartoon=this.items[index].cartoon;
                const unit_price=this.items[index].unit_price;
                const total=cartoon*unit_price;
                this.items[index].price=total;
            }else{
                this.items[index].unit_price=0;
                this.items[index].price=0;
            }
            
        }
    }
}
</script>