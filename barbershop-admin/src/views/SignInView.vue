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
                <form class="row mt-5 gap-4">
                    <div class="col-12 has-validation">
                        <label for="email" class="form-label">Email*</label>
                        <input type="text" :class="['form-control', 'p-3', errors.email ? 'is-invalid' : '']" id="email"
                            placeholder="Enter your e-mail" ref="emailInput" v-bind="emailAttrs" v-model="email" />
                        <div :class="errors.email ? 'invalid-feedback' : ''">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="col-12 has-validation">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" :class="['form-control', 'p-3', errors.password ? 'is-invalid' : '']"
                            id="password" placeholder="Enter your password" v-bind="passwordAttrs" v-model="password" />
                        <div :class="errors.password ? 'invalid-feedback' : ''">
                            {{ errors.password }}
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-dark p-3 w-100" @click="authenticate">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Barber Shop" class="d-none d-xl-block vh-100 object-fit-cover col-xl-6" />
    </div>
</template>

<script setup lang="ts">

import { useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/yup';
import * as yup from 'yup';
import Swal from 'sweetalert2';

import router from '@/router';

import { axiosInstance } from '@/helpers/helper';

const schema = toTypedSchema(
    yup.object({
        email: yup.string().required().email(),
        password: yup.string().required().min(8)
    }),
);

const { defineField, validate, values, errors } = useForm({
    validationSchema: schema
});

const [email, emailAttrs] = defineField("email");
const [password, passwordAttrs] = defineField("password");

async function authenticate() {

    const result = await validate();

    if (!result.valid) {

        Swal.fire({
            icon: "error",
            title: "Check your information!",
            text: "Please fill in all required fields correctly.",
        });

        return;
    }

    try {

        Swal.fire({
            title: "Logging in...",
            text: "Please wait",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        await axiosInstance.get('/sanctum/csrf-cookie');

        const { data } = await axiosInstance.post('/api/v1/auth/admin/authenticate', {
            email: email.value,
            password: password.value
        });

        Swal.close();

        if (data.success === true) {
            router.push({ path: '/' });
        }

    } catch (error: any) {

        Swal.close();

        Swal.fire({
            title: 'Error!',
            text: error?.response?.data?.message || "Unexpected error",
            icon: 'error',
            confirmButtonText: 'I got it',
            customClass: {
                confirmButton: "btn btn-dark"
            }
        });

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
