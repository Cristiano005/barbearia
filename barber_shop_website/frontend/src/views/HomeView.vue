<template>
    <section id="home">
        <div class="container">
            <div class="row justify-content-center">
                <div id="apresentation" class="col-12 col-lg-6">
                    <h2 class="lh-base mb-4 fw-bold">Wecolme to Barber Shop in Fiction City.</h2>
                    <p class="lh-base mb-4">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium.
                    </p>
                    <button
                        class="d-flex align-items-center justify-content-center btn btn-dark px-5"
                    >
                        Schedule an hour
                        <i class="bi bi-alarm-fill p-2"></i>
                    </button>
                </div>
                <div class="position-relative col-12 col-lg-6" id="container-image">
                    <img
                        class="position-relative rounded-1 w-100 h-auto"
                        src="https://matheuscostadesign.github.io/nlw6-beauty-salon/assets/images/main.jpg"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </section>
    <div class="left-to-right-divider"></div>
    <section id="about">
        <div class="container mx-auto">
            <div class="row">
                <header class="text-center mx-auto col-12 mb-5 mw-30">
                    <h3>Why choose us?</h3>
                    <p class="mt-4">
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                        praesentium voluptatum deleniti atque corrupti quos dolores et quas
                        molestias excepturi sint.
                    </p>
                </header>
            </div>
            <div class="row gap-4 justify-content-center mt-4 mx-auto">
                <!-- First card -->
                <div class="card col-12 col-md-5 col-xl-3 py-5 px-4">
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
                <div class="card col-12 col-md-5 col-xl-3 py-5 px-4">
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
                <div class="card col-12 col-md-5 col-xl-3 py-5 px-4">
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
    <div class="right-to-left-divider"></div>
    <section id="services">
        <div class="container">
            <div class="row">
                <header class="text-center mx-auto col-12 mb-5 mw-30">
                    <h3>Our services</h3>
                </header>
            </div>
            <div class="row gap-4 justify-content-center mt-4 mx-auto">
                <div class="card p-0 col-lg-3 col-md-5 col-sm-12">
                    <img
                        src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        style="height: 20rem"
                        class="card-img-top object-fit-cover"
                        alt="..."
                    />
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
                    <img
                        src="https://images.unsplash.com/photo-1533245270348-821d4d5c7514?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        style="height: 20rem"
                        class="card-img-top object-fit-cover"
                        alt="..."
                    />
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
                    <img
                        src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?q=80&w=1888&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        style="height: 20rem"
                        class="card-img-top object-fit-cover"
                        alt="..."
                    />
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
    <section id="testimonials">
        <div class="container">
            <header class="text-center mx-auto col-12 mw-30" id="services-header">
                <h3>Testimonials</h3>
                <p class="mt-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </header>
            <div class="row justify-content-center mt-6">
                <swiper-container
                    class="h-18"
                    pagination="true"
                    space-between="30"
                    :breakpoints="{
                        280: { slidesPerView: 1 },
                        720: { slidesPerView: 2 }
                    }"
                >
                    <swiper-slide>
                        <div class="card p-2">
                            <div class="card-body">
                                <p class="card-text">
                                    <i class="bi bi-quote fs-4"></i>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley
                                    of type and scrambled it to make a type specimen book.
                                </p>
                                <div
                                    class="d-flex justify-content-start align-items-center gap-2 testimonial-author"
                                >
                                    <img
                                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="img-fluid"
                                        alt="..."
                                    />
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
                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley
                                    of type and scrambled it to make a type specimen book.
                                </p>
                                <div
                                    class="d-flex justify-content-start align-items-center gap-2 testimonial-author"
                                >
                                    <img
                                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="img-fluid"
                                        alt="..."
                                    />
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
                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley
                                    of type and scrambled it to make a type specimen book.
                                </p>
                                <div
                                    class="d-flex justify-content-start align-items-center gap-2 testimonial-author"
                                >
                                    <img
                                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="img-fluid"
                                        alt="..."
                                    />
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
                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley
                                    of type and scrambled it to make a type specimen book.
                                </p>
                                <div
                                    class="d-flex justify-content-start align-items-center gap-2 testimonial-author"
                                >
                                    <img
                                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                        class="clip-path img-fluid"
                                        alt="..."
                                    />
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
    <section id="contact">
        <div class="container">
            <div class="row justify-content-center gap-5">
                <div id="test" class="mt-3 col-lg-5 col-sm-12">
                    <div>
                        <h4>Contact us on WhatsApp.</h4>
                        <p class="mt-4 w-75">
                            Contact us for any questions. We are available today via WhatsApp and
                            email.
                        </p>
                        <button class="btn btn-dark px-5">
                            <i class="bi bi-whatsapp"></i>
                            WhatsApp
                        </button>
                    </div>
                </div>

                <form
                    method="post"
                    class="d-flex flex-column gap-4 col-lg-5 col-sm-12"
                    id="contactForm"
                >
                    <div class="col-12">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control p-3"
                            id="exampleInputEmail1"
                            aria-describedby="emailHelp"
                            placeholder="Write your e-mail"
                        />
                    </div>
                    <div class="col-12">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control p-3"
                            id="exampleInputPassword1"
                            placeholder="Write your password"
                        />
                    </div>
                    <div class="col-12">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control p-3"
                            id="exampleInputEmail1"
                            aria-describedby="emailHelp"
                            placeholder="Write your e-mail"
                        />
                    </div>
                    <div class="col-12">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control p-3"
                            id="exampleInputPassword1"
                            placeholder="Write your password"
                        />
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
    </section>
</template>

<script setup lang="ts">
// import function to register Swiper custom elements
import { register } from 'swiper/element/bundle'
// register Swiper custom elements
register()
</script>

<style scoped lang="scss">

#apresentation {
    max-width: 24rem;
    margin-right: 4rem;
}

button {
    height: 3.125rem;
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

.mw-30 {
    max-width: 30rem;
}

.mt-6 {
    margin-top: 5rem;
}

#map {
    height: 20rem;
}

.h-18 {
    min-height: 18rem;
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

@media screen and (max-width: 768px) {
    main {
        margin: 0;
    }

    #home {
        overflow-x: hidden;
    }

    #container-image {
        order: -1;
        margin-bottom: 2rem;
    }

    #container-image img {
        right: 2.93rem;
    }

    #apresentation {
        margin-right: 0;
    }
}
</style>
