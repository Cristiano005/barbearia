<template>
    <TheHeader/>
    <main class="p-5">
        <div class="table-header row flex-wrap justify-content-between gap-2">
            <h2 class="col-12 col-lg-6">Schedules</h2>
            <div class="d-flex col-12 col-lg-5 filters flex-wrap gap-3">
                <div class="col-12 col-lg-5">
                    <input
                        class="form-control me-2 h-100 p-2"
                        type="search"
                        placeholder="Search by services"
                        aria-label="Search" />
                </div>
                <div class="col-12 col-lg-4">
                    <select class="form-select h-100 p-2" aria-label="Default select example">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <button type="button" class="btn btn-success col-12 col-lg-2 p-2">
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
                            <button
                                class="btn btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-delete">
                                Edit
                            </button>
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

<script setup>

import TheHeader from '@/components/TheHeader.vue';

</script>