<template>
    <div v-if="loading" class="preloader">
        <transition name="fade">
            <div class="loader-wrapper">
                <img
                    :src="'/images/frontlogo.png'"
                    alt="Goritmi Logo"
                    class="logo-bounce mb-2"
                    width="120"
                />
                <h1 class="display-4 c-font-family">
                    {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                </h1>
                <p class="loader-text text-center">
                    <span></span>
                    <span></span>
                    <span></span>
                </p>
                <!-- <p style="color: red;">Coming Soon</p> -->
            </div>
        </transition>
    </div>

    <div
        v-else
        class="main"
        :class="{
            'c-jameel-noori':
                $page.props.default_language === 'PK' ||
                $page.props.default_language === 'SA',
        }"
    >
        <header
            id="header"
            class="header fixed-top d-flex align-items-center justify-content-between px-3"
        >
            <a
                href="/"
                class="logo d-flex align-items-center text-decoration-none"
            >
                <img
                    :src="'/images/frontlogo.png'"
                    alt="Goritmi Logo"
                    class="logo-bounce mb-2"
                />
                <h4 class="text-white">
                    {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                </h4>
            </a>

            <!-- test {{ user_language_name }} / {{ $page.props.default_language }} -->

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
                            {{ translate(user_language_name) }}
                        </a>
                        <ul
                            v-if="langMenuOpen"
                            class="dropdown-menu dropdown-menu-end c-global-radius"
                            aria-labelledby="languageDropdown"
                            style="border-radius: 0px !important"
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
                    <!-- <li class="nav-item">
                        <a
                            class="nav-link"
                            href="/events"
                            :class="{ active: isActive('/events') }"
                            >{{ translate("Events") }}</a
                        >
                    </li> -->
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
                <!-- <li>
                    <a
                        href="/events"
                        :class="{ active: isActive('/events') }"
                        >{{ translate("Events") }}</a
                    >
                </li> -->
                <li>
                    <a
                        href="/student/enroll"
                        :class="{ active: isActive('/student/enroll') }"
                        >{{ translate("Enroll") }}</a
                    >
                </li>
                <li
                    class="nav-item dropdown languages bg-warning"
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
                        aria-labelledby="languageDropdown"
                        style="border-radius: 0px !important"
                    >
                        <li
                            v-for="(language, index) in languages"
                            :key="index"
                            :class="[
                                language.code == $page.props.default_language
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
            </ul>
        </nav>
        <div
            :class="{
                'rtl-text':
                    $page.props.default_language === 'PK' ||
                    $page.props.default_language === 'SA',
            }"
        >
            <slot></slot>
        </div>

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer text-white">
            <div class="container">
                <!-- Footer Top -->
                <div class="row py-4">
                    <!-- Logo and Institute Name -->
                    <div
                        class="col-lg-3 col-md-6 mb-4 mb-lg-0 text-center text-lg-start"
                    >
                        <img
                            :src="'/images/frontlogo.png'"
                            alt="Logo"
                            width="180"
                            class="mb-3 logo-bounce"
                        />
                        <h5 class="fw-bold">
                            {{
                                translate("Jamia Darol Uloom Noumania Utmanzai")
                            }}
                        </h5>
                        <p class="small">
                            {{
                                translate(
                                    "Spreading knowledge, nurturing values."
                                )
                            }}
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-3 col-md-6 mt-5 mb-lg-0">
                        <h6 class="fw-bold mb-3">
                            {{ translate("Quick Links") }}
                        </h6>
                        <ul class="list-unstyled">
                            <li>
                                <a href="/" class="footer-link">{{
                                    translate("Home")
                                }}</a>
                            </li>
                            <li>
                                <a href="/about" class="footer-link">{{
                                    translate("About")
                                }}</a>
                            </li>
                            <li>
                                <a href="/contact" class="footer-link">{{
                                    translate("Contact")
                                }}</a>
                            </li>
                            <li>
                                <a href="/events" class="footer-link">{{
                                    translate("Events")
                                }}</a>
                            </li>
                            <li>
                                <a href="/student/enroll" class="footer-link">{{
                                    translate("Enroll")
                                }}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6 mt-5 mb-lg-0">
                        <h6 class="fw-bold mb-3">
                            {{ translate("Contact Info") }}
                        </h6>
                        <p class="mb-1">
                            <i class="bi bi-telephone-fill me-2"></i>
                            <strong>{{ translate("Phone") }}:</strong> 091650861
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <strong>{{ translate("Email") }}:</strong>
                            jamianumania2025@gmail.com
                        </p>
                    </div>

                    <!-- Social Links -->
                    <div
                        class="col-lg-3 col-md-6 mt-5 text-center text-lg-start"
                    >
                        <h6 class="fw-bold mb-3 ms-3">
                            {{ translate("Follow Us") }}
                        </h6>
                        <div>
                            <a
                                href="https://play.google.com/store/apps/details?id=com.jamianumaniapak.numania"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <img
                                    src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
                                    alt="Get it on Google Play"
                                    style="height: 60px"
                                />
                            </a>
                        </div>
                        <div
                            class="d-flex justify-content-center justify-content-lg-start ms-3"
                        >
                            <a
                                href="https://facebook.com"
                                target="_blank"
                                class="me-3 social-icon"
                            >
                                <i class="bi bi-facebook"></i>
                            </a>

                            <a
                                href="https://youtueb.com"
                                target="_blank"
                                class="me-3 social-icon"
                            >
                                <i class="bi bi-youtube"></i>
                            </a>
                            <br />
                        </div>
                        
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div
                    class="text-center pt-3 border-top border-light-subtle mt-4"
                >
                    <p class="mb-0 small">
                        {{ translate("&copy; Copyright") }}
                        <strong>{{
                            translate("Jamia Darol Uloom Noumania Utmanzai")
                        }}</strong>
                        {{ translate(". All Rights Reserved | Designed by") }}
                        <a
                            href="https://goritmi.co.uk"
                            class="text-white text-decoration-underline"
                            >{{ translate("Goritim Ltd") }}</a
                        >
                    </p>
                </div>
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

            loading: true,
            dots: "",
            dotInterval: null,
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

        document.addEventListener("click", this.handleOutsideClick);

        // preloader
        let preloader = this.$refs.preloader;
        if (preloader) {
            window.addEventListener("load", () => {
                preloader.remove();
            });
        }
        window.addEventListener("scroll", this.handleScroll);

        // Animate dots
        let dotCount = 0;
        this.dotInterval = setInterval(() => {
            dotCount = (dotCount + 1) % 4;
            this.dots = ".".repeat(dotCount);
        }, 100);

        setTimeout(() => {
            clearInterval(this.dotInterval);
            this.loading = false;
        }, 2000);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleOutsideClick);
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
@import url("public/backend/assets/vendor/bootstrap-icons/bootstrap-icons.css");
@import url("public/backend/assets/vendor/boxicons/css/boxicons.min.css");
@import url("public/backend/assets/vendor/remixicon/remixicon.css");
@import url("public/backend/assets/vendor/simple-datatables/style.css");

