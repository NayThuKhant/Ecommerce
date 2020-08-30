<template>
    <div>
        <h1>{{ product.name }}</h1>
    </div>
</template>

<script>
export default {
    name: "product",
    data() {
        return {
            product: {}
        }
    },
    mounted() {
        this.fetchProduct()
    },
    computed: {
        id() {
            return this.$route.params.id
        }
    },
    watch: {
        id() {
            this.fetchProduct()
        }
    },
    methods: {
        fetchProduct() {
            axios.get(`/api/products/${this.id}`)
            .then(({data}) => {
                this.product = data
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
