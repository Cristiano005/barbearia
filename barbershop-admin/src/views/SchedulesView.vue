<template>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit your schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- <div class="mb-3">
                            <label for="service-to-schedule" class="col-form-label">Service:</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="service-to-schedule" v-model="selectedService">
                                <option v-for="service of services">
                                    {{ service.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Date*</label>
                            <VueDatePicker :model-value="selectedDate" :min-date="new Date()" :format="format"
                                ref="dateInput" :enableTimePicker="false" locale="pt-BR"
                                @update:model-value="searchTimesAvailable" placeholder="Select a date" id="date" />
                            <div ref="dateMessageContainer"></div>
                        </div> -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Time*</label>
                            <select class="form-control" ref="timeInput" disabled>
                                <option disabled selected value=""> Select a time </option>
                            </select>
                            <div ref="timeMessageContainer"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning">Edit Schedule</button>
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
                <template v-if="schedules && schedules.length">
                    <div class="row align-items-center text-bg-dark p-3 rounded" v-for="schedule of schedules"
                        :key="`schedule${schedule.id}`">
                        <div class="col-1">
                            <i class="bi bi-calendar-event" style="font-size: 3.5rem;"></i>
                        </div>
                        <div class="col-9 border-end">
                            <h5>
                                {{ schedule.user.name }}
                            </h5>
                            <h6>
                                {{ schedule.date }} - {{ schedule.time }}
                                <span :class="['badge', statusColors[schedule.status]]">
                                    {{ schedule.status }}
                                </span>
                            </h6>
                            <small>
                                {{ schedule.service.name }} - {{ schedule.service.price }}
                            </small>
                        </div>
                        <div class="d-flex col-2 gap-4 ps-5">
                            <div class="btn-group">
                                <i class="d-flex align-items-center fs-4 bi bi-pencil-square cursor-pointer"
                                    title="Define schedule's status" data-bs-toggle="dropdown"
                                    aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item text-success" href="#">
                                            <i class="bi bi-check"></i>
                                            Success
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-secondary" href="#">
                                            <i class="bi bi-person-fill-x"></i>
                                            Absent
                                        </a>
                                    </li>
                                </ul>
                            </div> <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
                                @click="openEditModal(schedule.service)"></i>
                            <i class="fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"
                                @click="deleteSchedule(schedule.id)"></i>
                        </div>
                    </div>
                </template>
                <template v-else-if="schedules && !schedules.length">
                    <h2> Data not found </h2>
                </template>
                <template v-else>
                    <h2> Loading... </h2>
                </template>
                <nav aria-label="...">
                    <ul class="pagination justify-content-center">

                        <template v-if="pagination.currentPage > 1">
                            <li class="page-item">
                                <button class="page-link"
                                    @click="goToPage(pagination.currentPage - 1)">Previous</button>
                            </li>
                        </template>
                        <template v-else>
                            <li class="page-item disabled">
                                <button class="page-link">Previous</button>
                            </li>
                        </template>

                        <li :class="pagination.currentPage === page ? 'active' : ''"
                            v-for="page of pagination.quantityOfPages">
                            <button class="page-link" @click="goToPage(page)">
                                {{ page }}
                            </button>
                        </li>

                        <template v-if="pagination.currentPage < pagination.quantityOfPages">
                            <li class="page-item">
                                <button class="page-link" @click="goToPage(pagination.currentPage + 1)">Next</button>
                            </li>
                        </template>
                        <template v-else>
                            <li class="page-item disabled">
                                <button class="page-link">Next</button>
                            </li>
                        </template>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">

import { onMounted, reactive, ref } from 'vue';

import TheHeader from '@/components/TheHeader.vue';
import { axiosInstance } from '@/helpers/helper';

import { Modal } from "bootstrap";
import Swal from 'sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

interface ScheduleInterface {
    id: number,
    user: {
        name: string,
        email: string,
    },
    service: {
        name: string,
        price: string,
    },
    payment: string,
    status: "pending",
    date: string,
    time: string,
};

interface StatusColorsInterface {
    success: string,
    pending: string,
    absent: string,
    cancelled: string,
}

interface PaginationInterface {
    quantityOfPages: number,
    currentPage: number,
}

const schedules = ref<ScheduleInterface[]>();
const payments = reactive<string[]>(['money', 'pix', 'credit-card', 'debit-card']);

const selectedDateInterval = ref<string>("");
const selectedPayment = ref<string>(payments[0]);
const selectedService = ref();
const selectedDate = ref();

const statusColors = reactive<StatusColorsInterface>({
    success: "text-bg-success",
    pending: "text-bg-warning",
    absent: "text-bg-secondary",
    cancelled: "text-bg-danger",
});

const statusFilters = ref<String[]>(["Success", "Pending", "Absent", "Cancelled"]);
const selectedStatusFilter = ref<String>("Pending");

const pagination = ref<PaginationInterface>({
    quantityOfPages: 1,
    currentPage: 1,
});

const autosize = (event: Event): void => {
    const textarea = event.target as HTMLTextAreaElement;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
};

const formatterDate = (date, time) => {
    const dateInstance = new Date(`${date}T${time}`);
    const day = String(dateInstance.getDate()).padStart(2, "0");
    const month = String(dateInstance.getMonth() + 1).padStart(2, "0"); // Os meses começam em 0
    const year = dateInstance.getFullYear();
    const hours = String(dateInstance.getHours()).padStart(2, "0");
    const minutes = String(dateInstance.getMinutes()).padStart(2, "0");

    return `${day}/${month}/${year} às ${hours}:${minutes}h`;
}

const filterSchedule = async () => {
    pagination.value.currentPage = 1;
    schedules.value = await getAllSchedules();
};

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

async function openEditModal(service) {

    const modal = new Modal(document.getElementById('exampleModal'), {});
    modal.show();

    //selectedService.value = service.name
    //services.value = await getAllServices();
}

async function deleteSchedule(id: number) {

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

onMounted(async () => {
    schedules.value = await getAllSchedules();
})

</script>
