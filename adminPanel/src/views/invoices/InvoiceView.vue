<template>
    <h1 class="font-bold text-2xl">Invoice Details</h1>
    <div class="flex justify-between">
        <table>
                    <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Invoice #</td>
                        <td>{{invoice.serial_number}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Invoice Date</td>
                        <td>{{ invoice.invoice_Date }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Invoice Status</td>
                        <td>
                            <select v-model="invoice.status" @change="onStatusChange">
                                <option v-for="status of invoiceStatuses" :value="status">{{ status }}</option>
                            </select>
                            <!-- <span
                                class="text-white py-1 px-2 rounded"
                                :class="{'bg-emerald-500' : invoice.status === 'paid',
                                'bg-gray-500' : invoice.status !== 'paid'}">
                                {{ invoice.status }}
                            </span> -->
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Total</td>
                        <td>{{ invoice.total }}</td>
                    </tr>
                    </tbody>
                </table>

                <table>
                    <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Gross price</td>
                        <td>{{ invoice.gross_price }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Discount</td>
                        <td>{{ invoice.discount }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">TVA</td>
                        <td>
                           {{ invoice.TVA }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">TVA rate</td>
                        <td>
                           {{ invoice.TVA_rate }}%
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Product</td>
                        <td>{{ invoice.product_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Customer</td>
                        <td v-if="invoice.customer">{{ invoice.customer.first_name }} {{ invoice.customer.last_name }}</td>
                    </tr>
                    </tbody>
                </table>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
                <table>
                    <tbody>
                        <tr>
  <td class="font-bold py-1 px-2">Customer</td>
  <td v-if="invoice.customer">{{ invoice.customer.first_name }} {{ invoice.customer.last_name }}</td>
</tr>
<tr v-if="invoice.customer && invoice.customer.email">
  <td class="font-bold py-1 px-2">Email</td>
  <td>{{ invoice.customer.email }}</td>
</tr>
<tr v-if="invoice.customer && invoice.customer.phone">
  <td class="font-bold py-1 px-2">Phone</td>
  <td>{{ invoice.customer.phone }}</td>
</tr>
<tr v-if="invoice.customer && invoice.customer.invoiceAddress">
  <td class="font-bold py-1 px-2">Invoice Address</td>
  <td>{{ invoice.customer.invoiceAddress.address1 }}, {{ invoice.customer.invoiceAddress.address2 }}, {{ invoice.customer.invoiceAddress.city }}, {{ invoice.customer.invoiceAddress.state }} {{ invoice.customer.invoiceAddress.zipcode }}, {{ invoice.customer.invoiceAddress.country }}</td>
</tr>
<tr v-if="invoice.customer && invoice.customer.billingAddress">
  <td class="font-bold py-1 px-2">Billing Address</td>
  <td>{{ invoice.customer.billingAddress.address1 }}, {{ invoice.customer.billingAddress.address2 }}, {{ invoice.customer.billingAddress.city }}, {{ invoice.customer.billingAddress.state }} {{ invoice.customer.billingAddress.zipcode }}, {{ invoice.customer.billingAddress.country }}</td>
</tr>

                    </tbody>
                </table>
    </div>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue';
import store from '../../store';
import { useRoute } from 'vue-router';
import axiosClient from '../../axios';

const route = useRoute()

const invoice = ref({})
const invoiceStatuses = ref([])

// const invoices = computed(()=> store.state.invoices)

onMounted(()=>{
    store.dispatch('getInvoice', route.params.id)
    .then(({data})=>{
        invoice.value = data
    })
    axiosClient.get('invoice/statuses')
    .then(({data}) => {
        invoiceStatuses.value = data
    })
})

function onStatusChange(){
    axiosClient.post(`invoice/change-status/${invoice.value.id}/${invoice.value.status}`)
    .then(({data}) => {
        console.log("Success");
    })
}
</script>