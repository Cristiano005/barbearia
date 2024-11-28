<template>
    <div class="d-flex p-0 m-0 min-vh-100">
        <div class="col-xl-6 col-sm-12 d-flex justify-content-center align-items-center">
            <div class="container custom-width p-4">
                <div class="mt-4">
                    <h2 class="fs-2 mb-5">
                        <RouterLink class="text-dark text-decoration-none" to="/">
                            Barber Shop
                        </RouterLink>
                    </h2>
                    <h3>Access our platform.</h3>
                    <p class="mt-3">
                        Welcome back! Sign in to manage your appointments or book a new haircut.
                    </p>
                </div>
                <form class="row mt-5 gap-4">
                    <div class="col-12 has-validation">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control p-3" id="email" aria-describedby="emailHelp"
                            placeholder="Enter your e-mail" ref="emailInput" v-model="email"/>
                        <div ref="emailMessageContainer"></div>
                    </div>
                    <div class="col-12 has-validation">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" class="form-control p-3" id="password"
                            placeholder="Enter your password" ref="passwordInput" v-model="password"/>
                        <div ref="passwordMessageContainer"></div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-dark p-3 w-100" @click="authenticate">Sign In</button>
                    </div>
                </form>
                <p class="mt-4">
                    Don't have an account?
                    <RouterLink class="text-dark fw-bold" to="/signup"> Create one right now. </RouterLink>
                </p>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Barber Shop" class="d-none d-xl-block vh-100 object-fit-cover col-xl-6" />
    </div>
</template>

<script setup lang="ts">

import { ref } from 'vue';
import router from '@/router';

import { axiosInstance, validate } from '@/helpers/helper';

import Swal from 'sweetalert2';

const email = ref<string>('');
const password = ref<string>('');

const emailInput = ref<HTMLInputElement | null>(null);
const passwordInput = ref<HTMLInputElement | null>(null);

const emailMessageContainer = ref<HTMLDivElement | null>(null);
const passwordMessageContainer = ref<HTMLDivElement | null>(null);

async function authenticate() {

    try {
        const validatedEmail: boolean = validate(emailInput.value, emailMessageContainer.value, {
            name: 'email',
            rules: ['empty', 'email'],
            value: email.value
        });

        const validatedPassword: boolean = validate(passwordInput.value, passwordMessageContainer.value, {
            name: 'password',
            rules: ['empty', 'password'],
            value: password.value
        });

        if (!validatedEmail || !validatedPassword) {
            return;
        }

        await axiosInstance.get('/sanctum/csrf-cookie');

        const { data } = await axiosInstance.post('/api/v1/auth/authenticate', {
            email: email.value,
            password: password.value
        });

        if (data.success === true) {
            router.push({ path: '/' });
        }

    } catch (error) {
        Swal.fire({
            title: 'Error!',
            text: error.response.data.message,
            icon: 'error',
            confirmButtonText: 'I got it',
            customClass: {
                confirmButton: "btn btn-dark"
            }
        });
    }
}

</script>

<style scoped lang="scss">
@media (min-width: 768px) {
    .custom-width {
        width: 75%;
    }
}

@media (max-width: 768px) {
    .custom-width {
        width: 100%;
    }
}
</style>