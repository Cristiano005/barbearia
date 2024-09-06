<template>
    <section id="home">
        <div class="d-flex gap-4 mx-auto row" id="container-home">
            <div id="apresentation" class="col-12 col-md-6">
                <h2 class="lh-base mb-4 fw-bold">Wecolme to Barber Shop in Nova Odessa.</h2>
                <p class="lh-base mb-4">
                    Um salão exclusivo em São Paulo, especializado em tratamentos naturais.
                </p>
                <button class="d-flex align-items-center justify-content-center btn btn-dark px-5">
                    Schedule an hour
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
    </section>
    <div class="divider"></div>
    <section id="services">
        <div class="container-fluid mx-auto">
            <div class="row">
                <header class="text-center mx-auto col-12 mb-5" id="services-header">
                    <h3>Why choose us?</h3>
                    <p class="mt-4">
                        Com mais de 10 anos no mercado, o Beautysalon já conquistou clientes de
                        inúmeros países com seus tratamentos exclusivos e totalmente naturais
                    </p>
                </header>
            </div>
            <div class="row gap-4 justify-content-center">
                <!-- First card -->
                <div class="card col-12 col-md-3 py-5 px-4">
                    <div class="icon d-flex justify-content-center">
                        <i
                            class="fa-solid fa-hand-holding-dollar fs-1 bg-dark rounded text-warning p-4"
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
                        <i class="fa-solid fa-scissors fs-1 bg-dark rounded text-warning p-4"></i>
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
                        <i class="fa-solid fa-seedling fs-1 bg-dark rounded text-warning p-4"></i>
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
    <section id="contact">
        <div id="container-map">
            <div id="map"></div>
            <div class="d-flex flex-column align-items-center justify-content-center mt-5">
                <h3 class="text-secondary">Adress:</h3>
                <small class="fs-6 mt-2"> Fictional street </small>
                <small class="mt-2"> Nova Odessa - SP, Brazil </small>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center mt-5">
            <h3 class="text-secondary" id="title-section">Contact us</h3>
            <div id="contact" class="mw-100">
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
                        <label for="subject" class="form-label" id="label-subject">Subject</label>
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
    </section>
    <div class="divider"></div>
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

#background-effect {
    width: 40rem;
    top: -16.8%;
    left: 16.8%;
}

img {
    width: 40rem;
    height: auto;
}

#services div.container div.row:nth-child(2) {
    margin-top: 6rem;
}

#services-header {
    max-width: 30rem;
}
</style>
