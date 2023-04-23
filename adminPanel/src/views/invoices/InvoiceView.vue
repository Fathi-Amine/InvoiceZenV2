<template>
    {{invoice}}
</template>
<script setup>
import { computed, onMounted } from 'vue';
import store from '../../store';
import { useRoute } from 'vue-router';

const route = useRoute()


// const invoices = computed(()=> store.state.invoices)

onMounted(()=>{
    store.dispatch('getInvoice', route.params.id)
})
</script>