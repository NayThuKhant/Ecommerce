<template>
    <div class="container mx-auto py-5">
        <div class="container-fluid bg-gray-200 flex flex-col mb-6" v-for="order in orders">
            <div class="flex justify-between border-solid border-b-2 border-black-900 text-sm p-3 bg-orange-300">
                <span>Order#{{ order.id}}</span>
                <span>Ordered on {{ order.created_at }}</span>
                <span>Total : {{ order.total }} mmk</span>
                <span>{{ order.items.length }} items</span>
                <a href="#" class="text-sm">Manage</a>
            </div>
            <div class="text-sm flex flex-col p-3" v-for="item in order.items">
                <div class="flex justify-between">
                    <div class="flex flex-1">
                        <img :src="`/${JSON.parse(item.featured_photo)[0]}`" alt="" class="w-12 h-12">
                        <div class="flex flex-col px-2">
                            <h3 class="font-bold">{{ item.variant.product.name }}</h3>
                            <span class="text-xs">{{ item.variant.name }}</span>
                        </div>
                    </div>

                    <span class="flex-1">
                        {{ item.variant.special_price }} MMK x <span class="opacity-25">Qty : </span>{{ item.quantity }}
                    </span>
                    <span class="flex-1">
                        {{ item.price }} MMK
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "orders",

    data() {
        return {
            orders: [],
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
                    console.log(data)
                })
                .catch((e) => {
                    console.log(e.message)
                })
        }
    }

}
</script>

<style scoped>

</style>
