<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { useForm } from '@inertiajs/vue3'

const form = useForm({
    first_name: null,
    last_name: null,
    email: null,
    phone: null,
})
</script>

<template>
    <Head title="Create Staff" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Add Staff
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="form.post(route('staff.store'))" class="max-w-xl mx-auto">
                            <h2 class="font-bold mb-5 text-lg">Add new staff member</h2>

                            <div class="mb-5">
                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name*</label>
                                <input type="text" id="first_name" v-model="form.first_name" class="form-input" required />
                                <div v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
                            </div>

                            <div class="mb-5">
                                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name*</label>
                                <input type="text" id="last_name" v-model="form.last_name" class="form-input" required />
                            </div>

                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email*</label>
                                <input type="email" id="email" v-model="form.email" class="form-input" required />
                            </div>

                            <div class="mb-5">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input type="text" id="phone" v-model="form.phone" class="form-input" />
                            </div>

                            <button type="submit" class="form-submit">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
