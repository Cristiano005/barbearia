<template>
    <header class="p-2 bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand fw-medium" href="#">Barber Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                    <ul class="navbar-nav gap-2">
                        <li class="nav-item">
                            <RouterLink class="nav-link text-white" to="/">
                                Home
                            </RouterLink>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="btn btn-outline-light dropdown-toggle border-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <RouterLink class="dropdown-item" to="/my-schedules">
                                        My Schedules
                                    </RouterLink>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main class="p-5">
        <div class="container mx-auto">
            <div class="row">
                <header class="col-12 mw-30">
                    <h3>My Schedules</h3>
                </header>
            </div>
            <div class="gap-3 mt-4 mx-auto">
                <div class="row align-items-center text-bg-dark p-3 rounded">
                    <div class="col-auto">
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                    <div class="col-10 border-end">
                        <h6>
                            31/10/2024 - 09:30h
                            <span class="badge text-bg-success">Success</span>
                        </h6>
                        <small>
                            NO FAID - R$ 15,00
                        </small>
                    </div>
                    <div class="d-flex col-auto gap-4 ps-5">
                        <i class="fs-4 bi bi-pencil text-warning cursor-pointer" title="Edit"></i>
                        <i class="fs-4 bi bi-calendar-x text-danger cursor-pointer" title="Cancel"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">


</script>

<style scoped lang="scss">
.cursor-pointer {
    cursor: pointer;
}
</style>