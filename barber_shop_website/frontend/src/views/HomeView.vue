<template>
    <section id="home">
        <div class="container">
            <div class="row justify-content-center">
                <div id="apresentation" class="col-12 col-md-6">
                    <h2 class="lh-base mb-4 fw-bold">Wecolme to Barber Shop in Nova Odessa.</h2>
                    <p class="lh-base mb-4">
                        Um salão exclusivo em São Paulo, especializado em tratamentos naturais.
                    </p>
                    <button
                        class="d-flex align-items-center justify-content-center btn btn-dark px-5"
                    >
                        Schedule an hour
                        <i class="bi bi-alarm-fill p-2"></i>
                    </button>
                </div>
                <div class="position-relative col-12 col-md-6">
                    <div
                        id="background-effect"
                        class="position-absolute bg-dark h-100 z-n1 rounded-1"
                    ></div>
                    <img
                        class="rounded-1"
                        src="https://matheuscostadesign.github.io/nlw6-beauty-salon/assets/images/main.jpg"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </section>
    <div class="divider"></div>
    <section id="services">
        <div class="container mx-auto">
            <div class="row">
                <header class="text-center mx-auto col-12 mb-5" id="services-header">
                    <h3>Why choose us?</h3>
                    <p class="mt-4">
                        Com mais de 10 anos no mercado, o Beautysalon já conquistou clientes de
                        inúmeros países com seus tratamentos exclusivos e totalmente naturais
                    </p>
                </header>
            </div>
            <div class="row gap-4 justify-content-center mt-4">
                <!-- First card -->
                <div class="card col-12 col-md-3 py-5 px-4">
                    <div class="icon d-flex justify-content-center">
                        <i
                            class="bi bi-piggy-bank-fill fs-1 bg-dark rounded text-white px-4 py-2"
                        ></i>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-dark my-3">Low price</h3>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk
                            of the card's content.
                        </p>
                    </div>
                </div>

                <!-- Second card -->
                <div class="card col-12 col-md-3 py-5 px-4">
                    <div class="icon d-flex justify-content-center">
                        <i class="bi bi-scissors fs-1 bg-dark rounded text-white px-4 py-2"></i>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-dark my-3">Quality</h3>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk
                            of the card's content.
                        </p>
                    </div>
                </div>

                <!-- Third card -->
                <div class="card col-12 col-md-3 py-5 px-4">
                    <div class="icon d-flex justify-content-center">
                        <i class="bi bi-shop-window fs-1 bg-dark rounded text-white px-4 py-2"></i>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center text-dark my-3">Healthy ambient</h3>
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk
                            of the card's content.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="divider"></div>
    <section class="testimonials">
        <div class="container">
            <header class="text-center mx-auto col-12" id="services-header">
                <h3>Why choose us?</h3>
                <p class="mt-4">
                    Com mais de 10 anos no mercado, o Beautysalon já conquistou clientes de inúmeros
                    países com seus tratamentos exclusivos e totalmente naturais
                </p>
            </header>
            <div class="row justify-content-center mt-6">
                <swiper-container pagination="true" slides-per-view="2" space-between="30">
                    <swiper-slide>
                        <div class="card p-4">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">
                                    With supporting text below as a natural lead-in to additional
                                    content.
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="card p-4">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">
                                    With supporting text below as a natural lead-in to additional
                                    content.
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="card p-4">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">
                                    With supporting text below as a natural lead-in to additional
                                    content.
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </swiper-slide>
                    <swiper-slide>
                        <div class="card p-4">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">
                                    With supporting text below as a natural lead-in to additional
                                    content.
                                </p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </swiper-slide>
                </swiper-container>
            </div>
        </div>
    </section>
    <div class="divider"></div>
    <section id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div id="test" class="mt-3 col-lg-5 col-sm-12">
                    <h4>Contact us on WhatsApp.</h4>
                    <p class="mt-4 w-75">
                        Contact us for any questions. We are available today via WhatsApp and email.
                    </p>
                    <button class="btn btn-dark px-5">
                        <i class="bi bi-whatsapp"></i>
                        WhatsApp
                    </button>
                </div>
                <div id="contact" class="col-lg-5 col-sm-12">
                    <form method="post" id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label" id="label-name">Name</label>
                            <input
                                type="text"
                                class="form-control border-dark name"
                                id="name"
                                placeholder="Erisvaldo"
                                name="name"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label" id="label-email">Email</label>
                            <input
                                type="email"
                                class="form-control border-dark email"
                                id="email"
                                placeholder="name@example.com"
                                name="email"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label" id="label-subject"
                                >Subject</label
                            >
                            <input
                                type="text"
                                class="form-control border-dark subject"
                                id="subject"
                                placeholder="Travel"
                                name="subject"
                            />
                        </div>
                        <div class="form-floating">
                            <textarea
                                class="form-control border-dark resize-none message"
                                placeholder="Leave a message here"
                                id="message"
                                name="message"
                            ></textarea>
                            <label for="message" id="label-message">Message</label>
                        </div>
                        <button
                            class="w-100 mt-4 btn btn-dark btn-outline-secondary text-light"
                            id="send-email"
                        >
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup lang="ts">
import { register } from 'swiper/element/bundle'

register()
</script>

<style scoped>
#apresentation {
    max-width: 24rem;
    margin-right: 4rem;
}

button {
    height: 3.125rem;
}

#background-effect {
    width: 40rem;
    top: -16.8%;
    left: 16.8%;
}

img {
    width: 40rem;
    height: auto;
}

#services-header {
    max-width: 30rem;
}

.mt-6 {
    margin-top: 5rem;
}

#map {
    height: 20rem;
}
</style>
