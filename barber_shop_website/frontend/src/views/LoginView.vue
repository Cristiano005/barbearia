<template>
    <div class="d-flex p-0 m-0">
        <div class="col-lg-6 col-md-12 vh-100" id="container-wrapper">
            <div id="header" class="w-75">
                <h2 class="fs-2 mb-2">Barber Shop</h2>
                <h3>Acesse nossa plataforma</h3>
                <p class="mt-3">
                    Faço login ou registre-se para começar a construir seus projetos ainda hoje.
                </p>
            </div>
            <main class="row gap-5 w-75 mt-5">
                <form class="row gap-4">
                    <div class="col-lg-12">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control p-3"
                            id="exampleInputEmail1"
                            aria-describedby="emailHelp"
                            placeholder="Write your e-mail"
                        />
                    </div>
                    <div class="col-lg-12">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control p-3"
                            id="exampleInputPassword1"
                            placeholder="Write your password"
                        />
                    </div>
                    <div class="col-lg-12">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                        <label class="form-check-label ml-2" for="exampleCheck1"
                            >Check me out</label
                        >
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary p-3 w-100">Sign in</button>
                    </div>
                </form>
            </main>
            <p href="#" class="mt-4">
                Do you haven't account?
                <a href="#"> Create one right now. </a>
            </p>
        </div>
        <img
            src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt=""
            class="col-lg-6 col-12 d-none d-xl-block vh-100 object-fit-cover"
        />
    </div>
</template>

<script setup lang="ts"></script>

<style>
main {
    margin: 0;
}

main h3 {
    margin-top: 84px;
}

#container-wrapper {
    padding-left: 112px;
}

#header {
    padding-top: 60px;
}
</style>
