<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Teacher Management") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Darul Oloom") }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ translate("Teachers") }}</li>
                        <li class="breadcrumb-item active">{{ translate("Index") }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#updateRecordModal"
                    @click="clearFields">
                    <i class="bi bi-plus-lg"></i> {{ translate("New Teacher") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">{{ translate("All Teachers") }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Name") }}</th>
                                    <th>{{ translate("Designation") }}</th>
                                    <th>{{ translate("Monthly Salary") }}</th>
                                    <th>{{ translate("Contact") }}</th>
                                    <th>{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(teacher, index) in teachersData" :key="teacher.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>
                                        <Link :href="route('teachers.show', teacher.id)"
                                            class="text-primary text-decoration-underline name-link"
                                            title="View details">
                                        {{ teacher.name }}
                                        </Link>
                                    </td>
                                    <td>{{ teacher.designation }}</td>
                                    <td>{{ teacher.monthly_salary }}</td>
                                    <td>{{ teacher.contact }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm fs-6" title="Edit" data-bs-toggle="modal"
                                                data-bs-target="#updateRecordModal" @click="showEntry(teacher.id)">
                                                <i class="bi bi-pencil"></i>
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
                                {{ form.id ? form.name : translate("Add New Teacher") }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Name") }}</label>
                                        <input type="text" v-model="form.name" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.name }" />
                                        <div v-if="formErrors.name" class="invalid-feedback">
                                            {{ formErrors.name[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Designation") }}</label>
                                        <input type="text" v-model="form.designation" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.designation }" />
                                        <div v-if="formErrors.designation" class="invalid-feedback">
                                            {{ formErrors.designation[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Monthly Salary") }}</label>
                                        <input type="number" v-model="form.monthly_salary" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.monthly_salary }" />
                                        <div v-if="formErrors.monthly_salary" class="invalid-feedback">
                                            {{ formErrors.monthly_salary[0] }}
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label class="form-label">{{ translate("Contact") }}</label>
                                        <input type="text" v-model="form.contact" class="form-control"
                                            :class="{ 'invalid-bg': formErrors.contact }" />
                                        <div v-if="formErrors.contact" class="invalid-feedback">
                                            {{ formErrors.contact[0] }}
                                        </div>
                                    </div>

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
            teachersData: [],
            form: {
                id: "",
                name: "",
                designation: "",
                monthly_salary: "",
                contact: "",
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
                .get(route("api.teachers.fetch"))
                .then((res) => {

                    this.teachersData = res.data;

                })
                .catch((err) => console.error(err));
        },
        showEntry(id) {
            axios.get(route("api.teachers.show", id))
                .then((res) => {
                   
                    this.form = { ...res.data };
                })
                .catch((err) => toastr.error(err));
        },
submit() {
    this.formStatus = 0;
    axios
        .post(route("api.teachers.store"), this.form) // 👈 same route works for add/update
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
        clearFields() {
            this.form = {
                id: "",
                name: "",
                designation: "",
                contact: "",
                process: this.process,
            };
            this.formErrors = [];
        },
    },
};
</script>
