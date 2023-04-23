<template>
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
                        <ThCell class="border-b-2 p-2 text-left" field="actions">Operations</ThCell>
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
                        <td class="border-b p-2 ">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex justify-center w-full items-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
                                    <EllipsisVerticalIcon class="h-5 w-5 text-indigo-500" aria-hidden="true" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0">
                                <MenuItems
                                    class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <router-link :to="{name: 'app.invoices.view', params:{id: invoice.id}}" :class="[
                                                active ? 'bg-theme-primary text-clr-primary' : 'text-indigo-600',
                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                            ]" @click="viewInvoice(invoice)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                                </svg>

                                                View
                                            </router-link>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-theme-primary text-clr-primary' : 'text-indigo-600',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="editInvoice(invoice)">
                                            <PencilIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true" />
                                            Edit
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-theme-primary text-clr-primary' : 'text-red-500',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="deleteInvoice(invoice)">
                                            <TrashIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true" />
                                            Delete
                                        </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </td>
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
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid'

const emit = defineEmits(['clickEdit', 'clickView'])
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

function editInvoice(invoice){
    emit('clickEdit',invoice)
}

function viewInvoice(invoice){
    emit('clickView',invoice)
}

function deleteInvoice(invoice){
    if(!confirm('Are you sure You want to delete?')){
        return 
    }
    console.log(invoice);
    store.dispatch('deleteInvoice', invoice.id)
    .then(res=>{
        store.dispatch('getInvoices')

    })
}
</script>

<!-- <script setup>
import Spinner from '../../components/core/Spinner.vue';
import { computed, onMounted, ref } from 'vue';
import store from '../../store/index';
import { PRODUCTS_PER_PAGE } from '../../constants'
import ThCell from '../../components/core/table/ThCell.vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid'

const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref("");
const sortField = ref("updated_at");
const sortDirection = ref("desc");
const products = computed(() => store.state.products);
const emit = defineEmits(['clickEdit'])

onMounted(() => {
    getProducts();
})

function getProducts(url = null) {
    store.dispatch('getProducts', {
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
    getProducts(link.url)
}

function sortProduct(field) {
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
    getProducts();
}

function editProduct(product) {
    emit('clickEdit', product)
}

function deleteProduct(product) {
    if (!confirm('Are you sure you want to delete the product?')) {
        return
    }
    store.dispatch('deleteProduct', product.id)
        .then(() => {
            store.dispatch('getProducts')
        })
}
</script> -->
<style scoped></style>