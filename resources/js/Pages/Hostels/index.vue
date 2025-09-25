<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Hostel Management") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Darul Oloom") }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ translate("Hostels") }}</li>
                        <li class="breadcrumb-item active">{{ translate("Index") }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#updateRecordModal"
                    @click="clearFields">
                    <i class="bi bi-plus-lg"></i> {{ translate("New Hostel") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">{{ translate("All Hostels") }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Hostel Name") }}</th>
                                    <th>{{ translate("Contact Number") }}</th>
                                    <th>{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(hostel, index) in hostelsData" :key="hostel.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ hostel.hostel_name }}</td>
                                    <td>{{ hostel.contact_number }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm fs-6" title="Edit" data-bs-toggle="modal"
                                                data-bs-target="#updateRecordModal" @click="showEntry(hostel.id)">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm text-danger fs-6" title="Delete"
                                                @click="deleteEntry(hostel.id)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
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
                            <h5 class="modal-title text-primary">
                                {{ form.id ? form.hostel_name : translate("Add New Hostel") }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <!-- Hostel Name -->
                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Hostel Name") }}</label>
                                        <input type="text" v-model="form.hostel_name" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.hostel_name }" />
                                        <div v-if="formErrors.hostel_name" class="invalid-feedback">
                                            {{ formErrors.hostel_name[0] }}
                                        </div>
                                    </div>
                                    <!-- Contact Number -->
                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Contact Number") }}</label>
                                        <input type="text" v-model="form.contact_number" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.contact_number }" />
                                        <div v-if="formErrors.contact_number" class="invalid-feedback">
                                            {{ formErrors.contact_number[0] }}
                                        </div>
                                    </div>
                                    <!-- Save Button -->
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-success" @click="submit"
                                            v-if="formStatus === 1">
                                            {{ translate("Save") }}
                                        </button>
                                        <button class="btn btn-success" type="button" disabled v-else>
                                            {{ translate("Saving") }}
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button hidden ref="closeModal" data-bs-toggle="modal" data-bs-target="#customermodal"></button>
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
            hostelsData: [],
            form: {
                id: "",
                hostel_name: "",
                contact_number: "",
            },
            formErrors: [],
            formStatus: 1,
        };
    },
    created() {
        this.fetchRecords();
    },
    methods: {
        fetchRecords() {
            axios
                .get(route("api.hostels.fetch"))
                .then((res) => {
                    this.hostelsData = res.data;
                })
                .catch((err) => console.error(err));
        },
        showEntry(id) {
            axios.get(route("api.hostels.show", id))
                .then((res) => {
                    this.form = { ...res.data };
                })
                .catch((err) => toastr.error(err));
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.hostels.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    toastr.success(this.translate("Saved successfully."));
                    this.fetchRecords();
                    this.$refs.closeModal.click();
                })
                .catch((err) => {
                    this.formStatus = 1;
                    this.formErrors = err.response.data.errors || {};
                    toastr.error(err.response.data.message);
                });
        },
        deleteEntry(id) {
            if (confirm(this.translate("Are you sure you want to delete this hostel?"))) {
                axios.delete(route("api.hostels.destroy", id))
                    .then(() => {
                        toastr.success(this.translate("Deleted successfully."));
                        this.fetchRecords();
                    })
                    .catch((err) => toastr.error(err.response.data.message));
            }
        },
        clearFields() {
            this.form = {
                id: "",
                hostel_name: "",
                contact_number: "",
            };
            this.formErrors = [];
        },
    },
};
</script>
