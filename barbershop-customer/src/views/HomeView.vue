<template>
    <header class="fixed-top p-2 bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand fw-medium" href="#">Barber Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                    <ul class="navbar-nav gap-2">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/#testimonials">Testimonials</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/#contact">Contact</a>
                        </li>
                        <template v-if="!user.isAuthenticated">
                            <li class="nav-item">
                                <RouterLink class="btn btn-outline-light" to="/signin">Sign In</RouterLink>
                            </li>
                            <li class="nav-item">
                                <RouterLink class="btn btn-outline-light" to="/signup">Sign Up</RouterLink>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item dropdown">
                                <button class="btn btn-outline-light dropdown-toggle border-0" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-person fs-5"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li>
                                        <RouterLink class="dropdown-item" to="/my-schedules">
                                            My Schedules
                                        </RouterLink>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </template>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <section class="overflow-hidden headline" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <div id="apresentation" class="col-12 col-lg-6">
                        <h2 class="lh-base mb-4 fw-bold">
                            Wecolme to Barber Shop in Fiction City.
                        </h2>
                        <p class="lh-base mb-4">
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                            accusantium.
                        </p>
                        <RouterLink class="d-flex align-items-center justify-content-center btn btn-dark px-5" to="/schedule">
                            Schedule an hour
                            <i class="bi bi-alarm-fill p-2"></i>
                        </RouterLink>
                    </div>
                    <div class="position-relative col-12 col-lg-6" id="container-image">
                        <img class="position-relative rounded-1 w-100 h-auto"
                            src="https://matheuscostadesign.github.io/nlw6-beauty-salon/assets/images/main.jpg"
                            alt="" />
                    </div>
                </div>
            </div>
        </section>
        <div class="left-to-right-divider"></div>
        <section class="headline" id="about">
            <div class="container mx-auto">
                <div class="row">
                    <header class="text-center mx-auto col-12 mb-5 mw-30">
                        <h3>Why choose us?</h3>
                        <p class="mt-4">
                            At vero eos et accusamus et iusto odio dignissimos ducimus qui
                            blanditiis praesentium voluptatum deleniti atque corrupti quos dolores
                            et quas molestias excepturi sint.
                        </p>
                    </header>
                </div>
                <div class="row gap-4 justify-content-center mt-4 mx-auto">
                    <!-- First card -->
                    <div class="card col-12 col-md-5 col-xl-3 py-5 px-4">
                        <div class="icon d-flex justify-content-center">
                            <i class="bi bi-piggy-bank-fill fs-1 bg-dark rounded text-white px-4 py-2"></i>
                        </div>
                        <div class="card-body">
                            <h3 class="text-center text-dark my-3">Low price</h3>
                            <p class="card-text">
                                Some quick example text to build on the card title and make up the
                                bulk of the card's content.
                            </p>
                        </div>
                    </div>

                    <!-- Second card -->
                    <div class="card col-12 col-md-5 col-xl-3 py-5 px-4">
                        <div class="icon d-flex justify-content-center">
                            <i class="bi bi-scissors fs-1 bg-dark rounded text-white px-4 py-2"></i>
                        </div>
                        <div class="card-body">
                            <h3 class="text-center text-dark my-3">Quality</h3>
                            <p class="card-text">
                                Some quick example text to build on the card title and make up the
                                bulk of the card's content.
                            </p>
                        </div>
                    </div>

                    <!-- Third card -->
                    <div class="card col-12 col-md-5 col-xl-3 py-5 px-4">
                        <div class="icon d-flex justify-content-center">
                            <i class="bi bi-shop-window fs-1 bg-dark rounded text-white px-4 py-2"></i>
                        </div>
                        <div class="card-body">
                            <h3 class="text-center text-dark my-3">Healthy ambient</h3>
                            <p class="card-text">
                                Some quick example text to build on the card title and make up the
                                bulk of the card's content.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="right-to-left-divider"></div>
        <section class="headline" id="services">
            <div class="container">
                <div class="row">
                    <header class="text-center mx-auto col-12 mb-5 mw-30">
                        <h3>Our services</h3>
                    </header>
                </div>
                <div class="row gap-4 justify-content-center mt-4 mx-auto">
                    <div class="card p-0 col-lg-3 col-md-5 col-sm-12">
                        <img src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            style="height: 20rem" class="card-img-top object-fit-cover" alt="..." />
                        <div class="card-body text-center">
                            <h4 class="card-title">No Fade Haircut - $15</h4>
                            <h6 class="card-text mt-3 mb-3">
                                <i class="bi bi-clock"></i>
                                35 min
                            </h6>
                            <a href="#" class="btn btn-dark">Schedule</a>
                        </div>
                    </div>
                    <div class="card p-0 col-lg-3 col-md-5 col-sm-12">
                        <img src="https://images.unsplash.com/photo-1533245270348-821d4d5c7514?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            style="height: 20rem" class="card-img-top object-fit-cover" alt="..." />
                        <div class="card-body text-center">
                            <h4 class="card-title">Fade Haircut - $10</h4>
                            <h6 class="card-text mt-3 mb-3">
                                <i class="bi bi-clock"></i>
                                30 min
                            </h6>
                            <a href="#" class="btn btn-dark">Schedule</a>
                        </div>
                    </div>
                    <div class="card p-0 col-lg-3 col-md-5 col-sm-12">
                        <img src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?q=80&w=1888&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            style="height: 20rem" class="card-img-top object-fit-cover" alt="..." />
                        <div class="card-body text-center">
                            <h4 class="card-title">Beard Trim - $5</h4>
                            <h6 class="card-text mt-3 mb-3">
                                <i class="bi bi-clock"></i>
                                15 min
                            </h6>
                            <a href="#" class="btn btn-dark">Schedule</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="left-to-right-divider"></div>
        <section class="headline" id="testimonials">
            <div class="container">
                <header class="text-center mx-auto col-12 mw-30" id="services-header">
                    <h3>Testimonials</h3>
                    <p class="mt-4">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.
                    </p>
                </header>
                <div class="row justify-content-center" style="margin-top: 5rem">
                    <swiper-container class="h-18" pagination="true" space-between="30" :breakpoints="{
                        280: { slidesPerView: 1 },
                        720: { slidesPerView: 2 }
                    }">
                        <swiper-slide>
                            <div class="card p-2">
                                <div class="card-body">
                                    <p class="card-text">
                                        <i class="bi bi-quote fs-4"></i>
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </p>
                                    <div
                                        class="d-flex justify-content-start align-items-center gap-2 testimonial-author">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            class="img-fluid" alt="..." />
                                        <span> Test </span>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                        <swiper-slide>
                            <div class="card p-2">
                                <div class="card-body">
                                    <p class="card-text">
                                        <i class="bi bi-quote fs-4"></i>
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </p>
                                    <div
                                        class="d-flex justify-content-start align-items-center gap-2 testimonial-author">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            class="img-fluid" alt="..." />
                                        <span> Test </span>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                        <swiper-slide>
                            <div class="card p-2">
                                <div class="card-body">
                                    <p class="card-text">
                                        <i class="bi bi-quote fs-4"></i>
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </p>
                                    <div
                                        class="d-flex justify-content-start align-items-center gap-2 testimonial-author">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            class="img-fluid" alt="..." />
                                        <span> Test </span>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                        <swiper-slide>
                            <div class="card p-2">
                                <div class="card-body">
                                    <p class="card-text">
                                        <i class="bi bi-quote fs-4"></i>
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </p>
                                    <div
                                        class="d-flex justify-content-start align-items-center gap-2 testimonial-author">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            class="clip-path img-fluid" alt="..." />
                                        <span> Test </span>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper-container>
                </div>
            </div>
        </section>
        <div class="right-to-left-divider"></div>
        <section class="headline" id="contact">
            <div class="container">
                <div class="row justify-content-center gap-5">
                    <div id="test" class="mt-3 col-lg-5 col-sm-12">
                        <div>
                            <h4>Contact us on WhatsApp.</h4>
                            <p class="mt-4 w-75">
                                Contact us for any questions. We are available today via WhatsApp
                                and email.
                            </p>
                            <button class="btn btn-dark px-5">
                                <i class="bi bi-whatsapp"></i>
                                WhatsApp
                            </button>
                        </div>
                    </div>

                    <form method="post" class="d-flex flex-column gap-4 col-lg-5 col-sm-12" id="contactForm">
                        <div class="col-12">
                            <label for="name" class="form-label">Name*</label>
                            <input type="email" class="form-control p-3" id="name" placeholder="Enter your namer" />
                        </div>
                        <div class="col-12">
                            <label for="contact-email" class="form-label">Email*</label>
                            <input type="text" class="form-control p-3" id="contact-email"
                                placeholder="Enter your email" />
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject*</label>
                            <input type="text" class="form-control p-3" id="subject" placeholder="Enter your subject" />
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message*</label>
                            <input type="text" class="form-control p-3" id="message" placeholder="Enter your message" />
                        </div>
                        <button class="w-100 mt-4 btn btn-dark btn-outline-secondary text-light" id="send-email">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark">
        <div class="d-flex container mx-auto justify-content-center justify-content-sm-between flex-wrap gap-2">
            <div class="d-flex flex-column align-items-center align-items-sm-start col-12 col-sm-6">
                <h4 class="text-white">Barber Shop.</h4>
                <p class="text-white mt-4">2024 Barber Shop.</p>
                <p class="text-white">All rights reserved.</p>
            </div>
            <div id="social-medias" class="d-flex gap-5">
                <a href="#" class="social-media">
                    <i class="bi bi-facebook text-white fs-4 cursor-pointer"></i>
                </a>
                <a href="#" class="social-media">
                    <i class="bi bi-instagram text-white fs-4 cursor-pointer"></i>
                </a>
                <a href="#" class="social-media">
                    <i class="bi bi-youtube text-white fs-4 cursor-pointer"></i>
                </a>
            </div>
        </div>
    </footer>
