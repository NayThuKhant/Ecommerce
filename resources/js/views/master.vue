<template>
    <div>
        <div>
            <navbar-component></navbar-component>
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
</template>

<script>
export default {
    name: "master",
    data() {
        return {
            user: {}
        }
    },
    mounted() {
        this.fetchCurrentUser();
    },
    methods: {
        fetchCurrentUser() {
            axios.get('/api/user')
            .then(({data}) => {
                this.$store.commit('setAsReady')
                this.$store.commit('setCurrentUser', data)
            })
            .catch((error) => {
                console.log(error.message)
            })
        }
    }
}
</script>

<style scoped>

</style>
