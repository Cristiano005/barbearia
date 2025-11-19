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
                            <label for="customer" class="col-form-label">Customer*</label>
                            <select class="form-select h-100 p-2 border border-dark" aria-label="Default select example"
                                id="customer" v-model="formData.customerId">
                                <option v-for="customer of customers" :key="`customer${customer.id}`"
                                    :value="customer.id">
                                    {{ customer.name }} - {{ customer.email }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="service" class="form-label">Service*</label>
                            <select class="form-control" id="service" v-model="formData.serviceId">
                                <option v-for="service of services" :key="`service${service.id}`" :value="service.id">
                                    {{ service.name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Date*</label>
                            <VueDatePicker v-model="formData.date"
                                @update:model-value="(val: Date) => handleDate(val, availableDateTimes)" ref="dateInput"
                                :enableTimePicker="false" :format="format" :allowed-dates="onlyFreeDays"
                                placeholder="Select a date" id="date" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Time*</label>
                            <select class="form-control" ref="timeInput" v-model="formData.time" :disabled="isDisabled">
                                <option value=""> Selecione um horário </option>
                                <option v-for="time of times" :key="`time${time}`" :value="time"> {{ time }}
                                </option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Payment Type*</label>
                            <select class="form-control" id="service" v-model="formData.paymentTypeId">
                                <option v-for="payment of payments" :key="`payment${payment.id}`" :value="payment.id">
                                    {{ payment.payment_type }}
                                </option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" @click="createSchedule">Add Schedule</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import { onMounted, reactive, ref, toRef } from "vue";

import Swal from "sweetalert2";
import VueDatePicker from "@vuepic/vue-datepicker";

import { axiosInstance } from "@/helpers/helper";
import type { AvailableDateTimesInterface, CustomerInterface, PaymentTypeInterface, ServiceInterface } from "@/helpers/types";
import { useDateTimeHandler } from "../composables/useDateTimeHandler";

const props = defineProps<{
    services: ServiceInterface[],
    payments: PaymentTypeInterface[],
    availableDateTimes: AvailableDateTimesInterface[],
    onlyFreeDays: Date[],
}>();

const customers = ref<CustomerInterface[]>([]);

const formData = reactive<{
    customerId: number,
    serviceId: number,
    date: string,
    time: string,
    paymentTypeId: number,
}>({
    customerId: 1,
    serviceId: 1,
    date: "",
    time: "",
    paymentTypeId: 3,
});

const { format, handleDate, times, isDisabled } = useDateTimeHandler(toRef(formData, "time"));

async function createSchedule() {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-3",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    const foundService: ServiceInterface | undefined = props.services.find(service => service.id === formData.serviceId);
    const serviceName: string | undefined = foundService?.name;
    const servicePrice: number = foundService?.price === undefined ? 0 : Number(foundService.price);

    const paymentName = props.payments.find(payment => payment.id === formData.paymentTypeId)?.payment_type;

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        html: `
                <div class="text-start">
                    <p>
                        <strong>Date:</strong> ${format(formData.date)}
                    </p>
                    <p>
                        <strong>Time:</strong> ${formData.time}
                    </p>
                    <p>
                        <strong>Service:</strong> ${serviceName}
                    </p>
                    <p>
                        <strong>Price:</strong> ${servicePrice}
                    </p>
                    <p>
                        <strong>Payment:</strong>  ${paymentName}
                    </p>
                </div>
                <div class="alert alert-warning mt-3" role="alert">
                    Please confirm that the information above is correct.
                </div> 
            `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, schedule it!"
    }).then(async (result) => {

        if (result) {

            try {

                const { data } = await axiosInstance.post("/api/v1/admin/schedules", {
                    user_id: formData.customerId,
                    service_id: formData.serviceId,
                    payment_id: formData.paymentTypeId,
                    date: format(formData.date),
                    time: formData.time,
                });

                if (data.success) {

                    swalWithBootstrapButtons.fire("Success", data.message, "success");

                    formData.serviceId = 1;
                    formData.date = "";
                    formData.time = "";
                    formData.paymentTypeId = 2;
                }

            } catch (error) {
                console.log(error);
            }
        }
    });
}

async function getAllCustomers() {

    try {
        const { data } = await axiosInstance.get("/api/v1/admin/users");
        return data.data;
    } catch (error) {
        console.log(error);
    }

}

onMounted(async () => {
    customers.value = await getAllCustomers();
});

</script>