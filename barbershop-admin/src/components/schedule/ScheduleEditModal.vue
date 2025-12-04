<template>
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
                        <div class="mb-3 has-validation">
                            <label for="service-to-schedule" class="col-form-label">Service:</label>
                            <select :class="{
                                'form-select': true,
                                'h-100': true,
                                'p-2': true,
                                'is-invalid': errors.serviceId
                            }" id="service" v-model="serviceId" v-bind="serviceIdAttrs">
                                <option v-for="service of services" :key="`service${service.id}`" :value="service.id">
                                    {{ service.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="date" class="form-label">Date*</label>
                            <VueDatePicker :class="{ 'is-invalid': errors.date }" v-model="date" v-bind="dateAttrs"
                                @update:model-value="(val: Date) => handleDate(val, availableDateTimes)"
                                :enableTimePicker="false" :format="format" :allowed-dates="onlyFreeDays"
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
                            }" v-model="time" v-bind="timeAttrs" :disabled="isDisabled">
                                <option value=""> Select a hour </option>
                                <option v-for="time of times" :key="`time${time}`" :value="time"> {{ time }}
                                </option>
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

import { onMounted, watch } from "vue";

import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/yup";
import * as yup from "yup";
import Swal from "sweetalert2";
import VueDatePicker from "@vuepic/vue-datepicker";

import { axiosInstance } from "@/helpers/helper";
import type { AvailableDateTimesInterface, ScheduleInterface, ServiceInterface } from "@/helpers/types";
import { useDateTimeHandler } from "../composables/useDateTimeHandler";

const props = defineProps<{
    schedule: ScheduleInterface | null,
    services: ServiceInterface[],
    availableDateTimes: AvailableDateTimesInterface[],
    onlyFreeDays: Date[],
    scheduleId: number | null
}>();

const emits = defineEmits(["updated"]);

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

const { isDisabled, handleDate, getFormattedDate, format, times } = useDateTimeHandler(time);

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

        console.log(props.scheduleId)

        const { data } = await axiosInstance.put(`/api/v1/admin/schedules/${props.scheduleId}`, {
            service_id: serviceId.value,
            date: getFormattedDate(date.value),
            time: time.value,
        });

        Swal.fire({
            icon: "success",
            title: data.message,
        });

        isDisabled.value = true;

        emits("updated");
    }

    catch (error: any) {
        console.log(error);
        Swal.fire({
            icon: "error",
            title: error.response.data.message || "An error occurred!",
        });
    }
}

onMounted(() => {

    const el = document.getElementById("scheduleEditModal");
    if (!el) return;

    el.addEventListener("shown.bs.modal", () => {
        if (!props.schedule) return;

        resetForm({ // Parei aqui onde preciso verificar o problema de abrir o modal e demorar 2 segundos pra preencher os valores.
            values: {
                serviceId: props.schedule.service.id,
                date: new Date(props.schedule.date),
                time: props.schedule.time,
            },
        });

        handleDate(new Date(props.schedule.date), props.availableDateTimes);
        isDisabled.value = false;
    });

    el.addEventListener("hidden.bs.modal", () => {
        resetForm();
        isDisabled.value = true;
    });
});

</script>