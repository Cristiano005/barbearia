<script setup lang="ts">

import HeaderComponent from '@/components/HeaderComponent.vue'

</script>

<template>
    <header class="fixed-top">
        <HeaderComponent />
    </header>
    <main>
        <RouterView />
    </main>
    <footer></footer>
</template>

<style scoped>

header {
  height: 4.5rem;
}

main {
  margin: 4.5rem 0;
}

section {
  padding: 10rem 0;
}

</style>