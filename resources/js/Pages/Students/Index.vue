<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Enrolled Students") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Darul Oloom") }}</a>
                        </li>
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

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ translate("Session") }}</label>
                            <Multiselect
                                v-model="selectedSessions"
                                :options="yearsOptions.map(y => String(y))"
                                :placeholder="translate('Select session year')"
                                :searchable="true"
                                :multiple="true"
                            />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ translate("Course") }}</label>
                            <Multiselect
                                v-model="selectedCourses"
                                :options="filterOptions"
                                :placeholder="translate('Select Course')"
                                :searchable="true"
                                :multiple="true"
                            />
                        </div>
                    </div>

                    <!-- Student Table -->
                    <div v-if="canShowTable" class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Name") }}</th>
                                    <th>{{ translate("Father") }}</th>
                                    <th>{{ translate("Apply For") }}</th>
                                    <th>{{ translate("Phone#") }}</th>
                                    <th>{{ translate("Applied Date") }}</th>
                                    <th>{{ translate("Status") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(student, index) in filteredStudents"
                                    :key="student.id"
                                    :class="getRowClass(student.status)"
                                >
                                    <th>{{ index + 1 }}</th>
                                    <td>
                                        <span
                                            class="fw-bold text-primary cursor-pointer"
                                            @click="showDetails(student)"
                                        >
                                            {{ student.name }}
                                        </span>
                                    </td>
                                    <td>{{ student.father }}</td>
                                    <td>{{ student.apply_for }}</td>
                                    <td>{{ student.phone_number }}</td>
                                    <td>{{ formatDate(student.created_at) }}</td>
                                    <td>
                                        <Multiselect
                                            v-model="student.status"
                                            :options="statusOptions"
                                            :searchable="false"
                                            :close-on-select="true"
                                            :clear-on-select="false"
                                            :allow-empty="false"
                                            @select="confirmStatusChange(student)"
                                        />
                                        <ConfirmationModal
                                            :record-id="student.id"
                                            @processThis="updateStatus"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="text-muted text-center py-4">
                        {{ translate("Please select both session and course to view enrolled students.") }}
                    </div>
                </div>
            </div>
        </section>

        <!-- Student Detail Modal -->
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
                                <tr><th>{{ translate("Name") }}</th><td>{{ selectedStudent.name }}</td></tr>
                                <tr><th>{{ translate("Father") }}</th><td>{{ selectedStudent.father }}</td></tr>
                                <tr><th>{{ translate("Date of Birth") }}</th><td>{{ selectedStudent.dob }}</td></tr>
                                <tr><th>{{ translate("CNIC") }}</th><td>{{ selectedStudent.cnic }}</td></tr>
                                <tr><th>{{ translate("Phone Number") }}</th><td>{{ selectedStudent.phone_number }}</td></tr>
                                <tr><th>{{ translate("WhatsApp Number") }}</th><td>{{ selectedStudent.whatsapp }}</td></tr>
                                <tr><th>{{ translate("Apply For") }}</th><td>{{ selectedStudent.apply_for }}</td></tr>
                                <tr><th>{{ translate("Country") }}</th><td>{{ selectedStudent.country }}</td></tr>
                                <tr><th>{{ translate("Province") }}</th><td>{{ selectedStudent.province }}</td></tr>
                                <tr><th>{{ translate("Guardian Name") }}</th><td>{{ selectedStudent.guardian_name }}</td></tr>
                                <tr><th>{{ translate("Guardian CNIC") }}</th><td>{{ selectedStudent.guardian_cnic }}</td></tr>
                                <tr><th>{{ translate("Guardian Phone") }}</th><td>{{ selectedStudent.guardian_mobile }}</td></tr>
                                <tr><th>{{ translate("Previous Madrasa") }}</th><td>{{ selectedStudent.previous_madrasa }}</td></tr>
                                <tr><th>{{ translate("Previous Class") }}</th><td>{{ selectedStudent.previous_class }}</td></tr>
                                <tr><th>{{ translate("Total Marks") }}</th><td>{{ selectedStudent.total_marks }}</td></tr>
                                <tr><th>{{ translate("Obtained Marks") }}</th><td>{{ selectedStudent.obtained_marks }}</td></tr>
                                <tr><th>{{ translate("Primary Education") }}</th><td>{{ selectedStudent.primary_education }}</td></tr>
                                <tr><th>{{ translate("Additional Ability") }}</th><td>{{ selectedStudent.additional_ability }}</td></tr>
                                <tr><th>{{ translate("Permanent Address") }}</th><td>{{ selectedStudent.permanent_address }}</td></tr>
                                <tr><th>{{ translate("Current Address") }}</th><td>{{ selectedStudent.current_address }}</td></tr>
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
import Multiselect from "@vueform/multiselect";

export default {
    layout: Master,
    components: { Multiselect },
    data() {
        return {
            students: [],
            selectedStudent: {},
            selectedSessions: [],
            selectedCourses: [],
            filterOptions: [
                "تحصّص بالفقہ ایک سال", "تحصّص بالفقہ دو سال", "تحصّص باللغات",
                "دورہ حدیث", "درجہ سابعہ", "درجہ سادسہ", "درجہ خامسہ",
                "درجہ رابعہ", "درجہ ثالثہ", "درجہ ثانیہ", "درجہ اولیٰ", "متوسطا",
            ],
            yearsOptions: Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i),
            statusOptions: [
                { value: 1, label: "Accept" },
                { value: 2, label: "Pending" },
                { value: 3, label: "Reject" },
            ],
            studentToUpdate: null,
            newStatus: null,
        };
    },
    computed: {
        canShowTable() {
            return this.selectedSessions.length > 0 && this.selectedCourses.length > 0;
        },
        filteredStudents() {
            if (!this.canShowTable) return [];
            return this.students.filter(s =>
                this.selectedSessions.includes(String(s.session)) &&
                this.selectedCourses.includes(s.apply_for)
            );
        },
    },
    created() {
        this.fetchStudents();
    },
    methods: {
        translate(text) {
            return text;
        },
        fetchStudents() {
            axios.get(route("api.students.fetch"))
                .then(res => this.students = res.data)
                .catch(err => console.error(err));
        },
        confirmStatusChange(student) {
            this.studentToUpdate = student;
            this.newStatus = student.status;
            const modal = new bootstrap.Modal(document.getElementById(`confirmationModal-${student.id}`));
            modal.show();
        },
        updateStatus(studentId) {
            if (!this.studentToUpdate || !this.newStatus) return;
            axios.post(route("api.students.updateStatus"), {
                id: studentId,
                status: this.newStatus,
            })
                .then(() => {
                    this.studentToUpdate.status = this.newStatus;
                    toastr.success(this.translate("Status updated successfully."));
                })
                .catch(() => {
                    this.$toast.error(this.translate("Failed to update status."));
                })
                .finally(() => {
                    this.studentToUpdate = null;
                    this.newStatus = null;
                });
        },
        getRowClass(status) {
            switch (status) {
                case 1: return "table-success";
                case 2: return "table-warning";
                case 3: return "table-danger";
                default: return "";
            }
        },
        showDetails(student) {
            this.selectedStudent = student;
            const modal = new bootstrap.Modal(document.getElementById("studentModal"));
            modal.show();
        },
        formatDate(date) {
            return moment(date).format("DD-MMM-YYYY hh:mm A");
        },
    },
};
</script>

<style>
@import "@vueform/multiselect/themes/default.css";
.cursor-pointer {
    cursor: pointer;
}
</style>
