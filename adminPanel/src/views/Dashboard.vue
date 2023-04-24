<template>
     <div class="mb-2 flex items-center justify-between">
    <h1 class="text-3xl font-semibold">Dashboard</h1>
    <div class="flex items-center">
      <label class="mr-2">Change Date Period</label>
      <CustomInput type="select" />
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <!--    Active Customers-->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label class="text-lg font-semibold block mb-2">Active Customers</label>
      <template >
        <span class="text-3xl font-semibold"></span>
      </template>
      <Spinner />
    </div>
    <!--/    Active Customers-->
    <!--    Active Products -->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
         <!-- style="animation-delay: 0.1s" -->
         
      <label class="text-lg font-semibold block mb-2">Invoices</label>
      <template >
        <span class="text-3xl font-semibold"></span>
      </template>
      <Spinner/>
    </div>
    
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
         <!-- style="animation-delay: 0.2s"> -->
      <label class="text-lg font-semibold block mb-2">Paid Invoices</label>
      <template >
        <span class="text-3xl font-semibold"></span>
      </template>
      <Spinner />
    </div>
    

    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center"
         style="animation-delay: 0.3s">
      <label class="text-lg font-semibold block mb-2">Total Income</label>
      <template>
        <span class="text-3xl font-semibold"></span>
      </template>
      <Spinner />
    </div>
    <!--/    Total Income -->
  </div>

  <div class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-3">
    <div class="col-span-1 md:col-span-2 row-span-1 md:row-span-2 bg-white py-6 px-5 rounded-lg shadow">
      <label class="text-lg font-semibold block mb-2"></label>
      <template >
        <div  class="py-2 px-3 hover:bg-gray-50">
          <p>
            <!-- <router-link  class="text-indigo-700 font-semibold">
               
            </router-link> -->
            
          </p>
          <p class="flex justify-between">
            <span></span>
            <span></span>
          </p>
        </div>
      </template>
      <Spinner/>
    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label class="text-lg font-semibold block mb-2">Invoices by Country</label>
      <template>
        <DoughnutChart />
      </template>
      <Spinner />
    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow">
      <label class="text-lg font-semibold block mb-2">Latest Customers</label>
      <template >
        <router-link 
                     class="mb-3 flex">
          <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
            <UserIcon class="w-5"/>
          </div>
          <div>
            <h3></h3>
            <p></p>
          </div>
        </router-link>
      </template>
      <Spinner />
    </div>
  </div>
</template>
<script setup>
import DoughnutChart from '../components/core/Charts/Doughnut.vue'
</script>
<style scoped></style>