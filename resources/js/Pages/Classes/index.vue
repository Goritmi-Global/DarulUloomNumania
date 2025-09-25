<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Class Management") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Darul Oloom") }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ translate("Classes") }}</li>
                        <li class="breadcrumb-item active">{{ translate("Index") }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#updateRecordModal"
                    @click="clearFields">
                    <i class="bi bi-plus-lg"></i> {{ translate("New Class") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">{{ translate("All Classes") }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Class Name") }}</th>
                                    <th>{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(classItem, index) in classesData" :key="classItem.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>
                                        <Link :href="route('classes.show', classItem.id)"
                                            class="text-primary text-decoration-underline name-link"
                                            title="View details">
                                        {{ classItem.class_name }}
                                        </Link>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm fs-6" title="Edit" data-bs-toggle="modal"
                                                data-bs-target="#updateRecordModal" @click="showEntry(classItem.id)">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm text-danger fs-6" title="Delete"
                                                @click="deleteEntry(classItem.id)">
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
                                {{ form.id ? form.class_name : translate("Add New Class") }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <!-- Class Name -->
                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Class Name") }}</label>
                                        <input type="text" v-model="form.class_name" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.class_name }" />
                                        <div v-if="formErrors.class_name" class="invalid-feedback">
                                            {{ formErrors.class_name[0] }}
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
import { Link } from '@inertiajs/vue3';

export default {
    layout: Master,
    components: { Link },
    data() {
        return {
            classesData: [],
            form: {
                id: "",
                class_name: "",
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
                .get(route("api.classes.fetch"))
                .then((res) => {
                    this.classesData = res.data;
                })
                .catch((err) => console.error(err));
        },
        showEntry(id) {
            axios.get(route("api.classes.show", id))
                .then((res) => {
                    this.form = { ...res.data };
                })
                .catch((err) => toastr.error(err));
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.classes.store"), this.form)
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
            if (confirm(this.translate("Are you sure you want to delete this class?"))) {
                axios.delete(route("api.classes.destroy", id))
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
                class_name: "",
            };
            this.formErrors = [];
        },
    },
};
</script>