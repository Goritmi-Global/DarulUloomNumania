<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Bayanaat") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{ translate("Home") }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Bayanaat") }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Index") }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <button
                    class="btn btn-success mt-3"
                    data-bs-toggle="modal"
                    data-bs-target="#updateRecordModal"
                    @click="clearFields"
                >
                    <i class="bi bi-plus-lg"></i>
                    {{ translate("New Bayanaat") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">
                        {{ translate("All Bayanaat") }}
                    </h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate("Title") }}</th>
                                <th>{{ translate("Author") }}</th>
                                <th>{{ translate("Islamic Date") }}</th>
                                <th>{{ translate("English Date") }}</th>
                                <th>{{ translate("Contents") }}</th>
                                <th>{{ translate("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(bayan, index) in bayanaat"
                                :key="bayan.id"
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ bayan.title }}</td>
                                <td>{{ bayan.author }}</td>
                                <td>{{ bayan.islamic_date }}</td>
                                <td>{{ bayan.english_date }}</td>
                                <td>
                                    <div v-html="bayan.content"></div>
                                </td>
                                <td>
                                    <button
                                        class="btn btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateRecordModal"
                                        @click="showEntry(bayan)"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button
                                        class="btn btn-sm text-danger"
                                        @click="deleteBayan(bayan.id)"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="updateRecordModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-if="form.id">
                                {{ translate("Edit Bayanaat") }}
                            </h5>
                            <h5 v-else>{{ translate("New Bayanaat") }}</h5>
                            <button
                                class="btn-close"
                                ref="closeModal"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="title" class="form-label">{{
                                            translate("Title")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="title"
                                            v-model="form.title"
                                            :class="{
                                                'invalid-bg': formErrors.title,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.title"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.title[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="author"
                                            class="form-label"
                                            >{{ translate("Author") }}</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="author"
                                            v-model="form.author"
                                            :class="{
                                                'invalid-bg': formErrors.author,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.author"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.author[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="islamic_date"
                                            class="form-label"
                                            >{{
                                                translate("Islamic Date")
                                            }}</label
                                        >

                                        <!-- <Datepicker v-model="hijriDate" calendar="islamic" /> -->

                                        <Datepicker
                                            v-model="form.islamic_date"
                                            :enable-time-picker="false"
                                            @update:modelValue="convertToHijri"
                                            autoApply
                                        />
                                        <!-- Display the Converted Hijri Date -->
                                        <!-- <input 
      type="text" 
      v-model="hijriDate" 
      readonly 
      placeholder="Hijri Date" 
    /> -->

                                        <div
                                            v-if="formErrors.islamic_date"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.islamic_date[0] }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="english_date"
                                            class="form-label"
                                            >{{
                                                translate("English Date")
                                            }}</label
                                        >
                                        <Datepicker
                                            autoApply
                                            :enable-time-picker="false"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.english_date,
                                            }"
                                            v-model="form.english_date"
                                        >
                                        </Datepicker>
                                        <div
                                            v-if="formErrors.english_date"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.english_date[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="content" class="form-label">{{
                                        translate("Content")
                                    }}</label>
                                    <br />

                                    <QuillEditor
                                        v-model:content="form.content"
                                        contentType="html"
                                        toolbar="full"
                                        theme="snow"
                                    />
                                </div>

                                <div class="mt-3">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        v-if="formStatus === 1"
                                        @click="submit"
                                    >
                                        {{ translate("Save") }}
                                    </button>
                                    <button
                                        class="btn btn-success"
                                        type="button"
                                        disabled
                                        v-else
                                    >
                                        {{ translate("Saving")
                                        }}<span
                                            class="spinner-border spinner-border-sm"
                                        ></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Master from "../Layout/Master.vue";

import axios from "axios";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import { QuillEditor } from "@vueup/vue-quill";

import "@vueup/vue-quill/dist/vue-quill.snow.css";
import moment from "moment-hijri"; // Import Hijri conversion library

export default {
    layout: Master,
    components: {
        QuillEditor,
        Datepicker,
    },
    data() {
        return {
            gregorianDate: null, // Selected Gregorian date
            hijriDate: "", // Converted Hijri date
            bayanaat: [],
            form: {
                id: "",
                title: "",
                author: "",
                islamic_date: "",
                english_date: "",
                content: "",
            },
            formErrors: {}, // Error object for form validation
            formStatus: 1, // 1 = ready, 0 = saving
        };
    },
    created() {
        this.fetchBayanaat();
    },
    methods: {
        convertToHijri(date) {
            this.form.islamic_date = date
                ? moment(date).format("iYYYY/iM/iD")
                : "";
        },
        fetchBayanaat() {
            axios
                .get(route("api.bayanaat.fetch"))
                .then((res) => {
                    this.bayanaat = res.data;
                })
                .catch((error) => {
                    console.error(error);
                    toastr.error(this.translate("Failed to fetch bayanaat."));
                });
        },
        showEntry(bayan) {
            this.form = { ...bayan };
        },
        submit() {
            this.formStatus = 0;

            // Convert the English date to MySQL format before submitting
    if (this.form.english_date) {
        this.form.english_date = moment(this.form.english_date).format("YYYY-MM-DD");
    }

    
            axios
                .post(route("api.bayanaat.store"), this.form)
                .then(() => {
                    this.formStatus = 1;
                    this.$refs.closeModal.click();
                    toastr.success(this.translate("Bayan saved successfully."));
                    this.fetchBayanaat();
                    this.clearFields();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    if (error.response && error.response.data) {
                        this.formErrors = error.response.data.errors || {};
                        toastr.error(
                            this.translate(
                                "Please correct the errors and try again."
                            )
                        );
                    } else {
                        toastr.error(
                            this.translate("An unexpected error occurred.")
                        );
                    }
                });
        },
        deleteBayan(id) {
            axios
                .delete(route("api.bayanaat.delete", id))
                .then(() => {
                    this.fetchBayanaat();
                    toastr.success(translate("Bayan deleted successfully."));
                })
                .catch((error) => {
                    console.error(error);
                    toastr.error(this.translate("Failed to delete bayan."));
                });
        },
        clearFields() {
            this.form = {
                id: "",
                title: "",
                author: "",
                islamic_date: "",
                english_date: "",
                content: "",
            };
            this.formErrors = {}; // Clear form errors
        },
    },
};
</script>
