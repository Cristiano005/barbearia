<template>
    <div class="d-flex p-0 m-0 min-vh-100">
        <div class="col-xl-6 col-sm-12 d-flex" id="form-container">
            <div class="container custom-width">
                <div id="header">
                    <h2 class="fs-2 mb-5">
                        <RouterLink class="text-dark text-decoration-none" to="/"> Barber Shop </RouterLink>
                    </h2>
                    <h3>Access our platform.</h3>
                    <p class="mt-3">Sign up and schedule your haircut with us right now.</p>
                </div>
                <form class="row mt-5 gap-4">
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control p-3"
                            id="name"
                            aria-describedby="emailHelp"
                            placeholder="Write your name"
                        />
                    </div>
                    <div class="col-12">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control p-3"
                            id="exampleInputEmail1"
                            aria-describedby="emailHelp"
                            placeholder="Write your e-mail"
                        />
                    </div>
                    <div class="col-12">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control p-3"
                            id="exampleInputPassword1"
                            placeholder="Write your password"
                        />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark p-3 w-100">Sign in</button>
                    </div>
                </form>
                <p class="mt-4">
                    Already have an account?
                    <RouterLink to="/signin"> Sign In </RouterLink>
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
main {
    margin: 0;
}

#header {
    padding-top: 2rem;
}

@media (min-width: 1400px) {
    /* Bootstrap's xxl breakpoint */
    .custom-width {
        width: 60%;
    }
}

@media (min-width: 768px) {
    /* Bootstrap's lg breakpoint */
    .custom-width {
        width: 75%;
        padding: 2rem;
    }
}

@media (max-width: 768px) {
    /* Bootstrap's lg breakpoint */
    .custom-width {
        width: 100%;
        padding: 2rem;
    }
}

#form-container {
    justify-content: center;
    align-items: center;
}
</style>
