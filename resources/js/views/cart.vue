<template>
    <div class="md:container sm:container-fluid mx-auto flex px-5">
        <div class="w-2/3 mx-2 mt-3 flex-col" v-if="is_not_empty_cart">
            <div class="flex my-2 py-2 bg-gray-200" v-for="(variant, index) in variants">
                <div class="flex w-2/3 px-3 flex">
                    <img :src="`/${JSON.parse(variant.photos)[0]}`" alt="" class="w-20 h-20 border-2 border-gray-300">
                    <div class="flex-1 px-2">
                        <router-link :to="{ name : 'product.show', params : { id : variant.product.id }}">
                            <h2 class="font-italic text-sm">{{ variant.product.name }} ({{ variant.name }})</h2>
                        </router-link>
                        <p class="text-sm">Ks {{ variant.special_price }} </p>
                        <span class="text-xs text-gray-500"> only {{ variant.stocks }} items available</span>
                    </div>
                </div>
                <div class="flex w-1/3 justify-around items-center">
                    <span class="text-lg font-bold px-4"> Ks {{ variant.pivot.sub_total }}</span>
                    <button @click="removeFromCart(variant.id)"><i class="las la-trash text-2xl text-blue-900"></i>
                    </button>
                    <button @click="decreaseQuantity(variant.id,index)"><i
                        class="las la-minus-circle text-2xl text-blue-900"></i>
                    </button>
                    <span class="mx-3 font-bold text-lg"> {{ variant.pivot.quantity }} </span>
                    <button @click="increaseQuantity(variant.id,index)"><i
                        class="las la-plus-circle text-2xl text-blue-900"></i></button>
                </div>
            </div>
        </div>


        <div class="w-1/3 mx-2 mt-3" v-if="is_not_empty_cart">
            <div class="w-100 bg-gray-200 my-2 flex-col p-3">
                <div class="flex-col border-b-2 border-gray-400">
                    <div class="mb-6">Order Summary</div>
                    <div class="my-3 text-sm flex justify-between">
                        <span>Subtotal ( {{ counter }} items )</span>
                        <span>+ {{ cart.sub_total }} </span>
                    </div>
                    <div class="my-3 text-sm flex justify-between">
                        <span>Shipping Fee</span>
                        <span>+ {{ cart.shipping_fee }}</span>
                    </div>
                    <div class="my-3 text-sm flex justify-between">
                        <span>Discount</span>
                        <span>- {{ cart.discount }}</span>
                    </div>
                    <div class="my-3 text-sm flex flex-col">
                        <div class="flex justify-between items-center">
                            <input type="text" class="w-2/3 h-8 mr-2 border-2 px-3 outline-none"
                                   placeholder="Voucher Code" v-model="voucher">
                            <button class="w-1/3 ml-2 bg-blue-300 h-8 border-2" @click="applyVoucher">APPLY</button>
                        </div>
                        <div class="flex flex-col" v-if="is_voucher">
                            <span class="text-xs text-red-400" @click="removeVoucher">Remove Voucher</span>
                        </div>
                        <span v-if="!is_voucher" class="text-xs text-red-400">no voucher</span>
                    </div>


                </div>
                <div class="flex-col">
                    <div class="my-4 text-lg text-red-400 flex justify-between">
                        <span>Total</span>
                        <span>{{ cart.total }} MMK</span>
                    </div>
                    <div class="text-xs my-4 flex-col justify-content-between">
                        <div class="flex-1 flex items-center">
                            <input type="radio" name="payment" class="mr-2" id="payment1" value="prepaid"
                                   v-model="payment">
                            <label for="payment1"> prepaid </label>
                        </div>
                        <div class="flex-1 flex items-center">
                            <input type="radio" name="payment" class="mr-2" id="payment2" value="cash on delivery"
                                   checked v-model="payment">
                            <label for="payment2"> cash on delivery </label>
                        </div>
                    </div>
                    <div class="flex my-1">
                        <button class="flex-1 bg-red-400 text-sm p-2 text-white" @click="confirmClearCart">Clear Cart
                        </button>
                    </div>
                    <div class="flex">
                        <button class="flex-1 bg-orange-400 text-sm p-2 text-white" @click="confirmOrderNow">Place Order
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="class mx-auto mt-5" v-if="!is_not_empty_cart">
            Your Cart is still empty,
            <router-link class="text-blue-400" :to="{name : 'home'}">go back to shop !</router-link>
        </div>
    </div>

</template>

