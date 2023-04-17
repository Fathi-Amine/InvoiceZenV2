<template>
    <div class="flex items-center justify-between mb-3 animate-fade-in-down">
        <h1 class="text-3xl font-semibold">Products</h1>
        <button type="submit" @click="showProductModal"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-clr-primary bg-theme-primary hover:bg-indigo-500">
            Add Product
        </button>
    </div>
    <ProductModal v-model="showModal" :product="productModel" @close="onModalClose"></ProductModal>
    <ProductsTable @click-edit="editProduct" />
</template>
<script setup>
import ProductsTable from './ProductsTable.vue';
import ProductModal from './ProductModal.vue';
import { ref } from 'vue';
import store from '../../store';

const showModal = ref(false);

const productModel = ref({
    id: '',
    product_name: '',
    section_id: '',
    description: '',

})

function showProductModal() {
    showModal.value = true;
}

function editProduct(product) {
    store.dispatch('getProduct', product.id)
        .then(({ data }) => {
            productModel.value = data;
            showProductModal()
        })
}

function onModalClose() {
    productModel.value = {
        id: '',
        product_name: '',
        section_id: '',
        description: '',
    }
}

</script>
<style scoped></style>