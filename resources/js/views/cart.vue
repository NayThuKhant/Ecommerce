<template>
    <div class="container mx-auto flex px-5">
        <div class="w-2/3 mx-2 mt-3 flex-col">
            <div class="flex my-2 py-2 bg-gray-200" v-for="(variant, index) in variants">
                <div class="flex w-2/3 px-3 flex">
                    <img src="/images/shirt.jpg" alt="" class="w-20 h-20 border-2 border-gray-300">
                    <div class="flex-1 px-2">
                        <h2 class="font-italic text-sm">{{ variant.product.name }} ({{variant.name}})</h2>
                        <p class="text-sm">Ks {{ variant.special_price }} </p>
                    </div>
                </div>
                <div class="flex w-1/3 justify-around items-center">
                    <span class="text-lg font-bold px-4"> Ks {{ variant.pivot.sub_total }}</span>
                    <button @click="removeFromCart(variant.id)"><i class="las la-trash text-2xl text-blue-900"></i></button>
                    <button @click="decreaseQuantity(variant.id)"><i class="las la-minus-circle text-2xl text-blue-900"></i>
                    </button>
                    <span class="mx-3 font-bold text-lg"> {{ variant.pivot.quantity }} </span>
                    <button @click="increaseQuantity(variant.id)"><i
                        class="las la-plus-circle text-2xl text-blue-900"></i></button>
                </div>
            </div>
        </div>


        <div class="w-1/3 mx-2 mt-3">
            <div class="w-100 bg-gray-200 my-2 flex-col p-3">
                <div class="flex-col border-b-2 border-gray-400">
                    <div class="mb-6">Order Summary</div>
                    <div class="my-3 text-sm flex justify-between">
                        <span>Subtotal ( 3 items )</span>
                        <span>3000 MMK</span>
                    </div>
                    <div class="my-3 text-sm flex justify-between">
                        <span>Shipping Fee</span>
                        <span>3000 MMK</span>
                    </div>
                    <div class="my-3 text-sm flex justify-between items-center">
                        <input type="text" class="w-2/3 h-8 mr-2 border-2 px-3 outline-none"
                               placeholder="Voucher Code">
                        <button class="w-1/3 ml-2 bg-blue-300 h-8 border-2">APPLY</button>
                    </div>
                </div>
                <div class="flex-col">
                    <div class="my-3 text-lg text-red-400 flex justify-between">
                        <span>Total</span>
                        <span>3000 MMK</span>
                    </div>
                    <div class="flex">
                        <button class="flex-1 bg-orange-400 text-sm p-2 text-white">Place Order</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "cart",
    data() {
        return {
            variants: {},
        }
    },
    mounted() {
        this.fetchVariantsInCart();
    },
    methods: {
        fetchVariantsInCart() {
            axios.get('/api/product-in-cart')
                .then(({data}) => {
                    this.variants = data;
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },

        removeFromCart(product) {
            axios.post('api/remove-from-cart/' + product)
                .then(() => {
                    toastr.success('Removed from cart successfully', "Success")
                    this.fetchVariantsInCart();
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },

        decreaseQuantity(product) {
           if(this.variants[0].pivot.quantity == 1) {
               this.removeFromCart(product)
           }
           else {
             axios.put('/api/decrease-from-cart/' + product)
                .then(() => {
                    this.fetchVariantsInCart();
                })
                .catch((e) => {
                    console.log(e)
                })
           }
        },

        increaseQuantity(product) {
            axios.put('/api/increase-to-cart/'+product)
                .then(()=> {
                    this.fetchVariantsInCart();
                })
                .catch((e)=> {
                    console.log(e)
                })
        }

    }

}
</script>

<style scoped>

</style>
