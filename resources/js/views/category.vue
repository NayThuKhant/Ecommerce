<template>
     <div>
        <section class="container mx-auto py-4 bg-white mt-3">
            <div class="heading flex justify-between items-center">
                <h3 class="font-bold text-3xl">Products in {{ category.name }}</h3>
                <button class="btn btn-indigo">See all</button>
            </div>
            <div class="products mt-4 flex flex-wrap -mx-4">
                <item-component v-for="product in category.products" :key="product.id" :product="product"></item-component>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "category",
    data() {
        return {
            category: {}
        }
    },
    mounted() {
        this.fetchProducts()
    },
    methods: {
        fetchProducts() {
            axios.get(`/api/categories/${this.$route.params.slug}`)
            .then(({data}) => {
                this.category = data
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
