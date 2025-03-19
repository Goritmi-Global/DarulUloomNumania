<template>
    <main id="main" class="main">
        <!-- Contact Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">Contact Us</h1>
                <p class="lead">We are here to assist you. Feel free to reach out to us.</p>
            </div>
        </section>

        <!-- Contact Details -->
        <section class="contact-details py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="theme-text-color">Get in Touch</h2>
                        <p><strong>Address:</strong> 123 Madrasa Road, City, Country</p>
                        <p><strong>Phone:</strong> +123 456 7890</p>
                        <p><strong>Email:</strong> info@jamianoumania.com</p>
                        <div class="map-container mt-3">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434508616!2d144.95592631550464!3d-37.81720974201461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d5df1fbd5cf%3A0x5045675218cee40!2sMelbourne%20Central!5e0!3m2!1sen!2sau!4v1612485674424!5m2!1sen!2sau"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="card card-body">
                        <h2 class="theme-text-color">Send Us a Message</h2>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Master from "./Layout/MasterFront.vue";

export default {
    layout: Master,
};
</script>

<style>
.hero-section {
    margin-top: 70px;
    background-color: var(--primary-color);
}
.contact-details {
    background-color: #f9f9f9;
    padding: 40px 0;
}
.map-container iframe {
    border-radius: 10px;
}
</style>