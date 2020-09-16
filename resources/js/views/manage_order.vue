<template>
    <div class="container mx-auto py-5 flex flex-col">
        <div class="container-fluid bg-gray-200 flex my-2 p-5 justify-around bg-red-400" v-if="is_cancelled">
            <div class="flex flex-col text-center">
                <i class="lar la-times-circle text-red-900" style="font-size: 64px"></i>
                <span class="text-xs">This order was cancelled and there's nothing to do !</span>
            </div>
        </div>
        <div class="container-fluid bg-gray-200 flex my-2 p-5 justify-around bg-green-400" v-if="is_delivered">
            <div class="flex flex-col text-center">
                <i class="lar la-check-circle text-green-900" style="font-size: 64px"></i>
                <span class="text-xs">This order was successfully delivered to you !</span>
            </div>
        </div>
        <div class="container-fluid bg-gray-200 flex my-2 p-5 justify-around" v-if="!is_cancelled">
            <div class="flex flex-col opacity-100 text-center">
                <i class="lar la-check-circle text-green-900" style="font-size: 40px"></i>
                <span class="text-xs">Pending</span>
            </div>
            <div class="flex flex-col opacity-25 text-center" :class="{ 'opacity-100' : confirmed }">
                <i class="lar la-check-circle" :class="{ 'text-green-900' : confirmed }" style="font-size: 40px"></i>
                <span class="text-xs">Confirmed</span>
            </div>
            <div class="flex flex-col opacity-25 text-center" :class="{ 'opacity-100' : processed }">
                <i class="lar la-check-circle" :class="{ 'text-green-900' : processed }" style="font-size: 40px"></i>
                <span class="text-xs">Proceeded</span>
            </div>
            <div class="flex flex-col opacity-25 text-center" :class="{ 'opacity-100' : shipped }">
                <i class="lar la-check-circle" :class="{ 'text-green-900' : shipped }" style="font-size: 40px"></i>
                <span class="text-xs">Shipped</span>
            </div>
            <div class="flex flex-col opacity-25 text-center" :class="{ 'opacity-100' : delivered }">
                <i class="lar la-check-circle" :class="{ 'text-green-900' : delivered }" style="font-size: 40px"></i>
                <span class="text-xs">Delivered</span>
            </div>
        </div>

        <order-component :order="order" :key="order.id" :manage="false" :order_status="false"></order-component>
        <div class="container-fluid flex">
            <div class="container-fluid flex-1 flex-col pr-1">
                <div class="container-fluid bg-gray-200 my-2 p-2">
                    <h4 class="text-lg mb-3">Shipping Address</h4>
                    <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda consequuntur
                        culpa debitis dicta, eos error exercitatio</p>
                </div>
                <div class="container-fluid bg-gray-200 my-2 p-2 leading-loose">
                    <h4 class="text-lg mb-3">Order Status</h4>

                </div>
            </div>
            <div class="container-fluid flex-1 flex-col pl-1">
                <div class="container-fluid bg-gray-200 my-2 p-2 leading-loose">
                    <h4 class="text-lg mb-3">Total Summary</h4>

                    <div class="container-fluid flex">
                        <span class="text-sm flex-1">Sub total</span>
                        <span class="text-sm flex-1 text-right">+ {{ order.subtotal }} MMK</span>
                    </div>
                    <div class="container-fluid flex mb-2">
                        <span class="text-sm flex-1">Shipping fee</span>
                        <span class="text-sm flex-1 text-right">+ {{ order.shipping_fee }} MMK</span>
                    </div>
                    <div class="container-fluid flex mt-2">
                        <span class="text-sm flex-1 font-bold">Total</span>
                        <span class="text-sm flex-1 font-bold text-right">= {{ order.total }} MMK</span>
                    </div>
                </div>
                <div class="container-fluid bg-gray-200 my-2 p-2 leading-loose">
                    <h4 class="text-lg mb-3">Cancel My Order</h4>
                    <button @click="confirmCancelOrder"
                            class="bg-red-500 text-sm rounded-lg p-2 outline-none focus:outline-none"
                            v-if="order.is_cancellable">Cancel My Order
                    </button>
                    <span class="text-xs text-muted font-bold" v-if="order.is_cancellable">Your order was just <span
                        class="text-red-500">{{ order.final_status }}</span> and can be cancelled !</span>
                    <span class="text-xs text-muted font-bold" v-if="!order.is_cancellable">Your order was just <span
                        class="text-red-500">{{ order.final_status }}</span> and can not be cancelled !</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import orders from "./orders";

export default {
    name: "manage_order",
    data() {
        return {
            order: [],
            reason: '',
            confirmed : '',
            processed : '',
            shipped : '',
            delivered : '',
        }
    },
    mounted() {
        this.fetchItems()
    },
    watch: {
        id() {
            this.fetchItems()
        }
    },
    computed: {
        id() {
            return this.$route.params.id
        },
        is_delivered() {
            return this.order.final_status == 'delivered / ended'
        },
        is_cancelled() {
            return this.order.final_status == 'cancelled'
        }
    },
    methods: {
        fetchItems() {
            axios.get(`/api/orders/${this.id}/manage`)
                .then(({data}) => {
                    this.order = data
                    console.log(data)
                    this.confirmed = this.order.order_status.confirmed_at
                    this.processed = this.order.order_status.processed_at
                    this.shipped = this.order.order_status.shipped_at
                    this.delivered = this.order.order_status.delivered_at
                })
                .catch((e) => {
                    toastr.error(e.message, 'Error')
                })
        },
        cancelOrder() {
            axios.post(`/api/orders/${this.id}/cancel`, {reason: this.reason})
                .then(() => {
                    this.fetchItems()
                    this.$swal('Success', 'Successfully cancelled your order')
                    window.location.replace('/orders')
                })
                .catch((e) => {
                    toastr.error(e.message, 'Error')
                })
        },
        confirmCancelOrder() {
            this.$swal.mixin({
                confirmButtonText: 'Next &rarr;',
                showCancelButton: true,
                progressSteps: ['1', '2']
            }).queue([
                {
                    input: 'text',
                    title: 'Cancellation',
                    text: 'Please give us a reason to cancel'
                },
                {
                    title: 'Confirm cancellation',
                    text: 'Please confirm to cancel your order',
                    confirmButtonText: 'Confirm',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                }
            ])
                .then(result => {
                    if (!result.dismiss) {
                        if (result.value[0]) {
                            this.reason = result.value[0]
                        } else {
                            this.reason = 'Something Else'
                        }
                        this.cancelOrder()
                    }
                })
        },
    }

}
</script>

<style scoped>

</style>
