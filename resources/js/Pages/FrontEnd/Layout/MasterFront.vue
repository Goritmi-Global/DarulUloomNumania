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
                            {{ user_language_name }}
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
        <footer
            id="footer"
            class="footer"
            :class="{
                'rtl-text':
                    $page.props.default_language === 'PK' ||
                    $page.props.default_language === 'SA',
            }"
        >
            <div class="container">
                <!-- Footer Top Section -->
                <div class="footer-top">
                    <div class="row">
                        <!-- Contact Info Section -->
                        <div class="col-lg-6 col-md-6 footer-contact">
                            <h3>
                                {{
                                    translate(
                                        "Jamia Darol Uloom Noumania Utmanzai"
                                    )
                                }}
                            </h3>
                            <p>
                                <strong>{{ translate("Phone:") }} </strong>
                                091650861<br />
                                <strong>{{ translate("Email:") }} </strong>
                                jamianumania2025@gmail.com<br />
                            </p>
                            <div class="footer-social">
                                <a
                                    href="https://facebook.com"
                                    target="_blank"
                                    class="facebook"
                                    ><i class="bi bi-facebook"></i
                                ></a>
                                <a
                                    href="https://twitter.com"
                                    target="_blank"
                                    class="twitter ms-3"
                                    ><i class="bi bi-twitter"></i
                                ></a>
                                <a
                                    href="https://instagram.com"
                                    target="_blank"
                                    class="instagram ms-3"
                                    ><i class="bi bi-instagram"></i
                                ></a>
                                <a
                                    href="https://linkedin.com"
                                    target="_blank"
                                    class="linkedin ms-3"
                                    ><i class="bi bi-linkedin"></i
                                ></a>
                            </div>
                        </div>
                        <!-- Quick Links Section -->
                        <div class="col-lg-6 col-md-6 footer-links">
                            <h4>{{ translate("Quick Links") }}</h4>
                            <ul type="none">
                                <li>
                                    <a href="/">{{ translate("Home") }} </a>
                                </li>
                                <li>
                                    <a href="/about"
                                        >{{ translate("About") }}
                                    </a>
                                </li>
                                <li>
                                    <a href="/contact"
                                        >{{ translate("Contact") }}
                                    </a>
                                </li>
                                <li>
                                    <a href="/events"
                                        >{{ translate("Events") }}
                                    </a>
                                </li>
                                <li>
                                    <a href="/student/enroll"
                                        >{{ translate("Enroll") }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Newsletter Section -->
                        <!-- <div class="col-lg-4 col-md-6 footer-newsletter">
                            <h4>Join Our Newsletter</h4>
                            <p>Get updates on events and announcements.</p>
                            <form action="#" method="post">
                                <input
                                    type="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    required
                                />
                                <button type="submit">Subscribe</button>
                            </form>
                        </div> -->
                    </div>
                </div>

                <!-- Footer Bottom Section -->
                <div class="footer-bottom">
                    <p>
                        {{ translate("&copy; Copyright") }}
                        <strong
                            ><span
                                >{{
                                    translate(
                                        "Jamia Darol Uloom Noumania Utmanzai"
                                    )
                                }}
                            </span></strong
                        >{{ translate(". All Rights Reserved | Designed by") }}
                        <a href="https://goritmi.co.uk"
                            >{{ translate("Goritim Ltd") }}
                        </a>
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

.footer {
    background: #174696 !important;
    padding: 10px;
    color: white !important;
    font-size: 14px;
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

.footer {
    width: 100%;
    background: white;
    font-size: 14px;
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
.footer-top {
    margin-bottom: 30px;
}

.footer-social a {
    font-size: 20px;
    color: white;
    margin: 0 10px;
    transition: color 0.3s ease;
}

.footer-social a:hover {
    color: #f8d4d4;
}

.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links ul li {
    margin: 5px 0;
}

.footer-links ul li a {
    color: white;
    text-decoration: none;
    font-weight: 500;
}

.footer-links ul li a:hover {
    color: #f8d4d4;
}

.footer-newsletter form input {
    padding: 10px;
    width: 70%;
    border: 1px solid white;
    border-radius: 5px;
    margin-right: 10px;
}

.footer-newsletter form button {
    padding: 10px 20px;
    background-color: #174696;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.footer-newsletter form button:hover {
    background-color: #f8d4d4;
    color: #174696;
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
</style>
