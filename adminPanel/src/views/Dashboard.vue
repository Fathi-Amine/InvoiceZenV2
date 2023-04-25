<template>
    <div class="mb-2 flex items-center justify-between">
   <h1 class="text-3xl font-semibold">Dashboard</h1>
   <div class="flex items-center">
     <label class="mr-2">Change Date Period</label>
     <!-- <CustomInput type="select" /> -->
   </div>
 </div>
 <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
   <!--    Active Customers-->
   <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
       <template v-if="!loading.totalCustomers">
         <label class="text-lg font-semibold block mb-2">Active Customers</label>
         <span class="text-3xl font-semibold">{{ totalCustomers }}</span>
       
     </template>
     <Spinner v-else/>
   </div>
   <!--/    Active Customers-->
   <!--    Active Products -->
   <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
        <!-- style="animation-delay: 0.1s" -->

        <template v-if="!loading.invoicesCount">
         <label class="text-lg font-semibold block mb-2">Invoices</label>
         <span class="text-3xl font-semibold">{{ invoicesCount }}</span>
       
     </template> 
     <Spinner v-else/>
   </div>

   <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
        <!-- style="animation-delay: 0.2s"> -->
        <template v-if="!loading.paidInvoicesCount">
         <label class="text-lg font-semibold block mb-2">Paid Invoices</label>
         <span class="text-3xl font-semibold">{{ paidInvoicesCount }}</span>
    
     </template>
     <Spinner v-else/>
   </div>


   <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
        style="animation-delay: 0.3s">
        <template v-if="!loading.collectedAmount">
         <label class="text-lg font-semibold block mb-2">Total Income</label>
         <span class="text-3xl font-semibold">{{ collectedAmount }}</span>
      
     </template>
     <Spinner v-else/>
   </div>
   <!--/    Total Income -->
 </div>

 <div class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-3">
   <div class="col-span-1 md:col-span-2 row-span-1 md:row-span-2 bg-white py-6 px-5 rounded-lg shadow">
     <label class="text-lg font-semibold block mb-2">Latest Invoices</label>
     <div v-for="invoice of latestInvoices" :key="invoice.id"  class="py-2 px-3 hover:bg-gray-50">
       <p class="flex justify-between">
           <span>Customer: {{ invoice.name }}</span>
           <span> Total: {{ invoice.total }} </span>
       </p>
       <p class="flex justify-between">
         <span>Product: {{ invoice.product_name }} </span>
         <span>Date: {{ invoice.created_at }}</span>
       </p>
     </div>
     <template >
     </template>
     <!-- <Spinner/> -->
   </div>
   <div class="bg-white py-6 px-5 rounded-lg shadow">
     <label class="text-lg font-semibold block mb-2">Latest Customers</label>
     <div v-for="customer of latestCustomers" :key="customer.id" class="flex items-center">
        <div class="w-8 h-8 bg-gray-200 flex items-center justify-center rounded-full mr-2">
            <UserIcon class="w-5 h-5"/>
        </div>
        <div>
            <h3>{{ customer.first_name }} {{ customer.last_name }}</h3>
            <p>{{ customer.email }}</p>
        </div>
    </div>
     <template >
       <!-- <router-link  -->
                    <!-- class="mb-3 flex"> -->
         <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
           
         </div>
         <div>
           <h3>{{ latestCustomers }}</h3>
           <p></p>
         </div>
       <!-- </router-link>  -->
     </template>
     <!-- <Spinner /> -->
   </div>
 </div>
</template>
<script setup>
import { ref } from 'vue';
import axiosClient from '../axios.js'
import CustomInput from '../components/core/CustomInput.vue'
import Spinner from '../components/core/Spinner.vue'
import { UserIcon, DocumentTextIcon} from '@heroicons/vue/20/solid'



const loading = ref({
    totalCustomers: true,
    invoicesCount: true,
    paidInvoicesCount: true,
    collectedAmount: true,
    latestCustomers: true,
    latestInvoices: true
})
const totalCustomers = ref(0)
const invoicesCount = ref(0)
const paidInvoicesCount = ref(0)
const collectedAmount = ref(0)
const latestCustomers = ref([])
const latestInvoices = ref([])

axiosClient.get('/dashboard/total-customers').then(({data}) => {
    totalCustomers.value = data
    loading.value.totalCustomers = false
})
axiosClient.get('/dashboard/invoices-count').then(({data}) => {
    invoicesCount.value = data
    loading.value.invoicesCount = false
})
axiosClient.get('/dashboard/paidInvoices-count').then(({data}) => {
    paidInvoicesCount.value = data
    loading.value.paidInvoicesCount = false
})
axiosClient.get('/dashboard/income-amount').then(({data}) => {
    collectedAmount.value = new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'})
      .format(data);
    loading.value.collectedAmount = false
})

axiosClient.get('/dashboard/latest-customers').then(({data : customers}) => {

    latestCustomers.value = customers
    loading.value.latestCustomers = false
})

axiosClient.get('/dashboard/latest-invoices').then(({data : invoices}) => {

latestInvoices.value = invoices
loading.value.latestInvoices = false
})
</script>
<style scoped></style>