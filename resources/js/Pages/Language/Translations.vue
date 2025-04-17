<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1>{{ translate("Translations") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')"
                                >{{ translate("Home") }}
                            </Link>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Languages") }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Translations") }}
                        </li>
                    </ol>
                </nav>
            </div>
            <Link class="btn btn-success" :href="route('languages')"
                >{{ translate("Go to Languages") }}
            </Link>
        </div>

        <!-- End Page Title -->
        <section class="section">
            <div class="card">
                <div class="card-body pt-4">
                    <div class="row mb-4 mb-md-0">
                        <div class="col-md">
                            <h5 class="card-title">{{ language.name }}</h5>
                        </div>
                        <div class="col-md d-flex align-items-center">
                            <input
                                type="text"
                                v-on:input="searchTranslations"
                                v-model="searchForm.search"
                                :placeholder="translate('Search Translations')"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="45%">
                                    {{ translate("Key") }}
                                </th>
                                <th width="45%">{{ translate("Value") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(
                                    translation, index
                                ) in translations.data"
                                :key="translation.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ translation.lang_key }}</td>
                                <td class="d-flex">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="
                                            form.values[translation.lang_key]
                                        "
                                    />
                                    <button
                                        type="button"
                                        class="btn btn-sm fs-6"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteTranslationModal"
                                        :title="translate('Delete')"
                                        @click="passDeleteId(translation.id)"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav
                        aria-label="Page navigation example"
                        v-if="
                            pagination.next_page_url || pagination.prev_page_url
                        "
                    >
                        <ul class="pagination">
                            <li
                                class="page-item"
                                v-for="(links, index) in pagination.links"
                                :key="index"
                                :class="[
                                    { active: links.active },
                                    {
                                        disabled:
                                            index == 0 &&
                                            !pagination.prev_page_url,
                                    },
                                    {
                                        disabled:
                                            index ==
                                                pagination.links.length - 1 &&
                                            !pagination.next_page_url,
                                    },
                                ]"
                            >
                                <a
                                    v-if="
                                        index == 0 ||
                                        index == pagination.links.length - 1
                                    "
                                    class="page-link"
                                    href="#"
                                    @click="loadTranslations(links.url)"
                                    v-html="links.label"
                                ></a>
                                <a
                                    v-else
                                    class="page-link"
                                    href="#"
                                    @click="loadTranslations(links.url)"
                                    >{{ links.label }}</a
                                >
                            </li>
                        </ul>
                    </nav>

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
                    <!-- Floating Labels Form -->
                </div>
            </div>
        </section>
        <!-- translation delete Modal -->
        <div class="modal fade" id="deleteTranslationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="block-content text-center p-4">
                            <h2>
                                {{ translate("Are you sure?") }}
                            </h2>

                            <button
                                type="button"
                                class="btn btn-sm btn-success me-2"
                                data-bs-dismiss="modal"
                                @click="deleteThisTranslation"
                            >
                                {{ translate("Yes, delete it!") }}
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-dark"
                                data-bs-dismiss="modal"
                            >
                                {{ translate("Close") }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End #main -->
</template>

<script>
import Master from "../Layout/Master.vue";
export default {
    layout: Master,
    props: ["language_id"],
    created() {
        this.getLanguage();
        this.loadTranslations();
    },
    data() {
        return {
            form: {
                language_id: this.language_id,
                values: {},
            },
            // formErrors : [],
            language: [],
            translations: [],
            pagination: {},

            searchForm: {
                language_id: this.language_id,
                search: "",
            },
            formStatus: 1,
        };
    },
    methods: {
        getLanguage() {
            axios
                .get(route("api.languages.show", this.language_id), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.language = response.data;
                    // this.loadTranslations(this.language.id);
                });
        },
        loadTranslations(page_url) {
            let formData = new FormData();
            page_url = page_url || route("api.translations.show");
            formData.append("language_id", this.language_id);
            axios
                .post(page_url, formData, {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    // clearing this values object
                    this.form.values = {};
                    this.translations = response.data;
                    response.data.data.forEach((i) => {
                        this.form.values[i.lang_key] = i.lang_value;
                    });
                    this.makePagination(response.data);
                });
        },

        makePagination(res) {
            let pagination = {
                links: res.links,
                current_page: res.current_page,
                last_page: res.last_page,
                next_page_url: res.next_page_url,
                prev_page_url: res.prev_page_url,
            };
            this.pagination = pagination;
        },

        submit() {
            this.formStatus = 0;
            axios
                .post(route("api.translations.store"), this.form, {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((data) => {
                    this.formStatus = 1;
                    toastr.success(
                        this.translate("Translations added successfully")
                    );
                })
                .catch((error) => {
                    this.formStatus = 1;
                    toastr.error(error.response.data.message);
                });
        },
        searchTranslations() {
            axios
                .post(route("api.translations.search"), this.searchForm, {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    // clearing this values object
                    this.form.values = {};
                    this.translations = response.data;
                    response.data.data.forEach((i) => {
                        this.form.values[i.lang_key] = i.lang_value;
                    });
                    this.makePagination(response.data);
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
        passDeleteId(id) {
            this.deleteId = id;
        },
        deleteThisTranslation() {
            axios
                .delete(route("api.translation.delete", this.deleteId), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then(() => {
                    toastr.success(
                        this.translate("Translation deleted successfully")
                    );
                    this.loadTranslations();
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
    },
};
</script>

<style>
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
.pagination .page-item.active .page-link {
    background-color: #012970 !important;
    border-color: #012970 !important;
    z-index: 3;
    color: white !important;
}
.pagination .page-link {
    color: #012970 !important;
}
</style>
