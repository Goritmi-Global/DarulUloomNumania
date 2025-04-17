<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">{{ translate("About Jamia Darul Uloom Noumania")}} </h1>
                <p class="lead">
                    {{ translate("A beacon of Islamic knowledge, nurturing faith and intellect.") }}
                </p>
            </div>
        </section>

        <!-- About Us Section -->
        <section class="about-section py-5 bg-light">
            <div class="container">
                <h2 class="display-4 p-3 theme-text-color">{{ translate("Who We Are") }}</h2>
                <p>
                    {{ translate(
                        "Jamia Darol Uloom Noumania Utmanzai is dedicated to providing quality Islamic education integrated with modern learning techniques. Our mission is to spread the light of knowledge and help students develop a strong connection with their faith."
                        ) 
                        }}
                    
                </p>
            </div>
        </section>

        <!-- Our Vision & Mission -->
        <section class="vision-mission-section py-5">
            <div class="container">
                <h2 class="display-4 p-3 theme-text-color">
                    {{ translate("Our Vision & Mission") }}
                </h2>
                <p>
                    {{ 
                        translate(
                            "Our vision is to create a generation of scholars who embody the true spirit of Islam, practicing and preaching with sincerity. We aim to provide an educational environment that nurtures both academic and spiritual growth."
                        ) 
                        }}
                    
                </p>
            </div>
        </section>

        <!-- Leadership Section -->
        <section class="leadership-section py-5 bg-light">
            <div class="container">
                <h2 class="display-4 p-3 theme-text-color">{{ translate("Our Leadership") }}</h2>
                <p>
                    {{ translate("Under the guidance of esteemed scholars and educators, Jamia Darul Uloom Noumania continues to uphold the highest standards of Islamic education.") }}
                </p>
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
/* General Styles */
.hero-section {
    margin-top: 70px;
    background-color: var(--primary-color);
}

.theme-text-color {
    color: var(--primary-color);
}
</style>
