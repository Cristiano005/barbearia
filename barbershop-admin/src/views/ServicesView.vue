<template>
    <div class="modal fade" id="serviceAddModal" tabindex="-1" aria-labelledby="serviceAddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceAddModalLabel">Add Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="serviceName" id="serviceName"
                                placeholder="Service name" v-model="serviceNameToCreate">
                            <div ref="timeMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="servicePrice" class="form-label">Price*</label>
                            <BRLInput placeholder="R$ 0,00" v-model="servicePriceToCreate" :options="BRL_INPUT_OPTIONS" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" @click="addService()">Add Service</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="serviceEditModal" tabindex="-1" aria-labelledby="serviceEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="serviceEditModalLabel">Edit Service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="serviceId" id="serviceId">
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Name*</label>
                            <input type="text" class="form-control" name="serviceName" id="serviceName"
                                placeholder="Service name" v-model="serviceNameToUpdate">
                            <div ref="timeMessageContainer"></div>
                        </div>
                        <div class="mb-3">
                            <label for="servicePrice" class="form-label">Price*</label>
                            <BRLInput placeholder="R$ 0,00" v-model="servicePriceToUpdate" :options="BRL_INPUT_OPTIONS" />
                            <div ref="timeMessageContainer"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning"
                        @click="updateService(serviceIdToUpdate, serviceNameToUpdate, servicePriceToUpdate)">Update
                        Service</button>
                </div>
            </div>
        </div>
    </div>
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
                            :key="`service${service.id}`" @edit="openEditModal(service)" @cancel="deleteService(service.id)"/>
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

import { Modal } from "bootstrap";
import Swal from 'sweetalert2';
import '@vuepic/vue-datepicker/dist/main.css';
import { useCurrencyInput } from 'vue-currency-input';

import { axiosInstance } from '@/helpers/helper';
import type { PaginationInterface, ServiceInterface } from '@/helpers/types';
import { BRL_INPUT_OPTIONS } from '@/utils/currencySettings';

import TheHeader from "@/components/TheHeader.vue";
import Pagination from "@/components/Pagination.vue";
import ServiceCard from "@/components/ServiceCard.vue";
import BRLInput from "@/components/BRLInput.vue";

const serviceNameToCreate = ref<string>("");
const servicePriceToCreate = ref<number | null>(null);

const serviceIdToUpdate = ref<number>(0);
const serviceNameToUpdate = ref<string>("");
const servicePriceToUpdate = ref<number | null>(null);

const services = ref<ServiceInterface[]>([]);

const isLoadingServices = ref<boolean>(true);
const pagination = ref<PaginationInterface>({
    quantityOfPages: 1,
    currentPage: 1,
});

let addModalInstance: Modal | null = null;
let editModalInstance: Modal | null = null;

function formatPrice(price: number | string) {
    price = typeof price === "string" ? parseFloat(price) / 100 : price;
    return `R$ ${price}`;
}

async function openEditModal(service: ServiceInterface) {

    editModalInstance.show();

    serviceIdToUpdate.value = service.id;
    serviceNameToUpdate.value = service.name;
    servicePriceToUpdate.value = parseFloat(service.price);
}

async function goToPage(page: number) {
    pagination.value.currentPage = page;
    services.value = await getAllServices();
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

async function addService() {

    if (!serviceNameToCreate.value || !servicePriceToCreate.value) {
        Swal.fire({
            icon: "error",
            title: "Please, fill all fields!",
        });
        return;
    }

    try {

        const { data } = await axiosInstance.post(`/api/v1/admin/services`, {
            name: serviceNameToCreate.value,
            price: servicePriceToCreate.value,
        });

        if (data.success) {

            addModalInstance.hide();

            Swal.fire({
                icon: "success",
                title: data.message,
            });

            services.value = await getAllServices();
        }
    }

    catch (error) {
        console.log(error);
    }
}

async function updateService(id: number, name: string, price: string) {

    try {

        const { data } = await axiosInstance.put(`/api/v1/admin/services/${id}`, {
            name: name,
            price: price,
        });

        if (data.success) {

            editModalInstance.hide();

            Swal.fire({
                icon: "success",
                title: "Service was updated successfully!",
            });

            services.value = await getAllServices();
        }
    }

    catch (error) {
        console.log(error);
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
    addModalInstance = new Modal(document.querySelector("#serviceAddModal"));
    editModalInstance = new Modal(document.querySelector("#serviceEditModal"))
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
