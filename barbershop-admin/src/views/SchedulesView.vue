<template>
    <div class="modal fade" id="scheduleFilterModal" tabindex="-1" aria-labelledby="serviceAddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceAddModalLabel">Filter Schedules</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Status</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="service-to-schedule" v-model="selectedStatusFilter">
                                <option v-for="filter of statusFilters">
                                    {{ filter }}
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" @click="filterSchedule">Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="scheduleAddModal" tabindex="-1" aria-labelledby="serviceAddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceAddModalLabel">Add Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="serviceName" id="serviceName"
                                placeholder="Service name">
                            <div ref="timeMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="servicePrice" class="form-label">Price*</label>
                            <input type="text" class="form-control" name="servicePrice" id="servicePrice"
                                placeholder="Service price">
                            <div ref="timeMessageContainer"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Add Schedule</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="scheduleEditModal" tabindex="-1" aria-labelledby="scheduleEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="scheduleEditModal">Edit your schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- <input type="hidden" id="scheduleId" v-model="scheduleId"> -->
                        <div class="mb-3">
                            <label for="service-to-schedule" class="col-form-label">Service:</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="service-to-schedule" v-model="selectedService">
                                <option v-for="service of services" :key="service.id" :value="service.id">
                                    {{ service.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Date*</label>
                            <VueDatePicker v-model="selectedDate" @update:model-value="handleDate" :format="format"
                                ref="dateInput" :enableTimePicker="false" :allowed-dates="onlyFreeDays"
                                placeholder="Select a date" id="date" />
                            <div ref="dateMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Time*</label>
                            <select class="form-control" ref="timeInput" :disabled="isDisabled" v-model="selectedTime">
                                <option value=""> Selecione um horário </option>
                                <option v-for="time in times"> {{ time }} </option>
                            </select>
                            <div ref="timeMessageContainer"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" @click="saveChanges">Edit Schedule</button>
                </div>
            </div>
        </div>
    </div>
    <TheHeader />
    <main class="p-5">
        <div class="container mx-auto">
            <div class="row">
                <header class="d-flex justify-content-between align-items-center flex-wrap mw-30">
                    <h3>Schedules</h3>
                    <div class="d-flex align-items-center gap-3">
                        <i class="fs-4 bi bi-funnel cursor-pointer" title="Filter schedules" data-bs-toggle="modal"
                            data-bs-target="#scheduleFilterModal"></i>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                            data-bs-target="#scheduleAddModal">
                            Add Schedules
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                </header>
            </div>
            <div class="row gap-3 mt-4 mx-auto">
                <template v-if="isLoadingSchedules">
                    <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                        <div class="fs-4 spinner-border text-dark text-center" style="width: 3rem; height: 3rem;"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <strong role="status">Loading...</strong>
                    </div>
                </template>
                <ScheduleCard v-else-if="schedules && schedules.length" v-for="schedule of schedules"
                    :key="`schedule${schedule.id}`" :schedule="schedule" @edit="openEditScheduleModal(schedule)"
                    @cancel="openCancelScheduleModal" />
                <template v-else="schedules && !schedules.length">
                    <h2> Data not found </h2>
                </template>
            </div>
            <Pagination :pagination="pagination" @goToPage="goToPage" />
        </div>
    </main>
</template>

<script setup lang="ts">

import { onMounted, reactive, ref, computed } from 'vue';

import Swal from 'sweetalert2';
import { Modal } from "bootstrap";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import TheHeader from '@/components/TheHeader.vue';
import ScheduleCard from '@/components/ScheduleCard.vue';

import { fetchServices } from '@/services/serviceService';
import { axiosInstance } from '@/helpers/helper';
import type { ScheduleInterface, ServiceInterface, AvailableDateTimesInterface, FetchServicesParams, PaginationInterface, StatusColorsInterface } from "@/helpers/types";
import Pagination from '@/components/Pagination.vue';

let addModalInstance: Modal | null = null;

const isLoadingSchedules = ref<boolean>(true);

const schedules = ref<ScheduleInterface[]>([]);
const services = ref<ServiceInterface[]>([]);
const payments = reactive<string[]>(['money', 'pix', 'credit-card', 'debit-card']);

const selectedDateInterval = ref<string>("");
const selectedPayment = ref<string>(payments[0]);
const selectedService = ref<number | null>(null);
const selectedDate = ref();

const scheduleId = ref<number>();

const statusFilters = ref<String[]>(["Success", "Pending", "Absent", "Cancelled"]);
const selectedStatusFilter = ref<String>("Pending");

const pagination = ref<PaginationInterface>({
    quantityOfPages: 1,
    currentPage: 1,
});

const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);
const isDisabled = ref<boolean>(true);
const times = ref<String[]>([]);
const selectedTime = ref<String>("");

const onlyFreeDays = computed<Date[]>(() => {
    return availableDateTimes.value.map(dateTime => {
        const [year, month, day] = dateTime.date.split('-').map(Number);
        return new Date(year, month - 1, day);
    });
});

const getFormattedDate = (date: Date) => {
    const newDate = new Date(date);
    const day = String(newDate.getDate()).padStart(2, '0');
    const month = String(newDate.getMonth() + 1).padStart(2, '0');
    const year = newDate.getFullYear();

    return `${year}-${month}-${day}`;
}

const handleDate = (chosenDate: Date) => {

    const fullDate = getFormattedDate(chosenDate);

    times.value = availableDateTimes.value.filter(dateTime => dateTime.date === fullDate).map(dateTime => dateTime.time);

    if (times.value.length > 0) {
        isDisabled.value = false;
    } else {
        isDisabled.value = true;
        selectedTime.value = "";
    }
}

const format = (date: Date) => {
    return new Intl.DateTimeFormat('pt-BR').format(date);
}

const filterSchedule = async () => {

    try {

        isLoadingSchedules.value = true;

        pagination.value.currentPage = 1;
        schedules.value = await getAllSchedules();

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

async function getAvailableDateTimes() {
    try {
        const { data } = await axiosInstance.get(`/api/v1/availabilities`);
        return data.data;
    }

    catch (error) {
        console.log(error);
    }
}

async function goToPage(page: number) {
    pagination.value.currentPage = page;
    schedules.value = await getAllSchedules();
}

async function getAllSchedules() {

    try {
        const statusFilter = selectedStatusFilter.value.toLowerCase();
        const { data } = await axiosInstance.get(`api/v1/admin/schedules?status=${statusFilter}&page=${pagination.value.currentPage}`);
        pagination.value.quantityOfPages = data.meta.last_page;
        return data.data;
    }

    catch (error) {
        console.log(error);
    }
}

async function getAllServices({ currentPage = 1, all = false }: FetchServicesParams) {

    try {

        const data = await fetchServices({ currentPage, all });

        if (!all && data.meta) {
            pagination.value.quantityOfPages = data.meta.last_page;
            pagination.value.currentPage = data.meta.current_page;
        }

        return data;
    }

    catch (error) {
        console.log(error);
    }
}

async function openEditScheduleModal(schedule: ScheduleInterface) {
    const modal = new Modal(document.getElementById("scheduleEditModal"), {});
    modal.show();

    services.value = await getAllServices({ all: true });
    selectedService.value = schedule.service.id;
    scheduleId.value = schedule.id;
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

                schedules.value = await getAllSchedules();
            }
        }

        catch (error) {
            console.log(error);
        }
    }

}

async function saveChanges() {

    try {

        const { data } = await axiosInstance.put(`/api/v1/admin/schedules/${scheduleId.value}`, {
            service_id: selectedService.value,
            date: getFormattedDate(selectedDate.value),
            time: selectedTime.value,
        });

        Swal.fire({
            icon: "success",
            title: data.message,
        });

        selectedDate.value = null;
        selectedTime.value = "";

        const modalElement = document.getElementById("scheduleEditModal");
        const modal = Modal.getInstance(modalElement);
        modal?.hide();

        schedules.value = await getAllSchedules();
    }

    catch (error: any) {
        Swal.fire({
            icon: "error",
            title: error.response.data.message || "An error occurred!",
        });
    }
}

onMounted(async () => {
    addModalInstance = new Modal(document.querySelector("#scheduleFilterModal"));
    schedules.value = await getAllSchedules();
    availableDateTimes.value = await getAvailableDateTimes();
    isLoadingSchedules.value = false;
});

</script>
