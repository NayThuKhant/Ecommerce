<template>
    <section class="bg-gray-900">
        <div class="container mx-auto py-12">
            <div class="flex content-between">
                <div class="w-1/4 mr-5 categories">
                    <ul class="rounded bg-white relative">
                        <li class="py-3 border-b border-gray-300 px-3 hover:bg-gray-100" v-for="category in firstCategories">
                            <router-link :to="{ name: 'category', params: { slug: category.slug }}" class="block">{{ category.name }}</router-link>
                        </li>
                        <li class="py-3 px-4" v-if="secondCategories.length != 0">More
                            <ul class="hidden rounded bg-white shadow w-full absolute top-0 h-full" style="left: 100%">
                                <li class="py-3 border-b border-gray-300 px-3 hover:bg-gray-100" v-for="category in secondCategories">
                                    <a href="#" class="block">{{ category.name }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <img src="images/banner.jpg" class="rounded" alt="Banner">
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "BannerComponent",
    data(){
        return {
            categories: []
        }
    },
    mounted() {
        this.fetchCategories();
    },
    methods:{
        fetchCategories() {
            axios.get('/api/categories')
            .then(({data}) => {
                this.categories = data
            })
            .catch((errors) => {
                console.log(errors.message)
            })
        }
    },
    computed:{
        firstCategories() {
            return this.categories.slice(0,6)
        },
        secondCategories() {
            return this.categories.slice(6)
        }


    }

}
</script>

<style scoped>

</style>
