<template>
    <div class=" lg:container md:container sm:container-fluid mx-auto my-4 flex flex-col relative">
        <div class="flex justify-end my-3 py-2" :class="{ 'opacity-25' : show_add_address }">
            <button @click="show_add_address = true"
                    class="float-right uppercase btn-blue text-sm p-2 hover:bg-green-400">
                add new address
            </button>
        </div>

        <div :class="{ 'opacity-25' : show_add_address }"
            class="w-full flex lg:text-sm md:text-sm sm:text-xs text-xs px-2 py-4 border border-1 border-black-900 font-bold bg-gray-400">
            <div class="flex-1 flex" >
                <span class="w-1/4">Name</span>
                <span class="w-2/4">Full Address</span>
                <span class="w-1/4">Phone</span>
            </div>
            <span>Edit</span>
        </div>
        <div v-for="(address,index) in addresses" :key="index" :class="{ 'opacity-25' : show_add_address }"
             class="w-full flex lg:text-sm md:text-sm sm:text-xs text-xs px-2 py-4 hover:bg-gray-200 border-b-2 border-black-900">
            <div class="flex-1 flex">
                <span class="w-1/4">{{ address.full_name }}</span>
                <span class="w-2/4">{{ address.full_address }}</span>
                <span class="w-1/4">{{ address.phone }}</span>
            </div>
            <span>Edit</span>
        </div>

        <div class="absolute bg-gray-300 edit-address flex flex-col" v-if="show_add_address">
            <div class="bg-orange-400 py-2 mb-2 px-5">
                <h3>Add new address</h3>
            </div>
            <form class="flex flex-col p-5" @keydown="form.errors.clear($event.target.name)" @submit.prevent="save">
                <div class="flex mb-3">
                    <section class="flex flex-col flex-1 pr-2">
                        <label for="name" class="mb-2 text-sm font-bold">Name</label>
                        <input name="name" v-model="form.name" id="name" type="text"
                               class="bg-gray-100 outline-none py-1 px-3">
                        <span class="text-xs text-red-500" v-if="form.errors.has('name')"
                              v-text="form.errors.get('name')"></span>
                    </section>
                    <section class="flex flex-col flex-1 pl-2">
                        <label for="address" class="mb-2 text-sm font-bold">Address</label>
                        <input name="address" v-model="form.address" id="address" type="text"
                               class="bg-gray-100 outline-none py-1 px-3">
                        <span class="text-xs text-red-500" v-if="form.errors.has('address')"
                              v-text="form.errors.get('address')"></span>
                    </section>
                </div>
                <div class="flex mb-3">
                    <section class="flex flex-col flex-1 pr-2">
                        <label for="township" class="mb-2 text-sm font-bold">Township</label>
                        <input name="township" v-model="form.township" id="township" type="text"
                               class="bg-gray-100 outline-none py-1 px-3">
                        <span class="text-xs text-red-500" v-if="form.errors.has('township')"
                              v-text="form.errors.get('township')"></span>
                    </section>
                    <section class="flex flex-col flex-1 pl-2">
                        <label for="city" class="mb-2 text-sm font-bold">City</label>
                        <input name="city" v-model="form.city" id="city" type="text"
                               class="bg-gray-100 outline-none py-1 px-3">
                        <span class="text-xs text-red-500" v-if="form.errors.has('city')"
                              v-text="form.errors.get('city')"></span>
                    </section>
                </div>
                <div class="flex mb-3">
                    <section class="flex flex-col flex-1 pr-2">
                        <label for="region" class="mb-2 text-sm font-bold">Region</label>
                        <input name="region" v-model="form.region" id="region" type="text"
                               class="bg-gray-100 outline-none py-1 px-3">
                        <span class="text-xs text-red-500" v-if="form.errors.has('region')"
                              v-text="form.errors.get('region')"></span>
                    </section>
                    <section class="flex flex-col flex-1 pl-2">
                        <label for="phone" class="mb-2 text-sm font-bold">Phone</label>
                        <input name="phone" v-model="form.phone" id="phone" type="number"
                               class="bg-gray-100 outline-none py-1 px-3">
                        <span class="text-xs text-red-500" v-if="form.errors.has('phone')"
                              v-text="form.errors.get('phone')"></span>
                    </section>
                </div>
                <div class="flex mt-3">
                    <section class="flex flex-1">
                        <button type="submit" class="btn-full select-none bg-green-500 flex-1 mx-2" :class="form.errors.any() ? 'opacity-50' : ''"
                                :disabled="form.errors.any()">Save Address
                        </button>
                        <button type="button" class="btn-full select-none bg-red-500 flex-1 mx-2" @click="cancelAddAddress">Cancel</button>
                    </section>
                </div>
            </form>
        </div>

    </div>
</template>

<script>

class Errors {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.errors = {};
    }


    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */
    has(field) {
        if (this.any()) {
            return this.errors.errors.hasOwnProperty(field);
        }
        return false
    }


    /**
     * Determine if we have any errors.
     */
    any() {
        if (Object.keys(this.errors).length > 0) {
            return Object.keys(this.errors.errors).length > 0
        }
    }


    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */
    get(field) {
        if (this.any()) {
            return this.errors.errors[field][0];
        }
    }


    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors) {
        this.errors = errors;
    }


    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */
    clear(field) {
        if (this.any()) {
            if (field) {
                delete this.errors.errors[field]
                return;
            }

            this.errors = {};
        }
    }
}


class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }


    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }


    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data);

                    reject(error.response.data);
                });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}


export default {
    name: "addresses.vue",
    data() {
        return {
            addresses: [],
            show_add_address : false,

            form: new Form({
                name: '',
                address: '',
                phone: '',
                city: '',
                region: '',
                township: ''
            }),

        }
    },
    mounted() {
        this.fetchAddresses()
    },

    methods: {
        fetchAddresses() {
            axios.get('/api/addresses')
                .then(({data}) => {
                    this.addresses = data
                })
                .catch((e) => {
                    toastr.error(e.message, 'Error')
                })
        },
        save() {
            this.form.post('/api/addresses/create')
                .then((response) => {
                    this.addresses.push(response)
                    toastr.success('successfully added new address', 'Success')
                    this.show_add_address = false
                })
                .catch(e => {
                    console.log(e.message)
                })
        },
        cancelAddAddress() {
            this.show_add_address = false
            if(this.form.errors.any()) {
                this.form.errors.clear()
            }
        }
    }


}
</script>

<style scoped>
.edit-address {
    left: 50%;
    width: 100%;
    transform: translateX(-50%);
    top: 5%;
}
</style>
