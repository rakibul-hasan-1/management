<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4 ">
        <div class="card">
            <div class="card-header">
                Order Details
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
                                            <input type="tel" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="searchcustomer" v-model="customer.phone" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Name</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="customer.name" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Email</label>
                                            <input type="email" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="customer.email" readonly />
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Customer Address</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="customer.address" readonly />
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
                                <h5 class="card-title">Product List</h5>
                                <div style="height:20px"></div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Color Code</th>
                                                    <th>Godown</th>
                                                    <th>Rack</th>
                                                    <th>Volume (KG)</th>
                                                    <th>Cartoon/Pieces</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in items" :key="index">
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.variant.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.variant.color_code" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.variant.rack.godown.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.variant.rack.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.volume" v-on:keyup="changevolume(index)" :max="item.volume" min="1" readonly/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.cartoon" v-on:keyup="changecartoon(index)" :max="item.cartoon" min="1" readonly/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.variant.unit_price" min="1" readonly/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.total" readonly/>
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
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="changediscount" v-model="discount" readonly />
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
            id:null,
        }
    },
    created(){
        const route = useRoute()
        const id = route.params.id
        const data={'id':id}
        axios.post('/api/getorder',data).then(response=>{
            console.log(response);
            this.subtotal=response.data.data.subtotal
            this.discount=response.data.data.discount
            this.total=response.data.data.total
            this.id=id
            this.customer=response.data.data.customer
        }).catch(error=>{
            console.log(error)
        });
        axios.post('/api/getvariantbyorder',data).then(response=>{
            console.log(response);
            this.items=response.data.data
        }).catch(error=>{
            console.log(error)
        });
        
    },
    methods:{
        searchproduct(){
            const data={'color_code':this.color_code};
            console.log(data);
            axios.post('/api/getvariantbycode',data).then(response=>{
                console.log(response.data.data);
                if(response.data.data.length >=1 ){
                    response.data.data.forEach(item => {
                        this.items.push(item)
                    })
                    // this.items.push(response.data.data)
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
                toastr.success('you are logged in');
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
        },
        submit(){
            const data={"customer":this.customer,'variant':this.items,'subtotal':this.subtotal,'discount':this.discount,'total':this.total}
            axios.post('/api/placeorder',data).then(response=>{
                console.log("placeorder",response.data);
                if(response.data){
                    router.push({ path: '/admin/order' });
                }
            }).catch(error=>{
                console.log(error)
            });
            console.log("order",data);
        },
        changevolume(index){
            const unit=this.items[index].volume;
            const unit_price=this.items[index].unit_price;
            const data={'id':this.items[index].id};
            axios.post('/api/getunitss',data).then(response=>{
                console.log("res",response.data.volume);
                if(response.data && response.data.volume >= unit){
                    this.items[index].price=unit*unit_price;
                }else{
                    this.items[index].volume=response.data.volume;
                }
                this.calculatetotal();
            }).catch(error=>{
                console.log(error)
            });

        },
        calculatetotal(){
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
        changecartoon(index){
            const unit=this.items[index].cartoon;
            const unit_price=this.items[index].unit_price;
            const data={'id':this.items[index].id};
            axios.post('/api/getunitss',data).then(response=>{
                console.log("res",response.data.cartoon);
                if(response.data && response.data.cartoon >= unit){
                    this.items[index].price=unit*unit_price;
                }else{
                    this.items[index].cartoon=response.data.cartoon;
                }
                this.calculatetotal();
            }).catch(error=>{
                console.log(error)
            });
        }
    }
}
</script>