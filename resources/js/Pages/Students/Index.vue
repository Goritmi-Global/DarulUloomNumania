<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">Enrolled</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a :href="route('dashboard')">PIMMS</a>
                        </li>
                        <li class="breadcrumb-item">Students</li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol>
                </nav>
            </div>
            <div>
                <Link
                    :href="route('student.create')"
                    class="btn btn-success mt-3"
                >
                    <i class="bi bi-plus-lg"></i> Enroll Student
                </Link>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">All Students</h5>

                    <!-- Table with stripped rows -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Reg #</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Program</th>
                                <th scope="col">Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(student, index) in Students"
                                :key="student.id"
                            >
                                <th scope="row">{{ index + 1 }}</th>
                                <td>
                                    <a
                                        class="theme-text-color"
                                        :href="
                                            route('student.details', student.id)
                                        "
                                    >
                                        {{ student.name }}
                                    </a>
                                </td>
                                <td>{{ student.registration_number }}</td>
                                <td>{{ student.gender }}</td>
                                <td>{{ student.programName }}</td>
                                <td> <ImageZooming
                                    v-if="student.image"
                                    :file="student.image"
                                    :width="50"
                                /></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Master from "../Layout/Master.vue";
import axios from "axios";

export default {
    layout: Master,

    created() {
        this.fetchStudents();
    },
    data() {
        return {
            Students: [],
        };
    },
    methods: {
        fetchStudents() {
            axios
                .get(route("api.student.fetch"), {
                    headers: {
                        Authorization: "Bearer " + this.$page.props.auth_token,
                    },
                })
                .then((response) => {
                    this.Students = response.data;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
    },
};
</script>

<style lang="scss">
@import "@vueform/multiselect/themes/default.css";
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
</style>
