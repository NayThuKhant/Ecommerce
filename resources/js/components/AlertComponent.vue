<template>
    <div class="rounded shadow-lg w-full px-3 py-3 mb-3" :class="[alertClass]">
        <span class="text-white font-semibold text-sm">
            <slot/>
        </span>
    </div>
</template>

<script>
export default {
    name: "AlertComponent",
    props: {
        type: {
            required: false,
            type: String,
            default: 'success'
        }
    },
    computed: {
        alertClass() {
            if (this.type === "success") {
                return "bg-green-500"
            }
            else if (this.type === "warning") {
                return "bg-yellow-500"
            }
            else if (this.type === "error") {
                return "bg-red-500"
            }
        }
    }
}
</script>

<style scoped>

</style>
