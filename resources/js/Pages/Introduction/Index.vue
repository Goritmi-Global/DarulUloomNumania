<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">
                    {{ translate("Introduction") }}
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{
                                translate("Darul Oloom")
                            }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Introduction") }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Index") }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div>
                <!-- <div> -->
                <button
                    class="btn btn-success mt-3"
                    data-bs-toggle="modal"
                    data-bs-target="#updateRecordModal"
                    @click="clearFields"
                >
                    <i class="bi bi-plus-lg"></i>
                    {{ translate("New Introduction") }}
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
                        {{ translate("All Introductions") }}
                    </h5>
                    <!-- Search Input -->
                    <div
                        class="mb-3"
                        :class="{
                            'rtl-text':
                                $page.props.default_language === 'PK' ||
                                $page.props.default_language === 'SA',
                        }"
                    >
                        <input
                            type="text"
                            v-model="searchQuery"
                            class="form-control"
                            :placeholder="
                                translate('Search by title or author')
                            "
                        />
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {{ translate("Title") }}
                                    </th>
                                    <th scope="col">
                                        {{ translate("Description") }}
                                    </th>
                                    <th scope="col">
                                        {{ translate("Action") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        intro, index
                                    ) in paginatedIntroductions"
                                    :key="intro.id"
                                >
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ intro.title }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#introDetailsModal"
                                            @click="
                                                introDetails(intro.description)
                                            "
                                        >
                                            <i
                                                class="bi bi-eye-fill text-primary"
                                            ></i>
                                        </button>
                                    </td>
                                    <!-- <td>{{ intro.description }}</td> -->
                                    <td>
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-sm fs-6"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateRecordModal"
                                                @click="showEntry(intro)"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <DeleteModal
                                            :deleteId="intro.id"
                                            @deleteThis="deleteThis"
                                        ></DeleteModal>
                                             
                                        </div>
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

            <!-- Modal for Creating/Updating Introduction -->
            <div
                class="modal fade"
                id="updateRecordModal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" v-if="form.id">
                                {{ translate("Edit Introduction") }}
                            </h5>
                            <h5 class="modal-title text-primary" v-else>
                                {{ translate("New Introduction Entry") }}
                            </h5>
                            <button
                                ref="closeMainModal"
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
                                            for="description"
                                            class="form-label"
                                            >{{
                                                translate("Description")
                                            }}</label
                                        >
                                        <div class="col-12">
                                            <QuillEditor
                                                v-model:content="
                                                    form.description
                                                "
                                                contentType="html"
                                                toolbar="full"
                                                theme="snow"
                                            />
                                        </div>
                                        <div
                                            v-if="formErrors.description"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.description[0] }}
                                        </div>
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
            </div>

            <!-- Book Details modal -->
            <div
                class="modal fade"
                id="introDetailsModal"
                :class="{
                    'rtl-text':
                        $page.props.default_language === 'PK' ||
                        $page.props.default_language === 'SA',
                }"
            >
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ translate("Book Details") }}</h5>
                            <button
                                class="btn-close"
                                ref="closeModal"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div v-html="introContents"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Book Details modal -->
        </section>
    </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/Master.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
export default {
    layout: Master,
    components: {
        QuillEditor,
    },
    data() {
        return {
            introductions: [],
            form: {
                id: "",
                title: "",
                description: "",
            },
            formErrors: [],
            formStatus: 1,  
            searchQuery: "",
            currentPage: 1,
            perPage: 5,
            introContents: "",
        };
    },
    computed: {
        filteredIntroductions() {
            const q = this.searchQuery.toLowerCase();
            return this.introductions.filter((intro) => {
                return (
                    intro.title.toLowerCase().includes(q) ||
                    intro.description.toLowerCase().includes(q)
                );
            });
        },
        paginatedIntroductions() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredIntroductions.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredIntroductions.length / this.perPage);
        },
    },

    created() {
        this.fetchIntroductions();
    },
    methods: {
        introDetails(details) {
            this.introContents = "";
            this.introContents = details;
        },
        fetchIntroductions() {
            axios
                .get(route("api.introduction.fetch"))
                .then((response) => {
                   
                    this.introductions = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        showEntry(introduction) {
            this.form = { ...introduction };
        },
        submit() {
            this.formStatus = 0;

            axios
                .post(route("api.introduction.store"), this.form)
                .then(() => {
                   
                    this.formStatus = 1;
                    this.$refs.closeMainModal.click();
                    toastr.success(
                        this.translate("Introduction saved successfully.")
                    );
                    
                    this.fetchIntroductions();
                })

                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response?.data?.errors || {};
                    toastr.error(
                        error.response?.data?.message || "An error occurred."
                    );
                });
        },
        deleteThis(id) {
            axios
                .delete(route("api.introduction.delete", id))
                .then(() => {
                    this.fetchIntroductions();
                    toastr.success(
                        this.translate("Introduction deleted successfully.")
                    );
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        clearFields() {
            this.form.id = "";
            this.form.title = "";
            this.form.description = "";
            this.formErrors = [];
        },
    },
};
</script>
