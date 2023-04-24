<template>
    <div class="flex items-center justify-between mb-3 animate-fade-in-down">
        <h1 class="text-3xl font-semibold">Users</h1>
        <button type="submit" @click="showUserModal"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-clr-primary bg-theme-primary hover:bg-indigo-500">
            Add User
        </button>
    </div>
    <UserModal v-model="showModal" :user="userModel" @close="onModalClose"></UserModal>
    <UsersTable @click-edit="editUser" />
</template>
<script setup>
import UsersTable from './UsersTable.vue';
import UserModal from './UserModal.vue';
import { ref } from 'vue';
import store from '../../store';

const showModal = ref(false);

const userModel = ref({
    id: '',
    name: '',
    email: '',
    password: '',

})

function showUserModal() {
    showModal.value = true;
}

function editUser(user) {
    store.dispatch('getAdminUser', user.id)
        .then(({ data }) => {
            userModel.value = data;
            showUserModal()
        })
}

function onModalClose() {
    userModel.value = {
        id: '',
        name: '',
        email: '',
        password: '',
    }
}

</script>
<style scoped></style>