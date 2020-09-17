<template>
    <div class="container mx-auto py-5">
        <div class="container-fluid bg-gray-200 flex mb-2 p-2 flex">
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'All'}" @click="filterOrders(orders,'All')">All</button>
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'Cancelled'}" @click="filterOrders(cancelled_orders,'Cancelled')">Confirmed</button>
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'Pending'}" @click="filterOrders(pending_orders,'Pending')">Pending</button>
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'Confirmed'}" @click="filterOrders(confirmed_orders,'Confirmed')">Confirmed</button>
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'Processed'}" @click="filterOrders(processed_orders,'Processed')">Processed</button>
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'Shipped'}" @click="filterOrders(shipped_orders,'Shipped')">Shipped</button>
            <button class="focus:outline-none p-2 text-xs select-none" :class="{'text-blue-500 text-sm font-bold' : filtered_orders.name == 'Delivered'}" @click="filterOrders(delivered_orders,'Delivered')">Delivered</button>
        </div>
        <div class="container-fluid mb-2 p-2" v-show="filtered_orders.orders.length == 0">
            <span class="text-sm font-bold">There's no <span>{{filtered_orders.name}}</span> orders currently, go back to <span class="text-blue-500 cursor-pointer" @click="filterOrders(orders,'All')">All Orders</span> or <router-link class="text-blue-500 cursor-pointer" :to="{name : 'home'}">make a new one</router-link></span>
        </div>
        <order-component v-for="order in filtered_orders.orders" :order="order" :key="order.id" :manage="true"></order-component>
    </div>
</template>

<script>
export default {
    name: "orders",
    data() {
        return {
            orders: [],
            filtered_orders : {
                'name' : '',
                'orders' : []
            }
        }
    },
    computed: {
        cancelled_orders() {
            return this.filterOrdersData('cancelled')
        },
        pending_orders() {
            return this.filterOrdersData('pending')
        },
        confirmed_orders() {
            return this.filterOrdersData('confirmed')
        },
        shipped_orders() {
            return this.filterOrdersData('shipped')
        },
        processed_orders() {
            return this.filterOrdersData('processed')
        },
        delivered_orders() {
            return this.filterOrdersData('delivered / ended')
        }
    },
    mounted() {
        this.fetchOrders()
    },

    methods: {
        fetchOrders() {
            axios.get('/api/orders')
                .then(({data}) => {
                    this.orders = data
                    this.filtered_orders.orders = data
                    this.filtered_orders.name = 'All'
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },
        filterOrders(data,name) {
            this.filtered_orders.orders = data
            this.filtered_orders.name = name
        },
        filterOrdersData(status) {
            return this.orders.filter(order => {
                return order.final_status == status
            })
        },

    }

}
</script>

<style scoped>

</style>
