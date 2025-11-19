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
                        <div class="mb-3">
                            <label for="service-to-schedule" class="col-form-label">Service:</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="service-to-schedule" v-model="formData.serviceId">
                                <option v-for="service of services" :key="service.id" :value="service.id">
                                    {{ service.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Date*</label>
                            <VueDatePicker v-model="formData.date"
                                @update:model-value="(val: Date) => handleDate(val, availableDateTimes)"
                                :format="format" ref="dateInput" :enableTimePicker="false" :allowed-dates="onlyFreeDays"
                                placeholder="Select a date" id="date" />
                            <div ref="dateMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Time*</label>
                            <select class="form-control" ref="timeInput" :disabled="isDisabled" v-model="formData.time">
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

import { reactive, toRef } from "vue";

import Swal from "sweetalert2";
import VueDatePicker from "@vuepic/vue-datepicker";

import { axiosInstance } from "@/helpers/helper";
import type { AvailableDateTimesInterface, ServiceInterface } from "@/helpers/types";
import { useDateTimeHandler } from "../composables/useDateTimeHandler";

const props = defineProps<{
    services: ServiceInterface[],
    availableDateTimes: AvailableDateTimesInterface[],
    onlyFreeDays: Date[],
    scheduleId: number | null
}>();

const emits = defineEmits(["updated"]);

const formData = reactive<{
    serviceId: number,
    date: Date | null,
    time: string,
}>({
    serviceId: 1,
    date: null,
    time: "",
});

const { isDisabled, handleDate, getFormattedDate, format, times } = useDateTimeHandler(toRef(formData, "time"));

async function saveChanges() {

    try {

        const { data } = await axiosInstance.put(`/api/v1/admin/schedules/${props.scheduleId}`, {
            service_id: formData.serviceId,
            date: getFormattedDate(formData.date),
            time: formData.time,
        });

        Swal.fire({
            icon: "success",
            title: data.message,
        });

        formData.date = null;
        formData.time = "";

        isDisabled.value = true;

        emits("updated");
    }

    catch (error: any) {
        Swal.fire({
            icon: "error",
            title: error.response.data.message || "An error occurred!",
        });
    }
}

</script>