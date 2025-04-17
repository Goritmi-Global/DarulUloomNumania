<template>
    <main id="main" class="main">
        <!-- Contact Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">{{ translate("Contact Us") }}</h1>
                <p class="lead">{{ translate("We are here to assist you. Feel free to reach out to us") }}.</p>
            </div>
        </section>

        <!-- Contact Details -->
        <section class="contact-details py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="theme-text-color text-center mb-4">{{
                        translate(
                            "Jamia Darol Uloom Noumania Utmanzai"
                        )
                    }}</h2>
                        <p class="text-center"><strong>{{ translate("Phone") }}:</strong> 091650861</p>
                        <p class="text-center"><strong>{{ translate("Email") }}:</strong> info@jamianoumania.com</p>

                        <div class="map-container mt-4">
                            <iframe
                                src="https://www.google.com/maps?q=34.17684698606916,71.76090259806283&hl=es;z=14&output=embed"
                                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
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
