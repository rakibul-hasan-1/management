import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App.vue'
import router from './router'
import store from './store'
import './assets/scss/global.scss'
import './index.css'
import BaseCard from './components/Base/BaseCard.vue'
import BaseBtn from './components/Base/BaseBtn.vue'

// perfectscrollbar plugins 
import PerfectScrollbar from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css'
import VueApexCharts from "vue3-apexcharts";
import pagination from 'laravel-vue-pagination';


// globally call 

// app.component('BaseBtn', BaseBtn)
const token = localStorage.getItem('token');
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
}

createApp(App)
    .component('BaseCard', BaseCard)
    .component('BaseBtn', BaseBtn)
    .use(PerfectScrollbar)
    .use(VueApexCharts)
    .use(VueAxios, axios)
    .use(store)
    .component('pagination', pagination)
    .use(router)
    .mount('#app')
