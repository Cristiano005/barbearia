<template>
    <div class="d-flex p-0 m-0 min-vh-100">
        <div class="col-xl-6 col-sm-12 d-flex justify-content-center align-items-center">
            <div class="container custom-width p-4">
                <div id="header">
                    <h2 class="fs-2 mb-5">
                        <RouterLink class="text-dark text-decoration-none" to="/"> Barber Shop </RouterLink>
                    </h2>
                    <h3>Access our platform.</h3>
                    <p class="mt-3">Sign up and schedule your haircut with us right now.</p>
                </div>
                <form class="row mt-5 gap-4">
                    <div class="col-12 has-validation">
                        <label for="name" class="form-label">Name*</label>
                        <input type="text" :class="['form-control', 'p-3', errors.name ? 'is-invalid' : '']" id="name"
                            placeholder="Enter your name" ref="nameInput" v-bind="nameAttrs" v-model="name" />
                        <div :class="errors.name ? 'invalid-feedback' : ''">
                            {{ errors.name }}
                        </div>
                    </div>
                    <div class="col-12 has-validation">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" :class="['form-control', 'p-3', errors.email ? 'is-invalid' : '']"
                            id="email" placeholder="Enter your e-mail" ref="emailInput" v-bind="emailAttrs"
                            v-model="email" />
                        <div :class="errors.email ? 'invalid-feedback' : ''">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="col-12 has-validation">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" :class="['form-control', 'p-3', errors.password ? 'is-invalid' : '']"
                            id="password" placeholder="Enter your password" ref="passwordInput" v-bind="passwordAttrs"
                            v-model="password" />
                        <div :class="errors.password ? 'invalid-feedback' : ''">
                            {{ errors.password }}
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-dark p-3 w-100" @click="register">Sign Up</button>
                    </div>
                </form>
                <p class="mt-4">
                    Already have an account?
                    <RouterLink class="text-dark fw-bold" to="/signin"> Sign In </RouterLink>
                </p>
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

import { useUserStore } from '@/stores/user';

const userStore = useUserStore();

const schema = toTypedSchema(
    yup.object({
        name: yup.string().required().min(2),
        email: yup.string().required().email(),
        password: yup.string().required().min(8)
    }),
);

const { defineField, validate, errors } = useForm({
    validationSchema: schema,
});

const [name, nameAttrs] = defineField("name");
const [email, emailAttrs] = defineField("email");
const [password, passwordAttrs] = defineField("password");

async function register() {

    try {

        const result = await validate();

        if (!result.valid) {

            Swal.fire({
                icon: "error",
                title: "Check your information!",
                text: "Please fill in all required fields correctly.",
            });

            return;
        }

        await userStore.register(name.value as string, email.value as string, password.value as string);

    } catch (error: any) {
        Swal.fire({
            title: "Error!",
            text: error.response.data.message,
            icon: "error",
            confirmButtonText: "I got it",
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