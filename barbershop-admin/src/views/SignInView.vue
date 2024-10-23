<template>
    <div class="d-flex p-0 m-0 min-vh-100">
        <div class="col-xl-6 col-sm-12 d-flex justify-content-center align-items-center">
            <div class="container custom-width p-4">
                <div class="mt-4">
                    <h2 class="fs-2 mb-5">
                        <RouterLink class="text-dark text-decoration-none" to="/"> Barber Shop </RouterLink>
                    </h2>
                    <h3>Access our platform.</h3>
                    <p class="mt-3">Welcome back! Sign in to manage your appointments or book a new haircut.</p>
                </div>
                <form class="row mt-5 gap-4" @submit.prevent="authenticate">
                    <div class="col-12">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control p-3" id="email" placeholder="Enter your e-mail" v-model="email" />
                    </div>
                    <div class="col-12">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" class="form-control p-3" id="password" placeholder="Enter your password" v-model="password" />
                    </div>
                    <div class="col-12">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                        <label class="form-check-label ms-2" for="exampleCheck1">Check me out</label>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark p-3 w-100">Sign In</button>
                    </div>
                </form>
                <p class="mt-4">
                    Don't have an account?
                    <RouterLink class="text-dark fw-bold" to="/signup"> Create one right now. </RouterLink>
                </p>
            </div>
        </div>
        <img
            src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Barber Shop"
            class="d-none d-xl-block vh-100 object-fit-cover col-xl-6" />
    </div>
</template>

<script setup lang="ts">

import { ref } from 'vue';
import router from '@/router';

import { axiosInstance } from '@/helpers/helper';

const email = ref<string>('');
const password = ref<string>('');

function validate(): boolean {
    if (email.value.trim().length === 0) {
        return false;
    }

    if (password.value.trim().length === 0) {
        return false;
    }

    return true;
}

async function authenticate() {

    try {

        if (validate() === false) {
            console.log('There is a issue here');
            return;
        }

        await axiosInstance.get('/sanctum/csrf-cookie');

        const { data } = await axiosInstance.post('/api/v1/auth/login', {
            email: email.value,
            password: password.value
        });

        if(data.success === true) {
            router.push({ path: '/' }); 
        }

    } catch (error) {
        console.log(error)
    }
}
</script>

<style scoped>
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