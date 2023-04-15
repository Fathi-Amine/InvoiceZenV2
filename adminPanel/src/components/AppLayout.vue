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
        <Spinner />
    </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Sidebar from './Sidebar.vue';
import TopNavBar from './TopNavBar.vue';
import Spinner from './core/Spinner.vue';
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