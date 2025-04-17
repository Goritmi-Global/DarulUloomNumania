<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Books") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Home") }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Books") }}
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
                    <i class="bi bi-plus-lg"></i> {{ translate("New Book") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color" :class="{
                'rtl-text':
                    $page.props.default_language === 'PK' ||
                    $page.props.default_language === 'SA',
            }">
                        {{ translate("All Books") }}
                    </h5>
                    <div class="mb-3" :class="{
                            'rtl-text':
                                $page.props.default_language === 'PK' ||
                                $page.props.default_language === 'SA',
                        }">
                        <input
                            type="text"
                            class="form-control"
                            v-model="searchQuery"
                            :placeholder="
                                translate('Search by title or download link')
                            "
                        />
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Title") }}</th>

                                    <th>{{ translate("Image") }}</th>
                                    <th>{{ translate("Download Link") }}</th>
                                    <th>{{ translate("Content") }}</th>
                                    <th>{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(book, index) in filteredBooks"
                                    :key="book.id"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ book.title }}</td>
                                    <td>
                                        <ImageZooming
                                            :file="
                                                book.image ??
                                                '/images/default.jpg'
                                            "
                                            :width="100"
                                        />
                                    </td>

                                    <td>{{ book.download_link }}</td>
                                    <td v-html="book.description"></td>
                                    <td>
                                        <button
                                            class="btn btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateRecordModal"
                                            @click="showEntry(book)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm text-danger"
                                            @click="deleteBook(book.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            </div>

            <!-- Modal -->
            <div class="modal fade" id="updateRecordModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-if="form.id">{{ translate("Edit Book") }}</h5>
                            <h5 v-else>{{ translate("New Book") }}</h5>
                            <button
                                class="btn-close"
                                data-bs-dismiss="modal"
                                ref="closeModal"
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
                                            for="download_link"
                                            class="form-label"
                                            >{{
                                                translate("Download Link")
                                            }}</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="download_link"
                                            v-model="form.download_link"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.download_link,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.download_link"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.download_link[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="download_link"
                                            class="form-label"
                                            >{{ translate("Image") }}</label
                                        >
                                        <br />
                                        <CropperOffCanvas
                                            @croppedImg="croppedImgPassToForm"
                                            accept=".jpg,.jpeg,.png"
                                        />
                                        <br />

                                        <img
                                            v-if="form.image"
                                            :src="
                                                form.image ??
                                                '/images/default.jpg'
                                            "
                                            :width="100"
                                        />

                                        <img
                                            v-else-if="existing_image"
                                            :src="
                                                existing_image ??
                                                '/images/default.jpg'
                                            "
                                            :width="100"
                                        />
                                        <img
                                            v-else
                                            :src="'/images/default.jpg'"
                                            :width="100"
                                        />

                                        <div
                                            v-if="formErrors.image"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.image[0] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="content" class="form-label">{{
                                        translate("Content")
                                    }}</label>
                                    <br />
                                    <QuillEditor
                                        v-model:content="form.description"
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
                                        {{ translate("Saving")
                                        }}<span
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
import axios from "axios";
import Master from "../Layout/Master.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

export default {
    layout: Master,
    components: { QuillEditor },
    data() {
        return {
            books: [],
            form: {
                id: "",
                title: "",
                download_link: "",

                image: "",
                description: "",
            },
            formErrors: {},
            formStatus: 1,
            existing_image: "",
            searchQuery: "",
            currentPage: 1,
            pageSize: 20,
        };
    },

    created() {
        this.fetchBooks();
    },
    computed: {
        filteredBooks() {
            if (!this.searchQuery) return this.books;
            const q = this.searchQuery.toLowerCase();
            return this.books.filter((book) => {
                return (
                    (book.title && book.title.toLowerCase().includes(q)) ||
                    (book.download_link &&
                        book.download_link.toLowerCase().includes(q))
                );
            });
        },
        paginatedBooks() {
            const start = (this.currentPage - 1) * this.pageSize;
            return this.filteredBooks.slice(start, start + this.pageSize);
        },
        totalPages() {
            return Math.ceil(this.filteredBooks.length / this.pageSize);
        },
    },

    watch: {
        searchQuery() {
            this.currentPage = 1;
        },
    },

    methods: {
        fetchBooks() {
            axios
                .get(route("api.books.fetch"))
                .then((res) => {
                    this.books = res.data;
                })
                .catch((err) => {
                    console.error("Error fetching books:", err);
                });
        },
        showEntry(book) {
            this.form = { ...book };

            // If the book has an image, store it in existing_image
            this.existing_image = book.image || null;
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.books.store"), this.form)
                .then(() => {
                    this.$refs.closeModal.click();
                    this.formStatus = 1;
                    toastr.success(this.translate("Book saved successfully."));
                    this.fetchBooks();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    if (error.response && error.response.data) {
                        this.formErrors = error.response.data.errors || {};
                        toastr.error(error.response.data.message);
                    } else {
                        toastr.error("An unexpected error occurred.");
                    }
                });
        },
        deleteBook(id) {
            if (confirm("Are you sure you want to delete this book?")) {
                axios
                    .delete(route("api.books.delete", id))
                    .then(() => this.fetchBooks());
            }
        },
        clearFields() {
            this.form = {
                id: "",
                title: "",
                author: "",
                islamic_date: "",
                english_date: "",
                content: "",
            };
        },
        croppedImgPassToForm(img) {
            this.form.image = img;
        },
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
    },
};
</script>
