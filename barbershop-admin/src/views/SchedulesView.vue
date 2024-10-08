<template>
    <TheHeader />
    <main class="p-5">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">New schedule</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="customer" class="col-form-label">Customer:</label>
                                <input type="text" class="form-control" placeholder="Enter with the name" id="customer" />
                            </div>
                            <div class="mb-3">
                                <label for="service-to-schedule" class="col-form-label">Service:</label>
                                <select class="form-select h-100 p-2" aria-label="Default select example" id="service-to-schedule">
                                    <option selected>All</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customer" class="col-form-label">Date and Hour:</label>
                                <input type="text" class="form-control" id="customer" />
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Note:</label>
                                <textarea class="form-control" placeholder="Any notes..." id="message-text"></textarea>
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
            <h2 class="col-12 col-lg-3 col-xxl-6 mb-0">Schedules</h2>
            <div class="d-flex col-12 col-lg-8 col-xxl-5 filters flex-wrap justify-content-end gap-3">
                <div class="col-12 col-lg-4">
                    <input class="form-control me-2 h-100 p-2" type="search" placeholder="Search by schedules" aria-label="Search" />
                </div>
                <div class="col-12 col-lg-4">
                    <select class="form-select h-100 p-2" aria-label="Default select example">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <button type="button" class="btn btn-success col-12 col-lg-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    + Add schedule
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

<script setup>
import TheHeader from '@/components/TheHeader.vue';
</script>