</template>

<script setup lang="ts">

import { register } from 'swiper/element/bundle'
import { onMounted } from 'vue'

import { useUserStore } from '@/stores/user';

const user = useUserStore();

register()

onMounted(async () => {

    const scrollReveal = ScrollReveal({
        origin: 'top',
        distance: '30px',
        duration: 700,
        reset: true
    })

    scrollReveal.reveal(`#home, #about, #services, #testimonials, #contact`, {
        interval: 300
    });

    await user.check();
})
</script>

<style scoped lang="scss">
html.sr .load-hidden {
    visibility: hidden;
}

header #navbarContent ul li:nth-last-child(n+1) a {
    position: relative;
    top: 0;
    transition: color 0.25s !important;

    &:hover {
        color: white !important;
    }

    &::after {
        content: '';
        width: 0%;
        height: 0.1rem;
        position: absolute;
        left: 0;
        bottom: -0.8rem;
        transition: width 0.25s !important;
        background-color: rgb(255, 255, 255) !important; // Ensure visibility
    }

    &:hover::after {
        width: 100% !important;
    }
}

main {
    margin-top: 4.5rem;

    #apresentation {
        max-width: 24rem;
        margin-right: 4rem;
    }

    #container-image::before {
        content: '';
        height: 100%;
        width: 100%;
        background-color: #212529;
        position: absolute;
        top: -16.8%;
        left: 16.7%;
        z-index: 0;
    }

    swiper-container::part(bullet-active) {
        background-color: #212529;
    }

    .testimonial-author img {
        width: 2.5rem;
        height: 2.5rem;
        clip-path: circle();
        object-fit: cover;
    }
}

.mw-30 {
    max-width: 30rem;
}

.h-18 {
    min-height: 18rem;
}

@media screen and (max-width: 768px) {
    main {
        margin: 0;

        #apresentation {
            margin-right: 0;
        }

        #container-image {
            order: -1;
            margin-bottom: 2rem;
        }

        #container-image img {
            right: 2.93rem;
        }
    }
}

@media (min-width: 280px) and (max-width: 1000px) {
    .h-18 {
        min-height: 20rem;
    }
}
</style>
