<template>
    <div class="container mx-auto py-5">
        <order-component v-for="order in orders" :order="order" :key="order.id" :manage="true"></order-component>
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
