<template>
    <section class="border border-gray-400 pb-5">
        <div class="nav-bar mt-4 container mx-auto">
            <div class="flex items-center justify-between">
                <router-link to="/">
                    <img src="/images/logo.png" alt="logo">
                </router-link>

                <search-component></search-component>

                <div class="flex">
                    <button class="rounded-icon"><i class="las la-shopping-bag"></i></button>
                    <button  v-if="isAuthenticated" class="rounded-icon ml-4"><i class="lar la-user"></i></button>

                    <div class="flex flex-col ml-3 justify-center">
                        <p v-if="isAuthenticated" class="text-gray-600 text-sm">Welcome {{ $store.state.user.name }}!</p>
                        <div class="text-sm">
                            <router-link v-if="!isAuthenticated" to="/login" class="link uppercase font-bold">Sign in</router-link>
                            <a href="#" @click="logout" class="link" v-if="isAuthenticated">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "NavbarComponent",
    computed: {
        isAuthenticated() {
            return this.$store.state.user != '';
        }
    },
    methods: {
        logout() {
            axios.post('/logout')
            .then(() => {
                window.location.replace('/')
            })
            .catch((message) => {
                console.log(error.message)
            })
        }
    }
}
</script>
