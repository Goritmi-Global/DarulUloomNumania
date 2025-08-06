<template>
    <div
        class="main"
        :class="{
            'c-jameel-noori':
                $page.props.default_language === 'PK' ||
                $page.props.default_language === 'SA',
        }"
    >
        <!-- HEADER -->
        <header
            id="header"
            class="header fixed-top d-flex justify-content-between align-items-center px-4 shadow-sm bg-white"
        >
            <div class="d-flex align-items-center gap-3">
                <a
                    :href="route('dashboard')"
                    class="logo d-flex align-items-center"
                >
                    <img
                        :src="'/images/frontlogo.png'"
                        alt="Logo"
                        height="50"
                        class="me-2"
                    />
                </a>
                <i class="bi bi-list toggle-sidebar-btn fs-4"></i>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a
                    class="nav-link"
                    :href="route('/')"
                    target="_blank"
                    title="Browse Website"
                >
                    <i class="bi bi-globe fs-5 text-primary"></i>
                </a>

                <!-- Language Switch -->
                <div class="dropdown">
                    <a
                        class="nav-link dropdown-toggle fw-semibold text-primary"
                        href="#"
                        id="languageDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ translate(user_language_name) }}
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-end shadow-sm"
                        aria-labelledby="languageDropdown"
                    >
                        <li
                            v-for="(language, index) in languages"
                            :key="index"
                            :class="{
                                'lang-active':
                                    language.code ==
                                    $page.props.default_language,
                            }"
                        >
                            <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                                @click="changeLang(language.code)"
                            >
                                {{ language.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Profile (Mobile + Desktop) -->
                <div class="dropdown d-flex align-items-center">
                    <a
                        class="nav-link dropdown-toggle fw-semibold text-dark"
                        href="#"
                        id="userDropdown"
                        data-bs-toggle="dropdown"
                        role="button"
                        aria-expanded="false"
                    >
                        {{ $page.props.user.first_name }}
                        {{ $page.props.user.last_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a
                                class="dropdown-item d-flex align-items-center gap-2"
                                href="/profile"
                            >
                                <i class="bi bi-gear text-primary"></i>
                                {{ translate("Account Settings") }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a
                                class="dropdown-item d-flex align-items-center gap-2"
                                href="javascript:;"
                                @click="logout"
                            >
                                <i
                                    class="bi bi-box-arrow-right text-danger"
                                ></i>
                                {{ translate("Sign Out") }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- SIDEBAR -->
        <aside id="sidebar" class="sidebar pt-5">
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        :class="{ active: isActive('/dashboard') }"
                        href="/dashboard"
                    >
                        <i class="bi bi-house-door"></i>
                        <span>{{ translate("Dashboard") }}</span>
                    </a>
                </li>

                <!-- ACCOUNTS -->
                <li
                    class="nav-item"
                    v-if="
                        ['superadmin', 'accountant'].includes(
                            $page.props.user.role
                        )
                    "
                >
                    <a
                        class="nav-link"
                        :class="{ collapsed: !isParentActive(accountsLinks) }"
                        data-bs-toggle="collapse"
                        data-bs-target="#accounts-nav"
                        href="#"
                    >
                        <i class="bi bi-wallet2"></i>
                        <span>{{ translate("Accounts") }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        id="accounts-nav"
                        class="nav-content collapse"
                        :class="{ show: isParentActive(accountsLinks) }"
                        data-bs-parent="#sidebar-nav"
                    >
                        <li v-for="link in accountsLinks" :key="link.path">
                            <a
                                :href="link.path"
                                :class="{ active: isActive(link.path) }"
                            >
                                <i :class="link.icon"></i>
                                <span>{{ translate(link.label) }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- STUDENTS -->
                <li
                    class="nav-item"
                    v-if="
                        ['superadmin', 'admission'].includes(
                            $page.props.user.role
                        )
                    "
                >
                    <a
                        class="nav-link"
                        :class="{ collapsed: !isParentActive(studentLinks) }"
                        data-bs-toggle="collapse"
                        data-bs-target="#students-nav"
                        href="#"
                    >
                        <i class="bi bi-person-lines-fill"></i>
                        <span>{{ translate("Students") }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        id="students-nav"
                        class="nav-content collapse"
                        :class="{ show: isParentActive(studentLinks) }"
                        data-bs-parent="#sidebar-nav"
                    >
                        <li v-for="link in studentLinks" :key="link.path">
                            <a
                                :href="link.path"
                                :class="{ active: isActive(link.path) }"
                            >
                                <i class="bi bi-chevron-right"></i>
                                {{ translate(link.label) }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- DARUL IFTAH -->
                <li
                    class="nav-item"
                    v-if="
                        ['superadmin', 'iftah'].includes($page.props.user.role)
                    "
                >
                    <a
                        class="nav-link"
                        :class="{ collapsed: !isParentActive(iftahLinks) }"
                        data-bs-toggle="collapse"
                        data-bs-target="#darul-iftah-nav"
                        href="#"
                    >
                        <i class="bi bi-journal-bookmark"></i>
                        <span>{{ translate("Darul Iftah") }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        id="darul-iftah-nav"
                        class="nav-content collapse"
                        :class="{ show: isParentActive(iftahLinks) }"
                        data-bs-parent="#sidebar-nav"
                    >
                        <li v-for="link in iftahLinks" :key="link.path">
                            <a
                                :href="link.path"
                                :class="{ active: isActive(link.path) }"
                            >
                                <i class="bi bi-chevron-right"></i>
                                {{ translate(link.label) }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- USERS & SETTINGS (Superadmin Only) -->
                <li
                    class="nav-item"
                    v-if="$page.props.user.role === 'superadmin'"
                >
                    <a
                        class="nav-link"
                        :href="'/users'"
                        :class="{ active: isActive('/users') }"
                    >
                        <i class="bi bi-people-fill"></i>
                        <span>{{ translate("Software Users") }}</span>
                    </a>
                </li>
                <li
                    class="nav-item"
                    v-if="$page.props.user.role === 'superadmin'"
                >
                    <a
                        class="nav-link"
                        :class="{ collapsed: !isParentActive(['/languages']) }"
                        data-bs-toggle="collapse"
                        data-bs-target="#settings-nav"
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
                        <li>
                            <a
                                :href="'/languages'"
                                :class="{ active: isActive('/languages') }"
                            >
                                <i class="bi bi-translate"></i>
                                {{ translate("Languages") }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- PAGE CONTENT -->
        <slot></slot>

        <!-- FOOTER -->
        <footer id="footer" class="footer bg-light text-center py-3">
            <div class="text-muted small">
                &copy; {{ new Date().getFullYear() }}
                {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}.
                {{ translate("All Rights Reserved") }}
                <br />
                {{ translate("Designed by") }}
                <a href="https://goritmi.co.uk" target="_blank">Goritmi Ltd</a>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            languages: [],
            user_language_name: "",
            accountsLinks: [
                {
                    path: "/transactions",
                    label: "Transactions",
                    icon: "bi bi-cash",
                },
                {
                    path: "/expense/types",
                    label: "Expense Types",
                    icon: "bi bi-dash-circle",
                },
                {
                    path: "/income/types",
                    label: "Income Types",
                    icon: "bi bi-plus-circle",
                },
                {
                    path: "/operating/advance",
                    label: "Operating Advance",
                    icon: "bi bi-plus-circle",
                },
                {
                    path: "/income-statements",
                    label: "Income Statements",
                    icon: "bi bi-file-earmark-text",
                },
                {
                    path: "/reports",
                    label: "Reports",
                    icon: "bi bi-bar-chart-line",
                },
            ],
            studentLinks: [
                { path: "/students", label: "All Students" },
                { path: "/enrolled-students", label: "Enrolled Students" },
            ],
            iftahLinks: [
                { path: "/introduction", label: "Introduction" },
                { path: "/books", label: "Books" },
                { path: "/bayanaat", label: "Bayanaat" },
                { path: "/islamic-names", label: "Islamic Names" },
                { path: "/questions-answers", label: "Questions & Answers" },
            ],
        };
    },
    mounted() {
        this.loadExternalScripts();
    },
    created() {
        this.fetchLanguages();
    },
    methods: {
        isActive(route) {
            return this.$page.url === route || this.$page.url.startsWith(route + '/');

        },
        isParentActive(links) {
            return links.some((link) => this.$page.url.startsWith(link.path));
        },
        logout() {
            axios
                .post(
                    route("api.logout"),
                    {},
                    {
                        headers: {
                            Authorization:
                                "Bearer " + this.$page.props.auth_token,
                        },
                    }
                )
                .then(() => {
                    this.$inertia.get(route("login"));
                });
        },
        fetchLanguages() {
            axios
                .get(route("api.all.languages"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((res) => {
                    this.languages = res.data;
                    const userLang = res.data.find(
                        (p) => p.code === this.$page.props.default_language
                    );
                    this.user_language_name = userLang ? userLang.name : "";
                });
        },
        changeLang(code) {
            const formData = new FormData();
            formData.append("default_language", code);
            axios
                .post(route("api.user.default.language"), formData)
                .then(() => {
                    window.location.reload();
                });
        },
        loadExternalScripts() {
            const bootstrapJs = document.createElement("script");
            bootstrapJs.src =
                "/backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js";
            document.head.appendChild(bootstrapJs);

            const mainJs = document.createElement("script");
            mainJs.src = "/backend/assets/js/main.js";
            document.head.appendChild(mainJs);
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
@import "@vueform/multiselect/themes/default.css";
/* custom style that should be moved into the custom.css file later */

.languages {
    font-weight: bold !important;
}
.languages .lang-active a {
    color: white !important;
}
.lang-active a,
.lang-active a:hover {
    /* background-color: white !important; */
    color: white !important;
    background-color: #174696 !important;
}

.c-jameel-noori {
    font-family: "Jameel Noori Nastaleeq", serif;
    font-size: 16px !important;
}

.rtl-text {
    direction: rtl;
    text-align: right;
    font-family: "Jameel Noori Nastaleeq", serif;
    font-size: 16px !important;
}
.c-jameel-noori {
    font-family: "Jameel Noori Nastaleeq", serif;
    font-size: 16px !important;
}
.rtl-text .nav ul {
    justify-content: flex-end !important;
}
.section-title {
    text-align: left;
    padding-bottom: 5px;
}
 
.section-title h5 {
    font-size: 22px;
    font-weight: bold;
    text-transform: uppercase;
    position: relative;
    color: #012970;
}
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
/* Fade transition */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1s ease;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
.nav-link.active {
    background-color: #f6f9ff !important;
    color: #174696 !important;
    font-weight: bold;
}
</style>
