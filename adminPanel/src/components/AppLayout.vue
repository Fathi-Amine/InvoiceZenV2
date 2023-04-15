<template>
    <div v-if="currentUser.id" class="flex min-h-full">
        <Sidebar :class="{ '-ml-[200px]': !sidebarOpened }"></Sidebar>
        <div class="flex-1">
            <TopNavBar @toggle-sidebar="toggleSidebar"></TopNavBar>
            <main class="p-6">

                <router-view></router-view>

            </main>
        </div>
    </div>
    <div v-else class="min-h-full flex justify-center items-center">
        <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-theme-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Sidebar from './Sidebar.vue';
import TopNavBar from './TopNavBar.vue';
import store from '../store';
import { computed } from '@vue/reactivity';


const sidebarOpened = ref(true)

function toggleSidebar() {
    sidebarOpened.value = !sidebarOpened.value
}
const currentUser = computed(() => {
    return store.state.user.data
})
onMounted(() => {
    store.dispatch('getUser');
    handleSidebar();

    window.addEventListener('resize', handleSidebar)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleSidebar)
})
function handleSidebar() {

    if (window.outerWidth <= 768) {
        sidebarOpened.value = false
    } else {
        sidebarOpened.value = true
    }
}
</script>
<style></style>