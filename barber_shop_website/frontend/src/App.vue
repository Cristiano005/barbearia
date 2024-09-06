<script setup lang="ts">
import HeaderComponent from '@/components/HeaderComponent.vue'
</script>

<template>
    <header class="fixed-top" id="header">
        <HeaderComponent />
    </header>
    <main>
        <RouterView />
    </main>
    <footer></footer>
</template>

<style>
* {
    font-family: 'Poppins', sans-serif;
}

header#header {
    height: 4.5rem;
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
  hsla(140, 50%, 40%, 1),    /* Cor verde mais escura */
  hsla(140, 50%, 70%, 0.34)   /* Cor verde mais clara com opacidade */
);


}
</style>
