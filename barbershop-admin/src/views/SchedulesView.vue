<template>
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
                <header class="col-12 mw-30">
                    <h3>Schedules</h3>
                </header>
            </div>
            <div class="gap-3 mt-4 mx-auto">
                <template v-if="schedules && schedules.length">
                    <div class="row align-items-center text-bg-dark p-3 rounded" v-for="schedule of schedules"
                        :key="`schedule${schedule.id}`">
                        <div class="col-auto">
                            <i class="bi bi-calendar-check fs-1"></i>
                        </div>
                        <div class="col-10 border-end">
                            <h5>
                                {{ schedule.user.name }}
                            </h5>
                            <h6>
                                {{ schedule.date }} - {{ schedule.time }}
                                <span class="badge text-bg-success">
                                    {{ schedule.status }}
                                </span>
                            </h6>
                            <small>
                                {{ schedule.service.name }} - {{ schedule.service.price }}
                            </small>
                        </div>
                        <div class="d-flex col-auto gap-4 ps-5">
                            <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
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
    status: string,
    date: string,
    time: string,
};

const schedules = ref<ScheduleInterface[]>();
const payments = reactive<string[]>(['money', 'pix', 'credit-card', 'debit-card']);

const selectedDateInterval = ref<string>("");
const selectedPayment = ref<string>(payments[0]);
const selectedService = ref();
const selectedDate = ref();

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

async function getAllSchedules() {

    try {
        const { data } = await axiosInstance.get("api/v1/admin/schedules");
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
