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
                        <input type="hidden" id="scheduleId" v-model="scheduleId">
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
    <header class="p-2 bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand fw-medium" href="#">Barber Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                    <ul class="navbar-nav gap-2">
                        <li class="nav-item">
                            <RouterLink class="nav-link text-white" to="/">
                                Home
                            </RouterLink>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="btn btn-outline-light dropdown-toggle border-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <RouterLink class="dropdown-item" to="/my-schedules">
                                        My Schedules
                                    </RouterLink>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main class="p-5">
        <div class="container mx-auto">
            <div class="row">
                <header class="col-12 mw-30">
                    <h3>My Schedules</h3>
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
                                @click="openEditModal(schedule.service.id, schedule.id)"></i>
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

import { onMounted, ref, computed } from "vue";

import { axiosInstance, getAllServices, format, getAvailableDateTimes } from "@/helpers/helper";

import { Modal } from "bootstrap";
import Swal from 'sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

interface ServiceInterface {
    id: number,
    name: string,
    price: string,
}

interface ScheduleInterface {
    id: number,
    service: {
        id: number,
        name: string,
        price: string,
    },
    payment: string,
    status: string,
    date: string,
    time: string,
};

interface AvailableDateTimesInterface {
    id: number,
    date: String,
    time: String,
}

const schedules = ref<ScheduleInterface[] | null>(null);
const services = ref<ServiceInterface[]>([]);

const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);

const scheduleId = ref<number>();

const selectedService = ref<number | null>(null);
const selectedDate = ref<Date | null>(null);

const isDisabled = ref<boolean>(true);
const times = ref<String[]>([]);
const selectedTime = ref<String>("");

const onlyFreeDays = computed<Date[]>(() => {
    return availableDateTimes.value.map(dateTime => {
        const [year, month, day] = dateTime.date.split('-').map(Number);
        return new Date(year, month - 1, day);
        // ⚠️ ATENÇÃO: problema de fuso horário
        // Quando se cria uma Date a partir de string "YYYY-MM-DD",
        // o JavaScript interpreta como UTC. No Brasil (UTC-3), isso desloca a data
        // para o dia anterior, fazendo o DatePicker mostrar o dia errado.
        //
        // Solução: criar a Date passando ano, mês e dia diretamente (ano, mês-1, dia)
        // assim o JavaScript cria a data já no fuso local, evitando o erro.
    });
})

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

async function getMyAllSchedules() {

    try {
        const { data } = await axiosInstance.get("/api/v1/schedules");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function openEditModal(serviceId: number, idOfSchedule: number) {

    const modal = new Modal(document.getElementById('exampleModal'), {});
    modal.show();

    selectedService.value = serviceId;
    scheduleId.value = idOfSchedule;
    services.value = await getAllServices();
}

async function saveChanges() {

    try {

        if (!selectedService.value || selectedDate.value === null || !selectedTime.value) {
            Swal.fire({
                icon: "error",
                title: "Please, fill all fields!",
            });
            return;
        }

        const { data } = await axiosInstance.put(`/api/v1/schedules/${scheduleId.value}`, {
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

        const modalElement = document.getElementById('exampleModal');
        const modal = Modal.getInstance(modalElement);
        modal?.hide();

        schedules.value = await getMyAllSchedules();
    }

    catch (error: any) {
        Swal.fire({
            icon: "error",
            title: error.response.data.message || "An error occurred!",
        });
    }

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
        text: "You'll need to schedule again.",
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

                schedules.value = await getMyAllSchedules();
            }
        }

        catch (error) {
            console.log(error);
        }
    }
}

onMounted(async () => {
    schedules.value = await getMyAllSchedules();
    availableDateTimes.value = await getAvailableDateTimes();
});

</script>

<style scoped lang="scss">
.cursor-pointer {
    cursor: pointer;
}
</style>