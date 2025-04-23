<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">
                    {{ translate("Privacy and Policy") }}
                    <br />
                    {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                </h1>

                <h2>
                    {{ translate("Charsadda Khyber PakhtunKhwa Pakistan") }}
                </h2>
            </div>
        </section>

        <!-- Policy Details -->
        <section class="policy-details py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h2 class="text-center mb-4 theme-text-color">
                            {{ translate("Our Commitment to Privacy") }}
                        </h2>
                        <p>
                            {{
                                translate(
                                    "We are committed to protecting your personal information and your right to privacy."
                                )
                            }}
                        </p>
                        <p>
                            {{
                                translate(
                                    "This Privacy Policy outlines how we collect, use, and protect your information when you interact with our website."
                                )
                            }}
                        </p>
                        <p>
                            {{
                                translate(
                                    "We do not share your personal data with third parties except where required by law."
                                )
                            }}
                        </p>
                        <p>
                            {{
                                translate(
                                    "By using our site, you agree to our Privacy Policy."
                                )
                            }}
                        </p>
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
    methods: {},
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
</style>
