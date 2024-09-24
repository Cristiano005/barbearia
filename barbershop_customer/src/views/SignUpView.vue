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
                    <div class="col-12">
                        <label for="name" class="form-label">Name*</label>
                        <input
                            type="text"
                            class="form-control p-3"
                            id="name"
                            placeholder="Enter your name"
                        />
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email*</label>
                        <input
                            type="email"
                            class="form-control p-3"
                            id="email"
                            placeholder="Enter your e-mail"
                        />
                    </div>
                    <div class="col-12">
                        <label for="password" class="form-label">Password*</label>
                        <input
                            type="password"
                            class="form-control p-3"
                            id="password"
                            placeholder="Enter your password"
                        />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark p-3 w-100">Sign Up</button>
                    </div>
                </form>
                <p class="mt-4">
                    Already have an account?
                    <RouterLink class="text-dark fw-bold" to="/signin"> Sign In </RouterLink>
                </p>
            </div>
        </div>
        <img
            src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Barber Shop"
            class="d-none d-xl-block vh-100 object-fit-cover col-xl-6"
        />
    </div>
</template>

<script setup lang="ts">
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