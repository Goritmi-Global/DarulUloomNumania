<template>
    <main id="main" class="main">
        <!-- Contact Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">Ask a Question</h1>
                <p class="lead">Have a question? Send us a message, and we will respond as soon as possible.</p>
            </div>
        </section>

        <!-- Contact Form -->
        <section class="contact-details py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-body">
                            <h2 class="theme-text-color text-center">Submit Your Question</h2>
                            <form @submit.prevent="submit">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="name" 
                                        v-model="form.name"
                                        :class="{ 'invalid-bg': formErrors.name }"
                                    />
                                    <div v-if="formErrors.name" class="invalid-feedback">
                                        {{ formErrors.name }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email" 
                                        v-model="form.email"
                                        :class="{ 'invalid-bg': formErrors.email }"
                                    />
                                    <div v-if="formErrors.email" class="invalid-feedback">
                                        {{ formErrors.email }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="subject" 
                                        v-model="form.subject"
                                        :class="{ 'invalid-bg': formErrors.subject }"
                                    />
                                    <div v-if="formErrors.subject" class="invalid-feedback">
                                        {{ formErrors.subject }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Question Description</label>
                                    <textarea 
                                        class="form-control" 
                                        id="description" 
                                        v-model="form.description" 
                                        rows="4"
                                        :class="{ 'invalid-bg': formErrors.description }"
                                    ></textarea>
                                    <div v-if="formErrors.description" class="invalid-feedback">
                                        {{ formErrors.description }}
                                    </div>
                                </div>

                                <button 
                                    type="submit" 
                                    class="btn btn-success w-100"
                                    :disabled="formStatus === 0"
                                >
                                    <span v-if="formStatus === 1">Submit</span>
                                    <span v-else>
                                        Submitting...
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import axios from "axios";
import Master from "./Layout/MasterFront.vue";

export default {
    layout: Master,
    data() {
        return {
            form: {
                name: "",
                email: "",
                subject: "",
                description: "",
            },
            formErrors: {}, // Store validation errors
            formStatus: 1, // 1 = ready, 0 = saving
        };
    },
    methods: {
        validateForm() {
            this.formErrors = {}; // Clear previous errors
            let isValid = true;

            if (!this.form.name.trim()) {
                this.formErrors.name = "Full Name is required.";
                isValid = false;
                toastr.error("Full Name is required.");
            }
            if (!this.form.email.trim()) {
                this.formErrors.email = "Email Address is required.";
                isValid = false;
                toastr.error("Email is required.");
            } else if (!/\S+@\S+\.\S+/.test(this.form.email)) {
                this.formErrors.email = "Invalid email format.";
                isValid = false;
                toastr.error("Invalid email format.");
            }
            if (!this.form.subject.trim()) {
                this.formErrors.subject = "Subject is required.";
                isValid = false;
                toastr.error("Subject is required.");
            }
            if (!this.form.description.trim()) {
                this.formErrors.description = "Question Description is required.";
                isValid = false;
                toastr.error("Question Description is required.");
            }

            return isValid;
        },
        submit() {
            if (!this.validateForm()) {
                return; // Stop form submission if validation fails
            }

            this.formStatus = 0; // Disable form while saving

            axios
                .post(route("api.question.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    this.formErrors = {};
                    toastr.success("Your question has been submitted successfully.");
                    this.clearFields();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response?.data?.errors || {};
                    toastr.error(error.response?.data?.message || "An error occurred.");
                });
        },
        clearFields() {
            this.form = {
                name: "",
                email: "",
                subject: "",
                description: "",
            };
            this.formErrors = {};
        },
    },
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
.invalid-bg {
    border-color: red !important;
}
</style>
