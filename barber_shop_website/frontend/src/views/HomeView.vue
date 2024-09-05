<template>
    <section id="home">
        <div class="d-flex gap-4 mx-auto" id="container-home">
            <div id="apresentation">
                <h2 class="lh-base mb-4">Wecolme to Barber Shop in Nova Odessa.</h2>
                <p class="lh-base mb-4">
                    Um salão exclusivo em São Paulo, especializado em tratamentos naturais.
                </p>
                <button class="d-flex align-items-center justify-content-center btn btn-dark px-5">
                    Schedule an hour
                </button>
            </div>
            <div>
                <img
                    class="rounded-1"
                    src="https://matheuscostadesign.github.io/nlw6-beauty-salon/assets/images/main.jpg"
                    alt=""
                />
            </div>
        </div>
    </section>
</template>

<style scoped>

#container-home {
    max-width: 70rem;
}

#apresentation {
    max-width: 24rem;
    margin-right: 4rem;
}

button {
    height: 3.125rem;
}

img {
    max-width: 40rem;
    height: auto;
}
</style>
