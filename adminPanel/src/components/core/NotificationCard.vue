<template>
    <div v-show="notification.show"
        class="fixed w-[500px] left-1/2 -ml-[200px] top-16 py-2 px-4 pb-4 bg-emerald-500 text-white">
        <div class="font-semibold">
            {{ notification.message }}
        </div>
        <button @click="close"
            class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Progress -->
        <div>
            <div class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10"></div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import store from '../../store';

const notification = computed(()=>store.state.notification)

function close(){
    store.commit('hideNotification')
}
</script>