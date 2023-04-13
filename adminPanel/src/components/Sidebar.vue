<template>
    <div class="w-[200px] bg-theme-primary rounded-l-lg text-clr-primary py-4 px-2">
        <router-link :to="{ name: 'app.dashboard' }"
            class="flex items-center hover:bg-clr-primary hover:text-theme-primary py-1 px-3 rounded">
            <span class="mr-2">
                <HomeIcon class="w-5" />
            </span>
            <span class="text-sm">Dashboard</span>
        </router-link>
        <router-link :to="{ name: 'app.dashboard' }"
            class="flex items-center hover:bg-clr-primary hover:text-theme-primary py-1 px-3 rounded">
            <span class="mr-2">
                <ListBulletIcon class="w-5" />
            </span>
            <span class="text-sm">Products</span>
        </router-link>
        <router-link :to="{ name: 'app.dashboard' }"
            class="flex items-center hover:bg-clr-primary hover:text-theme-primary py-1 px-3 rounded">
            <span class="mr-2">
                <RectangleStackIcon class="w-5" />
            </span>
            <span class="text-sm">Sections</span>
        </router-link>
        <router-link :to="{ name: 'app.dashboard' }"
            class="flex items-center hover:bg-clr-primary hover:text-theme-primary py-1 px-3 rounded">
            <span class="mr-2">
                <DocumentTextIcon class="w-5" />
            </span>
            <span class="text-sm">Invoices</span>
        </router-link>
        <router-link :to="{ name: 'app.dashboard' }"
            class="flex items-center hover:bg-clr-primary hover:text-theme-primary py-1 px-3 rounded">
            <span class="mr-2">
                <UserGroupIcon class="w-5" />
            </span>
            <span class="text-sm">Users</span>
        </router-link>

        <router-link :to="{ name: 'app.dashboard' }"
            class="flex items-center hover:bg-clr-primary hover:text-theme-primary py-1 px-3 rounded">
            <span class="mr-2">
                <ChartBarIcon class="w-5" />
            </span>
            <span class="text-sm">Reports</span>
        </router-link>
    </div>
</template>
<script setup>
import { HomeIcon, ListBulletIcon, RectangleStackIcon, UserGroupIcon, ChartBarIcon, DocumentTextIcon } from '@heroicons/vue/20/solid'
</script>
<style></style>