<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <Spinner v-if="loading"
                                class="absolute left-0 top-0 bg-clr-primary right-0 bottom-0 flex items-center justify-center" />
                            <header class="py-3 px-4 flex justify-between items-center">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    {{ invoice.id ? `Update invoice: "${props.invoice.serial_number}"` : 'Create new Invoice'
                                    }}
                                </DialogTitle>
                                <button @click="closeModal()"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </header>
                             <form @submit.prevent="onSubmit">
                                <div class="bg-clr-primary px-4 pt-5 pb-4">
                                    <CustomInput class="mb-2" v-model="invoice.serial_number" label="Invoice Serial Number" />
                                    <small class="ml-1">Invoice Date</small>
                                    <CustomInput type="date" class="mb-2" v-model="invoice.invoice_Date"
                                        label="Invoice Date"/>
                                    <!-- <div>
                                        <label class="sr-only">Product:</label>
                                        <select id="product-select" v-model="invoice.product_id"
                                            class="block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-theme-primary focus:border-theme-primary focus:z-10 sm:text-sm rounded">
                                            <option value="">Select a Product</option>
                                            <option v-for="product in products.data" :key="product.id" :value="product.id">
                                                {{ product.name }}</option>
                                        </select>
                                    </div> -->
                                    <!-- <div>
                                        <label class="sr-only">Customer:</label>
                                        <select id="customer-select" v-model="invoice.customer_id"
                                            class="block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-theme-primary focus:border-theme-primary focus:z-10 sm:text-sm rounded">
                                            <option value="">Select a Customer</option>
                                            <option v-for="customer in customers.data" :key="customer.id" :value="customer.id">
                                                {{ customer.first_name }} {{ customer.last_name }}</option>
                                        </select>
                                    </div> -->
                                    <CustomInput type="number" class="mb-2" v-model="invoice.gross_price"
                                        label="Gross Price" />
                                    <CustomInput type="number" class="mb-2" v-model="invoice.discount"
                                    label="Discount" />
                                    <CustomInput type="number" class="mb-2" v-model="invoice.TVA"
                                        label="TVA" />
                                    <CustomInput type="number" class="mb-2" v-model="invoice.TVA_rate"
                                    label="TVA_rate" />
                                    <CustomInput type="number" class="mb-2" v-model="invoice.total"
                                    label="Total" />
                                    <CustomInput type="textarea" class="mb-2" v-model="invoice.note"
                                        label="Note" />
                                </div>
                                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit"
                                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-clr-primary bg-theme-primary hover:bg-theme-primary/10 hover:text-theme-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-theme-primary sm:ml-3 sm:w-auto ">
                                        Submit
                                    </button>
                                    <button type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-clr-primary text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-theme-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="closeModal" ref="cancelButtonRef">
                                        Cancel
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
  
<script setup>
import { computed, ref, onUpdated, onMounted } from 'vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import Spinner from '../../components/core/Spinner.vue';
import store from '../../store/index';
import CustomInput from '../../components/core/CustomInput.vue';
// import { getProducts } from '../../store/actions';

const loading = ref(false);

const invoice = ref({
    id: props.invoice.id,
    serial_number: props.invoice.serial_number,
    description: props.invoice.description,
    product_id: props.invoice.product_id,
    invoice_Date: props.invoice.invoice_Date,
    due_date: props.invoice.due_date,
    customer_id: props.invoice.customer_id,
    product_id: props.invoice.invoice_Date,
    status: props.invoice.status,
    gross_price: props.invoice.gross_price,
    discount: props.invoice.discount,
    TVA: props.invoice.TVA,
    TVA_rate: props.invoice.TVA_rate,
    total: props.invoice.total,
    note: props.invoice.note,
    payment_date: props.invoice.invoice_Date,
})

// const products = computed(() => store.state.products)

const props = defineProps({
    modelValue: Boolean,
    invoice: {
        required: true,
        type: Object,
    }
})

const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})
// onMounted(() => {
//     // getProducts();
//     getCustomers();
// })

onUpdated(() => {
    invoice.value = {
        id: props.invoice.id,
        serial_number: props.invoice.serial_number,
        description: props.invoice.description,
        product_id: props.invoice.product_id,
        invoice_Date: props.invoice.invoice_Date,
        due_date: props.invoice.due_date,
        customer_id: props.invoice.customer_id,
        product_id: props.invoice.invoice_Date,
        status: props.invoice.status,
        gross_price: props.invoice.gross_price,
        discount: props.invoice.discount,
        TVA: props.invoice.TVA,
        TVA_rate: props.invoice.TVA_rate,
        total: props.invoice.total,
        note: props.invoice.note,
        payment_date: props.invoice.invoice_Date,
    }
})
function closeModal() {
    show.value = false
    emit('close')
}

function onSubmit() {
    loading.value = true;
    if (invoice.value.id) {
        store.dispatch('updateInvoice', invoice.value)
            .then(response => {
                loading.value = false;
                if (response.status === 200) {
                    store.dispatch('getInvoices');
                    closeModal();
                }
            })
    } else {
        store.dispatch('createInvoice', invoice.value)
            .then(response => {
                loading.value = false;
                if (response.status === 201) {
                    store.dispatch('getInvoices');
                    closeModal();
                }
            })
    }
}

// function getProducts() {
//     store.dispatch('getProducts');
// }

// function getCustomers(){
//     store.dispatch('getCustomers');

// }

</script>
  
<style scoped></style>