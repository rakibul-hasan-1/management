<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4 ">
        <div class="card">
            <div class="card-header">
                Add New Order
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Customer Information
                                </h4>
                                <div style="height:20px"></div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Phone</label>
                                            <input type="tel" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="searchcustomer" v-model="customer.phone"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Name</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="customer.name" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Email</label>
                                            <input type="email" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="customer.email" />
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Address</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="customer.address" />
                                        </div>
                                    </div>                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add Product</h5>
                                <div style="height:20px"></div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Search Product By Color Code</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="searchproduct" v-model="color_code" />
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-8">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Color Code</th>
                                                    <th>Volume (KG)</th>
                                                    <th>Cartoon</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in items" :key="index">
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.color_code" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.volume" :max="item.volume" min="1"/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.cartoon" :max="item.cartoon" min="1" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.price" readonly/>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info my-1 text-white" @click="deleterow(index)">X</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Order Amount
                                </h4>
                                <div style="height:20px"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Subtotal</label>
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="subtotal" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Discount</label>
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="changediscount" v-model="discount"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Total</label>
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="total" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary text-primary hover:!text-white m-2" @click="submit()">Place Order</button>
                        <button type="button" class="btn btn-primary text-primary hover:!text-white m-2" @click="submit()">Place Order with Invoice Print</button>
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
            customer:{
                'phone':null,
                'name':null,
                'email':null,
                'address':null
            },
            color_code:null,
            items:[],
            subtotal:0,
            discount:0,
            total:0,
        }
    },
    created(){

    },
    methods:{
        searchproduct(){
            const data={'color_code':this.color_code};
            console.log(data);
            axios.post('/api/getvariantbycode',data).then(response=>{
                console.log(response.data.data);
                if(response.data.data){
                    this.items.push(response.data.data)
                    const subtotal=this.items.reduce((acc, item) => acc + item.price, 0);
                    this.subtotal=subtotal
                    if(this.discount > this.subtotal){
                        this.discount=0;
                        this.total=subtotal;
                    }else{
                        const total=this.subtotal-this.discount;
                        this.total=total;
                    }
                }
            }).catch(error=>{
                console.log(error)
            });
        },
        deleterow(index){
                this.items.splice(index,1)
                const subtotal=this.items.reduce((acc, item) => acc + item.price, 0);
                this.subtotal=subtotal
                if(this.discount > this.subtotal){
                    this.discount=0;
                    this.total=subtotal;
                }else{
                    const total=this.subtotal-this.discount;
                    this.total=total;
                }
        },
        changediscount(){
            if(this.discount > this.subtotal){
                this.discount=0;
                this.total=this.subtotal
            }else{
                const total=this.subtotal-this.discount;
                this.total=total;
            }
        },
        searchcustomer(){
            const data={'phone':this.customer.phone};
            axios.post('/api/searchcustomer',data).then(response=>{
                console.log(response.data.data);
                if(response.data.data){
                    this.customer=response.data.data
                }else{
                    this.customer={
                        'phone':this.customer.phone,
                        'name':null,
                        'email':null,
                        'address':null
                    }
                }
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>