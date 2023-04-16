<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Products</h1>
        <button type="submit"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-clr-primary bg-theme-primary hover:bg-indigo-500">
            Add Product
        </button>
    </div>
    <ProductsTable />
</template>
<script setup>
import ProductsTable from './ProductsTable.vue';




</script>
<style scoped></style>