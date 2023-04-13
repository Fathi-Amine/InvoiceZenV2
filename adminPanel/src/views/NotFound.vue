<template>
    <div class="flex min-h-full min-w-full justify-center items-center">
        <div class="flex">
            <div class="text-gray-700 text-5xl px-8 font-bold border-r leading-10">
                404
            </div>
            <div class="px-8">
                <h1 class="text-5xl font-bold mb-2">Page not found</h1>
                <p class="text-gray-400 mb-8">Please check the URL and try again</p>
                <div>
                    <router-link :to="{
                        name: 'app.dashboard'
                    }" class="rounded-md bg-theme-primary px-3 py-2 text-sm
                                    font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
                                    focus-visible:outline-offset-2 focus-visible:outline-theme-primary">Go
                        back home</router-link>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

</script>
<style scoped></style>