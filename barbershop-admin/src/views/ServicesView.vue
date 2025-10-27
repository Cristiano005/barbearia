<template>
    <ServiceAddModal @service-added="getAllServices"/>
    <ServiceEditModal ref="editModalRef" @service-updated="getAllServices" />
    <TheHeader />
    <main class="p-5">
        <div class="container mx-auto">
            <div class="row gap-4">
                <header class="d-flex justify-content-between align-itesm-center flex-wrap mw-30">
                    <h3>Services</h3>
                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                        data-bs-target="#serviceAddModal">
                        Add Service
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </header>
                <div class="d-flex flex-column align-items-center col-12 gap-3">
                    <template v-if="isLoadingServices">
                        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                            <div class="fs-4 spinner-border text-dark text-center" style="width: 3rem; height: 3rem;"
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <strong role="status">Loading...</strong>
                        </div>
                    </template>
                    <template v-else-if="services && services.length">
                        <ServiceCard class="w-100" :service="service" v-for="service of services"
                            :key="`service${service.id}`" @edit="openEditModal(service)"
                            @cancel="deleteService(service.id)" />
                        <Pagination :pagination="pagination" @goToPage="goToPage" />
                    </template>
                    <template v-else="services && !services.length">
                        <div class="d-flex flex-column justify-content-center text-center gap-4" style="width: 200px;">
                            <img class="w-100" src="../assets/empty_data.svg">
                            <h4> No Schedules </h4>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </main>
</template>

<script setup lang="ts">

import { ref, onMounted } from 'vue';

import Swal from 'sweetalert2';
import '@vuepic/vue-datepicker/dist/main.css';

import { axiosInstance } from '@/helpers/helper';
import type { PaginationInterface, ServiceInterface } from '@/helpers/types';

import TheHeader from "@/components/TheHeader.vue";
import Pagination from "@/components/Pagination.vue";
import ServiceCard from "@/components/ServiceCard.vue";
import ServiceAddModal from '@/components/service/ServiceAddModal.vue';
import ServiceEditModal from '@/components/service/ServiceEditModal.vue';

const services = ref<ServiceInterface[]>([]);

const isLoadingServices = ref<boolean>(true);
const pagination = ref<PaginationInterface>({
    quantityOfPages: 1,
    currentPage: 1,
});

const editModalRef = ref<InstanceType<typeof ServiceEditModal> | null>(null);

async function goToPage(page: number) {
    pagination.value.currentPage = page;
    services.value = await getAllServices();
}

function openEditModal(service: ServiceInterface) {
    editModalRef.value?.openAndSetData(service);
}

async function getAllServices() {

    try {
        const { data } = await axiosInstance.get(`/api/v1/admin/services?page=${pagination.value.currentPage}`);
        pagination.value.quantityOfPages = data.meta.last_page;
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

    finally {
        isLoadingServices.value = false;
    }
}

async function deleteService(id: number) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-3",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    const result = await swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "The service will be deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Don't delete it!",
        reverseButtons: true
    });

    if (result.isConfirmed) {

        try {

            const { data } = await axiosInstance.delete(`/api/v1/admin/services/${id}`);

            if (data.success) {

                Swal.fire({
                    icon: "success",
                    title: "Service was deleted successfully!",
                });

                services.value = await getAllServices();
            }
        }

        catch (error) {
            console.log(error);
        }
    }

}

onMounted(async () => {
    services.value = await getAllServices();
});

</script>

<style>
.input-slot-image {
    height: 1.25rem;
    width: auto;
    margin: 0 0 0.17rem 0.5rem;
}
</style>
