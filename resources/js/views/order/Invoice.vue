<template>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grif-cols-1 xl:grid-cols-1 gap-4 w-100">
        <div class="container">
      <div class="row">
        <div class="col-md-12 text-right mb-3">
        </div>
        <div class="col-md-12">
          <div class="card" id="invoice">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="d-md-flex flex-md-wrap">
                    <div class="mb-4 mb-md-2 text-left">
                      <span class="text-muted">Invoice To:</span>
                      <ul class="list list-unstyled mb-0">
                        <li>
                          <h5 class="my-2">{{customer.name}}</h5>
                        </li>
                        <li>{{customer.phone}}</li>
                        <li>{{customer.email}}</li>
                        <li>{{customer.address}}</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-6 text-end">
                  <div class="mb-4">
                    <div class="text-end" >
                      <h4 class="invoice-color mb-2 mt-md-2">
                        Invoice #{{order.order_no}}
                      </h4>
                      <ul class="list list-unstyled mb-0">
                        <li>
                          Date:
                          <span class="font-weight-semibold"
                            >{{order.date}}</span
                          >
                        </li>
                      </ul>
                  </div>
                  </div>
                </div>               
              </div>             
            </div>
            <div class="table-responsive">
              <table class="table table-lg table-striped">
                <thead class="bg-dark text-light text-center">
                  <tr>
                    <th>Name</th>
                    <th>Color Code</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  <tr v-for="(item,index) in items" :key="index">
                    <td>
                      {{item.variant.name}}
                    </td>
                    <td>{{item.variant.color_code}}</td>
                    <td v-if="item.volume">{{item.volume}} KG</td>
                    <td v-if="item.cartoon">{{item.cartoon}} Pieces</td>
                    <td><span class="font-weight-semibold">{{item.variant.unit_price}}</span></td>
                    <td><span class="font-weight-semibold">{{item.total}}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4">
                  <div class="d-md-flex flex-md-wrap">
                    <div class="pt-2 mb-3 wmin-md-400 ml-auto">
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <tr>
                              <th class="text-left">Subtotal:</th>
                              <td class="text-right">{{subtotal}}</td>
                            </tr>
                            <tr>
                              <th class="text-left">
                                Discount: <span class="font-weight-normal"></span>
                              </th>
                              <td class="text-right">{{discount}}</td>
                            </tr>
                            <tr>
                              <th class="text-left">Total:</th>
                              <td class="text-right text-primary">
                                <h5 class="font-weight-semibold">{{total}}</h5>
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
            <div class="card-footer text-center">
              <span class="text-muted"
                >Thanks for choosing us.</span
              >
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
            order:null,
        }
    },
    created(){
        const route = useRoute()
        const id = route.params.id
        const data={'id':id}
        axios.post('/api/getorder',data).then(response=>{
            console.log(response);
            this.order=response.data.data
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


<style scoped>
.mt-50 {
  margin-top: 50px;
}

.mb-50 {
  margin-bottom: 50px;
}

.card {
  position: relative;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-direction: column;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.1875rem;
}

.card-img-actions {
  position: relative;
}

.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  padding: 1.25rem;
  text-align: center;
}

.card-title {
  margin-top: 10px;
  font-size: 17px;
}

.invoice-color {
  color: red !important;
}

.card-header {
  padding: 0.9375rem 1.25rem;
  margin-bottom: 0;
  background-color: rgba(0, 0, 0, 0.02);
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

a {
  text-decoration: none !important;
}

.btn-light {
  color: #333;
  background-color: #fafafa;
  border-color: #ddd;
}

.header-elements-inline {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
}

@media (min-width: 768px) {
  .wmin-md-400 {
    min-width: 400px !important;
  }
}

.btn-primary {
  color: #fff;
  background-color: #2196f3;
}

.btn-labeled > b {
  position: absolute;
  top: -1px;
  background-color: blue;
  display: block;
  line-height: 1;
  padding: 0.62503rem;
}
</style>