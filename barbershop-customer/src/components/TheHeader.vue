<template>
    <header class="fixed-top p-2 bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <RouterLink class="navbar-brand fw-medium" to="/">Barber Shop</RouterLink>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                    <ul class="navbar-nav gap-2">

                        <template v-if="route.name === 'home'">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/#about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/#services">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/#testimonials">Testimonials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="/#contact">Contact</a>
                            </li>
                        </template>

                        <template v-else>
                            <li class="nav-item">
                                <RouterLink class="nav-link text-white" to="/">Home</RouterLink>
                            </li>
                        </template>

                        <template v-if="!isChecking">
                            <template v-if="!userStore.getAuthenticatedStatus">
                                <li class="nav-item">
                                    <RouterLink class="btn btn-outline-light" to="/signin">Sign In</RouterLink>
                                </li>
                                <li class="nav-item">
                                    <RouterLink class="btn btn-outline-light" to="/signup">Sign Up</RouterLink>
                                </li>
                            </template>
                            <template v-else>
                                <li class="nav-item dropdown">
                                    <button class="btn btn-outline-light dropdown-toggle border-0"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li>
                                            <RouterLink class="dropdown-item" to="/profile">
                                                Profile
                                            </RouterLink>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" @click="userStore.logout">Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </template>
                        </template>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</template>

<script setup lang="ts">

import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

import { useUserStore } from "@/stores/user";

const route = useRoute();

const userStore = useUserStore();
const isChecking = ref<boolean>(true);

onMounted(async () => {
    await userStore.check();
    isChecking.value = false;
});

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