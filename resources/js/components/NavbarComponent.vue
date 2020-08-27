<template>
    <section class="border border-gray-400 pb-5">
        <div class="nav-bar mt-4 container mx-auto">
            <div class="flex items-center justify-between">
                <img src="images/logo.png" alt="logo">
                <div class="search w-2/5 flex" style="height: 2.25rem">
                    <input type="text"
                           class="border border-gray-400 text-gray-800 placeholder-gray-700 font-semibold rounded-l w-full text-sm appearance-none focus:outline-none focus:shadow-outline px-4 py-2 leading-tight"
                           placeholder="Search"
                    >
                    <button class="bg-indigo-500 text-white text-lg block px-3 rounded-r hover:bg-indigo-600"><i
                        class="las la-search"></i></button>
                </div>
                <div class="flex">
                    <button class="rounded-icon"><i class="las la-shopping-bag"></i></button>
                    <button class="rounded-icon ml-4"><i class="lar la-user"></i></button>

                    <div class="flex flex-col ml-3">
                        <p class="text-gray-600 text-sm">Welcome!</p>
                        <div class="text-sm">
                            <a href="#" class="link">Sign in</a>
                            <span>|</span>
                            <a href="#" class="link">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "NavbarComponent"
}
</script>
