<template>
    <ScheduleFilterModal v-model:model-value="selectedStatusFilter" @apply-filters="filterSchedule" />
    <ScheduleAddModal :services="services" :payments="payments" :available-date-times="availableDateTimes"
        :only-free-days="onlyFreeDays" />
    <ScheduleEditModal :schedule="selectedSchedule" :services="services" :available-date-times="availableDateTimes" :only-free-days="onlyFreeDays"
        :schedule-id="scheduleId" @updated="handleUpdated" />
    <TheHeader />
    <main class="p-5">
        <div class="d-flex flex-column gap-5 container mx-auto">
            <div class="row gap-4">
                <header class="d-flex justify-content-between align-items-center flex-wrap col-12">
                    <h3>Schedules</h3>
                    <div class="d-flex align-items-center gap-3">
                        <i class="fs-4 bi bi-funnel cursor-pointer" title="Filter schedules" data-bs-toggle="modal"
                            data-bs-target="#scheduleFilterModal"></i>
                        <button type="button" class="btn btn-outline-success" @click="openAddScheduleModal">
                            Add Schedule
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                </header>
                <div class="d-flex flex-column align-items-center col-12 gap-3">
                    <template v-if="isLoadingSchedules">
                        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                            <div class="fs-4 spinner-border text-dark text-center" style="width: 3rem; height: 3rem;"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <strong role="status">Loading...</strong>
                        </div>
                    </template>
                    <template v-else-if="schedules && schedules.length">
                        <ScheduleCard v-for="schedule of schedules" :key="`schedule${schedule.id}`" :schedule="schedule"
                            @update-status="handleUpdateStatus" @edit="openEditScheduleModal(schedule)"
                            @cancel="openCancelScheduleModal" />
                    </template>
                    <template v-else="schedules && !schedules.length">
                        <div class="d-flex flex-column justify-content-center text-center gap-4" style="width: 200px;">
                            <img class="w-100" src="../assets/empty_data.svg">
                            <h4> No Schedules </h4>
                        </div>
                    </template>
                </div>
                <Pagination class="col-12" :pagination="pagination" @goToPage="goToPage" />
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">

import { onMounted, ref } from 'vue';

import Swal from 'sweetalert2';
import { Modal } from "bootstrap";
import '@vuepic/vue-datepicker/dist/main.css';

import TheHeader from '@/components/TheHeader.vue';
import ScheduleCard from '@/components/ScheduleCard.vue';

import { axiosInstance } from '@/helpers/helper';
import type { ScheduleInterface, PaymentTypeInterface } from "@/helpers/types";

import Pagination from '@/components/Pagination.vue';
import ScheduleAddModal from '@/components/schedule/ScheduleAddModal.vue';
import ScheduleFilterModal from '@/components/schedule/ScheduleFilterModal.vue';
import ScheduleEditModal from '@/components/schedule/ScheduleEditModal.vue';
import { useService } from '@/components/composables/useService';
import { useSchedule } from '@/components/composables/useSchedule';
import { useAvailability } from '@/components/composables/useAvailability';

const { schedules, pagination, getSchedules, updateStatus } = useSchedule();
const { services, getServices } = useService();
const { availableDateTimes, fetchAvailability, onlyFreeDays } = useAvailability();

const isLoadingSchedules = ref<boolean>(true);

const payments = ref<PaymentTypeInterface[]>([]);

const selectedSchedule = ref<ScheduleInterface | null>(null);
const selectedService = ref<number | null>(null);
const scheduleId = ref<number | null>(null);
const selectedStatusFilter = ref<string>("Pending");

let addModalInstance: Modal | null = null;
let editModalInstance: Modal | null = null;
let filterModalInstance: Modal | null = null;

const filterSchedule = async () => {

    try {

        isLoadingSchedules.value = true;

        pagination.currentPage = 1;
        await getSchedules(selectedStatusFilter.value);

        addModalInstance.hide();

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });

        Toast.fire({
            icon: "success",
            title: "Schedules filtered successfully!"
        });

    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: "error",
            title: "Failed to filter schedules",
        });
    }

    finally {
        isLoadingSchedules.value = false;
    }
};

async function handleUpdateStatus(scheduleId: number, status: "success" | "absent") {
    const result = await updateStatus(scheduleId, status);
    if (result) await getSchedules(selectedStatusFilter.value);
}

async function goToPage(page: number) {
    pagination.currentPage = page;
    await getSchedules(selectedStatusFilter.value);
}

async function getAllTypeOfPayments() {

    try {
        const { data } = await axiosInstance.get("/api/v1/payments");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function openAddScheduleModal() {
    await getServices({ all: true });
    addModalInstance?.show();
}

async function openEditScheduleModal(schedule: ScheduleInterface) {

    await getServices({ all: true });

    selectedSchedule.value = schedule;

    selectedService.value = schedule.service.id;
    scheduleId.value = schedule.id;

    editModalInstance?.show();
}

async function handleUpdated() {
    editModalInstance?.hide();
    await getSchedules(selectedStatusFilter.value);
    await fetchAvailability(); 
}

async function openCancelScheduleModal(id: number) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-3",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    const result = await swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "The customer's schedule will be canceled.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, cancel it!",
        cancelButtonText: "Don't cancel it!",
        reverseButtons: true
    });

    if (result.isConfirmed) {

        try {

            const { data } = await axiosInstance.delete(`/api/v1/schedules/${id}`);

            if (data.success) {

                Swal.fire({
                    icon: "success",
                    title: "Schedule was cancelled successfully!",
                });

                await getSchedules(selectedStatusFilter.value);
            }
        }

        catch (error) {
            console.log(error);
        }
    }

}

onMounted(async () => {

    addModalInstance = new Modal(document.querySelector("#scheduleAddModal"));
    editModalInstance = new Modal(document.querySelector("#scheduleEditModal"));
    filterModalInstance = new Modal(document.querySelector("#scheduleFilterModal"));

    await getSchedules(selectedStatusFilter.value);
    await fetchAvailability();

    payments.value = await getAllTypeOfPayments();
    isLoadingSchedules.value = false;
});

</script>
