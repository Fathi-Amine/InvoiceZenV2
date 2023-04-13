<template>
    <div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <!-- <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Your Company" /> -->
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">{{ title }}</h2>
            </div>
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
const { title } = defineProps({
    title: String,
})
</script>