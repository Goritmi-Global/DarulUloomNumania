<template>
    <main id="main" class="main">
        <!-- questoin Hero Section -->

        <section class="hero-section text-center text-white py-5">
            <div class="container">
                <h1 class="display-4 fw-bold">
                    {{ translate("Ask a Question") }}
                </h1>
                <p class="lead">
                    {{
                        translate(
                            "Have a question? Send us a message, and we will respond as soon as possible"
                        )
                    }}
                </p>
                <a
                    href="#ask-question-section"
                    class="btn btn-light btn-lg mt-3 shadow rounded-pill"
                >
                    {{ translate("Ask Question") }}
                </a>
            </div>
        </section>

        <!-- Search Bar -->
        <section class="container p-4">
            <!-- Search Input Block -->
            <div class="mb-5">
                <label
                    for="searchInput"
                    class="form-label fw-semibold theme-text-color mb-2"
                >
                    {{
                        translate("Search by Fatwa Number, Question or Answer")
                    }}
                </label>
                <div
                    class="input-group shadow-sm rounded-pill overflow-hidden border border-2 border-theme"
                >
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control border-0 rounded-start-pill py-2 px-4"
                        :placeholder="translate('Start typing to search')"
                        v-model="searchQuery"
                        @input="searchQuestions"
                        style="font-size: 1rem"
                    />
                    <span
                        class="input-group-text bg-white border-0 rounded-end-pill"
                    >
                        <i class="bi bi-search theme-text-color"></i>
                    </span>
                </div>
            </div>

            <!-- Accordion -->

            <h2 class="theme-text-color text-center mb-4">
                {{ translate("Questions and Answers") }}
                <!-- <br> -->
                <!-- {{ $page.props.default_language }} - test -->
            </h2>
            <div class="accordion" id="questionsAccordion">
                <div
                    class="accordion-item mb-3 border-0 shadow-sm rounded-4 overflow-hidden"
                    v-for="(question, index) in questions"
                    :key="question.id"
                >
                    <!-- Accordion Header -->
                    <h2 class="accordion-header" :id="'heading' + index">
                        <button
                            :class="{
                                'text-end flex-row-reverse':
                                    $page.props.default_language != 'US',
                                'text-start':
                                    $page.props.default_language === 'US',
                            }"
                            class="accordion-button collapsed bg-light fw-semibold"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#collapse' + index"
                            aria-expanded="false"
                            :aria-controls="'collapse' + index"
                            style="padding: 1rem 1.5rem; font-size: 1.1rem"
                        >
                            {{ truncateText(question.subject, 150) }}
                        </button>
                    </h2>

                    <!-- Accordion Content -->
                    <div
                        :id="'collapse' + index"
                        class="accordion-collapse collapse"
                        :aria-labelledby="'heading' + index"
                        data-bs-parent="#questionsAccordion"
                    >
                        <div class="accordion-body bg-white p-4">
                            <div class="row g-3 sawal-jawab">
                                <div class="col-12">
                                    <!-- Question Section -->
                                    <h5
                                        class="question_heading theme-text-color mb-2"
                                    >
                                        {{ translate("Question") }}
                                    </h5>
                                    <p class="mb-2">{{ question.subject }}</p>
                                    <p
                                        v-html="question.description"
                                        class="mb-3"
                                    ></p>
                                    <small class="text-muted">{{
                                        formatDate(question.date)
                                    }}</small>

                                    <!-- Answer Section -->
                                    <h5
                                        class="question_heading theme-text-color mt-4"
                                    >
                                        {{ translate("Answer") }}
                                    </h5>
                                    <p
                                        v-html="
                                            question.answer.answer_short_form
                                        "
                                        class="mb-3"
                                    ></p>

                                    <!-- Answer Details -->
                                    <h6 class="theme-text-color fw-bold">
                                        {{ translate("Answer Details") }}
                                    </h6>
                                    <p
                                        v-html="
                                            question.answer.answer_full_form
                                        "
                                    ></p>

                                    <!-- Extra Info -->
                                    <div
                                        v-if="
                                            question.answer.fitwa_number ||
                                            question.answer.approved_by_mufti
                                        "
                                        class="mt-3"
                                    >
                                        <p
                                            v-if="question.answer.fitwa_number"
                                            class="mb-1"
                                        >
                                            <strong
                                                >{{
                                                    translate("Fatwa Number")
                                                }}:</strong
                                            >
                                            #{{ question.answer.fitwa_number }}
                                        </p>
                                        <p
                                            v-if="
                                                question.answer
                                                    .approved_by_mufti
                                            "
                                        >
                                            <strong
                                                >{{
                                                    translate(
                                                        "Approved By Mufti"
                                                    )
                                                }}:</strong
                                            >
                                            {{
                                                question.answer
                                                    .approved_by_mufti
                                            }}
                                        </p>
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
                    id="ask-question-section"
                    class="btn btn-success mx-1"
                    @click="nextPage"
                    :disabled="!pagination.next"
                >
                    {{ translate("Next") }}
                </button>
            </div>
        </section>

        <!-- Question Form -->
        <section class="questoin-details py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-lg border-0 rounded-4 p-4">
                            <h2 class="theme-text-color text-center mb-4">
                                {{ translate("Ask Your Question") }}
                            </h2>
                            <form @submit.prevent="submit" class="row g-3">
                                <!-- Full Name -->
                                <div class="col-md-6">
                                    <label
                                        for="name"
                                        class="form-label fw-semibold"
                                        >{{ translate("Full Name") }}</label
                                    >
                                    <input
                                        type="text"
                                        id="name"
                                        class="form-control rounded-pill px-4 py-2 shadow-sm border border-2"
                                        v-model="form.name"
                                        :class="{
                                            'border-danger': formErrors.name,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.name"
                                        class="text-danger small mt-1"
                                    >
                                        {{ formErrors.name }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label
                                        for="email"
                                        class="form-label fw-semibold"
                                        >{{ translate("Email Address") }}</label
                                    >
                                    <input
                                        type="email"
                                        id="email"
                                        class="form-control rounded-pill px-4 py-2 shadow-sm border border-2"
                                        v-model="form.email"
                                        :class="{
                                            'border-danger': formErrors.email,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.email"
                                        class="text-danger small mt-1"
                                    >
                                        {{ formErrors.email }}
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div class="col-md-12">
                                    <label
                                        for="subject"
                                        class="form-label fw-semibold"
                                        >{{ translate("Subject") }}</label
                                    >
                                    <input
                                        type="text"
                                        id="subject"
                                        class="form-control rounded-pill px-4 py-2 shadow-sm border border-2"
                                        v-model="form.subject"
                                        :class="{
                                            'border-danger': formErrors.subject,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.subject"
                                        class="text-danger small mt-1"
                                    >
                                        {{ formErrors.subject }}
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label
                                        for="description"
                                        class="form-label fw-semibold"
                                        >{{
                                            translate("Question Description")
                                        }}</label
                                    >
                                    <textarea
                                        id="description"
                                        rows="4"
                                        class="form-control rounded-4 px-4 py-3 shadow-sm border border-2"
                                        v-model="form.description"
                                        :class="{
                                            'border-danger':
                                                formErrors.description,
                                        }"
                                    ></textarea>
                                    <div
                                        v-if="formErrors.description"
                                        class="text-danger small mt-1"
                                    >
                                        {{ formErrors.description }}
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12">
                                    <button
                                        type="submit"
                                        class="btn w-100 rounded-pill py-2 fw-semibold text-white"
                                        :disabled="formStatus === 0"
                                        style="background-color: #174696"
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
                                </div>
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
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default {
    layout: Master,
    components: {
        QuillEditor,
    },
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
                this.formErrors.name = this.translate("Full Name is required.");
                isValid = false;
                errorMessages.push(this.translate("Full Name is required."));
            }

            if (!this.form.email.trim()) {
                this.formErrors.email = this.translate(
                    "Email Address is required."
                );
                isValid = false;
                errorMessages.push(
                    this.translate("Email Address is required.")
                );
            } else if (!/\S+@\S+\.\S+/.test(this.form.email)) {
                this.formErrors.email = this.translate("Invalid email format.");
                isValid = false;
                errorMessages.push(this.translate("Invalid email format."));
            }

            if (!this.form.subject.trim()) {
                this.formErrors.subject = this.translate(
                    "Subject is required."
                );
                isValid = false;
                errorMessages.push(this.translate("Subject is required."));
            }

            if (!this.form.description.trim()) {
                this.formErrors.description = this.translate(
                    "Question Description is required."
                );
                isValid = false;
                errorMessages.push(
                    this.translate("Question Description is required.")
                );
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
.questoin-details {
    background-color: #f9f9f9;
    padding: 40px 0;
}
.invalid-bg {
    border-color: red !important;
}

.sawal-jawab h3,
.sawal-jawab h4 {
    background: #174696;
    color: white;
    font-size: 26px;
    padding: 10px 12px;
    margin-bottom: 20px;
}
.hero-section {
    background: linear-gradient(120deg, #023f86, #035bb8);
    color: white;
    margin-top: 60px;
}
.theme-text-color {
    color: #023f86;
}

.accordion-button {
    background-color: #dee2e6 !important;
    color: #174696;
    font-weight: 600;
    transition: background-color 0.3s ease;
    border-color: #174696 !important;
    box-shadow: 0 0 0 0.2rem rgba(23, 70, 150, 0.25) !important;
}

.accordion-button:not(.collapsed) {
    background-color: #e0ecf8;
    color: #174696;
}

.accordion-button:focus {
    box-shadow: none;
}

.accordion-body {
    background-color: #fff;
    color: #333;
    line-height: 1.6;
    font-size: 1rem;
    border-top: 1px solid #dee2e6;
}

.question_heading {
    font-size: 1.1rem;
    font-weight: 600;
    background-color: #f1f5fb;
    padding: 0.5rem 1rem;
    border-left: 4px solid #174696;
    margin-bottom: 1rem;
    border-radius: 0.3rem;
}
.input-group-text i {
    font-size: 1.2rem;
}

input::placeholder {
    color: #999;
}

.border-theme {
    border-color: #174696 !important;
}
.theme-text-color {
    color: #174696;
}
.form-control:focus {
    border-color: #174696;
    box-shadow: 0 0 0 0.2rem rgba(23, 70, 150, 0.25);
}
</style>
