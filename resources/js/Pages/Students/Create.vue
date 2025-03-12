<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">Student</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a :href="route('dashboard')">PIMMS</a>
                        </li>
                        <li class="breadcrumb-item">New</li>
                        <li class="breadcrumb-item active">Enrol</li>
                    </ol>
                </nav>
            </div>
            <div>
                <Link :href="route('students')" class="btn btn-success mt-3">
                    <i class="bi bi-plus-lg"></i> Go back
                </Link>
            </div>
        </div>

        <section class="section">
            <div class="card card-body p-4">
                <div class="card card-body p-4">
                    <h5 class="card-title theme-text-color">
                        Student information
                    </h5> 
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="inputNanme4"
                                >Form #

                                <span class="text-danger"> <b>*</b> </span>
                            </label>
                            <input
                                type="form_no"
                                class="form-control"
                                id="form_no"
                                :class="{
                                    'invalid-bg': formErrors.form_no,
                                }"
                                v-model="form.form_no"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.form_no"
                            >
                                {{ formErrors.form_no[0] }}
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                             {{ "College" }}
                                <span class="text-danger"> <b>*</b> </span>
                             
                            <Multiselect
                                :options="collegesOptions"
                                v-model="form.college" 
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.college,
                                }"
                                @select="pluckPrograms(form.college)"
                                :disabled="
                                        studentId
                                    "
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.college"
                            >
                                {{ formErrors.college[0] }}
                            </div>
                        </div>

                        <div class="col-md-6" v-if="form.college">
                            <label
                                >{{ "Program" }}
                                <span class="text-danger">
                                    <b>*</b>
                                </span></label
                            >
                            <Multiselect
                                v-model="form.program"
                                :options="programOptions" 
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.program,
                                }"
                                @select="compareProgramDuration(form.program)"
                                :disabled="
                                        studentId
                                    "
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.program"
                            >
                                {{ formErrors.program[0] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label
                                >{{ "Session" }}
                                <span class="text-danger">
                                    <b>*</b>
                                </span></label
                            >
                            <Multiselect
                                v-model="form.session"
                                :options="sessionOptions" 
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.session,
                                }"
                                :disabled="
                                        studentId
                                    "
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.session"
                            >
                                {{ formErrors.session[0] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label
                                >{{ "Batch" }}
                                <span class="text-danger">
                                    <b>*</b>
                                </span></label
                            >
                            <Multiselect
                                v-model="form.batch"
                                :options="batchOptions" 
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.batch,
                                }"
                                :disabled="
                                        studentId
                                    "
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.batch"
                            >
                                {{ formErrors.batch[0] }}
                            </div>
                        </div>

                        <!-- <div class="col-md-6" v-if="programType == 'Semester'">
                            <label>{{ "Semester" }}</label>
                            <Multiselect
                                v-model="form.current_semester"
                                :options="semesterOptions"
                                :placeholder="'Semester'"
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.current_semester,
                                }"
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.current_semester"
                            >
                                {{ formErrors.current_semester[0] }}
                            </div>
                        </div>
                        <div class="col-md-6" v-if="programType == 'Annual'">
                            <label>{{ "Annual" }}</label>
                            <Multiselect
                                v-model="form.annual"
                                :options="yearsOptions"
                                :placeholder="'Annual'"
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.annual,
                                }"
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.annual"
                            >
                                {{ formErrors.annual[0] }}
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <label for="inputNanme4">
                                Name
                                <span class="text-danger"> <b>*</b> </span>
                            </label>
                            <input
                                type="name"
                                class="form-control"
                                id="name"
                                :class="{
                                    'invalid-bg': formErrors.name,
                                }"
                                v-model="form.name"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.name"
                            >
                                {{ formErrors.name[0] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>
                                {{ "Date of Birth" }}
                            </label>
                            <Datepicker
                                autoApply
                                :enable-time-picker="false"
                                :class="{
                                    'invalid-bg': formErrors.dob,
                                }"
                                v-model="form.dob"
                            >
                            </Datepicker>
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.dob"
                            >
                                {{ formErrors.dob[0] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputNanme4">Marital Status</label>
                            <Multiselect
                                v-model="form.marital_status"
                                :options="MSOptions" 
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.marital_status,
                                }"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.marital_status"
                            >
                                {{ formErrors.marital_status[0] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>{{ "Gender" }}</label>
                            <Multiselect
                                v-model="form.gender"
                                :options="genderOptions" 
                                :searchable="true"
                                :class="{
                                    'invalid-bg': formErrors.gender,
                                }"
                            />
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.gender"
                            >
                                {{ formErrors.gender[0] }}
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="inputAddress">Permanent address</label>
                            <textarea
                                type="permanent_address"
                                class="form-control"
                                id="permanent_address"
                                :class="{
                                    'invalid-bg': formErrors.permanent_address,
                                }"
                                v-model="form.permanent_address"
                                rows="1"
                            ></textarea>

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.permanent_address"
                            >
                                {{ formErrors.permanent_address[0] }}
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">Country</label>
                            <input
                                type="text"
                                class="form-control"
                                id="country"
                                :class="{
                                    'invalid-bg': formErrors.student_country,
                                }"
                                v-model="form.student_country"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.student_country"
                            >
                                {{ formErrors.student_country[0] }}
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">Domicile</label>
                            <input
                                type="text"
                                class="form-control"
                                id="student_domicile"
                                :class="{
                                    'invalid-bg': formErrors.student_domicile,
                                }"
                                v-model="form.student_domicile"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.student_domicile"
                            >
                                {{ formErrors.student_domicile[0] }}
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">District</label>
                            <input
                                type="student_district"
                                class="form-control"
                                id="student_district"
                                :class="{
                                    'invalid-bg': formErrors.student_district,
                                }"
                                v-model="form.student_district"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.student_district"
                            >
                                {{ formErrors.student_district[0] }}
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">Cell # 1</label>
                            <input
                                type="cell_no_a"
                                class="form-control"
                                id="cell_no_a"
                                :class="{
                                    'invalid-bg': formErrors.cell_no_a,
                                }"
                                v-model="form.cell_no_a"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.cell_no_a"
                            >
                                {{ formErrors.cell_no_a[0] }}
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">Cell # 2</label>
                            <input
                                type="text"
                                class="form-control"
                                id="cell_no_b"
                                :class="{
                                    'invalid-bg': formErrors.cell_no_b,
                                }"
                                v-model="form.cell_no_b"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.cell_no_b"
                            >
                                {{ formErrors.cell_no_a[0] }}
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="student_email"
                                :class="{
                                    'invalid-bg': formErrors.student_email,
                                }"
                                v-model="form.student_email"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.student_email"
                            >
                                {{ formErrors.student_email[0] }}
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="inputNanme4">CNIC/Form-B</label>
                            <input
                                type="text"
                                class="form-control"
                                id="cnic_formb"
                                :class="{
                                    'invalid-bg': formErrors.cnic_formb,
                                }"
                                v-model="form.cnic_formb"
                            />

                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.cnic_formb"
                            >
                                {{ formErrors.cnic_formb[0] }}
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="c-files">
                                <span class="col-6 col-form-label mt-1">{{
                                    "Image"
                                }}</span>
                                <br />
                                <CropperOffCanvas
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
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title theme-text-color">
                            Parent information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Father name</label>
                                <input
                                    type="father_name"
                                    class="form-control"
                                    id="father_name"
                                    :class="{
                                        'invalid-bg': formErrors.father_name,
                                    }"
                                    v-model="form.father_name"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_name"
                                >
                                    {{ formErrors.father_name[0] }}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Profession</label>
                                <input
                                    type="father_profession"
                                    class="form-control"
                                    id="father_profession"
                                    :class="{
                                        'invalid-bg':
                                            formErrors.father_profession,
                                    }"
                                    v-model="form.father_profession"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_profession"
                                >
                                    {{ formErrors.father_profession[0] }}
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="inputAddress">Address</label>
                                <textarea
                                    type="father_address"
                                    class="form-control"
                                    id="father_address"
                                    :class="{
                                        'invalid-bg': formErrors.father_address,
                                    }"
                                    v-model="form.father_address"
                                    rows="1"
                                ></textarea>

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_address"
                                >
                                    {{ formErrors.father_address[0] }}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Country</label>
                                <input
                                    type="country"
                                    class="form-control"
                                    id="country"
                                    :class="{
                                        'invalid-bg': formErrors.father_country,
                                    }"
                                    v-model="form.father_country"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_country"
                                >
                                    {{ formErrors.father_country[0] }}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">District</label>
                                <input
                                    type="father_district"
                                    class="form-control"
                                    id="father_district"
                                    :class="{
                                        'invalid-bg':
                                            formErrors.father_district,
                                    }"
                                    v-model="form.father_district"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_district"
                                >
                                    {{ formErrors.father_district[0] }}
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Cell</label>
                                <input
                                    type="father_cell"
                                    class="form-control"
                                    id="father_cell"
                                    :class="{
                                        'invalid-bg': formErrors.father_cell,
                                    }"
                                    v-model="form.father_cell"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_cell"
                                >
                                    {{ formErrors.father_cell[0] }}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Phone</label>
                                <input
                                    type="father_phone"
                                    class="form-control"
                                    id="father_phone"
                                    :class="{
                                        'invalid-bg': formErrors.father_phone,
                                    }"
                                    v-model="form.father_phone"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_phone"
                                >
                                    {{ formErrors.father_phone[0] }}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Email</label>
                                <input
                                    type="father_email"
                                    class="form-control"
                                    id="father_email"
                                    :class="{
                                        'invalid-bg': formErrors.father_email,
                                    }"
                                    v-model="form.father_email"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.father_email"
                                >
                                    {{ formErrors.father_email[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title theme-text-color">
                            Guardian information
                        </h5>
                        <div class="col-12 col-md-6">
                            <div>
                                <label for="same_as_parent_status"
                                    >{{ "Same as parent" }}
                                </label>

                                <input
                                    class="ms-2 mt-1"
                                    type="checkbox"
                                    :placeholder="'Same as parent'"
                                    :class="{
                                        'invalid-bg':
                                            formErrors.same_as_parent_status,
                                    }"
                                    v-model="form.same_as_parent_status"
                                />
                            </div>
                            <div
                                class="invalid-feedback animated fadeIn"
                                v-if="formErrors.same_as_parent_status"
                            >
                                {{ formErrors.same_as_parent_status[0] }}
                            </div>
                        </div>
                        <div class="row g-3" v-if="!form.same_as_parent_status">
                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Guardian name</label>
                                <input
                                    type="guardian_name"
                                    class="form-control"
                                    id="guardian_name"
                                    :class="{
                                        'invalid-bg': formErrors.guardian_name,
                                    }"
                                    v-model="form.guardian_name"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.guardian_name"
                                >
                                    {{ formErrors.guardian_name[0] }}
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="inputAddress">Address</label>
                                <textarea
                                    type="guardian_address"
                                    class="form-control"
                                    id="guardian_address"
                                    :class="{
                                        'invalid-bg':
                                            formErrors.guardian_address,
                                    }"
                                    v-model="form.guardian_address"
                                    rows="1"
                                ></textarea>

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.guardian_address"
                                >
                                    {{ formErrors.guardian_address[0] }}
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Cell</label>
                                <input
                                    type="guardian_cell"
                                    class="form-control"
                                    id="guardian_cell"
                                    :class="{
                                        'invalid-bg': formErrors.guardian_cell,
                                    }"
                                    v-model="form.guardian_cell"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.guardian_cell"
                                >
                                    {{ formErrors.guardian_cell[0] }}
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Phone</label>
                                <input
                                    type="guardian_phone"
                                    class="form-control"
                                    id="guardian_phone"
                                    :class="{
                                        'invalid-bg': formErrors.guardian_phone,
                                    }"
                                    v-model="form.guardian_phone"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.guardian_phone"
                                >
                                    {{ formErrors.guardian_phone[0] }}
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="inputNanme4">Email</label>
                                <input
                                    type="guardian_email"
                                    class="form-control"
                                    id="guardian_email"
                                    :class="{
                                        'invalid-bg': formErrors.guardian_email,
                                    }"
                                    v-model="form.guardian_email"
                                />

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.guardian_email"
                                >
                                    {{ formErrors.guardian_email[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button
                                type="submit"
                                class="btn btn-success"
                                v-if="formStatus == 1"
                                @click="submit"
                            >
                                Enroll
                            </button>
                            <button
                                class="btn btn-success"
                                type="button"
                                disabled
                                v-else
                            >
                                Enrolling
                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                ></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <button
            hidden="hidden"
            data-bs-toggle="modal"
            data-bs-target="#modalForPrintPdf"
            title="Open"
            ref="openModal"
        ></button>

        <div class="modal fade" id="modalForPrintPdf" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="block-content text-center p-4">
                            <h6 class="mb-3">Print Slip OR Download Pdf</h6>

                            <a
                                target="_blank"
                                :href="
                                    route('print.pdf', [
                                        generated_student_id,
                                        generated_slip_id,
                                    ])
                                "
                                class="btn btn-sm btn-success me-2 btn-p"
                            >
                                Print
                            </a>

                            <a
                                target="_blank"
                                :href="
                                    route('download.pdf', [
                                        generated_student_id,
                                        generated_slip_id,
                                    ])
                                "
                                class="btn btn-sm btn-danger me-2 btn-p"
                            >
                                Pdf Download
                            </a>

                            <button
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-bs-dismiss="modal"
                                @click="redirectToIndex"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Master from "../Layout/Master.vue";
import Multiselect from "@vueform/multiselect";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";

export default {
    layout: Master,
    components: {
        Multiselect,
        Datepicker,
    },
    created() {
        // this.pluckPrograms();
        this.pluckSessions();
        this.pluckBatches();
        this.pluckColleges();
        if (this.studentId) {
            this.showEditRecord(this.studentId);
        }
    },
    props: ["studentId"],
    data() {
        return {
            Students: [],
            form: {
                student_id: "",
                form_no: "",
                program: "",
                college: "",
                session: "", //current session
                batch: "", //batch in which the student willbe enroll for the first time.
                name: "",
                dob: "",
                marital_status: "",
                gender: "",
                image: "",

                permanent_address: "",
                student_country: "",
                student_domicile: "",
                student_district: "",
                cell_no_a: "",
                cell_no_b: "",
                student_email: "",
                cnic_formb: "",
                father_name: "",
                father_profession: "",
                father_address: "",
                father_district: "",
                father_country: "",
                father_phone: "",
                father_cell: "",
                father_email: "",

                same_as_parent_status: "",
                guardian_name: "",
                guardian_address: "",
                guardian_phone: "",
                guardian_cell: "",
                guardian_email: "",

                status: "",
                current_semester: "",
                annual: "",
                entry_date: "",
            },
            formErrors: [],
            formStatus: 1,
            student_id: "",
            genderOptions: ["Male", "Female", "Other"],
            programOptions: [],
            sessionOptions: [],
            batchOptions: [],
            // semesterOptions: [
            //     "First Semester",
            //     "Second Semester",
            //     "Third Semester",
            //     "Fourth Semester",
            // ],
            programType: "Semester",
            // yearsOptions: ["First Year", "Second Year"],
            MSOptions: ["Married", "Unmarried"],
            statusOptions: ["Status 1", "Status 2"],
            existing_image: "",
            generated_student_id: "",
            generated_slip_id: "",
            collegesOptions: [],
        };
    },
    methods: {
        pluckColleges() { 
            axios
                .get(route("api.colleges.pluck"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.collegesOptions = response.data;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        pluckPrograms(college_id) {
            this.programOptions = [];
            this.form.semester = "";
            this.form.annual = ""; 
            this.form.program = "";
            axios
            .get(route("api.programs.pluck", college_id), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.programOptions = response.data;
                    this.programType = "Semester";
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        pluckSessions() {
            axios
                .get(route("api.sessoions.pluck"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.sessionOptions = response.data;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        pluckBatches() {
            axios
                .get(route("api.batch.for.enroll.pluck"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.batchOptions = response.data;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },

        submit() {
            this.formStatus = 0;
            let formData = new FormData();
            formData.append("student_id", this.form.student_id); //this id for updating the record.
            // Append each field to the formData object
            formData.append("form_no", this.form.form_no);
            formData.append("program", this.form.program);
            formData.append("college", this.form.college);
            formData.append("session", this.form.session);
            formData.append("batch", this.form.batch);
            formData.append("name", this.form.name);

            if (this.form.dob) {
                formData.append(
                    "dob",
                    this.form.dob.getMonth
                        ? this.form.dob.toLocaleDateString("en-US")
                        : this.form.dob
                        ? this.form.dob
                        : ""
                );
            }

            formData.append("marital_status", this.form.marital_status);
            formData.append("gender", this.form.gender);
            formData.append("image", this.form.image);
            formData.append("permanent_address", this.form.permanent_address);
            formData.append("student_country", this.form.student_country);
            formData.append("student_district", this.form.student_district);
            formData.append("student_domicile", this.form.student_domicile);
            formData.append("cell_no_a", this.form.cell_no_a);
            formData.append("cell_no_b", this.form.cell_no_b);
            formData.append("student_email", this.form.student_email);
            formData.append("cnic_formb", this.form.cnic_formb);

            formData.append("father_name", this.form.father_name);
            formData.append("father_profession", this.form.father_profession);
            formData.append("father_address", this.form.father_address);
            formData.append("father_district", this.form.father_district);
            formData.append("father_country", this.form.father_country);
            formData.append("father_phone", this.form.father_phone);
            formData.append("father_cell", this.form.father_cell);
            formData.append("father_email", this.form.father_email);

            formData.append(
                "same_as_parent_status",
                this.form.same_as_parent_status
            );
            formData.append("guardian_name", this.form.guardian_name);
            formData.append("guardian_address", this.form.guardian_address);
            formData.append("guardian_phone", this.form.guardian_phone);
            formData.append("guardian_cell", this.form.guardian_cell);
            formData.append("guardian_email", this.form.guardian_email);
            // formData.append("status", this.form.status);

            // if (this.form.annual) {
            //     formData.append("annual", this.form.annual);
            //     this.form.current_semester = "";
            //     formData.append("current_semester", "");
            // }
            // if (this.form.current_semester) {
            //     this.form.annual = "";
            //     formData.append("current_semester", this.form.current_semester);
            //     formData.append("annual", "");
            // }

            axios
                .post(route("api.student.store"), formData, {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.formStatus = 1;
                    toastr.success("Student record saved successfully");
                    if (response.data.process == "new") {
                        this.generated_student_id = response.data.student_id;
                        this.generated_slip_id = response.data.slip_id;
                        this.$refs.openModal.click();
                        this.clearFields();
                    } else {
                        this.clearFields();
                        this.$inertia.get(
                            route("student.details", this.form.student_id)
                        );
                    }
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                    this.formStatus = 1;
                    console.log(this.formStatus);
                    this.formErrors = error.response.data.errors;
                });
        },
        croppedImgSubmit(img) {
            this.form.image = img;
        },
        clearFields() {
            this.form.form_no = "";
            this.form.program = "";
            this.form.session = "";
            this.form.batch = "";
            this.form.name = "";
            this.form.dob = "";
            this.form.marital_status = "";
            this.form.gender = "";
            this.form.image = "";

            this.form.permanent_address = "";
            this.form.student_country = "";
            this.form.student_domicile = "";
            this.form.student_district = "";
            this.form.cell_no_a = "";
            this.form.cell_no_b = "";
            this.form.student_email = "";
            this.form.cnic_formb = "";
            this.form.father_name = "";
            this.form.father_profession = "";
            this.form.father_address = "";
            this.form.father_district = "";
            this.form.father_country = "";
            this.form.father_phone = "";
            this.form.father_cell = "";
            this.form.father_email = "";

            this.form.same_as_parent_status = "";
            this.form.guardian_name = "";
            this.form.guardian_address = "";
            this.form.guardian_phone = "";
            this.form.guardian_cell = "";
            this.form.guardian_email = "";

            this.form.status = "";
            this.form.current_semester = "";
            // this.form.annual = "";
            this.form.entry_date = "";

            this.formErrors = [];
        },
        showEditRecord(studentId) {
            axios
                .get(route("api.student.show", studentId), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.form.student_id = response.data.id;
                    this.form.form_no = response.data.form_no;
                    this.form.college = response.data.college_id;
                    this.pluckPrograms(response.data.college_id);
                    this.form.program = response.data.program;
                    this.form.session = response.data.session;
                    this.form.batch = response.data.batch;
                    this.form.name = response.data.name;
                    this.form.dob = response.data.dob;
                    this.form.marital_status = response.data.marital_status;
                    this.form.gender = response.data.gender;
                    this.existing_image = response.data.image;
                    this.form.image = response.data.image;

                    this.form.permanent_address = response.data.p_address;
                    this.form.student_country = response.data.s_country;
                    this.form.student_domicile = response.data.s_domicile;
                    this.form.student_district = response.data.s_district;
                    this.form.cell_no_a = response.data.cell_no_a;
                    this.form.cell_no_b = response.data.cell_no_b;
                    this.form.student_email = response.data.email;
                    this.form.cnic_formb = response.data.cnic_formb;
                    this.form.father_name = response.data.father_name;
                    this.form.father_profession =
                        response.data.father_profession;
                    this.form.father_address = response.data.father_address;
                    this.form.father_district = response.data.f_district;
                    this.form.father_country = response.data.f_country;
                    this.form.father_phone = response.data.f_phone;
                    this.form.father_cell = response.data.father_cell;
                    this.form.father_email = response.data.father_email;

                    this.form.same_as_parent_status =
                        response.data.same_as_parent_status;
                    this.form.guardian_name = response.data.guardian_name;
                    this.form.guardian_address = response.data.guardian_address;
                    this.form.guardian_phone = response.data.g_phone;
                    this.form.guardian_cell =
                        response.data.guardian_address_cell;
                    this.form.guardian_email = response.data.g_email;

                    // this.form.status = response.data.status;
                    this.form.current_semester = response.data.current_semester;
                    this.form.entry_date = response.data.entry_date;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        compareProgramDuration(program_id) {
            axios
                .get(route("api.compare.program.duration", program_id), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.programType = response.data.program_type;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        redirectToIndex() {
            this.$inertia.get(
                route("student.details", this.generated_student_id)
            );
        },
    },
};
</script>

<style lang="scss">
@import "@vueform/multiselect/themes/default.css";
.c-file-padding {
    padding: 1rem 0.75rem !important;
}
.invalid-feedback {
    display: block !important;
}
.invalid-bg {
    border-color: #f8d4d4 !important;
    background-color: #f8d4d4 !important;
}
.btn-p {
    width: 150px;
}
.text-danger {
    font-size: 20px;
}
</style>
