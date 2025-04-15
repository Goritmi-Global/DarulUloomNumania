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
                    <div class="mb-3">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>

                    <div class="table-responsive">
                        <div
                            v-if="searchQuery"
                            class="mt-3 mb-3 badge bg-success text-white"
                        >
                            <b>
                                {{ translate("Searched for") }} :
                                {{ searchQuery }}</b
                            >
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        {{ translate("Question Short Form") }}
                                    </th>
                                    <th>{{ translate("Short Answer") }}</th>
                                    <th>{{ translate("Status") }}</th>
                                    <th>{{ translate("Actions") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        question, index
                                    ) in paginatedQuestions"
                                    :key="question.id"
                                >
                                    <td>{{ question.subject }}</td>
                                    <td>
                                        {{
                                            question.answer
                                                ?.answer_short_form ||
                                            translate("No answer yet")
                                        }}
                                    </td>
                                    <td>
                                        <span
                                            class="ms-auto badge"
                                            :class="
                                                getStatusClass(question.status)
                                            "
                                        >
                                            {{ getStatusText(question.status) }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <!-- Details Icon -->
                                        <i
                                            class="bi bi-eye text-info fs-5 me-3 cursor-pointer"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailsModal"
                                            @click="openDetailsModal(question)"
                                            :title="translate('See Details')"
                                            style="cursor: pointer"
                                        ></i>

                                        <!-- Reply Icon -->
                                        <i
                                            class="bi bi-pencil-square text-success fs-5 cursor-pointer"
                                            data-bs-toggle="modal"
                                            data-bs-target="#replyModal"
                                            @click="
                                                openReplyModal(
                                                    question,
                                                    question.answer
                                                )
                                            "
                                            :title="translate('Reply')"
                                            style="cursor: pointer"
                                        ></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li
                                class="page-item"
                                :class="{ disabled: currentPage === 1 }"
                            >
                                <button
                                    class="page-link"
                                    @click="currentPage--"
                                >
                                    {{ translate("Previous") }}
                                </button>
                            </li>
                            <li
                                class="page-item"
                                :class="{
                                    disabled: currentPage === totalPages,
                                }"
                            >
                                <button
                                    class="page-link"
                                    @click="currentPage++"
                                >
                                    {{ translate("Next") }}
                                </button>
                            </li>
                        </ul>
                    </nav>
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
                                {{
                                    translate(
                                        replyForm.id
                                            ? "Edit Answer"
                                            : "Reply to Question"
                                    )
                                }}
                            </h5>
                            <button
                                ref="closeReplyModal"
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
                                        <label
                                            for="answer_short_form"
                                            class="form-label"
                                        >
                                            {{ translate("Short Answer") }}
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="answer_short_form"
                                            v-model="
                                                replyForm.answer_short_form
                                            "
                                            :class="{
                                                'invalid-bg':
                                                    replyErrors.answer_short_form,
                                            }"
                                        />
                                        <div
                                            v-if="replyErrors.answer_short_form"
                                            class="invalid-feedback"
                                        >
                                            {{
                                                replyErrors.answer_short_form[0]
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label
                                            for="answer_full_form"
                                            class="form-label"
                                        >
                                            {{ translate("Full Answer") }}
                                        </label>
                                        <textarea
                                            class="form-control"
                                            id="answer_full_form"
                                            v-model="replyForm.answer_full_form"
                                            rows="4"
                                            :class="{
                                                'invalid-bg':
                                                    replyErrors.answer_full_form,
                                            }"
                                        ></textarea>
                                        <div
                                            v-if="replyErrors.answer_full_form"
                                            class="invalid-feedback"
                                        >
                                            {{
                                                replyErrors.answer_full_form[0]
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label
                                            for="approved_by_mufti"
                                            class="form-label"
                                        >
                                            {{
                                                translate(
                                                    "Approved By Mufti (Optional)"
                                                )
                                            }}
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="approved_by_mufti"
                                            v-model="
                                                replyForm.approved_by_mufti
                                            "
                                        />
                                    </div>

                                    <div class="mt-3">
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            v-if="replyStatus === 1"
                                            @click="submitReply"
                                        >
                                            {{
                                                translate(
                                                    replyForm.id
                                                        ? "Update Reply"
                                                        : "Submit Reply"
                                                )
                                            }}
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

            <!-- Details Modal -->
            <div
                class="modal fade"
                id="detailsModal"
                tabindex="-1"
                aria-labelledby="detailsModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary">
                                {{ translate("Question Details") }}
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
                            <p>
                                <strong>{{ translate("Subject") }}:</strong>
                                {{ selectedQuestion?.subject }}
                            </p>
                            <p>
                                <strong>{{ translate("Description") }}:</strong>
                                {{ selectedQuestion?.description }}
                            </p>
                            <p>
                                <strong>{{ translate("Email") }}:</strong>
                                {{ selectedQuestion?.email }}
                            </p>
                            <p>
                                <strong>{{ translate("Date") }}:</strong>
                                {{ selectedQuestion?.date }}
                            </p>
                            <hr />
                            <div v-if="selectedQuestion?.answer">
                                <p>
                                    <strong
                                        >{{
                                            translate("Short Answer")
                                        }}:</strong
                                    >
                                    {{
                                        selectedQuestion?.answer
                                            ?.answer_short_form
                                    }}
                                </p>
                                <p>
                                    <strong
                                        >{{ translate("Full Answer") }}:</strong
                                    >
                                    {{
                                        selectedQuestion?.answer
                                            ?.answer_full_form
                                    }}
                                </p>
                                <p
                                    v-if="
                                        selectedQuestion?.answer
                                            ?.approved_by_mufti
                                    "
                                >
                                    <strong
                                        >{{ translate("Approved By") }}:</strong
                                    >
                                    {{
                                        selectedQuestion?.answer
                                            ?.approved_by_mufti
                                    }}
                                </p>
                            </div>
                            <div v-else>
                                <p>
                                    {{ translate("No answer provided yet.") }}
                                </p>
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
            selectedQuestion: null, // Store selected question for details modal
            replyForm: {
                id: "", // Holds the answer ID for editing
                question_id: "",
                answer_short_form: "",
                answer_full_form: "",
                approved_by_mufti: "",
            },
            replyErrors: [],
            replyStatus: 1, // 1 = ready, 0 = saving

            searchQuery: "",
            currentPage: 1,
            perPage: 20,
        };
    },

    created() {
        this.fetchQuestions();
    },
    computed: {
        filteredQuestions() {
            const query = this.searchQuery.toLowerCase();

            return this.questions.filter((q) => {
                const status = this.getStatusText(q.status).toLowerCase();
                const subject = q.subject?.toLowerCase() || "";
                const description = q.description?.toLowerCase() || "";
                const shortAns =
                    q.answer?.answer_short_form?.toLowerCase() || "";
                const fullAns = q.answer?.answer_full_form?.toLowerCase() || "";
                const approved =
                    q.answer?.approved_by_mufti?.toLowerCase() || "";

                return (
                    status.includes(query) ||
                    subject.includes(query) ||
                    description.includes(query) ||
                    shortAns.includes(query) ||
                    fullAns.includes(query) ||
                    approved.includes(query)
                );
            });
        },
        totalPages() {
            return Math.ceil(this.filteredQuestions.length / this.perPage);
        },
        paginatedQuestions() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredQuestions.slice(start, start + this.perPage);
        },
    },
    watch: {
        searchQuery() {
            this.currentPage = 1;
        },
    },

    methods: {
        fetchQuestions() {
            axios
                .get(route("api.question.fetch"))
                .then((response) => {
                    this.questions = response.data.map((q) => ({
                        ...q,
                        answer: q.answer || null, // Include answer if exists
                    }));
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        openReplyModal(question, answer) {
            // Clear all fields first
            this.replyForm = {
                id: "",
                question_id: "",
                answer_short_form: "",
                answer_full_form: "",
                approved_by_mufti: "",
            };
            this.replyErrors = [];
            this.replyForm.id = answer ? answer.id : "";
            this.replyForm.question_id = question.id;
            this.replyForm.answer_short_form = answer
                ? answer.answer_short_form
                : "";
            this.replyForm.answer_full_form = answer
                ? answer.answer_full_form
                : "";
            this.replyForm.approved_by_mufti = answer
                ? answer.approved_by_mufti
                : "";
            this.replyErrors = [];
        },
        submitReply() {
            this.replyStatus = 0;

            axios
                .post(route("api.answer.store"), this.replyForm)
                .then(() => {
                    this.replyStatus = 1;
                    toastr.success(
                        this.translate("Reply submitted successfully.")
                    );
                    this.fetchQuestions();
                    this.$refs.closeReplyModal.click();
                })
                .catch((error) => {
                    this.replyStatus = 1;
                    this.replyErrors = error.response?.data?.errors || {};
                    toastr.error(
                        error.response?.data?.message || "An error occurred."
                    );
                });
        },
        openDetailsModal(question) {
            this.selectedQuestion = question; // Store the selected question for modal display
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

<style scoped>
.bi-pencil {
    cursor: pointer;
}
</style>
