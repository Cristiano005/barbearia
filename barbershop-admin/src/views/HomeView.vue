<template>
    <TheHeader />
    <main class="p-5" style="background-color: rgb(244, 247, 254)">
        <div class="table-header row flex-wrap justify-content-between">
            <h2 class="col-12 col-lg-9">Dashboard</h2>
            <div class="d-flex col-12 col-lg-3 filters flex-wrap justify-content-end align-items-center gap-3">
                <VueDatePicker v-model="dateInterval" placeholder="Select a date interval" :type="false"
                    :clearable="false" format="dd/MM/yyyy" range multi-calendars
                    @update:model-value="updateDashboard" />
            </div>
        </div>
        <div class="row analysys bg-light mt-5 gap-5">
            <div class="card col-lg-3 mb-3">
                <div class="row align-items-center card-body text-center">
                    <h4 class="card-title">Total Revenue</h4>
                    <span class="card-text fs-1" id="revenuePerMonth">
                        {{ dashboardMetrics.revenueByPeriod.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) }}
                    </span>
                </div>
            </div>
            <div class="card col-lg-3 mb-3">
                <div class="row align-items-center card-body text-center">
                    <h4 class="card-title">Total Scheduled</h4>
                    <span class="card-text fs-1"> {{ dashboardMetrics.scheduleCount }} </span>
                </div>
            </div>
            <div class="card col-lg-3 mb-3">
                <div class="card-body row align-items-center text-center">
                    <h4 class="card-title">Hours Worked</h4>
                    <span class="card-text fs-1"> {{ dashboardMetrics.totalWorkedTime }} </span>
                </div>
            </div>

            <div class="card col-lg-2 mb-3">
                <div class="card-body row align-items-center text-center">
                    <h4 class="card-title">New Customers</h4>
                    <span class="card-text fs-1"> {{ dashboardMetrics.newCustomers }} </span>
                </div>
            </div>

            <div class="col-12 col-lg-5" style="height: 28rem">
                <h2 class="text-center text-dark">Revenue</h2>
                <Bar :data="revenuePerMonth.data" :options="revenuePerMonth.options" />
            </div>
            <div class="col-lg-3 text-light rounded" style="height: 28rem">
                <h2 class="text-center text-dark">Payments</h2>
                <Doughnut :data="paymentsByTypes.data" :options="paymentsByTypes.options" />
            </div>
            <div class="col-lg-3 text-light rounded" style="height: 28rem">
                <h2 class="text-center text-dark">Schedules Status</h2>
                <Doughnut :data="schedulesStatus.data" :options="schedulesStatus.options" />
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">

import TheHeader from '@/components/TheHeader.vue';
import { axiosInstance } from '@/helpers/helper';

import { ref, reactive, onMounted, computed } from 'vue';

import { Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, ArcElement, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const dateInterval = ref<Date[]>([]);

const dashboardMetrics = reactive({
    monthlyRevenue: [] as number[],
    revenueByPeriod: 0,
    scheduleCount: 0,
    totalWorkedTime: '00h:00m',
    newCustomers: 0,
    paymentTypeCounts: [] as number[],
    scheduleStatusCounts: [] as number[],
});

const revenuePerMonth = computed(() => {

    return {
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'Setempber', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'Revenue per Month',
                    data: dashboardMetrics.monthlyRevenue,
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

    }
});

const paymentsByTypes = computed(() => {
    return {
        data: {
            labels: ['Credit Card', 'Debit Card', 'Pix', 'Money'],
            datasets: [
                {
                    label: 'Payments by Type',
                    data: dashboardMetrics.paymentTypeCounts,
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
    }
});

const schedulesStatus = computed(() => {
    return {
        data: {
            labels: ['Finished', 'Pending', 'Absent', 'Cancelled'],
            datasets: [
                {
                    label: 'Schedule Status',
                    data: dashboardMetrics.scheduleStatusCounts,
                    backgroundColor: ['#198754', '#ffc107', '#6c757d', '#dc3545'],
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
    }
});

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

function formatterDate(date: Date) {

    const day = date.getDate() < 10 ? `0${date.getDate()}` : date.getDate();
    const month = date.getMonth() < 9 ? `0${date.getMonth() + 1}` : date.getMonth() + 1
    const year = date.getFullYear();

    return `${year}-${month}-${day}`;
}

async function getDataForDashboard(startDate: Date, endDate: Date) {

    try {
        const { data } = await axiosInstance.get(`/api/v1/admin/dashboard?startDate=${formatterDate(startDate)}&endDate=${formatterDate(endDate)}`);
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function updateDashboard(dates: Date[]) {

    const [startDate, endDate] = dates;

    const response = await getDataForDashboard(startDate, endDate);

    if (!response) return;

    dashboardMetrics.monthlyRevenue = response.monthly_revenue;
    dashboardMetrics.revenueByPeriod = response.period_revenue;
    dashboardMetrics.scheduleCount = response.schedule_count;
    dashboardMetrics.totalWorkedTime = response.worked_time;
    dashboardMetrics.newCustomers = response.new_customers;
    dashboardMetrics.paymentTypeCounts = Object.values(response.payment_type_counts);
    dashboardMetrics.scheduleStatusCounts = response.status_counts;
}

onMounted(async () => {
    const startDate: Date = new Date();
    const endDate: Date = new Date(new Date().setDate(startDate.getDate() + 30));
    dateInterval.value = [startDate, endDate];
    await updateDashboard([startDate, endDate]);
});

</script>