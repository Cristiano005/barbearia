<script setup lang="ts">
import { computed, type StyleValue } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const shouldShowAuthPage = computed<boolean>(() =>
    ['signin', 'signup'].includes(router.currentRoute.value.name as string)
)

const shouldApplyMainMargin = computed<StyleValue>(() =>
    !shouldShowAuthPage.value ? { marginTop: '4.5rem' } : { marginTop: '0' }
)
</script>

<template>
    <header class="fixed-top p-2 bg-dark" v-show="!shouldShowAuthPage">
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
                        <li class="nav-item">
                            <RouterLink class="btn btn-outline-light" to="/signin"
                                >Sign In</RouterLink
                            >
                        </li>
                        <li class="nav-item">
                            <RouterLink class="btn btn-outline-light" to="/signup"
                                >Sign Up</RouterLink
                            >
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main :style="shouldApplyMainMargin">
        <RouterView />
    </main>
    <footer class="bg-dark" v-show="!shouldShowAuthPage">
        <div class="container mx-auto">
            <div class="row justify-content-around">
                <div class="col-lg-6">
                    <h4 class="text-white">Barber shop</h4>
                    <p class="text-white mt-4">2024 Barber shop</p>
                    <p class="text-white">Diretos reservados</p>
                </div>
                <div id="social-medias" class="row col-lg-2 gap-5">
                    <a href="#" class="social-media col-md-1">
                        <i class="bi bi-facebook text-white fs-4 cursor-pointer"></i>
                    </a>
                    <a href="#" class="social-media col-md-1">
                        <i class="bi bi-instagram text-white fs-4 cursor-pointer"></i>
                    </a>
                    <a href="#" class="social-media col-md-1">
                        <i class="bi bi-youtube text-white fs-4 cursor-pointer"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<style>
* {
    font-family: 'Poppins', sans-serif;
}

section {
    padding: 10rem 0;
}

footer {
    padding: 3.75rem 0;
}

.left-to-right-divider {
    height: 1px;
    background: linear-gradient(270deg, rgb(0, 0, 0), rgb(219, 219, 219));
}

.right-to-left-divider {
    height: 1px;
    background: linear-gradient(270deg, rgb(219, 219, 219), rgb(0, 0, 0));
}
</style>