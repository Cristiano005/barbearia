<template>
    <TheHeader />
    <main class="p-5" style="background-color: rgb(244, 247, 254)">
        <div class="table-header row flex-wrap justify-content-between gap-2">
            <h2 class="col-12 col-lg-6">Dashboard</h2>
            <div class="d-flex col-12 col-lg-5 filters flex-wrap gap-3">
                <div class="col-12 col-lg-5">
                    <input class="form-control me-2 h-100 p-2" type="search" placeholder="Search by services" aria-label="Search" />
                </div>
                <div class="col-12 col-lg-4">
                    <select class="form-select h-100 p-2" aria-label="Default select example">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <button type="button" class="btn btn-success col-12 col-lg-2 p-2">+ Add service</button>
            </div>
        </div>
        <div class="row analysys bg-light mt-5 gap-4">
            <div class="card col-lg-3 mb-3">
                <div class="row align-items-center card-body text-center">
                    <h4 class="card-title">Total Revenue</h4>
                    <span class="card-text fs-1">
                        R$ 10.000,56
                    </span>
                </div>
            </div>
            <div class="card col-lg-3 mb-3">
                <div class="row align-items-center card-body text-center">
                    <h4 class="card-title">Total Scheduled</h4>
                    <span class="card-text fs-1">
                        123
                    </span>
                </div>
            </div>
            <div class="card col-lg-3 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <div class="card col-lg-2 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            
            <div class="col-12 col-lg-7" style="height: 28rem;">
                <div class="chart-container h-100">
                    <Bar :data="totalRevenue.data" :options="totalRevenue.options" />
                </div>
            </div>
            <div class="col-lg-4 text-light rounded" style="height: 28rem;">
                <Doughnut :data="paymentsTypes.data" :options="paymentsTypes.options" />
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import TheHeader from '@/components/TheHeader.vue';

import { Chart as ChartJS, Title, ArcElement, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import { Bar, Doughnut } from 'vue-chartjs';

import type { ChartData, ChartOptions } from 'chart.js';

import { reactive } from 'vue';

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
                position: 'top' as 'top',
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
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [
            {
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
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
                position: 'top' as 'top',
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
