<template>
    <ScheduleEditModal ref="editModalRef" @schedule-updated="refreshSchedules" />
    <TheHeader />
    <main class="d-flex flex-column gap-5 p-5">
        <section class="container mx-auto">
            <div class="row">
                <header class="col-12 mw-30">
                    <h3>My Schedules</h3>
                </header>
            </div>
            <div class="gap-3 mt-4 mx-auto">
                <LoadingSpinner v-if="isLoadingSchedules" />
                <template v-else-if="schedules && schedules.length">
                    <UserScheduleCard v-for="schedule in schedules" :key="`schedule${schedule.id}`" :schedule="schedule"
                        @edit="openEditModal(schedule)" @cancel="deleteSchedule(schedule.id)" />
                </template>
                <template v-else>
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <img class="w-25" src="../assets/404_image.svg" alt=""></img>
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex align-items-center justify-content-center gap-2" role="alert">
                                <i class="bi bi-info-circle fs-2"></i>
                                <h5 class="mb-0"> No schedule found! </h5>
                            </div>
                            <RouterLink class="d-flex align-items-center justify-content-center btn btn-dark px-5 mt-4"
                                to="/schedule">
                                Schedule an hour
                                <i class="bi bi-alarm-fill p-2"></i>
                            </RouterLink>
                        </div>
                    </div>
                </template>
            </div>
        </section>
        <section class="container mx-auto">
            <div class="row">
                <header class="col-12 mw-30">
                    <h3>My Data</h3>
                </header>
            </div>
            <LoadingSpinner v-if="isLoadingSchedules" />
            <template v-else>
                <form class="row align-items-center mt-4">
                    <div class="col-4 mb-3 has-validation">
                        <label class="mb-1" for=""> Name: </label>
                        <input type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" placeholder="Input Name" aria-label="Name"
                            aria-describedby="basic-addon1" v-model="name" v-bind="nameAttrs">
                        <div :class="errors.name ? 'invalid-feedback' : ''">
                            {{ errors.name }}
                        </div>
                    </div>
                    <div class="col-4 mb-3 has-validation">
                        <label class="mb-1" for=""> Email: </label>
                        <input type="email" :class="['form-control', errors.email ? 'is-invalid' : '']" placeholder="Input E-mail" aria-label="Email"
                            aria-describedby="basic-addon1" disabled readonly v-model="email" v-bind="emailAttrs">
                        <div :class="errors.email ? 'invalid-feedback' : ''">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="col-4 mb-3 has-validation">
                        <label class="mb-1" for=""> Phone Number: </label>
                        <input type="text" :class="['form-control', errors.phone_number ? 'is-invalid' : '']" placeholder="Input Phone Number"
                            aria-label="Phone Number" aria-describedby="basic-addon1" v-model="phoneNumber"
                            v-bind="phoneNumberAttrs">
                            <div :class="errors.phone_number ? 'invalid-feedback' : ''">
                                {{ errors.phone_number }}
                            </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3 col-12">
                        <button type="button" class="btn btn-warning col-auto">
                            Recuperar senha
                            <i class="bi bi-key-fill"></i>
                        </button>
                        <button type="button" class="btn btn-success col-auto" @click="updateProfileData">
                            Atualizar Dados
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </div>
                </form>
            </template>
        </section>
    </main>
</template>

<script setup lang="ts">

import { onMounted, ref } from "vue";

import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/yup";
import * as yup from "yup";
import Swal from "sweetalert2";

import { axiosInstance } from "@/helpers/helper";
import type { ScheduleInterface } from "@/helpers/types";
import { useUserStore } from "@/stores/user";

import TheHeader from "@/components/TheHeader.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import UserScheduleCard from "@/components/UserScheduleCard.vue";
import ScheduleEditModal from "@/components/profile/ScheduleEditModal.vue";

const { refreshUser, update } = useUserStore();

const schema = toTypedSchema(
    yup.object({
        name: yup.string().required("name is a required field").min(2),
        email: yup.string().email().required(),
        phone_number: yup.string().required("phone number is a required field").matches(
            /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/,
            "Invalid phone number"
        ),
    }),
);

const { defineField, resetForm, validate, errors } = useForm({
    validationSchema: schema,
});

const [name, nameAttrs] = defineField("name");
const [email, emailAttrs] = defineField("email");
const [phoneNumber, phoneNumberAttrs] = defineField("phone_number");

const editModalRef = ref(null);

const isLoadingSchedules = ref<boolean>(true);
const isLoadingProfileData = ref<boolean>(true);

const schedules = ref<ScheduleInterface[] | null>(null);

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success mx-3",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});

async function updateProfileData() {

    const result = await validate();

    if (!result.valid) {

        swalWithBootstrapButtons.fire({
            icon: "error",
            title: "Oops...",
            text: "Please check all fields and fill them correctly!"
        });

        return;
    }

    swalWithBootstrapButtons.fire({
        title: "Are you sure you want to update your data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, update it!"
    }).then(async (result) => {

        if (result.isConfirmed) {

            const response = await update(
                name.value as string,
                phoneNumber.value as string
            );

            if (response.success) {

                swalWithBootstrapButtons.fire({
                    icon: "success",
                    title: "Data updated successfully!",
                });

                return;
            }

            Swal.fire({
                icon: "error",
                title: response.message ?? "Update failed",
            });
        }
    });
}

async function getMyAllSchedules() {

    try {
        const { data } = await axiosInstance.get("/api/v1/schedules");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function refreshSchedules() {
    schedules.value = await getMyAllSchedules();
}

async function openEditModal(schedule: ScheduleInterface) {
    editModalRef.value?.openAndSetData(schedule);
}

async function deleteSchedule(id: number) {

    const result = await swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You'll need to schedule again.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, cancel it!",
        cancelButtonText: "Don't cancel it!",
        reverseButtons: true
    });

    if (result.isConfirmed) {

        try {

            const { data } = await axiosInstance.delete(`/api/v1/schedules/${id}`);

            if (data.success) {

                Swal.fire({
                    icon: "success",
                    title: "Schedule was cancelled successfully!",
                });

                schedules.value = await getMyAllSchedules();
            }
        }

        catch (error) {
            console.log(error);
        }
    }
}

onMounted(async () => {

    try {

        const [fetchedSchedules, userData] = await Promise.all([
            getMyAllSchedules(),
            refreshUser(),
        ]);

        schedules.value = fetchedSchedules;
        name.value = userData.name;
        email.value = userData.email;
        phoneNumber.value = userData.phone_number;

    } catch (error) {
        console.error(error);
    } finally {
        isLoadingSchedules.value = false;
        isLoadingProfileData.value = false;
    }
});

</script>

<style scoped lang="scss">

.cursor-pointer {
    cursor: pointer;
}

main {
    margin-top: 4.5rem;

    .has-validation {
        height: 91px;
    }
}

section {
    padding: 0;
}

</style>