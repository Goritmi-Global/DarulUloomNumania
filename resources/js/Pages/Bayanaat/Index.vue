<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Bayanaat") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">{{ translate("Home") }}</a></li>
                        <li class="breadcrumb-item">{{ translate("Bayanaat") }}</li>
                        <li class="breadcrumb-item active">{{ translate("Index") }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#updateRecordModal" @click="clearFields">
                    <i class="bi bi-plus-lg"></i> {{ translate("New Bayanaat") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title theme-text-color">{{ translate("All Bayanaat") }}</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate("Title") }}</th>
                                <th>{{ translate("Author") }}</th>
                                <th>{{ translate("Islamic Date") }}</th>
                                <th>{{ translate("English Date") }}</th>
                                <th>{{ translate("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bayan, index) in bayanaat" :key="bayan.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ bayan.title }}</td>
                                <td>{{ bayan.author }}</td>
                                <td>{{ bayan.islamic_date }}</td>
                                <td>{{ bayan.english_date }}</td>
                                <td>
                                    <button class="btn btn-sm" @click="showEntry(bayan.id)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm text-danger" @click="deleteBayan(bayan.id)">
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
                            <h5 v-if="form.id">{{ translate("Edit Bayanaat") }}</h5>
                            <h5 v-else>{{ translate("New Bayanaat") }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input v-model="form.title" placeholder="Title" class="form-control" />
                            <input v-model="form.author" placeholder="Author" class="form-control" />
                            <input v-model="form.islamic_date" placeholder="Islamic Date" class="form-control" />
                            <input v-model="form.english_date" type="date" class="form-control" />
                            
                            <QuillEditor v-model="form.content" theme="snow" />

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
// import { QuillEditor } from "vue3-quill";
import axios from "axios";


export default {
    layout: Master,
    // components: { QuillEditor },
    data() {
        return {
            bayanaat: [],
            form: { id: "", title: "", author: "", islamic_date: "", english_date: "", content: "" }
        };
    },
    created() { this.fetchBayanaat(); },
    methods: {
        fetchBayanaat() { axios.get(route("api.bayanaat.fetch")).then(res => this.bayanaat = res.data); },
        showEntry(id) { axios.get(route("api.bayanaat.show", id)).then(res => this.form = res.data); },
        submit() { axios.post(route("api.bayanaat.store"), this.form).then(() => this.fetchBayanaat()); },
        deleteBayan(id) { axios.delete(route("api.bayanaat.delete", id)).then(() => this.fetchBayanaat()); },
        clearFields() { this.form = { id: "", title: "", author: "", islamic_date: "", english_date: "", content: "" }; }
    }
};
</script>
