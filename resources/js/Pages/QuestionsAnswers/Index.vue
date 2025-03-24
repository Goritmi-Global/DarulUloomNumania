<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">
                    {{ translate("Asked Questions") }}
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{
                                translate("Darul Oloom")
                            }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Asked Questions") }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">
                        {{ translate("All Asked Questions") }}
                    </h5>
                    
                    <div class="accordion" id="questionsAccordion">
                        <div
                            class="accordion-item"
                            v-for="(question, index) in questions"
                            :key="question.id"
                        >
                            <h2 class="accordion-header" :id="'heading' + index">
                                <button
                                    class="accordion-button"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    :data-bs-target="'#collapse' + index"
                                    aria-expanded="true"
                                    :aria-controls="'collapse' + index"
                                >
                                    <strong>{{ question.subject }}</strong> - {{ question.name }}
                                    <span class="ms-3 badge" :class="getStatusClass(question.status)">
                                        {{ getStatusText(question.status) }}
                                    </span>
                                </button>
                            </h2>

                            <div
                                :id="'collapse' + index"
                                class="accordion-collapse collapse"
                                :aria-labelledby="'heading' + index"
                                data-bs-parent="#questionsAccordion"
                            >
                                <div class="accordion-body">
                                    <p><strong>Email:</strong> {{ question.email }}</p>
                                    <p><strong>Subject:</strong> {{ question.subject }}</p>
                                    <p><strong>Date:</strong> {{ question.date }}</p>
                                    <p><strong>Description:</strong> {{ question.description }}</p>

                                    <button
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#replyModal"
                                        @click="openReplyModal(question)"
                                    >
                                        {{ translate("Reply") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Modal -->
            <div
                class="modal fade"
                id="replyModal"
                tabindex="-1"
                aria-labelledby="replyModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary">
                                {{ translate("Reply to Question") }}
                            </h5>
                            <button
                                ref="closeModal"
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="answer_short_form" class="form-label">
                                            {{ translate("Short Answer") }}
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="answer_short_form"
                                            v-model="replyForm.answer_short_form"
                                            :class="{ 'invalid-bg': replyErrors.answer_short_form }"
                                        />
                                        <div
                                            v-if="replyErrors.answer_short_form"
                                            class="invalid-feedback"
                                        >
                                            {{ replyErrors.answer_short_form[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="answer_full_form" class="form-label">
                                            {{ translate("Full Answer") }}
                                        </label>
                                        <textarea
                                            class="form-control"
                                            id="answer_full_form"
                                            v-model="replyForm.answer_full_form"
                                            rows="4"
                                            :class="{ 'invalid-bg': replyErrors.answer_full_form }"
                                        ></textarea>
                                        <div
                                            v-if="replyErrors.answer_full_form"
                                            class="invalid-feedback"
                                        >
                                            {{ replyErrors.answer_full_form[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="approved_by_mufti" class="form-label">
                                            {{ translate("Approved By Mufti (Optional)") }}
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="approved_by_mufti"
                                            v-model="replyForm.approved_by_mufti"
                                        />
                                    </div>

                                    <div class="mt-3">
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            v-if="replyStatus === 1"
                                            @click="submitReply"
                                        >
                                            {{ translate("Submit Reply") }}
                                        </button>
                                        <button
                                            class="btn btn-success"
                                            type="button"
                                            disabled
                                            v-else
                                        >
                                            {{ translate("Submitting...") }}
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/Master.vue";

export default {
    layout: Master,
    data() {
        return {
            questions: [],
            replyForm: {
                question_id: "",
                answer_short_form: "",
                answer_full_form: "",
                approved_by_mufti: "",
            },
            replyErrors: [],
            replyStatus: 1, // 1 = ready, 0 = saving
        };
    },
    created() {
        this.fetchQuestions();
    },
    methods: {
        fetchQuestions() {
            axios
                .get(route("api.question.fetch"))
                .then((response) => { 
                    this.questions = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        openReplyModal(question) {
            this.replyForm.question_id = question.id;
            this.replyForm.answer_short_form = "";
            this.replyForm.answer_full_form = "";
            this.replyForm.approved_by_mufti = "";
            this.replyErrors = [];
        },
        submitReply() {
            this.replyStatus = 0;

            axios
                .post(route("api.answer.store"), this.replyForm)
                .then(() => {
                    this.$refs.closeModal.click();
                    this.replyStatus = 1;
                    toastr.success(
                        this.translate("Reply submitted successfully.")
                    );
                    this.fetchQuestions();
                })
                .catch((error) => {
                    this.replyStatus = 1;
                    this.replyErrors = error.response?.data?.errors || {};
                    toastr.error(
                        error.response?.data?.message || "An error occurred."
                    );
                });
        },
        getStatusText(status) {
            return status === 0
                ? "Not Replied"
                : status === 1
                ? "Waiting for Approval"
                : "Replied";
        },
        getStatusClass(status) {
            return status === 0
                ? "bg-danger text-white"
                : status === 1
                ? "bg-warning text-dark"
                : "bg-success text-white";
        },
    },
};
</script>
