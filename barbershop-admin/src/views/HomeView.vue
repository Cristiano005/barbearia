<template>
    <TheHeader />
    <main class="p-5" style="background-color: rgb(244, 247, 254)">
        <div class="table-header row flex-wrap justify-content-between">
            <h2 class="col-12 col-lg-9">Dashboard</h2>
            <div class="d-flex col-12 col-lg-3 filters flex-wrap justify-content-end align-items-center gap-3">
                <VueDatePicker
                    v-model="dateInterval"
                    placeholder="Select a date interval"
                    :type="false"
                    format="dd/MM/yyyy"
                    range
                    multi-calendars />
            </div>
        </div>
        <div class="row analysys bg-light mt-5 gap-5">
            <div class="card col-lg-3 mb-3">
                <div class="row align-items-center card-body text-center">
                    <h4 class="card-title">Total Revenue</h4>
                    <span class="card-text fs-1"> R$ 10.000,56 </span>
                </div>
            </div>
            <div class="card col-lg-3 mb-3">
                <div class="row align-items-center card-body text-center">
                    <h4 class="card-title">Total Scheduled</h4>
                    <span class="card-text fs-1"> 158 </span>
                </div>
            </div>
            <div class="card col-lg-3 mb-3">
                <div class="card-body row align-items-center text-center">
                    <h4 class="card-title">Hours Worked</h4>
                    <span class="card-text fs-1"> 152h </span>
                </div>
            </div>

            <div class="card col-lg-2 mb-3">
                <div class="card-body row align-items-center text-center">
                    <h4 class="card-title">New Customers</h4>
                    <span class="card-text fs-1"> 12 </span>
                </div>
            </div>

            <div class="col-12 col-lg-5" style="height: 28rem">
                <h2 class="text-center text-dark">Revenue</h2>
                <Bar :data="totalRevenue.data" :options="totalRevenue.options" />
            </div>
            <div class="col-lg-3 text-light rounded" style="height: 28rem">
                <h2 class="text-center text-dark">Payments</h2>
                <Doughnut :data="paymentsTypes.data" :options="paymentsTypes.options" />
            </div>
            <div class="col-lg-3 text-light rounded" style="height: 28rem">
                <h2 class="text-center text-dark">Schedules Status</h2>
                <Doughnut :data="schedulesStatus.data" :options="schedulesStatus.options" />
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';

import TheHeader from '@/components/TheHeader.vue';

import { Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, ArcElement, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import type { ChartData, ChartOptions } from 'chart.js';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const dateInterval = ref(null);

const totalRevenue = reactive<{
    data: ChartData<'bar'>;
    options: ChartOptions<'bar'>;
}>({
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'Setempber', 'October', 'November', 'December'],
        datasets: [
            {
                label: 'Total Revenue',
                // backgroundColor: '#198754',
                data: [5000, 6000, 10000, 3500, 1035, 5545, 5060, 8050, 9000, 7856, 9100, 9865],
                backgroundColor: '#198754',
                borderRadius: 8
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false // Isso remove as linhas de grade do eixo X
                }
            },
            y: {
                grid: {
                    display: false // Isso remove as linhas de grade do eixo X
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom' as 'bottom',
                labels: {
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                }
            }
        }
    }
});

const paymentsTypes = reactive<{
    data: ChartData<'bar'>;
    options: ChartOptions<'bar'>;
}>({
    data: {
        labels: ['Credit Card', 'Debit Card', 'Pix', 'Money'],
        datasets: [
            {
                label: 'My First Dataset',
                data: [12, 78, 18, 44],
                backgroundColor: ['#dc3545', '#0d6efd', '#ffc107', '#198754'],
                hoverOffset: 4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false // Isso remove as linhas de grade do eixo X
                }
            },
            y: {
                grid: {
                    display: false // Isso remove as linhas de grade do eixo X
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom' as 'bottom',
                labels: {
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                }
            }
        }
    }
});

const schedulesStatus = reactive<{
    data: ChartData<'bar'>;
    options: ChartOptions<'bar'>;
}>({
    data: {
        labels: ['Finished', 'Absent', 'Cancelled'],
        datasets: [
            {
                label: 'My First Dataset',
                data: [140, 5, 13],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                hoverOffset: 4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false // Isso remove as linhas de grade do eixo X
                }
            },
            y: {
                grid: {
                    display: false // Isso remove as linhas de grade do eixo X
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom' as 'bottom',
                labels: {
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                }
            }
        }
    }
});

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);
</script>
