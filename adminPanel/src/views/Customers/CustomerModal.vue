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
                                    {{ customer.id ? `Update customer: "${props.customer.name}"` : ''
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
                                <!-- <pre>{{ sections }}</pre> -->
                                <div class="bg-clr-primary px-4 pt-5 pb-4">
                                    <CustomInput class="mb-2" v-model="customer.first_name" label="First Name" />
                                    <CustomInput class="mb-2" v-model="customer.last_name" label="Last Name" />
                                    
                                    <CustomInput class="mb-2" v-model="customer.email"
                                        label="Email" />
                                    <CustomInput class="mb-2" v-model="customer.phone" label="Phone" />


                                    <CustomInput class="mb-2" v-model="customer.status"
                                    label="Status" />
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

const loading = ref(false);

const customer = ref({
    id: props.customer.id,
    first_name: props.customer.first_name,
    last_name: props.customer.last_name,
    email: props.customer.email,
    phone: props.customer.phone,
    status: props.customer.status,
})

const props = defineProps({
    modelValue: Boolean,
    customer: {
        required: true,
        type: Object,
    }
})

const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

onUpdated(() => {
    customer.value = {
        id: props.customer.id,
        first_name: props.customer.first_name,
        last_name: props.customer.last_name,
        email: props.customer.email,
        phone: props.customer.phone,
        status: props.customer.status,
    }
})
function closeModal() {
    show.value = false
    emit('close')
}

function onSubmit() {
    loading.value = true;
    if (customer.value.id) {
        store.dispatch('updateCustomer', customer.value)
            .then(response => {
                loading.value = false;
                if (response.status === 200) {
                    store.dispatch('getCustomers');
                    closeModal();
                }
            })
    } else {
        store.dispatch('createCustomer', customer.value)
            .then(response => {
                loading.value = false;
                if (response.status === 201) {
                    store.dispatch('getCustomers');
                    closeModal();
                }
            })
    }
}


</script>
  
<style scoped></style>