<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">Business Types</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Alsmi</a>
                        </li>
                        <li class="breadcrumb-item">Business Types</li>
                        <li class="breadcrumb-item active">Index</li>
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
                    <i class="bi bi-plus-lg"></i> New Business Type
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">
                        All Business Types
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(type, index) in businessTypes"
                                    :key="type.id"
                                >
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ type.name }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm fs-6"
                                            title="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateRecordModal"
                                            @click="showEntry(type)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- <button
                                            class="btn btn-sm btn-danger fs-6"
                                            title="Delete"
                                            @click="deleteThis(type.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="updateRecordModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{
                                    form.id
                                        ? "Edit Business Type"
                                        : "New Business Type"
                                }}
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                ref="closeModal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label"
                                    >Business Type Name</label
                                >
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
                            <button
                                class="btn btn-success"
                                @click="submit"
                                :disabled="formStatus === 0"
                            >
                                <span v-if="formStatus === 1">Save</span>
                                <span v-else>
                                    Saving
                                    <span
                                        class="spinner-border spinner-border-sm"
                                    ></span>
                                </span>
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
            businessTypes: [],
            form: { id: "", name: "" },
            formErrors: [],
            formStatus: 1,
        };
    },
    created() {
        this.fetchBusinessTypes();
    },
    methods: {
        fetchBusinessTypes() {
            axios
                .get(route("api.business.types.fetch"))
                .then((res) => (this.businessTypes = res.data))
                .catch((err) => console.error(err));
        },
        showEntry(type) {
            this.clearFields();
            this.form = { ...type };
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.business.types.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    this.fetchBusinessTypes();
                    this.form = { id: "", name: "" };
                    this.$refs.closeModal.click();
                    toastr.success("Business Type saved successfully!");
                })
                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response.data.errors || {};

                    toastr.error(error.response.data.message);
                });
        },
        deleteThis(id) {
            axios
                .delete(route("api.business.delete", id))
                .then(() => {
                    this.fetchBusinessTypes();
                    toastr.success("Business Type deleted successfully!");
                })
                .catch((err) => console.error(err));
        },
        clearFields() {
            this.form = { id: "", name: "" };
            this.formErrors = [];
        },
    },
};
</script>
