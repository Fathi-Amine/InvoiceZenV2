<template>
    <div class="flex min-h-full">
        <Sidebar :class="{ '-ml-[200px]': !sidebarOpened }"></Sidebar>
        <div class="flex-1">
            <TopNavBar @toggle-sidebar="toggleSidebar"></TopNavBar>
            <main class="p-6">

                <router-view></router-view>

            </main>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Sidebar from './Sidebar.vue';
import TopNavBar from './TopNavBar.vue';

const sidebarOpened = ref(true)

function toggleSidebar() {
    sidebarOpened.value = !sidebarOpened.value
}

onMounted(() => {
    handleSidebar()

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