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
                    <div class="col-md-10 policy-content">
                        <h2 class="text-center mb-4 theme-text-color">
                            {{ translate("Our Commitment to Privacy") }}
                        </h2>

                        <p>
                            {{
                                translate(
                                    "Welcome to Numania. Your privacy is important to us, and we are committed to protecting the information you share while using our services. This Privacy Policy explains how we collect, use, and protect your data when you use the Numania mobile application (the “App”) and our website (the “Website”)."
                                )
                            }}
                        </p>

                        <hr />

                        <p>
                            {{
                                translate(
                                    "This Privacy Policy outlines how we collect, use, and protect your information when you interact with our website."
                                )
                            }}
                        </p>

                        <h4>1. <b>{{ translate("Information We Collect") }}</b></h4>

                        <p>
                            <strong>
                                {{
                                    translate(
                                        "To provide you with help and support, the Numania app collects the following personal information from users:"
                                    )
                                }}
                            </strong>
                        </p>

                        <ul class="custom-list">
                            <li>{{ translate("Name") }}</li>
                            <li>{{ translate("Email Address") }}</li>
                            <li>{{ translate("Question or Message Submitted for Help") }}</li>
                        </ul>

                        <p>
                            {{
                                translate(
                                    "This information is collected solely for the purpose of responding to your queries and improving your experience with the app."
                                )
                            }}
                        </p>

                        <hr />

                        <p>
                            <strong>2. {{ translate("How We Use Your Information") }}</strong>
                        </p>

                        <ul class="custom-list">
                            <li>{{ translate("Provide support and respond to your inquiries") }}</li>
                            <li>{{ translate("Understand user needs and improve the app experience") }}</li>
                            <li>{{ translate("Ensure smooth operation of our services hosted on our online servers") }}</li>
                        </ul>

                        <p>
                            {{
                                translate(
                                    "We do not sell, rent, or share your personal information with third parties."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>3. {{ translate("Data Storage") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "The Numania app operates entirely through online servers. No personal data or preferences are stored on your device. All content and user interactions are processed in real-time through our secure server infrastructure."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>4. {{ translate("Third Party Services") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "The Numania app is distributed through the Google Play Store and Apple App Store, which may have their own data collection policies. We recommend reviewing their respective privacy policies to understand how they manage user data."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>5. {{ translate("Your Privacy Choices") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "You may choose not to submit personal information through the app. However, this may limit our ability to assist you. If you wish to request deletion of your submitted data, please contact us directly."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>6. {{ translate("Security") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "We use secure server technologies to safeguard your information during transmission and storage. However, we advise users to keep their devices and accounts protected using standard security practices."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>7. {{ translate("Data Deletion") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "At Numania, we respect your right to privacy and data control. While our app does not require user accounts, we do collect basic information (name, email, and question) to provide support."
                                )
                            }}
                        </p>
                        <p>
                            {{
                                translate(
                                    "If you wish to have this data deleted from our systems, you can submit a request by emailing us at:"
                                )
                            }}
                        </p>
                        <p><strong>📧 jamianumania2025@gmail.com</strong></p>
                        <p>
                            {{
                                translate(
                                    "Please include the email address and name you used when submitting your inquiry so we can identify and delete your data accurately. We will process your request in a timely manner and confirm once the data has been deleted."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>8. {{ translate("Changes to This Privacy Policy") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "We may update this Privacy Policy periodically. Any changes will be posted on our website, and continued use of the app after changes are made constitutes your acceptance of the updated policy."
                                )
                            }}
                        </p>

                        <hr />

                        <p><strong>9. {{ translate("Contact Us") }}</strong></p>
                        <p>
                            {{
                                translate(
                                    "If you have any questions, concerns, or requests regarding your data or this Privacy Policy, please contact us at:"
                                )
                            }}
                        </p>
                        <p><strong>jamianumania2025@gmail.com</strong></p>
                        <p>
                            {{
                                translate(
                                    "By using Numania, you acknowledge that you have read and understood this Privacy Policy."
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

.policy-content {
    line-height: 1.7;
    font-size: 1rem;
    color: #333;
}

.custom-list {
    font-weight: bold;
    padding-left: 20px;
    margin-top: 10px;
    margin-bottom: 10px;
}

.custom-list li {
    margin-bottom: 8px;
}

hr {
    border: 0;
    border-top: 1px solid #ccc;
    margin: 30px 0;
}
</style>
