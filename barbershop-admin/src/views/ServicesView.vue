<template>
    <TheHeader />
    <main class="p-5">
        <div class="modal fade" id="service-modal" tabindex="-1" aria-labelledby="service-modal-label" aria-hidden="true" ref="service-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="service-modal-label">New service</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="customer" class="col-form-label">Service:</label>
                                <input type="text" class="form-control border border-dark" placeholder="service" id="customer" />
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="col-form-label">Price:</label>
                                <input
                                    type="text"
                                    class="form-control border border-dark"
                                    placeholder="R$ 0,00"
                                    id="service-price" />
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="col-form-label">Duration Time:</label>
                                <VueDatePicker class="border border-dark rounded" v-model="durationTime" time-picker placeholder="duration">
                                    <template #input-icon>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            fill="currentColor"
                                            class="bi bi-hourglass input-slot-image color-dark"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z" />
                                        </svg>
                                    </template>
                                </VueDatePicker>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Schedule</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-header row flex-wrap align-items-center justify-content-between gap-2">
            <h2 class="col-12 col-lg-3 col-xxl-6 mb-0">Services</h2>
            <div class="d-flex col-12 col-lg-8 col-xxl-5 filters flex-wrap justify-content-end gap-3">
                <div class="col-12 col-lg-4">
                    <input class="form-control me-2 h-100 p-2" type="search" placeholder="Search by services" aria-label="Search" />
                </div>
                <div class="col-12 col-lg-4">
                    <select class="form-select h-100 p-2" aria-label="Default select example">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <button type="button" class="btn btn-success col-12 col-lg-3" data-bs-toggle="modal" data-bs-target="#service-modal">
                    + Add service
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="mt-5 table table-secondary table-striped table-hover rounded">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Service Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>
                            <span class="badge text-bg-success">Success</span>
                        </td>
                        <td class="d-flex flex-wrap gap-3">
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-delete">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>
                            <span class="badge text-bg-success">Success</span>
                        </td>
                        <td class="d-flex flex-wrap gap-3">
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                        <td>
                            <span class="badge text-bg-success">Success</span>
                        </td>
                        <td class="d-flex flex-wrap gap-3">
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                        <td>
                            <span class="badge text-bg-success">Success</span>
                        </td>
                        <td class="d-flex flex-wrap gap-3">
                            <button class="btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted, useTemplateRef } from 'vue';

import TheHeader from '@/components/TheHeader.vue';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const serviceModal = useTemplateRef<HTMLDivElement | null>('service-modal');

onMounted(() => {
    serviceModal.value?.addEventListener(
        'show.bs.modal',
        () =>
            (durationTime.value = {
                hours: 0,
                minutes: 0
            })
    );
});

interface Duration {
    hours: number;
    minutes: number;
}

const durationTime = ref<Duration>({
    hours: 0,
    minutes: 0
});

</script>

<style>
.input-slot-image {
    height: 1.25rem;
    width: auto;
    margin: 0 0 0.17rem 0.5rem;
}
</style>