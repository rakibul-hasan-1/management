import { createRouter, createWebHistory } from 'vue-router'
import NotFound from '../views/NotFound.vue'
import store from '../store'
import SignIn from '../views/sessions/SignIn.vue'
import SignUp from '../views/sessions/SignUp.vue'
import axios from 'axios'
const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../layout/index.vue'),
        // component: () => import('../views/dashboards/Dashboards.v1.vue'),
        redirect: '/dashboards',
        meta: {
            title: 'Home',
        },

        children: [
            {
                path: '/dashboards',
                name: 'Dashboards',
                // component: () => import('../views/dashboards/index.vue'),
                component: () => import('../views/dashboards/Dashboards.v1.vue'),
                meta: {
                    title: 'Dashboard',
                },
                // children: [
                //     {
                //         path: 'dashboard-version-one',
                //         name: 'dashboard-version-one',
                //         component: () =>
                //             import('../views/dashboards/Dashboards.v1.vue'),
                //     },
                // ],
            },
            {
                path: '/components',
                name: 'components',
                component: () => import('../views/components/index.vue'),
                meta: {
                    title: 'Components',
                },
                children: [
                    {
                        path: 'button',
                        name: 'button',
                        component: () =>
                            import('../views/components/Button.vue'),
                    },
                ],
            },
            
            {
                path: '/admin',
                name: 'components',
                component: () => import('../views/components/index.vue'),
                meta: {
                    title: 'Admin',
                },
                children: [
                    {
                        path: 'godown',
                        name: 'godown',
                        component: () =>
                            import('../views/godown/Index.vue'),
                    },
                    {
                        path: 'rack',
                        name: 'rack',
                        component: () =>
                            import('../views/rack/Index.vue'),
                    },
                    {
                        path: 'supplier',
                        name: 'supplier',
                        component: () =>
                            import('../views/supplier/Index.vue'),
                    },
                    {
                        path: 'supplier/create',
                        name: 'suppliercreate',
                        component: () =>
                            import('../views/supplier/Create.vue'),
                    },
                    {
                        path: 'supplier/edit/:id',
                        name: 'supplieredit',
                        component: () =>
                            import('../views/supplier/Edit.vue'),
                    },
                    {
                        path: 'supplier/transaction/:id',
                        name: 'suppliertransaction',
                        component: () =>
                            import('../views/supplier/Transaction.vue'),
                    },
                    {
                        path: 'customer',
                        name: 'customer',
                        component: () =>
                            import('../views/customer/Index.vue'),
                    },
                    {
                        path: 'customer/create',
                        name: 'customercreate',
                        component: () =>
                            import('../views/customer/Create.vue'),
                    },
                    {
                        path: 'customer/edit/:id',
                        name: 'customeredit',
                        component: () =>
                            import('../views/customer/Edit.vue'),
                    },
                    {
                        path: 'customer/transaction/:id',
                        name: 'customertransactionlist',
                        component: () =>
                            import('../views/customer/TransactionList.vue'),
                    },
                    {
                        path: 'customertransaction',
                        name: 'customertransaction',
                        component: () =>
                            import('../views/customer/Transaction.vue'),
                    },
                    {
                        path: 'product',
                        name: 'product',
                        component: () =>
                            import('../views/product/Index.vue'),
                    },
                    {
                        path: 'product/create',
                        name: 'productcreate',
                        component: () =>
                            import('../views/product/Create.vue'),
                    },
                    {
                        path: 'product/edit/:id',
                        name: 'productedit',
                        component: () =>
                            import('../views/product/Edit.vue'),
                    },
                    {
                        path: 'product/addvariant/:id',
                        name: 'addvariant',
                        component: () =>
                            import('../views/product/Addvariant.vue'),
                    },
                    {
                        path: 'order',
                        name: 'order',
                        component: () =>
                            import('../views/order/Index.vue'),
                    },
                    {
                        path: 'order/create',
                        name: 'ordercreate',
                        component: () =>
                            import('../views/order/Create.vue'),
                    },
                    {
                        path: 'order/view/:id',
                        name: 'orderview',
                        component: () =>
                            import('../views/order/View.vue'),
                    },
                    {
                        path: 'product/pending',
                        name: 'pendingproduct',
                        component: () =>
                            import('../views/product/Pending.vue'),
                    },
                    {
                        path: 'suppliertransaction/pending',
                        name: 'pendingsuppliertransaction',
                        component: () =>
                            import('../views/supplier/Pending.vue'),
                    },
                    {
                        path: 'transaction/pending',
                        name: 'pendingtransaction',
                        component: () =>
                            import('../views/transaction/Pending.vue'),
                    },
                    {
                        path: 'transaction',
                        name: 'transaction',
                        component: () =>
                            import('../views/transaction/Index.vue'),
                    },
                    {
                        path: 'transaction/create',
                        name: 'transactioncreate',
                        component: () =>
                            import('../views/transaction/Create.vue'),
                    },
                    {
                        path: 'user',
                        name: 'userlist',
                        component: () =>
                            import('../views/user/Index.vue'),

                    },
                    {
                        path: 'user/create',
                        name: 'usercreate',
                        component: () =>
                            import('../views/user/Create.vue'),

                    },
                    {
                        path: 'user/edit/:id',
                        name: 'useredit',
                        component: () =>
                            import('../views/user/Edit.vue'),
                    },
                    {
                        path: 'order/invoice/:id',
                        name: 'orderinvoiceview',
                        component: () => import('../views/order/Invoice.vue'),
                    },
                ],
            },
            
            {
                path: '/profile',
                name: 'profile',
                component: () => import('../views/profile/index.vue'),
                meta: {
                    title: 'Profile',
                },
                children: [
                    {
                        path: 'profileTwo',
                        name: 'ProfileTwo',
                        component: () =>
                            import('../views/profile/ProfileTwo.vue'),
                    },
                ],
            },
        ],
    },
    

    { path: '/signIn', component: SignIn },
    { path: '/signUp', component: SignUp },

    { path: '/:path(.*)', component: NotFound },
]

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { left: 0, top: 0 }
    },
    routes,
})
router.beforeEach((to, from, next) => {
    if (to.fullPath !== "/signIn") {
        if(to.fullPath==="/signUp"){
            next();
        }else{
            const token=localStorage.getItem('token');
            if(token){
                next();
            }else{
                router.push('/signIn');
            }
        }
        // axios.get('/api/profile').then(response => {
        //     console.log("next1")
        //     next();
        // }).catch(error => {
        //     console.log("next2")
        //     router.push('/signIn');
        // })
    } else {
        console.log("next3")
        next();
    }
})
router.afterEach(() => {
    if (window.innerWidth <= 1200) {
        const sidenav =
            store.state.largeSidebar.sidebarToggleProperties.isSideNavOpen

        store.commit('largeSidebar/toggleSidebarProperties')
    }
})

export default router
