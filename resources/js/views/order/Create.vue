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
                                            <label for="">Search Product By Name</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="searchproduct" v-model="name" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Search Product By Color Code</label>
                                            <input type="text" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:keyup="searchproduct" v-model="color_code" />
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-12">
                                        <h3>Search Result</h3>
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
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in itemss" :key="index">
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.color_code" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.rack.godown.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="item.rack.name" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.volume" v-on:keyup="changevolume(index)" :max="item.volume" min="1"/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.cartoon" v-on:keyup="changecartoon(index)" :max="item.cartoon" min="1" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.unit_price" min="1" readonly/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" v-model="item.price" readonly/>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info my-1 text-white" @click="addrow(item)">+</a>
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
                <div class="row mt-3" id="printable">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Added Product
                                </h4>
                                <div style="height:20px"></div>
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
                                                    <input type="text" class="form-control" v-model="item.rack.godown.name" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="item.rack.name" readonly />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" v-model="item.volume" v-on:keyup="changevolume(index)" :max="item.volume" min="1"/>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" v-model="item.cartoon" v-on:keyup="changecartoon(index)" :max="item.cartoon" min="1" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" v-model="item.unit_price" min="1" readonly/>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Previous Due {{transaction.invoice_id}}</label>
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="transaction.due" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Paid</label>
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-on:change="changepaid" v-model="paid"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Due</label>
                                            <input type="number" class="focus:outline-none w-full border border-gray px-3 py-2 my-3 rounded" v-model="due" readonly/>
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
                        <!-- <button type="button" class="btn btn-primary text-primary hover:!text-white m-2" @click="submit()">Place Order with Invoice Print</button> -->
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
            transaction:{
                'due':0,
                'invoice_id':null,
            },
            color_code:null,
            name:null,
            itemss:[],
            items:[],
            paid:0,
            due:0,
            subtotal:0,
            discount:0,
            total:0,
        }
    },
    created(){

    },
    methods:{
        searchproduct(){
            const data={'color_code':this.color_code,name:this.name};
            console.log(data);
            axios.post('/api/getvariantbycode',data).then(response=>{
                console.log(response.data.data);
                // if(response.data.data.length >=0 ){
                    // response.data.data.forEach(item => {
                    //     this.items.push(item)
                    // })
                    if(this.color_code=='' && this.name=='' || this.color_code == null && this.name=='' || this.color_code=='' && this.name==null){
                        this.itemss=[];
                    }else{
                        this.itemss=this.getDifference(response.data.data,this.items);
                    }               
            }).catch(error=>{
                console.log(error)
            });
        },
        getDifference(array1, array2) {
            return array1.filter(object1 => {
                return !array2.some(object2 => {
                return object1.id === object2.id;
                });
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
                    const total=((this.subtotal-this.discount)+this.transaction.due)-this.paid;
                    this.total=total;
                }
        },
        removeItemOnce(arr, value) {
            var index = arr.indexOf(value);
            if (index > -1) {
                arr.splice(index, 1);
            }
            return arr;
        },
        isCherries(fruit,item) {
            return fruit.name === item.name;
        },
        addrow(item){
            if(this.items.find(i => i.id === item.id)){

            }else{
                this.removeItemOnce(this.itemss, item)
                this.items.push(item);
                console.log(this.items,this.itemss)
                this.calculatetotal();
            }
        },
        calculatetotal(){
            const subtotal=this.items.reduce((acc, item) => acc + item.price, 0);
            this.subtotal=subtotal
            if(this.discount > this.subtotal){
                this.discount=0;
                this.total=subtotal;
            }else{
                const total=this.subtotal-this.discount;
                const due=((this.subtotal-this.discount)+this.transaction.due)-this.paid;
                this.total=total;
                this.due=due;
            }
        },
        changediscount(){
            if(this.discount > this.subtotal){
                this.discount=0;
                this.total=this.subtotal
                toastr.success('you are logged in');
            }else{
                const total=this.subtotal-this.discount;
                const due=((this.subtotal-this.discount)+this.transaction.due)-this.paid;
                this.total=total;
                this.due=due;
            }
        },
        changepaid(){
            const dues=((this.subtotal-this.discount)+this.transaction.due);
            if(this.paid > dues){
                this.paid=0;
            }else{
                const due=((this.subtotal-this.discount)+this.transaction.due)-this.paid;
                this.due=due;
            }
        },
        searchcustomer(){
            const data={'phone':this.customer.phone};
            axios.post('/api/searchcustomer',data).then(response=>{
                console.log(response.data);
                if(response.data.data){
                    this.customer=response.data.data
                    this.transaction=response.data.transaction
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
            const data={"customer":this.customer,'variant':this.items,'subtotal':this.subtotal,'discount':this.discount,'total':this.total,'transaction':this.transaction,'paid':this.paid,'due':this.due}
            axios.post('/api/placeorder',data).then(response=>{
                console.log("placeorder",response.data);
                if(response.data){
                    router.push({ path: '/admin/order/invoice/'+response.data.id });
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
        },
        printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    }
}
</script>