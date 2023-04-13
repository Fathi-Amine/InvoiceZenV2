<template>
    <GuestLayout title="Request a password reset">
        <form class="mt-8 space-y-6" action="#" method="POST">
            <input type="hidden" name="remember" value="true" />
            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <label for="email-address" class="sr-only">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required=""
                        class="relative block w-full rounded border-0 py-1.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        placeholder="Email address" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <router-link :to="{ name: 'login' }" class="font-medium text-indigo-600 hover:text-indigo-500">I
                        have
                        my password</router-link>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                    </span>
                    Reset Password
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
  
<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid'
import GuestLayout from '../components/GuestLayout.vue';
</script>
<style scoped></style>