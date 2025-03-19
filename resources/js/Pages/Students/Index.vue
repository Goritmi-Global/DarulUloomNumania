<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Enrolled Students") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">{{ translate("Darul Oloom") }}</a></li>
                        <li class="breadcrumb-item">{{ translate("Student Enrollment") }}</li>
                        <li class="breadcrumb-item active">{{ translate("Index") }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">{{ translate("All Enrolled Students") }}</h5>
                    <div class="table-responsive">
                        <table id="ledgerTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ translate("Name") }}</th>
                                    <th scope="col">{{ translate("Father") }}</th>
                                    <th scope="col">{{ translate("Apply For") }}</th>
                                    <th scope="col">{{ translate("Phone#") }}</th>
                                    <th scope="col">{{ translate("Applied Date") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(student, index) in students" :key="student.id">
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>
                                        <span class="fw-bold text-primary cursor-pointer" @click="showDetails(student)">
                                            {{ student.name }}
                                        </span>
                                    </td>
                                    <td>{{ student.father }}</td>
                                    <td>{{ student.apply_for }}</td>
                                    <td>{{ student.phone_number }}</td>
                                    <td>{{ formatDate(student.created_at) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Student Details Modal -->
        <div class="modal fade" id="studentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ selectedStudent.name }} - Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr><th>{{ translate("Father") }}</th><td>{{ selectedStudent.father }}</td></tr>
                                <tr><th>{{ translate("DOB") }}</th><td>{{ selectedStudent.dob }}</td></tr>
                                <tr><th>{{ translate("Phone#") }}</th><td>{{ selectedStudent.phone_number }}</td></tr>
                                <tr><th>{{ translate("Apply For") }}</th><td>{{ selectedStudent.apply_for }}</td></tr>
                                <tr><th>{{ translate("Permanent Address") }}</th><td>{{ selectedStudent.permanent_address }}</td></tr>
                                <tr><th>{{ translate("Current Address") }}</th><td>{{ selectedStudent.current_address }}</td></tr>
                                <tr><th>{{ translate("Primary Education") }}</th><td>{{ selectedStudent.primary_education }}</td></tr>
                                <tr><th>{{ translate("Additional Ability") }}</th><td>{{ selectedStudent.additional_ability }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "axios";
import moment from "moment";
import Master from "../Layout/Master.vue";

export default {
    layout: Master,
    data() {
        return {
            students: [],
            selectedStudent: {},
            dataTable: null,
        };
    },
    created() {
        this.fetchStudents();
    },
    methods: {
        fetchStudents() {
            axios.get(route("api.students.fetch"))
                .then((response) => {
                    this.students = response.data;
                    this.$nextTick(() => {
                        this.initializeDataTable();
                    });
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        initializeDataTable() {
            if (this.dataTable) {
                this.dataTable.destroy();
            }
            this.$nextTick(() => {
                this.dataTable = new DataTable("#ledgerTable", {
                    responsive: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        search: "Search:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous",
                        },
                    },
                });
            });
        },
        formatDate(date) {
            return moment(date).format("DD-MMM-YYYY hh:mm A");
        },
        showDetails(student) {
            this.selectedStudent = student;
            let modal = new bootstrap.Modal(document.getElementById("studentModal"));
            modal.show();
        },
    },
};
</script>

<style>
.cursor-pointer {
    cursor: pointer;
}
</style>