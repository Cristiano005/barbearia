<template>
    <EditScheduleModal ref="editModalRef" @schedule-updated="getMyAllSchedules" />
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
                    <div class="col-4 mb-3">
                        <label class="mb-1" for=""> Name: </label>
                        <input type="text" class="form-control" placeholder="Input Name" aria-label="Name"
                            aria-describedby="basic-addon1" v-model="profileData.name">
                    </div>
                    <div class="col-4 mb-3">
                        <label class="mb-1" for=""> Email: </label>
                        <input type="email" class="form-control" placeholder="Input E-mail" aria-label="Email"
                            aria-describedby="basic-addon1" disabled readonly v-model="profileData.email">
                    </div>
                    <div class="col-4 mb-3">
                        <label class="mb-1" for=""> Phone Number: </label>
                        <input type="text" class="form-control" placeholder="Input Phone Number"
                            aria-label="Phone Number" aria-describedby="basic-addon1"
                            v-model="profileData.phone_number">
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

import { onMounted, ref, reactive } from "vue";

import { axiosInstance } from "@/helpers/helper";
import type { ScheduleInterface, ProfileDataInterface } from "@/helpers/types";

import Swal from 'sweetalert2';

import TheHeader from "@/components/TheHeader.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import UserScheduleCard from "@/components/UserScheduleCard.vue";
import EditScheduleModal from "@/components/profile/EditScheduleModal.vue";

const editModalRef = ref(null);

const isLoadingSchedules = ref<boolean>(true);
const isLoadingProfileData = ref<boolean>(true);

const schedules = ref<ScheduleInterface[] | null>(null);

const profileData = reactive<ProfileDataInterface>({
    name: "",
    email: "",
    phone_number: "",
});

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success mx-3",
        cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});

async function getProfileData() {

    try {
        const { data } = await axiosInstance.get("/api/v1/user/me");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

    finally {
        isLoadingProfileData.value = false;
    }
}

function updateProfileData() {

    if (!profileData.name || !profileData.phone_number) {
        Swal.fire({
            icon: "error",
            title: "Please, fill all fields!",
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

            try {

                const { data } = await axiosInstance.put(`/api/v1/user/update`, {
                    name: profileData.name,
                    phone_number: profileData.phone_number
                });

                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Data updated successfully!",
                    });
                }
            }

            catch (error) {
                console.log(error);
            }
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

    finally {
        isLoadingSchedules.value = false;
    }
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
    const response = await getProfileData();
    schedules.value = await getMyAllSchedules();
    Object.assign(profileData, response);
});

</script>

<style scoped lang="scss">
.cursor-pointer {
    cursor: pointer;
}

main {
    margin-top: 4.5rem;
}

section {
    padding: 0;
}
</style>