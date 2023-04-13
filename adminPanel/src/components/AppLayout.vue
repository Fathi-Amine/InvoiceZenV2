<template>
    <div class="flex min-h-full">
        <Sidebar></Sidebar>
        <div class="flex-1">
            <TopNavBar></TopNavBar>
            <main class="">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
<script setup>
import Sidebar from './Sidebar.vue';
import TopNavBar from './TopNavBar.vue';
</script>
<style></style>