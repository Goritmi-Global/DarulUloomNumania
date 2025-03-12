<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ Details.name }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a :href="route('dashboard')">PIMMS</a>
                        </li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a :href="route('students')" class="btn btn-success mt-3">
                    <i class="bi bi-back"></i> All Students
                </a>
            </div>
        </div>
        <section class="section">
            <div class="card card-body p-4">
                <div
                    class="card-header h4 theme-text-color d-flex justify-content-between"
                >
                    <div>
                        Mr. {{ Details.name }} S/o Mr. {{ Details.father_name }}
                    </div>
                    <div>
                        <div
                            v-if="Details.id"
                            class="btn-group"
                            role="group"
                            aria-label="Basic example"
                        >
                            <a
                                type="button"
                                target="_blank"
                                :href="
                                    route('student.details.pdf.print', [
                                        Details.id,
                                        print,
                                    ])
                                "
                                class="btn btn-md btn-success"
                            >
                                <i class="bi bi-printer-fill"></i>
                            </a>

                            <a
                                type="button"
                                target="_blank"
                                :href="
                                    route('student.details.pdf.print', [
                                        Details.id,
                                        download,
                                    ])
                                "
                                class="btn btn-md btn-danger"
                            >
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-3">
                    <Link class="mt-1" :href="route('student.edit', studentId)">
                        <i class="bi bi-pencil"></i>
                    </Link>
                    <!-- <button class="btn">
                        <i
                            class="bi bi-pencil"
                            data-bs-toggle="modal"
                            data-bs-target="#studentmodal"
                            @click="editShow(studentId)"
                        ></i>
                    </button> -->
                    <DeleteModal
                        :deleteId="studentId"
                        @deleteThis="deleteThis"
                    />
                </div>
                <div class="card card-body p-4">
                    <div class="row mb-5">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title theme-text-color">
                                    Student information
                                </h5>
                            </div>
                            <div>
                                
                                <ImageZooming
                                    v-if="Details.image"
                                    :file="Details.image"
                                    :width="80"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- <div class="col-md-3">
                            <strong>{{ "Form Number" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.form_no }}
                        </div> -->
                        <div class="col-md-3">
                            <strong>{{ "Form #" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.form_no }}
                        </div>

                        <div class="col-md-3">
                            <strong>{{ "Registration #" }}</strong>
                        </div>

                        <div class="col-md-3">
                            {{ Details.registration_number }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "College" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.college_id }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Program" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.programName }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Current session" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.sessionName }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Batch" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.batchName }}
                        </div>
                        <div class="col-md-3" v-if="Details.current_semester">
                            <strong>{{ "Current semester" }}</strong>
                        </div>
                        <div class="col-md-3" v-if="Details.current_semester">
                            {{ Details.current_semester }}
                        </div>
                        <div class="col-md-3" v-if="Details.current_year">
                            <strong>{{ "Current year" }}</strong>
                        </div>
                        <div class="col-md-3" v-if="Details.current_year">
                            {{ Details.current_year }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Date of birth" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.dob }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Marital status" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.marital_status }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Gender" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.gender }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Permanent address" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.p_address }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Country" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.s_country }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Domicile" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.s_domicile }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "District" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.s_district }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Cell # 1" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.cell_no_a }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Cell # 2" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.cell_no_b }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Email" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.email }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "CNIC/Form-B" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.cnic_formb }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Current status" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.current_status }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ "Entry date" }}</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Details.entry_date }}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title theme-text-color">
                            Parent information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <strong>{{ "Father name" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.father_name }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Profession" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.father_profession }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Address" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.father_address }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Country" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.f_country }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "District" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.f_district }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Address" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.f_address }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Phone #" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.f_phone }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Cell #" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.father_cell }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Email" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.father_email }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title theme-text-color">
                            Guardian information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <strong>{{ "Guardian name" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.guardian_name }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Address" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.guardian_address }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Phone #" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.g_phone }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Cell #" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.g_cell }}
                            </div>
                            <div class="col-md-3">
                                <strong>{{ "Email" }}</strong>
                            </div>
                            <div class="col-md-3">
                                {{ Details.g_email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Master from "../Layout/Master.vue";
import axios from "axios";
import Multiselect from "@vueform/multiselect";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
export default {
    layout: Master,
    props: ["studentId"],
    components: {
        Multiselect,
        Datepicker,
    },
    created() {
        this.details_fetch(this.studentId);
    },
    data() {
        return {
            Details: [],
            formErrors: [],
            download: "download",
            print: "print",
        };
    },
    methods: {
        details_fetch(id) {
            axios
                .get(route("api.student.details.fetch", id), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.Details = response.data;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },

        deleteThis(id) {
            axios
                .delete(route("api.student.delete", id), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    toastr.success("Student record deleted successfully");
                    this.$inertia.get(route("students"));
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        setAltImg(event) {
            event.target.src = "/images/default.jpg";
        },
    },
};
</script>

<style lang="scss" scoped></style>
