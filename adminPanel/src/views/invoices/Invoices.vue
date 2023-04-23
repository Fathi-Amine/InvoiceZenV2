<template>
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Invoices</h1>
        <button type="submit" class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add Invoice
        </button>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Per Page</span>
                <select @change="getInvoices(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getInvoices(null)"
                    class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Type to Search invoices">
            </div>
        </div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <ThCell class="border-b-2 p-2 text-left" field="serial_number" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortInvoice">Serial</ThCell>
                        <ThCell class="border-b-2 p-2 text-left" field="due_date" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortInvoice">Due date</ThCell>
                        <ThCell class="border-b-2 p-2 text-left" field="" :sort-field="sortField"
                        :sort-direction="sortDirection">Product</ThCell>
                        <ThCell class="border-b-2 p-2 text-left" field="status" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortInvoice">Status</ThCell>
                        <ThCell class="border-b-2 p-2 text-left" field="total" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortInvoice">Total</ThCell>
                        <ThCell class="border-b-2 p-2 text-left" field="updated_at" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortInvoice">Last Updated at</ThCell>
                    </tr>
                </thead>
                <tbody  v-if="invoices.loading">
                    <tr>
                        <td colspan="6">
                            <Spinner class="my-2" v-if="invoices.loading"/>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr v-for="invoice of invoices.data">
                        <td class="border-b p-2">{{ invoice.serial_number }}</td>
                        <td class="border-b p-2">{{ invoice.due_date }}</td>
                        <td class="border-b p-2">{{ invoice.product_name}}</td>
                        <td class="border-b p-2">{{ invoice.status }}</td>
                        <td class="border-b p-2">{{ invoice.total }}</td>
                        <td class="border-b p-2">{{ invoice.updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        <div v-if="!invoices.loading" class="flex justify-between items-center mt-5">
            <span>
                Showing from {{ invoices.from }} to {{ invoices.to }}
            </span>
            <nav v-if="invoices.total > invoices.limit"
                class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <a v-for="(link, i) of invoices.links" :key="i" :disabled="!link.url" href="#"
                    @click.prevent="getForPage($event, link)" aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                    v-html="link.label" :class="[
                        link.active
                            ? 'z-10 bg-theme-primary text-clr-primary'
                            : 'bg-clr-primary border-gray-300 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === invoices.links.length - 1 ? 'rounded-r-m' : '',
                        !link.url ? 'bg-gray-100 text-gray-700' : ''
                    ]"></a>
            </nav>

        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import Spinner from '../../components/core/Spinner.vue';
import store from '../../store';
import { PRODUCTS_PER_PAGE } from '../../constants';
import ThCell from '../../components/core/table/ThCell.vue';
const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref("");
const sortField = ref("updated_at");
const sortDirection = ref("desc");

const invoices = computed(()=> store.state.invoices);
onMounted(()=>{
    getInvoices();
})

function getInvoices (url = null){
    store.dispatch('getInvoices', {
        url,
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
        search: search.value,
        perPage: perPage.value
    })
}

function getForPage(ev, link) {
    if (!link.url || link.active) {
        return
    }
    getInvoices(link.url)
}

function sortInvoice(field) {
    if (sortField.value === field) {
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc'
        } else {
            sortDirection.value = 'asc'
        }
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
    getInvoices();
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