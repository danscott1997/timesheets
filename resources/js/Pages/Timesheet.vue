<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  timesheet: Object,
  year: [String, Number]
})

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
    <Head title="Timesheet" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Timesheet
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 text-gray-200">
                <div class="flex gap-8 mb-4">
                  <div class="flex flex-col">
                    <label for="user">Staff</label>
                    <select name="user" class="bg-transparent w-24 my-2">
                      <option>John</option>
                    </select>
                  </div>

                  <div class="flex flex-col">
                    <label for="month">Month</label>
                    <select name="month" class="bg-transparent w-24 my-2">
                      <option>May</option>
                    </select>
                  </div>

                  <div class="flex flex-col">
                    <label for="year">Year</label>
                    <select name="year" class="bg-transparent w-24 my-2">
                      <option>2025</option>
                    </select>
                  </div>
                </div>


                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                      <div v-for="(data, month) in timesheet" :key="month">
                        <h2 class="text-xl p-8 font-extrabold">{{ month }} {{ year }}</h2>
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
                                <div class="flex flex-col">
                                  <p>{{ item.day }}</p>

                                  <div class="text-xs mt-2">
                                    <p v-show="! item.disabled && ! item.weekend">08:00 - 16:00</p>
                                    <p v-show="item.disabled || item.weekend">-</p>
                                  </div>
                                </div>

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
