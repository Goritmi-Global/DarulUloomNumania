<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">
                    {{ translate("Islamic Names") }}
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Home") }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Islamic Names") }}
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
                    <i class="bi bi-plus-lg"></i
                    >{{ translate("New Islamic Name") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">
                        {{ translate("All Islamic Names") }}
                    </h5>

                    <!-- Search Input -->
                    <div class="mb-3">
                        <input
                            type="text"
                            v-model="searchQuery"
                            class="form-control"
                            :placeholder="
                                translate('Search by Name or Meaning')
                            "
                        />
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Name") }}</th>
                                    <th>{{ translate("Meaning") }}</th>
                                    <th>{{ translate("Roman") }}</th>
                                    <th>{{ translate("Inflection") }}</th>
                                    <th>{{ translate("Type") }}</th>
                                    <th>{{ translate("Reference") }}</th>
                                    <th>{{ translate("Actions") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(name, index) in paginatedNames"
                                    :key="name.id"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ name.name }}</td>
                                    <td>{{ name.meaning }}</td>
                                    <td>{{ name.roman }}</td>
                                    <td>{{ name.inflection }}</td>
                                    <td>{{ name.type }}</td>
                                    <td>{{ name.reference }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-sm fs-6"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateRecordModal"
                                                @click="showEntry(name)"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm text-danger"
                                                title="Delete"
                                                @click="deleteName(name.id)"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
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

            <!-- Modal for Creating/Updating Islamic Name -->
            <div
                class="modal fade"
                id="updateRecordModal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" v-if="form.id">
                                {{ translate("Edit Islamic Name") }}
                            </h5>
                            <h5 class="modal-title text-primary" v-else>
                                {{ translate("New Islamic Name Entry") }}
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
                                        <label class="form-label">{{
                                            translate("Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.name"
                                            :class="{
                                                'invalid-bg': formErrors.name,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.name"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.name[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{
                                            translate("Meaning")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.meaning"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.meaning,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.meaning"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.meaning[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{
                                            translate("Roman")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.roman"
                                            :class="{
                                                'invalid-bg': formErrors.roman,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.roman"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.roman[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{
                                            translate("Inflection")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.inflection"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.inflection,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.roman"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.roman[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{
                                            translate("Type")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.type"
                                            :class="{
                                                'invalid-bg': formErrors.type,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.type"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.type[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{
                                            translate("Reference")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            v-model="form.reference"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.reference,
                                            }"
                                        ></textarea>
                                        <div
                                            v-if="formErrors.reference"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.reference[0] }}
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
            <!-- Modal code remains the same -->
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
            islamicNames: [],
            form: {
                id: "",
                name: "",
                meaning: "",
                roman: "",
                inflection: "",
                type: "",
                reference: "",
            },
            formErrors: [],
            formStatus: 1,
            currentPage: 1,
            pageSize: 20,
            searchQuery: "", // For search filter
        };
    },
    created() {
        this.fetchIslamicNames();
    },
    computed: {
        // Filtered and paginated names based on search query
        filteredNames() {
            return this.islamicNames.filter((name) => {
                return (
                    name.name
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase()) ||
                    name.meaning
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase())
                );
            });
        },
        // Paginate filtered names
        paginatedNames() {
            const start = (this.currentPage - 1) * this.pageSize;
            return this.filteredNames.slice(start, start + this.pageSize);
        },
        // Total pages based on filtered names
        totalPages() {
            return Math.ceil(this.filteredNames.length / this.pageSize);
        },
    },
    methods: {
        fetchIslamicNames() {
            axios
                .get(route("api.islamic-names.fetch"))
                .then((response) => {
                    this.islamicNames = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        showEntry(name) {
            this.form = { ...name };
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.islamic-names.store"), this.form)
                .then(() => {
                    this.$refs.closeModal.click();
                    this.formStatus = 1;
                    toastr.success(
                        this.translate("Islamic Name saved successfully.")
                    );
                    this.fetchIslamicNames(); // Fetch updated data
                })
                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response?.data?.errors || {};
                    toastr.error(
                        error.response?.data?.message || "An error occurred."
                    );
                });
        },
        deleteName(id) {
            axios.delete(route("api.islamic-names.delete", id)).then(() => {
                this.fetchIslamicNames();
                toastr.success(
                    this.translate("Islamic Name deleted successfully.")
                );
            });
        },
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        clearFields() {
            this.form = {
                id: "",
                name: "",
                meaning: "",
                roman: "",
                inflection: "",
                type: "",
                reference: "",
            };
            this.formErrors = [];
        },
    },
};
</script>
