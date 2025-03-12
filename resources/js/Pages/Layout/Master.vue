<template>
    <div class="main">
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a
                    :href="route('dashboard')"
                    class="logo d-flex align-items-center"
                >
                    <img src="/images/logo.png" height="150" alt="" />
                    <!-- <span class="d-none d-lg-block theme-text-color">Darul Ul Oloom</span> -->
                </a>

                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>

            <!-- End Search Bar -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <!-- <li class="nav-item d-block d-lg-none">
                        <a class="nav-link nav-icon search-bar-toggle" href="#">
                            <i class="bi bi-search"></i>
                            
                        </a>
                        
                    </li> -->
                    <!-- <li>
                        <button
                            class="btn btn-success btn-sm"
                            data-bs-toggle="modal"
                            ref="openTransactionModal"
                            data-bs-target="#transactionmodal"
                            @click="clearFields"
                        >
                            <i class="bi bi-plus-lg"></i> New Transaction
                        </button>
                    </li> -->
                    <li class="nav-item dropdown nav-item d-block d-lg-none">
                        <a
                            class="nav-link nav-profile d-flex align-items-center pe-0"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            <span class="d-md-block dropdown-toggle ps-2"
                                >{{ $page.props.user.first_name }}
                                {{ $page.props.user.last_name }}</span
                            > </a
                        ><!-- End Profile Iamge Icon -->

                        <ul
                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                        >
                            <li>
                                <a
                                    class="dropdown-item d-flex align-items-center"
                                    href="/profile"
                                >
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a
                                    class="dropdown-item d-flex align-items-center"
                                    href="javascript:;"
                                    @click="logout"
                                >
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Search Icon-->

                    <li class="nav-item dropdown pe-3">
                        <a
                            class="nav-link nav-profile d-flex align-items-center pe-0"
                            href="#"
                            data-bs-toggle="dropdown"
                        >
                            <!-- <img
                                :src="'/backend/assets/img/profile-img.jpg'"
                                alt="Profile"
                                class="rounded-circle"
                            /> -->
                            <span class="d-none d-md-block dropdown-toggle ps-2"
                                >{{ $page.props.user.first_name }}
                                {{ $page.props.user.last_name }}</span
                            > </a
                        ><!-- End Profile Iamge Icon -->

                        <ul
                            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                        >
                            <li>
                                <a
                                    class="dropdown-item d-flex align-items-center"
                                    href="/profile"
                                >
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a
                                    class="dropdown-item d-flex align-items-center"
                                    href="javascript:;"
                                    @click="logout"
                                >
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Profile Nav -->
                </ul>
            </nav>
            <!-- End Icons Navigation -->
        </header>
        <!-- End Header -->

        <!-- Modal for the new transactions -->
        <!-- Transaction Modal -->
        <div
            class="modal fade"
            id="transactionmodal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" v-if="form.id">
                            {{ form.remarks }} - {{ form.method }}
                            <small>({{ form.date }})</small>
                        </h5>
                        <h5 class="modal-title text-primary" v-else>
                            New Transaction Entry
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-body p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-12 mb-3">
                                    <label>{{ "Process Type" }} </label>
                                    <Multiselect
                                        v-model="form.process_type"
                                        :options="processTypeOptions"
                                        :searchable="true"
                                        @select="clearProcessType"
                                        :class="{
                                            'invalid-bg':
                                                formErrors.process_type,
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                        v-if="formErrors.process_type"
                                    >
                                        {{ formErrors.process_type[0] }}
                                    </div>
                                </div>
                                <div
                                    class="col-12 col-md-12 mb-3"
                                    v-if="
                                        form.process_type == 'Income' ||
                                        form.process_type == 'Expense'
                                    "
                                >
                                    <label>{{ "Bussiness Type" }} </label>
                                    <Multiselect
                                        v-model="form.business_type"
                                        :options="businessTypesOptions"
                                        :searchable="true"
                                        @select="
                                            pluckExpIncTypes(
                                                form.business_type,
                                                form.process_type
                                            )
                                        "
                                        :class="{
                                            'invalid-bg':
                                                formErrors.business_type,
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                        v-if="formErrors.business_type"
                                    >
                                        {{ formErrors.business_type[0] }}
                                    </div>
                                </div>

                                <div
                                    class="col-12 col-md-6"
                                    v-if="form.process_type == 'Income'"
                                >
                                    <label>{{ "Income Type" }} </label>
                                    <Multiselect
                                        v-model="form.income_type"
                                        :options="IncomeTypesOptions"
                                        :searchable="true"
                                        :class="{
                                            'invalid-bg':
                                                formErrors.income_type,
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                        v-if="formErrors.income_type"
                                    >
                                        {{ formErrors.income_type[0] }}
                                    </div>
                                </div>

                                <div
                                    class="col-12 col-md-6"
                                    v-if="form.process_type == 'Expense'"
                                >
                                    <label>{{ "Expense Type" }} </label>
                                    <Multiselect
                                        v-model="form.expense_type"
                                        :options="ExpenseTypesOptions"
                                        :searchable="true"
                                        :class="{
                                            'invalid-bg':
                                                formErrors.expense_type,
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                        v-if="formErrors.expense_type"
                                    >
                                        {{ formErrors.expense_type[0] }}
                                    </div>
                                </div>
                                <div
                                    class="col-12 col-md-6"
                                    v-if="
                                        form.process_type == 'Borrow' ||
                                        form.process_type == 'Lend'
                                    "
                                >
                                    <label>{{ "Select person" }} </label>
                                    <Multiselect
                                        v-model="form.person"
                                        :options="personsOptions"
                                        :searchable="true"
                                        :class="{
                                            'invalid-bg': formErrors.person,
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                        v-if="formErrors.person"
                                    >
                                        {{ formErrors.person[0] }}
                                    </div>
                                </div>
                                <div
                                    class="col-md-6 col-12"
                                    v-if="
                                        form.process_type == 'Income' ||
                                        form.process_type == 'Borrow'
                                    "
                                >
                                    <label for="cash_in">Cash In</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="cash_in"
                                        v-model="form.cash_in"
                                        :class="{
                                            'invalid-bg': formErrors.cash_in,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.cash_in"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.cash_in[0] }}
                                    </div>
                                </div>

                                <div
                                    class="col-md-6 col-12"
                                    v-if="
                                        form.process_type == 'Expense' ||
                                        form.process_type == 'Lend'
                                    "
                                >
                                    <label for="cash_out">Cash Out</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="cash_out"
                                        v-model="form.cash_out"
                                        :class="{
                                            'invalid-bg': formErrors.cash_out,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.cash_out"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.cash_out[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <label for="remarks">Description</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="remarks"
                                        v-model="form.remarks"
                                        :class="{
                                            'invalid-bg': formErrors.remarks,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.remarks"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.remarks[0] }}
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label>{{ "Payment Method" }} </label>
                                    <Multiselect
                                        v-model="form.method"
                                        :options="methodTypesOpions"
                                        :searchable="true"
                                        :class="{
                                            'invalid-bg': formErrors.method,
                                        }"
                                    />
                                    <div
                                        class="invalid-feedback animated fadeIn"
                                        v-if="formErrors.method"
                                    >
                                        {{ formErrors.method[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <label for="type">Reciept No</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="type"
                                        v-model="form.ref_no"
                                        :class="{
                                            'invalid-bg': formErrors.ref_no,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.ref_no"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.ref_no[0] }}
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <label for="date">Date</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        :max="today"
                                        id="date"
                                        v-model="form.date"
                                        :class="{
                                            'invalid-bg': formErrors.date,
                                        }"
                                    />
                                    <div
                                        v-if="formErrors.date"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.date[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="receipt_image"
                                        >Receipt image</label
                                    >
                                    <br />
                                    <CropperOffCanvas
                                        @croppedImg="croppedImgPassToForm"
                                        accept=".jpg,.jpeg,.png"
                                    />

                                    <br />
                                    <img
                                        v-if="form.receipt_image"
                                        :src="
                                            form.receipt_image ??
                                            '/images/default.jpg'
                                        "
                                        :width="100"
                                    />
                                    <img
                                        v-else-if="existing_receipt_image"
                                        :src="
                                            existing_receipt_image ??
                                            '/images/default.jpg'
                                        "
                                        :width="100"
                                    />
                                    <img
                                        v-else
                                        :src="'/images/default.jpg'"
                                        :width="100"
                                    />

                                    <div
                                        v-if="formErrors.receipt_image"
                                        class="invalid-feedback"
                                    >
                                        {{ formErrors.receipt_image[0] }}
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        v-if="formStatus == 1"
                                        @click="submit"
                                    >
                                        Save
                                    </button>
                                    <button
                                        class="btn btn-success"
                                        type="button"
                                        disabled
                                        v-else
                                    >
                                        Saving
                                        <span
                                            class="spinner-border spinner-border-sm"
                                        ></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button
                hidden
                data-bs-toggle="modal"
                data-bs-target="#customermodal"
                ref="closeModal"
            ></button>
        </div>

        <!-- Modal for the new transactions -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link collapsed" :class="{ active: isActive('/dashboard') }" href="/dashboard">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Accounts (Parent Menu with Transactions and Other Sub-Menus) -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#accounts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-circle"></i>
                <span>Accounts</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="accounts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a :class="{ active: isActive('/transactions') }" href="/transactions">
                        <i class="bi bi-cash"></i>
                        <span>Transactions</span>
                    </a>
                </li>
                <li>
                    <a :class="{ active: isActive('/business/types') }" href="/business/types">
                        <i class="bi bi-briefcase"></i>
                        <span>Business Types</span>
                    </a>
                </li>
                <li>
                    <a :class="{ active: isActive('/expense/types') }" href="/expense/types">
                        <i class="bi bi-dash-circle"></i>
                        <span>Expense Types</span>
                    </a>
                </li>
                <li>
                    <a :class="{ active: isActive('/income/types') }" href="/income/types">
                        <i class="bi bi-plus-circle"></i>
                        <span>Income Types</span>
                    </a>
                </li>
                <li>
                    <a :class="{ active: isActive('/income-statements') }" href="/income-statements">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Income Statements</span>
                    </a>
                </li>
                <li>
                    <a :class="{ active: isActive('/reports') }" href="/reports">
                        <i class="bi bi-bar-chart-line"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a :class="{ active: isActive('/loan-management') }" href="/loan-management">
                        <i class="bi bi-cash-coin"></i>
                        <span>Loan Management</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Accounts Section -->

        <!-- Software Users (Separate from Accounts) -->
        <li class="nav-item">
            <a class="nav-link collapsed" :class="{ active: isActive('/users') }" href="/users">
                <i class="bi bi-people"></i>
                <span>Software Users</span>
            </a>
        </li>

        <!-- Settings Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="settings-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <!-- Languages (Only for Super Admin) -->
                <li>
                    <a :class="{ active: isActive('/languages') }" href="/languages">
                        <i class="bi bi-translate"></i>
                        <span>{{ translate("Languages") }}</span>
                    </a>
                </li>
                 
            </ul>
        </li>
        <!-- End Settings -->
    </ul>
</aside>



        <!-- End Sidebar-->

        <slot></slot>

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Alsmi</span></strong
                >. All Rights Reserved
            </div>
            <div class="credits">
                Designed by
                <a href="https://goritmi.co.uk">Goritim Ltd</a>
            </div>
        </footer>
        <!-- End Footer -->
    </div>
</template>

<script>
import axios from "axios";
import Multiselect from "@vueform/multiselect";
export default {
    components: {
        Multiselect,
    },
    created() {
        this.process_type = "Income";
    },
    data() {
        return {
            formStatus: 1,
            form: {
                id: "",
                cash_in: "",
                cash_out: "",
                date: "",
                ref_no: "",
                method: "",
                remarks: "",
                expense_type: "",
                income_type: "",
                process_type: "",
                receipt_image: "",
                person: "",
                business_type: "",
            },
            formErrors: [],
            methodTypesOpions: ["Bank", "Cash"],
            ExpenseTypesOptions: [],
            IncomeTypesOptions: [],
            processTypeOptions: ["Expense", "Income", "Borrow", "Lend"],
            personsOptions: [],
            businessTypesOptions: [],
        };
    },
    mounted() {
        let bootstrapJs = document.createElement("script");
        bootstrapJs.setAttribute(
            "src",
            "/backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"
        );
        document.head.appendChild(bootstrapJs);

        let mainJs = document.createElement("script");
        mainJs.setAttribute("src", "/backend/assets/js/main.js");
        document.head.appendChild(mainJs);

        this.fetchTransactionEntries();
        this.pluckPersons();
        this.pluckBussinessTypes();
    },

    computed: {
        // Keeps Loan Management open if any sub-route is active
        isLoanManagementActive() {
            return (
                window.location.pathname.startsWith("/persons") ||
                window.location.pathname.startsWith("/business/types")
            );
        },
    },

    methods: {
        submit() {
            let formData = new FormData();
            // Helper function to handle null, undefined, or empty values
            const sanitizeValue = (value) =>
                (value ?? "").toString().trim() === "" ? "" : value;

            formData.append("id", sanitizeValue(this.form.id));
            formData.append("cash_in", sanitizeValue(this.form.cash_in));
            formData.append("cash_out", sanitizeValue(this.form.cash_out));
            formData.append("date", sanitizeValue(this.form.date));
            formData.append("ref_no", sanitizeValue(this.form.ref_no));
            formData.append("method", sanitizeValue(this.form.method));
            formData.append("remarks", sanitizeValue(this.form.remarks));
            formData.append(
                "business_type",
                sanitizeValue(this.form.business_type)
            );
            formData.append("person", sanitizeValue(this.form.person));
            formData.append(
                "expense_type",
                sanitizeValue(this.form.expense_type)
            );
            formData.append(
                "income_type",
                sanitizeValue(this.form.income_type)
            );
            formData.append(
                "process_type",
                sanitizeValue(this.form.process_type)
            );

            // Append image only if it exists
            if (this.form.receipt_image) {
                formData.append("receipt_image", this.form.receipt_image);
            }

            // this.formStatus = 0;
            axios
                .post(route("api.transaction.store"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(() => {
                    this.formStatus = 1;

                    toastr.success("Transaction entry saved successfully.");
                    this.$refs.closeModal?.click();
                    window.location.href = "/transactions";
                })

                .catch((error) => {
                    this.formStatus = 1;
                    toastr.error(error.response.data.message);
                    this.formErrors = error.response.data.errors;
                });
        },
        croppedImgPassToForm(img) {
            this.form.receipt_image = img;
        },
        setAltImg(event) {
            event.target.src = "/images/default.jpg";
        },
        clearProcessType() {
            this.form.cash_in = "";
            this.form.cash_out = "";
            this.form.business_type = "";
        },
        fetchTransactionEntries() {
            this.serachingLoading = true;
            // Validation checks
            this.FilterErrors = "";
            if (
                this.selectedFilter === "Monthly" &&
                (!this.selectedMonth || !this.selectedYear)
            ) {
                this.FilterErrors =
                    "Please select both Month and Year for the Monthly filter.";
                this.serachingLoading = false;
                return;
            }

            if (this.selectedFilter === "Yearly" && !this.selectedYear) {
                this.FilterErrors =
                    "Please select a Year for the Yearly filter.";
                this.serachingLoading = false;
                return;
            }

            if (
                this.selectedFilter === "Custom" &&
                (!this.startDate || !this.endDate)
            ) {
                this.FilterErrors =
                    "Please select both Start Date and End Date for the Custom filter.";
                this.serachingLoading = false;
                return;
            }

            let formData = new FormData();

            formData.append("selectedFilter", this.selectedFilter);

            if (this.selectedMonth) {
                formData.append("selectedMonth", this.selectedMonth);
            }
            if (this.selectedYear) {
                formData.append("selectedYear", this.selectedYear);
            }
            if (this.startDate) {
                formData.append("startDate", this.startDate);
            }
            if (this.endDate) {
                formData.append("endDate", this.endDate);
            }
            if (this.filterBusinessType) {
                formData.append("businessType", this.filterBusinessType);
            }

            axios
                .post(route("api.transaction.fetch"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.serachingLoading = false;
                    this.transactionEntries = response.data;
                })
                .catch((error) => {
                    this.serachingLoading = false;
                    toastr.error(error.response.data.message);
                });
        },
        pluckExpIncTypes(business_type_id, expense_type) {
            if (expense_type == "Income") {
                this.pluckIncomeTypes(business_type_id);
            }
            if (expense_type == "Expense") {
                this.pluckExpenseTypes(business_type_id);
            }
        },
        pluckIncomeTypes(business_type_id) {
            axios
                .get(route("api.income.pluck", business_type_id)) // Ensure this API returns income types
                .then((response) => {
                    this.IncomeTypesOptions = response.data; // Fix variable name casing
                })
                .catch((error) => {
                    console.error("Error fetching income types:", error);
                });
        },
        pluckExpenseTypes(business_type_id) {
            axios
                .get(route("api.expense.pluck", business_type_id)) // Ensure this API returns expense types
                .then((response) => {
                    this.ExpenseTypesOptions = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching expense types:", error);
                });
        },
        pluckPersons() {
            axios
                .get(route("api.persons.pluck"))
                .then((response) => {
                    this.personsOptions = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        pluckBussinessTypes() {
            axios
                .get(route("api.business.types.pluck"))
                .then((response) => {
                    this.businessTypesOptions = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        // Checks if the current route starts with the given path
        isActive(route) {
            return window.location.pathname.startsWith(route);
        },

        logout() {
            axios
                .post(route("api.logout"), this.form, {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then(() => {
                    this.$inertia.get(route("login"));
                })
                .catch((error) => {});
        },
    },
};
</script>

<style>
@import url("public/backend/assets/vendor/bootstrap/css/bootstrap.min.css");
@import url("public/backend/assets/vendor/bootstrap-icons/bootstrap-icons.css");
@import url("public/backend/assets/vendor/boxicons/css/boxicons.min.css");
@import url("public/backend/assets/vendor/remixicon/remixicon.css");
@import url("public/backend/assets/vendor/simple-datatables/style.css");
@import url("public/backend/assets/css/style.css");
@import url("public/backend/assets/css/custom.css");

@import "toastr";
</style>

<style>
@import "@vueform/multiselect/themes/default.css";
/* custom style that should be moved into the custom.css file later */
.section-title {
    text-align: left;
    padding-bottom: 5px;
}
.nav-link.active {
    background-color: #f6f9ff !important; /* Change this to your desired color */
    color: #174696 !important;
}
.section-title h5 {
    font-size: 22px;
    font-weight: bold;
    text-transform: uppercase;
    position: relative;
    color: #012970;
}
/* .section-title h5::before {
    content: "";
    position: absolute;
    display: block;
    width: 120px;
    height: 1px;
    background: #ddd;
    bottom: 1px;
    left: calc(50% - 60px);
}
.section-title h5::after {
    content: "";
    position: absolute;
    display: block;
    width: 40px;
    height: 3px;
    background: #012970;
    bottom: 0;
    left: calc(50% - 20px);
} */
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

.btn-success {
    background-color: #012970 !important;
    border-color: #012970 !important;
}

.btn-success:hover {
    background-color: #012970 !important;
    border-color: #012970 !important;
}

.btn-success:active {
    background-color: #012970 !important;
    border-color: #012970 !important;
}

.btn-success:focus {
    color: #fff !important;
    box-shadow: none !important;
}
.toast-success {
    background-color: #012970 !important;
}
.theme-text-color {
    color: #012970 !important;
    font-weight: bold;
}
.theme-bg-color {
    background-color: #012970 !important;
}
.text-primary {
    color: #012970 !important;
}
.logo img {
    max-height: 57px;
    margin-right: 6px;
}
.multiselect-option.is-selected {
    background: #012970;
    color: var(--ms-option-color-selected, #fff);
}
.multiselect-option.is-selected.is-pointed {
    background: #012970;
    color: var(--ms-option-color-selected, #fff);
}
.c-text-theme {
    color: #012970 !important;
}
</style>