@import url("public/backend/assets/vendor/bootstrap-icons/bootstrap-icons.css");

@import "toastr";
@import url("public/backend/assets/vendor/bootstrap/css/bootstrap.min.css");

@import url("./../../../../css/app.css");

/* Primary Color */
:root {
    --primary-color: #174696;
}

.c-font-family {
    font-family: "Jameel Noori Nastaleeq", serif;
    color: #174696;
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

#main {
    /* font-family: "Playfair Display", serif !important; */

    font-weight: 700 !important;
}
.header {
    background: #174696;
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
    color: #174696 !important;
}

/* .nav ul li {
    margin: 0 15px;
} */

.languages .lang-active a {
    color: white !important;
}
.lang-active a,
.lang-active a:hover {
    /* background-color: white !important; */
    color: white !important;
    background-color: #174696 !important;
}

.nav-link:focus {
    color: white;
}

.languages ul a {
    color: black !important;
    text-decoration: none !important;
    font-weight: 500 !important;
}
.nav ul li a {
    color: white;
    text-decoration: none;
}

.nav ul li a:hover {
    color: white;
    font-weight: bold;
}

.mobile-menu {
    display: none;
    font-size: 24px;
    color: white;
    cursor: pointer;
}

.mobile-nav {
    background: #174696;
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
    color: white;
    text-decoration: none;
    font-size: 18px;
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
    background: #174696 !important;
}

