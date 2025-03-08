<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">Persons</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Alsmi</a>
                        </li>
                        <li class="breadcrumb-item">Persons</li>
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
                    <i class="bi bi-plus-lg"></i> New Person
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">All Persons</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(person, index) in persons"
                                    :key="person.id"
                                >
                                    <th scope="row">{{ index + 1 }}</th>
                                    
                                    <td>
                                        <Link
                                            class="c-text-theme"
                                            :href="
                                                route(
                                                    'person.details',
                                                    person.id
                                                )
                                            "
                                        >
                                        {{ person.name }}
                                        </Link>
                                        </td>
                                    <td>{{ person.contact }}</td>
                                    <td>
                                        <button
                                            class="btn btn-sm fs-6"
                                            title="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateRecordModal"
                                            @click="showEntry(person)"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- <button
                                            class="btn btn-sm btn-danger fs-6"
                                            title="Delete"
                                            @click="deleteThis(person.id)"
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
                                {{ form.id ? "Edit Person" : "New Person" }}
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
                                <label class="form-label">Person Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.name"
                                    :class="{ 'invalid-bg': formErrors.name }"
                                />
                                <div
                                    v-if="formErrors.name"
                                    class="invalid-feedback"
                                >
                                    {{ formErrors.name[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contact</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.contact"
                                    :class="{
                                        'invalid-bg': formErrors.contact,
                                    }"
                                />
                                <div
                                    v-if="formErrors.contact"
                                    class="invalid-feedback"
                                >
                                    {{ formErrors.contact[0] }}
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
            persons: [],
            form: { id: "", name: "", contact: "" },
            formErrors: [],
            formStatus: 1, // 1 = ready, 0 = saving
        };
    },
    created() {
        this.fetchPersons();
    },
    methods: {
        fetchPersons() {
            axios
                .get(route("api.persons.fetch"))
                .then((res) => (this.persons = res.data))
                .catch((err) => console.error(err));
        },
        showEntry(person) {
            this.clearFields();
            this.form = { ...person };
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.person.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    this.fetchPersons();
                    this.form = { id: "", name: "", contact: "" };
                    this.$refs.closeModal.click();
                    toastr.success("Person saved successfully!");
                })
                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response.data.errors || {};
                    toastr.error(error.response.data.message);
                });
        },
        deleteThis(id) {
            axios
                .delete(route("api.persons.delete", id))
                .then(() => {
                    this.fetchPersons();
                    toastr.success("Person deleted successfully!");
                })
                .catch((err) => console.error(err));
        },
        clearFields() {
            this.form = { id: "", name: "", contact: "" };
            this.formErrors = [];
        },
    },
};
</script>
