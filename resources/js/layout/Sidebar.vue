<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import axios from 'axios';

let store = useStore()
let route = useRoute()

let toggleSubMenu = (e) => {
    // let parent = e.target.dataset.item;
    console.log(e.target)
}

onMounted(() => {
    // axios.get('/api/getuserdetails').then(response=>{
    //     console.log(response.data);
    //     store.state.user=response.data;
    //     localStorage.setItem('type',response.data.type);
    //     // console.log('user',store.state.user.type);
    //     store.state.type=response.data.type;
    // }).catch(error=>{
    //     console.log(error)
    // });
    window.addEventListener('resize', handleWindowResize)
})
// beforeDestroy
onBeforeUnmount(() => {
    window.removeEventListener('resize', handleWindowResize)
})

let handleWindowResize = () => {
    let sidenav = store.state.largeSidebar.sidebarToggleProperties.isSideNavOpen

    if (window.innerWidth <= 1200) {
        if (store.state.largeSidebar.sidebarToggleProperties.isSideNavOpen) {
            store.commit('largeSidebar/toggleSidebarProperties')
        }
    } else {
        if (!store.state.largeSidebar.sidebarToggleProperties.isSideNavOpen) {
            store.commit('largeSidebar/toggleSidebarProperties')
        }
    }
}
var type=localStorage.getItem('type');
// console.log('type',type);
function logout(){
    localStorage.removeItem('token');
    localStorage.removeItem('type');
}
</script>
<template>
    <div class="side-content-wrap">
        <div class="side-content-wrap">
            <div
                :class="
                    store.state.largeSidebar.sidebarToggleProperties
                        .isSideNavOpen === true
                        ? 'open'
                        : ''
                "
                class="sidebar-left"
            >
                <perfect-scrollbar>
                    <ul class="navigation-left">
                        <!-- <div 
                            @mouseenter="toggleSubMenu" 
                            class="nav-item" 
                            :class="selectedParentMenu == 'dashboards' ? 'active' : ''"
                            data-item="dashboards"
                            
                        ></div> -->
                        <router-link
                            to="/dashboards"
                            tag="li"
                            class="nav-item"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Bar-Chart text-3xl"></i>
                                <p>Dashboard</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/godown"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='staff' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Godown</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/rack"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='staff' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Rack</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/supplier"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Supplier</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/customer"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='staff' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Customer</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/product"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='staff' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Product</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/product/pending"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Pending Product</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/order/create"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='staff' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Create Order</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/order"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='Staff' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Order</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/suppliertransaction/pending"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Supplier Transaction Request</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/customertransaction"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Customer Transaction</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/transaction/pending"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Transaction Request</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/transaction"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin' || type=='Manager'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Wallet text-3xl"></i>
                                <p>Transaction</p>
                            </div>
                        </router-link>
                        <router-link
                            to="/admin/user"
                            tag="li"
                            class="nav-item"
                            v-if="type=='Admin'"
                        >
                            <div class="nav-item-hold">
                                <i class="i-Find-User text-3xl"></i>
                                <p>User</p>
                            </div>
                        </router-link>

                        <a
                            href="#"
                            tag="a"
                            class="nav-item"
                            @click="logout()"
                        >
                            <div class="nav-item-hold">
                                <i class="i-File-Word text-3xl"></i>
                                <p>Logout</p>
                            </div>
                        </a>
                    </ul>
                </perfect-scrollbar>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.nav-item.router-link-exact-active {
    @apply text-purple-500;

    &:after {
        content: '';
        position: absolute;
        width: 30px;
        height: 30px;
        bottom: -15px;
        right: -15px;
        transform: rotate(45deg);
        @apply bg-purple-500;
    }
}
.submenuLi {
    &:hover {
        .submenuli-icon {
            color: #8b5cf6;
        }
    }
    .submenuli-icon {
        color: #9ca3af;
    }
}
.submneu-nested-link {
    padding: 0 !important;
    color: #000 !important;
    &:hover {
        background-color: transparent !important;
        color: #8b5cf6 !important;
    }
}
.side-content-wrap {
    .sidebar-left {
        position: fixed;
        top: 80px;
        left: -120px;
        width: 120px;

        background: #fff;
        box-shadow: 0 4px 20px 1px rgba(0, 0, 0, 0.06),
            0 1px 4px rgba(0, 0, 0, 0.08);
        z-index: 90;
        transition: all 0.24s ease-in-out;
        &.open {
            left: 0;
            transition: all 0.24s ease-in-out;
        }
        .ps {
            height: calc(100vh - 80px);
        }
        .navigation-left {
            list-style: none;
            text-align: center;
            width: 120px;
            height: 100%;
            margin: 0;
            padding: 0;
            .nav-item,
            .nav-item-single {
                position: relative;
                display: block;
                width: 100%;
                overflow: hidden;
                cursor: pointer;
                &:hover {
                    .nav-item-hold {
                        @apply text-purple-500;
                    }
                    &:after {
                        content: '';
                        position: absolute;
                        width: 30px;
                        height: 30px;
                        bottom: -15px;
                        right: -15px;
                        transform: rotate(45deg);
                        @apply bg-purple-500;
                    }
                }

                &.active {
                    @apply text-purple-500;

                    &:after {
                        content: '';
                        position: absolute;
                        width: 30px;
                        height: 30px;
                        bottom: -15px;
                        right: -15px;
                        transform: rotate(45deg);
                        @apply bg-purple-500;
                    }
                }
                border-bottom: 1px solid #dee2e6;
                .nav-item-hold {
                    display: block;
                    width: 100%;
                    padding: 26px 0;
                    span.material-icons {
                        font-size: 2rem;
                    }
                }
            }
        }
    }
    .sidebar-left-secondary {
        position: fixed;
        top: 80px;
        left: calc(-220px - 20px);
        z-index: 89;
        height: calc(100vh - 80px);
        width: 220px;
        padding: 0.75rem 0;
        transition: all 0.24s ease-in-out;
        background: #fff;

        &.open {
            left: 120px;
            transition: all 0.24s ease-in-out;
        }
        ul.childNav {
            li {
                &.dropdown-sidemenu {
                    display: block;
                    transition: all 0.3s ease-in;
                    &.open {
                        a {
                            .dd-arrow {
                                transform: rotate(90deg);
                                transition: all 0.3s ease-in;
                            }
                        }
                        ul.submenu {
                            display: block;
                            max-height: 1000px;
                            transition: all 0.3s ease-in;
                        }
                    }

                    a {
                        .dd-arrow {
                            margin-left: auto !important;
                            transition: all 0.3s ease-in;
                        }
                    }
                }

                // &.active {
                //     a {
                //         background-color: #f3f4f6;
                //         @apply text-purple-500;
                //     }
                // }
                a {
                    text-transform: capitalize;
                    display: flex;
                    align-items: center;
                    font-size: 13px;
                    cursor: pointer;
                    padding: 12px 24px;
                    transition: 0.15s all ease-in;
                    &:hover {
                        background-color: #f3f4f6;
                        @apply text-purple-500;
                    }
                    &.router-link-active.router-link-exact-active {
                        @apply text-purple-500;
                    }
                }
                ul.submenu {
                    @apply bg-gray-50;
                    display: none;
                    max-height: 0px;
                    transition: all 0.3s ease-in;

                    &.open {
                        display: block;
                        transition: all 0.3s ease-in;
                    }
                    li {
                        a {
                            padding-left: 48px;
                        }
                    }
                }
            }
        }
    }
    .sidebar-overlay {
        display: none;
        position: fixed;
        width: calc(100% - 120px - 220px);
        height: calc(100vh - 80px);
        bottom: 0;
        right: 0;
        background: rgba(0, 0, 0, 0);
        z-index: 101;
        cursor: w-resize;
        &.open {
            display: block;
        }
    }
}
</style>
