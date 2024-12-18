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
                        <select class="form-control p-3" id="service" v-model="selectedService">
                            <option disabled selected :value="0"> SELECT SERVICE </option>
                            <option v-for="service of services" :value="service.id">
                                {{ service.name.toUpperCase() }} -
                                {{ currentFormatter(Number(service.price)) }}
                            </option>
                        </select>
                        <div ref="emailMessageContainer"></div>
                    </div>
                    <div class="col-sm-6 has-validation mb-3">
                        <label for="password" class="form-label">Date*</label>
                        <VueDatePicker :model-value="selectedDate" :min-date="new Date()" ref="dateInput"
                            :enableTimePicker="false" :format="format" locale="pt-BR"
                            @update:model-value="searchTimesAvailable" placeholder="Select a date" id="date" />
                        <div ref="dateMessageContainer"></div>
                    </div>
                    <div class="col-sm-6 has-validation mb-3">
                        <label for="password" class="form-label">Time*</label>
                        <select v-model="selectedTime" class="form-control p-3" ref="timeInput" disabled>
                            <option disabled selected value=""> Select a time </option>
                            <option v-for="time of times" :value="time.time"> {{ time.time }} </option>
                        </select>
                        <div ref="timeMessageContainer"></div>
                    </div>
                    <div class="col-12 has-validation mb-3">
                        <label for="password" class="form-label">Payment Type*</label>
                        <select class="form-control p-3" id="service" v-model="selectedPayment">
                            <option disabled selected :value="0"> SELECT A TYPE OF PAYMENT </option>
                            <option v-for="payment of payments" :value="payment.id"> {{ payment.payment_type }} </option>
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

import { onMounted, ref } from 'vue';

import { axiosInstance, validate, format } from '@/helpers/helper';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

interface ServiceInterface {
    id: number,
    name: string,
    price: string,
}

interface AvailabilityInterface {
    id: number,
    date: string,
    time: string,
}

interface PaymentTypeInterface {
    id: number,
    payment_type: string,
}

const services = ref<ServiceInterface[]>([]);
const times = ref<AvailabilityInterface[]>([]);
const payments = ref<PaymentTypeInterface[]>([]);

const selectedService = ref<number>(0);
const selectedDate = ref<Date>();
const selectedTime = ref<string>("");
const selectedPayment = ref<number>(0);

const currentFormatter = (price: number) => {
    return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
    }).format(price);
}

const dateInput = ref<HTMLInputElement | null>(null);
const timeInput = ref<HTMLInputElement | null>(null);

const dateMessageContainer = ref<HTMLDivElement | null>(null);
const timeMessageContainer = ref<HTMLDivElement | null>(null);

async function getAllServices() {

    try {
        const { data } = await axiosInstance.get("/api/v1/services");
        return data.data
    }

    catch (error) {
        console.log(error);
    }

}

async function searchTimesAvailable(date: Date | null) {

    selectedDate.value = date

    if (date) {

        try {
            const formattedDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().split("T")[0];
            const { data } = await axiosInstance.get(`/api/v1/availabilities?date=${formattedDate}`);
            timeInput.value?.removeAttribute("disabled");
            return times.value = data.data;
        }

        catch (error) {
            console.log(error);
        }

    }

    else {
        timeInput.value?.setAttribute("disabled", "true");
        selectedTime.value = "";
    }
}

async function schedule() {

    try {

        const validatedDate: boolean = validate(dateInput.value.$el, dateMessageContainer.value, {
            name: "date",
            rules: ["empty"],
            value: selectedDate.value
        });

        const validatedTime: boolean = validate(timeInput.value, timeMessageContainer.value, {
            name: "time",
            rules: ["empty"],
            value: selectedTime.value
        });

        console.log(selectedService.value === 0, !validatedDate, !validatedTime, selectedPayment.value === 0)

        if (selectedService.value === 0 || !validatedDate || !validatedTime || selectedPayment.value === 0) {
            return; 
        }

        console.log(selectedService.value);

        const { data } = await axiosInstance.post("/api/v1/schedules", {
            service_id: selectedService.value,
            payment_id: selectedPayment.value,
            date: format(selectedDate.value),
            time: selectedTime.value,
        });

        if(data.success === true) {
            alert("nice!")
        }

    } catch (error) {
        console.log(error)
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