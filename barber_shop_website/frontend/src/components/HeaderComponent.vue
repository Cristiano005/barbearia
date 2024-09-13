<script setup lang="ts"></script>

<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand fw-medium" href="#">Barber Shop</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent"
                aria-controls="navbarContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <RouterLink class="nav-link text-white" to="/#home">Home</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link text-white" to="/#about">About</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link text-white" to="/#services">Services</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link text-white" to="/#testimonials">Testimonials</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link text-white" to="/#contact">Contact</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="btn btn-outline-light" to="/signin">Sign In</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="btn btn-outline-light" to="/signin">Sign Up</RouterLink>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<style scoped></style>
