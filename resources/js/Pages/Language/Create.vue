<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1>{{ translate("Add New Language") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <Link
                            class="breadcrumb-item"
                            :href="route('dashboard')"
                            >{{ $page.props.website_name }}</Link
                        >
                        <li class="breadcrumb-item active">
                            {{ translate("Add New Language") }}
                        </li>
                    </ol>
                </nav>
            </div>
            <Link class="btn btn-success" :href="route('languages')">
                {{ translate("Go to Languages") }}</Link
            >
        </div>

        <!-- End Page Title -->
        <section class="section">
            <div class="card">
                <div class="card-body pt-4">
                    <h5 class="card-title">
                        {{ translate("Add New Language") }}
                    </h5>

                    <!-- Floating Labels Form -->
                    <form @submit.prevent="submit">
                        <div class="row g-3">
                            <div class="col-12 col-md-12">
                                <label>{{ translate("Choose Status") }}</label>
                                <br />
                                <div class="d-inline-block me-2">
                                    {{ translate("OFF") }}
                                </div>
                                <div
                                    class="form-check form-switch d-inline-block"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :class="{
                                            'invalid-bg': formErrors.status,
                                        }"
                                        v-model="form.status"
                                        checked
                                        :disabled="
                                            form.code === 'US' &&
                                            form.status == 1
                                        "
                                    />
                                    <label class="form-check-label">{{
                                        translate("ON")
                                    }}</label>
                                </div>

                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.status"
                                >
                                    {{ formErrors.status[0] }}
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div>
                                    <label for="name">{{
                                        translate("Name")
                                    }}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        :class="{
                                            'invalid-bg': formErrors.name,
                                        }"
                                        v-model="form.name"
                                    />
                                </div>
                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.name"
                                >
                                    {{ formErrors.name[0] }}
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="country">{{
                                    translate("Country")
                                }}</label>
                                <Multiselect
                                    v-model="form.code"
                                    :options="code_options"
                                    :searchable="true"
                                    :class="{ 'invalid-bg': formErrors.status }"
                                    :placeholder="translate('Choose country')"
                                />
                                <div
                                    class="invalid-feedback animated fadeIn"
                                    v-if="formErrors.code"
                                >
                                    {{ formErrors.code[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button
                                type="button"
                                @click="submit"
                                class="btn btn-success"
                                v-if="formStatus == 1"
                            >
                                {{ translate("Save") }}
                            </button>
                            <button
                                class="btn btn-success"
                                type="button"
                                disabled
                                v-else
                            >
                                {{ translate("Save") }}
                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                ></span>
                            </button>
                        </div>
                    </form>
                    <!-- End floating Labels Form -->
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->
</template>

<script>
import Master from "../Layout/Master.vue";
import Multiselect from "@vueform/multiselect";
export default {
    layout: Master,
    components: {
        Multiselect,
    },
    // props: ["countries"],
    created() {
        this.loadCountries();
    },
    data() {
        return {
            form: {
                name: "",
                code: "",
                status: "",
            },
            // code_options: this.countries,
            code_options: [],
            formErrors: [],
            formStatus: 1,
        };
    },
    methods: {
        loadCountries() {
            axios
                .get(route("api.countries.code.pluck"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.code_options = response.data;
                });
        },
        submit() {
            this.formStatus = 0;
            let formData = new FormData();

            formData.append("name", this.form.name ?? "");
            formData.append("code", this.form.code ?? "");
            if (this.form.status == "") {
                formData.append("status", false);
            } else {
                formData.append("status", this.form.status);
            }
            axios
                .post(route("api.languages.store"), formData, {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((data) => {
                    // this.formStatus = 1;
                    toastr.success(
                        this.translate("Language added successfully")
                    );
                    this.$inertia.get(route("languages"));
                })
                .catch((error) => {
                    this.formStatus = 1;
                    toastr.error(error.response.data.message);
                    if (error.response.data.errors) {
                        this.formErrors = error.response.data.errors;
                    }
                });
        },
    },
};
</script>

<style>
@import "@vueform/multiselect/themes/default.css";

.c-file-padding {
    padding: 1rem 0.75rem !important;
}
.invalid-feedback {
    display: block !important;
}
/* .invalid-bg {
    border-color: #f8d4d4 !important;
    background-color: #f8d4d4 !important;
} */

#CodeSelect {
    min-height: 58px;
}
.card {
    overflow: visible;
}
</style>
