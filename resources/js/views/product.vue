<template>

    <div class="container mx-auto flex flex-col p-3">
        <div class="py-2">
            <h1 class="text-xl font-bold font-italic">{{ product.name }}</h1>
        </div>

        <div class="flex py-2">
            <div class="w-2/6 p-2">
                <img :src="`/${selectedImages[0]}`" alt="" class="w-full h-64">
            </div>
            <div class="w-2/6 p-2 flex flex-col">
                <div class="flex-1">
                    <pre class="mt-1 text-sm">name    : {{ selected_variant.name }}</pre>
                    <pre class="mt-1 text-sm">color   : {{ selected_variant.color_family }}</pre>
                    <pre class="mt-1 text-sm">SKU     : {{ selected_variant.SKU }}</pre>
                    <pre class="mt-1 text-sm">Stocks  : {{ selected_variant.stocks }} items</pre>
                    <pre class="mt-1 text-sm">SKU     : {{ selected_variant.SKU }}</pre>
                    <pre class="mt-1 text-sm">Price   : {{ selected_variant.sale_price }}</pre>
                </div>
                <div class="flex-col">
                    <div class="flex">
                        <div @click="selectVariant(index)" class="h-16 w-16 p-1 m-1 border-2 border-red-900"
                             v-for="( variant,index ) in product.variants" :key="index">
                            <img :src="`/${JSON.parse(variant.photos)[0]}`" alt="" class="w-full h-full">
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Choose one of the variants to add to the cart</p>
                    </div>
                </div>
            </div>
            <div class="w-2/6 p-2 flex flex-col">
                <div class="py-2 border-b-2 border-gray-300">
                    <p class="mt-1 font-bold text-red-900">{{ selected_variant.special_price }} MMK (Now)</p>
                </div>
                <div class="flex-1 flex items-center">
                    <div class="flex-1 flex justify-center items-center">
                        <button @click="decreaseQuantity"><i class="las la-minus-circle text-5xl text-blue-900"></i>
                        </button>
                        <span class="mx-3 font-bold text-2xl"> {{ quantity }} </span>
                        <button @click="increaseQuantity" :disabled="disable_increasement"><i class="las la-plus-circle text-5xl text-blue-900"></i></button>
                    </div>
                    <div class="flex-1">
                        <button class="w-full bg-blue-300 p-3 rounded-full hover:bg-blue-500 hover:shadow font-bold text-sm" @click="addToCart" :disabled="disable_add_to_cart">
                            {{ disable_add_to_cart ? "Maxed" : "Add to Cart" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10">
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
            product : {},
            selected_variant : {},
            quantity : 1,
            current_quantity_in_cart: 0
        }
    },
    mounted() {
        this.fetchVariants()
        .then(() => {
            this.fetchCurrentQuantityInCart()
        })

    },
    computed: {
        id() {
            return this.$route.params.id
        },
        selectedImages() {
            return JSON.parse(this.selected_variant.photos ?? "[]");
        },
        isAuthenticated(){
            return this.$store.state.user != '';
        },
        disable_increasement() {
            if (this.quantity + this.current_quantity_in_cart >= this.selected_variant.stocks){
                return true
            }
            return false
        },
        disable_add_to_cart() {
            if (this.quantity > this.selected_variant.stocks - this.current_quantity_in_cart){
                return true
            }
            return false
        }
     },
    watch: {
        id() {
            this.fetchVariants()
        },
        selected_variant() {
            this.fetchCurrentQuantityInCart()
        }
    },
    methods: {
        async fetchVariants() {
            try {
                let {data} = await axios.get(`/api/products/${this.id}/variants`)
                this.product = data;
                this.selected_variant = this.product.variants[0];
            }
            catch (e) {
                toastr.error(e.message, "Error")
            }
        },
        fetchCurrentQuantityInCart() {
            axios.get(`/api/cart/${this.selected_variant.id}/get_current_quantity`)
            .then(({data}) => {
                this.current_quantity_in_cart = data.current_quantity
            })
        },
        selectVariant(index) {
            this.selected_variant = this.product.variants[index];
            this.quantity = 1;
        },

        decreaseQuantity() {
            if(this.quantity > 1) {
                this.quantity -= 1;
            }
            else {
                console.log('can\'t be lower than 0') //temporary testing , replace with remove from cart
            }
        },

        increaseQuantity() {
            if(this.quantity < this.selected_variant.stocks) {
                this.quantity += 1;
            }
        },

        addToCart(){
           if(this.isAuthenticated){
              axios.post('/api/add-to-cart/' + this.selected_variant.id, {
                  quantity : this.quantity
              })
               .then(() => {
                   toastr.success('Added to cart successfully', "Success")
               })
               .catch((e) => {
                   console.log(e.message)
               });
           }
           else{
               window.location.replace('/login');
           }
        }

    },

}


</script>

<style scoped>

</style>
