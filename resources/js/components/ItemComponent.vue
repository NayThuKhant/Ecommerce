<template>
    <div class="p-4 max-w-sm w-1/4">
        <div class="rounded overflow-hidden border border-gray-300 transition-ease  hover:shadow-xl">
            <a href="#" class="flex justify-center" style="height: 220px;">
                <img :src="`/${product.featured_photo}`" :alt="product.name" class="w-auto max-w-full h-full">
            </a>
            <div class="px-6 py-4">
                <a href="">
                    <div class="font-bold text-xl mb-2 hover:text-blue-600 transition-ease">{{ product.name }}</div>
                </a>
                <p class="text-gray-800 text-base">Start from {{ product.min_price }} Ks</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ItemComponent",
    props: ['product']
}
</script>

<style scoped>

</style>
