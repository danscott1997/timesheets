<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

defineProps({
    timesheet: Object,
    years: Array,
    months: Array,
    staff: Object,
    selectedStaff: String,
    selectedMonth: String,
    selectedYear: [String, Number],
});

function chunkByWeek(data) {
    const chunks = []
    const dataArray = Object.values(data);

    for (let i = 0; i < dataArray.length; i += 7) {
        const week = dataArray.slice(i, i + 7);
        chunks.push(week);
    }

    return chunks;
}
</script>

<template>
    <Head title="Timesheet"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Timesheet
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 text-gray-200">
                <div class="flex gap-8 mb-4">
                    <form method="GET" :action="route('timesheet.index')" class="flex gap-6">
                        <div class="flex flex-col">
                            <label for="staff">Staff</label>
                            <select name="staff" class="bg-transparent w-60 my-2">
                                <template v-for="staffMember in staff">
                                    <option :value="staffMember.id" :selected="selectedStaff == staffMember.id" v-text="staffMember.full_name"></option>
                                </template>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label for="month">Month</label>
                            <select name="month" class="bg-transparent w-28 my-2">
                                <template v-for="month in months">
                                    <option :value="month" :selected="selectedMonth == month" v-text="month"></option>
                                </template>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label for="year">Year</label>
                            <select name="year" class="bg-transparent w-24 my-2">
                                <template v-for="year in years">
                                    <option :value="year" :selected="selectedYear == year" v-text="year"></option>
                                </template>
                            </select>
                        </div>

                        <div class="flex flex-col justify-end">
                            <button type="submit"
                                    class="text-white w-32 bg-gray-800 hover:bg-gray-900 font-medium rounded-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                Filter
                            </button>
                        </div>
                    </form>

                    <div class="flex flex-col justify-end ml-auto">
                        <a :href="route('timesheet.index')">
                            <button
                                    class="text-white w-32 bg-gray-800 hover:bg-gray-900 font-medium rounded-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                Reset
                            </button>
                        </a>
                    </div>

<!--                    <div class="flex flex-col ml-auto">-->
<!--                        <label for="file_input">Upload CSV</label>-->
<!--                        <input disabled id="file_input"-->
<!--                               type="file"-->
<!--                               class="block w-full my-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">-->
<!--                    </div>-->
                </div>


                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div v-for="(data, month) in timesheet" :key="month">
                        <h2 class="text-xl p-8 font-extrabold">{{ selectedMonth }} {{ selectedYear }}</h2>
                        <div>
                            <table class="timesheet w-full bg-grey-700 mb-4">
                                <thead>
                                <tr>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                    <th>Sun</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(week, rowIndex) in chunkByWeek(data)" :key="rowIndex">
                                    <td
                                        v-for="(item, colIndex) in week"
                                        :key="colIndex"
                                        align="center"
                                        class="timesheet-day"
                                        :class="item.custom_classes"
                                    >
                                        <a :href="route('time-entries.create', {staff: selectedStaff, date: item.date})">
                                            <div class="flex flex-col">
                                                <p>{{ item.day }}</p>

                                                <div class="text-xs mt-2">
                                                    <template v-if="item.disabled || item.weekend">
                                                        <p>-</p>
                                                    </template>
                                                    <template v-else>
                                                        <span v-text="item.clocked_in?.slice(0, 5)"></span>
                                                        -
                                                        <span v-text="item.clocked_out?.slice(0, 5)"></span>
                                                    </template>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
