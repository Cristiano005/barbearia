<script setup lang="ts"></script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark h-100">
        <div class="container-fluid">
            <button
                class="navbar-toggler bg-light"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand text-light mx-auto link-warning" href="/">Barber Shop</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a
                            class="nav-link text-light link-warning"
                            aria-current="page"
                            href="/services"
                        >
                            Services -
                            <i class="fa-regular fa-hand-scissors"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light link-warning" href="/contact">
                            Contact -
                            <i class="fa-regular fa-envelope"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/about" class="nav-link text-light link-warning">
                            About -
                            <i class="fa-regular fa-building"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>