<template>
    <div>
        <section v-show="loaded" class="container mx-auto py-4 bg-white mt-3">
        <div class="heading flex justify-between items-center">
            <h3 class="font-bold text-3xl">Latest Products</h3>
            <button class="btn btn-indigo">See all</button>
        </div>
        <div class="products mt-4 flex flex-wrap -mx-4">
            <item-component v-for="product in products.data" :key="product.id" :product="product"></item-component>
        </div>
    </section>
    </div>
</template>

<script>
export default {
    name: "ProductComponent",
    data() {
        return {
            products: [],
            loaded: false
        }
    },
    mounted() {
        this.fetchProduct()
    },
    methods: {
        fetchProduct() {
            axios.get('/api/products')
            .then(({data}) => {
                this.products = data
                this.loaded = true
            })
            .catch(error => {
                console.log(error.message)
            })
        }
    }
}
</script>

<style scoped>

</style>
