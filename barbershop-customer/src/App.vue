<template>
    <RouterView />
</template>

<style lang="scss">
* {
    font-family: 'Poppins', sans-serif;
    scroll-behavior: smooth;
}

body {
    &::-webkit-scrollbar-thumb {
        background-color: #212529;
        border-radius: 999rem;
    }

    &::-webkit-scrollbar {
        width: 0.4rem;
        height: 0.4rem;
    }

    section {
        padding: 10rem 0;
    }

    footer {
        padding: 3.75rem 0;
    }

    button {
        height: 3.5rem;
    }

    .left-to-right-divider {
        height: 1px;
        background: linear-gradient(270deg, rgb(0, 0, 0), rgb(219, 219, 219));
    }

    .right-to-left-divider {
        height: 1px;
        background: linear-gradient(270deg, rgb(219, 219, 219), rgb(0, 0, 0));
    }
}

@media (min-width: 765px) and (max-width: 1000px) {
    #social-medias {
        justify-content: end;
    }
}
</style>
