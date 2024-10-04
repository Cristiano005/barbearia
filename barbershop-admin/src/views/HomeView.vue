<template>
    <TheHeader />
    <main class="p-5" style="background-color: rgb(244, 247, 254);">
        <div class="table-header row flex-wrap justify-content-between gap-2">
            <h2 class="col-12 col-lg-6">Dashboard</h2>
            <div class="d-flex col-12 col-lg-5 filters flex-wrap gap-3">
                <div class="col-12 col-lg-5">
                    <input
                        class="form-control me-2 h-100 p-2"
                        type="search"
                        placeholder="Search by services"
                        aria-label="Search" />
                </div>
                <div class="col-12 col-lg-4">
                    <select class="form-select h-100 p-2" aria-label="Default select example">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <button type="button" class="btn btn-success col-12 col-lg-2 p-2">
                    + Add service
                </button>
            </div>
        </div>
        <div class="row analysys bg-light gap-2 mt-5">
            <div class="col-12 col-lg-8" style="height: 20rem">
                <div class="row chart-container h-100">
                    <Bar :data="data" :options="options" />
                </div>
            </div>
            <div class="col-4 text-light rounded" style="height: 20rem">
                <!-- <Doughnut :data="data" :options="options" /> -->
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import TheHeader from '@/components/TheHeader.vue';

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';
import { Bar, Doughnut } from 'vue-chartjs';

const data = {
    labels: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'Setempber',
        'October',
        'November',
        'December'
    ],
    datasets: [
        {
            label: 'Total Revenue',
            // backgroundColor: '#198754',
            data: [5000, 6000, 10000, 3500, 1035, 5545, 5060, 8050, 9000, 7856, 9100, 9865],
            backgroundColor: '#198754',
            borderRadius: 8,
        }
    ]
};

const options = {
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
            position: 'top',
            labels: {
                font: {
                    size: 18,
                    weight: 'bold'
                }
            }
        }
    }
};

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);
</script>
