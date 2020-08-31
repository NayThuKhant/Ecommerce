<template>
    <div>
        <section class="heading bg-gray-300">
            <div class="container mx-auto heading py-6">
                <h3 class="font-bold text-3xl p-0">You are on the way!</h3>
                <p class="text-lg mt-2">We need some more info to complete your account sign up.</p>
            </div>
        </section>
        <section class="container mx-auto ">
            <div class="w-full max-w-lg mt-6 mx-auto rounded-lg border border-gray-400 px-4 py-4">
                <h5 class="uppercase tracking-wide text-gray-800 text-base font-bold mb-5 ">
                    More information
                </h5>
                <form class="flex flex-wrap" @submit.prevent="handleSubmit">
                    <alert-component type="error" v-if="error.errors">
                        <ul v-for="(error, index) in error.errors">
                            <li v-for="suberror in error">
                                {{suberror}}
                            </li>
                        </ul>
                    </alert-component>
                    <div class="form-group w-full">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="name">
                            Fullname <span class="text-xs text-red-500">*</span>
                        </label>
                        <input
                            class="form-input"
                            id="name" type="text" placeholder="Jane" v-model="formData.name" :disabled="user.name != null">
                    </div>
                    <div class="form-group w-full">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="email">
                            Email <span class="text-xs text-red-500">*</span>
                        </label>
                        <input
                            class="form-input"
                            id="email" type="text" placeholder="jane@example.com" v-model="formData.email" :disabled="user.email != null">
                    </div>
                    <div class="form-group w-full">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="phone">
                            Phone <span class="text-xs text-red-500">*</span>
                        </label>
                        <input
                            class="form-input"
                            id="phone" type="number" placeholder="0923456789" v-model="formData.phone">
                    </div>
                    <button type="submit" class="btn-full btn-blue">
                        Save & Continue
                    </button>
                </form>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "MoreInfoView",
    created() {
        this.$Progress.start()
    },
    mounted() {
        this.$Progress.finish()
    },
    data() {
        return {
            formData: {},
            error: {}
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        }
    },
    watch: {
        user() {
            this.formData = {...this.user}
        }
    },
    methods: {
        handleSubmit() {
            this.$Progress.start()
            axios.post('/api/update-info', {
                name: this.formData.name,
                email: this.formData.email,
                phone: this.formData.phone
            })
            .then(() => {
                toastr.success('Profile updated successfully', 'Success')
                window.location.replace('/')
                this.$Progress.finish()
            })
            .catch((e) => {
                this.error = e.response.data
                this.$Progress.fail()
            })
        }
    }
}
</script>

<style scoped>

</style>
