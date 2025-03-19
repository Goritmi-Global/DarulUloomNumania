<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">New Students Enrollment</h1>
                <p class="lead">
                    Providing quality Islamic education with modern learning
                    techniques.
                </p>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <section class="section mt-3 bg-whie">
                        <div class="">
                            <h1 class="display-4 p-3 theme-text-color">
                                {{ translate("Rule Regulations") }}
                            </h1>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-primary text-white"
                                        >
                                            <h5>
                                                {{
                                                    translate("Course Duration")
                                                }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                {{
                                                    translate(
                                                        "Each course has a duration ranging from 6 months to 3 years, depending on the subject matter."
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-success text-white"
                                        >
                                            <h5>
                                                {{
                                                    translate(
                                                        "Course Requirements"
                                                    )
                                                }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    {{
                                                        translate(
                                                            "Basic understanding of Arabic (optional but recommended)"
                                                        )
                                                    }}
                                                </li>
                                                <li>
                                                    {{
                                                        translate(
                                                            "Commitment to daily learning and practice"
                                                        )
                                                    }}
                                                </li>
                                                <li>
                                                    {{
                                                        translate(
                                                            "Ability to read and write in Urdu or English"
                                                        )
                                                    }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-warning text-white"
                                        >
                                            <h5>
                                                {{ translate("Madrassa Role") }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                {{
                                                    translate(
                                                        "Our institution provides a well-structured curriculum with experienced teachers and modern facilities to ensure a holistic Islamic education."
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-6">
                    <h1 class="display-4 p-3 mt-3 theme-text-color">Enroll</h1>

                    <section class="section bg-white">
                        <div class="card shadow-sm border-0 shadow-lg">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Apply For")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.apply_for"
                                            :options="filterOptions"
                                            :placeholder="
                                                translate(
                                                    'Select Course/Package'
                                                )
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.apply_for,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.apply_for"
                                            class="text-danger"
                                        >
                                            {{ formErrors.apply_for[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Phone Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.phone_number"
                                            placeholder="+92 300 1234567"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.phone_number,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.phone_number"
                                            class="text-danger"
                                        >
                                            {{ formErrors.phone_number[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.name"
                                            :class="{
                                                'is-invalid': formErrors.name,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.name"
                                            class="text-danger"
                                        >
                                            {{ formErrors.name[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Father Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.father"
                                            :class="{
                                                'is-invalid': formErrors.father,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.father"
                                            class="text-danger"
                                        >
                                            {{ formErrors.father[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Date of Birth")
                                        }}</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="form.dob"
                                            :class="{
                                                'is-invalid': formErrors.dob,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.dob"
                                            class="text-danger"
                                        >
                                            {{ formErrors.dob[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Primary Education")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.primary_education"
                                        />
                                        <div
                                            v-if="formErrors.primary_education"
                                            class="text-danger"
                                        >
                                            {{
                                                formErrors.primary_education[0]
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Additional Abilities")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.additional_ability"
                                        />
                                        <div
                                            v-if="formErrors.additional_ability"
                                            class="text-danger"
                                        >
                                            {{
                                                formErrors.additional_ability[0]
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Permanent Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            v-model="form.permanent_address"
                                            rows="2"
                                        ></textarea>
                                        <div
                                            v-if="formErrors.permanent_address"
                                            class="text-danger"
                                        >
                                            {{
                                                formErrors.permanent_address[0]
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Current Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            v-model="form.current_address"
                                            rows="2"
                                        ></textarea>
                                        <div
                                            v-if="formErrors.current_address"
                                            class="text-danger"
                                        >
                                            {{ formErrors.current_address[0] }}
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button
                                            type="submit"
                                            class="btn btn-success px-4"
                                            v-if="formStatus === 1"
                                            @click="submit"
                                        >
                                            {{ translate("Enroll Now") }}
                                        </button>
                                        <button
                                            class="btn btn-secondary px-4"
                                            type="button"
                                            disabled
                                            v-else
                                        >
                                            {{ translate("Processing...") }}
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div v-if="showModal" class="modal fade show d-block">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            {{ translate("Application Successful") }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="showModal = false"
                        ></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            <strong
                                >{{ translate("Dear ") }}
                                {{ currentStudent }},</strong
                            >
                        </p>
                        <p>
                            {{
                                translate(
                                    "You have successfully applied for the course of "
                                )
                            }}
                            <strong>{{ currentCourse }}</strong>
                        </p>
                        <p>
                            {{
                                translate(
                                    "The administration will contact you soon."
                                )
                            }}
                        </p>
                        <p>
                            {{ translate("For any queries, contact us at:") }}
                        </p>
                        <p>
                            <strong>0000-0000000</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show"></div>
    </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/MasterFront.vue";
import Multiselect from "@vueform/multiselect";
export default {
    layout: Master,
    components: {
        Multiselect,
    },
    data() {
        return {
            currentStudent: "",
            currentCourse: "",
            students: [],
            filterOptions: ["Hifz", "Tafseer", "Qirat", "Dars-e-Nizami"],
            form: {
                id: "",
                apply_for: "",
                phone_number: "",
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
            showModal: false,
        };
    },
    methods: {
        submit() {
            this.currentStudent = this.form.name;
            this.currentCourse = this.form.apply_for;
            this.formStatus = 0;
            axios
                .post(route("api.student.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    this.clearForm();
                    toastr.success(
                        this.translate("Student enrolled successfully.")
                    );
                    this.showModal = true;
                })
                .catch((error) => {
                    this.formStatus = 1;
                    if (error.response?.data?.errors) {
                        this.formErrors = error.response.data.errors;
                        let errorMessages = Object.values(this.formErrors)
                            .flat()
                            .join("<br>");
                        toastr.error(errorMessages);
                    } else {
                        toastr.error(
                            this.translate("An unexpected error occurred.")
                        );
                    }
                });
        },
        clearForm() {
            this.form = {
                id: "",
                apply_for: "",
                phone_number: "",
                name: "",
                father: "",
                dob: "",
                permanent_address: "",
                current_address: "",
                primary_education: "",
                additional_ability: "",
            };
            this.formErrors = {}; // Reset errors
        },
    },
};
</script>
<style>
/* General Styles */
.hero-section,
.admission-section {
    margin-top: 70px;
    background-color: var(--primary-color);
}
.section {
    display: flex;
    justify-content: center;
    align-items: center;
}
.card {
    max-width: 800px;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
}
.card-header {
    font-size: 20px;
    font-weight: bold;
}
.btn-success {
    font-size: 16px;
    padding: 10px 20px;
}
.is-invalid {
    border-color: red;
}
.card {
    max-width: 800px;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%; /* Ensure equal height */
}

.card-body {
    flex: 1; /* Allow content to fill evenly */
}
.card {
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    
}

.card:hover {
    opacity: 1;
    transform: translateY(-5px);
}

</style>
