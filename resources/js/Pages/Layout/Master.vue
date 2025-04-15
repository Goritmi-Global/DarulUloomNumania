<template>
    <div class="main">
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a
                    :href="route('dashboard')"
                    class="logo d-flex align-items-center"
                >
                    <img src="/images/logo.jpg" height="150" alt="" />
                    <!-- <span class="d-none d-lg-block theme-text-color">Darul Ul Oloom</span> -->
                </a>

                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>

            <!-- End Search Bar -->
            <a
                class="nav-link nav-icon ms-2"
                :href="route('/')"
                target="_blank"
                title="Browse Website"
            >
                <i class="bi bi-globe"></i>
            </a>
            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <!-- <li class="nav-item d-block d-lg-none">
                        <a class="nav-link nav-icon search-bar-toggle" href="#">
                            <i class="bi bi-search"></i>
                            
                        </a>
                        
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

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        :class="{ active: isActive('/dashboard') }"
                        href="/dashboard"
                    >
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Accounts (Parent Menu with Transactions and Other Sub-Menus) -->
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{
                            collapsed: !isParentActive([
                                '/transactions',
                                '/business/types',
                                '/expense/types',
                                '/income/types',
                                '/income-statements',
                                '/reports',
                                '/loan-management',
                            ]),
                        }"
                        data-bs-target="#accounts-nav"
                        data-bs-toggle="collapse"
                        href="#"
                    >
                        <i class="bi bi-person-circle"></i>
                        <span>Accounts</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        id="accounts-nav"
                        class="nav-content collapse"
                        :class="{
                            show: isParentActive([
                                '/transactions',
                                '/business/types',
                                '/expense/types',
                                '/income/types',
                                '/income-statements',
                                '/reports',
                                '/loan-management',
                            ]),
                        }"
                        data-bs-parent="#sidebar-nav"
                    >
                        <li>
                            <a
                                :class="{ active: isActive('/transactions') }"
                                href="/transactions"
                            >
                                <i class="bi bi-cash"></i>
                                <span>Transactions</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a
                                :class="{ active: isActive('/business/types') }"
                                href="/business/types"
                            >
                                <i class="bi bi-briefcase"></i>
                                <span>Business Types</span>
                            </a>
                        </li> -->
                        <li>
                            <a
                                :class="{ active: isActive('/expense/types') }"
                                href="/expense/types"
                            >
                                <i class="bi bi-dash-circle"></i>
                                <span>Expense Types</span>
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{ active: isActive('/income/types') }"
                                href="/income/types"
                            >
                                <i class="bi bi-plus-circle"></i>
                                <span>Income Types</span>
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{
                                    active: isActive('/income-statements'),
                                }"
                                href="/income-statements"
                            >
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Income Statements</span>
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{ active: isActive('/reports') }"
                                href="/reports"
                            >
                                <i class="bi bi-bar-chart-line"></i>
                                <span>Reports</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a
                                :class="{
                                    active: isActive('/loan-management'),
                                }"
                                href="/loan-management"
                            >
                                <i class="bi bi-cash-coin"></i>
                                <span>Loan Management</span>
                            </a>
                        </li>-->
                    </ul>
                </li>

                <!-- End Accounts Section -->

                

                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        :class="{ active: isActive('/students') }"
                        href="/students"
                    >
                        <i class="bi bi-people-fill"></i>
                        <span>{{ translate("Enrolled Student") }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{
                            collapsed: !isParentActive([
                                '/introduction',
                                '/books',
                                '/bayanaat',
                                '/islamic-names',
                                '/questions-answers',
                            ]),
                        }"
                        data-bs-target="#darul-iftah-nav"
                        data-bs-toggle="collapse"
                        href="#"
                    >
                        <i class="bi bi-person-circle"></i>
                        <span>{{ translate("Darul Iftah") }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        id="darul-iftah-nav"
                        class="nav-content collapse"
                        :class="{
                            show: isParentActive([
                                '/introduction',
                                '/books',
                                '/bayanaat',
                                '/islamic-names',
                                '/questions-answers',
                            ]),
                        }"
                        data-bs-parent="#sidebar-nav"
                    >
                        <li>
                            <a
                                :class="{ active: isActive('/introduction') }"
                                href="/introduction"
                            >
                                <i class="bi bi-info-circle"></i>
                                {{ translate("Introduction") }}
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{ active: isActive('/books') }"
                                href="/books"
                            >
                                <i class="bi bi-book"></i>
                                {{ translate("Books") }}
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{ active: isActive('/bayanaat') }"
                                href="/bayanaat"
                            >
                                <i class="bi bi-mic"></i>
                                {{ translate("Bayanaat") }}
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{ active: isActive('/islamic-names') }"
                                href="/islamic-names"
                            >
                                <i class="bi bi-person-badge"></i>
                                {{ translate("Islamic Names") }}
                            </a>
                        </li>
                        <li>
                            <a
                                :class="{
                                    active: isActive('/questions-answers'),
                                }"
                                href="/questions-answers"
                            >
                                <i class="bi bi-question-circle"></i>
                                {{ translate("Questions & Answers") }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Software Users (Separate from Accounts) -->
                <li class="nav-item">
                    <a
                        class="nav-link collapsed"
                        :class="{ active: isActive('/users') }"
                        href="/users"
                    >
                        <i class="bi bi-people"></i>
                        <span>{{ translate("Software Users") }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{ collapsed: !isParentActive(['/languages']) }"
                        data-bs-target="#settings-nav"
                        data-bs-toggle="collapse"
                        href="#"
                    >
                        <i class="bi bi-gear"></i>
                        <span>{{ translate("Settings") }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        id="settings-nav"
                        class="nav-content collapse"
                        :class="{ show: isParentActive(['/languages']) }"
                        data-bs-parent="#sidebar-nav"
                    >
                        <!-- Languages (Only for Super Admin) -->
                        <li>
                            <a
                                :class="{ active: isActive('/languages') }"
                                href="/languages"
                            >
                                <i class="bi bi-translate"></i>
                                <span>{{ translate("Languages") }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </aside>

        <!-- End Sidebar-->

        <slot></slot>

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Darul Oloom</span></strong
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

    data() {
        return {};
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
    },

    methods: {
        // Checks if the current route starts with the given path
        isActive(route) {
            return window.location.pathname.startsWith(route);
        },
        isParentActive(routes) {
            return routes.some((route) =>
                window.location.pathname.startsWith(route)
            );
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
.multiselect-option.is-selected {
    background: #012970 !important;
    color: var(--ms-option-color-selected, #fff);
}
.multiselect-option.is-selected.is-pointed {
    background: #012970 !important;
    color: var(--ms-option-color-selected, #fff);
}
</style>
