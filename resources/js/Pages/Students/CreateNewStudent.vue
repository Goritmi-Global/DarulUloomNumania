<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">
                    {{ translate("Enroll New Student") }}
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
                            {{ translate("Create") }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5
                        class="card-title theme-text-color"
                        :class="{
                            'rtl-text':
                                $page.props.default_language === 'PK' ||
                                $page.props.default_language === 'SA',
                        }"
                    ></h5>

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
                                            class="text-primary"
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
                                            translate("WhatsApp Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.whatsapp"
                                            placeholder="+92 300 1234567"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.whatsapp,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.whatsapp"
                                            class="text-danger"
                                        >
                                            {{ formErrors.whatsapp[0] }}
                                        </div>
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
                                            :class="{
                                                'is-invalid':
                                                    formErrors.guardian_name,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.guardian_name"
                                            class="text-danger"
                                        >
                                            {{ formErrors.guardian_name[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians CNIC")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_cnic"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.guardian_cnic,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.guardian_cnic"
                                            class="text-danger"
                                        >
                                            {{ formErrors.guardian_cnic[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians Mobile")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_mobile"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.guardian_mobile,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.guardian_mobile"
                                            class="text-danger"
                                        >
                                            {{ formErrors.guardian_mobile[0] }}
                                        </div>
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
                                            :class="{
                                                'is-invalid':
                                                    formErrors.previous_madrasa,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.previous_madrasa"
                                            class="text-danger"
                                        >
                                            {{ formErrors.previous_madrasa[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Previous Class")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.previous_class"
                                            :options="previousClassOptions"
                                            :placeholder="
                                                translate('Select Course')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.previous_class,
                                            }"
                                        />

                                        <div
                                            v-if="formErrors.previous_class"
                                            class="text-danger"
                                        >
                                            {{ formErrors.previous_class[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{
                                            translate("Total Marks")
                                        }}</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="form.total_marks"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.total_marks,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.total_marks"
                                            class="text-danger"
                                        >
                                            {{ formErrors.total_marks[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{
                                            translate("Obtained Marks")
                                        }}</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="form.obtained_marks"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.obtained_marks,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.obtained_marks"
                                            class="text-danger"
                                        >
                                            {{ formErrors.obtained_marks[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Secular Education")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.primary_education"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.primary_education,
                                            }"
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
                                            :class="{
                                                'is-invalid':
                                                    formErrors.additional_ability,
                                            }"
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

                                    <!-- Addresses -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Permanent Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            rows="2"
                                            v-model="form.permanent_address"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.permanent_address,
                                            }"
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
                                            rows="2"
                                            v-model="form.current_address"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.current_address,
                                            }"
                                        ></textarea>
                                        <div
                                            v-if="formErrors.current_address"
                                            class="text-danger"
                                        >
                                            {{ formErrors.current_address[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="c-files">
                                            <span
                                                class="col-6 col-form-label mt-1"
                                                >{{ "Image" }}</span
                                            >
                                            <br />
                                            <Cropper
                                                @croppedImg="croppedImgSubmit"
                                                accept=".jpg,.jpeg,.png"
                                            />
                                            <br />
                                            <ImageZooming
                                                v-if="form.image"
                                                :file="form.image"
                                                :width="100"
                                            />
                                            <ImageZooming
                                                v-else
                                                :file="existing_image"
                                                :width="100"
                                            />

                                            <!-- <img :src="form.image" width="100" /> -->
                                        </div>
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.image"
                                        >
                                            {{ formErrors.image[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Status")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.status"
                                            :options="statusOptions"
                                            :searchable="false"
                                            :close-on-select="true"
                                            :clear-on-select="false"
                                            :allow-empty="false"
                                            :placeholder="
                                                translate('Select Status')
                                            "
                                        />
                                        <div
                                            v-if="formErrors.status"
                                            class="text-danger"
                                        >
                                            {{ formErrors.status[0] }}
                                        </div>
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
        </section>
    </main>
</template>

<script>
import axios from "axios";
import moment from "moment";
import Master from "../Layout/Master.vue";
import Multiselect from "@vueform/multiselect";

export default {
    layout: Master,
    components: {
        Multiselect,
    },
    props: ["studentId", "studentData"],
    created() {
        if (this.studentId) {
            // in the Props in studentData the current student record is coming if studnetId found then get the studentData in the form3
            const studentData = this.studentData;
            // Set the form data with the studentData
            this.form = {
                id: studentData.id,
                apply_for: studentData.apply_for,
                name: studentData.name,
                father: studentData.father,
                dob: moment(studentData.dob).format("YYYY-MM-DD"),
                cnic: studentData.cnic,
                country: studentData.country,
                province: studentData.province,
                current_address: studentData.current_address,
                permanent_address: studentData.permanent_address,
                phone_number: studentData.phone_number,
                whatsapp: studentData.whatsapp,

                guardian_name: studentData.guardian_name,
                guardian_cnic: studentData.guardian_cnic,
                guardian_mobile: studentData.guardian_mobile,

                desired_class: studentData.desired_class,
                previous_madrasa: studentData.previous_madrasa,
                previous_class: studentData.previous_class,
                total_marks: studentData.total_marks,
                obtained_marks: studentData.obtained_marks,
                primary_education: studentData.primary_education,
                additional_ability: studentData.additional_ability,

                status: studentData.status || 2, // Default to 'Pending' if not set
            };
            this.existing_image = studentData.image;
        }
    },
    data() {
        return {
            enrollCheckCnin: "",
            admissionStatusDetails: null,
            formErrors: {},
            checkStatusBtn: 1,
            noRecordFound: false,

            formErrors: {},

            currentStudent: "",
            currentCourse: "",
            students: [],
            filterOptions: [
                "تَخَصُّص فِی الفِقْہِ ایک سال",
                "تَخَصُّص فِی الفِقْہِ دو سال",
                "تحصُّص فِي اللُّغَاتِ",
                "دورہ حدیث",
                "درجہ سابعہ",
                "درجہ سادسہ",
                "درجہ خامسہ",
                "درجہ رابعہ",
                "درجہ ثالثہ",
                "درجہ ثانیہ",
                "درجہ اولیٰ",

                "متوسطا",
            ],
            previousClassOptions: [
                "دورہ حدیث",
                "درجہ سابعہ",
                "درجہ سادسہ",
                "درجہ خامسہ",
                "درجہ رابعہ",
                "درجہ ثالثہ",
                "درجہ ثانیہ",
                "درجہ اولیٰ",

                "متوسطا",
            ],
            form: {
                id: "",
                apply_for: "",
                name: "",
                father: "",
                dob: "",
                cnic: "",
                country: "Pakistan",
                province: "",
                current_address: "",
                permanent_address: "",
                phone_number: "",
                whatsapp_number: "",
                image: null, // For storing the uploaded image
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

                status: "",
            },
            existing_image: "",
            countryList: [
                { label: "Pakistan (پاکستان)", value: "Pakistan" },
                { label: "Afghanistan (افغانستان)", value: "Afghanistan" },
            ],

            pakProvinceOptions: [
                { label: "Punjab (پنجاب)", value: "Punjab" },
                { label: "Sindh (سندھ)", value: "Sindh" },
                {
                    label: "Khyber Pakhtunkhwa (خیبر پختونخوا)",
                    value: "Khyber Pakhtunkhwa",
                },
                { label: "Balochistan (بلوچستان)", value: "Balochistan" },
                {
                    label: "Gilgit-Baltistan (گلگت بلتستان)",
                    value: "Gilgit-Baltistan",
                },
                {
                    label: "Azad Jammu and Kashmir (آزاد جموں و کشمیر)",
                    value: "Azad Jammu and Kashmir",
                },
            ],

            afgProvinceOptions: [
                { label: "Badakhshan (بدخشان)", value: "Badakhshan" },
                { label: "Badghis (بادغیس)", value: "Badghis" },
                { label: "Baghlan (بغلان)", value: "Baghlan" },
                { label: "Balkh (بلخ)", value: "Balkh" },
                { label: "Bamyan (بامیان)", value: "Bamyan" },
                { label: "Daykundi (دایکندی)", value: "Daykundi" },
                { label: "Farah (فراہ)", value: "Farah" },
                { label: "Faryab (فاریاب)", value: "Faryab" },
                { label: "Ghazni (غزنی)", value: "Ghazni" },
                { label: "Ghor (غور)", value: "Ghor" },
                { label: "Helmand (ہلمند)", value: "Helmand" },
                { label: "Herat (ہرات)", value: "Herat" },
                { label: "Jowzjan (جوزجان)", value: "Jowzjan" },
                { label: "Kabul (کابل)", value: "Kabul" },
                { label: "Kandahar (قندھار)", value: "Kandahar" },
                { label: "Kapisa (کاپیسا)", value: "Kapisa" },
                { label: "Khost (خوست)", value: "Khost" },
                { label: "Kunar (کنڑ)", value: "Kunar" },
                { label: "Kunduz (کندز)", value: "Kunduz" },
                { label: "Laghman (لغمان)", value: "Laghman" },
                { label: "Logar (لوگر)", value: "Logar" },
                { label: "Nangarhar (ننگرہار)", value: "Nangarhar" },
                { label: "Nimroz (نیمروز)", value: "Nimroz" },
                { label: "Nuristan (نورستان)", value: "Nuristan" },
                { label: "Paktia (پکتیا)", value: "Paktia" },
                { label: "Paktika (پکتیکا)", value: "Paktika" },
                { label: "Panjshir (پنجشیر)", value: "Panjshir" },
                { label: "Parwan (پروان)", value: "Parwan" },
                { label: "Samangan (سمنگان)", value: "Samangan" },
                { label: "Sar-e Pol (سر پل)", value: "Sar-e Pol" },
                { label: "Takhar (تخار)", value: "Takhar" },
                { label: "Urozgan (اروزگان)", value: "Urozgan" },
                { label: "Wardak (وردک)", value: "Wardak" },
                { label: "Zabul (زابل)", value: "Zabul" },
            ],
            statusOptions: [
                { value: 1, label: "Accepted (قبول کیا گیا)" },
                { value: 2, label: "Pending (زیر التواء)" },
                { value: 3, label: "Rejected (مسترد کیا گیا)" },
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
                    this.$inertia.get(route("students"));
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                    this.formStatus = 1;
                    if (error.response?.data?.errors) {
                        this.formErrors = error.response.data.errors;
                        let errorMessages = Object.values(this.formErrors)
                            .flat()
                            .join("<br>");
                        toastr.error(
                            this.translate("Some fields required data")
                        );
                    } else {
                        toastr.error(
                            this.translate("An unexpected error occurred.")
                        );
                    }
                });
        },

        croppedImgSubmit(img) {
            this.form.image = img;
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
            };
            this.formErrors = {};
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
