<template>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&family=Nunito:wght@300;400;600&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    />

<main :class="[$page.props.default_language === 'UR' ? 'rtl-text' : '', 'bg-template', 'position-relative']">
        <img :src="'/images/hero-image.jpg'" alt="background" class="hero-bg-image" />
        <div class="container position-relative z-1">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card shadow-lg rounded-4 border-0">
                            <div class="text-center pt-4">
                                <a :href="route('/')">
                                    <img :src="'/images/frontlogo.png'" height="100" alt="Jamia Nounia Logo" class="logo-bounce mb-2" />
                                </a>
                            </div>
                            <div class="card-body px-4">
                                <h5 class="card-title text-center fs-4 mb-3">{{ translate("Login to Your Account") }}</h5>
                                <form @submit.prevent="submit" class="row g-3">
                                    <div class="col-12">
                                        <label for="email" class="form-label">{{ translate("Email") }}</label>
                                        <input
                                            id="email"
                                            type="email"
                                            v-model="form.email"
                                            :class="['form-control', { 'is-invalid': formErrors.email }]"
                                            :placeholder="translate('Enter your email')"
                                            autocomplete="current-email"
                                        />
                                        <div class="invalid-feedback" v-if="formErrors.email">{{ formErrors.email[0] }}</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">{{ translate("Password") }}</label>
                                        <input
                                            id="password"
                                            type="password"
                                            v-model="form.password"
                                            :class="['form-control', { 'is-invalid': formErrors.password }]"
                                            :placeholder="translate('Enter your password')"
                                            autocomplete="current-password"
                                        />
                                        <div class="invalid-feedback" v-if="formErrors.password">{{ formErrors.password[0] }}</div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100" :disabled="formStatus !== 1">
                                            <span v-if="formStatus === 1">{{ translate('Login') }}</span>
                                            <span v-else>
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                {{ translate('Logging in...') }}
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center text-white mt-4 small">
                            &copy; {{ new Date().getFullYear() }} {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>



<script>
import axios from "axios";
export default {
    props: ["message"],
    created() {
        this.messagePrint();
    },
    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                role: "admin",
                remember: false,
            }),
            formErrors: [],
            formStatus: 1,
        };
    },
    methods: {
        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.login"), this.form)
                .then((response) => {
                    if (response.data.message) {
                        toastr.success(response.data.message);
                    }
                    this.form.reset();
                    this.$inertia.get(route("dashboard"));
                })
                .catch((error) => {
                    this.formStatus = 1;
                    // this.form.reset("password");
                    toastr.error(error.response.data.message);
                    if (error.response.data.errors) {
                        this.formErrors = error.response.data.errors;
                    }
                });
        },
        messagePrint() {
            if (this.message) {
                toastr.success(this.message);
            }
        },
    },
    mounted() {
        // detect when the user navigates back
        window.addEventListener("popstate", () => {
            setTimeout(() => {
                window.location.href = route("/");
            }, 1000);
        });

        // add a new entry to the browser's history
        history.pushState(null, null, location.href);
    },
};
</script>

<style scope>
@import url("public/backend/assets/vendor/bootstrap/css/bootstrap.min.css");
@import url("public/backend/assets/vendor/bootstrap-icons/bootstrap-icons.css");
@import url("public/backend/assets/vendor/boxicons/css/boxicons.min.css");
@import url("public/backend/assets/vendor/remixicon/remixicon.css");
@import url("public/backend/assets/vendor/simple-datatables/style.css");
@import url("public/backend/assets/css/style.css");
@import url("public/backend/assets/css/custom.css");
@import "toastr";

.hero-bg-image {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    object-fit: cover;
    z-index: 0;
    opacity: 0.3;
}

.bg-template {
    background: #fff;
    overflow: hidden;
}

.card {
    background: #fff;
    border-radius: 1rem;
}

.btn-primary {
    background-color: #012970;
    border-color: #012970;
}

.btn-primary:hover {
    background-color: #011a50;
    border-color: #011a50;
}

.is-invalid {
    border-color: #dc3545;
    background-color: #f8d7da;
}

</style>