.btn-success {
    background-color: #174696 !important;
    border-color: #174696 !important;
}

.btn-success:hover {
    background-color: #174696 !important;
    border-color: #174696 !important;
}

.btn-success:active {
    background-color: #174696 !important;
    border-color: #174696 !important;
}

.btn-success:focus {
    color: #fff !important;
    box-shadow: none !important;
}
.toast-success {
    background-color: #174696 !important;
}
.theme-text-color {
    color: #174696 !important;
    font-weight: bold;
}
.theme-bg-color {
    background-color: #174696 !important;
}
.text-primary {
    color: #174696 !important;
}

.multiselect-option.is-selected {
    background: #174696 !important;
    color: var(--ms-option-color-selected, #fff);
}
.multiselect-option.is-selected.is-pointed {
    background: #174696 !important;
    color: var(--ms-option-color-selected, #fff);
}
.nav ul li {
    height: 100%; /* Ensure the list item takes full navbar height */
}

.nav ul li a.active {
    font-weight: bold;
}

/* Loader Styles */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e6ecf3, #f7f9fc);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.loader-wrapper {
    text-align: center;
}

/* Bounce animation on the logo */
.logo-bounce {
    animation: logoBounce 1.2s infinite ease-in-out;
}

.logo-bounce {
    animation: logoZoom 3.8s ease-in-out infinite;
}

@keyframes logoZoom {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0.5;
    }
    to {
        opacity: 1;
    }
}
.loader-text {
    font-size: 20px;
    color: #174696;
    letter-spacing: 1px;
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

/* Dot style */
.loader-text span {
    width: 10px;
    height: 10px;
    background-color: #174696;
    border-radius: 50%;
    display: inline-block;
    animation: bounceDot 1.2s infinite ease-in-out;
}

/* Add delays for each dot using nth-child */
.loader-text span:nth-child(2) {
    animation-delay: 0.2s;
}
.loader-text span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes bounceDot {
    0%,
    80%,
    100% {
        transform: scale(0);
        opacity: 0.3;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

/* footer sytles */
.footer {
    background-color: #174696;
    font-size: 15px;
    padding-top: 40px;
    padding-bottom: 20px;
}
.footer-link {
    color: white;
    text-decoration: none;
    display: block;
    margin-bottom: 6px;
    transition: color 0.3s;
}
.footer-link:hover {
    color: #f8d4d4;
    text-decoration: underline;
}
.social-icon {
    color: white;
    font-size: 20px;
    transition: transform 0.3s, color 0.3s;
}
.social-icon:hover {
    color: #f8d4d4;
    transform: scale(1.2);
}

.lang-dropdown {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(23, 70, 150, 0.2);
    width: 200px;
    margin: 0 auto;
    padding: 10px 0;
    z-index: 999;
}

.lang-dropdown .dropdown-item {
    color: #174696 !important;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
    text-align: center;
}

.lang-dropdown .dropdown-item:hover {
    background-color: #174696;
    color: white !important;
    font-weight: bold;
}

.lang-active .dropdown-item {
    background-color: #174696 !important;
    color: white !important;
    font-weight: bold;
    /* border-radius: 6px; */
}
</style>
