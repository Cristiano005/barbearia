<template>
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editScheduleModalLabel">Edit your schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
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
</template>

<script setup lang="ts">

import { computed, onMounted, ref } from "vue";

import { axiosInstance, getAllServices, format, getAvailableDateTimes } from "@/helpers/helper";
import type { AvailableDateTimesInterface, ScheduleInterface, ServiceInterface } from "@/helpers/types";

import { Modal } from "bootstrap";
import Swal from "sweetalert2";

import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const emit = defineEmits(["scheduleUpdated"]);
defineExpose({ openAndSetData });

const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);
const times = ref<String[]>([]);
const services = ref<ServiceInterface[]>([]);

const scheduleId = ref<number | null>(null);
const selectedDate = ref<Date | null>(null);
const selectedTime = ref<String>("");
const selectedService = ref<String | number>("");

const isDisabled = ref<boolean>(true);

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

function openAndSetData(schedule: ScheduleInterface) {

    scheduleId.value = schedule.id;
    selectedService.value = schedule.service.id;

    const modalElement = document.getElementById("editScheduleModal");
    if (modalElement) {
        const modal = new Modal(modalElement, {});
        modal.show();
    }
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

        if (data.success) {

            emit("scheduleUpdated");

            selectedDate.value = null;
            selectedTime.value = "";

            Swal.fire({
                icon: "success",
                title: data.message,
            });
        }

    }

    catch (error: any) {
        Swal.fire({
            icon: "error",
            title: error.response.data.message || "An error occurred!",
        });
    }

}

onMounted(async () => {
    availableDateTimes.value = await getAvailableDateTimes();
    services.value = await getAllServices();
});

</script>