<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Islamic Names") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">{{ translate("Home") }}</a></li>
                        <li class="breadcrumb-item">{{ translate("Islamic Names") }}</li>
                        <li class="breadcrumb-item active">{{ translate("Index") }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#updateRecordModal" @click="clearFields">
                    <i class="bi bi-plus-lg"></i> {{ translate("New Islamic Name") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">{{ translate("All Islamic Names") }}</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate("Name") }}</th>
                                <th>{{ translate("Meaning") }}</th>
                                <th>{{ translate("Roman") }}</th>
                                <th>{{ translate("Inflection") }}</th>
                                <th>{{ translate("Type") }}</th>
                                <th>{{ translate("Reference") }}</th>
                                <th>{{ translate("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(name, index) in islamicNames" :key="name.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ name.name }}</td>
                                <td>{{ name.meaning }}</td>
                                <td>{{ name.roman }}</td>
                                <td>{{ name.inflection }}</td>
                                <td>{{ name.type }}</td>
                                <td>{{ name.reference }}</td>
                                <td>
                                    <button class="btn btn-sm" @click="showEntry(name.id)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm text-danger" @click="deleteName(name.id)">
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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-if="form.id">{{ translate("Edit Islamic Name") }}</h5>
                            <h5 v-else>{{ translate("New Islamic Name") }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input v-model="form.name" placeholder="Name" class="form-control" />
                            <input v-model="form.meaning" placeholder="Meaning" class="form-control" />
                            <input v-model="form.roman" placeholder="Roman" class="form-control" />
                            <input v-model="form.inflection" placeholder="Inflection" class="form-control" />
                            <input v-model="form.type" placeholder="Type" class="form-control" />
                            <textarea v-model="form.reference" placeholder="Reference" class="form-control"></textarea>

                            <button class="btn btn-success mt-2" @click="submit">{{ translate("Save") }}</button>
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

export default {
    layout: Master,
    data() {
        return {
            islamicNames: [],
            form: { id: "", name: "", meaning: "", roman: "", inflection: "", type: "", reference: "" }
        };
    },
    created() { this.fetchIslamicNames(); },
    methods: {
        fetchIslamicNames() { axios.get(route("api.islamic-names.fetch")).then(res => this.islamicNames = res.data); },
        showEntry(id) { axios.get(route("api.islamic-names.show", id)).then(res => this.form = res.data); },
        submit() { axios.post(route("api.islamic-names.store"), this.form).then(() => this.fetchIslamicNames()); },
        deleteName(id) { axios.delete(route("api.islamic-names.delete", id)).then(() => this.fetchIslamicNames()); },
        clearFields() { this.form = { id: "", name: "", meaning: "", roman: "", inflection: "", type: "", reference: "" }; }
    }
};
</script>
