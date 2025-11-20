<template>
    <header class="p-2 bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand fw-medium" href="/">Barber Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                    <ul class="navbar-nav gap-2">
                        <li class="nav-item">
                            <router-link class="nav-link text-white" to="/">Dashboard</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-white" to="/schedules">Schedules</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-white" to="/services">Services</router-link>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="btn btn-outline-light dropdown-toggle border-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    <button class="dropdown-item" @click="logout">Logout</button>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</template>

<script setup lang="ts">

import router from '@/router';

import { axiosInstance } from '@/helpers/helper';

async function logout() {

    try {
        const { data } = await axiosInstance.post("api/v1/auth/admin/logout", { withCredentials: true });
        if (data.success) router.push({ path: "/signin" });
    }

    catch (error) {
        console.log(error);
    }

}

</script>

<style lang="scss">
header #navbarContent ul li:nth-last-child(n+1) a {
    position: relative;
    top: 0;
    transition: color 0.25s !important;

    &:hover {
        color: white !important;
    }

    &::after {
        content: '';
        width: 0%;
        height: 0.1rem;
        position: absolute;
        left: 0;
        bottom: -0.8rem;
        transition: width 0.5s !important;
        background-color: rgb(255, 255, 255) !important; // Ensure visibility
    }

    &:hover::after {
        width: 100% !important;
    }
}
</style>