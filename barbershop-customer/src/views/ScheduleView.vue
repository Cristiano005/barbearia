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
                <form class="row mt-5">
                    <div class="col-12 has-validation mb-3">
                        <label for="service" class="form-label">Service*</label>
                        <select class="form-control p-3" id="service" v-model="form.serviceId">
                            <option v-for="service of services" :key="`service${service.id}`" :value="service.id">
                                {{ service.name.toUpperCase() }} -
                                {{ currentFormatter(Number(service.price)) }}
                            </option>
                        </select>
                        <div ref="emailMessageContainer"></div>
                    </div>
                    <div class="col-sm-6 has-validation mb-3">
                        <label for="password" class="form-label">Date*</label>
                        <VueDatePicker v-model="form.date" @update:model-value="handleDate" ref="dateInput"
                            :enableTimePicker="false" :format="format" :allowed-dates="onlyFreeDays"
                            placeholder="Select a date" id="date" />
                        <div ref="dateMessageContainer"></div>
                    </div>
                    <div class="col-sm-6 has-validation mb-3">
                        <label for="password" class="form-label">Time*</label>
                        <select v-model="form.time" class="form-control p-3" ref="timeInput" :disabled="isDisabled">
                            <option value=""> Selecione um horário </option>
                            <option v-for="time of times" :key="`time${time}`" :value="time"> {{ time }}
                            </option>
                        </select>
                        <div ref="timeMessageContainer"></div>
                    </div>
                    <div class="col-12 has-validation mb-3">
                        <label for="password" class="form-label">Payment Type*</label>
                        <select class="form-control p-3" id="service" v-model="form.paymentId">
                            <option v-for="payment of payments" :key="`payment${payment.id}`" :value="payment.id">
                                {{ payment.payment_type }}
                            </option>
                        </select>
                        <div ref="passwordMessageContainer"></div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="button" class="btn btn-dark p-3 w-100" @click="schedule">Schedule</button>
                    </div>
                </form>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Barber Shop" class="d-none d-xl-block vh-100 object-fit-cover col-xl-6" />
    </div>
</template>

<script setup lang="ts">

import { onMounted, ref, reactive, computed } from 'vue';

import { useRouter } from 'vue-router'

import { axiosInstance, validate, format, getAvailableDateTimes } from '@/helpers/helper';
import type { ServiceInterface, PaymentTypeInterface, AvailableDateTimesInterface } from '@/helpers/types';

import Swal from 'sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const services = ref<ServiceInterface[]>([]);
const times = ref<String[]>([]);
const payments = ref<PaymentTypeInterface[]>([]);
const availableDateTimes = ref<AvailableDateTimesInterface[]>([]);

const form = reactive({
    serviceId: 1 as number,
    date: null as Date | null,
    time: "" as string,
    paymentId: 2 as number,
});

const router = useRouter();
const isDisabled = ref<boolean>(true);

const dateInput = ref<HTMLInputElement | null>(null);
const timeInput = ref<HTMLInputElement | null>(null);

const dateMessageContainer = ref<HTMLDivElement | null>(null);
const timeMessageContainer = ref<HTMLDivElement | null>(null);

const currentFormatter = (price: number) => {
    return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
    }).format(price);
}

const getFormattedDate = (date: Date) => {
    const newDate = new Date(date);
    const day = String(newDate.getDate()).padStart(2, '0');
    const month = String(newDate.getMonth() + 1).padStart(2, '0');
    const year = newDate.getFullYear();

    return `${year}-${month}-${day}`;
}

const onlyFreeDays = computed<Date[]>(() => {
    return availableDateTimes.value.map(dateTime => {
        const [year, month, day] = dateTime.date.split('-').map(Number);
        return new Date(year, month - 1, day);
    });
})

const handleDate = (chosenDate: Date) => {

    const fullDate = getFormattedDate(chosenDate);

    times.value = availableDateTimes.value.filter(dateTime => dateTime.date === fullDate).map(dateTime => dateTime.time);

    if (times.value.length > 0) {
        isDisabled.value = false;
    } else {
        isDisabled.value = true;
        form.time = "";
    }
}

async function getAllServices() {

    try {
        const { data } = await axiosInstance.get("/api/v1/services");
        return data.data
    }

    catch (error) {
        console.log(error);
    }

}

function schedule() {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-3",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    const validatedDate: boolean = validate(dateInput.value.$el, dateMessageContainer.value, {
        name: "date",
        rules: ["empty"],
        value: form.date
    });

    const validatedTime: boolean = validate(timeInput.value, timeMessageContainer.value, {
        name: "time",
        rules: ["empty"],
        value: form.time
    });

    if ([validatedDate, validatedTime].includes(false)) {
        return;
    }

    try {

        const foundService: ServiceInterface | undefined = services.value.find(service => service.id === form.serviceId);
        const serviceName: string | undefined = foundService?.name;
        const servicePrice: number = foundService?.price === undefined ? 0 : Number(foundService.price);

        const paymentName = payments.value.find(payment => payment.id === form.paymentId)?.payment_type;

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            html: `
                <div class="text-start">
                    <p>
                        <strong>Date:</strong> ${format(form.date)}
                    </p>
                    <p>
                        <strong>Time:</strong> ${form.time}
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
                        service_id: form.serviceId,
                        payment_id: form.paymentId,
                        date: format(form.date),
                        time: form.time,
                    });

                    if (data.success === true) {

                        swalWithBootstrapButtons.fire("Success", data.message, "success");

                        form.serviceId = 1;
                        form.date = null;
                        form.time = "";
                        form.paymentId = 2;

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

async function getAllTypeOfPayments() {

    try {
        const { data } = await axiosInstance.get("/api/v1/payments");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

onMounted(async () => {
    services.value = await getAllServices();
    payments.value = await getAllTypeOfPayments();
    availableDateTimes.value = await getAvailableDateTimes();
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