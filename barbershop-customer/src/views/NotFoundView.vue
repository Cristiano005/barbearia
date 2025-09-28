<template>
    <main class="d-flex flex-column align-items-center justify-content-center gap-5">
        <div id="notFoundRouteTitle">
            <h1> 404! </h1>
            <h6 class="text-center"> You are lost </h6>
        </div>
        <div id="main-content">
            <img src="../assets/404_image.svg" alt="">
        </div>
        <a href="/" class="nav-link text-dark d-flex align-items-center gap-1">
            <i class="bi bi-arrow-bar-left fs-2"></i>
            Go home
        </a>
    </main>
</template>

<style scoped lang="scss">
main {

    height: 100dvh;

    #notFoundRouteTitle h1 {
        font-size: 4rem;
    }

    #main-content img {
        width: 720px;
        max-width: 100%;
        height: 320px;
    }

    a {

        position: relative;
        top: 0;
        transition: color 0.25s !important;

        &:hover {
            color: rgb(0, 0, 0) !important;
        }

        &::after {
            content: '';
            width: 0%;
            height: 0.1rem;
            position: absolute;
            left: 0;
            bottom: -0.8rem;
            transition: width 0.25s !important;
            background-color: rgb(0, 0, 0) !important; // Ensure visibility
        }

        &:hover::after {
            width: 100% !important;
        }

    }

}
</style>