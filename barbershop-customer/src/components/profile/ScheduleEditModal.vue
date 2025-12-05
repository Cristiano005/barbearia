<template>
    <div class="modal fade" id="scheduleEditModal" tabindex="-1" aria-labelledby="scheduleEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="scheduleEditModalLabel">Edit your schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 has-validation">
                            <label for="service-to-schedule" class="col-form-label">Service:</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="service-to-schedule" v-model="serviceId" v-bind="serviceIdAttrs">
                                <option v-for="service of services" :key="service.id" :value="service.id">
                                    {{ service.name }}
                                </option>
                            </select>
                            <div :class="errors.serviceId ? 'invalid-feedback' : ''">
                                {{ errors.serviceId }}
                            </div>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="date" class="form-label">Date*</label>
                            <VueDatePicker :class="{
                                'h-100': true,
                                'is-invalid': errors.time
                            }" v-model="date" v-bind="dateAttrs"
                                @update:model-value="(val: Date) => handleDate(val, availableDateTimes)"
                                :format="format" ref="dateInput" :enableTimePicker="false" :allowed-dates="onlyFreeDays"
                                placeholder="Select a date" id="date" />
                            <div :class="errors.date ? 'invalid-feedback' : ''">
                                {{ errors.date }}
                            </div>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="time" class="form-label">Time*</label>
                            <select :class="{
                                'form-select': true,
                                'h-100': true,
                                'p-2': true,
                                'is-invalid': errors.time
                            }" id="time" :disabled="isDisabled" v-model="time" v-bind="timeAttrs">
                                <option value=""> Select an hour </option>
                                <option v-for="time in times" :key="`time${time}`" :value="time"> {{ time }} </option>
                            </select>
                            <div :class="errors.time ? 'invalid-feedback' : ''">
                                {{ errors.time }}
                            </div>
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

import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/yup";
import * as yup from "yup";
import { Modal } from "bootstrap";
import Swal from "sweetalert2";

import { axiosInstance, getAllServices, getAvailableDateTimes } from "@/helpers/helper";
import type { AvailableDateTimesInterface, ScheduleInterface, ServiceInterface } from "@/helpers/types";
import { useDateTimeHandler } from "../composables/useDateTimeHandler";

import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const emit = defineEmits(["scheduleUpdated"]);
defineExpose({
    openAndSetData,
    hide: () => modalRef.value?.hide(),
    show: () => modalRef.value?.show()
});

const schema = toTypedSchema(
    yup.object({
        serviceId: yup.number().required("service is a required field").positive().max(200, "price cannot be more than 200"),
        date: yup.date().required("date is a required field"),
        time: yup.string().required("time field is required").matches(/^\d{2}:\d{2}:\d{2}$/, "invalid time"),
    }),
);

const { defineField, resetForm, validate, errors } = useForm({
    validationSchema: schema,
});

const [serviceId, serviceIdAttrs] = defineField("serviceId");
const [date, dateAttrs] = defineField("date");
const [time, timeAttrs] = defineField("time");

const { format, handleDate, getFormattedDate, toLocalDate, times, isDisabled } = useDateTimeHandler(time);

const modalRef = ref<Modal | null>(null);
const scheduleId = ref<number | null>(null);
const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);
const services = ref<ServiceInterface[]>([]);

const onlyFreeDays = computed<Date[]>(() => {
    return availableDateTimes.value.map(dateTime => {
        const [year, month, day] = dateTime.date.split('-').map(Number);
        return new Date(year, month - 1, day);
    });
});

function openAndSetData(schedule: ScheduleInterface) {

    scheduleId.value = schedule.id;
    serviceId.value = schedule.service.id;
    date.value = toLocalDate(schedule.date);
    time.value = schedule.time;

    handleDate(toLocalDate(schedule.date), availableDateTimes.value);

    if (times.value.length === 0) {
        times.value.unshift(schedule.time);
        isDisabled.value = false;
    }

    time.value = schedule.time;
    modalRef.value?.show();
}

async function saveChanges() {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-3",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    const result = await validate();

    if (!result.valid) {

        swalWithBootstrapButtons.fire({
            icon: "error",
            title: "Oops...",
            text: "Please check all fields and fill them correctly!"
        });

        return;
    }
    
    try {

        const { data } = await axiosInstance.put(`/api/v1/schedules/${scheduleId.value}`, {
            service_id: serviceId.value,
            date: getFormattedDate(date.value),
            time: time.value,
        });

        if (data.success) {

            emit("scheduleUpdated");

            modalRef.value?.hide();

            swalWithBootstrapButtons.fire({
                icon: "success",
                title: data.message,
            });
        }

    }

    catch (error: any) {
        swalWithBootstrapButtons.fire({
            icon: "error",
            title: error.response.data.message || "An error occurred!",
        });
    }

}

onMounted(async () => {

    availableDateTimes.value = await getAvailableDateTimes();
    services.value = await getAllServices();

    const modalElement = document.getElementById("scheduleEditModal");
    if (modalElement) {
        modalRef.value = new Modal(modalElement);
    }
});

</script>