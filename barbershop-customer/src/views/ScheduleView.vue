<template>
    <div class="d-flex p-0 m-0 min-vh-100">
        <div class="col-xl-6 col-sm-12 d-flex justify-content-center align-items-center">
            <div class="container custom-width p-4">
                <div class="mt-4">
                    <h2 class="fs-2 mb-5">
                        <RouterLink class="text-dark text-decoration-none" to="/">
                            Barber Shop
                        </RouterLink>
                    </h2>
                    <h3>Access our platform.</h3>
                    <p class="mt-3">
                        Welcome back! Sign in to manage your appointments or book a new haircut.
                    </p>
                </div>
                <form class="row mt-5" style="height: 392px;">
                    <LoadingSpinner v-if="isLoading" />
                    <template v-else>
                        <div class="col-12 has-validation mb-3">
                            <label for="service" class="form-label">Service*</label>
                            <select :class="{
                                'form-select': true,
                                'p-3': true,
                                'is-invalid': errors.serviceId
                            }" id="service" v-model="serviceId" v-bind="serviceIdAttrs">
                                <option v-for="service of services" :key="`service${service.id}`" :value="service.id">
                                    {{ service.name.toUpperCase() }} -
                                    {{ currentFormatter(Number(service.price)) }}
                                </option>
                            </select>
                            <div ref="emailMessageContainer"></div>
                        </div>
                        <div class="col-sm-6 has-validation mb-3">
                            <label for="password" class="form-label">Date*</label>
                            <VueDatePicker :class="{ 'is-invalid': errors.date }" v-model="date" v-bind="dateAttrs"
                                @update:model-value="(val: Date) => handleDate(val, availableDateTimes)"
                                :enableTimePicker="false" :format="formatToHuman" :allowed-dates="onlyFreeDays"
                                placeholder="Select a date" id="date" />
                            <div :class="errors.date ? 'invalid-feedback' : ''">
                                {{ errors.date }}
                            </div>
                        </div>
                        <div class="col-sm-6 has-validation mb-3">
                            <label for="time" class="form-label">Time*</label>
                            <select v-model="time" v-bind="timeAttrs" :class="{
                                'form-select': true,
                                'p-3': true,
                                'is-invalid': errors.time
                            }" id="time" :disabled="isDisabled">
                                <option value=""> Select an hour </option>
                                <option v-for="time of times" :key="`time${time}`" :value="time"> {{ time }}
                                </option>
                            </select>
                            <div :class="errors.time ? 'invalid-feedback' : ''">
                                {{ errors.time }}
                            </div>
                        </div>
                        <div class="col-12 has-validation mb-3">
                            <label for="paymentType" class="form-label">Payment Type*</label>
                            <select :class="{
                                'form-select': true,
                                'p-3': true,
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
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-dark p-3 w-100" @click="schedule">Schedule</button>
                        </div>
                    </template>
                </form>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Barber Shop" class="d-none d-xl-block vh-100 object-fit-cover col-xl-6" />
    </div>
</template>

<script setup lang="ts">

import { onMounted, ref, computed } from "vue";

import { useRouter } from "vue-router";
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/yup";
import * as yup from "yup";
import Swal from "sweetalert2";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import { axiosInstance, getAvailableDateTimes } from "@/helpers/helper";
import type { ServiceInterface, PaymentTypeInterface, AvailableDateTimesInterface } from "@/helpers/types";

import { useDateFormatter } from "@/components/composables/useDateFormatter";
import { useDateTimeHandler } from "@/components/composables/useDateTimeHandler";

import LoadingSpinner from "@/components/LoadingSpinner.vue";

const schema = toTypedSchema(
    yup.object({
        serviceId: yup.number().required().positive(),
        date: yup.date().required(),
        time: yup.string().required(),
        paymentTypeId: yup.number().required("payment type field is required").positive().typeError("payment type field must be a number"),
    }),
);

const { defineField, resetForm, validate, errors } = useForm({
    validationSchema: schema,
});

const [serviceId, serviceIdAttrs] = defineField("serviceId");

const [date, dateAttrs] = defineField("date");
const [time, timeAttrs] = defineField("time");
const [paymentTypeId, paymentTypeIdAttrs] = defineField("paymentTypeId");

const { handleDate, times, isDisabled } = useDateTimeHandler(time);
const { formatToHuman } = useDateFormatter();

const router = useRouter();

const services = ref<ServiceInterface[]>([]);
const payments = ref<PaymentTypeInterface[]>([]);
const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);

const isLoading = ref<boolean>(true);

const currentFormatter = (price: number) => {
    return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
    }).format(price);
}

const onlyFreeDays = computed<Date[]>(() => {
    return availableDateTimes.value.map(dateTime => {
        const [year, month, day] = dateTime.date.split('-').map(Number);
        return new Date(year, month - 1, day);
    });
})

async function schedule() {

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

        const foundService: ServiceInterface | undefined = services.value.find(service => service.id === serviceId.value);
        const serviceName: string | undefined = foundService?.name;
        const servicePrice: number = foundService?.price === undefined ? 0 : Number(foundService.price);

        const paymentName = payments.value.find(payment => payment.id === paymentTypeId.value)?.payment_type;

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            html: `
                <div class="text-start">
                    <p>
                        <strong>Date:</strong> ${formatToHuman(date.value as Date)}
                    </p>
                    <p>
                        <strong>Time:</strong> ${time.value}
                    </p>
                    <p>
                        <strong>Service:</strong> ${serviceName}
                    </p>
                    <p>
                        <strong>Price:</strong> ${currentFormatter(servicePrice)}
                    </p>
                    <p>
                        <strong>Payment:</strong> ${paymentName}
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

            if (result.isConfirmed) {

                try {

                    const { data } = await axiosInstance.post("/api/v1/schedules", {
                        service_id: serviceId.value,
                        payment_id: paymentTypeId.value,
                        date: formatToHuman(date.value as Date),
                        time: time.value,
                    });

                    if (data.success === true) {
                        swalWithBootstrapButtons.fire("success", data.message, "success");
                        router.push("/profile");
                    }

                }

                catch (error) {
                    swalWithBootstrapButtons.fire(
                        "Error!",
                        "Sorry, an error occurred while trying to book your appointment. Please try again.",
                        "error"
                    );
                }

            }

            else {
                swalWithBootstrapButtons.fire(
                    "Cancelled!",
                    "Schedule cancelled.",
                    "error"
                );
            }
        });

    } catch (error) {
        console.log(error);
    }

}

onMounted(async () => {

    try {
        const [servicesRes, paymentsRes, availableRes] = await Promise.all([
            axiosInstance.get("/api/v1/services"),
            axiosInstance.get("/api/v1/payments"),
            getAvailableDateTimes()
        ]);

        services.value = servicesRes.data.data;
        payments.value = paymentsRes.data.data;
        availableDateTimes.value = availableRes;

        resetForm({
            values: {
                serviceId: serviceId.value = services.value.length ? Math.max(...services.value.map(s => s.id)) : 0,
                time: "",
                paymentTypeId: 3,
            }
        });

    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
});

</script>

<style scoped lang="scss">
#clock-icon {
    margin-left: 0.75rem;
}

::v-deep(#date input) {
    height: 3.625rem;
}

@media (min-width: 768px) {
    .custom-width {
        width: 75%;
    }
}

@media (max-width: 768px) {
    .custom-width {
        width: 100%;
    }
}
</style>