<template>
    <div class="container-fluid bg-gray-200 flex flex-col mb-2">
        <div
            class="flex border-solid items-center border-b-2 border-black-900 text-sm p-2 bg-orange-300 justify-between">
            <div class="flex flex-col">
                <span>Order#{{ order.id }}</span>
                <span class="text-xs"> Placed on {{ new Date(order.created_at) }}</span>
            </div>
            <span class="bg-red-400 ml-4 rounded p-1 text-xs" v-show="manage">{{ order.final_status }}</span>
            <router-link v-show="manage" :to="{ name: 'order.manage', params: { id : order.id }}">Manage</router-link>
            <router-link v-show="!manage" :to="{ name : 'orders'}" class="hover:text-blue-900">Back to all orders</router-link>
        </div>
        <div class="text-sm flex flex-col p-2" v-for="item in order.items">
            <div class="flex justify-between">
                <div class="flex flex-1">
                    <img :src="`/${JSON.parse(item.featured_photo)[0]}`" alt="" class="w-12 h-12">
                    <div class="flex flex-col px-2">
                        <h3 class="font-bold">{{ item.variant.product.name }}</h3>
                        <span class="text-xs">{{ item.variant.name }}</span>
                    </div>
                </div>
                <span class="flex-1">{{ item.variant.special_price }} MMK x <span class="opacity-25">Qty : </span>{{ item.quantity }}</span>
                <span class="flex-1">{{ item.price }} MMK</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderComponent.vue",
    props: ['order', 'manage'],
}
</script>

<style scoped>

</style>
