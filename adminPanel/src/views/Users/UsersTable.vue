<template>
    <div class="bg-clr-primary p-4 rounded-lg shadow">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3"> Per Page</span>
                <select @change="getUsers(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getUsers(null)"
                    class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Type to Search users">
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <ThCell class="border-b-2 p-2 text-left" field="id" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortUser">ID</ThCell>
                    <ThCell class="border-b-2 p-2 text-left" field="name" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortUser">Name</ThCell>
                    <ThCell class="border-b-2 p-2 text-left" field="email" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortUser">Email</ThCell>
                    <ThCell class="border-b-2 p-2 text-left" field="created_at" :sort-field="sortField"
                        :sort-direction="sortDirection" @click="sortUser">Created at</ThCell>
                    <ThCell class="border-b-2 p-2 text-left" field="actions">Operations</ThCell>
                </tr>
            </thead>
            <tbody v-if="users.loading">
                <tr>
                    <td colspan="5">
                        <Spinner class="my-4" />
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="(user, index) of users.data" class="animate-fade-in-down"
                    :style="{ 'animation-delay': `${index * 0.2}s` }">
                    <td class="border-b p-2">{{ user.id }}</td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{
                            user.name }}</td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{
                    user.email }}</td>
                    <td class="border-b p-2">{{ user.created_at }}</td>
                    <td class="border-b p-2">
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
                                    class="absolute bottom-0 z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-theme-primary text-clr-primary' : 'text-indigo-600',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="editUser(user)">
                                            <PencilIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true" />
                                            Edit
                                        </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <button :class="[
                                            active ? 'bg-theme-primary text-clr-primary' : 'text-red-500',
                                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                        ]" @click="deleteUser(user)">
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
        <div v-if="!users.loading" class="flex justify-between items-center mt-5">
            <span>
                Showing from {{ users.from }} to {{ users.to }}
            </span>
            <nav v-if="users.total > users.limit"
                class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <a v-for="(link, i) of users.links" :key="i" :disabled="!link.url" href="#"
                    @click.prevent="getForPage($event, link)" aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                    v-html="link.label" :class="[
                        link.active
                            ? 'z-10 bg-theme-primary text-clr-primary'
                            : 'bg-clr-primary border-gray-300 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === users.links.length - 1 ? 'rounded-r-m' : '',
                        !link.url ? 'bg-gray-100 text-gray-700' : ''
                    ]"></a>
            </nav>

        </div>
    </div>
</template>
<script setup>
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
const users = computed(() => store.state.users);
const emit = defineEmits(['clickEdit'])

onMounted(() => {
    getUsers();
})

function getUsers(url = null) {
    store.dispatch('getUsers', {
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
    getUsers(link.url)
}

function sortUser(field) {
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
    getUsers();
}

function editUser(user) {
    emit('clickEdit', user)
}

function deleteUser(user) {
    if (!confirm('Are you sure you want to delete the user?')) {
        return
    }
    store.dispatch('deleteUser', user.id)
        .then(() => {
            store.dispatch('getUsers')
        })
}
</script>
<style scoped></style>