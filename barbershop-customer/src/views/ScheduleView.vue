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
                        <select class="form-control p-3" id="service">
                            <option v-for="service of services" value=""> {{ service }} </option>
                        </select>
                        <div ref="emailMessageContainer"></div>
                    </div>
                    <div class="col-sm-6 has-validation mb-3">
                        <label for="password" class="form-label">Date*</label>
                        <VueDatePicker v-model="selectedDate" :min-date="new Date()" ref="dateInput" :enableTimePicker="false" :format="format" locale="pt-BR"
                         placeholder="Select a date" />
                        <div ref="dateMessageContainer"></div>
                    </div>
                    <div class="col-sm-6 has-validation mb-3">
                        <label for="password" class="form-label">Time*</label>
                        <VueDatePicker v-model="selectedTime" ref="timeInput" minutes-increment="30" time-picker
                            locale="pt-BR" placeholder="Select a time">
                            <template #input-icon>
                                <i class="bi bi-clock" id="clock-icon"></i>
                            </template>
                        </VueDatePicker>
                        <div ref="timeMessageContainer"></div>
                    </div>
                    <div class="col-12 has-validation mb-3">
                        <label for="password" class="form-label">Payment Type*</label>
                        <select class="form-control p-3" id="service">
                            <option v-for="payment of payments" value=""> {{ payment }} </option>
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

import { ref } from 'vue';

import { axiosInstance, validate } from '@/helpers/helper';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const services = ref<string[]>(['Service 1', 'Service 2']);
const payments = ref<string[]>(['Payment 1', 'Payment 2']);

const selectedDate = ref<Date | null>(null);
const selectedTime = ref<string>("");

const format = (date: Date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

const dateInput = ref<HTMLInputElement | null>(null);
const timeInput = ref<HTMLInputElement | null>(null);

const dateMessageContainer = ref<HTMLDivElement | null>(null);
const timeMessageContainer = ref<HTMLDivElement | null>(null);

async function schedule() {

    try {

        const validatedDate: boolean = validate(dateInput.value.$el, dateMessageContainer.value, {
            name: "date",
            rules: ["empty"],
            value: selectedDate.value
        });

        const validatedTime: boolean = validate(timeInput.value.$el, timeMessageContainer.value, {
            name: "time",
            rules: ["empty"],
            value: selectedTime.value
        });

        if (!validatedDate || validatedTime) {
            return;
        }

    } catch (error) {
        console.log(error)
    }

}

</script>

<style scoped lang="scss">
#clock-icon {
    margin-left: 0.75rem;
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