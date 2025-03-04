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
                            <input type="text" class="form-control" name="servicePrice" id="servicePrice"
                                placeholder="Service price" v-model="servicePriceToCreate">
                            <div ref="timeMessageContainer"></div>
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
                            <input type="text" class="form-control" name="servicePrice" id="servicePrice"
                                placeholder="Service price" v-model="servicePriceToUpdate">
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
            <header class="d-flex justify-content-between align-itesm-center flex-wrap mw-30">
                <h3>Services</h3>
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                    data-bs-target="#serviceAddModal">
                    Add Service
                    <i class="bi bi-plus-circle"></i>
                </button>
            </header>
            <div class="d-flex flex-column gap-3 mt-4 mx-auto">
                <template v-if="services && services.length">
                    <div class="row align-items-center text-bg-dark p-3 rounded m-0" v-for="service of services"
                        :key="`service${service.id}`">
                        <div class="col-auto">
                            <i class="bi bi-scissors fs-1"></i>
                        </div>
                        <div class="col-10 border-end">
                            <h6>
                                {{ service.name }}
                            </h6>
                            <small>
                                {{ service.price }}
                            </small>
                        </div>
                        <div class="d-flex col-auto gap-4 ps-5">
                            <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"
                                @click="openEditModal(service.id, service.name, service.price)"></i>
                            <i class="fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"
                                @click="deleteService(service.id)"></i>
                        </div>
                    </div>
                </template>
                <template v-else-if="services && !services.length">
                    <h2> Data not found </h2>
                </template>
                <template v-else>
                    <h2> Loading... </h2>
                </template>
                <nav aria-label="...">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#">
                                1
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">

import TheHeader from '@/components/TheHeader.vue';
import { axiosInstance } from '@/helpers/helper';

import { ref, onMounted } from 'vue';

import { Modal } from "bootstrap";
import Swal from 'sweetalert2';
import '@vuepic/vue-datepicker/dist/main.css';

interface ServiceInterface {
    id: number,
    name: string,
    price: string,
}

const serviceNameToCreate = ref<string>("");
const servicePriceToCreate = ref<string>("");

const serviceIdToUpdate = ref<number>(0);
const serviceNameToUpdate = ref<string>("");
const servicePriceToUpdate = ref<string>("");

const services = ref<ServiceInterface[]>([]);

let addModalInstance: Modal | null = null;
let editModalInstance: Modal | null = null;

function formatPrice(price: number | string) {
    price = typeof price === "string" ? parseFloat(price) / 100 : price;
    return `R$ ${price}`;
}

async function getAllServices() {

    try {
        const { data } = await axiosInstance.get("/api/v1/admin/services");
        return data.data;
    }

    catch (error) {
        console.log(error);
    }

}

async function openEditModal(id: number, name: string, price: string) {

    editModalInstance.show();

    serviceIdToUpdate.value = id;
    serviceNameToUpdate.value = name;
    servicePriceToUpdate.value = formatPrice(parseFloat(price));
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

            const { data } = await axiosInstance.delete(`/api/v1/service/${id}`);

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
