<script setup lang="ts">
import HeaderComponent from '@/components/HeaderComponent.vue'
</script>

<template>
    <header class="fixed-top p-2 bg-dark">
        <HeaderComponent />
    </header>
    <main>
        <RouterView />
    </main>
    <footer class="bg-dark">
        <div class="container mx-auto">
            <div class="row justify-content-around">
                <div class="col-lg-6">
                    <h4 class="text-white">Barber shop</h4>
                    <p class="text-white mt-4"> 2024 Barber shop</p>
                    <p class="text-white"> Diretos reservados</p>
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

main {
    margin: 4.5rem 0;
}

section {
    padding: 10rem 0;
}

div.divider {
    height: 1px;
    background: linear-gradient(
        270deg,
        hsla(140, 50%, 40%, 1),
        /* Cor verde mais escura */ hsla(140, 50%, 70%, 0.34)
            /* Cor verde mais clara com opacidade */
    );
}

footer {
    padding: 3.75rem 0;
}
</style>
