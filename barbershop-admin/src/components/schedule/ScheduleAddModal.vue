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
                        <div class="mb-3 has-validation">
                            <label for="customer" class="col-form-label">Customer*</label>
                            <select :class="{
                                'form-select': true,
                                'h-100': true,
                                'p-2': true,
                                'is-invalid': errors.customerId
                            }" aria-label="Default select example" id="customer" v-model="customerId"
                                v-bind="customerIdAttrs">
                                <option v-for="customer of customers" :key="`customer${customer.id}`"
                                    :value="customer.id">
                                    {{ customer.name }} - {{ customer.email }}
                                </option>
                            </select>
                            <div :class="errors.customerId ? 'invalid-feedback' : ''">
                                {{ errors.customerId }}
                            </div>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="service" class="form-label">Service*</label>
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
                            <div :class="errors.serviceId ? 'invalid-feedback' : ''">
                                {{ errors.serviceId }}
                            </div>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="password" class="form-label">Date*</label>
                            <VueDatePicker :class="{ 'is-invalid': errors.date }" v-model="date" v-bind="dateAttrs"
                                @update:model-value="(val: Date) => handleDate(val, availableDateTimes)"
                                :enableTimePicker="false" :format="format" :allowed-dates="onlyFreeDays"
                                placeholder="Select a date" id="date" />
                            <div :class="errors.date ? 'invalid-feedback' : ''">
                                {{ errors.date }}
                            </div>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="password" class="form-label">Time*</label>
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
                        <div class="mb-3 has-validation">
                            <label for="paymentType" class="form-label">Payment Type*</label>
                            <select :class="{
                                'form-select': true,
                                'is-invalid': errors.paymentTypeId
                            }" id="paymentType" v-model="paymentTypeId" v-bind="paymentTypeIdAttrs">
                                <option v-for="payment of payments" :key="`payment${payment.id}`" :value="payment.id">
                                    {{ payment.payment_type }}
                                </option>
                            </select>
                            <div :class="errors.paymentTypeId ? 'invalid-feedback' : ''">
                                {{ errors.paymentTypeId }}
                            </div>
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

import { onMounted, reactive, ref, watch } from "vue";

import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/yup";
import * as yup from "yup";
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

const schema = toTypedSchema(
    yup.object({
        customerId: yup.number().required("customer is a required field").positive(),
        serviceId: yup.number().required("service is a required field").positive().max(200, "price cannot be more than 200"),
        date: yup.date().required("date is a required field"),
        time: yup.string().required("time field is required").matches(/^\d{2}:\d{2}:\d{2}$/, "invalid time"),
        paymentTypeId: yup.number().required("payment type field is required").positive(),
    }),
);

const { defineField, resetForm, validate, errors } = useForm({
    validationSchema: schema,
});

const [customerId, customerIdAttrs] = defineField("customerId");

const [serviceId, serviceIdAttrs] = defineField("serviceId");
watch(() => props.services, (services) => {
    serviceId.value = services.length ? Math.max(...services.map(s => s.id)) : 0;
});

const [date, dateAttrs] = defineField("date");
const [time, timeAttrs] = defineField("time");

const [paymentTypeId, paymentTypeIdAttrs] = defineField("paymentTypeId");

const customers = ref<CustomerInterface[]>([]);

const { format, handleDate, times, isDisabled } = useDateTimeHandler(time);

async function createSchedule() {

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

    const foundService: ServiceInterface | undefined = props.services.find(service => service.id === serviceId.value);
    const serviceName: string | undefined = foundService?.name;
    const servicePrice: number = foundService?.price === undefined ? 0 : Number(foundService.price);

    const paymentName = props.payments.find(payment => payment.id === paymentTypeId.value)?.payment_type;

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        html: `
                <div class="text-start">
                    <p>
                        <strong>Date:</strong> ${format(date.value)}
                    </p>
                    <p>
                        <strong>Time:</strong> ${time.value}
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
                    user_id: customerId.value,
                    service_id: serviceId.value,
                    payment_id: paymentTypeId.value,
                    date: format(date.value),
                    time: time.value,
                });

                if (data.success) {

                    swalWithBootstrapButtons.fire("Success", data.message, "success");

                    // serviceId = 1;
                    // date = "";
                    // time = "";
                    // paymentTypeId = 2;
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
    resetForm({
        values: {
            customerId: 1,
            time: "",
            paymentTypeId: 3,
        }
    });

    const el = document.getElementById("scheduleAddModal");
    if (!el) return;

    el.addEventListener("hidden.bs.modal", () => {
        resetForm({
            values: {
                customerId: 1,
                // serviceId: props.services.length ? Math.max(...props.services.map(s => s.id)) : 0, // ajustar isso depois!
                time: "",
                paymentTypeId: 3,
            }
        });
    });
});

</script>