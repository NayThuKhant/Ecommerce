<template>
    <div>
        <div class="tabs">
            <ul class="flex justify-center">
                <li v-for="tab in tabs" :class="{ 'is-active': tab.isActive }" class="block mx-5">
                    <a :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
                </li>
            </ul>
        </div>

        <hr class="h-2">

        <div class="tabs-details px-40">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "TabsComponent",
    data() {
        return {
            tabs: []
        }
    },

    created() {

        this.tabs = this.$children;

    },
    methods: {
        selectTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name == selectedTab.name);
            });
        }
    }
}
</script>

<style scoped>

</style>
