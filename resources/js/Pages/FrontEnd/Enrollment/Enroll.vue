<template>
    <main id="main" class="main">
        <!-- Hero Section -->
        <section class="hero-section text-center py-5 text-white">
            <div class="container">
                <h1 class="display-4">
                    {{ translate("New Student Enrollment") }}
                </h1>
                <p class="lead">
                    {{
                        translate(
                            "Providing quality Islamic education with modern learning techniques"
                        )
                    }}.
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
                    <h1 class="display-4 p-3 mt-3 theme-text-color">
                        {{ translate("Enroll") }}
                    </h1>

                    <section class="section bg-white">
                        <div class="card shadow-sm border-0 shadow-lg">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <!-- Apply For -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Apply For")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.apply_for"
                                            :options="filterOptions"
                                            :placeholder="
                                                translate('Select Course')
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

                                    <!-- Name -->
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

                                    <!-- Father's Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Fathers Name")
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

                                    <!-- CNIC -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("CNIC Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.cnic"
                                            :class="{
                                                'is-invalid': formErrors.cnic,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.cnic"
                                            class="text-danger"
                                        >
                                            {{ formErrors.cnic[0] }}
                                        </div>
                                    </div>

                                    <!-- DOB -->
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

                                    <!-- Country & Province Dropdowns -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Country")
                                        }}</label>

                                        <Multiselect
                                            v-model="form.country"
                                            :options="countryList"
                                            :placeholder="
                                                translate('Select country')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.country,
                                            }"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Province")
                                        }}</label>
                                        <Multiselect
                                            v-if="form.country == 'Pakistan'"
                                            v-model="form.province"
                                            :options="pakProvinceOptions"
                                            :placeholder="
                                                translate('Select province')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.province,
                                            }"
                                        />
                                        <Multiselect
                                            v-if="form.country == 'Afghanistan'"
                                            v-model="form.province"
                                            :options="afgProvinceOptions"
                                            :placeholder="
                                                translate('Select province')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.province,
                                            }"
                                        />
                                    </div>

                                    <!-- Phone & WhatsApp -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Phone Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.phone_number"
                                            placeholder="+92 300 1234567"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("WhatsApp Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.whatsapp"
                                            placeholder="+92 300 1234567"
                                        />
                                    </div>

                                    <!-- Guardian Info -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_name"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians CNIC")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_cnic"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians Mobile")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_mobile"
                                        />
                                    </div>

                                    <!-- Academic Info -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Previous Madrasa Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.previous_madrasa"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Previous Class")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.previous_class"
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{
                                            translate("Total Marks")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.total_marks"
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{
                                            translate("Obtained Marks")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.obtained_marks"
                                        />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Secular Education")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.primary_education"
                                        />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate(
                                                "Additional Qualifications"
                                            )
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.additional_ability"
                                        />
                                    </div>

                                    <!-- Addresses -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Permanent Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            rows="2"
                                            v-model="form.permanent_address"
                                        ></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Current Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            rows="2"
                                            v-model="form.current_address"
                                        ></textarea>
                                    </div>

                                    <!-- Conditional Document Uploads -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Upload Documents")
                                        }}</label>
                                        <div v-if="form.country === 'Pakistan'">
                                            <input
                                                type="file"
                                                @change="
                                                    handleFileUpload(
                                                        $event,
                                                        'cnic_front'
                                                    )
                                                "
                                            />
                                            CNIC Front<br />
                                            <input
                                                type="file"
                                                @change="
                                                    handleFileUpload(
                                                        $event,
                                                        'cnic_back'
                                                    )
                                                "
                                            />
                                            CNIC Back
                                        </div>
                                        <div v-else>
                                            <input
                                                type="file"
                                                @change="
                                                    handleFileUpload(
                                                        $event,
                                                        'passport'
                                                    )
                                                "
                                            />
                                            Passport<br />
                                            <input
                                                type="file"
                                                @change="
                                                    handleFileUpload(
                                                        $event,
                                                        'visa'
                                                    )
                                                "
                                            />
                                            Visa
                                        </div>
                                        <input
                                            type="file"
                                            @change="
                                                handleFileUpload(
                                                    $event,
                                                    'verification_letter'
                                                )
                                            "
                                        />
                                        Verification Letter
                                    </div>

                                    <!-- Submit -->
                                    <div class="mt-4">
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
            filterOptions: [
                "دورہ حدیث",
                "درجہ اولیٰ",
                "درجہ ثانیہ",
                "درجہ ثالثہ",
                "درجہ رابعہ",
                "درجہ خامسہ",
                "درجہ سادسہ",
                "درجہ سابعہ",
                "تحصّص باللغات",
                "تحصّص بالفقہ",
                "ایک سال اور دو سال",
                "متوسطا",
            ],
            form: {
                id: "",
                apply_for: "",
                name: "",
                father: "",
                dob: "",
                cnic: "",
                country: "",
                province: "",
                current_address: "",
                permanent_address: "",
                phone_number: "",
                whatsapp_number: "",

                // Guardian Info
                guardian_name: "",
                guardian_cnic: "",
                guardian_phone: "",

                // Academic Info
                desired_class: "",
                previous_madrasa: "",
                previous_class: "",
                total_marks: "",
                obtained_marks: "",
                primary_education: "",
                additional_ability: "",

                // Document Uploads
                cnic_front: null,
                cnic_back: null,
                passport: null,
                visa: null,
                verification_letter: null,

                // Payment
                payment_confirmed: false,
            },
            countryList: ["Pakistan", "Afghanistan"],

            pakProvinceOptions: [
                "Punjab",
                "Sindh",
                "Khyber Pakhtunkhwa",
                "Balochistan",
                "Gilgit-Baltistan",
                "Azad Jammu and Kashmir",
            ],
            afgProvinceOptions: [
                "Kabul",
                "Herat",
                "Kandahar",
                "Mazar-i-Sharif",
                "Jalalabad",
                "Bamiyan",
                "Badakhshan",
            ],
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

            const formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] !== null) {
                    formData.append(key, this.form[key]);
                }
            }

            axios
                .post(route("api.student.store"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
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
                name: "",
                father: "",
                dob: "",
                cnic: "",
                country: "",
                province: "",
                current_address: "",
                permanent_address: "",
                phone_number: "",
                whatsapp_number: "",

                guardian_name: "",
                guardian_cnic: "",
                guardian_phone: "",

                desired_class: "",
                previous_madrasa: "",
                previous_class: "",
                total_marks: "",
                obtained_marks: "",
                primary_education: "",
                additional_ability: "",

                cnic_front: null,
                cnic_back: null,
                passport: null,
                visa: null,
                verification_letter: null,

                payment_confirmed: false,
            };
            this.formErrors = {};
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
