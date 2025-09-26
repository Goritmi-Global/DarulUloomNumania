<template>
  <main id="main" class="main">
    <div class="pagetitle mt-3">
      <h1>{{ translate('Class Results') }}</h1>
    </div>

    <section class="section">

      <!-- Subjects Summary Card -->
      <div class="card mb-3 mt-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">{{ translate('Subjects & Marks') }}</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center" v-for="sub in subjects"
              :key="sub.id">
              <span>{{ sub.subject_name }}</span>
              <span class="badge bg-primary px-4 py-2">{{ sub.total_marks }}</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Marks Table -->
      <div class="card">
        <div class="card-body">
          <form @submit.prevent="saveResults">
            <h5 class="card-title fw-bold">{{ translate('Subjects Marks') }}</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ translate('Name') }}</th>
                  <th v-for="sub in subjects" :key="sub.id">{{ sub.subject_name }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(s, idx) in students" :key="s.id">
                  <td>{{ idx + 1 }}</td>
                  <td>{{ s.name }}</td>
                  <td v-for="sub in subjects" :key="sub.id">
                    <input type="number" class="form-control" v-model.number="results[s.id][sub.id]" min="0"
                      :max="sub.total_marks" placeholder="Marks" />
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="text-end">
              <button type="submit" class="btn btn-primary mt-3">
                Save Results
              </button>
            </div>

          </form>
        </div>
      </div>

    </section>
  </main>
</template>


<script>
import axios from "axios";
import Master from "../Layout/Master.vue";

export default {
  layout: Master,
  props: {
    classData: Object,
    students: Array,
    subjects: Array,
  },
  data() {
    return {
      results: {}, // { student_id: { subject_id: marks } }
    };
  },
  created() {
    this.students.forEach((s) => {
      this.results[s.id] = {};
      this.subjects.forEach((sub) => {
        this.results[s.id][sub.id] = 0;
      });
    });
  }
  ,
  methods: {
    async saveResults() {
      try {
        const payload = {
          class_id: this.classData.id,
          results: [],
        };

        this.students.forEach((s) => {
          payload.results.push({
            student_id: s.id,
            class_id: this.classData.id,
            marks: this.results[s.id], // already {subject_id: marks}
          });
        });

        const response = await axios.post("/api/results/save", payload);
        alert(response.data.message);

        this.students.forEach((s) => {
          this.results[s.id] = {};
          this.subjects.forEach((sub) => {
            this.results[s.id][sub.id] = 0;
          });
        });
      } catch (error) {
        console.error(error);
        alert("Something went wrong while saving results.");
      }
    }

  },
};
</script>
