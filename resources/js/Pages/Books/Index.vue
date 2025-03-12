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
                    <h5 class="card-title theme-text-color">
                        {{ translate("All Books") }}
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Title") }}</th>
                                    <th>{{ translate("Description") }}</th>
                                    <th>{{ translate("Image") }}</th>
                                    <th>{{ translate("Download") }}</th>
                                    <th>{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(book, index) in books"
                                    :key="book.id"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ book.title }}</td>
                                    <td>{{ book.description }}</td>
                                    <td>
                                        <img
                                            :src="book.image"
                                            class="img-thumbnail"
                                            width="50"
                                            v-if="book.image"
                                        />
                                    </td>
                                    <td>
                                        <a
                                            :href="book.download_link"
                                            target="_blank"
                                            class="btn btn-primary btn-sm"
                                            v-if="book.download_link"
                                        >
                                            {{ translate("Download") }}
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-sm"
                                            @click="showEntry(book.id)"
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
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="updateRecordModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-if="form.id">{{ translate("Edit Book") }}</h5>
                            <h5 v-else>{{ translate("New Book") }}</h5>
                            <button
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <input
                                v-model="form.title"
                                placeholder="Title"
                                class="form-control"
                            />
                            <textarea
                                v-model="form.description"
                                placeholder="Description"
                                class="form-control"
                            ></textarea>
                            <input
                                v-model="form.image"
                                placeholder="Image URL"
                                class="form-control"
                            />
                            <input
                                v-model="form.download_link"
                                placeholder="Download Link"
                                class="form-control"
                            />
                            <button
                                class="btn btn-success mt-2"
                                @click="submit"
                            >
                                {{ translate("Save") }}
                            </button>
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
            books: [],
            form: {
                id: "",
                title: "",
                description: "",
                image: "",
                download_link: "",
            },
        };
    },
    created() {
        this.fetchBooks();
    },
    methods: {
        fetchBooks() {
            axios
                .get(route("api.books.fetch"))
                .then((res) => (this.books = res.data));
        },
        showEntry(id) {
            axios
                .get(route("api.books.show", id))
                .then((res) => (this.form = res.data));
        },
        submit() {
            axios
                .post(route("api.books.store"), this.form)
                .then(() => this.fetchBooks());
        },
        deleteBook(id) {
            axios
                .delete(route("api.books.delete", id))
                .then(() => this.fetchBooks());
        },
        clearFields() {
            this.form = {
                id: "",
                title: "",
                description: "",
                image: "",
                download_link: "",
            };
        },
    },
};
</script>
