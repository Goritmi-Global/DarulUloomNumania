<template>
  <main id="main" class="main">
    <!-- Page Title -->
    <div class="pagetitle d-flex justify-content-between align-items-start mb-3">
      <div>
        <h1 class="theme-text-color mb-1">{{ translate("Class Details") }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link href="/dashboard">{{ translate("Darul Oloom") }}</Link>
            </li>
            <li class="breadcrumb-item">
              <Link href="/classes">{{ translate("Classes") }}</Link>
            </li>
            <li class="breadcrumb-item active">{{ record.class_name }}</li>
          </ol>
        </nav>
      </div>
      <div>
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addSubjectModal"
            @click="clearFields">
            <i class="bi bi-plus-lg"></i> {{ translate("Add Subject") }}
        </button>
      </div>
    </div>

    <section class="section">
      <!-- Summary -->
      <div class="row g-3 mb-4">
        <!-- Class Card -->
        <div class="col-md-4">
          <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
            <div class="summary-header p-3"></div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="icon-circle">
                  <i class="bi bi-journal-bookmark"></i>
                </div>
              </div>
              <div>
                <div class="text-muted small">{{ translate("Class Name") }}</div>
                <div class="fw-semibold">{{ record.class_name }}</div>
                <div class="small text-muted mt-1">
                  {{ translate("Academic Class") }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Metrics -->
        <div class="col-md-8">
          <div class="card border-0 shadow-lg rounded-4 h-100">
            <div class="card-body d-grid metrics-grid">
              <div class="metric-tile">
                <div class="text-muted small">{{ translate("Total Subjects") }}</div>
                <div class="fs-4 fw-bold text-primary">{{ totals.total_subjects }}</div>
              </div>
              
              <div class="metric-tile highlight">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="text-muted small">{{ translate("Total Marks") }}</span>
                </div>
                <div class="subjects-list">
                  <div v-if="subjects.length > 0" class="small">
                    <div v-for="subject in subjects" :key="subject.id" class="subject-item">
                      <span class="subject-name">{{ subject.subject_name }}</span>:
                      <span class="subject-marks text-success fw-semibold">{{ subject.total_marks }}</span>
                    </div>
                  </div>
                  <div v-else class="small text-muted">
                    {{ translate("No subjects added yet") }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Subjects Table -->
      <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title theme-text-color m-0">
              {{ translate("All Subjects for") }} {{ record.class_name }}
            </h5>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>{{ translate("Subject Name") }}</th>
                  <th class="text-end">{{ translate("Total Marks") }}</th>
                  <th>{{ translate("Created Date") }}</th>
                  <th>{{ translate("Action") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(subject, i) in subjects" :key="subject.id">
                  <td class="text-muted">{{ i + 1 }}</td>
                  <td class="fw-semibold">{{ subject.subject_name }}</td>
                  <td class="text-end">
                    <span class="badge bg-success">{{ subject.total_marks }}</span>
                  </td>
                  <td class="text-muted">{{ formatDate(subject.created_at) }}</td>
                  <td>
                    <button class="btn btn-sm text-danger fs-6" title="Delete"
                        @click="deleteSubject(subject.id)">
                        <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
                <tr v-if="!subjects.length">
                  <td colspan="5" class="text-center text-muted py-4">
                    {{ translate("No subjects found") }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Add Subject Modal -->
      <div class="modal fade" id="addSubjectModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-primary">
                {{ translate("Add New Subject") }}
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="card card-body p-3">
                <div class="row g-3">
                  <!-- Subject Name -->
                  <div class="col-12">
                    <label class="form-label">{{ translate("Subject Name") }}</label>
                    <input type="text" v-model="subjectForm.subject_name" class="form-control"
                        :class="{ 'invalid-bg': formErrors.subject_name }" />
                    <div v-if="formErrors.subject_name" class="invalid-feedback">
                        {{ formErrors.subject_name[0] }}
                    </div>
                  </div>
                  <!-- Total Marks -->
                  <div class="col-12">
                    <label class="form-label">{{ translate("Total Marks") }}</label>
                    <input type="number" v-model="subjectForm.total_marks" class="form-control"
                        :class="{ 'invalid-bg': formErrors.total_marks }" min="1" max="1000" />
                    <div v-if="formErrors.total_marks" class="invalid-feedback">
                        {{ formErrors.total_marks[0] }}
                    </div>
                  </div>
                  <!-- Save Button -->
                  <div class="mt-3">
                    <button type="button" class="btn btn-success" @click="submitSubject"
                        v-if="formStatus === 1">
                        {{ translate("Save Subject") }}
                    </button>
                    <button class="btn btn-success" type="button" disabled v-else>
                        {{ translate("Saving") }}
                        <span class="spinner-border spinner-border-sm"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button hidden ref="closeModal" data-bs-toggle="modal" data-bs-target="#addSubjectModal"></button>
      </div>
    </section>
  </main>
</template>

<script>
import Master from "../Layout/Master.vue";
import { Link } from '@inertiajs/vue3';
import axios from "axios";

export default {
  layout: Master,
  name: 'ClassDetails',
  components: { Link },

  props: {
    record: { type: Object, required: true },
    subjects: { type: Array, default: () => [] },
    totals: { type: Object, default: () => ({ total_subjects: 0, total_marks: 0 }) },
  },

  data() {
    return {
      subjectForm: {
        subject_name: "",
        total_marks: "",
        class_id: this.record.id,
      },
      formErrors: [],
      formStatus: 1,
    };
  },

  methods: {
    submitSubject() {
      this.formStatus = 0;
      axios
        .post(route("api.subjects.store"), this.subjectForm)
        .then(() => {
          this.formStatus = 1;
          toastr.success(this.translate("Subject added successfully."));
          this.$refs.closeModal.click();
          // Refresh the page to show new subject
          window.location.reload();
        })
        .catch((err) => {
          this.formStatus = 1;
          this.formErrors = err.response.data.errors || {};
          toastr.error(err.response.data.message);
        });
    },
    
    deleteSubject(id) {
      if (confirm(this.translate("Are you sure you want to delete this subject?"))) {
        axios.delete(route("api.subjects.destroy", id))
          .then(() => {
            toastr.success(this.translate("Subject deleted successfully."));
            // Refresh the page
            window.location.reload();
          })
          .catch((err) => toastr.error(err.response.data.message));
      }
    },

    clearFields() {
      this.subjectForm = {
        subject_name: "",
        total_marks: "",
        class_id: this.record.id,
      };
      this.formErrors = [];
    },

    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString();
    },
  },
};
</script>

<style scoped>
.summary-header{
  background: linear-gradient(90deg, rgba(28,13,130,0.12), rgba(28,13,130,0.02));
  min-height: 18px;
}
.icon-circle{
  width: 40px; height: 40px; border-radius: 50%;
  display: grid; place-items: center;
  background: rgba(28,13,130,0.08);
  color: #1C0D82;
  font-size: 1.1rem;
}

.metrics-grid {
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.metric-tile{
  background: #f8f9fb; 
  border-radius: 18px; 
  padding: 20px 16px; 
  height: 100%; 
  display: flex; 
  flex-direction: column; 
  justify-content: flex-start;
}
.metric-tile.highlight{ 
  background: #f6f9ff; 
  border: 1px dashed rgba(28,13,130,0.25); 
}

.subjects-list {
  flex-grow: 1;
  max-height: 120px;
  overflow-y: auto;
  padding-right: 5px;
}

.subjects-list::-webkit-scrollbar {
  width: 4px;
}

.subjects-list::-webkit-scrollbar-track {
  background: rgba(0,0,0,0.1);
  border-radius: 2px;
}

.subjects-list::-webkit-scrollbar-thumb {
  background: rgba(28,13,130,0.3);
  border-radius: 2px;
}

.subject-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 2px 0;
  border-bottom: 1px solid rgba(0,0,0,0.05);
}

.subject-item:last-child {
  border-bottom: none;
}

.subject-name {
  color: #495057;
  font-weight: 500;
}

.subject-marks {
  font-size: 0.9rem;
}

.name-link:hover {
  text-decoration: none !important;
}
</style>