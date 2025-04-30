<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Bayanaat") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Home") }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Bayanaat") }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Index") }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <button
                    class="btn btn-success mt-3"
                    data-bs-toggle="modal"
                    data-bs-target="#updateRecordModal"
                    @click="clearFields"
                >
                    <i class="bi bi-plus-lg"></i> {{ translate("New Bayan") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5
                        class="card-title theme-text-color"
                        :class="{
                            'rtl-text':
                                $page.props.default_language === 'PK' ||
                                $page.props.default_language === 'SA',
                        }"
                    >
                        {{ translate("All Bayanaat") }}
                    </h5>

                    <!-- Search Input -->
                    <div class="mb-3" :class="{
                            'rtl-text':
                                $page.props.default_language === 'PK' ||
                                $page.props.default_language === 'SA',
                        }">
                        <input
                            type="text"
                            v-model="searchQuery"
                            class="form-control"
                            :placeholder="
                                translate('Search by title or author')
                            "
                        />
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Title") }}</th>
                                    <th>{{ translate("Author") }}</th>
                                    <th>{{ translate("Islamic Date") }}</th>
                                    <th>{{ translate("English Date") }}</th>
                                    <th>{{ translate("Contents") }}</th>
                                    <th>{{ translate("Actions") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(bayan, index) in paginatedBayanaat"
                                    :key="bayan.id"
                                >
                                    <td>
                                        {{
                                            (currentPage - 1) * pageSize +
                                            index +
                                            1
                                        }}
                                    </td>
                                    <td>{{ bayan.title }}</td>
                                    <td>{{ bayan.author }}</td>
                                    <td>{{ bayan.islamic_date }}</td>
                                    <td>{{ bayan.english_date }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bayanDetailsModal"
                                            @click="bayanDetails(bayan.content)"
                                        >
                                            <i
                                                class="bi bi-eye-fill text-primary"
                                            ></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateRecordModal"
                                            @click="
                                                clearFields();
                                                showEntry(bayan);
                                            "
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <DeleteModal
                                            :deleteId="bayan.id"
                                            @deleteThis="deleteThis"
                                        ></DeleteModal>
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
                                    @click="changePage(currentPage - 1)"
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
                                    @click="changePage(currentPage + 1)"
                                >
                                    {{ translate("Next") }}
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Bayan Details modal -->
            <div
                class="modal fade"
                id="bayanDetailsModal"
                :class="{
                    'rtl-text':
                        $page.props.default_language === 'PK' ||
                        $page.props.default_language === 'SA',
                }"
            >
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ translate("Bayan Details") }}</h5>
                            <button
                                class="btn-close"
                                ref="closeModal"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div v-html="bayanContents"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bayan Details modal -->

            <!-- Modal -->
            <div
                class="modal fade"
                id="updateRecordModal"
                :class="{
                    'rtl-text':
                        $page.props.default_language === 'PK' ||
                        $page.props.default_language === 'SA',
                }"
            >
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-if="form.id">
                                {{ translate("Edit Bayan") }}
                            </h5>
                            <h5 v-else>{{ translate("New Bayan") }}</h5>
                            <button
                                class="btn-close"
                                ref="closeModal"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="title" class="form-label">{{
                                            translate("Title")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            v-model="form.title"
                                            :class="{
                                                'invalid-bg': formErrors.title,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.title"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.title[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="author"
                                            class="form-label"
                                            >{{ translate("Author") }}</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="author"
                                            v-model="form.author"
                                            :class="{
                                                'invalid-bg': formErrors.author,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.author"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.author[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="english_date"
                                            class="form-label"
                                            >{{
                                                translate("English Date")
                                            }}</label
                                        >
                                        <Datepicker
                                            autoApply
                                            :enable-time-picker="false"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.english_date,
                                            }"
                                            v-model="form.english_date"
                                            @update:modelValue="convertToHijri"
                                        />
                                        <div
                                            v-if="formErrors.english_date"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.english_date[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="islamic_date"
                                            class="form-label"
                                            >{{
                                                translate("Islamic Date")
                                            }}</label
                                        >
                                        <Datepicker
                                            v-model="form.islamic_date"
                                            :enable-time-picker="false"
                                            autoApply
                                            :disabled="true"
                                            :input-props="{ readonly: true }"
                                        />
                                        <div
                                            v-if="formErrors.islamic_date"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.islamic_date[0] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="content" class="form-label">{{
                                        translate("Content")
                                    }}</label>
                                    <QuillEditor
                                        v-model:content="form.content"
                                        contentType="html"
                                        toolbar="full"
                                        theme="snow"
                                    />
                                </div>

                                <div class="mt-3">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        v-if="formStatus === 1"
                                        @click="submit"
                                    >
                                        {{ translate("Save") }}
                                    </button>
                                    <button
                                        class="btn btn-success"
                                        type="button"
                                        disabled
                                        v-else
                                    >
                                        {{ translate("Saving") }}
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
        </section>
    </main>
</template>

<script>
import Master from "../Layout/Master.vue";
import axios from "axios";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import moment from "moment-hijri";

export default {
    layout: Master,
    components: {
        QuillEditor,
        Datepicker,
    },
    data() {
        return {
            bayanaat: [],
            form: {
                id: "",
                title: "",
                author: "",
                islamic_date: "",
                english_date: "",
                content: "",
            },
            formErrors: {},
            formStatus: 1,
            searchQuery: "",
            currentPage: 1,
            pageSize: 20,
            bayanContents: "",
        };
    },
    computed: {
        filteredBayanaat() {
            return this.bayanaat.filter((b) => {
                const query = this.searchQuery.toLowerCase();
                return (
                    b.title.toLowerCase().includes(query) ||
                    b.author.toLowerCase().includes(query)
                );
            });
        },
        paginatedBayanaat() {
            const start = (this.currentPage - 1) * this.pageSize;
            return this.filteredBayanaat.slice(start, start + this.pageSize);
        },
        totalPages() {
            return Math.ceil(this.filteredBayanaat.length / this.pageSize);
        },
    },
    watch: {
        searchQuery() {
            this.currentPage = 1;
        },
    },
    created() {
        this.fetchBayanaat();
    },
    methods: {
        bayanDetails(details) {
            this.bayanContents = "";
            this.bayanContents = details;
        },
        convertToHijri(date) {
            this.form.islamic_date = date
                ? moment(date).format("iYYYY/iM/iD")
                : "";
        },
        fetchBayanaat() {
            axios
                .get(route("api.bayanaat.fetch"))
                .then((res) => {
                    this.bayanaat = res.data;
                })
                .catch((error) => {
                    console.error(error);
                    toastr.error(this.translate("Failed to fetch bayanaat."));
                });
        },
        showEntry(bayan) {
            this.form = { ...bayan };
        },
        submit() {
            this.formStatus = 0;
            if (this.form.english_date) {
                this.form.english_date = moment(this.form.english_date).format(
                    "YYYY-MM-DD"
                );
            }
            axios
                .post(route("api.bayanaat.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    this.$refs.closeModal.click();
                    toastr.success(this.translate("Bayan saved successfully."));
                    this.fetchBayanaat();
                    this.clearFields();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    if (error.response && error.response.data) {
                        this.formErrors = error.response.data.errors || {};
                        toastr.error(
                            this.translate(
                                "Please correct the errors and try again."
                            )
                        );
                    } else {
                        toastr.error(
                            this.translate("An unexpected error occurred.")
                        );
                    }
                });
        },
        deleteThis(id) {
            axios
                .delete(route("api.bayanaat.delete", id))
                .then(() => {
                    this.fetchBayanaat();
                    toastr.success(
                        this.translate("Bayan deleted successfully.")
                    );
                })
                .catch((error) => {
                    console.error(error);
                    toastr.error(this.translate("Failed to delete bayan."));
                });
        },
         
        clearFields() {
            this.form = {
                id: "",
                title: "",
                author: "",
                islamic_date: "",
                english_date: "",
                content: [],
            };
            this.formErrors = {};
        },
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
    },
};
</script>
