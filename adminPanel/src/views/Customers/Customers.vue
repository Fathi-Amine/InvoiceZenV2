<template>
    <div class="flex items-center justify-between mb-3 animate-fade-in-down">
        <h1 class="text-3xl font-semibold">Customers</h1>
    </div>
    <CustomerModal v-model="showModal" :customer="customerModel" @close="onModalClose"></CustomerModal>
    <CustomersTable @click-edit="editCustomer" />
</template>
<script setup>
import CustomersTable from './CustomersTable.vue';
import CustomerModal from './CustomerModal.vue';
import { ref } from 'vue';
import store from '../../store';

const showModal = ref(false);

const customerModel = ref({
    id: '',
    name: '',
    email: '',
    password: '',

})

function showCustomerModal() {
    showModal.value = true;
}

function editCustomer(customer) {
    store.dispatch('getAdminCustomer', customer.id)
        .then(({ data }) => {
            customerModel.value = data;
            showCustomerModal()
        })
}

function onModalClose() {
    customerModel.value = {
        id: '',
        name: '',
        email: '',
        password: '',
    }
}

</script>
<style scoped></style>