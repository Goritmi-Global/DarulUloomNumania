<template>
    <main id="main" class="main">
        <!-- Contact Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">{{ translate("Ask a Question") }}</h1>
                <p class="lead">
                    {{
                        translate(
                            "Have a question? Send us a message, and we will respond as soon as possible."
                        )
                    }}
                </p>
            </div>
        </section>

        <!-- Search Bar -->
        <section class="container p-4">
            <div class="mb-4">
                <input
                    type="text"
                    class="form-control"
                    v-model="searchQuery"
                    :placeholder="translate('Search by question or answer...')"
                    @input="searchQuestions"
                />
            </div>

            <!-- Accordion -->
            <div class="accordion" id="questionsAccordion">
                <div
                    class="accordion-item"
                    v-for="(question, index) in questions"
                    :key="question.id"
                >
                    <h2 class="accordion-header" :id="'heading' + index">
                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + index"
                            aria-expanded="false"
                            :aria-controls="'collapse' + index"
                        >
                            {{ truncateText(question.description, 150) }}
                        </button>
                    </h2>
                    <div
                        :id="'collapse' + index"
                        class="accordion-collapse collapse"
                        :aria-labelledby="'heading' + index"
                        data-bs-parent="#questionsAccordion"
                    >
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div
                                            class="card-header bg-primary text-white"
                                        >
                                            {{ translate("Question Details") }}
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Question Short Form"
                                                        )
                                                    }}:</strong
                                                >
                                                {{ question.subject }}
                                            </p>
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Full Question"
                                                        )
                                                    }}:</strong
                                                >
                                                {{ question.description }}
                                            </p>
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Question Date"
                                                        )
                                                    }}:</strong
                                                >
                                                {{ formatDate(question.date) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div
                                            class="card-header bg-success text-white"
                                        >
                                            {{ translate("Answer Details") }}
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Short Answer"
                                                        )
                                                    }}:</strong
                                                >
                                                <span
                                                    v-html="
                                                        question.answer
                                                            .answer_short_form
                                                    "
                                                    class="ms-1"
                                                ></span>
                                            </p>
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Full Answer"
                                                        )
                                                    }}:</strong
                                                >
                                                <span
                                                    v-html="
                                                        question.answer
                                                            .answer_full_form
                                                    "
                                                    class="ms-1"
                                                ></span>
                                            </p>
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Approved By Mufti"
                                                        )
                                                    }}:</strong
                                                >
                                                {{
                                                    question.answer
                                                        ?.approved_by_mufti ||
                                                    translate("Not Available")
                                                }}
                                            </p>
                                            <p>
                                                <strong
                                                    >{{
                                                        translate(
                                                            "Answer Date"
                                                        )
                                                    }}:</strong
                                                >
                                                {{
                                                    question.answer
                                                        ? formatDate(
                                                              question.answer
                                                                  .date
                                                          )
                                                        : translate(
                                                              "Not Available"
                                                          )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center my-4">
                <button
                    class="btn btn-success mx-1"
                    @click="prevPage"
                    :disabled="!pagination.prev"
                >
                    {{ translate("Previous") }}
                </button>
                <button
                    class="btn btn-success mx-1"
                    @click="nextPage"
                    :disabled="!pagination.next"
                >
                    {{ translate("Next") }}
                </button>
            </div>
        </section>

        <!-- Contact Form -->
        <section class="contact-details py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <!-- Made form slightly wider -->
                        <div class="card card-body shadow-sm">
                            <h2 class="theme-text-color text-center">
                                {{ translate("Ask Your Question") }}
                            </h2>
                            <form @submit.prevent="submit">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{
                                        translate("Full Name")
                                    }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        v-model="form.name"
                                        :class="{
                                            'invalid-bg': formErrors.name,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.name"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.name }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{
                                        translate("Email Address")
                                    }}</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        v-model="form.email"
                                        :class="{
                                            'invalid-bg': formErrors.email,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.email"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.email }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">{{
                                        translate("Subject")
                                    }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="subject"
                                        v-model="form.subject"
                                        :class="{
                                            'invalid-bg': formErrors.subject,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.subject"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.subject }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label
                                        for="description"
                                        class="form-label"
                                        >{{
                                            translate("Question Description")
                                        }}</label
                                    >
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        v-model="form.description"
                                        rows="4"
                                        :class="{
                                            'invalid-bg':
                                                formErrors.description,
                                        }"
                                    ></textarea>
                                    <div
                                        v-if="formErrors.description"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.description }}
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                    :disabled="formStatus === 0"
                                >
                                    <span v-if="formStatus === 1">{{
                                        translate("Submit")
                                    }}</span>
                                    <span v-else>
                                        {{ translate("Submitting...") }}
                                        <span
                                            class="spinner-border spinner-border-sm"
                                        ></span>
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
            questions: [],
            searchQuery: "",
            pagination: {
                next: null,
                prev: null,
            },
        };
    },
    methods: {
        validateForm() {
            this.formErrors = {}; // Clear previous errors
            let isValid = true;
            let errorMessages = []; // Store all errors

            if (!this.form.name.trim()) {
                this.formErrors.name = "Full Name is required.";
                isValid = false;
                errorMessages.push("Full Name is required.");
            }
            if (!this.form.email.trim()) {
                this.formErrors.email = "Email Address is required.";
                isValid = false;
                errorMessages.push("Email Address is required.");
            } else if (!/\S+@\S+\.\S+/.test(this.form.email)) {
                this.formErrors.email = "Invalid email format.";
                isValid = false;
                errorMessages.push("Invalid email format.");
            }
            if (!this.form.subject.trim()) {
                this.formErrors.subject = "Subject is required.";
                isValid = false;
                errorMessages.push("Subject is required.");
            }
            if (!this.form.description.trim()) {
                this.formErrors.description =
                    "Question Description is required.";
                isValid = false;
                errorMessages.push("Question Description is required.");
            }

            // Show only one toastr message for all errors
            if (errorMessages.length > 0) {
                toastr.error(errorMessages.join("<br>")); // Display all errors in a single toastr
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
                    toastr.success(
                        this.translate(
                            "Your question has been submitted successfully. We will respond you soon!"
                        )
                    );

                    this.clearFields();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response.data.errors || {};
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
        fetchQuestions(page = 1) {
            axios
                .get(`/api/questions/approved`, {
                    params: { page: page, search: this.searchQuery },
                })
                .then((response) => {
                    this.questions = response.data.data; // Make sure API returns data
                    this.pagination.currentPage = response.data.current_page;
                    this.pagination.lastPage = response.data.last_page;
                    this.pagination.next = response.data.next_page_url !== null;
                    this.pagination.prev = response.data.prev_page_url !== null;
                })
                .catch((error) => {
                    console.error(
                        "Error fetching questions",
                        error.response.data
                    );
                });
        },
        searchQuestions() {
            this.fetchQuestions(1); // Fetch results with search applied
        },
        nextPage() {
            if (this.pagination.next)
                this.fetchQuestions(this.pagination.currentPage + 1);
        },
        prevPage() {
            if (this.pagination.prev)
                this.fetchQuestions(this.pagination.currentPage - 1);
        },
        truncateText(text, length) {
            if (!text) return "";
            return text.length > length
                ? text.substring(0, length) + "..."
                : text;
        },
        formatDate(dateString) {
            if (!dateString) return "Not Available";
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(dateString).toLocaleDateString("en-US", options);
        },
    },
    mounted() {
        this.fetchQuestions();
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
