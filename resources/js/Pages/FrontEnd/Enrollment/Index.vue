<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">
                    {{ translate("Student Enrollment") }}
                </h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{
                                translate("Darul Oloom")
                            }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Student Enrollment") }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Index") }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div v-if="!students || students.length === 0">
                <button
                    class="btn btn-success mt-3"
                    data-bs-toggle="modal"
                    data-bs-target="#updateRecordModal"
                    @click="clearFields"
                >
                    <i class="bi bi-plus-lg"></i>
                    {{ translate("New Enrollment") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">
                        {{ translate("All Enrolled Students") }}
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ translate("Name") }}</th>
                                    <th scope="col">{{ translate("Father") }}</th>
                                    <th scope="col">{{ translate("DOB") }}</th>
                                    <th scope="col">{{ translate("Apply For") }}</th>
                                    <th scope="col">{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(student, index) in students" :key="student.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ student.name }}</td>
                                    <td>{{ student.father }}</td>
                                    <td>{{ student.dob }}</td>
                                    <td>{{ student.apply_for }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-sm fs-6"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateRecordModal"
                                                @click="showEntry(student)"
                                            >
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

            <!-- Modal for Creating/Updating Student Enrollment -->
            <div
                class="modal fade"
                id="updateRecordModal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                
            </div>
        </section>
    </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/Master.vue";
import Multiselect from "@vueform/multiselect";
export default {
    layout: Master,
    components: {
        Multiselect
    },
    data() {
        return {
            students: [],
            filterOptions: ["Hifz", "Tafseer", "Qirat", "Dars-e-Nizami"],
            form: {
                id: "",
                apply_for: [],
                name: "",
                father: "",
                dob: "",
                permanent_address: "",
                current_address: "",
                primary_education: "",
                additional_ability: "",
            },
            formErrors: [],
            formStatus: 1,
        };
    },
    created() {
        this.fetchStudents();
    },
    methods: {
        fetchStudents() {
            axios
                .get(route("api.student.fetch"))
                .then((response) => {
                    this.students = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        showEntry(student) {
            this.form = { ...student };
        },
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.student.store"), this.form)
                .then(() => {
                    this.$refs.closeModal.click();
                    this.formStatus = 1;
                    toastr.success(translate("Student enrolled successfully."));
                    this.fetchStudents();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    this.formErrors = error.response?.data?.errors || {};
                });
        },
        clearFields() {
            this.form = {
                id: "",
                apply_for: [],
                name: "",
                father: "",
                dob: "",
                permanent_address: "",
                current_address: "",
                primary_education: "",
                additional_ability: "",
            };
            this.formErrors = [];
        },
    },
};
</script>
