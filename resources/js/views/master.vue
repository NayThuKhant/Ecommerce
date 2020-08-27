<template>
    <div>
        <spinner-component v-if="!this.$store.state.loaded"/>
        <div v-show="this.$store.state.loaded">
            <navbar-component></navbar-component>
            <menubar-component></menubar-component>
            <banner-component></banner-component>
            <product-component></product-component>
        </div>
    </div>
</template>

<script>
export default {
    name: "master",
}
</script>

<style scoped>

</style>
