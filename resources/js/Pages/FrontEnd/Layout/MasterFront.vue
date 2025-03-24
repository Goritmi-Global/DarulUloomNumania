<template>
    <div class="main">
        <header
            id="header"
            class="header fixed-top d-flex align-items-center justify-content-between px-3"
        >
            <a href="/" class="logo d-flex align-items-center">
                <img src="/images/logo.png" alt="Logo" />
            </a>

            <nav class="nav">
                <ul class="d-flex align-items-center">
                    <!-- Language Dropdown -->
                    <li
                        class="nav-item dropdown languages"
                        v-if="languages && languages.length"
                    >
                        <a
                            class="nav-link dropdown-toggle"
                            href="javascript:void(0)"
                            id="languageDropdown"
                            role="button"
                            @click="toggleLangMenu"
                        >
                            {{ user_language_name }}
                        </a>
                        <ul
                            v-if="langMenuOpen"
                            class="dropdown-menu dropdown-menu-end c-global-radius"
                            aria-labelledby="languageDropdown"
                        >
                            <li
                                v-for="(language, index) in languages"
                                :key="index"
                                :class="[
                                    language.code ==
                                    $page.props.default_language
                                        ? 'lang-active'
                                        : '',
                                ]"
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
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/"
                            :class="{ active: isActive('/') }"
                            >{{ translate("Home") }}</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/about"
                            :class="{ active: isActive('/about') }"
                            >{{ translate("About") }}</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/contact"
                            :class="{ active: isActive('/contact') }"
                            >{{ translate("Contact") }}</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/events"
                            :class="{ active: isActive('/events') }"
                            >{{ translate("Events") }}</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/ask/question"
                            :class="{ active: isActive('/ask/question') }"
                            >{{ translate("Ask Question") }}</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/student/enroll"
                            :class="{ active: isActive('/student/enroll') }"
                            >{{ translate("Enroll") }}</a
                        >
                    </li>
                </ul>
            </nav>

            <i class="bi bi-list mobile-menu" @click="toggleMenu"></i>
        </header>

        <!-- Mobile Navigation -->
        <nav v-if="menuOpen" class="mobile-nav">
            <ul>
                <li>
                    <a href="/" :class="{ active: isActive('/') }">{{
                        translate("Home")
                    }}</a>
                </li>
                <li>
                    <a href="/about" :class="{ active: isActive('/about') }">{{
                        translate("About")
                    }}</a>
                </li>
                <li>
                    <a
                        href="/contact"
                        :class="{ active: isActive('/contact') }"
                        >{{ translate("Contact") }}</a
                    >
                </li>
                <li>
                    <a
                        href="/events"
                        :class="{ active: isActive('/events') }"
                        >{{ translate("Events") }}</a
                    >
                </li>
                <li>
                    <a
                        href="/student/enroll"
                        :class="{ active: isActive('/student/enroll') }"
                        >{{ translate("Enroll") }}</a
                    >
                </li>
            </ul>
        </nav>

        <slot></slot>

        <footer
            class="footer d-flex flex-column align-items-center py-3 bg-light"
        >
            <div class="footer-content text-center">
                <p class="mb-1">
                    &copy; {{ new Date().getFullYear() }}
                    <strong>Darul Uloom</strong>. All Rights Reserved.
                </p>
                <p class="mb-2">
                    Designed by
                    <a
                        href="https://goritmi.co.uk"
                        target="_blank"
                        class="text-primary"
                        >Goritmi Ltd</a
                    >
                </p>
            </div>
            <div class="footer-social d-flex justify-content-center">
                <a href="#" class="mx-2 text-primary"
                    ><i class="bi bi-facebook"></i
                ></a>
                <a href="#" class="mx-2 text-primary"
                    ><i class="bi bi-twitter"></i
                ></a>
                <a href="#" class="mx-2 text-primary"
                    ><i class="bi bi-instagram"></i
                ></a>
                <a href="#" class="mx-2 text-primary"
                    ><i class="bi bi-linkedin"></i
                ></a>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    created() {
        this.fatchLanguages();
    },
    data() {
        return {
            form: {
                default_language: this.$page.props.user_language ?? "",
            },
            menuOpen: false,
            langMenuOpen: false,
            user_language_name: "",
            languages: [],
        };
    },

    methods: {
        isActive(route) {
            return window.location.pathname === route;
        },
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },
        toggleLangMenu() {
            this.langMenuOpen = !this.langMenuOpen;
        },
        fatchLanguages() {
            axios
                .get(route("api.front_end.languages.data"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.languages = response.data;
                    this.user_language_name =
                        response.data.find(
                            (p) => p.code === this.$page.props.default_language
                        )?.name || "Select Language";
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        changeLang(code) {
            let formData = new FormData();
            formData.append("default_language", code);

            axios
                .post(route("api.user.default.language"), formData)
                .then(() => {
                    window.location.reload();
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
    },
};
</script>

<style>
@import url("public/backend/assets/vendor/bootstrap/css/bootstrap.min.css");
/* Primary Color */
:root {
    --primary-color: #012970;
}

#main {
    font-family: "Playfair Display", serif !important;

    font-weight: 700 !important;
}
.header {
    background: #012970;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo img {
    height: 40px;
    margin-right: 10px;
}

.brand {
    color: #fff;
    font-weight: bold;
    font-size: 18px;
}

.nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flow;
    color: #012970 !important;
}

.nav ul li {
    margin: 0 15px;
}

.lang-active a {
    color: white !important;
}
.lang-active a,
.lang-active a:hover {
    /* background-color: white !important; */
    color: white !important;
    background-color: #012970 !important;
}

.languages ul a {
    color: #012970 !important;
    text-decoration: none !important;
    font-weight: 500 !important;
}
.nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
}

.nav ul li a:hover {
    color: #f8d4d4;
}

.mobile-menu {
    display: none;
    font-size: 24px;
    color: #fff;
    cursor: pointer;
}

.mobile-nav {
    background: #012970;
    padding: 10px 0;
}

.mobile-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
}

.mobile-nav ul li {
    padding: 10px 0;
}

.mobile-nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
}

.footer {
    background: #f8f9fa;
    padding: 10px;
    text-align: center;
    font-size: 14px;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .nav {
        display: none;
    }
    .mobile-menu {
        display: block;
    }
}
.bg-primary {
    background: #012970 !important;
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

.footer {
    width: 100%;
    background: #f8f9fa;
    text-align: center;
    font-size: 14px;
    margin-top: 20px;
}
.footer-content p {
    margin: 0;
    color: #012970;
}
.footer-social a {
    font-size: 18px;
    color: #012970;
    text-decoration: none;
}
.footer-social a:hover {
    color: #f8d4d4;
}
.multiselect-option.is-selected {
    background: #012970 !important;
    color: var(--ms-option-color-selected, #fff);
}
.multiselect-option.is-selected.is-pointed {
    background: #012970 !important;
    color: var(--ms-option-color-selected, #fff);
}
.nav ul li {
    height: 100%; /* Ensure the list item takes full navbar height */
}

.nav ul li a.active {
    background-color: #fff;
    color: #012970 !important;
    font-weight: bold;
    display: flex;
    align-items: center;
    height: 100%;
    padding: 0 15px;
    border-radius: 0;
}
</style>
