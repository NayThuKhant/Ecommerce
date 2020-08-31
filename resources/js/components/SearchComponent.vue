<template>
    <div class="search w-2/5 flex relative" style="height: 2.25rem">
        <input type="text"
               class="border border-gray-400 text-gray-800 placeholder-gray-700 bg-gray-100 font-semibold rounded-l w-full text-sm appearance-none focus:outline-none focus:shadow-outline px-4 py-2 leading-tight"
               placeholder="Search"
               v-model="keyword"
               @keyup="debouncedFetch"
        >
        <button class="bg-indigo-500 text-white text-lg block px-3 rounded-r hover:bg-indigo-600">
            <i class="las la-search"></i></button>

        <div class="w-full absolute shadow-lg" style="top:100%" v-if="results.length && keyword !== '' && searchBoxActive" v-on-clickaway="clickaway">
            <ul class="w-100 bg-white">
                <li @click="clearSearch" v-for="result in results" :key="result.id"><router-link :to="{name: 'product.show', params: {id: result.id}}" class="search-item">{{ result.name }}</router-link></li>
            </ul>
        </div>
    </div>
</template>

<script>
import _ from 'underscore';
import { mixin as clickaway } from 'vue-clickaway';
export default {
    name: "SearchComponent",
    mixins: [clickaway],
    data() {
        return {
            keyword: "",
            results: [],
            searchBoxActive: false
        }
    },
    methods: {
        debouncedFetch: _.debounce(
            function(){
                this.fetchResults()
            }, 500),

        fetchResults() {
            if (this.keyword === "") {
                return;
            }
            axios.get(`/api/search?q=${this.keyword}`)
            .then(({data}) => {
                this.results = data
                this.searchBoxActive = true
            })
            .catch(e => {
                console.log(e.message);
            })
        },
        clickaway() {
            this.searchBoxActive = false
        },
        clearSearch() {
            this.searchBoxActive = false
            this.keyword = ""
        }
    }
}
</script>

<style scoped>

</style>
