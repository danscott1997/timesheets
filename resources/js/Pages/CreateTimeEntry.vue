<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link} from "@inertiajs/vue3";
import { Head } from '@inertiajs/vue3';

import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    staff: Object,
    date: String,
    formattedDate: String,
    timeEntry: Object,
    timesheetLink: String,
});

const form = useForm({
    clocked_in: props.timeEntry?.clocked_in,
    clocked_out: props.timeEntry?.clocked_out,
    staff_id: props.staff?.id,
    selectedDate: props.date,
});

function submitForm() {
    form.post(route('time-entries.store'));
}
</script>

<template>
    <Head title="Add Time Entry" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Add Time Entry
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-show="form.wasSuccessful" class="max-w-xl mx-auto mb-4">
                            <span class="font-bold text-green-500">Time entry created successfully</span>
                        </div>

                        <div v-show="form.hasErrors" class="max-w-xl mx-auto mb-4">
                            <template v-for="error in form.errors">
                                <span class="font-bold text-red-500" v-text="error"></span>
                            </template>
                        </div>

                        <a :href="timesheetLink" class="back-button">
                            Back to timesheet
                        </a>


                        <form @submit.prevent="submitForm()" class="max-w-xl mx-auto">
                            <h2 class="font-bold mb-5 text-lg">
                                <span v-text="(timeEntry ? 'Updating' : 'Creating')"></span>
                                time entry for {{ staff.full_name }} on {{ formattedDate }}
                            </h2>

                            <div class="mb-5">
                                <label for="clocked_in_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Clocked In*</label>
                                <input type="time" id="clocked_in" v-model="form.clocked_in" class="form-input" required />
                                <div v-if="form.errors.clocked_in">{{ form.errors.clocked_in }}</div>
                            </div>

                            <div class="mb-5">
                                <label for="clocked_in_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Clocked Out*</label>
                                <input type="time" id="clocked_out_at" v-model="form.clocked_out" class="form-input" required />
                                <div v-if="form.errors.clocked_out">{{ form.errors.clocked_out }}</div>
                            </div>

                            <input type="hidden" name="staff" v-model="form.staff_id">
                            <input type="hidden" name="selectedDate" v-model="form.date">

                            <button type="submit" class="form-submit">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
