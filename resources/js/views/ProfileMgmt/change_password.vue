<template>
    <div>
        <section class="heading bg-gray-300">
            <div class="container mx-auto heading py-6">
                <h3 class="font-bold text-3xl p-0">Change Password</h3>
            </div>
        </section>
        <section class="container mx-auto ">
            <div class="w-full max-w-lg mt-6 mx-auto rounded-lg border border-gray-300 px-4 py-4">
                <h5 class="uppercase tracking-wide text-gray-800 text-base font-bold mb-5 ">
                    More information
                </h5>
                <form class="flex flex-wrap" @submit.prevent="">
                    <div class="form-group w-full">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="current_password">
                            Current Password <span class="text-xs text-red-500">*</span>
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="current_password" autocomplete="current_password" type="password" v-model="formData.current_password">
                    </div>
                    <div class="form-group w-full">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="new_password">
                            New Password <span class="text-xs text-red-500">*</span>
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="new_password" autocomplete="new_password" type="password" v-model="formData.new_password">
                    </div>
                    <div class="form-group w-full">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="password_confirmation">
                            Confirm Password <span class="text-xs text-red-500">*</span>
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="password_confirmation" autocomplete="new_password" type="password" v-model="formData.password_confirmation">
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
    name: "change_password",
    data() {
        return {
            formData: {
                current_password: "",
                new_password: "",
                password_confirmation: ""
            }
        }
    }
}
</script>

<style scoped>

</style>
