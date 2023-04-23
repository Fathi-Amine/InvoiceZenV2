<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Invoices</h1>
        <button @click="showInvoiceModal" type="submit" 
        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add Invoice
        </button>
    </div>
    <InvoicesTable @click-edit="editInvoice" @click-view="viewInvoice"/>
    <InvoiceModal v-model="showModal" :invoice="invoiceModel" @close="onModalClose"/>
</template>

<script setup>
import InvoicesTable from "./InvoicesTable.vue";
import InvoiceModal from "./InvoiceModal.vue";
import { ref } from "vue";
import store from "../../store";

const showModal = ref(false);

const invoiceModel = ref({
    id: '',
    serial_number: '',
    invoice_Date: '',
    due_date: '',
    customer_id: '',
    product_id: '',
    status: '',
    gross_price: '',
    discount: '',
    TVA:'',
    TVA_rate: '',
    total: '',
    note: '',
    payment_date: '',

})

function showInvoiceModal(){
    showModal.value = true
}

function editInvoice(invoice){
    store.dispatch('getInvoice', invoice.id)
    .then(({data})=>{
        invoiceModel.value = data
        showInvoiceModal()
    })
}

function viewInvoice(invoice){
    console.log(invoice);
}

function onModalClose(){
    invoiceModel.value = {
        id: '',
        serial_number: '',
        invoice_Date: '',
        due_date: '',
        customer_id: '',
        product_id: '',
        status: '',
        gross_price: '',
        discount: '',
        TVA:'',
        TVA_rate: '',
        total: '',
        note: '',
        payment_date: '',
    }
}
</script>


<!-- <template>
    <div class="flex items-center justify-between mb-3 animate-fade-in-down">
        <h1 class="text-3xl font-semibold">Invoices</h1>
        <button type="submit" @click="showInvoiceModal"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-clr-primary bg-theme-primary hover:bg-indigo-500">
            Add Invoice
        </button>
    </div>
    <InvoiceModal v-model="showModal" :product="invoiceModel" @close="onModalClose"></InvoiceModal>
    <InvoicesTable @click-edit="editInvoice" />
</template>
<script setup>
import InvoicesTable from './InvoicesTable.vue';
import InvoiceModal from './InvoiceModal.vue';

import store from '../../store';

const showModal = ref(false);



function showInvoiceModal() {
    showModal.value = true;
}

function editInvoice(Invoice) {
    store.dispatch('getInvoice', invoice.id)
        .then(({ data }) => {
            invoiceModel.value = data;
            showInvoiceModal()
        })
}

function onModalClose() {
    productModel.value = {
    id: '',
    serial_number: '',
    invoice_Date: '',
    due_date: '',
    customer_id: '',
    product_id: '',
    status: '',
    gross_price: '',
    discount: '',
    TVA_rate: '',
    total: '',
    note: '',
    payment_date: '',
    }
}

</script>
<style scoped></style> -->