<script>
export default {
    name: "cart",
    data() {
        return {
            cart: '',
            variants: [],
            voucher: '',
            payment: 'cash on delivery',
            addresses: [],
            selected_address: '',
        }
    },
    watch: {
        isAuthenticated(value) {
            if (value) {
                this.fetchVariantsInCart()
                this.fetchAddresses()
                this.checkVoucher()
            }
        }
    },
    mounted() {
        if (this.$store.state.user != '') {
            this.fetchVariantsInCart()
            this.fetchAddresses()
        }
        this.checkVoucher()
    },
    computed: {
        isAuthenticated() {
            return this.$store.state.user != ''
        },

        is_not_empty_cart() {
            if (this.variants.length < 1) {
                return false
            } else {
                return true
            }
        },
        is_voucher() {
            if (this.cart.discount > 0) {
                return true
            } else {
                return false
            }
        },
        counter() {
            return this.variants.length
        },
    },
    methods: {
        fetchVariantsInCart() {
            axios.get('/api/product-in-cart')
                .then(({data}) => {
                    this.cart = data
                    this.variants = data.variants
                    this.voucher = data.voucher
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },
        fetchAddresses() {
            axios.get('/api/addresses')
                .then(({data}) => {
                    this.addresses = data
                })
                .catch((e) => {
                    toastr.error(e.message, 'Error')
                })
        },
        removeFromCart(product) {
            this.$Progress.start()
            axios.post('api/remove-from-cart/' + product)
                .then(() => {
                    toastr.success('Removed from cart successfully', "Success")
                    this.fetchVariantsInCart();
                    this.checkVoucher()
                    this.eventBus.$emit('updated-cart')
                    this.$Progress.finish()
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },

        decreaseQuantity(product, index) {
            if (this.variants[index].pivot.quantity == 1) {
                this.removeFromCart(product)
            } else {
                this.$Progress.start()
                axios.put('/api/decrease-from-cart/' + product)
                    .then(() => {
                        this.fetchVariantsInCart();
                        this.checkVoucher()
                        this.$Progress.finish()
                    })
                    .catch((e) => {
                        console.log(e)
                    })
            }
        },

        increaseQuantity(product, index) {
            if (this.variants[index].stocks <= this.variants[index].pivot.quantity) {
                toastr.error(`There are only ${this.variants[index].stocks} stocks`, 'Out of stocks')
            } else {
                this.$Progress.start()
                axios.put('/api/increase-to-cart/' + product)
                    .then(() => {
                        this.checkVoucher()
                        this.fetchVariantsInCart();
                        this.$Progress.finish()
                    })
                    .catch((e) => {
                        console.log(e)
                    })
            }
        },
        removeVoucher() {
            axios.post('/api/remove-voucher')
            .then(() => {
                toastr.success('successfully removed voucher')
                this.fetchVariantsInCart()
            })
            .catch((e) => {
                console.log(e)
            })

        },
        applyVoucher() {
            axios.post('/api/apply-voucher', {
                'voucher': this.voucher
            })
                .then(({data}) => {
                    this.fetchVariantsInCart()
                    toastr.success(data);
                })
                .catch(e => {
                    console.log(e)
                })
        },
        checkVoucher() {
            axios.post('/api/apply-voucher', {
                'voucher': this.cart.voucher
            })
                .then(({data}) => {
                    console.log(data)
                    this.fetchVariantsInCart()
                })
                .catch(e => {
                    console.log(e)
                })
        },

        confirmOrderNow() {
            this.$swal({
                icon: 'info',
                title: 'Are you sure to order now ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Order Now',
                cancelButtonText: 'Cancel',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    this.orderNow()
                } else {
                    this.$swal('Cancel', 'Your items are still in cart', 'info')
                }
            })
        },

        orderNow() {
            this.$Progress.start()
            this.checkVoucher()
            axios.post('/api/order-now', {
                payment_method: this.payment
            })
                .then(() => {
                    this.clearCart()
                    this.$Progress.finish()
                    this.$swal('Ordered', 'successfully ordered', 'success')
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },

        confirmClearCart() {
            this.$swal({
                icon: 'question',
                title: 'Are you sure to clear you cart?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Clear Cart',
                cancelButtonText: 'Cancel',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    this.clearCart()
                } else {
                    this.$swal('Cancel', 'Your items are still in cart', 'info')
                }
            })
        },
        clearCart() {
            axios.post('/api/clear-cart')
                .then(() => {
                    toastr.success('successfully cleared your cart', 'success')
                    this.removeVoucher()
                    this.fetchVariantsInCart();
                    this.eventBus.$emit('updated-cart')
                })
                .catch((e) => {
                    console.log(e.message)
                })
        },

    }

}
</script>

<style scoped>

</style>
