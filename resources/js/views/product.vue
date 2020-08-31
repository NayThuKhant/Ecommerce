<template>

    <div class="container mx-auto flex flex-col p-3">
        <div class="py-2">
            <h1 class="text-xl font-bold font-italic">{{ product.name }}</h1>
        </div>

        <div class="flex py-2">
            <div class="w-1/5 p-2">
                <img :src="`/${selectedImages[0]}`" alt="" class="w-full h-64">
            </div>
            <div class="w-2/5 p-2 flex flex-col">
                <div class="flex-1">
                    <p class="mt-1">name : {{ selected_variant.name }}</p>
                    <p class="mt-1">color : {{ selected_variant.color_family }}</p>
                    <p class="mt-1">SKU : {{ selected_variant.SKU }}</p>
                    <p class="mt-1">Stocks : {{ selected_variant.stocks }} items</p>
                    <p class="mt-1">SKU : {{ selected_variant.SKU }}</p>
                    <p class="mt-1">Price : {{ selected_variant.sale_price }}</p>
                    <p class="mt-1">Special Price : {{ selected_variant.special_price }}</p>
                </div>
                <div class="flex">
                    <div @mouseover="selectVariant(index)" class="h-16 w-16 p-1 m-1 border-2 border-red-900" v-for="( variant,index ) in product.variants" :key="index">
                        <img :src="`/${JSON.parse(variant.photos)[0]}`" alt="" class="w-full h-full">
                    </div>

                </div>
            </div>
            <div class="w-2/5 p-2 flex flex-col">
                <div class="py-2 border-b-2 border-gray-300">
                    <p class="mt-1 font-bold text-red-900">{{ selected_variant.special_price }} MMK (Now)</p>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="flex-1 flex justify-center items-center">
                        <button><i class="las la-minus-circle text-5xl text-blue-900"></i></button>
                        <span class="mx-3 font-bold text-2xl">1</span>
                        <button><i class="las la-plus-circle text-5xl text-blue-900"></i></button>
                    </div>
                    <div class="flex-1">
                        <button class="w-full bg-blue-300 p-3 rounded-full hover:bg-blud-500 hover:shadow">Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16">
            <tabs-component>
                <tab-component name="Description" :selected="true" class="">
                    <p v-html="product.description">
                    </p>
                </tab-component>
                <tab-component name="Highlight">
                    <p v-html="product.highlight">
                    </p>
                </tab-component>
                <tab-component name="What's include in the box ?">
                    <p v-html="product.included">

                    </p>
                </tab-component>
            </tabs-component>
        </div>


    </div>

</template>

<script>
export default {
    name: "product",
    data() {
        return {
            product: {},
            selected_variant : {},
        }
    },
    mounted() {
        this.fetchVariants()
    },
    computed: {
        id() {
            return this.$route.params.id
        },
        selectedImages(){
              return JSON.parse(this.selected_variant.photos ?? "[]");
        }
    },
    watch: {
        id() {
            this.fetchVariants()
        }
    },
    methods: {
        fetchVariants() {
            axios.get(`/api/products/${this.id}/variants`)
                .then(({data}) => {
                    this.product = data;
                    this.selected_variant = this.product.variants[0];
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },

        selectVariant(index){
            this.selected_variant = this.product.variants[index];
        }
    },

}


</script>


<style scoped>

</style>
