<template>
    <div>
        <section v-show="loaded" class="container-fluid mx-auto py-4 bg-white mt-3">
        <div class="products mt-4 flex flex-wrap mx-4 container mx-auto">
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

