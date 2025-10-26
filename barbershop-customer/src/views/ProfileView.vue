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
    <TheHeader />
    <main class="d-flex flex-column gap-5 p-5">
        <section class="container mx-auto">
            <div class="row">
                <header class="col-12 mw-30">
                    <h3>My Schedules</h3>
                </header>
            </div>

            <div class="gap-3 mt-4 mx-auto">
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
                    <div class="row align-items-center text-bg-dark p-3 rounded" v-for="schedule of schedules"
                        :key="`schedule${schedule.id}`">
                        <div class="col-auto">
                            <i class="bi bi-calendar-check fs-1"></i>
                        </div>
                        <div class="col-10 border-end">
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
                        <div class="d-flex col-auto gap-4 ps-5">
                            <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
                                @click="openEditModal(schedule.service.id, schedule.id)"></i>
                            <i class="fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"
                                @click="deleteSchedule(schedule.id)"></i>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <img class="w-25" src="../assets/404_image.svg" alt=""></img>
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex align-items-center justify-content-center gap-2" role="alert">
                                <i class="bi bi-info-circle fs-2"></i>
                                <h5 class="mb-0"> No schedule found! </h5>
                            </div>
                            <RouterLink class="d-flex align-items-center justify-content-center btn btn-dark px-5 mt-4"
                                to="/schedule">
                                Schedule an hour
                                <i class="bi bi-alarm-fill p-2"></i>
                            </RouterLink>
                        </div>
                    </div>
                </template>
            </div>
        </section>
        <section class="container mx-auto">

            <div class="row">
                <header class="col-12 mw-30">
                    <h3>My Data</h3>
                </header>
            </div>

            <template v-if="isLoadingProfileData">

                <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                    <div class="fs-4 spinner-border text-dark text-center" style="width: 3rem; height: 3rem;"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <strong role="status">Loading...</strong>
                </div>

            </template>

            <template v-else>

                <form class="row align-items-center mt-4">

                    <div class="col-4 mb-3">
                        <label class="mb-1" for=""> Name: </label>
                        <input type="text" class="form-control" placeholder="Input Name" aria-label="Name"
                            aria-describedby="basic-addon1" v-model="profileData.name">
                    </div>

                    <div class="col-4 mb-3">
                        <label class="mb-1" for=""> Email: </label>
                        <input type="email" class="form-control" placeholder="Input E-mail" aria-label="Email"
                            aria-describedby="basic-addon1" disabled readonly v-model="profileData.email">
                    </div>

                    <div class="col-4 mb-3">
                        <label class="mb-1" for=""> Phone Number: </label>
                        <input type="text" class="form-control" placeholder="Input Phone Number"
                            aria-label="Phone Number" aria-describedby="basic-addon1"
                            v-model="profileData.phone_number">
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-3 col-12">
                        <button type="button" class="btn btn-warning col-auto">
                            Recuperar senha
                            <i class="bi bi-key-fill"></i>
                        </button>
                        <button type="button" class="btn btn-success col-auto" @click="updateProfileData">
                            Atualizar Dados
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </div>

                </form>

            </template>

        </section>
    </main>
</template>

<script setup lang="ts">

import { onMounted, ref, computed, reactive } from "vue";

import { axiosInstance, getAllServices, format, getAvailableDateTimes } from "@/helpers/helper";

import { Modal } from "bootstrap";
import Swal from 'sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import TheHeader from "@/components/TheHeader.vue";

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
    status: "success" | "pending" | "absent" | "cancelled",
    date: string,
    time: string,
};

interface AvailableDateTimesInterface {
    id: number,
    date: String,
    time: String,
};

interface ProfileDataInterface {
    name: string,
    email: string,
    phone_number: string,
};

interface StatusColorsInterface {
    success: string,
    pending: string,
    absent: string,
    cancelled: string,
}

const isLoadingSchedules = ref<boolean>(true);
const isLoadingProfileData = ref<boolean>(true);

const schedules = ref<ScheduleInterface[] | null>(null);
const services = ref<ServiceInterface[]>([]);

const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);

const profileData = reactive<ProfileDataInterface>({
    name: "",
    email: "",
    phone_number: "",
});

const scheduleId = ref<number>();

const selectedService = ref<number | null>(null);
const selectedDate = ref<Date | null>(null);

const isDisabled = ref<boolean>(true);
const times = ref<String[]>([]);
const selectedTime = ref<String>("");

const statusColors = reactive<StatusColorsInterface>({
    success: "text-bg-success",
    pending: "text-bg-warning",
    absent: "text-bg-secondary",
    cancelled: "text-bg-danger",
});

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
});

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success mx-3",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
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

async function getProfileData() {

    try {
        const { data } = await axiosInstance.get("/api/v1/user/me");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

    finally {
        isLoadingProfileData.value = false;
    }
}

function updateProfileData() {

    if (!profileData.name || !profileData.phone_number) {
        Swal.fire({
            icon: "error",
            title: "Please, fill all fields!",
        });
        return;
    }

    swalWithBootstrapButtons.fire({
        title: "Are you sure you want to update your data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, update it!"
    }).then(async (result) => {

        if (result.isConfirmed) {

            try {

                const { data } = await axiosInstance.put(`/api/v1/user/update`, {
                    name: profileData.name,
                    phone_number: profileData.phone_number
                });

                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Data updated successfully!",
                    });
                }
            }

            catch (error) {
                console.log(error);
            }
        }
    });
}

async function getMyAllSchedules() {

    try {
        const { data } = await axiosInstance.get("/api/v1/schedules");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

    finally {
        isLoadingSchedules.value = false;
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

    const response = await getProfileData();

    schedules.value = await getMyAllSchedules();
    availableDateTimes.value = await getAvailableDateTimes();
    Object.assign(profileData, response);
});

</script>

<style scoped lang="scss">

.cursor-pointer {
    cursor: pointer;
}

main {
    margin-top: 4.5rem;
}

section {
    padding: 0;
}

</style>